@extends('admin.layout')
@section('title')
Thêm mới danh mục
@endsection
@section('content')

    <form action="{{  route('admin.categories.store') }}" method="post">
        @csrf
        <div>
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
              Is active
            </label>
          </div>

       <div class="mt-2">
        <button class="btn btn-success">Thêm</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
       </div>
    </form>
@endsection
