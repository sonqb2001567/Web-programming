<?php
@session_start();


// Kết nối cơ sở dữ liệu (dùng lại từ login.php)
$svname = "localhost:3306";
$user_svname = "root";
$sv_password = "";
$sv_dbname = "mycvdatabase";

$conn = new mysqli($svname, $user_svname, $sv_password, $sv_dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý phân trang
$page_number = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
$items_per_page = 3;
$starter = ($page_number - 1) * $items_per_page;
$skip = $items_per_page;

$sql_count = "SELECT COUNT(*) as total FROM template";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_items = $row_count['total'];
$total_pages = ceil($total_items / $items_per_page);

// Xử lý xóa CV
if (isset($_POST['trash_button'])) {
    $cv_id = $_POST['trash_button'];
    $sql = "DELETE FROM cv_content WHERE cv_id = $cv_id";
    $conn->query($sql);
    $sql = "DELETE FROM cv WHERE ID = $cv_id";
    $conn->query($sql);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTL web</title>
</head>
<body>
    <!-- Thanh điều hướng (giữ nguyên) -->
    <div class="d-flex flex-row sticky-top justify-content-between p-2 shadow-sm" style="background-color: rgb(242, 244, 245);">
        <div class="d-inline-flex align-items-center">
            <button type="button" class="custom-button btn btn-link text-dark mr-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="h5 text-primary mb-0 ml-3">GROUP 5</h1>
        </div>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">GROUP 5</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <?php if (isset($_SESSION['user_type'])) { ?>
                    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_type'] === 'admin' ? $_SESSION['admin_name'] : $_SESSION['user_name']); ?>!</p>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                <?php } else { ?>
                    <p>Welcome, Guest!</p>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php } ?>
            </div>
        </div>
        <form action="index.php" method="get" class="custom-search-bar d-flex align-items-center form-control rounded-pill w-50">
            <span class="fa-solid fa-magnifying-glass"></span>
            <input type="text" name="search_zone" class="custom-tim-kiem" placeholder="Tìm kiếm">
            <input type="hidden" name="page" value="home">
        </form>
        <div class="ml-3">
            <img src="https://storage.googleapis.com/a1aa/image/c6PvQ9PPnRYpm1iDHFMjd2U2SQnj6Of8HK_E7sOi04s.jpg" alt="User avatar" class="rounded-circle" width="40" height="40">
        </div>
    </div>

    <header style="background-color: rgb(242, 244, 245);">
        <div class="container">
            <?php if (isset($_SESSION['user_type'])) { ?>
                <section class="mb-5">
                    <br>
                    <h2 class="h6 mt-3">CV của bạn:</h2>
                    <div class="d-flex flex-row row">
                        <?php
                        $sql = "
                            SELECT *
                            FROM cv c
                            JOIN template t ON c.template_id = t.template_id
                        ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <div class="me-2 col-6 col-sm-4 col-md-3 col-lg-2 text-center mb-4 position-relative">
                                    <form action="index.php" method="POST">
                                        <button class="position-absolute top-0 start-100 translate-middle" 
                                                style="border: none; background-color: transparent;"
                                                id="trash_button" name="trash_button" value="<?php echo $row['ID'];?>">
                                            <i class="fa-solid fa-trash" style="color: red;"></i>
                                        </button>
                                    </form>
                                    <button class="custom-button2">
                                        <img src="<?php echo $row['picture'];?>" alt="a CV" class="img-fluid mb-2 customer-image">
                                        <p class="small"><?php echo $row['Name'];?></p>
                                    </button>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </section>
            <?php } ?>
        </div>
    </header>

    <main class="container mt-4">
        <?php if (!isset($_GET['search_zone']) || $_GET['search_zone'] == "") { ?>
            <section>
                <h2 class="h6 font-weight-bold mb-3">CV mẫu:</h2>
                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') { ?>
                    <form action="index.php" method="get">
                        <button class="btn btn-outline-primary mb-3" id="create_default" name="page" value="submitionForm">Create default</button>
                    </form>
                <?php } ?>

                <div class="d-flex flex-row row">
                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') { ?>
                        <button class="align-items-center justify-content-center custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                            <div>
                                <i class="fa-solid fa-plus img-fluid mb-2"></i>
                                <br>
                                <p class="small">Tạo mới</p>
                            </div>
                        </button>
                    <?php } ?>
                    <?php
                    $sql = "
                        SELECT t.*, c.ID as cv_id, cc.cv_content_id
                        FROM template t
                        LEFT JOIN cv c ON c.template_id = t.template_id
                        LEFT JOIN cv_content cc ON cc.cv_id = c.ID
                        LIMIT $starter, $skip
                    ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Nếu không có cv_content_id, sử dụng giá trị mặc định (ví dụ: 2 cho Template 1)
                            $cv_content_id = $row['cv_content_id'] ?? 2; // Mặc định Template 1 có cv_content_id = 2
                            ?>
                            <form class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" action="index.php" method="get">
                                <button class="custom-button3" id="<?php echo $row['template_id'];?>">
                                    <div class="card">
                                        <img loading="lazy" src="<?php echo $row['picture'];?>" alt="Template preview" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title small font-weight-bold"><?php echo $row['name'];?></h5>
                                            <p class="card-text small text-muted"><?php echo $row['date'];?></p>
                                        </div>
                                    </div>
                                </button>
                                <input type="hidden" name="page" value="Formcv">
                                <input type="hidden" name="cv_content_id" value="<?php echo $cv_content_id;?>">
                            </form>
                            <?php
                        }
                    }
                    ?>
                </div>
            </section>

            <div class="ms-3 mb-5" style="position: relative;">
                <section class="d-flex justify-content-center">
                    <h4>Page: <?php echo $page_number?> of <?php echo $total_pages?> pages</h4>
                </section>
                <section>
                    <div class="d-flex justify-content-center mt-4">
                        <div class="d-flex flex-wrap">
                            <form action="index.php" method="get">
                                <input type="hidden" name="page_number" value="1">
                                <input type="hidden" name="page" value="home">
                                <button type="submit" class="btn btn-primary text-white d-flex align-items-center">
                                    First
                                </button>
                            </form>
                            <?php
                            if(isset($_GET['page_number']) && $_GET['page_number']>1){
                            ?>
                                <form action="index.php" method="get">
                                    <input type="hidden" name="page_number" value="<?php echo $_GET['page_number']-1 ?>">
                                    <input type="hidden" name="page" value="home">
                                    <button type="submit" class="btn btn-primary text-white d-flex align-items-center ms-1 d-none d-md-inline-block">
                                        <i class="fas fa-chevron-left mx-2"></i>
                                        Previous
                                    </button>
                                </form>
                            <?php
                            } else {
                            ?>
                                <form action="index.php" method="get">
                                    <input type="hidden" name="page_number" value="1">
                                    <input type="hidden" name="page" value="home">
                                    <button type="submit" class="btn btn-primary text-white d-flex align-items-center ms-1 d-none d-md-inline-block">
                                        <i class="fas fa-chevron-left mx-2"></i>
                                        Previous
                                    </button>
                                </form>
                            <?php
                            }
                            ?>
                            <div id="pagination" class="btn-group ms-2 me-1" role="group">
                                <?php
                                for($i=1; $i<=$total_pages; $i++){
                                ?>
                                    <form action="index.php" method="get">
                                        <input type="hidden" name="page" value="home">
                                        <input type="hidden" name="page_number" value="<?php echo $i?>">
                                        <button type="submit" class="btn btn-primary text-white me-1"><?php echo $i?></button>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            if(!isset($_GET['page_number'])){
                            ?>
                                <form action="index.php" method="get">
                                    <input type="hidden" name="page_number" value="2">
                                    <input type="hidden" name="page" value="home">
                                    <button type="submit" class="btn btn-primary text-white d-flex align-items-center me-1 d-none d-md-inline-block">
                                        Next
                                        <i class="fas fa-chevron-right mx-2"></i>
                                    </button>
                                </form>
                            <?php
                            } else {
                                if ($_GET['page_number']<$total_pages){
                            ?>
                                    <form action="index.php" method="get">
                                        <input type="hidden" name="page_number" value="<?php echo $_GET['page_number']+1 ?>">
                                        <input type="hidden" name="page" value="home">
                                        <button type="submit" class="btn btn-primary text-white d-flex align-items-center me-1 d-none d-md-inline-block">
                                            Next
                                            <i class="fas fa-chevron-right mx-2"></i>
                                        </button>
                                    </form>
                            <?php
                                } else {
                            ?>
                                    <form action="index.php" method="get">
                                        <input type="hidden" name="page_number" value="<?php echo $total_pages ?>">
                                        <input type="hidden" name="page" value="home">
                                        <button type="submit" class="btn btn-primary text-white d-flex align-items-center me-1 d-none d-md-inline-block">
                                            Next
                                            <i class="fas fa-chevron-right mx-2"></i>
                                        </button>
                                    </form>
                            <?php
                                }
                            }
                            ?>
                            <form action="index.php" method="get">
                                <input type="hidden" name="page_number" value="<?php echo $total_pages?>">
                                <input type="hidden" name="page" value="home">
                                <button type="submit" class="btn btn-primary text-white d-flex align-items-center">
                                    Last
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        <?php } else { ?>
            <section min-height="200vh" class="flex-container mb-5">
                <h2 class="h6 font-weight-bold mb-3">CV mẫu:</h2>
                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') { ?>
                    <form action="index.php" method="get">
                        <button class="btn btn-outline-primary mb-3" id="create_default" name="page" value="submitionForm">Create default</button>
                    </form>
                <?php } ?>

                <div class="d-flex flex-row row">
                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') { ?>
                        <button class="align-items-center justify-content-center custom-button3 col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                            <div>
                                <i class="fa-solid fa-plus img-fluid mb-2"></i>
                                <br>
                                <p class="small">Tạo mới</p>
                            </div>
                        </button>
                    <?php } ?>
                    <?php
                    $sql = "
                        SELECT t.*, c.ID as cv_id, cc.cv_content_id
                        FROM template t
                        LEFT JOIN cv c ON c.template_id = t.template_id
                        LEFT JOIN cv_content cc ON cc.cv_id = c.ID
                        WHERE t.name LIKE '%".$_GET['search_zone']."%'
                        OR t.date LIKE '%".$_GET['search_zone']."%'
                    ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $cv_content_id = $row['cv_content_id'] ?? 2;
                            ?>
                            <form class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" action="index.php" method="get">
                                <button class="custom-button3" id="<?php echo $row['template_id'];?>">
                                    <div class="card">
                                        <img loading="lazy" src="<?php echo $row['picture'];?>" alt="Template preview" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title small font-weight-bold"><?php echo $row['name'];?></h5>
                                            <p class="card-text small text-muted"><?php echo $row['date'];?></p>
                                        </div>
                                    </div>
                                </button>
                                <input type="hidden" name="page" value="Formcv">
                                <input type="hidden" name="cv_content_id" value="<?php echo $cv_content_id;?>">
                            </form>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="text-center">
                            <h2 style="color: red;">Nothing found</h2>
                            <h2 style="color: red;">Please try again</h2>
                            <img style="width: 200px; height: 200px;" src="https://media1.tenor.com/m/YaJVnr_0CZoAAAAd/anime-sad.gif" alt="sorry-image">
                        </div>
                        <?php
                    }
                    ?>
            </section>
        <?php } ?>
    </main>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="webAction/cvNavigation.js"></script>
</body>
</html>