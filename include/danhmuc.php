<?php
	// include('include/slider.php');
?>
<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	else{
		$id = '';
	}
	$param_sort = "";

	// lọc theo giá
	if(isset($_GET['start'])){
		$start = $_GET['start'];
		$end = $_GET['end'];
		// kethop1
		$param_sort = "start=".$start."&"."end=".$end."&";
		// 
		$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
		 			AND tbl_sanpham.category_id='$id' AND tbl_sanpham.sanpham_giakhuyenmai >= '$start' AND tbl_sanpham.sanpham_giakhuyenmai < '$end' ");
	
		if($end==0){
			$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
					AND tbl_sanpham.category_id='$id' AND tbl_sanpham.sanpham_giakhuyenmai >= '$start' ");
		}
		// kêt hop 1
		if(isset($_GET['start']) && isset($_GET['field'])){
			$field = $_GET['field'];
			$sort = $_GET['sort'];
			if($sort == 'desc'){
				$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
					AND tbl_sanpham.category_id='$id' AND tbl_sanpham.sanpham_giakhuyenmai >= '$start' AND tbl_sanpham.sanpham_giakhuyenmai < '$end' ORDER BY tbl_sanpham.sanpham_giakhuyenmai DESC ");
			}
			if($sort == 'asc'){
				$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
					AND tbl_sanpham.category_id='$id' AND tbl_sanpham.sanpham_giakhuyenmai >= '$start' AND tbl_sanpham.sanpham_giakhuyenmai < '$end' ORDER BY tbl_sanpham.sanpham_giakhuyenmai ASC ");
			}
		}
		// kêt hop 2
		if(isset($_GET['start']) && isset($_GET['brand_id'])){
			$brand_id = $_GET['brand_id'];
			
			$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
			AND tbl_sanpham.category_id='$id' AND tbl_sanpham.sanpham_giakhuyenmai >= '$start' AND tbl_sanpham.sanpham_giakhuyenmai < '$end' AND tbl_sanpham.brand_id = $brand_id ");
		}
		}
		// sắp xếp theo giá
		elseif(isset($_GET['field'])){
			$field = $_GET['field'];
			$sort = $_GET['sort'];
			
			if($sort == 'desc'){
				$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
					AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_giakhuyenmai DESC ");
			}
			if($sort == 'asc'){
				$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
					AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_giakhuyenmai ASC ");
			}
		}
		
		//  thương hiệu
		elseif(isset($_GET['brand_id'])){
			$brand_id = $_GET['brand_id'];
			$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
			AND tbl_sanpham.category_id='$id' AND tbl_sanpham.brand_id = $brand_id ");

		}
		else{
			$sql_cate = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
						AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_id DESC");
		}
	
		$sql_category = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
					AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_id DESC");
		$row_title = mysqli_fetch_array($sql_category);
		$title = $row_title["category_name"];

	
	?>
<!-- top Products -->
<div class="services-breadcrumb">
			<div class="agile_inner_breadcrumb">
				<div class="container">
					<ul class="w3_short">
						<li>
							<a href="index.php">Home</a>
							<i>|</i>
						</li>
						<li>Danh mục sản phẩm</li>
					</ul>
				</div>
			</div>
	</div>
