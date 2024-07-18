@extends('admin.layout')
@section('styles_lib')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection
@section('title')
    Thêm mới sản phẩm
@endsection
@section('content')
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="d-flex">
            <div class="left col-md-5">
                <div class="mt-2">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên sản phẩm" required>
                </div>

                <input type="text" class="form-control" id="sku" name="sku" value="{{ Str::random(8) }}" hidden>



                <div class="mt-2">
                    <label for="name">Danh mục sản phẩm</label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="">--Danh mục sản phẩm--</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <label for="img_thumbnail">Ảnh thumbnail</label>
                    <input type="file" class="form-control" id="img_thumbnail" name="img_thumbnail" required>
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
                            <tr>
                                <td>1</td>
                                <td><input type="file" name="galleries[1]" class="form-control"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>


                <div class="mt-2">
                    <label for="price_regular">Giá bán</label>
                    <input type="number" class="form-control" id="price_regular" name="price_regular" required placeholder="Nhập giá bán">
                </div>
                <div class="mt-2">
                    <label for="price_sale">Giá sale</label>
                    <input type="number" class="form-control" id="price_sale" name="price_sale" placeholder="Nhập giá sale">
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
                        <tbody>
                            @foreach ($sizes as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td><input type="number" value="0" name="product_variants[{{ $item->id }}]"
                                            class="form-control"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

              
            </div>

            <div class="right col-md-5 m-4">
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
                                value="1" checked>
                            <label class="form-check-label" for="mySwitch">{{ $value }}</label>
                        </div>
                    @endforeach

                </div>

               
                <div>
                    <label for="description">Mô tả</label><br>

                    <textarea name="description" id="description" cols="70" rows="3" placeholder="Mô tả chi tiết sản phẩm"></textarea>
                </div>
                <div>
                    <label for="content">Nội dung</label><br>
                    <textarea name="content"></textarea>
                </div>
                <div>
                    <label for="user_manual">Hướng dẫn sử dụng</label><br>
                    <textarea name="user_manual" id="user_manual" cols="70" rows="5" placeholder="Nội dung"></textarea>
                </div>

                <div class="mt-2">
                    <label for="tags">Tags</label>
                    <select class="form-select" name="tags[]" multiple>
                        @foreach ($tags as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-success">Thêm</button>
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
