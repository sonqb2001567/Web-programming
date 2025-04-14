<?php
@session_start();

// Kết nối cơ sở dữ liệu
$svname = "localhost:3308";
$user_svname = "root";
$sv_password = "";
$sv_dbname = "MyCVDatabase";

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
    $sql_check = "SELECT * FROM cv WHERE ID = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $cv_id, $_SESSION['user_id']);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $sql = "DELETE FROM cv_content WHERE cv_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cv_id);
        $stmt->execute();

        $sql = "DELETE FROM cv WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cv_id);
        $stmt->execute();
    }
    $stmt_check->close();
}
?>

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - MyCV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Thanh điều hướng -->
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
                    <p>Xin chào, <?php echo htmlspecialchars($_SESSION['user_type'] === 'admin' ? $_SESSION['admin_name'] : $_SESSION['user_name']); ?>!</p>
                    <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
                <?php } else { ?>
                    <p>Xin chào, Khách!</p>
                    <a href="login.php" class="btn btn-primary">Đăng nhập</a>
                <?php } ?>
            </div>
        </div>
        <form action="index.php" method="get" class="custom-search-bar d-flex align-items-center form-control rounded-pill w-50">
            <span class="fa-solid fa-magnifying-glass"></span>
            <input type="text" name="search_zone" class="custom-tim-kiem" placeholder="Tìm kiếm">
            <input type="hidden" name="page" value="home">
        </form>
        <div class="ml-3">
            <img src="https://storage.googleapis.com/a1aa/image/c6PvQ9PPnRYpm1iDHFMjd2U2SQnj6Of8HK_E7sOi04s.jpg" alt="Ảnh đại diện người dùng" class="rounded-circle" width="40" height="40">
        </div>
    </div>

    <header style="background-color: rgb(242, 244, 245);">
        <div class="container">
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user') { ?>
                <section class="mb-5">
                    <br>
                    <h2 class="h6 mt-3">CV của bạn:</h2>
                    <div class="d-flex flex-row row">
                        <?php
                        $sql = "
                            SELECT c.*, t.picture
                            FROM cv c
                            JOIN template t ON c.template_id = t.template_id
                            WHERE c.user_id = ?
                        ";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $_SESSION['user_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();

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
                                    <form action="index.php" method="get">
                                        <button class="custom-button2">
                                            <img src="<?php echo $row['picture'];?>" alt="Ảnh CV" class="img-fluid mb-2 customer-image">
                                            <p class="small"><?php echo htmlspecialchars($row['Name']);?></p>
                                        </button>
                                        <input type="hidden" name="page" value="Formcv">
                                        <input type="hidden" name="cv_id" value="<?php echo $row['ID'];?>">
                                    </form>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p class='text-center'>Bạn chưa có CV nào.</p>";
                        }
                        $stmt->close();
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
                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user') { ?>
                    <form action="index.php" method="get">
                        <button class="btn btn-outline-primary mb-3" id="create_default" name="page" value="submitionForm">Tạo CV mặc định</button>
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
                        SELECT t.*, c.ID as cv_id,
                            (SELECT cc.cv_content_id 
                             FROM cv_content cc 
                             WHERE cc.cv_id = c.ID 
                             AND cc.cv_content_id > 3 
                             LIMIT 1) as priority_cv_content_id,
                            (SELECT cc.cv_content_id 
                             FROM cv_content cc 
                             WHERE cc.cv_id = c.ID 
                             AND cc.cv_content_id <= 3 
                             LIMIT 1) as fallback_cv_content_id
                        FROM template t
                        LEFT JOIN cv c ON c.template_id = t.template_id
                        LIMIT $starter, $skip
                    ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $cv_content_id = $row['priority_cv_content_id'] ?? $row['fallback_cv_content_id'] ?? 0;
                            $template_id = $row['template_id'];
                            ?>
                            <form class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" action="index.php" method="get">
                                <button class="custom-button3" id="<?php echo $template_id;?>">
                                    <div class="card">
                                        <img loading="lazy" src="<?php echo $row['picture'];?>" alt="Ảnh xem trước mẫu" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title small font-weight-bold"><?php echo htmlspecialchars($row['name']);?></h5>
                                            <p class="card-text small text-muted"><?php echo $row['date'];?></p>
                                        </div>
                                    </div>
                                </button>
                                <input type="hidden" name="page" value="Formcv">
                                <input type="hidden" name="cv_content_id" value="<?php echo $cv_content_id;?>">
                                <input type="hidden" name="template_id" value="<?php echo $template_id;?>">
                            </form>
                            <?php
                        }
                    }
                    ?>
                </div>
            </section>

            <div class="ms-3 mb-5" style="position: relative;">
                <section class="d-flex justify-content-center">
                    <h4>Trang: <?php echo $page_number?> / <?php echo $total_pages?> trang</h4>
                </section>
                <section>
                    <div class="d-flex justify-content-center mt-4">
                        <div class="d-flex flex-wrap">
                            <form action="index.php" method="get">
                                <input type="hidden" name="page_number" value="1">
                                <input type="hidden" name="page" value="home">
                                <button type="submit" class="btn btn-primary text-white d-flex align-items-center">
                                    Đầu tiên
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
                                        Trước
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
                                        Trước
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
                                        Tiếp
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
                                            Tiếp
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
                                            Tiếp
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
                                    Cuối cùng
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
                        <button class="btn btn-outline-primary mb-3" id="create_default" name="page" value="submitionForm">Tạo CV mặc định</button>
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
                    $search_term = '%' . $_GET['search_zone'] . '%';
                    $sql = "
                        SELECT t.*, c.ID as cv_id,
                            (SELECT cc.cv_content_id 
                             FROM cv_content cc 
                             WHERE cc.cv_id = c.ID 
                             AND cc.cv_content_id > 3 
                             LIMIT 1) as priority_cv_content_id,
                            (SELECT cc.cv_content_id 
                             FROM cv_content cc 
                             WHERE cc.cv_id = c.ID 
                             AND cc.cv_content_id <= 3 
                             LIMIT 1) as fallback_cv_content_id
                        FROM template t
                        LEFT JOIN cv c ON c.template_id = t.template_id
                        WHERE t.name LIKE ?
                        OR t.date LIKE ?
                    ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $search_term, $search_term);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $cv_content_id = $row['priority_cv_content_id'] ?? $row['fallback_cv_content_id'] ?? 0;
                            $template_id = $row['template_id'];
                            ?>
                            <form class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" action="index.php" method="get">
                                <button class="custom-button3" id="<?php echo $template_id;?>">
                                    <div class="card">
                                        <img loading="lazy" src="<?php echo $row['picture'];?>" alt="Ảnh xem trước mẫu" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title small font-weight-bold"><?php echo htmlspecialchars($row['name']);?></h5>
                                            <p class="card-text small text-muted"><?php echo $row['date'];?></p>
                                        </div>
                                    </div>
                                </button>
                                <input type="hidden" name="page" value="Formcv">
                                <input type="hidden" name="cv_content_id" value="<?php echo $cv_content_id;?>">
                                <input type="hidden" name="template_id" value="<?php echo $template_id;?>">
                            </form>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="text-center">
                            <h2 style="color: red;">Không tìm thấy kết quả</h2>
                            <h2 style="color: red;">Vui lòng thử lại</h2>
                            <img style="width: 200px; height: 200px;" src="https://media1.tenor.com/m/YaJVnr_0CZoAAAAd/anime-sad.gif" alt="Hình ảnh xin lỗi">
                        </div>
                        <?php
                    }
                    $stmt->close();
                    ?>
            </section>
        <?php } ?>
    </main>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="webAction/cvNavigation.js"></script>
</body>
</html>