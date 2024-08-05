@extends('admin.layout')
@section('title')
    Chi tiết đơn hàng
@endsection
@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Thông tin người nhận -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Thông Tin Người Nhận
        </div>
        <div class="card-body">
            <h4 class="card-title">Họ và tên: <span class="text-muted">{{ $order->name }}</span></h4>
            <h5 class="card-subtitle mb-2 text-muted">Số điện thoại: {{ $order->phone_number }}</h5>
            <h5 class="card-subtitle mb-2 text-muted">Email: {{ $order->email }}</h5>
            <h5 class="card-subtitle mb-2 text-muted">Địa chỉ: {{ $order->address }}</h5>
            <h5 class="card-subtitle mb-2 text-muted">Trạng thái đơn hàng: <span class="badge bg-info">{{ $order->status_order }}</span></h5>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Sản Phẩm Trong Đơn Hàng
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Size</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $row = 0;
                    @endphp
                    @foreach ($orderItems as $item)
                        <tr>
                            <td>{{ ++$row }}</td>
                            <td><img src="{{ Storage::url($item->img_thumbnail) }}" class="img-thumbnail" width="100" alt=""></td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->size_name }}</td>
                            <td>
                                <span class="badge bg-success">{{ $item->quantity }}</span>
                            </td>
                            <td>{{ number_format($item->quantity * ($item->price_sale ?? $item->price_regular)) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cập nhật trạng thái đơn hàng -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Cập Nhật Trạng Thái Đơn Hàng
        </div>
        <div class="card-body">
            <form action="{{ route('admin.order.update', $order->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    @php
                        $status_order = [
                            'Chờ xác nhận',
                            'Đã xác nhận',
                            'Đang chuẩn bị hàng',
                            'Đang vận chuyển',
                            'Giao hàng thành công',
                        ];
                    @endphp
                    <label for="status_order" class="form-label">Trạng thái đơn hàng</label>
                    <select class="form-select" name="status_order" id="status_order">
                        @foreach ($status_order as $item)
                        <option value="{{ $item }}" {{ $order->status_order == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{ route('admin.orders') }}">Quay lại</a>
                    <button class="btn btn-warning" type="submit">Cập Nhật Trạng Thái</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
