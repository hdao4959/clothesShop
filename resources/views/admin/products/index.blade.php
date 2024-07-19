@extends('admin.layout')
@section('title')
    Danh sách sản phẩm
@endsection
@section('content')
    <a class="btn btn-success" href="{{ route('admin.products.create') }}">Thêm mới</a><br>
    @if (session('error'))
        <div  class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá bán thường</th>
                <th>Giá khuyến mãi</th>
                <th>IS ACTIVE</th>
                {{-- <th>Tags</th> --}}
                <th>Chức năng</th>
            </tr>
        </thead>
        
        
        @foreach ($products as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    @php
                        $img = Storage::url($item->img_thumbnail);
                        if(Str::contains($item->img_thumbnail, 'http')){
                            $img = $item->img_thumbnail;
                        }
                    @endphp
                    <img src="{{ $img }}" width="70" alt="{{ $img }}">
                </td>
                <td>{{ $item->name }}</td>
               <td>{{ $item->category->name }}</td>
                <td>{{ number_format($item->price_regular) }}đ</td>
                <td>{{ number_format($item->price_sale) }}đ</td>
                <td>{!! $item->is_active ? '<span class="badge bg-primary">Yes</span>' :
                "<span class='badge bg-danger'>No</span>"
                 !!}</td>
            
                <td nowrap>
                    <form action="{{ route('admin.products.destroy', $item) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.products.show', $item) }}">Detail</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('admin.products.edit', $item) }}">Edit</a>
                        <button onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $products->links('pagination::bootstrap-5') }}
@endsection
