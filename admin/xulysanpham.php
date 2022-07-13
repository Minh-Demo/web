<?php
session_start();
if (!isset($_SESSION['dangnhap'])) {
    header('Location:index.php');
}
// đăng xuất
if (isset($_GET['login'])) {
    $dangxuat = $_GET['login'];
} else {
    $dangxuat = '';
}
if ($dangxuat == 'dangxuat') {
    session_destroy();
    header('Location:index.php');
}
?>
<?php
include('../db/connect.php');
?>
<?php
// thêm sản phẩm
if (isset($_POST['themsanpham'])) {
    $tensanpham = $_POST['tensanpham'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $soluong = $_POST['soluong'];
    $gianhap = $_POST['gianhap'];
    $gia = $_POST['giasanpham'];
    $giakhuyenmai = $_POST['giakhuyenmai'];
    $danhmuc = $_POST['danhmuc'];
    $thuonghieu = $_POST['brands'];
    $chitiet = $_POST['chitiet'];
    $mota = $_POST['mota'];
    $thongso = $_POST['thongso'];
    // tạo đường dẫn ra folder uploads
    $path = '../uploads/';
    $sql_insert_sanpham = mysqli_query($con, "INSERT INTO tbl_sanpham(brand_id,sanpham_name,sanpham_chitiet,sanpham_mota,sanpham_thongso,sanpham_gianhap,sanpham_gia,sanpham_giakhuyenmai,sanpham_soluong,sanpham_image,category_id) 
                values ('$thuonghieu','$tensanpham','$chitiet','$mota','$thongso',$gianhap,'$gia','$giakhuyenmai','$soluong','$hinhanh','$danhmuc')");
    move_uploaded_file($hinhanh_tmp, $path . $hinhanh);
}
// cập nhật
elseif (isset($_POST['capnhatsanpham'])) {
    $id_update = $_GET['capnhat_id'];
    $tensanpham = $_POST['tensanpham'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $soluong = $_POST['soluong'];
    $gianhap = $_POST['gianhap'];
    $gia = $_POST['giasanpham'];
    $giakhuyenmai = $_POST['giakhuyenmai'];
    $danhmuc = $_POST['danhmuc'];
    $thuonghieu = $_POST['thuonghieu'];
    $chitiet = $_POST['chitiet'];
    $mota = $_POST['mota'];
    $thongso = $_POST['thongso'];
    // tạo đường dẫn ra folder uploads
    $path = '../uploads/';
    // kiểm tra có chọn ảnh không
    if (!$hinhanh) {
        $sql_update_img = "UPDATE tbl_sanpham SET sanpham_name='$tensanpham',sanpham_chitiet='$chitiet',sanpham_mota='$mota',sanpham_thongso='$thongso',sanpham_gianhap='$gianhap',
                    sanpham_gia='$gia',sanpham_giakhuyenmai='$giakhuyenmai',sanpham_soluong='$soluong',category_id='$danhmuc',brand_id='$thuonghieu' WHERE sanpham_id = '$id_update'";
    } else {
        move_uploaded_file($hinhanh_tmp, $path . $hinhanh);
        $sql_update_img = "UPDATE tbl_sanpham SET sanpham_name='$tensanpham',sanpham_chitiet='$chitiet',sanpham_mota='$mota',sanpham_thongso='$thongso',
                                sanpham_gianhap='$gianhap',sanpham_gia='$gia',sanpham_giakhuyenmai='$giakhuyenmai',sanpham_soluong='$soluong',sanpham_image='$hinhanh',
                                category_id='$danhmuc',brand_id='$thuonghieu' WHERE sanpham_id = '$id_update'";
    }
    mysqli_query($con, $sql_update_img);
    header("Location:xulysanpham.php");
}
// xóa sản phẩm
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $sql_delete = mysqli_query($con, "DELETE FROM tbl_sanpham WHERE sanpham_id='$id'");
    header("Location:xulysanpham.php");
}

?>

<!-- <?php
if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = '';
}
if ($page == '' || $page == 1) {
    $begin = 0;
} else {
    $begin = ($page * 10) - 10;
}

?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm </title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
    <h4 style="text-align:center;">Xin chào <?php echo $_SESSION['dangnhap'] ?> <a href="?login=dangxuat">Đăng xuất</a></h4>
    <!-- navbar  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="collapse navbar-collapse" id="navbarNav" style="background-color: #99CCCC;">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">DashBoard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="xulydonhang.php">Đơn hàng <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulydanhmuc.php">Danh mục sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulydanhmucbaiviet.php">Danh mục bài viết</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulybaiviet.php">Tin tức</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulykhachhang.php">Khách hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulykho.php">Kho hàng</a>
                </li>
            </ul>
        </div>
    </nav><br><br>
    <!-- /navbar -->
    <div class="container">
        <div class="row">
            <!-- cập nhật sản phẩm -->
            <?php
            if (isset($_GET['quanly']) == 'capnhat') {
                $id_capnhat = $_GET['capnhat_id'];
                $sql_capnhat = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_id = '$id_capnhat'");
                $row_capnhat = mysqli_fetch_array($sql_capnhat);
                $id_category_1 = $row_capnhat['category_id'];
                $id_brands_1 = $row_capnhat['brand_id'];
            ?>
                <div class="col-md-4">
                    <h4 style="text-align: center;">Cập nhật sản phẩm </h4>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- lấy dữ liệu từ csđl đổ ra form -->
                        <!-- tên -->
                        <label>Tên sản phẩm</label>
                        <input type="text" class="form-control" name="tensanpham" value="<?php echo $row_capnhat['sanpham_name'] ?>" required=""><br>
                        <!-- hình ảnh -->
                        <label>Hình ảnh</label>
                        <input type="file" class="form-control" name="hinhanh" required="">
                        <img src="../uploads/<?php echo $row_capnhat['sanpham_image'] ?>" height="80" width="80"><br>
                        <!-- giá -->
                        <label>Giá nhập</label>
                        <input type="text" class="form-control" name="gianhap" value="<?php echo $row_capnhat['sanpham_gianhap'] ?>" required=""><br>
                        <label>Giá</label>
                        <input type="text" class="form-control" name="giasanpham" value="<?php echo $row_capnhat['sanpham_gia'] ?>" required=""><br>
                        <!-- giá km -->
                        <label>Giá khuyến mãi</label>
                        <input type="text" class="form-control" name="giakhuyenmai" value="<?php echo $row_capnhat['sanpham_giakhuyenmai'] ?>" required=""><br>
                        <!-- giá km -->
                        <label>Số lượng</label>
                        <input type="number" min="1" class="form-control" name="soluong" value="<?php echo $row_capnhat['sanpham_soluong'] ?>" required=""><br>
                        <!-- mô tả -->
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="10" name="mota" required=""><?php echo $row_capnhat['sanpham_mota'] ?></textarea><br>
                        <!-- chi tiết -->
                        <label>Chi tiết</label>
                        <textarea class="form-control" rows="10" name="chitiet" required=""><?php echo $row_capnhat['sanpham_chitiet'] ?></textarea><br>
                        <!-- thông số kỹ thuật -->
                        <label>Thông số kỹ thuật</label>
                        <textarea class="form-control" rows="10" name="thongso" required=""><?php echo $row_capnhat['sanpham_thongso'] ?></textarea><br>
                        <!-- lấy danh mục từ csdl -->
                        <?php
                        $sql_danhmuc = mysqli_query($con, "SELECT * FROM tbl_category ORDER BY category_id DESC");
                        ?>
                        <label>Danh mục</label>
                        <select class="form-control" name="danhmuc">
                            <option value="0">---Chọn danh mục sản phẩm---</option>
                            <?php
                            while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) {
                                // so sánh category_id lấy từ tblsanpham vs tbl_category
                                if ($id_category_1 == $row_danhmuc['category_id']) {

                            ?>
                                    <option selected value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select><br>
                        <!-- thương hiệu -->
                        <?php
                        $sql_brands = mysqli_query($con, "SELECT * FROM tbl_brands ORDER BY brand_id DESC");
                        ?>
                        <label>Thương hiệu</label>
                        <select class="form-control" name="thuonghieu">
                            <option value="0">---Chọn thương hiệu---</option>
                            <?php
                            while ($row_brands = mysqli_fetch_array($sql_brands)) {
                                // so sánh category_id lấy từ tblsanpham vs tbl_category
                                if ($id_brands_1 == $row_brands['brand_id']) {

                            ?>
                                    <option selected value="<?php echo $row_brands['brand_id'] ?>"><?php echo $row_brands['brand_name'] ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?php echo $row_brands['brand_id'] ?>"><?php echo $row_brands['brand_name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select><br>
                        <input type="submit" name="capnhatsanpham" value="Cập nhật sản phẩm" class="btn btn-primary">
                    </form>
                </div>
            <?php
            } else {
            ?>
                <div class="col-md-4">
                    <h4 style="text-align: center;">Thêm sản phẩm </h4>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- tên -->
                        <label>Tên sản phẩm</label>
                        <input type="text" class="form-control" name="tensanpham" placeholder="Nhập tên sản phẩm" required=""><br>
                        <!-- hình ảnh -->
                        <label>Hình ảnh</label>
                        <input type="file" class="form-control" name="hinhanh" required=""><br>
                        <!-- giá -->
                        <label>Giá nhập</label>
                        <input type="text" class="form-control" name="gianhap" placeholder="Nhập giá sản phẩm" required=""><br>
                        <label>Giá</label>
                        <input type="text" class="form-control" name="giasanpham" placeholder="Nhập giá sản phẩm" required=""><br>
                        <!-- giá km -->
                        <label>Giá khuyến mãi</label>
                        <input type="text" class="form-control" name="giakhuyenmai" placeholder="Nhập giá khuyến mãi" required=""><br>
                        <!-- giá km -->
                        <label>Số lượng</label>
                        <input type="number" min="1" class="form-control" name="soluong" placeholder="Nhập số lượng" required=""><br>
                        <!-- mô tả -->
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="10" name="mota" required=""></textarea><br>
                        <!-- chi tiết -->
                        <label>Chi tiết</label>
                        <textarea class="form-control" rows="10" name="chitiet" required=""></textarea><br>
                        <!-- thông số kỹ thuật -->
                        <label>Thông số kỹ thuật</label>
                        <textarea class="form-control" rows="10" name="thongso" required=""></textarea><br>
                        <!-- lấy danh nục từ csdl -->
                        <?php
                        $sql_danhmuc = mysqli_query($con, "SELECT * FROM tbl_category ORDER BY category_id DESC");
                        ?>
                        <label>Danh mục</label>
                        <select class="form-control" name="danhmuc">
                            <option value="0">---Chọn danh mục sản phẩm---</option>
                            <?php
                            while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) {
                            ?>
                                <option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select><br>
                        <!-- thương hiệu -->
                        <?php
                        $sql_brands = mysqli_query($con, "SELECT * FROM tbl_brands ORDER BY brand_id DESC");
                        ?>
                        <label>Thương hiệu</label>
                        <select class="form-control" name="brands">
                            <option value="0">---Chọn thương hiệu---</option>
                            <?php
                            while ($row_brands = mysqli_fetch_array($sql_brands)) {
                            ?>
                                <option value="<?php echo $row_brands['brand_id'] ?>"><?php echo $row_brands['brand_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select><br>

                        <input type="submit" name="themsanpham" value="Thêm sản phẩm" class="btn btn-primary">
                    </form>
                </div>
            <?php
            }
            ?>
            <div class="col-md-8">
                <!-- Tìm kiếm -->
                <form class="form-inline" method="GET">
                    <input class="form-control mr-sm-2" name="search_product" type="search" placeholder="Tìm kiếm theo danh mục" aria-label="Search" required><br>
                    <button class="btn my-2 my-sm-0" type="submit">Tìm kiếm</button><br><br>
                    <button style="margin-left: 20px;" class="btn my-2 my-sm-0" type="submit"><a href="xulysanpham.php" style="color:#000;">Hiển thị tất cả sản phẩm</a></button><br>
                </form><br>
                <!-- Liệt kê ds các sản phẩm -->
                <h4 style="text-align:center;">Danh sách các sản phẩm</h4>
                <?php
                $timkiem = isset($_GET['search_product']) ? $_GET['search_product'] : "";
                if ($timkiem) {
                    $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                                            WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id AND category_name LIKE '%$timkiem%' 
                                            ORDER BY tbl_sanpham.sanpham_id DESC");
                } else {
                    $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                                WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id ORDER BY sanpham_id DESC");
                    // phân trang
                    // $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                    //             WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id ORDER BY sanpham_id DESC LIMIT $begin,10");
                }
                ?>
                <table class="table table-reponsive table-bordered">
                    <tr>
                        <!-- <th>Thứ tự</th> -->
                        <th>id sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Giá</th>
                        <th>Giá khuyến mãi</th>
                        <th>Quản lý</th>
                    </tr>
                    <?php
                    $i = 0;
                    while ($row_sanpham = mysqli_fetch_array($sql_select_sanpham)) {
                        $i++;
                    ?>
                        <tr>
                            <!-- <td><?php echo $i ?></td> -->
                            <td><?php echo $row_sanpham['sanpham_id'] ?></td>

                            <td><?php echo $row_sanpham['sanpham_name'] ?></td>
                            <td><img src="../uploads/<?php echo $row_sanpham['sanpham_image'] ?>" height="80" width="80"></td>
                            <td><?php echo $row_sanpham['sanpham_soluong'] ?></td>
                            <td><?php echo $row_sanpham['category_name'] ?></td>
                            <td><?php echo $row_sanpham['brand_name'] ?></td>

                            <td><?php echo number_format($row_sanpham['sanpham_gia']) . 'vnđ' ?></td>
                            <td><?php echo number_format($row_sanpham['sanpham_giakhuyenmai']) . 'vnđ' ?></td>
                            <td><a href="?xoa=<?php echo $row_sanpham['sanpham_id'] ?>">Xóa</a> ||
                                <a href="xulysanpham.php?quanly=capnhat&capnhat_id=<?php echo $row_sanpham['sanpham_id'] ?>">Cập nhật</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

                <!-- phân trang -->
                <!-- <style>
                    ul.list_trang {
                        padding: 0;
                        margin: 0;
                        list-style: none;
                    }

                    ul.list_trang li {
                        float: left;
                        padding: 5px 13px;
                        margin: 5px;
                        background: burlywood;
                        display: block;
                    }

                    ul.list_trang li a {
                        color: #000;
                        text-align: center;
                        text-decoration: none;
                    }
                </style>
                <p>Trang:</p>
                <?php
                if (!isset($_SESSION['dangnhap'])) {
                    header('Location:index.php');
                }
                 $sql_trang = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                 WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id ORDER BY sanpham_id DESC");
                
                $row_count = mysqli_num_rows($sql_trang);
                $trang = ceil($row_count / 10);
                ?>
                <ul class="list_trang">
                    <?php
                    for ($i = 1; $i <= $trang; $i++) {
                    ?>
                        <li><a href="?trang=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }
                    ?>

                </ul> -->
                <!-- end -->
            </div>
        </div>

    </div>
</body>

</html>