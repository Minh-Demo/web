<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = '';
    }
    $sql_chitiet = mysqli_query($con,"SELECT * FROM tbl_sanpham WHERE sanpham_id = '$id'");
?>
<?php
// lấy dl từ form 
    if(isset($_POST['themgiohang'])){
        $tensanpham = $_POST['tensanpham'];
        $sanpham_id = $_POST['sanpham_id'];
        $hinhanh = $_POST['hinhanh'];
        $giasanpham = $_POST['giasanpham'];
        $soluong = $_POST['soluong'];
        $sanpham_soluong = $_POST['sanpham_soluong'];
		// 
		$sql_select_giohang = mysqli_query($con,"SELECT * FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
		$count = mysqli_num_rows($sql_select_giohang);
		// nếu đã tồn tại sản phẩm trên giỏ hàng -> update số lượng
		if($count>0){
			$row_sanphamget = mysqli_fetch_array($sql_select_giohang);
			if($row_sanphamget['soluong'] + $soluong <= $sanpham_soluong){
				$soluong = $row_sanphamget['soluong']+1;
				$sql_giohang = "UPDATE tbl_giohang SET soluong = $soluong WHERE sanpham_id = '$sanpham_id'";
			}else{
				echo '<script>alert("Số lượng đặt hiện tại vượt quá số lượng sản phẩm")</script>';	

			}
		}
		// nếu không -> insert sp mới vào giỏ hàng
		else{

			$soluong = $soluong;
			$sql_giohang = "INSERT INTO tbl_giohang(tensanpham,sanpham_id,giasanpham,hinhanh,soluong,sanpham_soluong) values
        		('$tensanpham','$sanpham_id','$giasanpham','$hinhanh','$soluong','$sanpham_soluong')";
        	$insert_row = mysqli_query($con,$sql_giohang);	
        	if($insert_row == 0){
            header('Localhost:81/index.php?quanly=chitietsp&id=',$sanpham_id);
        }
		}
		
        
    }

	//cập nhật giỏ hàng
	elseif(isset($_POST['capnhatgiohang'])){
		for($i=0;$i<count($_POST['product_id']);$i++){
			$id_sanpham = $_POST['product_id'][$i];
			$sql_select_cn = mysqli_query($con,"SELECT * FROM tbl_sanpham WHERE sanpham_id='".$id_sanpham."'");
			
				$row_sanphamcn = mysqli_fetch_array($sql_select_cn);
				if($_POST['soluong'][$i]<=$row_sanphamcn['sanpham_soluong']){
					$sanpham_id = $_POST['product_id'][$i];
					$soluong = $_POST['soluong'][$i];
					$sql_update = mysqli_query($con,"UPDATE tbl_giohang SET soluong = '$soluong' WHERE sanpham_id = '$sanpham_id'");
				}else{
					//  còn lại nối chuỗi '.$row_sanphamcn['sanpham_soluong'].'
					echo '<script>alert("Số lượng đặt hiện tại vượt quá số lượng sản phẩm. ")</script>';	
				}

			

		}
	}
	// xóa sản phẩm
	elseif(isset($_GET['xoa'])){
		$id=$_GET['xoa'];
		$sql_delete = mysqli_query($con,"DELETE FROM tbl_giohang WHERE giohang_id = '$id'");
	}
	//đăng xuất 
	elseif(isset($_GET['dangxuat'])){
		$id=$_GET['dangxuat'];
		if($id == 1){
			unset($_SESSION['dangnhap_home']);
		}// 
	}
	// thanh toasn
	elseif(isset($_POST['thanhtoan'])){
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$note = $_POST['note'];
		$address = $_POST['address'];
		$giaohang = $_POST['giaohang'];
		$sql_khachhang =mysqli_query($con,"INSERT INTO tbl_khachhang(name,phone,email,note,address,giaohang,password) values
        		('$name','$phone','$email','$note','$address','$giaohang','$password')");
		//Thêm đơn hàng
		if($sql_khachhang){
			$sql_select_khachhang = mysqli_query($con,"SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
			$madonhang = rand(0,9999);
			$row_khachhang=mysqli_fetch_array($sql_select_khachhang);
			$khachhang_id = $row_khachhang['khachhang_id'];

			$_SESSION['dangnhap_home'] = $row_khachhang['name'];
			$_SESSION['khachhang_id'] = $khachhang_id;
			for($i=0;$i<count($_POST['thanhtoan_product_id']);$i++){
				$sanpham_id = $_POST['thanhtoan_product_id'][$i];
				$soluong = $_POST['thanhtoan_soluong'][$i];
				

				// update
				
				$sql_donhang = mysqli_query($con,"INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,madonhang) 
						values ('$sanpham_id','$khachhang_id','$soluong','$madonhang')");

				$sql_giaodich = mysqli_query($con,"INSERT INTO tbl_giaodich(sanpham_id,soluong,magiaodich, khachhang_id) 
						values ('$sanpham_id','$soluong','$madonhang','$khachhang_id')");
				$sql_delete_thanhtoan = mysqli_query($con,"DELETE FROM tbl_giohang WHERE sanpham_id = '$sanpham_id'");
			}
			
		}
	}//đặt hàng khi đã đăng nhập
	elseif(isset($_POST['dathang'])){
		$khachhang_id = $_SESSION['khachhang_id'];
		$madonhang = rand(0,9999);
		//Thêm đơn hàng
		for($i=0;$i<count($_POST['thanhtoan_product_id']);$i++){
			$sanpham_id = $_POST['thanhtoan_product_id'][$i];
			$soluong = $_POST['thanhtoan_soluong'][$i];
				
			$update_soluong = mysqli_query($con,"UPDATE tbl_sanpham set sanpham_soluong = sanpham_soluong - $soluong WHERE sanpham_id = $sanpham_id;");

			$sql_donhang = mysqli_query($con,"INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,madonhang) 
						values ('$sanpham_id','$khachhang_id','$soluong','$madonhang')");

			$sql_giaodich = mysqli_query($con,"INSERT INTO tbl_giaodich(sanpham_id,soluong,magiaodich, khachhang_id) 
						values ('$sanpham_id','$soluong','$madonhang','$khachhang_id')");
			$sql_delete_thanhtoan = mysqli_query($con,"DELETE FROM tbl_giohang WHERE sanpham_id = '$sanpham_id'");
			}
		}

?>
<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>G</span>iỏ hàng của bạn
			</h3>
			<?php
				if(isset($_SESSION['dangnhap_home'])){
					echo '<h4 style="color: #000;">Xin chào:  '.$_SESSION['dangnhap_home'].'<a href ="index.php?quanly=giohang&dangxuat=1"> Đăng xuất</a></h4>';
				}else{
					echo '';
				}
				?>
			<!-- //tittle heading -->
			<div class="checkout-right">
				<?php 
				$sql_lay_giohang = mysqli_query($con,"SELECT * FROM tbl_giohang, tbl_sanpham WHERE tbl_giohang.sanpham_id = tbl_sanpham.sanpham_id ORDER BY giohang_id DESC");

				?>

				
				<div class="table-responsive">
					<form action="" method="POST">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>STT</th>
								<th>Sản phẩm</th>
								<th>Số lượng đặt</th>
								<!-- <th>Số lượng còn</th> -->
								<th>Tên sản phẩm</th>

								<th>Giá</th>
								<th>Giá tổng</th>
								<th>Quản lý</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$i = 0;
						$total =0;
						
						while($row_fetch_giohang = mysqli_fetch_array($sql_lay_giohang)){
							// tổng tiền sp
							$subtotal = $row_fetch_giohang['soluong']*$row_fetch_giohang['sanpham_giakhuyenmai'];
							// cộng dồn tiền sản phẩm
							$total+=$subtotal;
							$i++;
							
						?>
							<tr class="rem1">
								<td class="invert"><?php echo $i?></td>
								<td class="invert-image">
									<a href="#">
										<img src="images/<?php echo $row_fetch_giohang['hinhanh']?>" alt=" " class="img-responsive">
									</a>
								</td>
								<td class="invert">
									<div class="quantity">
										<input type="number" min = 1 name="soluong[]" value="<?php echo $row_fetch_giohang['soluong']?>">
										<input type="hidden" name="product_id[]" value="<?php echo $row_fetch_giohang['sanpham_id']?>">
									</div>
								</td>
								<!-- <td class="invert">
									<?php echo $row_fetch_giohang['sanpham_soluong']?>
								</td> -->
								<td class="invert"><?php echo $row_fetch_giohang['tensanpham']?></td>
								<td class="invert"><?php echo number_format($row_fetch_giohang['sanpham_giakhuyenmai']).'vnđ'?></td>
								<td class="invert"><?php echo number_format($subtotal).'vnđ'?></td>
								<td class="invert">
									<a href="?quanly=giohang&xoa=<?php echo $row_fetch_giohang['giohang_id']?>">Xóa sản phẩm</a>
								</td>
							</tr>
						<?php
							}
						?>
						<tr>
							<td colspan="8">Tổng tiền: <?php echo number_format($total).'vnđ'?></td>
						</tr>
						<tr>
							<td colspan="8">
							<button class="btn btn-success"><a href="index.php" style="color: #fff;"> Tiếp tục mua hàng </a></button>
							<input type="submit" class="btn btn-success" value="Cập nhật giỏ hàng" name="capnhatgiohang">
							<?php
								$sql_giohang_select = mysqli_query($con,"SELECT * FROM tbl_giohang");
								$count_giohang_select = mysqli_num_rows($sql_giohang_select);

								if(isset($_SESSION['dangnhap_home']) && $count_giohang_select > 0){
									while($row_1 = mysqli_fetch_array($sql_giohang_select)){
								?>
									<input type="hidden"  name="thanhtoan_soluong[]" value="<?php echo $row_1['soluong']?>">
									<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_1['sanpham_id']?>">
								<?php
								}
								?>
									<input type="submit" class="btn btn-primary" value="Đặt hàng" name="dathang">
								<?php
								}
								?>
							</td>

						</tr>
						</tbody>
					</table>
					</form>
				</div>
			</div>
			<?php
			if(!isset($_SESSION['dangnhap_home'])){
			?>
			<div class="checkout-left">
				<div class="address_form_agile mt-sm-5 mt-4">
					<h4 class="mb-sm-4 mb-3">Thông tin giao hàng</h4>
					<form action="" method="post" class="creditly-card-form agileinfo_form">
						<div class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row">
									<div class="controls form-group">
										<input class="billing-address-name form-control" type="text" name="name" placeholder="Họ và tên" required="">
									</div>
									<div class="w3_agileits_card_number_grids">
										<div class="w3_agileits_card_number_grid_left form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Số điện thoại" name="phone" required="">
											</div>
										</div>
										<div class="w3_agileits_card_number_grid_right form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Địa chỉ" name="address" required="">
											</div>
										</div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Email" name="email" required="">
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Password" name="password" required="">
									</div>
									<div class="controls form-group">
										<textarea style="resize: none" class="form-control" placeholder="Ghi chú" name="note"></textarea>
									</div>
									<div class="controls form-group">
										<select class="option-w3ls" name = "giaohang">
											<option>Hình thức thanh toán</option>
											<option value="1">Thanh toán online</option>
											<option value="0">Thanh toán khi nhận hàng</option>

										</select>
									</div>
								</div>
								<?php
								$sql_lay_giohang = mysqli_query($con,"SELECT *FROM tbl_giohang ORDER BY giohang_id DESC");
								while($row_thanhtoan = mysqli_fetch_array($sql_lay_giohang)){
								?>
									<input type="hidden"  name="thanhtoan_soluong[]" value="<?php echo $row_thanhtoan['soluong']?>">
									<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_thanhtoan['sanpham_id']?>">
								<?php
								}
								?>
								<input style="width:20% " type="submit" name="thanhtoan" class="btn btn-success" value="Thanh toán tới địa chỉ này">
							</div>
						</div>
					</form>
					
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
	<!-- //checkout page -->