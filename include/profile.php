<?php
if(isset($_POST['capnhatthongtin'])){
    $id_update = $_GET['capnhat_id'];
    $hovaten = $_POST['hovaten'];
    $sodienthoai = $_POST['sodienthoai'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $matkhau = $_POST['matkhau'];
    $ghichu = $_POST['ghichu'];

    $sql_update = mysqli_query($con,"UPDATE tbl_khachhang SET name = '$hovaten', phone='$sodienthoai', address='$diachi', email='$email',
                    password='$matkhau', note='$ghichu'  WHERE khachhang_id = '$id_update'");
    // header("Location:index.php?quanly=profile&khachhang=$id_update");
}
?>
<?php
if (isset($_GET['khachhang'])) {
    $id_khachhang = $_GET['khachhang'];
} else {
    $id_khachhang = '';
}
$sql_khachhang = mysqli_query($con, "SELECT * FROM tbl_khachhang WHERE khachhang_id='$id_khachhang'"); //ORDER BY tbl_giaodich.ngaythang DESC sau group by
$row_khachhang = mysqli_fetch_array($sql_khachhang);
?>
<section style="background-color: #eee;">

    <div class="container py-5">
        <div class="row">
         
            <!-- Hiển thị thông tin khách hàng -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="https://www.seekpng.com/png/full/46-463314_v-th-h-user-profile-icon.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3"><?php echo $row_khachhang['name'] ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Họ và tên</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $row_khachhang['name'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Số điện thoại</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $row_khachhang['phone'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Địa chỉ</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $row_khachhang['address'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $row_khachhang['email'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Mật khẩu</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $row_khachhang['password'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Ghi chú giao hàng</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $row_khachhang['note'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success"><a href="index.php" style="color: #fff;"> Quay lại </a></button>
                <button style="margin-left: 50px;" class="btn btn-primary"><a href="?quanly=profile&khachhang=<?php echo $row_khachhang['khachhang_id'] ?>&capnhat_id=<?php echo $row_khachhang['khachhang_id'] ?>" style="color: #fff;"> Sửa thông tin </a></button><br><br>
            </div>

            <!-- Cập nhật thông tin -->
            <?php
            if (isset($_GET['quanly']) == 'profile' && isset($_GET['capnhat_id'])) {
                $id_capnhat = $_GET['capnhat_id'];
                $sql_capnhat = mysqli_query($con, "SELECT * FROM tbl_khachhang WHERE khachhang_id = '$id_capnhat'");
                $row_capnhat = mysqli_fetch_array($sql_capnhat);
            ?>
            
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                        <form action="" method="POST">
                           
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Họ và tên</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="hovaten" value="<?php echo $row_capnhat['name'] ?>" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Số điện thoại</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sodienthoai" value="<?php echo $row_capnhat['phone'] ?>" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Địa chỉ</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="diachi" value="<?php echo $row_capnhat['address'] ?>" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" value="<?php echo $row_capnhat['email'] ?>" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Mật khẩu</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="matkhau" value="<?php echo $row_capnhat['password'] ?>" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Ghi chú giao hàng</p>
                                </div>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" rows="5" name="ghichu"  required=""><?php echo $row_capnhat['note'] ?></textarea>
                                </div>
                            </div>
                            <input style="text-align: center;" type="submit" name="capnhatthongtin" value="Cập nhật" class="btn btn-primary"><br><br>
                            </form>
                        </div>
                    </div>
                </div>
            
            <?php
            }
            ?>
        </div>

    </div>
</section>