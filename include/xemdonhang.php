<?php
    if(isset($_GET['huydon']) && isset($_GET['magiaodich'])){
        $huydon = $_GET['huydon'];
        $magiaodich = $_GET['magiaodich'];
    }else{
        $huydon = '';
        $magiaodich = '';
    }
    $sql_update_donhang = mysqli_query($con,"UPDATE tbl_donhang SET huydon='$huydon' WHERE madonhang='$magiaodich'");
    $sql_update_giaodich = mysqli_query($con,"UPDATE tbl_giaodich SET huydon='$huydon' WHERE magiaodich='$magiaodich'");
?>
<!-- top Products -->
<div class="ads-grid py-sm-5 py-4" >
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<!-- <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Xem đơn hàng</h3> -->
			<!-- //tittle heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-12">
					<div class="wrapper">
						<!-- first section -->
					
							<div class="row">
								<?php
								if(isset($_SESSION['dangnhap_home'])){
                                    echo 'Đơn hàng của: '. $_SESSION['dangnhap_home'];
                                }
								?>
								
								<div class="col-md-12">
                                    <h4 style="text-align:center;">Các đơn hàng đã đặt</h4><br>
                                    <?php
                                    if(isset($_GET['khachhang'])){
                                        $id_khachhang = $_GET['khachhang'];
                                    }else{
                                        $id_khachhang='';
                                    }
                                        $sql_select = mysqli_query($con,"SELECT * FROM tbl_giaodich WHERE tbl_giaodich.khachhang_id='$id_khachhang' GROUP BY tbl_giaodich.magiaodich "); //ORDER BY tbl_giaodich.ngaythang DESC sau group by
                                    ?>
                                    <table class="table table-reponsive table-bordered">
                                        <tr style="text-align:center ;">
                                            <th>Thứ tự</th>
                                            <th>Mã giao dịch</th>

                                            <th>Ngày đặt hàng</th>
                                            <th>Tình trạng</th>
                                            
                                            <th>Quản lý</th>
                                            <th>Hủy đơn</th>

                                        </tr>
                                        <?php
                                            $i = 0;
                                            while($row_donhang = mysqli_fetch_array($sql_select)){
                                                $i++;
                                        ?>
                                        <tr style="text-align:center ;">
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row_donhang['magiaodich']?></td>
                    
                                            
                                            <td><?php echo $row_donhang['ngaythang']?></td>
                                            <td> <?php
                                            if($row_donhang['tinhtrangdon']==0){
                                                echo 'Đang xử lý...';
                                            }else{
                                                echo 'Đã xử lý | Đang giao hàng';
                                            }
                                            ?></td>

                                            <td><a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id']?>&magiaodich=<?php echo $row_donhang['magiaodich'] ?>">Xem chi tiết đơn hàng</a></td>
                                           
                                            <td>
                                                <?php
                                                    if($row_donhang['huydon']==0){
                                                ?>
                                                    <a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id']?>&magiaodich=<?php echo $row_donhang['magiaodich'] ?>&huydon=1">Yêu cầu hủy đơn</a>
                                                <?php
                                                    }elseif($row_donhang['huydon']==1){
                                                ?>
                                                <p>Đang chờ hủy đơn...</p>
                                                <?php
                                                }else{
                                                    echo 'Đã hủy đơn hàng';
                                                }
                                                ?>   
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                                <!-- Xem chi tiết đơn hàng -->
                                <div class="col-md-12">
                                    <h4 style="text-align:center;">Chi tiết đơn hàng</h4><br>
                                    <?php
                                    if(isset($_GET['magiaodich'])){
                                        $magiaodich = $_GET['magiaodich'];
                                    }else{
                                        $magiaodich='';
                                    }
                                        $sql_select = mysqli_query($con,"SELECT * FROM tbl_giaodich,tbl_khachhang,tbl_sanpham WHERE tbl_giaodich.sanpham_id=tbl_sanpham.sanpham_id 
                                                    AND tbl_khachhang.khachhang_id=tbl_giaodich.khachhang_id AND tbl_giaodich.magiaodich='$magiaodich' ORDER BY tbl_giaodich.giaodich_id DESC"); 
                                    ?>
                                    <table class="table table-reponsive table-bordered">
                                        <tr style="text-align:center ;">
                                            <th>Thứ tự</th>
                                            <th>Họ tên</th>
                                            <th>Địa chỉ</th>

                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá</th>
                                            <!-- <th>Tổng tiền</th> -->
                                            <th>Ngày đặt hàng</th>
                                            

                                            <th>Ghi chú</th>
                                        </tr>
                                        <?php
                                            $i = 0;
                                            while($row_donhang = mysqli_fetch_array($sql_select)){
                                                $i++;
                                        ?>
                                        <tr style="text-align:center ;">
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row_donhang['name']?></td>
                                            <td><?php echo $row_donhang['address']?></td>
                    
                                            <td><?php echo $row_donhang['sanpham_name']?></td>
                                            <td><?php echo $row_donhang['soluong']?></td>
                                            <td><?php echo number_format( $row_donhang['sanpham_giakhuyenmai']).'vnđ'?></td>
                                            <!-- <td><?php echo number_format($row_donhang['soluong'] * $row_donhang['sanpham_giakhuyenmai']).'vnđ'?></td> -->
                                            <td><?php echo $row_donhang['ngaythang']?></td>
                                            <td><?php echo $row_donhang['note']?></td>
                                            
                                        
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
								
							</div>
					
						<!-- //first section -->
						
					</div>
				</div>
			</div>
		</div>
</div>
	<!-- //top products -->