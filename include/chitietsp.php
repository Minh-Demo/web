<?php
if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id = '';
}
$sql_chitiet = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_id='$id'");

?>
<!-- page -->
<div class="services-breadcrumb">
	<div class="agile_inner_breadcrumb">
		<div class="container">
			<ul class="w3_short">
				<li>
					<a href="index.php">Trang chủ</a>
					<i>|</i>
				</li>
				<li>Chi tiết sản phẩm</li>
			</ul>
		</div>
	</div>
</div>
<!-- //page -->
<?php
while ($row_chitiet = mysqli_fetch_array($sql_chitiet)) {
?>
	<!-- thông tin chi tiết -->
	<div class="banner-bootom-w3-agileits py-5" style="background-image: linear-gradient(#99CCFF	, #EEEEEE);">
		<div class="container py-xl-4 py-lg-2" style="background-color: #fff;">
			<div class="row ">
				<div class="col-lg-5 col-md-8 single-right-left ">
					<div class="grid images_3_of_2">
						<div class="flexslider">
							<ul class="slides">
								<img src="images/<?php echo $row_chitiet["sanpham_image"] ?>" data-imagezoom="true" width="150" height="150" alt="">


							</ul>
							<div class="clearfix">
								<img src="images/<?php echo $row_chitiet["sanpham_image"] ?>" data-imagezoom="true" width="150" height="150" alt="">

							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-7 single-right-left simpleCart_shelfItem">

					<h3 class="mb-3"><?php echo $row_chitiet['sanpham_name'] ?></h3>
					<p class="mb-3">
						<span class="item_price"><?php echo number_format($row_chitiet['sanpham_giakhuyenmai']) . 'vnđ' ?></span>
						<del class="mx-2 font-weight-light"><?php echo number_format($row_chitiet['sanpham_gia']) . 'vnđ' ?></del>
						<label style="color: red; ">Miễn phí vận chuyển</label>

					</p>
					<div class="single-infoagile">
						<ul>
							<li class="mb-3">
								Lắp đặt tại nhà.
							</li>
							<li class="mb-3">
								Giao hàng nhanh chóng.
							</li>
							<li class="mb-3">
								Với đội ngũ kỹ thuật chuyên nghiệp.
							</li>

						</ul>
					</div>
					<div class="product-single-w3l">
						<h3 style="text-align:center; padding-top: 10px;">Giới thiệu sản phẩm</h3><br>
						<h4>
							<pre style="white-space:pre-wrap; font-family: Arial, Helvetica, sans-serif;"><b><?php echo $row_chitiet['sanpham_mota'] ?></b></pre>
						</h4><br>
					</div>


					<div class="occasion-cart">
						<?php
						if ($row_chitiet["sanpham_soluong"] > 0) {
						?>
							<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
								<form action="?quanly=giohang" method="post">
									<fieldset>
										<input type="hidden" name="tensanpham" value="<?php echo $row_chitiet['sanpham_name'] ?>" />
										<input type="hidden" name="sanpham_soluong" value="<?php echo $row_chitiet['sanpham_soluong'] ?>" />
										<input type="hidden" name="sanpham_id" value="<?php echo $row_chitiet['sanpham_id'] ?>" />
										<input type="hidden" name="giasanpham" value="<?php echo $row_chitiet['sanpham_gia'] ?>" />
										<input type="hidden" name="hinhanh" value="<?php echo $row_chitiet['sanpham_image'] ?>" />
										<input type="hidden" name="soluong" value="1" />

										<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button" />
									</fieldset><br>
								</form>
							</div>
						<?php } else { ?>
							<h1 class="error" style="color: #ff0000; font-weight: bold;">Hết Hàng</h1>
						<?php }	?>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 single-right-left ">
					<h3 style="text-align:center; padding-top: 10px;">Chi tiết sản phẩm</h3><br>
					<h4>
						<pre style="white-space:pre-wrap; font-family: Arial, Helvetica, sans-serif;"><?php echo $row_chitiet['sanpham_chitiet'] ?></pre>
					</h4>
				</div>
				<!-- css form modal -->
				<style>
					.modal-content {
						border: 5px solid rgba(244, 92, 93, 0.82);
						position: relative;
						display: -webkit-box;
						display: -ms-flexbox;
						display: flex;
						-webkit-box-orient: vertical;
						-webkit-box-direction: normal;
						-ms-flex-direction: column;
						flex-direction: column;
						width: 150%;
						pointer-events: auto;
						background-color: #fff;
						background-clip: padding-box;

						border-radius: 2.0rem;
						outline: 0;
					}
				</style>
				<!-- css form modal -->
				<div class="col-lg-12 col-md-12 " style="text-align:center;">
					<h2><a href="#" data-toggle="modal" data-target="#thongso" class="text-black">Thông số kỹ thuật</a></h2><br>
				</div>
				<!-- Modal thông số kỹ thuật -->
				<div class="modal fade" id="thongso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Thông số kỹ thuật</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<h4>
									<pre style="white-space:pre-wrap; font-family: Arial, Helvetica, sans-serif;"><?php echo $row_chitiet['sanpham_thongso'] ?></pre>
								</h4>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

							</div>
						</div>
					</div>
				</div>



				<!-- Sản phẩm liên quan -->
				<div class="product-single-w3l">
					<h3 style="text-align:center; padding-top: 10px;">Sản phẩm liên quan</h3><br>
					<div class="row">
						<?php
						$sql_splienquan = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE category_id = $row_chitiet[category_id] AND brand_id = $row_chitiet[brand_id] ORDER BY RAND() LIMIT 3");
						while ($row_splienquan = mysqli_fetch_array($sql_splienquan)) {
						?>
							<div class="col-md-3 product-men mt-5">
								<div class="men-pro-item simpleCart_shelfItem">
									<div class="men-thumb-item text-center">
										<img src="images/<?php echo $row_splienquan["sanpham_image"] ?>" width="150" height="150" alt="">
										<div class="men-cart-pro">
											<div class="inner-men-cart-pro">
												<a href="?quanly=chitietsp&id=<?php echo $row_splienquan['sanpham_id'] ?>" class="link-product-add-cart">Xem chi tiết </a>
											</div>

										</div>


									</div>
									<div class="item-info-product text-center border-top mt-4">
										<h4 class="pt-1">
											<a href="?quanly=chitietsp&id=<?php echo $row_splienquan['sanpham_id'] ?>"><?php echo $row_splienquan['sanpham_name'] ?></a>
										</h4>
										<div class="info-product-price my-2">
											<span class="item_price">
												<?php echo number_format($row_splienquan["sanpham_giakhuyenmai"]) . "đ" ?>
											</span>
											<del><?php echo number_format($row_splienquan["sanpham_gia"]) . "đ" ?></del>
										</div>
										<p><?php
											if($row_splienquan["sanpham_soluong"] > 0){
												echo 'Số lượng: '.$row_splienquan['sanpham_soluong'];
											}else{
												echo "Hết hàng";
											}
											?></p><br>
										<?php
											if($row_splienquan["sanpham_soluong"] > 0){
											?>
										<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
											<form action="?quanly=giohang" method="post">
												<fieldset>
													<input type="hidden" name="tensanpham" value="<?php echo $row_splienquan['sanpham_name'] ?>" />
													<input type="hidden" name="sanpham_id" value="<?php echo $row_splienquan['sanpham_id'] ?>" />
													<input type="hidden" name="giasanpham" value="<?php echo $row_splienquan['sanpham_gia'] ?>" />
													<input type="hidden" name="hinhanh" value="<?php echo $row_splienquan['sanpham_image'] ?>" />
													<input type="hidden" name="soluong" value="1" />

													<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button" />
												</fieldset>
											</form>
										</div>
										<?php }else { ?>
												<h3 class="product-new-top" style="color: #fff; font-weight: bold;">Hết Hàng</span><br>
											<?php }	?>
									</div>
								</div>
							</div>
						<?php
						}

						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //thông tin chi tiết -->
<?php
}
?>