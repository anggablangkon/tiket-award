<?php
include 'db.php';
if (isset($_GET['invoice'])) {
$invoice = $_GET['invoice'];
$query = mysqli_query($connect, "select * from mticket where invoice='$invoice' and paidstatus='0' and isdelete='0'");
$datatransfer = mysqli_fetch_array($query);
$cdate = $datatransfer['cdate'];

$query = mysqli_query($connect, "select price, startdate, enddate, isdelete from mticketprice where isdelete = 0 and date_format(startdate, '%Y-%m-%d') 
					<= date_format('$cdate','%Y-%m-%d')	and date_format(enddate, '%Y-%m-%d') >= date_format('$cdate','%Y-%m-%d')");

$dataharga = mysqli_fetch_array($query);
$male = $datatransfer['male'];
$female = $datatransfer['female'];
$total = $datatransfer['male'] + $datatransfer['female'];
$totharga = number_format($dataharga['price'] * $total+5);

$data = array(
            'nama'      =>  $datatransfer['nama'],
            'jmltiket'   =>  $total,
            'male' => $male,
            'female' => $female,
            'total'    =>  $totharga,);
 echo json_encode($data);
}

if (isset($_GET['tiket'])) {
	$tiket = $_GET['tiket'];
	$query = mysqli_query($connect, "select * from mdetailtiket where tiket = '$tiket' and print = '0' and isdelete='0'") or die(mysqli_error($connect));
	$data = mysqli_fetch_array($query);
	$query = mysqli_num_rows($query);
	if ($query > 0) {
		$message = 'Tiket Tersedia';
	}else{
		$message = 'Tiket Tidak Tersedia Mohon Cek Code Tiket Anda';
	}

	$data = array(
		'pesan' => $message );
	echo json_encode($data);
}
?>