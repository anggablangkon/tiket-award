<?php

session_start();
error_reporting(0);
include 'db.php';

if (isset($_FILES['transfer']) && count($_FILES['transfer']['name']) > 0) {
  $invoice = $_POST['invoice'];
  $cdate = date('Y-m-d');
  $transfer = explode(",", $_POST['total']);
  $transfer = $transfer[0].$transfer[1].$transfer[2];
  $path = 'img';
  $sql = "select invoice from mticket where invoice='$invoice'";
  $query = mysqli_query($connect, $sql)or die(mysqli_error($connect));
  $info = mysqli_fetch_array($query);
  if ($info['invoice'] ==null) {
    $message = '<div class="alert alert-danger">No Invoice Anda tidak terdaftar</div>';
  }else{
        if ($_POST['fileasli'] != null){
            $gambar = explode(',',$_POST['fileasli']);
            for ($i = 0; $i < count($gambar); $i++) {
                $filename = $gambar[$i];
                if($filename != ""){
                    $tmp_filename = $_FILES['transfer']['tmp_name'][$i];
                    $arr = explode(".", $filename);
                    $ext = end($arr);
                    if ($_FILES['transfer']['name'][$i] == $filename) {
                        $tmp_filename = $_FILES['transfer']['tmp_name'][$i];
                        $size = $_FILES['transfer']['size'][$i];

                          $sql = "insert into mticketatt (invoice, filename, ext, isdelete, cdate, mdate)
                              values ('$invoice', '$filename', '$ext', '0', '$cdate',null)";

                          if (mysqli_query($connect, $sql)or die(mysqli_error($connect))) {
                            $idAtt = mysqli_insert_id($connect)or die(mysqli_error($connect)); 
                            }
                        if ($idAtt != null) {
                            $newfilename = $idAtt .'.'.$ext;
                            $newfilename = $path . '/' . $newfilename;
                            move_uploaded_file($tmp_filename, $newfilename);
                        }
                    }
                }
            }
        }

        if ($_POST['photos'] != null){
            $img = explode('|', $_POST['photos']);

            for ($i = 0; $i < count($img) - 1; $i++) {
                if (strpos($img[$i], 'data:image/jpeg;base64,') === 0) {
                    $img[$i] = str_replace('data:image/jpeg;base64,', '', $img[$i]);  
                    $ext = 'jpg';
                }
                if (strpos($img[$i], 'data:image/png;base64,') === 0) { 
                    $img[$i] = str_replace('data:image/png;base64,', '', $img[$i]); 
                    $ext = 'png';
                }

                $filename = $_FILES['transfer']['name'][$i];
                $arr = explode(".", $filename);
                $ext = end($arr);
                $obj['size'] = $_FILES['transfer']['size'][$i];
                $sql = "insert into mticketatt (invoice, filename, ext, isdelete, cdate, mdate)
                    values ('$invoice', '$filename', '$ext', '0', '$cdate',null)";

                if (mysqli_query($connect, $sql)or die(mysqli_error($connect))) {
                  $idAtt = mysqli_insert_id($connect)or die(mysqli_error($connect)); 
                  }
                if ($idAtt != null) {
                    $img[$i] = str_replace(' ', '+', $img[$i]);
                    $data = base64_decode($img[$i]);
                    $file = $path.'/'.$idAtt.'.'.$ext;
                    file_put_contents($file, $data);
                }
            }
        }
  $sql = "update mticket set transfer='$transfer', mdate='$cdate' where invoice='$invoice' ";
  $query = mysqli_query($connect, $sql)or die(mysqli_error($connect));
  header("Location: success.php?page=2");
}
}
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

  <style type="text/css">
    input[readonly]
    {
        background-color:#ccc;
    }
    .form-control {
      border-radius: 30px 30px 30px 30px;
      border: 1px solid #f4eab1;
      background-color: rgba(233, 219, 137, 0.14);
      border-color: rgba(199, 196, 143, 1);
      border-style: solid;
      display: block;
      width: 100%;
      height: 40px;
      padding: 0 20px;
      border-radius: 20px;
      font-family: 'Nunito', sans-serif;
      text-align: center;
      color:#FFFFFF; }
      .form-control:focus {
        border: 1px solid #ae3c33; }

        ::-webkit-input-placeholder { 
          color: #f4eab1;
          font-family: 'Nunito', sans-serif;
        }

        :-ms-input-placeholder { 
          color: #f4eab1;
          font-family: 'Nunito', sans-serif;
        }

        ::placeholder {
          color: #f4eab1;
          font-family: 'Nunito', sans-serif;
        }
    * {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box; }

    body {
    font-family: 'Nunito', sans-serif;
      color: #FFFFFF;
      font-size: 13px;
      margin: 0; }

    input, textarea, select, button {
    font-family: 'Nunito', sans-serif;
      color: #333;
      font-size: 13px; }

    p, h1, h2, h3, h4, h5, h6, ul {
      margin: 0; }

    img {
      max-width: 100%; }

    ul {
      padding-left: 0;
      margin-bottom: 0; }

    a:hover {
      text-decoration: none; }

    :focus {
      outline: none; }

    .wrapper {
      min-height: 100vh;
      background-size: cover;
      background-repeat: no-repeat;
      display: flex;
      align-items: center; }

    .inner {
      min-width: 850px;
      margin: auto;
      padding-top: 68px;
      padding-bottom: 48px;
      /*background: url("../images/registration-form-2.jpg");*/
    }
      .inner h3 {
        text-transform: uppercase;
        font-size: 22px;
        font-family: 'Nunito', sans-serif;

        text-align: center;
        margin-bottom: 32px;
        color: #333;
        letter-spacing: 2px; }

    form {
      width: 50%;
      padding-left: 45px; }

    .form-group {
      display: flex; }
      .form-group .form-wrapper {
        width: 50%; }
        .form-group .form-wrapper:first-child {
          margin-right: 20px; }

    .form-wrapper {
      margin-bottom: 17px; }
      .form-wrapper label {
        margin-bottom: 9px;
        display: block; 
        text-align: center;}

    select {
      -moz-appearance: none;
      -webkit-appearance: none;
      cursor: pointer;
      padding-left: 20px; }
      select option[value=""][disabled] {
        display: none; }

    button {
      border: none;
      width: 152px;
      height: 40px;
      margin: auto;
      margin-top: 29px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      background: #ae3c33;
      font-size: 13px;
      color: #fff;
      text-transform: uppercase;
      font-family: 'Nunito', sans-serif;
      border-radius: 20px;
      overflow: hidden;
      -webkit-transform: perspective(1px) translateZ(0);
      transform: perspective(1px) translateZ(0);
      box-shadow: 0 0 1px rgba(0, 0, 0, 0);
      position: relative;
      -webkit-transition-property: color;
      transition-property: color;
      -webkit-transition-duration: 0.5s;
      transition-duration: 0.5s; }
      button:before {
        content: "";
        position: absolute;
        z-index: -1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #f11a09;
        -webkit-transform: scaleX(0);
        transform: scaleX(0);
        -webkit-transform-origin: 0 50%;
        transform-origin: 0 50%;
        -webkit-transition-property: transform;
        transition-property: transform;
        -webkit-transition-duration: 0.5s;
        transition-duration: 0.5s;
        -webkit-transition-timing-function: ease-out;
        transition-timing-function: ease-out; }
      button:hover:before {
        -webkit-transform: scaleX(1);
        transform: scaleX(1);
        -webkit-transition-timing-function: cubic-bezier(0.52, 1.64, 0.37, 0.66);
        transition-timing-function: cubic-bezier(0.52, 1.64, 0.37, 0.66); }

    .checkbox {
      position: relative; }
      .checkbox label {
        padding-left: 22px;
        cursor: pointer; }
      .checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer; }
      .checkbox input:checked ~ .checkmark:after {
        display: block; }

    .checkmark {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      height: 12px;
      width: 13px;
      border-radius: 2px;
      background-color: #ebebeb;
      border: 1px solid #ccc;
      font-family: 'Nunito', sans-serif;
      color: #000;
      font-size: 10px;
      font-weight: bolder; }
      .checkmark:after {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        content: '\f26b'; }

    @media (max-width: 991px) {
      .inner {
        min-width: 768px; } }
    @media (max-width: 767px) {
      .inner {
        min-width: auto;
        background: none;
        padding-top: 0;
        padding-bottom: 0; }

      form {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px; } }

    /*# sourceMappingURL=style.css.map */
    .textreadonly {
      color: black;
    }
  </style>

</head>

<body style="background-color: black" style="padding-top:none;">
<div class="col-md-12">
  <center>
  <!-- Form Register -->
  <div class="wrapper" >
    <div class="inner">
      <form method="post" action="" enctype="multipart/form-data" autocomplete="off">

          <div class="form-wrapper">
            <label for="">Invoice</label>
            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice *" onkeyup="filltransfer()" autocomplete="off" required="" />
            <?php if(isset($message)) {
              echo $message;
            }
            ?>
          </div>
          <div class="form-wrapper">
            <label for="">Nama Lengkap</label>
            <input type="text" class="form-control textreadonly" id="nama" name="nama" placeholder="Nama Lengkap" readonly="">
          </div>

          <div class="form-wrapper">
            <label for="">Jumlah tiket Laki-laki</label>
          </div>
          <div class="form-wrapper">
            <input type="text" class="form-control textreadonly" id="male" name="tottiket" placeholder="Jumlah Tiket" readonly="" >
          </div>

          <div class="form-wrapper">
            <label for="">Jumlah tiket Perempuan</label>
          </div>
          <div class="form-wrapper">
            <input type="text" class="form-control textreadonly" id="female" name="tottiket" placeholder="Jumlah Tiket" readonly="" >
          </div>

          <div class="form-wrapper">
            <label for="">Total Pembayaran</label>
          </div>
          <div class="form-wrapper">
            <input type="text" class="form-control textreadonly" id="total" name="total" placeholder="Total Pembayaran" readonly="">
          </div>

        <div class="form-wrapper">
          <label for="">File Transfer</label>
        </div>
        <div class="form-wrapper">
          <input type="file" id="kv-explorer" class="form-control" name="transfer[]" placeholder="file" multiple required />
          <input type="hidden" name="photos" id="photos">
          <input id="fileasli" type="hidden" name="fileasli">
        </div>
        <div class="form-wrapper">
        <button type="submit" name="Transfer">Transfer</button>
      </div>
      </form>
    </div>
  </div>
  </center>
</div>

  <!-- Bootstrap core JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

  <script type="text/javascript">
    function filltransfer(){
      var invoice = $("#invoice").val();
      $.ajax({
        url: 'ajaxtransfer.php',
        data:"invoice="+invoice,
        success: function (data) {
      // }).
        var json = data,
        obj = JSON.parse(json);
        $('#nama').val(obj.nama);
        $('#jumlah').val(obj.jmltiket);
        $('#total').val(obj.total);
        $('#male').val(obj.male);
        $('#female').val(obj.female);
      }
    });
    }

    var kvExplorer = document.getElementById('kv-explorer');
        if (kvExplorer != null) {
            kvExplorer.addEventListener('change', fileChange, false);
        }
    function fileChange(e) {
        document.getElementById('photos').value = ''; 
        document.getElementById('fileasli').value = '';
        for (var i = 0; i < e.target.files.length; i++) { 
             
            var file = e.target.files[i];
            if (file.size <=200000 ) {
                var filePath = this.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if(!allowedExtensions.exec(filePath)){
                    document.getElementById('kv-explorer').value = ''; 
                    alert('Please only select images in JPG- or PNG-format.');   
                    return false;
                }
                document.getElementById('fileasli').value += file.name +',' ;
            }else if (file.type == "image/jpeg" || file.type == "image/png") {
                var reader = new FileReader();  
                reader.onload = function(readerEvent) {
         
                    var image = new Image();
                    image.onload = function(imageEvent) { 
         
                    var max_size = 500;
                    var w = image.width;
                    var h = image.height;
                               
                    if (w > h) {  if (w > max_size) { h*=max_size/w; w=max_size; }
                    } else     {  if (h > max_size) { w*=max_size/h; h=max_size; } }
                       
                    var canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(image, 0, 0, w, h);
                    if (file.type == "image/jpeg") {
                        var dataURL = canvas.toDataURL("image/jpeg", 1.0);
                    } else {
                        var dataURL = canvas.toDataURL("image/png");    
                }
                    document.getElementById('photos').value += dataURL + '|';
                }
                    image.src = readerEvent.target.result;
                }
                   reader.readAsDataURL(file);
                   reader.crossOrigin = 'Anonymous';
            } else {
                   document.getElementById('kv-explorer').value = ''; 
                   alert('Please only select images in JPG- or PNG-format.');   
                   return false;
            }
        }
    }
  </script>

</body>

</html>