<?php
include 'db.php';
if (isset($_GET['tiket'])) {
$tiket = $_GET['tiket'];

$query = mysqli_query($connect, "select tb1.telp, tb2.tiket from mticket tb1 left join mdetailtiket tb2 on tb1.invoice = tb2.invoice where tb2.tiket='$tiket' and tb1.isdelete='0' and tb2.print is null and tb1.status='1' and tb1.paidstatus='1'")or die(mysqli_error($connect));
$cektelp = mysqli_num_rows($query);
if ($cektelp > 0) {
    $sql = mysqli_query($connect, "select tb1.tiket, tb1.tiketdetail, tb2.nama, (tb2.male + tb2.female) as totaltiket from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb1.tiket = '$tiket'")or die(mysqli_error($connect));
    $message = 'sukses';
    $tiketdetail = mysqli_fetch_array($sql);
    $tiket = $tiketdetail['tiket'];
    $name = $tiketdetail['nama'];
    $totaltiket = $tiketdetail['totaltiket'];
}else{
    $query = mysqli_query($connect, "select * from mticket tb1 left join mdetailtiket tb2 on tb2.invoice = tb1.invoice where keyqrcode = '$tiket' and paidstatus='1' and status='1' and tb1.isdelete='0' and tb2.print is null")or die(mysqli_error($connect));
    $cekqrcode = mysqli_num_rows($query);
    if ($cekqrcode > 0) {
        $sql = mysqli_query($connect, "select tb1.tiket, tb1.tiketdetail, tb2.nama, (tb2.male + tb2.female) as totaltiket from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb2.keyqrcode = '$tiket'")or die(mysqli_error($connect));
        $tiketdetail = mysqli_fetch_array($sql);
        $tiket = $tiketdetail['tiket'];
        $name = $tiketdetail['nama'];
        $totaltiket = $tiketdetail['totaltiket'];
        $message = 'sukses';
    }else{
        $tiket = '';
    	$name = '';
    	$totaltiket = '';
        $sql = '0';
        $message = 'gagal';
    }
}
$data = array(
    'tiket' => $tiket,
	'nama' => $name,
	'total' => $totaltiket,
	'status' => $message);
    echo json_encode($data);
}
?>