<div class="d-flex flex-row sticky-top justify-content-between p-2 shadow-sm" style="background-color: rgb(242, 244, 245);">
        <!-- bar icon -->
        <div class="d-inline-flex align-items-center">
            <button type="button" class="custom-button btn btn-link text-dark mr-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a class="h5 text-primary mb-0 ml-3" style="text-decoration: none;" href="index.php?page=home">GROUP 5</a>
            <!-- <h1 class="h5 text-primary mb-0 ml-3">GROUP 5</h1> -->
        </div>
        <!-- hidden bar -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-primary " id="offcanvasWithBothOptionsLabel">GROUP 5</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Hello everyone :3</p>
            <!-- <div class=" d-grid gap-2"> -->
                <form class="d-grid gap-2 mb-2" action="index.php" method="get">
                    <button class="btn btn-primary" type="submit" id="login_button" name="page" value="login">
                        Login
                    </button>
                </form>
                <form class="d-grid gap-2" action="index.php" method="get">
                    <button class="btn btn-danger" type="submit" id="logout_button" name="page" value="logout">
                        Logout
                    </button>
                </form>
            <!-- </div> -->
        </div>
        </div>
        <!-- hidden bar end -->
        
        <!-- search bar -->
        <form action="index.php" method="get" class="custom-search-bar d-flex align-items-center rounded-pill w-50">
            <span class="fa-solid fa-magnifying-glass ms-2"></span>
            <input
                type="text" name="search_zone" id="search_zone"
                class="custom-tim-kiem border-0 flex-grow-1 rounded-pill"
                placeholder="Tìm kiếm"
            >
        </form>
        <!-- user avatar -->
        <div class="ml-3">
            <!-- random image -->
            <img src="https://storage.googleapis.com/a1aa/image/c6PvQ9PPnRYpm1iDHFMjd2U2SQnj6Of8HK_E7sOi04s.jpg" alt="User avatar" class="rounded-circle" width="40" height="40">
        </div>
    </div>