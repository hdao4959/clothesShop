@extends('admin.layout')
@section('title')
    Danh sách danh mục
@endsection
@section('content')
    <a class="btn btn-success" href="{{ route('admin.categories.create') }}">Thêm mới</a><br>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</d>
    @endif <br>
    @if (session('success'))
        <div  class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>IS_ACTIVE</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
                <th>ACTION</th>
            </tr>
        </thead>
        

        @foreach ($categories as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{!! $item->is_active ? 
                    '<span class="badge bg-primary">Yes</span>' : 
                    '<span class="badge bg-danger">No</span>' !!}
                </td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    <form action="{{ route('admin.categories.destroy', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        {{-- <a class="btn btn-sm btn-secondary" href="{{ route('admin.categories.show', $item) }}">Detail</a> --}}
                        <a class="btn btn-sm btn-warning" href="{{ route('admin.categories.edit', $item) }}">Edit</a>
                        <button onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $categories->links('pagination::bootstrap-5') }}
@endsection
