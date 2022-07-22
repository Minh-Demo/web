<?php
session_start();

use Carbon\Carbon;
use Carbon\CarbonInterval;

require('../carbon/autoload.php'); //gọi hàm carbon

if (!isset($_SESSION['dangnhap'])) {
  header('Location:index.php');
}
// đăng xuất
if (isset($_GET['login'])) {
  $dangxuat = $_GET['login'];
} else {
  $dangxuat = '';
}
if ($dangxuat == 'dangxuat') {
  session_destroy();
  header('Location:index.php');
}
?>
<?php
include('../db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WELCOME ADMIN</title>
  <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <link rel="stylesheet" type="text/css" href="../css/main1.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
</head>

<body>

  <h4 style="text-align:center;">Xin chào <?php echo $_SESSION['dangnhap'] ?> <a href="?login=dangxuat">Đăng xuất</a></h4>
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
  </nav>
  <!-- /navbar -->
  <?php
  $now = Carbon::now()->toDateString();

  $sql_thongke = "SELECT * FROM tbl_thongke WHERE ngaydat='" . $now . "'"; //chọn thống ke dựa vào ngày dat
  $query_thongke = mysqli_query($con, $sql_thongke); //truy vấn
  $row = mysqli_fetch_array($query_thongke);

  ?>


  <!-- Thống kê chi tiết -->
  <?php
  if (mysqli_num_rows($query_thongke) != 0) {
  ?>
    <div class="col-md-12 col-lg-12">
      <div class="row">
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small primary coloured-icon"><i class='icon bx  bxs-shopping-bags fa-3x'></i>
            <div class="info">
              <h4>Tổng đơn hàng </h4>
              <p><b><?php echo $row['donhang'] ?> đơn hàng</b></p>
              <p class="info-tong">Tổng số đơn hàng được bán ra trong ngày.</p>
            </div>
          </div>
        </div>
        <!-- col-6 -->
        
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small warning coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
            <div class="info">
              <h4>Doanh thu</h4>
              <p><b><?php echo number_format($row['doanhthu']) . ' vnđ' ?> </b></p>
              <p class="info-tong">Tổng doanh thu trong ngày.</p>
            </div>
          </div>
        </div>
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
            <div class="info">
              <h4>Lợi nhuận</h4>
              <p><b><?php echo number_format(($row['doanhthu'])-($row['nhaphang'])) . ' vnđ' ?> </b></p>
              <p class="info-tong">Lợi nhuận trong ngày.</p>
            </div>
          </div>
        </div>
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
            <div class="info">
              <h4>Tiền nhập hàng</h4>
              <p><b><?php echo number_format($row['nhaphang']) . ' vnđ' ?> </b></p>
              <p class="info-tong">Tổng tiền nhập các sản phẩm đã bán trong ngày.</p>
            </div>
          </div>
        </div>

      </div>
    </div><?php
        } else {
          ?><div class="col-md-12 col-lg-12">
      <div class="row">
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small primary coloured-icon"><i class='icon bx  bxs-shopping-bags fa-3x'></i>
            <div class="info">
              <h4>Tổng đơn hàng </h4>
              <p><b>0 đơn hàng</b></p>
              <p class="info-tong">Tổng số đơn hàng trong ngày.</p>
            </div>
          </div>
        </div>
       
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small warning coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
            <div class="info">
              <h4>Doanh thu</h4>
              <p><b> 0 </b></p>
              <p class="info-tong">Tổng doanh thu trong ngày.</p>
            </div>
          </div>
        </div>
         <!-- col-6 -->
         <div class="col-md-3">
          <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
            <div class="info">
              <h4>Lợi nhuận</h4>
              <p><b>0</b></p>
              <p class="info-tong">Lợi nhuận trong ngày.</p>
            </div>
          </div>
        </div>
        <!-- col-6 -->
        <div class="col-md-3">
          <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
            <div class="info">
              <h4>Tiền nhập hàng</h4>
              <p><b> 0 </b></p>
              <p class="info-tong">Tổng tiền nhập các sản phẩm đã bán trong ngày.</p>
            </div>
          </div>
        </div>
      </div>
    <?php
        }
    ?>
    <!-- hết thống kê chi tiết -->
    <!-- Biểu đồ -->

    <div class="container" style="background-image: linear-gradient(#99CCFF	, #EEEEEE);">
      <h3 style="padding-top: 15px; padding-bottom: 5px;">Biểu đồ thống kê chi tiết</h3>
      <!-- off => input text không tự điền -->
      <form autocomplete="off">
        <div class="row">
          <!-- Từ ngày đến ngàyyy -->
          <div class="col-md-3">
            <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
            <input type="button" id="btn-dashboard-filter" class="btn btn-primary" value="Lọc kết quả">
          </div>
          <div class="col-md-3">
            <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>

          </div>
          <!-- Lọc theo ngày -->
          <div class="col-md-3">
            <p>Lọc theo:
              <select class="custom-select select-thongke" id="inputGroupSelect01">
                <option value="365ngay">365 ngày qua</option>
                <option value="3ngay">3 ngày qua</option>
                <option value="7ngay">7 ngày qua</option>
                <option value="28ngay">28 ngày qua</option>
                <option value="90ngay">90 ngày qua</option>
              </select>
            </p>
          </div>
        </div>
      </form>
      <!-- hiển thị biểu đồ -->
      <div id="myfirstchart" style="height: 250px;"></div>
    </div><br><br>

    <!-- heder -->
    <!-- bảng đơn hàng hôm nay -->
    <div class="container">
      <h4 style="text-align:center;">Các đơn hàng đã đặt trong ngày</h4>
      <?php
      $now_1 = Carbon::now()->toDateString();

      $sql_tk_donhang = "SELECT * FROM tbl_donhang WHERE ngaydathang LIKE '%$now_1%' GROUP BY madonhang"; //chọn thống ke dựa vào ngày dat
      $query_tk = mysqli_query($con, $sql_tk_donhang); //truy vấn



      ?>
      <table class="table table-reponsive table-bordered">
        <tr style="text-align:center ;">
          <th>Thứ tự</th>
          <th>Mã đơn hàng</th>
          <th>Tình trạng đơn</th>

          <th>Ngày đặt hàng</th>
          <th>Hủy đơn</th>
          <th>Quản lý</th>
        </tr>
        <?php
        $i = 0;
        while ($row_tk = mysqli_fetch_array($query_tk)) {
          $i++;
        ?>
          <tr style="text-align:center ;">
            <td><?php echo $i ?></td>
            <td><?php echo $row_tk['madonhang'] ?></td>
            <td><?php
                if ($row_tk['tinhtrang'] == 0) {
                  echo 'Chưa xử lý';
                } else {
                  echo 'Đã xử lý';
                }
                ?></td>

            <td><?php echo $row_tk['ngaydathang'] ?></td>
            <td><?php
                if ($row_tk['huydon'] == 0) {
                } elseif ($row_tk['huydon'] == 1) {
                  echo '<a href = "xulydonhang.php?quanly=xemdonhang&madonhang=' . $row_tk['madonhang'] . '&xacnhanhuy=2">Xác nhận hủy đơn</a>';
                } else {
                  echo 'Đã hủy';
                }
                // <a href="xulydonhang.php?quanly=xemdonhang&madonhang='.$row_donhang["madonhang"].'&xacnhanhuy=2"Xác nhận hủy đơn</a>
                ?></td>

            <td>
              <a href="xulydonhang.php?quanly=xemdonhang&madonhang=<?php echo $row_tk['madonhang'] ?>">Xem chi tiết đơn hàng</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </table>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <!--function hiển thị input text datepicker  -->
    <script>
      $(function() {
        $("#datepicker").datepicker({
          dateFormat: 'yy-mm-dd'
        });
        $("#datepicker2").datepicker({
          dateFormat: 'yy-mm-dd'
        });
      });
    </script>
    <!-- End -->

    <script type="text/javascript">
      $(document).ready(function() {
        thongke();
        var char = new Morris.Bar({ //biêu đồ thống ke
          parseTime: false,
          hideHover: 'auto',
          // ID of the element in which to draw the chart.
          element: 'myfirstchart',
          lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766B56', '#766B56'], //màu đường link hoặc cột
          // Chart data records -- each entry in this array corresponds to a point on
          // the chart.

          xkey: 'date',
          ykeys: ['order', 'sales', 'tiennhap', 'quantity'], //các cột tiêu đề
          labels: ['đơn hàng', 'doanh thu', 'Tiền nhập hàng', 'số lượng bán ra'] //các cột giá trị

        });
        // Lọc từ ngày---đến ngày click vào nút lọc kq
        $('#btn-dashboard-filter').click(function() {
          var _token = $('input[name="_token"]').val();
          // biến dựa vào id 'datepicker' từ ngày đến ngàyy
          var from_date = $('#datepicker').val();
          var to_date = $('#datepicker2').val();

          $.ajax({
            url: "thongke1.php", //gửi dữ liệu trang thống kê
            method: "POST",
            dataType: "JSON", //trả về kiểu JSON
            // data từ ngày đến ngày
            data: {
              from_date: from_date,
              to_date: to_date,
              _token: _token
            },
            success: function(data) {
              char.setData(data); //đổ dữ liệu vào biểu đồ
            }
          });

        });
        // nhấn nút thống kê theo nagf
        $('.select-thongke').change(function() {

          // lấy value từ class select-thongke trên form
          var thoigian = $(this).val();
          if (thoigian == '3ngay') { //thời gian theo ngày 
            var text = '3 ngày qua';
          } else if (thoigian == '7ngay') {
            var text = '7 ngày qua';
          } else if (thoigian == '28ngay') {
            var text = '28 ngày qua';
          } else if (thoigian == '90ngay') {
            var text = '90 ngày qua';
          } else {
            var text = '365 ngày qua';
          }
          $.ajax({
            url: "thongke.php", //gửi dữ liệu trang thống kê
            method: "POST",
            dataType: "JSON", //trả về kiểu JSON
            data: {
              thoigian: thoigian
            },
            success: function(data) {
              char.setData(data); //đổ dữ liệu vào biểu đồ
              $('#text-date').text(text);
            }
          });
        })

        function thongke() {
          var text = '365 ngày qua'; //mặc định dữ liệu thống kê theo 365 ngày
          $.ajax({
            url: "thongke.php",
            method: "POST",
            dataType: "JSON",

            success: function(data) {
              char.setData(data);
              $('#text-date').text(text);
            }
          });
        }
      })
    </script>

</body>

</html>