<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.products.';
    const FILE_PATH_THUMBNAIL = 'product_thumbnail';
    const FILE_PATH_GALLERIES = 'product_galleries';
    public function index()
    {
        $products = Product::with('category', 'tags')->latest('id')->paginate(5);
        return view(self::PATH_VIEW . __FUNCTION__, compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $sizes = ProductSize::all();
        $categories = Category::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'sizes', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $request['is_active'] ??= 0;
        $request['is_hot_deal'] ??= 0;
        $request['is_good_deal'] ??= 0;
        $request['is_show_home'] ??= 0;
        $request['is_new'] ??= 0;

        $dataProduct = $request->except('product_variants', 'tags');
        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];
        $dataVariants = $request->product_variants;


        // dd($dataVariants);
        $img_thumbnail = null;


        if ($request->img_thumbnail) {
            $img_thumbnail = Storage::put(self::FILE_PATH_THUMBNAIL, $request->img_thumbnail);
        }

        $dataGalleries = isset($request->galleries) ?  $request->galleries : [];




        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $dataProduct['name'],
                'category_id' => $dataProduct['category_id'],
                'slug' => $dataProduct['slug'],
                'sku' => $dataProduct['sku'],
                'img_thumbnail' => $img_thumbnail,
                'price_regular' => $dataProduct['price_regular'],
                'price_sale' => $dataProduct['price_sale'],
                'description' => $dataProduct['description'],
                'content' => $dataProduct['content'],
                'user_manual' => $dataProduct['user_manual'],

                'is_active' => $request['is_active'],
                'is_hot_deal' => $request['is_hot_deal'],
                'is_good_deal' => $request['is_good_deal'],
                'is_show_home' => $request['is_show_home'],
                'is_new' => $request['is_new'],
            ]);



            foreach ($dataVariants as $size_id => $value) {
                if ($value) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'product_size_id' => $size_id,
                        'quantity' => $value
                    ]);
                } else {
                    continue;
                }
            }

            if ($request->tags) {
                $product->tags()->sync($request->tags);
            }


            foreach ($dataGalleries as $value) {
                if ($imageGallery = Storage::put(self::FILE_PATH_GALLERIES, $value)) {
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $imageGallery
                    ]);
                } else {
                    // Ghi nhật ký lỗi
                    Log::error('Failed to store image for gallery', ['product_id' => $product->id, 'file' => $value]);

                    // Ném ngoại lệ để xử lý lỗi
                    throw new \Exception('Failed to store image for gallery');
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with("success", "Thêm sản phẩm thành công");
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::exists($img_thumbnail)) {
                Storage::delete($img_thumbnail);
            };

            if ($dataGalleries !== []) {
                foreach ($dataGalleries as $key => $img) {
                    if (Storage::exists(self::FILE_PATH_GALLERIES . $img)) {
                        Storage::delete(self::FILE_PATH_GALLERIES . $img);
                    }
                }
            }
            return "Có lỗi" . $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::with('variants.size')->find($product->id);
        $galleries = $product->galleries()->get();
        $tags = $product->tags()->get();
        $variants = $product->variants()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'galleries', 'tags', 'variants'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product = Product::where('id', $product->id)->with('category')->first();
        $tags = Tag::all();
        $product_tags = $product->tags()->pluck('id')->toArray();
        $product_galleries = $product->galleries()->pluck('id', 'product_id');
        $product_variants = $product->variants()->get();
        $sizes = ProductSize::all();
        $categories = Category::all();

        if ($product) {
            return view(self::PATH_VIEW . __FUNCTION__, compact(
                'product',
                'product_tags',
                'tags',
                'product_galleries',
                'product_variants',
                'categories',
                'sizes'
            ));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // dd($request);
        $dataProduct = $request->except('tags', 'product_variants');
        $dataTags = $request->tags;
        $dataGalleries = $request->galleries;
        $dataVariants = $request->product_variants;
        $currentGalleries = $product->galleries->pluck('image', 'id')->toArray();
        $galleries = [];
        $variants = [];
        $dataGalleryImage = [];
        $dataProductUpdate = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price_regular' => $request->price_regular,
            'price_sale' => $request->price_sale,
            'description' => $request->description,
            'content' => $request->content,
            'user_manual' => $request->user_manual,
            'is_active' => $request['is_active'] ?? 0,
            'is_hot_deal' => $request['is_hot_deal'] ?? 0,
            'is_good_deal' => $request['is_good_deal'] ?? 0,
            'is_show_home' => $request['is_show_home'] ?? 0,
            'is_new' => $request['is_new'] ?? 0,
        ];
        if ($request->galleries) {
            foreach ($dataGalleries as $key => $item) {
                $galleries[] = [
                    'id' => $key,
                    'product_id' =>  $dataProduct['id'],
                    'image' => $item
                ];
            }
        }



        try {
            DB::beginTransaction();

            $product->update($dataProductUpdate);

            if ($request->hasFile('img_thumbnail') && Storage::exists($product->img_thumbnail)) {
                $image = Storage::put(self::FILE_PATH_THUMBNAIL, $request->img_thumbnail);
                Storage::delete($product->img_thumbnail);
            }

            if (!empty($galleries)) {
                foreach ($galleries as  $gale) {
                    if (array_key_exists($gale['id'], $currentGalleries)) {
                        $gale['image'] = Storage::put(self::FILE_PATH_GALLERIES, $gale['image']);
                        Storage::delete($currentGalleries[$gale['id']]);
                        ProductGallery::create($gale);
                        $dataGalleryImage[] = $gale['image'];
                    } else {
                        $gale['image'] = Storage::put(self::FILE_PATH_GALLERIES, $gale['image']);
                        ProductGallery::create($gale);
                        $dataGalleryImage[] = $gale['image'];
                    }
                }
            }

            foreach ($dataVariants as $key => $quantity) {
                if ($quantity == 0) {
                    $product->variants()->where('product_size_id', $key)->delete();
                    continue;
                } else {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product->id, 'product_size_id' => $key],
                        ['quantity' => $quantity]
                    );
                }
            }

            // if (!empty($variants)) {
            //     foreach ($variants as $variant) {
            //         if ($variant['quanttiy'])
            //             ProductVariant::updateOrCreate(['product_id' => $product->id, 'product_size_id' => $variant['product_size_id']], $variant);
            //     }
            // }

            $product->tags()->sync($dataTags);
            DB::commit();

            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();

            if (!empty($request->img_thumbnail) && Storage::exists($request->img_thumbnail)) {
                Storage::delete($request->img_thumbnail);
            }

            if (!empty($dataGalleryImage)) {
                foreach ($dataGalleryImage as $image) {
                    if (!empty($image) && Storage::exists($image)) {
                        Storage::delete($image);
                    }
                }
            }
            return "Có lỗi xảy ra " . $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        try {
            DB::transaction(function () use ($product) {
                $galleries = $product->galleries()->get();
                foreach ($galleries as $item) {
                    if (Storage::exists($item->image)) {
                        Storage::delete($item->image);
                    }
                }
                if ($product->tags()->exists()) {
                    $product->tags()->detach();
                }

                if ($galleries->isNotEmpty()) {
                    $product->galleries()->delete();
                }

                if ($product->variants()->exists()) {
                    $product->variants()->delete();
                }
                $product->delete();
            });
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', "Xoá sản phẩm thành công");
        } catch (\Exception $e) {
            DB::rollBack();
            return "Có lỗi xảy ra " . $e->getMessage();
        }
    }
}
