<?php
	include('include/slider.php');
?>
<?php
	if(isset($_POST['search_button'])){
		$tukhoa = $_POST['search_product'];
		$sql_product = mysqli_query($con,"SELECT * FROM tbl_sanpham WHERE sanpham_name LIKE '%$tukhoa%'
						ORDER BY tbl_sanpham.sanpham_id DESC");
		$title = $tukhoa;
	}
	//sắp xếp
	// $oderField = isset($_GET['field']) ? $_GET['field'] : "";
	// $orderSort = isset($_GET['field']) ? $_GET['field'] : "";

	// if(!empty($orderSort) && !empty($oderField)){
	// 	$sql_product_sx = mysqli_query($con,"SELECT * FROM tbl_sanpham ORDER BY tbl_sanpham.sanpham_gia ASC");
	// }

?>
<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Từ khóa tìm kiếm: <?php echo $title?></h3>
			<!-- //tittle heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">
						<!-- first section -->
						<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
							<div class="row">
								<?php
								while($row_sanpham = mysqli_fetch_array($sql_product)){
								?>
								<div class="col-md-4 product-men mt-5">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="images/<?php echo $row_sanpham["sanpham_image"]?>" width="150" height="150" alt="">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="?quanly=chitietsp&id=<?php echo $row_sanpham['sanpham_id'] ?>" class="link-product-add-cart">Xem chi tiết </a>
												</div>
											</div>
											<span class="product-new-top">Trả góp 0%</span>
										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href = "?quanly=chitietsp&id=<?php echo $row_sanpham['sanpham_id'] ?>"><?php echo $row_sanpham['sanpham_name'] ?></a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price">
													<?php echo number_format($row_sanpham["sanpham_giakhuyenmai"])."đ"?>
												</span>
												<del><?php echo number_format($row_sanpham["sanpham_gia"])."đ"?></del>
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
											<form action="?quanly=giohang" method="post">
												<fieldset>
													<input type="hidden" name="tensanpham" value="<?php echo $row_sanpham['sanpham_name'] ?>" />

													<input type="hidden" name="sanpham_soluong" value="<?php echo $row_sanpham['sanpham_soluong'] ?>" />
													
													<input type="hidden" name="sanpham_id" value="<?php echo $row_sanpham['sanpham_id'] ?>" />
													<input type="hidden" name="giasanpham" value="<?php echo $row_sanpham['sanpham_gia'] ?>" />
													<input type="hidden" name="hinhanh" value="<?php echo $row_sanpham['sanpham_image'] ?>" />
													<input type="hidden" name="soluong" value="1" />
													
													<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button" />
												</fieldset>
											</form>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								?>
								
							</div>
						</div>
						<!-- //first section -->
						
					</div>
				</div>
				<!-- //product left -->
				<!-- product right -->
				<div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
					<div class="side-bar p-sm-4 p-3">
						<div class="search-hotel border-bottom py-2">
							<form class="form-inline" action="index.php?quanly=timkiem" method="post">
							<button class="btn my-2 my-sm-0" name="search_button" type="submit">Tìm kiếm</button><br>
								<input class="form-control mr-sm-2" name="search_product" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search" required>
								
							</form><br>
							
						
						<!-- price -->
					
						<!-- //price -->
						
						<!-- offers -->
						<!-- price -->
						<h3 class="agileits-sear-head mb-3">Lọc khoảng giá</h3>
							<div class="range border-bottom py-2">
								<?php
									$sql_sx = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
										 ORDER BY tbl_sanpham.sanpham_id DESC");
									$row_sx = mysqli_fetch_array($sql_sx);
									$sql_gia ="SELECT * FROM tbl_price_range";
									$result = $con->query($sql_gia);
									foreach($result as $item):
								?>
								<section>
									<a href="?quanly=danhmuc&id=<?php echo $row_sx['category_id'] ?>&start=<?=$item['start']?>&end=<?=$item['end']?>">
									<?=$item['end']==0?"Trên ".number_format($item['start'],0,',','.').'đ':number_format($item['start'],0,',','.').' - '.number_format($item['end'],0,',','.').'đ'?>
									</a>
								</section>
								<?php
								endforeach;
								?>
							</div><br>
						<!-- //price -->
						<!-- Brands -->
						<h3 class="agileits-sear-head mb-3">Thương hiệu</h3>
							<div class="range border-bottom py-2">
								<?php
									$sql_sx = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
										 ORDER BY tbl_sanpham.sanpham_id DESC");
									$row_sx = mysqli_fetch_array($sql_sx);
									
									$sql_brand ="SELECT * FROM tbl_brands WHERE tbl_brands.status = 1";

									$brands = $con->query($sql_brand);
									foreach($brands as $brand):
								?>
								<section>
									<a href="?quanly=danhmuc&id=<?php echo $row_sx['category_id'] ?>&brand_id=<?=$brand['brand_id']?>"><?=$brand['brand_name']?></a>
									
								</section>
								<?php
								endforeach;
								?>
							</div>
						<!-- //offers -->
						<!-- delivery -->
						
						<!-- //delivery -->
						<!-- arrivals -->
						
						<!-- //arrivals -->
					</div>
					<!-- //product right -->
				</div>
			</div>
		</div>
	</div>
	<!-- //top products -->