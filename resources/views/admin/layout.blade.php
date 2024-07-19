<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
      @yield('styles_lib')
  </head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            {{-- <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> --}}
            Bootstrap
          </a>
          <div class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        </div>
      </nav>
    <div class="content">

          <div class="d-flex">
            <div class="left" style="width:200px;min-height:calc(100vh - 100px)" >
                <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ route('admin.home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.categories.index') }}">Danh mục</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{  route('admin.products.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{  route('admin.orders') }}">Đơn hàng</a>
                    </li>
                    
                    {{-- <li class="nav-item">
                      <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li> --}}
                    
                  </ul>
            </div>
            <div class="right" style="width:calc(100% - 200px)">
                <article>
                    <h1>@yield('title')</h1>
                    @yield('content')
                </article>
            </div>
          </div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            {{-- <div class="container-fluid">
            
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">Trang chủ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">Danh mục</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">Giảng viên</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">Môn học</a>
                  </li>
                
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
                <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
              </div>
            </div> --}}
          </nav>

       
      

       
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts_lib')
@yield('scripts')
</html>