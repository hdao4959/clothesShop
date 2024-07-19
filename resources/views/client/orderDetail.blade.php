@extends('client.layout.layout-client')
@section('title')
    Chi tiết đơn hàng
@endsection
@section('content')
    <div class="card mb-4 mt-2">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Thông tin người nhận</h4>
        </div>
        <div class="card-body">
            <p>Họ và tên: <b>{{ $orders->name }}</b></p>
            <p>Địa chỉ nhận hàng: <b>{{ $orders->address }}</b></p>
            <p>Số điện thoại: <b>{{ $orders->phone_number }}</b></p>
            <p>Email: <b>{{ $orders->email }}</b></p>
            <p>Ngày đặt đơn: <b>{{ $orders->created_at->format('d/m/Y H:i') }}</b></p>
            <p>Trang thái đơn hàng: 
                @if ($orders->status_order == "Đã huỷ đơn")
                <b class="text-danger">{{ $orders->status_order  }}</b>
                    @else
                    <b class="text-primary">{{ $orders->status_order  }}</b>
                @endif</p>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card">
        @if (session('success'))
            <span class="text-success">{{ session('success') }}</span>
        @endif
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0 text-center">Sản phẩm</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Hình ảnh</th>
                        <th class="text-center">Tên sản phẩm</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Giá</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Tổng giá</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $row = 0;

                        $totalPrice = 0;
                    @endphp
                    @foreach ($orderItems as $item)
                        <tr>
                            <td class="align-content-center text-center">{{ ++$row }}</td>
                            <td class="align-content-center text-center"><img src="{{ Storage::url($item->img_thumbnail) }}"
                                    width="50px" alt="Image"> </td>
                            <td class="align-content-center text-center">{{ $item->product_name }}</td>
                            <td class="align-content-center text-center">{{ $item->size_name }}</td>
                            <td class="align-content-center text-center">
                                {{ number_format($item->price_sale ?? $item->price_regular) }}đ</td>
                            <td class="align-content-center text-center">{{ $item->quantity }}</td>
                            <td class="align-content-center text-center">
                                {{ number_format($item->quantity * ($item->price_sale ?? $item->price_regular)) }}đ</td>
                            @php
                                $totalPrice += $item->quantity * ($item->price_sale ?? $item->price_regular);
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <h3>Tổng tiền thanh toán: <strong class="text-danger">{{ number_format($totalPrice) }}đ</strong></h3>
            </div>
            <div class="mt-3">
                <a href="{{ route('client.orders') }}" class="btn btn-secondary">Quay lại</a>
                @if ($orders->status_order == "Chờ xác nhận")
                    <form action="{{ route('client.orderCanceled', $orders->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Huỷ đơn</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
