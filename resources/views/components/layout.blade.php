<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="py-3 mb-4 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">STATIZEN</span>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                        {{ request()->is('/') ? 'aria-current="page"' : '' }}>Dashboard</a></li>
                <li class="nav-item"><a href="/keluarga"
                        class="nav-link {{ request()->is('keluarga*') ? 'active' : '' }}"
                        {{ request()->is('keluarga*') ? 'aria-current="page"' : '' }}>Data Warga</a></li>
                <li class="nav-item"><a href="/bantuan" class="nav-link {{ request()->is('bantuan') ? 'active' : '' }}"
                        {{ request()->is('blt*') ? 'aria-current="page"' : '' }}>Bantuan</a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex mx-2">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="container flex-grow-1">
        {{ $slot }}
    </main>
    <footer>
        <div class="card text-bg-primary text-center mb-4 shadow">
            <div class="card-body p-5">
                <h6 class="card-subtitle mb-2">KONTAK</h6>
                <h2 class="card-title display-5">HUBUNGI KAMI</h2>
                <div class="row mt-4">

                    <div class="col-md-6 mb-3 mb-md-0 d-flex flex-row justify-content-center align-items-center gap-2">
                        <svg width="30" height="30" viewBox="0 0 67 67" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d=" M56.6666 9.70018C53.6102 6.61386 49.9701 4.16673 45.9583 2.50139C41.9466 0.836041
                37.6436 -0.0142106 33.3 0.00017965C15.1 0.00017965 0.266667 14.8335 0.266667 33.0335C0.266667 38.8668
                1.8 44.5335 4.66667 49.5335L0 66.6668L17.5 62.0668C22.3333 64.7002 27.7667 66.1002 33.3 66.1002C51.5
                66.1002 66.3333 51.2668 66.3333 33.0668C66.3333 24.2335 62.9 15.9335 56.6666 9.70018ZM33.3
                60.5002C28.3667 60.5002 23.5333 59.1668 19.3 56.6668L18.3 56.0668L7.9 58.8002L10.6667 48.6668L10
                47.6335C7.25849 43.257 5.80308 38.1978 5.8 33.0335C5.8 17.9002 18.1333 5.56685 33.2667 5.56685C40.6
                5.56685 47.5 8.43351 52.6666 13.6335C55.2254 16.1797 57.253 19.2087 58.6321 22.5446C60.0111 25.8806
                60.714 29.4571 60.7 33.0668C60.7666 48.2002 48.4333 60.5002 33.3 60.5002ZM48.3666 39.9668C47.5333
                39.5668 43.4666 37.5668 42.7333 37.2668C41.9666 37.0002 41.4333 36.8668 40.8667 37.6668C40.3 38.5002
                38.7333 40.3668 38.2667 40.9002C37.8 41.4668 37.3 41.5335 36.4667 41.1002C35.6333 40.7002 32.9667
                39.8002 29.8333 37.0002C27.3667 34.8002 25.7333 32.1002 25.2333 31.2668C24.7667 30.4335 25.1667 30.0002
                25.6 29.5668C25.9667 29.2002 26.4333 28.6002 26.8333 28.1335C27.2333 27.6668 27.4 27.3002 27.6667
                26.7668C27.9333 26.2002 27.8 25.7335 27.6 25.3335C27.4 24.9335 25.7333 20.8668 25.0667 19.2002C24.4
                17.6002 23.7 17.8002 23.2 17.7668H21.6C21.0333 17.7668 20.1667 17.9668 19.4 18.8002C18.6667 19.6335
                16.5333 21.6335 16.5333 25.7002C16.5333 29.7668 19.5 33.7002 19.9 34.2335C20.3 34.8002 25.7333 43.1335
                34 46.7002C35.9667 47.5668 37.5 48.0668 38.7 48.4335C40.6666 49.0668 42.4667 48.9668 43.9 48.7668C45.5
                48.5335 48.8 46.7668 49.4666 44.8335C50.1666 42.9002 50.1666 41.2668 49.9333 40.9002C49.7 40.5335 49.2
                40.3668 48.3666 39.9668Z" fill="white" />
                        </svg>
                        <h4>080000000000</h4>
                    </div>

                    <div class="col-md-6 d-flex flex-row justify-content-center align-items-center gap-2">
                        <svg width="30" height="30" viewBox="0 0 67 54" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M60 0H6.66667C3 0 0.0333333 3 0.0333333 6.66667L0 46.6667C0 50.3333 3 53.3333 6.66667 53.3333H60C63.6667 53.3333 66.6667 50.3333 66.6667 46.6667V6.66667C66.6667 3 63.6667 0 60 0ZM60 13.3333L33.3333 30L6.66667 13.3333V6.66667L33.3333 23.3333L60 6.66667V13.3333Z"
                                fill="white" />
                        </svg>
                        <h4>email@gmail.com</h4>
                    </div>

                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    @stack('scripts')
</body>

</html>
