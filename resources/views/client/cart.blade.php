@extends('client.layout.layout-client')


@section('content')
<h1 class="mb-4">Giỏ hàng</h1>
<div>
    @if (session('cart'))
    @php
        $cart = session('cart');
        $row_number = 0;
    @endphp
    <div class="table-responsive">
    @if (session('success'))
    <span class="text-green">{{ session('success') }}</span>
    @endif
        <table class="table table-hover ">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    
              
                @php
                    $total = 0;
                @endphp
                @foreach ($cart  as $key => $item)
                    <tr >
                        @php
                            $total += $item['price_sale'] ?? $item['price_regular']
                        @endphp
                        <td class="align-middle">{{ $row_number + 1 }}</td>
                        <td class="align-middle"><img src="{{ filter_var($item['img_thumbnail'], FILTER_VALIDATE_URL) ? $item['img_thumbnail'] : Storage::url($item['img_thumbnail']) }}" width="50" alt=""></td>
                        <td class="align-middle">{{ $item['name'] }}</td>
                        <td class="align-middle">{{  $item['size']['name'] }}</td>
                        <td class="align-middle">
                            <input class="form-control" type="number" name="quantity[]" value="{{ $item['quantity_item']}}" min="1">
                        </td>
                        <td class="align-middle">{{ number_format($item['price_sale'] ?? $item['price_regular'], 0, ',', '.') }}₫</td>
                        <td class="align-middle">
                            <form action="{{ route('cart.remove', ['id' => $key]) }}" method="POST" id="form_delete_{{ $key }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tổng giá trị giỏ hàng</h5>
                    <p class="card-text">{{ number_format($total, 0, ',', '.') }}₫</p>
                    <a href="{{ route('form_order') }}" class="btn btn-success btn-block">Đặt hàng</a>
                    <a href="{{ route("home") }}" class="btn btn-secondary btn-block">Xem các sản phẩm khác</a>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<h4>Không có sản phẩm nào trong giỏ hàng</h4>
<a href="{{ route('home') }}" class="btn btn-secondary">Quay lại trang chủ</a>
@endif

@endsection