<div class="ads-grid py-sm-5 py-4" style="background-image: linear-gradient(#99CCFF	, #EEEEEE);">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			
			<!-- //tittle heading -->
			<div class="row" style="background-color: #fff;">
			
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">
					
					
					<!-- first section -->

						<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
						<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3"><?php echo $row_title["category_name"]?></h3>
						<?php
						if(isset($_GET['start'])){
							if($end==0){
							echo'<h3>Các sản phẩm có giá trên '.number_format($start,0,',','.').'đ</h3>';
							}else
							echo'<h3>Các sản phẩm có giá từ '.number_format($start,0,',','.').'đ' .' - '.number_format($end,0,',','.').'đ</h3>';
						}elseif(isset($_GET['brand_id'])){
							$brand_id = $_GET['brand_id'];
							$sql_th = mysqli_query($con,"SELECT * FROM tbl_brands WHERE tbl_brands.brand_id = $brand_id");
							$row_th = mysqli_fetch_array($sql_th);
							echo'<h3>Các sản phẩm thương hiệu '.$row_th['brand_name'];
						}
						elseif(isset($_GET['field'])){
							$field = $_GET['field'];
							$sort = $_GET['sort'];
							if($sort == 'desc'){
								echo'<h3>Các sản phẩm có giá từ cao đến thấp ';
							}else{
								echo'<h3>Các sản phẩm có giá từ thấp đến cao ';
							}
						}

						?>
						

						
							<div class="row">
								<?php
								while($row_sanpham = mysqli_fetch_array($sql_cate)){
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
											<!-- hiển thị số lượng -->
											<p><?php
											if($row_sanpham["sanpham_soluong"] > 0){
												echo 'Số lượng: '.$row_sanpham['sanpham_soluong'];
											}else{
												echo "Hết hàng";
											}
											?></p><br>
											<!-- kiểm tra số lượng hết hàng  -->
											<?php
											if($row_sanpham["sanpham_soluong"] > 0){
											?>
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
											<?php }else { ?>
												<h3 class="product-new-top" style="color: #fff; font-weight: bold;">Hết Hàng</span>
											<?php }	?>
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
						
						<button class="btn my-2 my-sm-0" type="submit"><a href="index.php?quanly=danhmuc&id=<?php echo $row_title['category_id'] ?>" style="color:#000;">Hiển thị tất cả sản phẩm</a></button><br><br>
							<!-- Sắp xếp -->
							<div id="filter-box">
								<?php
					
									$sql_sort = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
										AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_id DESC");
									$row_sort = mysqli_fetch_array($sql_sort);
									
								?>
								<select id="sort-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
									<option value="">--Sắp xếp theo giá--</option>
									<option <?php if(isset($_GET['sort']) && $_GET['sort'] == 'desc') {?> selected <?php } ?> value="?quanly=danhmuc&id=<?php echo $row_sort['category_id'] ?>&<?=$param_sort?>field=gia&sort=desc">Cao đến thấp</option>
									<option <?php if(isset($_GET['sort']) && $_GET['sort'] == 'asc') {?> selected <?php } ?> value="?quanly=danhmuc&id=<?php echo $row_sort['category_id'] ?>&<?=$param_sort?>field=gia&sort=asc">Thấp đến cao</option>
								</select>
							</div>
							<br><br>
							<!-- Lọc theo khoảng giá -->
							<h3 class="agileits-sear-head mb-3">Lọc khoảng giá</h3>
							<div class="range border-bottom py-2">
								<?php
									$sql_sx = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
										AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_id DESC");
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
						<!-- Lọc thương hiệu -->
						<h3 class="agileits-sear-head mb-3">Thương hiệu</h3>
							<div class="range border-bottom py-2">
								<?php
									$sql_sx = mysqli_query($con,"SELECT * FROM tbl_category, tbl_sanpham WHERE tbl_category.category_id=tbl_sanpham.category_id 
										AND tbl_sanpham.category_id='$id' ORDER BY tbl_sanpham.sanpham_id DESC");
									$row_sx = mysqli_fetch_array($sql_sx);
									
									$sql_brand ="SELECT * FROM tbl_brands WHERE tbl_brands.status = 1";

									$brands = $con->query($sql_brand);
									foreach($brands as $brand):
								?>
								<section>
									<a href="?quanly=danhmuc&id=<?php echo $row_sx['category_id'] ?>&<?=$param_sort?>brand_id=<?=$brand['brand_id']?>"><?=$brand['brand_name']?></a>
									
								</section>
								<?php
								endforeach;
								?>
							</div>
						<!-- //Brands -->
						
						<!-- //arrivals -->
					</div>
					<!-- //product right -->
				</div>
			</div>
		</div>
	</div>
	<!-- //top products -->