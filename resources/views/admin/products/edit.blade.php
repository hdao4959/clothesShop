@extends('admin.layout')
@section('styles_lib')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection
@section('title')
    Chỉnh sửa sản phẩm
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="d-flex">
            <div class="left col-md-5">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="mt-2">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name') ? old('name') : $product->name }}">
                </div>

                <div class="mt-2">
                    <label for="name">Danh mục sản phẩm</label>
                    <select class="form-control" name="category_id" id="category_id">
                        @foreach ($categories as $cate)
                            <option value="{{ $cate->id }}" @if ( old('category_id') == $cate->id ?? (isset($product->category) && $product->category->id == $cate->id)) selected @endif>
                                {{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2 shadow">
                    <label class="form-label" for="img_thumbnail">Ảnh thumbnail</label>
                    <input type="file" class="form-control" id="img_thumbnail" name="img_thumbnail">
                    <div class="text-center mt-2">
                        <img class="" src="{{ Storage::url($product->img_thumbnail) }}" width="300" alt="">
                    </div>
                </div>

                <div class="mt-2">
                    <label for="img_thumbnail">Ảnh liên quan</label>


                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hình ảnh</th>
                                <th><a class="btn btn-sm btn-primary" id="addRow">Thêm</a></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($product->galleries as $gale)
                                <tr>
                                    <td>1</td>
                                    <td><input type="file" name="galleries[{{ $gale->id }}]" class="form-control">
                                    </td>
                                    <td><img src="{{ Storage::url($gale->image) }}" width="50"
                                            alt="{{ Storage::url($gale->image) }}"></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>


                <div class="mt-2">
                    <label for="price_regular">Giá bán</label>
                    <input type="number" class="form-control" id="price_regular" name="price_regular"
                        value="{{ old('price_regular', $product->price_regular) }}">
                </div>
                <div class="mt-2">
                    <label for="price_sale">Giá sale</label>
                    <input type="number" class="form-control" id="price_sale" name="price_sale"
                        value="{{ old('price_sale', $product->price_sale) }}">
                </div>

                <div class="mt-2">
                    <label>Biến thể</label>
                    <table class="table">
                        <thead class="table">
                            <tr>
                                <th>Size</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                           @php
                               
                               @dd($product->with('variants')->get());
                           @endphp --}}
                        @foreach ($sizes as $size)
                            @php
                                $variant = $product_variants->firstWhere('product_size_id', $size->id);
                            @endphp
                            <tr>
                                <td>{{ $size->name }}</td>
                                <td><input type="number" name="product_variants[{{ $size->id }}]"
                                        value="{{ old('product_variants.' . $size->id, $variant->quantity ?? 0) }}"
                                        class="form-control"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>

            <div class="right col-md-5 " style="margin-left:40px">
                <div class="d-flex">

                    @php
                        $column = [
                            'is_active' => 'Active',
                            'is_hot_deal' => 'Hot deal',
                            'is_good_deal' => 'Good deal',
                            'is_show_home' => 'Show home',
                            'is_new' => 'Is new',
                        ];
                    @endphp

                    @foreach ($column as $key => $value)
                        <div class="form-check form-switch col-md-3">
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="{{ $key }}"
                                value="1" @checked($product[$key] != 0 || old($key) == 1)>
                            <label class="form-check-label" for="mySwitch">{{ $value }}</label>
                        </div>
                    @endforeach

                </div>


                <div>
                    <label for="description">Mô tả</label><br>

                    <textarea name="description" id="description" cols="70" rows="3" placeholder="Mô tả chi tiết sản phẩm">{{ old('description', $product->description) }}</textarea>
                </div>
                <div>
                    <label for="content">Nội dung</label><br>
                    <textarea name="content">{{ old('content', $product->content )}}</textarea>
                </div>
                <div>
                    <label for="user_manual">Hướng dẫn sử dụng</label><br>
                    <textarea name="user_manual" id="user_manual" cols="70" rows="5" placeholder="Nội dung">{{ old('user_manual', $product->user_manual) }}</textarea>
                </div>

                <div class="mt-2">
                    <label for="tags">Tags</label>
                    <select class="form-select" name="tags[]" multiple>
                        @foreach ($tags as $tag)
                            <option @selected( old('tags')? in_array($tag->id, old('tags')) : in_array($tag->id, $product_tags)) value="{{ $tag->id }}">{{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mt-2">
                    <button type="submit" class="btn btn-warning">Sửa</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </div>


    </form>




    <script></script>
@endsection


@section('scripts_lib')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
@endsection
@section('scripts')
    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            var tableBody = document.getElementById('tableBody');

            var newRow = document.createElement('tr');

            var rowCount = tableBody.getElementsByTagName('tr').length + 1;

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="file" name="galleries[${rowCount}]" class="form-control"></td>
                <td><i class="fa-solid fa-trash-can" onclick="deleteRow(this)"></i></td>
            `;

            tableBody.appendChild(newRow);
        });

        function deleteRow(button) {
            var row = button.closest('tr');
            row.remove();

            // Cập nhật lại số thứ tự của các hàng sau khi xóa
            var tableBody = document.getElementById('tableBody');
            var rows = tableBody.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                rows[i].getElementsByTagName('td')[0].innerText = i + 1;
            }
        }


        CKEDITOR.replace('content');
        CKEDITOR.on('instanceReady', function(evt) {
            var editor = evt.editor;

            editor.on('change', function(e) {
                var contentSpace = editor.ui.space('contents');
                var ckeditorFrameCollection = contentSpace.$.getElementsByTagName('iframe');
                var ckeditorFrame = ckeditorFrameCollection[0];
                var innerDoc = ckeditorFrame.contentDocument;
                var innerDocTextAreaHeight = $(innerDoc.body).height();
                console.log(innerDocTextAreaHeight);
            });
        });
    </script>
@endsection
