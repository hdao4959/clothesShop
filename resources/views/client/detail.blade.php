@extends('client.layout.layout-client')

@section('content')
    <h1>Trang chi tiết sản phẩm</h1>
    <div class="row">
        <div class="left d-flex col-md-5  text-center ">
            <img src="{{ filter_var($product->img_thumbnail, FILTER_VALIDATE_URL) ? $product->img_thumbnail : Storage::url($product->img_thumbnail) }}"
                width="350" alt="">

            <div class=" mt-2 justify-content-center">
                @foreach ($galleries as $item)
                    <img class="m-2"
                        src="{{ filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : Storage::url($item['image']) }}"
                        width="70px" alt="">
                @endforeach
            </div>
        </div>
        <div class="right col-md-7">
            <h1>{{ $product->name }}</h1>
            <div class="price d-flex">
                <h3 class="text-secondary m-2"><s>{{ $product->price_regular }}đ</s></h3>
                <h3 class="text-danger m-2">{{ $product->price_sale }}đ</h3>
            </div>
            <span>SKU: <b>{{ $product->sku }}</b></span>
            <div>
                {{-- <div class="d-flex mt-2 mb-2" style="width:100px">
                    <select name="" class="form-control" id="">
                        <option value="">--Size--</option>
                        @foreach ($product->variants as $item)
                            <option>{{ $item->size->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <form action="{{ route("addCart") }}" method="post">
                    @csrf
                <input type="hidden" value="{{ $product->id }}" name="product_id">
                <div class="d-flex mt-2 mb-2" style="width:100px">
                    <label for="size">Size: </label>
                    @foreach ($product->variants as $item)
                        <input required  style="margin-left:10px" type="radio" name="size"
                            id="" value="{{ $item->size->id }}">
                        {{ $item->size->name }}
                    @endforeach
                </div>
                <div class="d-flex mt-2 mb-2"> 
                    <label class="form-label" for="quantity">Số lượng</label>
                    <div style="width:100px;margin-left:10px"><input class="form-control" type="number" name="quantity_item" id="" min="1" value="1">
                    </div>
                </div>


                <div>
                    {{-- <button type="" class="btn btn-danger">Mua ngay</button> --}}
                    <button type="submit" class="btn btn-warning">Thêm vào giỏ hàng</button>
                </div>
            </form>
                <div>
                    <label for="">Description</label>
                    <p>{{ $product->description }}</p>
                </div>
                <div>

                    <p>{!! $product->content !!}</p>
                </div>
                <div>
                    <label for="">Hướng dẫn sử dụng</label>
                    <p>{{ $product->user_manual }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
