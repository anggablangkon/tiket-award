<?php
session_start();
error_reporting(0);
include 'db.php';

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title></title>

  <!-- Font Awesome Icons -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200&display=swap" rel="stylesheet"> 

  <!-- Plugin CSS -->
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <!-- Theme CSS - Includes Bootstrap -->
  <link rel="stylesheet" type="text/css" href="css/custom.css">
  <link rel="stylesheet" type="text/css" href="vendor/sweetalert2/dist/sweetalert2.css">

</head>

<body style="background-color: black" style="padding-top:none;">
<div class="col-md-12">
  <!-- Form Register -->
  <div class="wrapper" style="width: 50%; margin: auto">
    <div class="inner">
      <form method="post" action="" enctype="multipart/form-data" autocomplete="off" id="form_cetak">
        <p id="message" style="display: none; font-size: 50px; width: 190%"></p>
          <div class="form-wrapper">
            <input type="text" class="form-control" id="tiket" name="tiket" placeholder="No Tiket * / scan QR" required="" autofocus="" style="width: 650px; height:100px; font-size: 50px">
          </div>
        <div class="form-wrapper">
        <button type="button" name="Transfer" id="print" style="width: 650px; height: 50px; font-size: 28px; display: none">Print</button>
      </div>
      </form>
    </div>
  </div>
</div>
  <!-- Bootstrap core JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script type="text/javascript" src="vendor/sweetalert2/dist/sweetalert2.all.js"></script>
  <script src='https://rawgit.com/kabachello/jQuery-Scanner-Detection/master/jquery.scannerdetection.js'></script>

  <script type="text/javascript">
    $("#print").click( function(){
      var datas = $('#form_cetak').serialize();
      var tiket = $('#tiket').val();
      $.ajax({
        url: 'ajaxtprint.php',
        data:"tiket="+tiket,
        success: function (data) {
          var json = data,
          obj = JSON.parse(json);
          if (obj.status == "sukses") {
            Swal.fire({
              width: 750,
              title: '<h1 style="font-size: 100px"><b>'+obj.tiket+'</b></h1>',
              html: '<h2><strong>Tiket Atas Nama : ' +obj.nama+ '<br>  jumlah tiket anda : '+obj.total+'</strong><h2>',
              imageUrl: 'img/berl-logo.png',
              imageHeight: 80,
              imageWidth: 80,
              showCancelButton: true,
              confirmButtonColor: 'rgba(219, 201, 107, 1)',
              cancelButtonColor: 'rgba(199, 196, 143, 1)',
              confirmButtonText: 'Print',
              cancelButtonText: 'Close',
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  type: "get",
                  url: "print_tikets.php",
                  dataType: 'json',
                  data: datas,
                  success: function (array) {
                    if (array.status == "sukses") {
                        window.open('print_tiket.php?tiket='+tiket,'Calendar','width=10,height=10');
                        window.location.replace("form_cetak.php");
                        $("#tiket").val("");
                    }else if (array.status == "gagal") {
                      Swal.fire(
                        'Warning',
                        'No Tiket yang anda masukan salah atau mungkin sudah dicetak.',
                        'error',
                        $("#tiket").val("")
                      )
                    }
                  }
                });
              }else if(result.dismiss){
                $("#tiket").val("");
              }
            })
          }else if (obj.status == "gagal") {
            Swal.fire({
              width: 750,
              title: "<strong>Kesalahan</strong>",
              html: "<h2><strong>No Tiket yang anda masukan salah atau mungkin sudah dicetak</strong></h2>",
              icon: "warning",
              showCancelButton: true,
              showConfirmButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Close',
            })
            $("#tiket").val("");
          }
        }
      });
    });
    $("#tiket").keydown(function(event){
        if(event.which ==13 || event.which == 10){
          event.preventDefault();
          $("#print").trigger("click");
        }
    });
    $("#tiket").keyup(function(event){
      var tiket = $("#tiket").val();
      if (tiket.length > 2 ) {
        $.ajax({
          url: 'ajaxtprint.php',
          data:"tiket="+tiket,
          success: function (data) {
            var json = data,
            obj = JSON.parse(json);
            if (obj.status == "sukses") {
              $("#print").trigger("click");
            }
          }})
      }
    });
  </script>
</body>

</html>