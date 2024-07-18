@extends('admin.layout')
@section('title')
    Chi tiết sản phẩm
@endsection
@section('content')
    <div class="container mt-5">

        <div class="row">
            <div class="col-md-6">
                @php
                    $img = Storage::url($product->img_thumbnail);
                    if (Str::contains($product->img_thumbnail, 'http')) {
                        $img = $product->img_thumbnail;
                    }
                @endphp
                <div class="mb-4">
                    <img src="{{ $img }}" alt="" class="img-fluid">
                </div>
                @if ($galleries->toArray() != [])
                <div class="d-flex flex-wrap">
                    
                    @else
                <div class="d-none flex-wrap">
                        
                @endif
                    @foreach ($galleries as $item)
                        <img src="{{ Storage::url($item->image) }}" class="img-thumbnail m-2" style="width: 100px;" alt="">
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
               <div class="d-flex">
               @php
                   if($product->price_sale){
                    $price_regular = '<h2 class="text-muted m-1"><s>'. str_replace(",", ".", number_format($product->price_regular)) . 'đ' . '</s></h2>';
                    $price_sale = '<h2 class="text-danger m-1">' .  str_replace(',', '.',number_format($product->price_sale)) . 'đ'. '</h2>';
                   }else{
                    $price_regular = '<h2 class="text-danger m-1">'. str_replace(",", ".", number_format($product->price_regular)). 'đ' . '</h2>';
                    $price_sale = null;
                   }
               @endphp
                {!! $price_regular !!}
                {!! $price_sale !!}
               </div>

               <div>
                <span>SKU: <b>{{ $product->sku }}</b></span><br>
                <span>Slug: <b>{{ $product->slug }}</b></span>
               </div>
               <div>
                <label for="">Mô tả: </label>
                <span>
                    {{ $product->description }}
                </span>
<br>
                <label for="">Content</label><br>
                <span>
                    {!! $product->content !!}
                </span>
               </div>
                <div class="mt-4">
                    
                    <label for="">Biến thể</label>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @if ($product->variants != [])
                            @foreach ($product->variants as $variant)
                            <tr>
                                <td>{{ $variant->size->name }}</td>
                                <td>{{ $variant->quantity }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td  colspan="2">Không có size</td></tr>
                            @endif
                           
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h3>Tags</h3>
                    
                    <div>
                        @if ($tags->isNotEmpty())
                
                            @foreach ($tags as $tag)
                                <span class="badge bg-info">{{ $tag->name }}</span>
                          @endforeach
                        @else
                        <span>Không có tags</span>
                        @endif
                     
                    </div>
                </div>

                <div>
                <div class="mt-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning" >Sửa</a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>   
        </div>
    </div>


@endsection

