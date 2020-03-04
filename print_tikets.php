<?php
include 'db.php';
if (isset($_GET['tiket'])) {
$tiket = $_GET['tiket'];
$mdate = date('Y-m-d H:i:s');
$query = mysqli_query($connect, "select tb2.tiket from mticket tb1 left join mdetailtiket tb2 on tb1.invoice = tb2.invoice where tb2.tiket='$tiket' and tb1.isdelete='0' and tb2.print is null and tb1.status='1' and tb1.paidstatus='1'")or die(mysqli_error($connect));
$cektelp = mysqli_num_rows($query);
if ($cektelp > 0) {
    $sql = mysqli_query($connect, "select tb1.tiket, tb1.tiketdetail, tb2.nama, (tb2.male + tb2.female) as totaltiket from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb1.tiket = '$tiket'")or die(mysqli_error($connect));
    // $print = mysqli_query($connect, "update mdetailtiket set print = '1', mdate='$mdate' where tiket = '$tiket'")or die(mysqli_error($connect));
    $detailtiket = mysqli_fetch_array($sql);
    $message['status'] = 'sukses';
    $message['nama'] = $detailtiket['nama'];
    $message['total'] = $detailtiket['totaltiket'];
}else{
    $query = mysqli_query($connect, "select * from mticket tb1 left join mdetailtiket tb2 on tb2.invoice = tb1.invoice where keyqrcode = '$tiket' and paidstatus='1' and status='1' and tb1.isdelete='0' and tb2.print is null")or die(mysqli_error($connect));
    $cekqrcode = mysqli_num_rows($query);
    if ($cekqrcode > 0) {
        $sql = mysqli_query($connect, "select tb1.tiket, tb1.tiketdetail, tb2.nama, (tb2.male + tb2.female) as totaltiket from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb2.keyqrcode = '$tiket'")or die(mysqli_error($connect));
        $qrtiket = mysqli_fetch_array($sql);
        $tiketqr = $qrtiket['tiket'];
        // $print = mysqli_query($connect, "update mdetailtiket set print = '1', mdate='$mdate' where tiket = '$tiketqr' ")or die(mysqli_error($connect));
        $message['status'] = 'sukses';
        $message['nama'] = $qrtiket['nama'];
        $message['total'] = $qrtiket['totaltiket'];
    }else{
      $message['status'] = 'gagal';
    }
}
  echo json_encode($message);
}  ?>
