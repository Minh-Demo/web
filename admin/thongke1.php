<?php
	use Carbon\Carbon;
    use Carbon\CarbonInterval;
    include('../db/connect.php'); //connect db
    require('../carbon/autoload.php'); //sử dụng carbon lấy ra thứ ngày tháng
    if(isset($_POST['from_date'])){
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
    }

    $sql = "SELECT * FROM tbl_thongke WHERE ngaydat BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY ngaydat ASC" ; //lấy dử liệu giữa ngày hiện tại và ngày cách đó 7 28 90 365

    $sql_query = mysqli_query($con,$sql); //truy vấn
    $count = mysqli_num_rows($sql_query);
    if($count>0){
        while($val = mysqli_fetch_array($sql_query)){ //dữ liệu là mảng gồm các phần tử phái dưới
            $chart_data[] = array(
                'date' => $val['ngaydat'],
                'order' => $val['donhang'],
                'sales' => $val['doanhthu'],
                'tiennhap' => $val['nhaphang'],
                'quantity' => $val['soluongban']

            );
        }
    }else{
        $chart_data[] = array(
                'date' => '',
                'order' => '',
                'sales' => '',
                'tiennhap' =>'',
                'quantity' => ''

            );
    }
    
  	// print_r($chart_data);
     
    echo $data = json_encode($chart_data); //echo dữ liệu dạng JSON
   
?>