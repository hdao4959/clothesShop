<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    @php
        $categories = DB::table('categories')->get();
        // dd($categories)
    @endphp
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark-subtle">
            <div class="container ">
                <a class="navbar-brand" href="#">HairClothes</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Trang Chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Danh Mục
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                               
                                @foreach ($categories as $item)
                                <a class="dropdown-item" href="{{ route('showCategory', $item->id) }}">{{ $item->name }}</a>
                                @endforeach
                               
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart') }}">Giỏ Hàng</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tài Khoản</a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>
 
        <article style="min-height:500px">
            @yield('content')
        </article>

        <footer class="bg-dark-subtle mt-2 h-25 align-content-center">
            <h3 class="text-center text-light ">HairClothes</h3>
        </footer>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</html>
