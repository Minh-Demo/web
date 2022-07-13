<?php
require('../tfpdf/tfpdf.php');
require('../db/connect.php');

$pdf = new tFPDF();
$pdf->AddPage(0);
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->SetFont('DejaVu', '', 14);


    // tru vấn
    $madonhang = $_GET['madonhang'];
    $sql_select = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                    AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");
    $sql_tt = mysqli_query($con, "SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id
                    AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id AND tbl_donhang.madonhang = '$madonhang'");

// container
$row1 = mysqli_fetch_array($sql_tt);
$pdf->Write(20, 'Thông tin hóa đơn', 'C');
$pdf->Ln(20);
$pdf->Write(10, 'Mã đơn hàng: ');
$pdf->Write(10, $row1['madonhang']);
$pdf->Write(10, '    Tên khách hàng: ');
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
$i = 0;
$sum = 0;
while ($row = mysqli_fetch_array($sql_select)) {
    $thanhtien = $row['soluong'] * $row['sanpham_giakhuyenmai'];
    // cộng dồn tiền sản phẩm
    $sum += $thanhtien;
    $i++;
    $pdf->Write(10, $i . ',');
    $pdf->Write(10, 'Tên sản phẩm: ');
    $pdf->Write(10, $row['sanpham_name']);
    $pdf->Ln(10);
    $pdf->Write(10, '    Số lượng: ');
    $pdf->Write(10, $row['soluong']);
    $pdf->Ln(10);
    $pdf->Write(10, '    Giá: ');
    $pdf->Write(10, number_format($row['sanpham_giakhuyenmai']) . 'vnđ');
    $pdf->Ln(10);
}
$pdf->Write(10, 'Tổng phải thanh toán: ');
$pdf->Write(10, number_format($sum) . 'vnđ');
$pdf->Ln(10);
$pdf->Write(10, 'Cảm ơn bạn đã đặt hàng tại website của chúng tôi.');
$pdf->Ln(10);
// container
$pdf->Output();
