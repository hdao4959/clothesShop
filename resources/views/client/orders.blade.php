@extends('client.layout.layout-client')
@section('title')
    Đơn hàng
@endsection
@section('content')
    <h1 class="text-center">Đơn hàng của bạn</h1>
    @if (session('success'))
            <div  class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
    <div>
        
        @if ($orders)
            <table class="table">
                <thead>
                   
                    <th>#</th>
                    <th>Mã đơn hàng</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Chức năng</th>
                    </th>
                </thead>
                    @php
                        $total = 0;
                    @endphp
                <tbody>
                    @foreach ($orders as $item)
                        <tr>
                           <td>{{$total += 1 }}</td>
                            <td>{{ $item->order_code }}</td>
                            <td>{{ $item->status_order }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td><a href="{{ route('client.orderDetail', $item) }}" class="btn btn-primary">Chi tiết</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            
            <h2>Không có đơn hàng nào</h2>
        @endif
    </div>

@endsection
