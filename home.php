<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTL web</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="d-flex flex-row sticky-top justify-content-between p-2 shadow-sm" style="background-color: rgb(242, 244, 245);">
        <!-- bar icon -->
        <div class="d-inline-flex align-items-center">
            <button type="button" class="custom-button btn btn-link text-dark mr-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="h5 text-primary mb-0 ml-3">GROUP 5</h1>
        </div>
        <!-- hidden bar -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">GROUP 5</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Try scrolling the rest of the page to see this option in action.</p>
            <button>testing button</button>
        </div>
        </div>
        <!-- hidden bar end -->
        
        <!-- search bar -->
        <form action="" class="custom-search-bar d-flex align-items-center form-control rounded-pill w-50">
            <span class="fa-solid fa-magnifying-glass"></span>
            <input type="text" class="custom-tim-kiem" placeholder="Tìm kiếm">
        </form>
        <!-- user avatar -->
        <div class="ml-3">
            <!-- random image -->
            <img src="https://storage.googleapis.com/a1aa/image/c6PvQ9PPnRYpm1iDHFMjd2U2SQnj6Of8HK_E7sOi04s.jpg" alt="User avatar" class="rounded-circle" width="40" height="40">
        </div>
    </div>

    <header style="background-color: rgb(242, 244, 245);">
        <!-- bộ currently template của user -->
        <div class="container">
            <section class="mb-5">
                <br>
                <h2 class="h6 mt-3">CV của bạn:</h2>
                <div class="d-flex flex-row row">
                    <!-- box 1 -->
                    <button class="custom-button2 col-6 col-sm-4 col-md-3 col-lg-2 text-center mb-4">
                        <i class="fa-solid fa-plus img-fluid mb-2"></i>
                        <!-- <img src="https://i.pinimg.com/736x/45/68/47/45684748d9a4c9adf6cdd3f958a10d7e.jpg" alt="Tài liệu trống" class="img-fluid mb-2 customer-image"> -->
                        <p class="small">Tạo mới</p>
                    </button>
                    <!-- box 2 -->
                    <button class="custom-button2 col-6 col-sm-4 col-md-3 col-lg-2 text-center mb-4">
                        <img src="https://i.pinimg.com/736x/45/68/47/45684748d9a4c9adf6cdd3f958a10d7e.jpg" alt="CV 1" class="img-fluid mb-2 customer-image">
                        <p class="small">CV 1</p>
                    </button>
                    <!-- box 3 -->
                    <button class="custom-button2 col-6 col-sm-4 col-md-3 col-lg-2 text-center mb-4">
                        <img src="https://i.pinimg.com/736x/ed/1d/6b/ed1d6b44b28df0ac7ae98a4d4b5d2745.jpg" alt="CV 2" class="img-fluid mb-2 customer-image">
                        <p class="small">CV 2</p>
                    </button>
                    <!-- box 4 -->
                    <button class="custom-button2 col-6 col-sm-4 col-md-3 col-lg-2 text-center mb-4">
                        <img src="https://i.pinimg.com/736x/68/d6/4b/68d64b24261cee027fd135bb79dad9cf.jpg" alt="CV 3" class="img-fluid mb-2 customer-image">
                        <p class="small">CV 3</p>
                    </button>
                </div>
            </section>    
        </div>
    </header>
    
    <main class="container mt-4">
        <!-- bộ currently template được admin đăng lên -->
        <section>
            <h2 class="h6 font-weight-bold mb-3">CV mẫu:</h2>
            <div class="d-flex flex-row row">
                <!-- tao moi -->
                <button class="align-items-center justify-content-center custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                    <div>
                        <i class="fa-solid fa-plus img-fluid mb-2"></i>
                        <br>
                        <p class="small">Tạo mới</p>
                    </div>
                </button>
                <!-- template 1 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4" id="template1">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 1</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 2 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 2</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 3 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 3</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 4 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 4</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 5 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 5</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 6 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 6</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 7 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 7</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
                <!-- template 8 -->
                <button class="custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://storage.googleapis.com/a1aa/image/72Xs-wZ71b0V7jIqwHzCjgxosALytrA-AKd7r9fpiHc.jpg" alt="Template preview" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title small font-weight-bold">Template 8</h5>
                            <p class="card-text small text-muted">1 thg 1, 2025</p>
                        </div>
                    </div>
                </button>
            </div>
        </section>
    </main>

    <footer class="p-3" style="background-color: rgb(242, 244, 245);">
        <div class="container">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <p class="small text-muted">© 2025 Group 5</p>
                <div class="d-flex flex-row">
                    <a href="#" class="text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-muted">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="webAction/cvNavigation.js"></script>
</body>
</html>