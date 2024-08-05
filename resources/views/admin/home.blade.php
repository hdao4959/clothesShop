@extends('admin.layout')

@section('title')
    Trang chủ
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tổng đơn hàng</div>
                <div class="card-body">
                    {{-- <h5 class="card-title">{{ $totalOrders }}</h5> --}}
                    <h5 class="card-title">{{ $totalOrderes }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Tổng sản phẩm</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalProducts }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Tổng danh mục</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalCategories }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection