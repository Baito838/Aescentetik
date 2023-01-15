<?php
include_once 'config.php';
$product = query("SELECT * FROM penjualan");
date_default_timezone_set('Asia/Jakarta');

$result = mysqli_query($conn, 'SELECT SUM(total) AS sum_total FROM penjualan'); 
$total = mysqli_fetch_assoc($result);
$sum_total = $total['sum_total'];

$jumlah_lilin = mysqli_query($conn, 'SELECT SUM(jumlah) AS sum_jumlah FROM penjualan'); 
$jumlah = mysqli_fetch_assoc($jumlah_lilin);
$sum_jumlah = $jumlah['sum_jumlah'];

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
</head>
<body>
    <h1 align="center"> Laporan Data Penjualan </h1>
    <div>
    <p>Tanggal : '. date('Y-m-d') .' </p>
    <p>Waktu :  '. hari_ini() . ', ' . date("g:i a") .'</p>
    </div>
    <table align="center" border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td align="center">No</td>
                    <td align="center">Tanggal</td>
                    <td align="center">Nama</td>
                    <td align="center">No Telfon</td>
                    <td align="center">Produk</td>
                    <td align="center">Jumlah</td>
                    <td align="center">Total</td>
                </tr>';
    $i = 1;
    foreach($product as $row){
        $html .= '  
                <tr>
                    <td>'.$i++.'</td>
                    <td>'. tgl_indo(date('Y-m-d', strtotime($row["tanggal"]))) .'</td>
                    <td>'. $row["nama"] .'</td>
                    <td align="center">'. $row["nomer_telfon"].'</td>
                    <td align="center">'. $row["produk"].'</td>
                    <td align="center">'. $row["jumlah"].'</td>
                    <td align="center">'. $row["total"].'</td>
                </tr>
            ';
    }

    $html .= '
                    <tr>
                        <td align="right" colspan="5">Total Lilin Terjual</td>
                        <td align="center" colspan="2">'. $sum_jumlah .' </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="5">Total Seluruh Pendapatan</td>
                        <td align="center" colspan="2">'. "Rp. ".number_format($sum_total, 0 ,".",".") .' </td>
                    </tr>
        ';
$html .=    
    '</table>
</body>
</html>

';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>
