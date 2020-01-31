<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$date2 = date('m-Y', strtotime('-1 months'));
$date1 = date('d-m-Y');

echo "<h1>Console Monitoring data realisasi masuk antara 15-$date2 s/d $date1</h1>";
?>
<table border=1>
    <tr>
        <th>Nama Cabang</th>
        <th>Jumlah Data Masuk</th>
    </tr>
    <?php 
    foreach ($jum as $key => $val) {
        echo "<tr>
                <td>".$val->BRANCH_NAME."</td>
                <td>".$val->MA."</td>
            </tr>";
    }
    ?>
</table>
<br>
<table width = "100%" border=1>
<tr>
    <th>No</th>
    <th >Cabang</th>
    <th width="30%">Judul inv</th>
    <th width="20%">Judul sub</th>
    <th>bulan</th>
    <th>Di Buat</th>
    <th>Di Hapus</th>
</tr>
<?php
foreach ($dat as $key => $value) {

    //echo $value->BRANCH_NAME;	$value->RKAP_INVS_TITLE;	$value->RKAP_SUBPRO_TITTLE;	$value->M;	$value->CREATED_AT;	$value->IS_DELETED;
    
    echo "
        <tr>
            <td>".$key."</td>
            <td>".$value->BRANCH_NAME."</td>
            <td>".$value->RKAP_INVS_TITLE."</td>
            <td>".$value->RKAP_SUBPRO_TITTLE."</td>
            <td>".$value->M."</td>
            <td>".$value->CREATED_AT."</td>
            <td>".$value->IS_DELETED."</td>
        </tr>
    ";
}
?>
</table>    
</body>
</html>

