@extends('client.layout.layout-client')
@section('title')
    Chi tiết sản phẩm
@endsection
@section('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endsection
@section('content')
    <h1>Trang chi tiết sản phẩm</h1>
    <div class="row">
        <div class="left d-flex col-md-6  text-center ">
            <img src="{{ filter_var($product->img_thumbnail, FILTER_VALIDATE_URL) ? $product->img_thumbnail : Storage::url($product->img_thumbnail) }}"
                width="450" alt="">

            <div class=" mt-2 justify-content-center">
                @foreach ($galleries as $item)
                    <img class="m-2"
                        src="{{ filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : Storage::url($item['image']) }}"
                        width="70px" alt="">
                @endforeach
            </div>
        </div>
        <div class="right col-md-6">
            <h2 class="text-info">{{ $product->name }}</h2>
            <div class="price d-flex">
                @if ($product->price_sale)
                    <h3 class="text-secondary m-2"><s>{{ $product->price_regular }}đ</s></h3>
                    <h3 class="text-danger m-2">{{ $product->price_sale }}đ</h3>
                @else
                    <h3 class="text-danger m-2">{{ $product->price_regular }}đ</h3>
                @endif
            </div>
            <span>SKU: <b>{{ $product->sku }}</b></span>
            <div>
                <form action="{{ route('handleCart') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                    <div class="d-flex mt-2 mb-2" style="width:100px">
                        <label for="size">Size: </label>

                        @foreach ($product->variants as $item)
                            <input required style="margin-left:10px" type="radio" name="size" id=""
                                value="{{ $item->size->id }}">
                            <b>{{ $item->size->name }}</b>
                        @endforeach
                    </div>
                    <div class="d-flex mt-2 mb-2">
                        <label class="form-label" for="quantity">Số lượng</label>
                        <div style="margin-left:10px"><input type="number" style="width:80px"
                                name="quantity_item" id="" min="1" value="1">
                        </div>
                    </div>


                    <div>
                        <button type="submit" name="action" value="buy_now" class="btn btn-danger">Mua ngay</button>
                        <button type="submit" name="action" value="add_to_cart" class="btn btn-warning">Thêm vào giỏ
                            hàng</button>
                    </div>
                </form>

                <div class="mt-2">
                    <h3>Chi tiết sản phẩm</h3>
                    @if ($product->description)
                        <div>
                            <label for="">Mô tả</label>
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif

                    @if ($product->user_manual)
                        <div>
                            <label for="">Hướng dẫn sử dụng</label>
                            <p>{{ $product->user_manual }}</p>
                        </div>
                    @endif

                    @if ($product->content)
                        <div>
                            <p>{!! $product->content !!}</p>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div>
        <h1 class="text-center">Các sản phẩm khác</h1>
        <div class="row">

            @foreach ($other_products as $item)
                <div class="col-md-3">
                    <div class="card mt-2 shadow-sm">
                        <div class="position-relative">
                            <span class="badge bg-danger position-absolute mt-2">Hot deal</span>
                            <img src="{{ filter_var($item->img_thumbnail, FILTER_VALIDATE_URL) ? $item->img_thumbnail : Storage::url($item->img_thumbnail) }}"
                                class="card-img-top" alt="{{ $item->name }}">
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ Str::limit($item->name, 23) }}</h1>
                            <p class="card-text">Giá: @if ($item->price_sale)
                                    <s class="text-secondary">{{ number_format($item->price_regular) }}đ</s> <strong
                                        class="text-danger">{{ number_format($item->price_sale) }}đ</strong></p>
                        @else
                            <strong class="text-danger">{{ number_format($item->price_regular) }}đ</strong></p>
            @endif
            </p>
            <div>
                <a href="{{ route('product.detail', $item->slug) }}" class="btn btn-primary btn-sm">Chi
                    tiết</a>
            </div>
        </div>
        </div>
        </div>
        @endforeach
        </div>
    </div>
@endsection
