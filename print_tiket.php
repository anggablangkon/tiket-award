<?php
session_start();
error_reporting(0);
include 'db.php';
 ?>

<!DOCTYPE html>
<html lang="en">
  <body>
    <?
      if (isset($_GET["tiket"]) && $_GET["tiket"]!=""){
        $tiket = $_GET["tiket"];
        $mdate = date('Y-m-d H:i:s');
      }
      $query = mysqli_query($connect, "select * from mdetailtiket where tiket = '$tiket'")or die(mysqli_error($connect));
      $cekqrcode = mysqli_num_rows($query);
      if ($cekqrcode > 0) {
        $sql = mysqli_query($connect, "select tb1.tiketdetail, tb2.nama from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb1.tiket = '$tiket'")or die(mysqli_error($connect));
      }else{
        $query = mysqli_query($connect, "select tb2.tiket from mticket tb1 left join mdetailtiket tb2 on tb2.invoice = tb1.invoice where tb1.keyqrcode = '$tiket' and tb1.isdelete='0'")or die(mysqli_error($connect));
        $cekqrcode = mysqli_num_rows($query);
        if ($cekqrcode > 0) {
          $detailtiket = mysqli_fetch_array($query);
          $tiket = $detailtiket['tiket'];
          $sql = mysqli_query($connect, "select tb1.tiketdetail, tb2.nama from mdetailtiket tb1 left join mticket tb2 on tb2.invoice = tb1.invoice where tb1.tiket = '$tiket'")or die(mysqli_error($connect));
        }else{
          echo "data tidak ada";
          die();
        }
      }

      foreach ($sql as $key => $tiket) {
        $update = mysqli_query($connect, "update mdetailtiket set print = '1', mdate='$mdate' where tiketdetail = '".$tiket['tiketdetail']."'")or die(mysqli_error($connect));
        $query = mysqli_query($connect, "select * from mseat where isdelete = '0'")or die(mysqli_error($connect));
        $totalseat = mysqli_fetch_array($query);
        if ($totalseat['kuota_seat1'] < $totalseat['seat1']) {
          mysqli_query($connect,"update mseat set kuota_seat1 = '".$totalseat['kuota_seat1']."'+1 where isdelete = 0 ")or die(mysqli_error($query));
          $seat = $totalseat['nama_seat1'];
        }elseif ($totalseat['kuota_seat1'] >= $totalseat['seat1']) {
          mysqli_query($connect,"update mseat set kuota_seat2 = '".$totalseat['kuota_seat2']."'+1 where isdelete = 0 ")or die(mysqli_error($query));
          $seat = $totalseat['nama_seat2'];
        }
        echo "<script>";
          echo "window.open('tiket.php?tiketdetail=".$tiket['tiketdetail']."&nama=".$tiket['nama']."&seat=".$seat."','_blank','width=10,height=10');";
        echo "</script>";
      }
      ?>
    <script>
        window.close();
    </script>
  </body>
</html>