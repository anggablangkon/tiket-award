<?php
session_start();
error_reporting(1);
include 'db.php';

$variable = $_GET['page'];
$nama = $_GET['name'];
if ($variable == 1) {
  $messageheader = "Terimakasih telah mendaftar sebagai peserta B erl award 2020 ";
  $messagebody = "selanjutnya team kami akan mengirimkan kepada anda link konfirmasi pendaftaran dan nomer rekening pembayaran melalui nomer whatsapp yang telah kamu daftarkan <br>note : biasanya team kami akan menghubungi anda kurang dari 24 jam. <br>Terimakasih";
  #$download = '<a class="btn btn-primary btn-xl js-scroll-trigger" href="downloadinvoice.php?c='.$nama.'">Download Invoice</a>';
}elseif($variable == 2){
  $messageheader = "Terimaksih sudah konfirmasi.";
  $messagebody = "Pembayaran anda akan kami cek kembali<br>selanjutnya anda bisa menunggu konfirmasi tiket kami, maksimal 12 Jam melalui nomer whatapp anda.<br>
  Kode unik Rp.5 akan di donasikan kepada yang membutuhkan";
  $download = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Creative - Start Bootstrap Theme</title>

  <!-- Font Awesome Icons -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- Plugin CSS -->
  <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

  <!-- Theme CSS - Includes Bootstrap -->
  <link href="css/creative.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/form.css">

</head>

<body id="page-top">
  <!-- Masthead -->
  <header class="masthead">
    <div class="container h-100">
      <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-10 align-self-end">
          <h1 class="text-uppercase text-white font-weight-bold"><?php echo $messageheader ?></h1>
          <hr class="divider my-4">
        </div>
        <div class="col-lg-8 align-self-baseline">
          <p class="text-white-75 font-weight-light mb-5"><?php echo $messagebody ?></p>
          <?php echo $download; ?>
        </div>
      </div>
    </div>
  </header>

  <!-- Footer -->
<!--   <footer class="bg-light py-5">
    <div class="container">
      <div class="small text-center text-muted">Copyright &copy; 2019 - Start Bootstrap</div>
    </div>
  </footer> -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/creative.min.js"></script>

</body>

</html>