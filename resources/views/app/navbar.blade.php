<style>
    .custom-img {
        height: 400px;
        object-fit: cover;
        width: 100%;
        position: relative;
    }
    .text-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 36px;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        font-family: "Poppins", sans-serif;
        text-align: center;
    }
    .navbar {
        background-color: #f8b400;
    }
    .navbar-nav .nav-item .nav-link {
        color: #fff;
        font-weight: bold;
        font-family: "Poppins", sans-serif;
    }
    .navbar-nav .nav-item .nav-link.active,
    .navbar-nav .nav-item .nav-link:hover {
        color: #000;
    }
    .navbar .navbar-brand {
        font-size: 24px;
        font-weight: bold;
        color: white;
    }

    .dropdown {
        margin-right: 55px !important; 
    }
     /* CSS untuk mengatur margin dropdown ke kanan */
     .dropdown-menu {
        margin-right: 90px !important; 
    }
</style>

<div class="container-fluid p-0">
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="{{ asset('assets/img/antrian2.jpg') }}" class="d-block w-100 custom-img" alt="Slide 1">
                <div class="text-overlay">
                    <div>Antri dengan Mudah, Cepat, dan Nyaman</div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="{{ asset('assets/img/antrian2.jpg') }}" class="d-block w-100 custom-img" alt="Slide 2">
                <div class="text-overlay">
                    <div>Pemanggilan Antrian Otomatis dan Real-Time</div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">QueueXpress</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    @if(Auth::check() && Auth::user()->role_id == 1) 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('datatiketcustomer') }}">Data Tiket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dataantrianAdmine') }}">Data Antrian</a>
                        </li>
                    @else 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('formTiket') }}">Ambil Tiket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dataAntrian') }}">Data Antrian</a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link" href="{{ route('login') }}" style="margin-left:1650%">LOGIN</a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    @if(Auth::check())
                        <!-- Dropdown Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Role: {{ Auth::user()->role->role_name }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
