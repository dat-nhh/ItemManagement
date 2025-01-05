<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản lý hàng hóa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
    .nav-link {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sub-menu {
        padding-left: 20px; 
    }

    .caret {
        margin-left: 5px; 
    }
    </style>

    <script>
        function toggleMenus(menu) {
            const allSubMenus = document.querySelectorAll('.sub-menu');

            const subMenu = menu.nextElementSibling;
            const isDisplayed = subMenu.style.display === 'block';

            subMenu.style.display = isDisplayed ? 'none' : 'block';
        }
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 bg-light vh-100 p-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ in_array(request()->path(), ['item', 'item/search']) ? 'active' : '' }}" href="{{ url('/item') }}">Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ in_array(request()->path(), ['warehouse', 'warehouse/search']) ? 'active' : '' }}" href="{{ url('/warehouse') }}">Kho Hàng</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link {{ in_array(request()->path(), ['import', 'export', 'transfer']) ? 'active' : '' }}" onclick="toggleMenus(this)">Giao Dịch <span class="caret"><i class="bi bi-chevron-down"></i></span></span>
                        <ul class="nav flex-column sub-menu" style="display: {{ in_array(request()->path(), ['import', 'export', 'transfer']) ? 'block' : 'none' }};">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('import') ? '' : 'text-secondary' }}" href="{{ url('/import') }}">Nhập kho</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('export') ? '' : 'text-secondary' }}" href="{{ url('/export') }}">Xuất kho</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('transfer') ? '' : 'text-secondary' }}" href="{{ url('/transfer') }}">Chuyển kho</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link {{ in_array(request()->path(), ['vendor', 'customer']) ? 'active' : '' }}" onclick="toggleMenus(this)">Đối tác <span class="caret"><i class="bi bi-chevron-down"></i></span></span>
                        <ul class="nav flex-column sub-menu" style="display: {{ in_array(request()->path(), ['vendor', 'customer']) ? 'block' : 'none' }};">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('vendor') ? '' : 'text-secondary' }}" href="{{ url('/vendor') }}">Nhà cung cấp</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('customer') ? '' : 'text-secondary' }}" href="{{ url('/customer') }}">Khách hàng</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 p-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>