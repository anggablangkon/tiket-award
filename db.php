<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'dvberl_produksi';

$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
  echo 'koneksi gagal';
}
 ?>