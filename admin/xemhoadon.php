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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--Danh sách các đơn hàng  -->
                <!-- <style>
                    .header {
                        display: flex;
                    }
                </style>
                <div class="header">
                    <div>
                        <h3 style="text-align:left;margin-left:30px; padding: 50px 0px 20px ">Điện máy store</h3>
                        <span >Địa chỉ: Cổ Nhuế - Bắc Từ Liêm - Hà Nội</span>
                        <p style="margin-left:15px;">Điện thoại: 001 234 5678</p>
                        <span style="margin-left:25px;">Fax: 001 234 5678</span><br><br>
                        
                        
                    </div>
                   
                    <h1 style="float: right; margin-left:300px; padding: 50px 0px 20px">Hóa đơn thanh toán</h1>

                    
                </div> -->
                <h2 style="text-align:center; padding: 50px 0px 20px">Hóa đơn thanh toán</h2>

                <?php
                if (isset($_GET['madonhang'])) {
                    $madonhang = $_GET['madonhang'];
                    $sql_select = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                            AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");
                    $sql_tt = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                            AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");
                }

                ?>
                <?php
                $row = mysqli_fetch_array($sql_tt);
                ?>
                <h5>Mã đơn hàng: <?php echo $row['madonhang'] ?></h5>
                <h5>Tên khách hàng: <?php echo $row['name'] ?></h5>
                <h5>Địa chỉ: <?php echo $row['address'] ?></h5>
                <h5>Số điện thoại: <?php echo $row['phone'] ?></h5>
                <h5>Các sản phẩm đã đặt hàng:</h5>
                <table class="table table-reponsive table-bordered">
                    <tr style="text-align:center ;">
                        <th>Thứ tự</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                        <th>Ngày đặt hàng</th>


                    </tr>
                    <?php
                    $i = 0;
                    $total =0;
                    while ($row_donhang1 = mysqli_fetch_array($sql_select)) {
                        $subtotal = $row_donhang1['soluong']*$row_donhang1['sanpham_giakhuyenmai'];
							// cộng dồn tiền sản phẩm
						$total+=$subtotal;
                        $i++;
                    ?>


                        <tr style="text-align:center ;">
                            <td><?php echo $i ?></td>
                            <td><?php echo $row_donhang1['sanpham_name'] ?></td>
                            <td><?php echo $row_donhang1['soluong'] ?></td>
                            <td><?php echo number_format($row_donhang1['sanpham_giakhuyenmai']) . 'vnđ' ?></td>
                            <td><?php echo number_format($row_donhang1['soluong'] * $row_donhang1['sanpham_giakhuyenmai']) . 'vnđ' ?></td>


                            <td><?php echo $row_donhang1['ngaydathang'] ?></td>

                        </tr>
                        
                    <?php
                    }
                    ?>
               
                       
                </table>
                <h5>Tổng phải thanh toán: <?php echo number_format($total) . 'vnđ' ?></h5>
                <button class="btn btn-success"><a href="xulydonhang.php" style="color: #fff;"> Quay lại  </a></button>
                <button class="btn btn-primary"><a href="indonhang_1.php?madonhang=<?php echo $row['madonhang']?>" style="color: #fff;"> In hóa đơn  </a></button>
                <button class="btn btn-primary"><a href="inbaohanh.php?madonhang=<?php echo $row['madonhang']?>" style="color: #fff;"> In phiếu bảo hành  </a></button>

            </div>
        </div>
    </div>
</body>

</html>