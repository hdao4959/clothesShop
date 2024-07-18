@extends('client.layout.layout-client')
@section('scripts')
    <style>
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: #555;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
@endsection
@section('content')
    <div>
        <h1 class="my-3">Sản phẩm mới</h1>
        <div class="row">
            @foreach ($products as $item)
                <div class="col-md-3">
                    <div class="card mt-2 shadow-sm">
                        <div class="position-relative">
                            @if ($item->is_new)
                            <span class="badge bg-danger position-absolute mt-2">New</span>
                            @endif
                            <img src="{{ filter_var($item->img_thumbnail, FILTER_VALIDATE_URL) ? $item->img_thumbnail : Storage::url($item->img_thumbnail) }}"
                                class="card-img-top" alt="{{ $item->name }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Giá bán thường: {{ $item->price_regular }}</p>
                            <p class="card-text">Giá bán sale: <strong>{{ $item->price_sale }}</strong></p>
                            <div>
                                <a href="{{ route('product.detail', $item->slug) }}" class="btn btn-primary btn-sm">Chi
                                    tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


