@extends('client.layout.layout-client')
@section('title')
Thông tin người nhận
@endsection

@section('content')
    <h1 class="mb-4 text-center">Thông tin người nhận</h1>
    <div class="">
        <form style="width:600px;margin:0 auto" action="{{ route('add_order') }}" method="POST">
            @csrf
            @if (Auth::check())
                <div class="form-group">
                    <label for="address">Địa chỉ nhận hàng</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ"
                        required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" class="form-control" id="phone" name="phone_number"
                        placeholder="Nhập số điện thoại" required>
                </div>
            @else
                <div class="form-group">
                    <label for="guest_name">Họ và tên</label>
                    <input type="text" class="form-control" id="guest_name" name="guest_name" placeholder="Nhập họ và tên"
                        required>
                </div>
                <div class="form-group">
                    <label for="guest_address">Địa chỉ nhận hàng</label>
                    <input type="text" class="form-control" id="guest_address" name="guest_address" placeholder="Nhập địa chỉ"
                        required>
                </div>
                <div class="form-group">
                    <label for="guest_phone_number">Số điện thoại</label>
                    <input type="tel" class="form-control" id="guest_phone_number" name="guest_phone_number"
                        placeholder="Nhập số điện thoại" required>
                </div>
                <div class="form-group">
                    <label for="guest_email">Email</label>
                    <input type="email" class="form-control" id="guest_email" name="guest_email"
                        placeholder="Nhập địa chỉ email" required>
                </div>
            @endif


            <div class="mt-2">
                <h3>Danh sách sản phẩm</h3>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                
                    @foreach ($cart as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td><img src="{{ Storage::url($product['img_thumbnail']) }}" width="60" alt="">
                            </td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['size']['name'] }}</td>
                            <td>{{ $product['quantity_item'] }}</td>
                            <td>{{ number_format($product['quantity_item'] * $product['price_sale'] ?? $product['price_regular']) }}</td>

                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Thanh toán</button>
                <a href="{{ route('home') }}" type="submit" class="btn btn-secondary">Xem các sản phẩm khác</a>
            </div>
        </form>
    </div>
@endsection
