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
// thêm danh mục
    if(isset($_POST['themdanhmuc'])){
        $tendanhmuc = $_POST['danhmuc'];
        $sql_insert = mysqli_query($con,"INSERT INTO tbl_category(category_name) values ('$tendanhmuc')");
    }
    // cập nhật
    elseif(isset($_POST['capnhatdanhmuc'])){
        $id_post_capnhat = $_POST['id_danhmuc'];
        $tendanhmuc = $_POST['danhmuc'];
        $sql_update = mysqli_query($con,"UPDATE tbl_category SET category_name = '$tendanhmuc' WHERE category_id = '$id_post_capnhat'");
        header("Location:xulydanhmuc.php");
    }
    // xóa danh mục
    if(isset($_GET['xoa'])){
        $id = $_GET['xoa'];
        $sql_delete = mysqli_query($con,"DELETE FROM tbl_category WHERE category_id='$id'");
        header("Location:xulydanhmuc.php");
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
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
            <?php
                if(isset($_GET['quanly'])=='capnhat'){
                    $id_capnhat = $_GET['id'];
                    $sql_capnhat = mysqli_query($con,"SELECT * FROM tbl_category WHERE category_id = '$id_capnhat'");
                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
            ?>
            <div class="col-md-4">
                <h4>Cập nhật danh mục</h4>
                <label for="">Tên danh mục</label>
                <form action="" method="POST">
                    <input type="text" class="form-control" name="danhmuc" value="<?php echo $row_capnhat['category_name']?>" required=""><br>
                    <input type="hidden" class="form-control" name="id_danhmuc" value="<?php echo $row_capnhat['category_id']?>" >
                    <input type="submit" name="capnhatdanhmuc" value="Cập nhật danh mục" class="btn btn-default">
                </form>
            </div>
            <?php
            }else{
                ?>
            <div class="col-md-4">
                <h4>Thêm danh mục</h4>
                <label for="">Tên danh mục</label>
                <form action="" method="POST">
                    <input type="text" class="form-control" name="danhmuc" placeholder="Nhập tên danh mục" required=""><br>
                    <input type="submit" onclick="abc()" name="themdanhmuc" value="Thêm danh mục" class="btn btn-default">
                </form>
            </div>
            <?php
            }
            ?>
            <div class="col-xl-8">
                <h4 style="text-align:center;">Danh sách các danh mục</h4>
                <?php
                    $sql_select = mysqli_query($con,"SELECT * FROM tbl_category ORDER BY category_id DESC")
                ?>
                <table class="table table-reponsive table-bordered">
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tên danh mục</th>
                        <th>Quản lý</th>
                    </tr>
                    <?php
                        $i = 0;
                        while($row_category = mysqli_fetch_array($sql_select)){
                            $i++;
                    ?>
                    <tr>
                        <th><?php echo $i ?></th>
                        <th><?php echo $row_category['category_name']?></th>
                        <th><a href="?xoa=<?php echo $row_category['category_id'] ?>">Xóa</a> || 
                            <a href="?quanly=capnhat&id=<?php echo $row_category['category_id'] ?>">Cập nhật</a></th>
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