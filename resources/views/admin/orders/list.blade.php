@extends('admin.layout')

@section('content')
    <h1>Danh sách đơn hàng</h1>



    @php
     
    @endphp
    <table class="table">
        <thead>
            <tr>
                <td>ID</td>
                <td>Tên người nhận</td>
                <td>Số đt</td>
                <td>Email</td>
                <td>Địa chỉ</td>
                <td>Trạng thái</td>
                <td>Ngày đặt hàng</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
           @foreach ($orders as $item)
           <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->phone_number }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->address }}</td>
            <td>{{ $item->status_order }}</td>
            <td>{{ $item->created_at }}</td>
            <td>
                <a class="btn btn-sm btn-primary" href="{{ route("admin.order.detail",$item->id) }}">Chi tiết</a>
            </td>
        </tr>
           @endforeach
        </tbody>
    </table>
@endsection