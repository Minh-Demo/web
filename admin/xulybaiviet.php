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
// thêm sản phẩm
    if(isset($_POST['thembaiviet'])){
        $tenbaiviet = $_POST['tenbaiviet'];
        $hinhanh = $_FILES['hinhanh']['name'];
        $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
       
        $danhmuc = $_POST['danhmuc'];
        $noidung = $_POST['noidung'];
        $tomtat = $_POST['tomtat'];
        // tạo đường dẫn ra folder uploads
        $path = '../uploads/';
        $sql_insert_sanpham = mysqli_query($con,"INSERT INTO tbl_baiviet(tenbaiviet,tomtat,noidung,danhmuctin_id,baiviet_image) 
                values ('$tenbaiviet','$tomtat','$noidung','$danhmuc','$hinhanh')");
        move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
    }
    // cập nhật
    elseif(isset($_POST['capnhatbaiviet'])){
        $id_update = $_GET['capnhat_id'];
        $tenbaiviet = $_POST['tenbaiviet'];
        $hinhanh = $_FILES['hinhanh']['name'];
        $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
        
        $danhmuc = $_POST['danhmuc'];
        $noidung = $_POST['noidung'];
        $tomtat = $_POST['tomtat'];
        // tạo đường dẫn ra folder uploads
        $path = '../uploads/';
        // kiểm tra có chọn ảnh không
        if(!$hinhanh){
            $sql_update_img = "UPDATE tbl_baiviet SET tenbaiviet='$tenbaiviet',noidung='$noidung',tomtat='$tomtat',
                    danhmuctin_id='$danhmuc' WHERE baiviet_id = '$id_update'";
        }else{
            move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
            $sql_update_img = "UPDATE tbl_baiviet SET tenbaiviet='$tenbaiviet',noidung='$noidung',tomtat='$tomtat',
                    danhmuctin_id='$danhmuc',baiviet_image='$hinhanh' WHERE baiviet_id = '$id_update'";
        }
        mysqli_query($con,$sql_update_img);
        header("Location:xulybaiviet.php");
    }
    // xóa sản phẩm
    if(isset($_GET['xoa'])){
        $id = $_GET['xoa'];
        $sql_delete = mysqli_query($con,"DELETE FROM tbl_baiviet WHERE baiviet_id='$id'");
        header("Location:xulybaiviet.php");
    }



?>
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
    <div class="container" >
        <div class="row">
            <!-- cập nhật sản phẩm -->
            <?php
                if(isset($_GET['quanly'])=='capnhat'){
                    $id_capnhat = $_GET['capnhat_id'];
                    $sql_capnhat = mysqli_query($con,"SELECT * FROM tbl_baiviet WHERE baiviet_id = '$id_capnhat'");
                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
                    $id_category_1 = $row_capnhat['danhmuctin_id']
            ?>
            <div class="col-md-4" >
                <h4 style="text-align: center;">Cập nhật bài viết </h4>
                <form action="" method="POST" enctype="multipart/form-data">
                <!-- lấy dữ liệu từ csđl đổ ra form -->
                <!-- tên -->
                    <label>Tên bài viết</label>
                    <input type="text" class="form-control" name="tenbaiviet" value="<?php echo $row_capnhat['tenbaiviet'] ?>" required=""><br>
                <!-- hình ảnh -->
                    <label>Hình ảnh</label>
                    <input type="file" class="form-control" name="hinhanh" required="">
                    <img src="../uploads/<?php echo $row_capnhat['baiviet_image']?>" height="80" width="80"><br>
                
                    <label>Tóm tắt</label>
                    <textarea class="form-control" rows="10" name="tomtat" required="" ><?php echo $row_capnhat['tomtat'] ?></textarea><br>
                <!-- chi tiết -->
                    <label>Nội dung chi tiết</label>
                    <textarea class="form-control" rows="10" name="noidung"  required=""><?php echo $row_capnhat['noidung'] ?></textarea><br>
                <!-- lấy danh mục từ csdl -->
                <?php 
                $sql_danhmuc = mysqli_query($con,"SELECT * FROM tbl_danhmuc_tin ORDER BY danhmuctin_id DESC");
                ?>
                    <label>Danh mục</label>
                    <select class="form-control" name="danhmuc">
                        <option value="0">---Chọn danh mục sản phẩm---</option>
                        <?php 
                        while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)){
                            // so sánh category_id lấy từ tblsanpham vs tbl_category
                            if($id_category_1 == $row_danhmuc['danhmuctin_id']){

                        ?>
                        <option selected value="<?php echo $row_danhmuc['danhmuctin_id']?>"><?php echo $row_danhmuc['tendanhmuc']?></option>
                        <?php
                            }else{
                        ?>
                        <option value="<?php echo $row_danhmuc['danhmuctin_id']?>"><?php echo $row_danhmuc['tendanhmuc']?></option>
                        <?php       
                            }
                        }
                        ?>
                    </select><br>
                    <input type="submit" name="capnhatbaiviet" value="Cập nhật bài viết" class="btn btn-primary">
                </form>
            </div>
            <?php
            }else{
                ?>
            <div class="col-md-4" >
                <h4 style="text-align: center;">Thêm bài viết </h4>
                <form action="" method="POST" enctype="multipart/form-data">
                <!-- tên -->
                    <label>Tên bài viết</label>
                    <input type="text" class="form-control" name="tenbaiviet" placeholder="Nhập tên bài viết" required=""><br>
                <!-- hình ảnh -->
                    <label>Hình ảnh</label>
                    <input type="file" class="form-control" name="hinhanh" required=""><br>
                
                   
                <!-- mô tả -->
                    <label>Tóm tắt</label>
                    <textarea class="form-control" name="tomtat" required=""></textarea><br>
                <!-- chi tiết -->
                    <label>Nội dung</label>
                    <textarea class="form-control" name="noidung" required=""></textarea><br>
                <!-- lấy danh nục từ csdl -->
                <?php 
                $sql_danhmuc = mysqli_query($con,"SELECT * FROM tbl_danhmuc_tin ORDER BY danhmuctin_id DESC");
                ?>
                    <label>Danh mục</label>
                    <select class="form-control" name="danhmuc">
                        <option value="0">---Chọn danh mục sản phẩm---</option>
                        <?php 
                        while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)){
                        ?>
                        <option value="<?php echo $row_danhmuc['danhmuctin_id']?>"><?php echo $row_danhmuc['tendanhmuc']?></option>
                        <?php
                        }
                        ?>
                    </select><br>
                    <input type="submit" name="thembaiviet" value="Thêm bài viết" class="btn btn-primary">
                </form>
            </div>
            <?php
            }
            ?>
            <div class="col-md-8" >
                <!-- Liệt kê ds các bài viết -->
                <h4 style="text-align:center;">Danh sách các bài viết</h4>
                <?php
                    $sql_select_baiviet = mysqli_query($con,"SELECT * FROM tbl_baiviet,tbl_danhmuc_tin 
                                WHERE tbl_baiviet.danhmuctin_id = tbl_danhmuc_tin.danhmuctin_id ORDER BY tbl_baiviet.baiviet_id DESC");
                ?>
                <table  class="table table-reponsive table-bordered">
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tên bài viết</th>
                        <th>Hình ảnh</th>
                        
                        <th>Danh mục</th>
                       
                        <th>Quản lý</th>
                    </tr>
                    <?php
                        $i = 0;
                        while($row_baiviet = mysqli_fetch_array($sql_select_baiviet)){
                            $i++;
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo $row_baiviet['tenbaiviet']?></td>
                        <td><img src="../uploads/<?php echo $row_baiviet['baiviet_image']?>" height="80" width="80"></td>
                        
                        <td><?php echo $row_baiviet['tendanhmuc']?></td>
                        
                        
                        <td><a href="?xoa=<?php echo $row_baiviet['baiviet_id'] ?>">Xóa</a> || 
                            <a href="xulybaiviet.php?quanly=capnhat&capnhat_id=<?php echo $row_baiviet['baiviet_id']?>">Cập nhật</a></td>
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