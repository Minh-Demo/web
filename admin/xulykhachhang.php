<?php
    session_start();
    if(!isset($_SESSION['dangnhap'])){
        header('Location:index.php');
    }
    // đăng xuất
    if(isset($_GET['login'])){
        $dangxuat = $_GET['login'];
    }else{
        $dangxuat = '';
    }
    if($dangxuat == 'dangxuat'){
        session_destroy();
        header('Location:index.php');
    }
?>
<?php
    include('../db/connect.php');
?>
<?php
    if(isset($_GET['xoakhachhang'])){
        $magiaodich = $_GET['xoakhachhang'];
        $mahang = $_POST['mahang_xuly'];
        $sql_delete_giaodich = mysqli_query($con,"DELETE FROM tbl_giaodich WHERE magiaodich='$magiaodich'");
        header("Location:xulykhachhang.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <h4 style="text-align:center;">Xin chào <?php echo $_SESSION['dangnhap']?> <a href="?login=dangxuat">Đăng xuất</a></h4>
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
            <!-- Liệt kê ds các đơn hàng -->
            <div class="col-md-12">
                <h4 style="text-align:center;">Danh sách khách hàng</h4>
                <?php
                    // $sql_select_khachhang = mysqli_query($con,"SELECT * FROM tbl_khachhang, tbl_giaodich WHERE 
                    //             tbl_khachhang.khachhang_id=tbl_giaodich.khachhang_id  GROUP BY tbl_giaodich.magiaodich 
                    //             ORDER BY tbl_khachhang.khachhang_id DESC"); 

                    // xem các giao dịch đã mua
                    $sql_select_khachhang = mysqli_query($con,"SELECT * FROM tbl_khachhang, tbl_giaodich WHERE 
                                tbl_khachhang.khachhang_id=tbl_giaodich.khachhang_id  GROUP BY tbl_khachhang.khachhang_id 
                                "); 
                ?>
                <table class="table table-reponsive table-bordered">
                    <tr style="text-align:center ;">
                        <th>Thứ tự</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <!-- <th>Ngày mua</th> -->
                        <th>Quản lý</th>
                    </tr>
                    <?php
                        $i = 0;
                        while($row_khachhang = mysqli_fetch_array($sql_select_khachhang)){
                            $i++;
                    ?>
                    <tr style="text-align:center ;">
                        <td><?php echo $i ?></td>
                        <td><?php echo $row_khachhang['name']?></td>
                        <td><?php echo $row_khachhang['phone']?></td>
                        <td><?php echo $row_khachhang['address']?></td>
                        <td><?php echo $row_khachhang['email']?></td>
                        <!-- <td><?php echo $row_khachhang['ngaythang']?></td> -->
                        
                        <td>
                            <!-- <a href="?xoakhachhang=<?php echo $row_khachhang['magiaodich'] ?>">Xóa</a> || -->
                        <!-- từng đơn => khachhang_id = magiaodich -->
                            <a href="?quanly=xemgiaodich&khachhang=<?php echo $row_khachhang['khachhang_id'] ?>">Xem giao dịch</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <!-- //liệt kê khách hang -->
            <!-- Liệt kê lịch sử mua hàng -->
            <div class="col-md-12">
                <h4 style="text-align:center;">Lịch sử đơn hàng</h4>
                <?php
                if(isset($_GET['khachhang'])){
                    $magiaodich = $_GET['khachhang'];
                }else{
                    $magiaodich='';
                }
                //  giao dịch từng đơn => tbl_giaodich.khachhang_id='$magiaodich' = tbl_giaodich.magiaodich='$magiaodich'
                    $sql_select = mysqli_query($con,"SELECT * FROM tbl_giaodich,tbl_khachhang,tbl_sanpham WHERE tbl_giaodich.sanpham_id=tbl_sanpham.sanpham_id 
                                AND tbl_khachhang.khachhang_id=tbl_giaodich.khachhang_id AND tbl_giaodich.khachhang_id='$magiaodich' ORDER BY tbl_giaodich.giaodich_id DESC"); 
                ?>
                <table class="table table-reponsive table-bordered">
                    <tr style="text-align:center ;">
                        <th>Thứ tự</th>
						<th>Mã giao dịcch</th>

                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
						<th>Giá</th>
						<!-- <th>Tổng tiền</th> -->
						<th>Ngày đặt hàng</th>

                        <th>Ghi chú</th>
                        <th>Tình trạng đơn hàng</th>
                    </tr>
                    <?php
                        $i = 0;
                        while($row_donhang = mysqli_fetch_array($sql_select)){
                            $i++;
                    ?>
                    <tr style="text-align:center ;">
                        <td><?php echo $i ?></td>
                        <td><?php echo $row_donhang['magiaodich']?></td>
 
                        <td><?php echo $row_donhang['sanpham_name']?></td>
                        <td><?php echo $row_donhang['soluong']?></td>
                        <td><?php echo number_format( $row_donhang['sanpham_giakhuyenmai']).'vnđ'?></td>
                        <!-- <td><?php echo number_format($row_donhang['soluong'] * $row_donhang['sanpham_giakhuyenmai']).'vnđ'?></td> -->
                        <td><?php echo $row_donhang['ngaythang']?></td>
                        <td><?php echo $row_donhang['note']?></td>
                        <td><?php 
                            if($row_donhang['huydon']==0){

                            }elseif($row_donhang['huydon']==1){
                                echo '<a href = "xulydonhang.php?quanly=xemdonhang&madonhang='.$row_donhang['madonhang'].'&xacnhanhuy=2">Xác nhận hủy đơn</a>';
                            }else{
                                echo 'Đã hủy';
                            }
                            // <a href="xulydonhang.php?quanly=xemdonhang&madonhang='.$row_donhang["madonhang"].'&xacnhanhuy=2"Xác nhận hủy đơn</a>
                        ?></td>
                        <input type="hidden" name="mahang_xuly" value="<?php echo $row_donhang['magiaodich']?>">
                        
                    
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