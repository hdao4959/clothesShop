@extends('admin.layout')

@section('content')
    <h1>Chi tiết đơn hàng</h1>

    <div class="text-center">

        <h4>Họ và tên: {{ $order->name }}</h4>
        <h4>Số điện thoại: {{ $order->phone_number }}</h4>
        <h4>Email: {{ $order->email }}</h4>
        <h4>Địa chỉ: {{ $order->address }}</h4>
        <h4>Trạng thái đơn hàng: {{ $order->status_order }}</h4>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            @php
                $row = 0;
            @endphp
            @foreach ($orderItems as $item)
                <tr>
                    <td>{{ $row + 1 }}</td>
                    <td><img src="{{ Storage::url($item->img_thumbnail) }}" width="50px" alt=""></td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->size_name }}</td>
                    <td>
                        <div class="badge bg-success">{{ $item->quantity }}</div>
                    </td>
                    <td>{{ number_format($item->quantity * $item->price_sale ?: $item->price_regular) }}đ</td>

                </tr>
            @endforeach
        </table>
    </div>
    <form action="{{ route('admin.order.update', $order->id) }}" method="post">
        <div class="mt-2 mb-2">

            @php
                $status_order = [
                    'Chờ xác nhận',
                    'Đã xác nhận',
                    'Đang chuẩn bị hàng',
                    'Đang vận chuyển',
                    'Giao hàng thành công',
                    'Đã huỷ đơn',
                ];
            @endphp
            <span>Trạng thái đơn hàng</span>

            <select class="form-control" name="status_order" id="">
                @foreach ($status_order as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <a class="btn btn-secondary" href="{{ route('admin.orders') }}">Quay lại</a>
            <button class="btn btn-warning" type="submit">Cập nhật trạng thái</button>
        </div>
    </form>
@endsection
