<?php
require('../tfpdf/tfpdf.php');
require('../db/connect.php');

// tru vấn
$madonhang = $_GET['madonhang'];
$sql_select = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                    AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");
$sql_tt = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                    AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");

$row1 = mysqli_fetch_array($sql_tt);


$pdf = new tFPDF();
$pdf->AddPage();
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
// container
$pdf->SetFont('DejaVu', '',18);
// Cell (width, height, text, border, endline)
$pdf->Cell(100 ,5,'   Điện máy Store',0,0);
$pdf->Cell(59 ,5,'Hóa đơn thanh toán',0,1); //hết dòng

$pdf->SetFont('DejaVu', '', 10);
$pdf->Cell(100 ,7,'Địa chỉ: Cổ Nhuế - Bắc Từ Liêm - Hà Nội',0,0);
$pdf->Cell(59 ,5,'',0,1); //hết dòng
$pdf->Cell(100 ,7,'     Điện thoại: 001 234 5678',0,0);
$pdf->Cell(70 ,5,'Hà Nội, Ngày......Tháng......Năm.........',0,1); //hết dòng
$pdf->Cell(100 ,7,'         Fax: 001 234 5678',0,0);
$pdf->Cell(59 ,5,'',0,1); //hết dòng

$pdf->SetFont('DejaVu', '', 14);
$pdf->Ln(7);
$pdf->Write(10, 'Mã đơn hàng: ');
$pdf->Write(10, $row1['madonhang']);
$pdf->Write(10, '                   Tên khách hàng: ');
$pdf->Write(10, $row1['name']);
$pdf->Ln(10);
$pdf->Write(10, 'Địa chỉ: ');
$pdf->Write(10, $row1['address']);
$pdf->Ln(10);
$pdf->Write(10, 'Số điện thoại :');
$pdf->Write(10, $row1['phone']);
$pdf->Ln(10);

$pdf->Write(10, 'Các sản phẩm đã đặt :');
$pdf->Ln(10);
$pdf->SetFont('DejaVu', '', 12);

$pdf->Cell(10 ,5,'STT',1,0,'C');
$pdf->Cell(120 ,5,'Tên sản phẩm',1,0,'C');
$pdf->Cell(25 ,5,'Số lượng',1,0);

$pdf->Cell(35 ,5,'Giá ',1,1);
$i = 0;
$sum = 0;
while ($row = mysqli_fetch_array($sql_select)) {
    $thanhtien = $row['soluong'] * $row['sanpham_giakhuyenmai'];
    // cộng dồn tiền sản phẩm
    $sum += $thanhtien;
    $i++;
    $pdf->Cell(10 ,5,$i,1,0,'C');
    $pdf->Cell(120 ,5,$row['sanpham_name'],1,0,);
    $pdf->Cell(25 ,5,$row['soluong'],1,0);
    $pdf->Cell(35 ,5,number_format($row['sanpham_giakhuyenmai']) . 'vnđ',1,1);


    // $pdf->Write(10, $i . ',');
    // $pdf->Write(10, 'Tên sản phẩm: ');
    // $pdf->Write(10, $row['sanpham_name']);
    // $pdf->Ln(10);
    // $pdf->Write(10, '    Số lượng: ');
    // $pdf->Write(10, $row['soluong']);
    // $pdf->Ln(10);
    // $pdf->Write(10, '    Giá: ');
    // $pdf->Write(10, number_format($row['sanpham_giakhuyenmai']) . 'vnđ');

}
$pdf->Write(10, 'Ngày đặt hàng: ');
$pdf->Write(10, $row1['ngaydathang']);
$pdf->Ln(10);
$pdf->Write(10, 'Tổng phải thanh toán: ');
$pdf->Write(10, number_format($sum) . 'vnđ');
$pdf->Ln(10);
$pdf->Write(10, 'Cảm ơn bạn đã đặt hàng tại website của chúng tôi.');
$pdf->Ln(10);


// container
$pdf->Output();
