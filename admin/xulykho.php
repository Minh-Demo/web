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
// cập nhật
if (isset($_POST['capnhatsoluong'])) {
    $id_update = $_GET['capnhat_id'];

    $soluong = $_POST['soluong'];

    $sql_update = "UPDATE tbl_sanpham SET sanpham_soluong='$soluong' WHERE sanpham_id = '$id_update'";
    mysqli_query($con, $sql_update);
    header("Location:xulykho.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý kho</title>
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
            <?php
                if (isset($_GET['quanly']) == 'capnhat') {
                    $id_capnhatsl = $_GET['capnhat_id'];
                    $sql_capnhatsl = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_id = '$id_capnhatsl'");
                    $row_capnhatsl = mysqli_fetch_array($sql_capnhatsl);

                ?>
            <div class="col-md-3">
                <h4 style="text-align: center;">Cập nhật số lượng </h4>
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- lấy dữ liệu từ csđl đổ ra form -->
                    <!-- tên -->
                    <label>Tên sản phẩm</label>
                    <input type="text" class="form-control" name="tensanpham" value="<?php echo $row_capnhatsl['sanpham_name'] ?>" required=""><br>

                    <label>Số lượng</label>
                    <input type="number" min="1" class="form-control" name="soluong" value="<?php echo $row_capnhatsl['sanpham_soluong'] ?>" required=""><br>

                    <input type="submit" name="capnhatsoluong" value="Cập nhật" class="btn btn-primary">
                </form>
            </div>
        <?php
                }
        ?>
        <div class="col-md-12">
            <!-- Tìm kiếm -->
            <form class="form-inline" method="GET">
                <input class="form-control mr-sm-2" name="search_product" type="search" placeholder="Tìm kiếm theo danh mục" aria-label="Search" required><br>
                <button class="btn my-2 my-sm-0" type="submit">Tìm kiếm</button>
                <button style="margin-left: 20px;" class="btn my-2 my-sm-0" type="submit"><a href="?nhapkho=1" style="color:#000;">Sắp hết hàng</a></button><br>

                <button style="margin-left: 20px;" class="btn my-2 my-sm-0" type="submit"><a href="xulykho.php" style="color:#000;">Hiển thị tất cả sản phẩm</a></button><br>
            </form><br>

            <!-- thương hiệu -->
            <?php
            $sql_brands = mysqli_query($con, "SELECT * FROM tbl_brands ORDER BY brand_id DESC");
            ?>
            <select id="select-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="0">---Chọn thương hiệu---</option>
                <?php
                while ($row_brands = mysqli_fetch_array($sql_brands)) {
                ?>
                    <option <?php if (isset($_GET['thuonghieu']) && $_GET['thuonghieu'] == $row_brands['brand_id']) { ?> selected <?php } ?> value="?thuonghieu=<?php echo $row_brands['brand_id'] ?>"><?php echo $row_brands['brand_name'] ?></option>
                <?php
                }
                ?>
            </select>
            
            
            <!-- Liệt kê ds các sản phẩm -->
            <h4 style="text-align:center;">Danh sách các mặt hàng trong kho</h4>
            <?php
            //  $sql_select_sanpham = mysqli_query($con,"SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
            //  WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id ORDER BY sanpham_id DESC");
            $timkiem = isset($_GET['search_product']) ? $_GET['search_product'] : "";
            $thuonghieu = isset($_GET['thuonghieu']) ? $_GET['thuonghieu'] : "";
            $nhap_hang = isset($_GET['nhapkho']) ? $_GET['nhapkho'] : "";
            if ($timkiem) {
                $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                                            WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id AND category_name LIKE '%$timkiem%' 
                                            ORDER BY tbl_sanpham.sanpham_id DESC");
            }elseif($thuonghieu){
                $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                                        WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id AND tbl_sanpham.brand_id = $thuonghieu
                                        ORDER BY tbl_sanpham.sanpham_id DESC");
            }elseif($nhap_hang){
                $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                                        WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id AND tbl_sanpham.sanpham_soluong <= 10
                                        ORDER BY tbl_sanpham.sanpham_id DESC");
            }
            else {
                $sql_select_sanpham = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_category,tbl_brands
                                WHERE tbl_sanpham.category_id = tbl_category.category_id AND tbl_brands.brand_id = tbl_sanpham.brand_id ORDER BY sanpham_id DESC");
            }
            ?>
            <table class="table table-reponsive table-bordered">
                <tr>
                    <th>Id sản phẩm </th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Danh mục</th>
                    <th>Thương hiệu</th>
                    <th>Quản lý</th>
                </tr>
                <?php
                $i = 0;
                while ($row_sanpham = mysqli_fetch_array($sql_select_sanpham)) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $row_sanpham['sanpham_id'] ?></td>
                        <td><?php echo $row_sanpham['sanpham_name'] ?></td>
                        <td><img src="../uploads/<?php echo $row_sanpham['sanpham_image'] ?>" height="80" width="80"></td>
                        <td><?php echo $row_sanpham['sanpham_soluong'] ?></td>
                        <td><?php echo $row_sanpham['category_name'] ?></td>
                        <td><?php echo $row_sanpham['brand_name'] ?></td>

                        <td><a href="?xoa=<?php echo $row_sanpham['sanpham_id'] ?>">Xóa</a> ||
                            <a href="xulykho.php?quanly=capnhat&capnhat_id=<?php echo $row_sanpham['sanpham_id'] ?>">Cập nhật</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
        </div>
    </div>
</body>

</html>