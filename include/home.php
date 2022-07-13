<?php
include('include/slider.php');
?>
<!-- <?php
		if (isset($_GET['trang'])) {
			$page = $_GET['trang'];
		} else {
			$page = '';
		}
		if ($page == '' || $page == 1) {
			$begin = 0;
		} else {
			$begin = ($page * 4) - 4;
		}
		?> -->
<!-- top Products -->

<div class="ads-grid py-sm-5 py-4" style="background-image: linear-gradient(#99CCFF	, #EEEEEE);">
	<div class="container py-lg-4 py-lg-2">
		<!-- Sản phẩm bán chạy -->
		<div class="agileinfo-ads-display col-lg-12" style="background-color: #fff">
			<div class="wrapper">
				<!-- first section -->
				<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-3">
					<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Sản phẩm bán chạy</h3>

					<div class="row">
						<?php
						$sql_product_sidebar = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_hot = '1' ORDER BY sanpham_id DESC LIMIT 4");
						while ($row_product_sidebar = mysqli_fetch_array($sql_product_sidebar)) {
						?>

							<div class="col-md-3 product-men mt-5">
								<div class="men-pro-item simpleCart_shelfItem">
									<div class="men-thumb-item text-center">
										<img src="images/<?php echo $row_product_sidebar["sanpham_image"] ?>" width="150" height="150" alt="">
										<div class="men-cart-pro">
											<div class="inner-men-cart-pro">
												<a href="?quanly=chitietsp&id=<?php echo $row_product_sidebar['sanpham_id'] ?>" class="link-product-add-cart">Xem chi tiết </a>
											</div>

										</div>
										<span class="product-new-top">Sản phẩm hot</span>

									</div>
									<div class="item-info-product text-center border-top mt-4">
										<h4 class="pt-1">
											<a href="?quanly=chitietsp&id=<?php echo $row_product_sidebar['sanpham_id'] ?>"><?php echo $row_product_sidebar['sanpham_name'] ?></a>
										</h4>
										<div class="info-product-price my-2">
											<span class="item_price">
												<?php echo number_format($row_product_sidebar["sanpham_giakhuyenmai"]) . "đ" ?>
											</span>
											<del><?php echo number_format($row_product_sidebar["sanpham_gia"]) . "đ" ?></del>
										</div>
										<p><?php
											if ($row_product_sidebar["sanpham_soluong"] > 0) {
												echo 'Số lượng: ' . $row_product_sidebar['sanpham_soluong'];
											} else {
												echo "<h3 style='color: #FF0000;'>Hết hàng</h3>";
											}
											?></p><br>
										<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
											<form action="?quanly=giohang" method="post">
												<fieldset>
													<input type="hidden" name="tensanpham" value="<?php echo $row_product_sidebar['sanpham_name'] ?>" />
													<input type="hidden" name="sanpham_soluong" value="<?php echo $row_product_sidebar['sanpham_soluong'] ?>" />
													<input type="hidden" name="sanpham_id" value="<?php echo $row_product_sidebar['sanpham_id'] ?>" />
													<input type="hidden" name="giasanpham" value="<?php echo $row_product_sidebar['sanpham_gia'] ?>" />
													<input type="hidden" name="hinhanh" value="<?php echo $row_product_sidebar['sanpham_image'] ?>" />
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
					<!-- phân trang -->
					<!-- <style>
								ul.list_trang{
									padding: 0;
									margin: 0;
									list-style: none;
								}
								ul.list_trang li{
									float: left;
									padding: 5px 13px;
									margin: 5px;
									background: burlywood;
									display: block;
								}
								ul.list_trang li a{
									color: #000;
									text-align: center;
									text-decoration: none;
								}
							</style>
							<p>Trang:</p>
							<?php
							$sql_trang = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_hot = '0' ORDER BY sanpham_id DESC ");
							$row_count = mysqli_num_rows($sql_trang);
							$trang = ceil($row_count / 4);
							?>
							<ul class="list_trang">
							<?php
							for ($i = 1; $i <= $trang; $i++) {
							?>
							<li><a href="index.php?trang=<?php echo $i ?>"><?php echo $i ?></a></li>
							<?php
							}
							?> -->

					</ul>
				</div>

				<!-- //first section -->
				<!-- third section -->
				<!-- <div class="product-sec1 product-sec2 px-sm-5 px-3">
							<div class="row">
								<h3 class="col-md-4 effect-bg">Summer Carnival</h3>
								<p class="w3l-nut-middle">Get Extra 10% Off</p>
								<div class="col-md-8 bg-right-nut">
									<img src="images/image1.png" alt="">
								</div>
							</div>
						</div> -->
				<!-- //third section -->


			</div>
		</div>
		<!-- all sản phẩm -->
		<div class="container py-lg-4 py-lg-2">
			<!-- Sản phẩm bán chạy -->
			<div class="agileinfo-ads-display col-lg-12" style="background-color: #fff">
				<div class="wrapper">
					<!-- first section -->
					<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-3">
						<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Sản phẩm mới</h3>
						<!-- <h3 class="heading-tittle text-center font-italic"><?php echo $row_cate_home["category_name"] ?></h3> -->
						<div class="row">
							<?php
							$sql_product_all = mysqli_query($con, "SELECT * FROM tbl_sanpham  ORDER BY sanpham_id DESC LIMIT 8 ");
							while ($row_product_all = mysqli_fetch_array($sql_product_all)) {
							?>

								<div class="col-md-3 product-men mt-5">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="images/<?php echo $row_product_all["sanpham_image"] ?>" width="150" height="150" alt="">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="?quanly=chitietsp&id=<?php echo $row_product_all['sanpham_id'] ?>" class="link-product-add-cart">Xem chi tiết </a>
												</div>

											</div>
											<!-- <style>
												.product-new-top{
													background-color: #07882e;
												}
											</style> -->
											<span class="product-new-top">Mới</span>

										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href="?quanly=chitietsp&id=<?php echo $row_product_all['sanpham_id'] ?>"><?php echo $row_product_all['sanpham_name'] ?></a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price">
													<?php echo number_format($row_product_all["sanpham_giakhuyenmai"]) . "đ" ?>
												</span>
												<del><?php echo number_format($row_product_all["sanpham_gia"]) . "đ" ?></del>
											</div>
											<p><?php
												if ($row_product_all["sanpham_soluong"] > 0) {
													echo 'Số lượng: ' . $row_product_all['sanpham_soluong'];
												} else {
													echo "<h3 style='color: #FF0000;'>Hết hàng</h3>";
												}
												?></p><br>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="?quanly=giohang" method="post">
													<fieldset>
														<input type="hidden" name="tensanpham" value="<?php echo $row_product_all['sanpham_name'] ?>" />
														<input type="hidden" name="sanpham_soluong" value="<?php echo $row_product_all['sanpham_soluong'] ?>" />
														<input type="hidden" name="sanpham_id" value="<?php echo $row_product_all['sanpham_id'] ?>" />
														<input type="hidden" name="giasanpham" value="<?php echo $row_product_all['sanpham_gia'] ?>" />
														<input type="hidden" name="hinhanh" value="<?php echo $row_product_all['sanpham_image'] ?>" />
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
						<!-- phân trang -->
						<!-- <style>
								ul.list_trang{
									padding: 0;
									margin: 0;
									list-style: none;
								}
								ul.list_trang li{
									float: left;
									padding: 5px 13px;
									margin: 5px;
									background: burlywood;
									display: block;
								}
								ul.list_trang li a{
									color: #000;
									text-align: center;
									text-decoration: none;
								}
							</style>
							<p>Trang:</p>
							<?php
							$sql_trang = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_hot = '0' ORDER BY sanpham_id DESC ");
							$row_count = mysqli_num_rows($sql_trang);
							$trang = ceil($row_count / 4);
							?>
							<ul class="list_trang">
							<?php
							for ($i = 1; $i <= $trang; $i++) {
							?>
							<li><a href="index.php?trang=<?php echo $i ?>"><?php echo $i ?></a></li>
							<?php
							}
							?> -->

						</ul>
					</div>

					<!-- //first section -->
					<!-- third section -->
					<!-- <div class="product-sec1 product-sec2 px-sm-5 px-3">
							<div class="row">
								<h3 class="col-md-4 effect-bg">Summer Carnival</h3>
								<p class="w3l-nut-middle">Get Extra 10% Off</p>
								<div class="col-md-8 bg-right-nut">
									<img src="images/image1.png" alt="">
								</div>
							</div>
						</div> -->
					<!-- //third section -->


				</div>
			</div>
			<!-- all sản phẩm -->
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Danh mục sản phẩm</h3>
			<!-- //tittle heading -->
			<div class="row" style="background-color: #fff;">
				<!-- product left -->
				<div class="agileinfo-ads-display col-xl-9">
					<div class="wrapper">
						<?php
						$sql_cate_home = mysqli_query($con, "SELECT * FROM tbl_category ORDER BY category_id DESC");
						while ($row_cate_home = mysqli_fetch_array($sql_cate_home)) {
							$id_category = $row_cate_home["category_id"];
						?>
							<!-- first section -->
							<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
								<h3 class="heading-tittle text-center font-italic"><?php echo $row_cate_home["category_name"] ?></h3>
								<div class="row ">
									<?php
									$sql_product = mysqli_query($con, "SELECT * FROM tbl_sanpham ORDER BY sanpham_id DESC ");
									while ($row_sanpham = mysqli_fetch_array($sql_product)) {
										if ($row_sanpham["category_id"] == $id_category) {
									?>
											<div class="col-md-4 product-men mt-5">
												<div class="men-pro-item simpleCart_shelfItem">
													<div class="men-thumb-item text-center">
														<img src="images/<?php echo $row_sanpham["sanpham_image"] ?>" width="150" height="150" alt="">
														<div class="men-cart-pro">
															<div class="inner-men-cart-pro">
																<a href="?quanly=chitietsp&id=<?php echo $row_sanpham['sanpham_id'] ?>" class="link-product-add-cart">Xem chi tiết </a>
															</div>
														</div>

													</div>
													<div class="item-info-product text-center border-top mt-4">
														<h4 class="pt-1">
															<a href="?quanly=chitietsp&id=<?php echo $row_sanpham['sanpham_id'] ?>"><?php echo $row_sanpham['sanpham_name'] ?></a>
														</h4>
														<div class="info-product-price my-2">
															<span class="item_price">
																<?php echo number_format($row_sanpham["sanpham_giakhuyenmai"]) . "đ" ?>
															</span>
															<del><?php echo number_format($row_sanpham["sanpham_gia"]) . "đ" ?></del>
														</div>
														<p><?php
															if ($row_sanpham["sanpham_soluong"] > 0) {
																echo 'Số lượng: ' . $row_sanpham['sanpham_soluong'];
															} else {
																echo "<h3 style='color: #FF0000;'>Hết hàng</h3>";
															}
															?></p><br>
														<?php
														if ($row_sanpham["sanpham_soluong"] > 0) {
														?>
															<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
																<form action="?quanly=giohang" method="post">
																	<fieldset>
																		<input type="hidden" name="tensanpham" value="<?php echo $row_sanpham['sanpham_name'] ?>" />
																		<input type="hidden" name="sanpham_id" value="<?php echo $row_sanpham['sanpham_id'] ?>" />
																		<input type="hidden" name="giasanpham" value="<?php echo $row_sanpham['sanpham_gia'] ?>" />
																		<input type="hidden" name="hinhanh" value="<?php echo $row_sanpham['sanpham_image'] ?>" />
																		<input type="hidden" name="soluong" value="1" />

																		<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button" />
																	</fieldset>
																</form>
															</div>
														<?php } else { ?>
															<h3 class="product-new-top" style="color: #fff; font-weight: bold;">Hết Hàng</span>
															<?php }	?>
													</div>
												</div>
											</div>
									<?php
										}
									}
									?>
								</div><br>
								<!-- <a style="float: right;" href="?quanly=danhmuc&id=<?php echo $row_cate_home["category_id"] ?>">Xem tất cả sản phẩm</a> -->
							</div>
						<?php
						}
						?>
						<!-- //first section -->
						<!-- third section -->
						<!-- <div class="product-sec1 product-sec2 px-sm-5 px-3">
							<div class="row">
								<h3 class="col-md-4 effect-bg">Summer Carnival</h3>
								<p class="w3l-nut-middle">Get Extra 10% Off</p>
								<div class="col-md-8 bg-right-nut">
									<img src="images/image1.png" alt="">
								</div>
							</div>
						</div> -->
						<!-- //third section -->
					</div>
				</div>

				<!-- //product left -->

				<!-- product right -->
				<div class="col-xl-3 mt-xl-0 mt-4 p-xl-0">
					<div class="side-bar p-sm-4 p-3">

						<!-- best seller -->
						<div class="f-grid py-2">
							<h3 class="agileits-sear-head mb-3">Sản phẩm mới</h3>
							<div class="box-scroll">
								<div class="scroll">
									<?php
									$sql_product_sidebar_new = mysqli_query($con, "SELECT * FROM tbl_sanpham  ORDER BY sanpham_id DESC LIMIT 8");
									while ($row_product_sidebar_new = mysqli_fetch_array($sql_product_sidebar_new)) {
									?>
										<div class="row">
											<div class="col-lg-3 col-sm-2 col-3 left-mar">
												<img src="images/<?php echo $row_product_sidebar_new["sanpham_image"] ?>" alt="" class="img-fluid">
											</div>
											<div class="col-lg-9 col-sm-10 col-9 w3_mvd">
												<a href=""><?php echo $row_product_sidebar_new["sanpham_name"] ?></a>
												<a href="" class="price-mar mt-2"><?php echo number_format($row_product_sidebar_new["sanpham_giakhuyenmai"]) . "đ" ?></a>
												<del><?php echo number_format($row_product_sidebar_new["sanpham_gia"]) . "đ" ?></del>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
						<!-- //best seller -->

						<div class="search-hotel border-bottom py-2">

							<form class="form-inline" action="index.php?quanly=timkiem" method="post">
								<button class="btn my-2 my-sm-0" name="search_button" type="submit">Tìm kiếm</button><br>
								<input class="form-control mr-sm-2" name="search_product" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search" required>

							</form><br>
						</div>



						<!-- electronics -->
						<div class="left-side border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">Danh mục sản phẩm</h3>
							<ul>
								<?php
								$sql_category_sidebar = mysqli_query($con, 'SELECT * FROM tbl_category ORDER BY category_id DESC');
								while ($row_category_sidebar = mysqli_fetch_array($sql_category_sidebar)) {
								?>
									<li>
										<span class="span">
											<a href="?quanly=danhmuc&id=<?php echo $row_category_sidebar['category_id'] ?>"><?php echo $row_category_sidebar["category_name"] ?></a>
										</span>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
						<!-- //delivery -->

						<!-- best seller -->
						<div class="f-grid py-2">
							<h3 class="agileits-sear-head mb-3">Sản phẩm bán chạy</h3>
							<div class="box-scroll">
								<div class="scroll">
									<?php
									$sql_product_sidebar = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_hot = '0' ORDER BY sanpham_id DESC");
									while ($row_product_sidebar = mysqli_fetch_array($sql_product_sidebar)) {
									?>
										<div class="row">
											<div class="col-lg-3 col-sm-2 col-3 left-mar">
												<img src="images/<?php echo $row_product_sidebar["sanpham_image"] ?>" alt="" class="img-fluid">
											</div>
											<div class="col-lg-9 col-sm-10 col-9 w3_mvd">
												<a href=""><?php echo $row_product_sidebar["sanpham_name"] ?></a>
												<a href="" class="price-mar mt-2"><?php echo number_format($row_product_sidebar["sanpham_giakhuyenmai"]) . "đ" ?></a>
												<del><?php echo number_format($row_product_sidebar["sanpham_gia"]) . "đ" ?></del>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
						<!-- //best seller -->
					</div>
					<!-- //product right -->
				</div>
			</div>
		</div>
	</div>
	<!-- //top products -->