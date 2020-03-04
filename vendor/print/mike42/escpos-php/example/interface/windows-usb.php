<?php
/* Change to the correct path if you copy this example! */
require __DIR__ . '/../../../../autoload.php';
include '../../../../../../db.php';
use Mike42\Escpos\Printer;
#use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

if (isset($_GET['telp'])) {
$telp = $_GET['telp'];
$tiket = $_GET['tiket'];

$query = mysqli_query($connect, "select tb1.telp, tb2.tiket from mticket tb1 left join mdetailtiket tb2 on tb1.invoice = tb2.invoice where tb1.telp = '$telp' and tb2.tiket='$tiket' and tb1.isdelete='0' and tb2.print is null and tb1.status='1' and tb1.paidstatus='1'")or die(mysqli_error($connect));
$cektelp = mysqli_num_rows($query);
if ($cektelp > 0) {
    $sql = mysqli_query($connect, "select tb1.tiketdetail, tb2.nama from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb1.tiket = '$tiket'")or die(mysqli_error($connect));
    $print = mysqli_query($connect, "update mdetailtiket set print = '1' where tiket = '$tiket'")or die(mysqli_error($connect));
    $message['status'] = 'sukses';
}else{
    $query = mysqli_query($connect, "select * from mticket tb1 left join mdetailtiket tb2 on tb2.invoice = tb1.invoice where keyqrcode = '$telp' and paidstatus='1' and status='1' and tb1.isdelete='0' and tb2.print is null")or die(mysqli_error($connect));
    $cekqrcode = mysqli_num_rows($query);
    if ($cekqrcode > 0) {
        $sql = mysqli_query($connect, "select tb1.tiket, tb1.tiketdetail, tb2.nama from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb2.keyqrcode = '$telp'")or die(mysqli_error($connect));
        $qrtiket = mysqli_fetch_array($sql);
        $tiketqr = $qrtiket['tiket'];
        $print = mysqli_query($connect, "update mdetailtiket set print = '1' where tiket = '$tiketqr'")or die(mysqli_error($connect));
        $message['status'] = 'sukses';
    }else{
        $sql = '0';
        $message['status'] = 'gagal';
        $fail = "Code anda tidak terdaftar";
        // echo $fail;
    }
}
// $array = array(
//     'warning' => $fail,
//     'result' => 'true');
    echo json_encode($message);

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
try {
    // Enter the share name for your USB printer here
    //$connector = null;
    #$connector = new WindowsPrintConnector("XP-360B");
    $connector = new NetworkPrintConnector("172.16.0.20",9100);
    #$connector = new WindowsPrintConnector("EPSON-L3110");
    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
    while ($tiket = mysqli_fetch_array($sql)) {
    // $printer->initialize();
    $printer -> text($tiket['tiketdetail']."\n");
    $printer -> text("BERL AWARD 2020\n");
    $printer -> text("\n");
    $printer -> text("A/N"." ".$tiket['nama']."\n");
    $printer -> text("\n");
    $printer -> cut();
    /* Close printer */
    $printer -> close();
    }
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
}
