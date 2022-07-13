<?php
session_start();

use Carbon\Carbon;
use Carbon\CarbonInterval;

require('../carbon/autoload.php'); //gọi hàm carbon

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
// cập nhật dơn hàng
if (isset($_POST['capnhatdonhang'])) {
    $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
    $xuly = $_POST['xuly'];
    $mahang = $_POST['mahang_xuly'];
    $sql_update_donhang = mysqli_query($con, "UPDATE tbl_donhang SET tinhtrang='$xuly' WHERE madonhang='$mahang'");
    $sql_update_giaodich = mysqli_query($con, "UPDATE tbl_giaodich SET tinhtrangdon='$xuly' WHERE magiaodich='$mahang'");
    //cap nhat thong ke doanh thu
    $sql_lietke_dh = "SELECT * FROM tbl_donhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id AND tbl_donhang.madonhang='$mahang'";

    $sql_thongke = "SELECT * FROM tbl_thongke WHERE ngaydat='" . $now . "'"; //chọn thống ke dựa vào ngày dat
    $query_thongke = mysqli_query($con, $sql_thongke); //truy vấn
    $query_lietke_dh = mysqli_query($con, $sql_lietke_dh); //truy vấn

    $total = 0;
    $giatien = 0;
    $nhaphang = 0;
    while ($row = mysqli_fetch_array($query_lietke_dh)) {

        $total += $row['soluong'];
        $tongnhap = $row['sanpham_gianhap'] * $row['soluong'];
        $nhaphang += $tongnhap;
        $tong = $row['sanpham_giakhuyenmai'] * $row['soluong'];
        $giatien += $tong;
        $row['sanpham_soluong'] -= $row['soluong'];
    }


    //cập nhật đơn hàng thống kê doanh thu
    if (mysqli_num_rows($query_thongke) == 0) {
        $soluongban = $total;
        $doanhthu = $giatien;
        $tiennhap = $nhaphang;
        $donhang = 1;
        $sql_update_thongke = mysqli_query($con, "INSERT INTO tbl_thongke (ngaydat,soluongban,doanhthu,nhaphang,donhang) VALUE('$now','$soluongban','$doanhthu','$tiennhap','$donhang')"); //nếu ngày đặt tồn tại thì cập nhật thống kê theo ngày đặt đó
    } elseif (mysqli_num_rows($query_thongke) != 0) { //nếu ngày đặt ko có thì thêm vào ngày mới trong thống kê
        while ($row_tk = mysqli_fetch_array($query_thongke)) {
            $soluongban = $row_tk['soluongban'] + $total;
            $doanhthu = $row_tk['doanhthu'] + $giatien;
            $tiennhap = $row_tk['nhaphang'] + $nhaphang;
            $donhang = $row_tk['donhang'] + 1;
            $sql_update_thongke = mysqli_query($con, "UPDATE tbl_thongke SET soluongban='$soluongban',doanhthu='$doanhthu',nhaphang='$tiennhap',donhang='$donhang' WHERE ngaydat='$now'"); //update thống kê
        }
    }
    header("Location:xulydonhang.php");
} // xóa đơn hàng
if (isset($_GET['xoadonhang'])) {
    $madonhang = $_GET['xoadonhang'];
    $mahang = $_POST['mahang_xuly'];
    $sql_delete_donhang = mysqli_query($con, "DELETE FROM tbl_donhang WHERE madonhang='$madonhang'");
    header("Location:xulydonhang.php");
} //Hủy đơn
if (isset($_GET['xacnhanhuy']) && isset($_GET['madonhang'])) {
    $huydon = $_GET['xacnhanhuy'];
    $magiaodich = $_GET['madonhang'];
} else {
    $huydon = '';
    $magiaodich = '';
}
$sql_update_donhang = mysqli_query($con, "UPDATE tbl_donhang SET huydon='$huydon' WHERE madonhang='$magiaodich'");
$sql_update_giaodich = mysqli_query($con, "UPDATE tbl_giaodich SET huydon='$huydon' WHERE magiaodich='$magiaodich'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
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
            <!-- Liệt kê ds các đơn hàng -->
            <div class="col-md-12">
                <!-- tìm kiếm theo mã đơn hàng -->
                <form class="form-inline" method="GET">
                    <input class="form-control mr-sm-2" name="search_madonhang" type="search" placeholder="Tìm kiếm theo mã đơn hàng" aria-label="Search" required><br>
                    <button class="btn my-2 my-sm-0" type="submit">Tìm kiếm</button><br><br>
                    <button style="margin-left: 20px;" class="btn my-2 my-sm-0" type="submit"><a href="xulydonhang.php" style="color:#000;">Hiển thị tất cả</a></button><br>
                </form><br>


                <!-- tình trạng đơn -->
                <div id="filter-box">
                    <select id="select-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="#">--Tình trạng đơn--</option>
                        <option <?php if (isset($_GET['tinhtrangdon']) && $_GET['tinhtrangdon'] == '1') { ?> selected <?php } ?> value="?tinhtrangdon=1">Đã xử lý </option>
                        <option <?php if (isset($_GET['tinhtrangdon']) && $_GET['tinhtrangdon'] == '2') { ?> selected <?php } ?> value="?tinhtrangdon=2">Chưa xử lý</option>
                    </select><br>
                </div>
                <!-- Chi tiết đơn hàng -->
                <?php
                if (isset($_GET['quanly']) == 'xemdonhang') {
                    $madonhang = $_GET['madonhang'];
                    $sql_chitiet = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                                AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");
                ?>
                    <!-- xem chi tiết đơn hàng -->
                    <div class="col-md-12">
                        <h4 style="text-align:center;">Chi tiết đơn hàng</h4>

                        <form action="" method="POST">
                            <table class="table table-reponsive table-bordered">
                                <tr style="text-align:center ;">
                                    <th>Thứ tự</th>
                                    <th>Mã hàng</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng tiền</th>
                                    <th>Ghi chú</th>
                                    <th>Ngày đặt hàng</th>
                                </tr>
                                <?php
                                $i = 0;
                                while ($row_donhang = mysqli_fetch_array($sql_chitiet)) {
                                    $i++;
                                ?>
                                    <tr style="text-align:center ;">
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row_donhang['madonhang'] ?></td>
                                        <td><?php echo $row_donhang['sanpham_name'] ?></td>
                                        <td><?php echo $row_donhang['soluong'] ?></td>
                                        <td><?php echo number_format($row_donhang['sanpham_giakhuyenmai']) . 'vnđ' ?></td>
                                        <td><?php echo number_format($row_donhang['soluong'] * $row_donhang['sanpham_giakhuyenmai']) . 'vnđ' ?></td>
                                        <td><?php echo $row_donhang['note'] ?></td>
                                        <td><?php echo $row_donhang['ngaydathang'] ?></td>
                                        <input type="hidden" name="mahang_xuly" value="<?php echo $row_donhang['madonhang'] ?>">
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <select class="form-control" name="xuly">
                                <option value="#">----</option>
                                <option value="1">Đã xử lý | Giao hàng</option>
                                <option value="0">Chưa xử lý</option>
                            </select><br>
                            <input type="submit" value="Cập nhật đơn hàng" name="capnhatdonhang" class="btn btn-success">
                        </form>
                    </div>
                    <!-- chi tiêt đơn hàng -->
                <?php
                }
                ?>
                <!-- End chi tiết -->
                <!--Danh sách các đơn hàng  -->
                <h4 style="text-align:center;">Danh sách các đơn hàng</h4>
                <?php
                $search_madonhang = isset($_GET['search_madonhang']) ? $_GET['search_madonhang'] : "";
                $tinhtrangdon = isset($_GET['tinhtrangdon']) ? $_GET['tinhtrangdon'] : "";
                // hiển thị đơn hàng theo mã đơn tìm kiếm
                if ($search_madonhang) {
                    $sql_select = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id 
                                AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = $search_madonhang GROUP BY madonhang ORDER BY `tbl_donhang`.`ngaydathang` DESC");
                }
                // hiển thị theo tình trạng đơn
                elseif ($tinhtrangdon) {
                    if ($tinhtrangdon == 1) {
                        $sql_select = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id 
                                    AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tinhtrang = 1 GROUP BY madonhang ORDER BY `tbl_donhang`.`ngaydathang` DESC");
                    } elseif ($tinhtrangdon == 2) {
                        $sql_select = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id 
                                    AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.tinhtrang = 0 GROUP BY madonhang ORDER BY `tbl_donhang`.`ngaydathang` DESC");
                    }
                } else {
                    $sql_select = mysqli_query($con, "SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id 
                                AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id GROUP BY madonhang ORDER BY `tbl_donhang`.`ngaydathang` DESC");
                }
                ?>
                <table class="table table-reponsive table-bordered">
                    <tr style="text-align:center ;">
                        <th>Thứ tự</th>
                        <th>Mã đơn hàng</th>
                        <th>Tình trạng đơn</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Hủy đơn</th>
                        <th>Quản lý</th>
                    </tr>
                    <?php
                    $i = 0;
                    while ($row_donhang = mysqli_fetch_array($sql_select)) {
                        $i++;
                    ?>
                        <tr style="text-align:center ;">
                            <td><?php echo $i ?></td>
                            <td><?php echo $row_donhang['madonhang'] ?></td>
                            <td><?php
                                if ($row_donhang['tinhtrang'] == 0) {
                                    echo 'Chưa xử lý';
                                } else {
                                    echo 'Đã xử lý';
                                }
                                ?></td>
                            <td><?php echo $row_donhang['name'] ?></td>
                            <td><?php echo $row_donhang['ngaydathang'] ?></td>
                            <td><?php
                                if ($row_donhang['huydon'] == 0) {
                                } elseif ($row_donhang['huydon'] == 1) {
                                    echo '<a href = "xulydonhang.php?quanly=xemdonhang&madonhang=' . $row_donhang['madonhang'] . '&xacnhanhuy=2">Xác nhận hủy đơn</a>';
                                } else {
                                    echo 'Đã hủy';
                                }
                                // <a href="xulydonhang.php?quanly=xemdonhang&madonhang='.$row_donhang["madonhang"].'&xacnhanhuy=2"Xác nhận hủy đơn</a>
                                ?></td>

                            <td>
                                <!-- <a href="?xoadonhang=<?php echo $row_donhang['madonhang'] ?>">Xóa</a> ||  -->
                                <a href="?quanly=xemdonhang&madonhang=<?php echo $row_donhang['madonhang'] ?>">Xem chi tiết</a> ||
                                <a href="xemhoadon.php?madonhang=<?php echo $row_donhang['madonhang'] ?>">Xem hóa đơn</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <!-- //liệt kê đơn hàng -->

        </div>
    </div>
</body>

</html>