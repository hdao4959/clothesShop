@extends('admin.layout')
@section('title')
Chỉnh sửa danh mục
@endsection
@section('content')

    <form action="{{ route('admin.categories.update', $category) }}" method="post">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" value="{{ $category->name }}" name="name">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1"
            @if ($category->is_active == 1)
            @checked(true)
            @endif name="is_active" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
              Is active
            </label>
          </div>
       <div class="mt-2">
        <button type="submit" class="btn btn-warning">Sửa</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
       </div>
    </form>
@endsection