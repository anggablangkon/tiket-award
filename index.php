<?php
session_start();
error_reporting(0);
include 'db.php';

if (isset($_POST['register'])) {
      // inisialisasi data
      $obj['nama'] = mysqli_real_escape_string($connect, $_POST['nama']);
      $obj['telp1'] = mysqli_real_escape_string($connect, $_POST['telp']);
      $obj['domisili'] = mysqli_real_escape_string($connect, $_POST['domisili']);
      $obj['cdate'] = date('Y-m-d');
      $obj['male'] = $_POST['male'];
      $obj['female'] = $_POST['female'];

      function hp($obj) {
          // kadang ada penulisan no hp 0811 239 345
          $nohp = str_replace(" ","",$obj['telp1']);
          // kadang ada penulisan no hp (0274) 778787
          $nohp = str_replace("(","",$obj['telp1']);
          // kadang ada penulisan no hp (0274) 778787
          $nohp = str_replace(")","",$obj['telp1']);
          // kadang ada penulisan no hp 0811.239.345
          $nohp = str_replace(".","",$obj['telp1']);
      
          // cek apakah no hp mengandung karakter + dan 0-9
          if(!preg_match('/[^+0-9]/',trim($nohp))){
              // cek apakah no hp karakter 1-3 adalah +62
              if(substr(trim($nohp), 0, 3)=='+62'){
                  $hp = trim($nohp);
              }
              // cek apakah no hp karakter 1 adalah 0
              elseif(substr(trim($nohp), 0, 1)!='+62'){
                  $hp = '+62'.substr(trim($nohp), 1);
              }
          }
          return $hp;
      }

      $obj['telp'] = hp($obj);

          // urutkan invoice dari yang terbawah
      $sql = mysqli_query($connect, "select invoice from mticket order by invoice DESC");
          // ubah data ke bentuk array tanpa looping
      $invoice = mysqli_fetch_array($sql);
          // cek data
      if (count($invoice) < 1) {
            // kalau data kosong pake no default
        $random = 2020;
      }else{
            // kalau ada panggil nomor invoice dari database lalu potong pada karakter ke 8 untuk di ambil 
        $random = substr($invoice['invoice'],8);
      }
          // buat nomor invoice
      $ran = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);

      // cek invoice dengan yang ada di database
      if ($invoice['invoice'] == $ran) {
        //buat nomor invoice baru
        $newran = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $obj['invoice'] = $newran;
      }else{
        $obj['invoice'] = $ran;
      }

      // ambil nilai harga tiket sesuai waktu
      $sql = mysqli_query($connect, "select * from mticketprice where isdelete = '0' and startdate <= curdate() and enddate >= curdate()");
      $tiket = mysqli_fetch_array($sql);

          // query insert ke tabel
      $sql = "insert into mticket values(null,'".$tiket['idticketprice']."','".$obj['nama']."','".$obj['telp']."','".$obj['domisili']."','".$obj['invoice']."',0,0,null,'".$obj['cdate']."',null,'".$obj['male']."','".$obj['female']."','0',null )";
          // eksekusi query
      $query = mysqli_query($connect, $sql)or die(mysqli_error($connect));

      $sql   = "select idticket from mticket where telp = '".$obj['telp']."' order by idticket desc ";
      $query = mysqli_query($connect, $sql)or die(mysqli_error($connect));
      $query = mysqli_fetch_array($query);

      $id    = $query['idticket'];
      $date  =  date('dmy');
      $keyqrcode = md5('#berl'.$id.$date.'berl#');

      $sql = "update mticket set keyqrcode = '$keyqrcode' where idticket = '$id' ";
      $query = mysqli_query($connect, $sql)or die(mysqli_error($connect));
      header("Location: success.php?page=1&name=".$ran." ");
    // }
}

if (isset($_FILES['transfer']) && count($_FILES['transfer']['name']) > 0) {
  $invoice = $_POST['invoice'];
  $cdate = date('Y-m-d');
  $totaltrf = explode(",",$_POST['total']);
  $transfer = $totaltrf[0].$totaltrf[1].$totaltrf[2];
  $path = 'img';
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
          <h1 class="text-uppercase text-white font-weight-bold">Your Favorite Source of Free Bootstrap Themes</h1>
          <hr class="divider my-4">
        </div>
        <div class="col-lg-8 align-self-baseline">
          <p class="text-white-75 font-weight-light mb-5">Start Bootstrap can help you build better websites using the Bootstrap framework! Just download a theme and start customizing, no strings attached!</p>
          <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Find Out More</a>
        </div>
      </div>
    </div>
  </header>

  <!-- About Section -->
  <section class="page-section bg-primary" id="about">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="text-white mt-0">Transfer</h2>
          <hr class="divider light my-4">
          <form method="post" action="" enctype="multipart/form-data" autocomplete="off">
          <div class="form-group">
            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice *" onkeyup="filltransfer()" autocomplete="off" />
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" readonly />
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="jumlah" name="tottiket" placeholder="Jumlah Tiket" readonly/>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="total" name="total" placeholder="Total Tagihan" readonly/>
          </div>
          <div class="form-group">
            <input type="file" id="kv-explorer" class="form-control" name="transfer[]" placeholder="file" multiple />
            <input type="hidden" name="photos" id="photos">
            <input id="fileasli" type="hidden" name="fileasli">
          </div>
          <button type="submit" class="btn btn-light btn-xl js-scroll-trigger" name="transfer">Transfer</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="page-section" id="services">
    <div class="container">
      <h2 class="text-center mt-0">At Your Service</h2>
      <hr class="divider my-4">
      <div class="row">
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-gem text-primary mb-4"></i>
            <h3 class="h4 mb-2">Sturdy Themes</h3>
            <p class="text-muted mb-0">Our themes are updated regularly to keep them bug free!</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
            <h3 class="h4 mb-2">Up to Date</h3>
            <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-globe text-primary mb-4"></i>
            <h3 class="h4 mb-2">Ready to Publish</h3>
            <p class="text-muted mb-0">You can use this design as is, or you can make changes!</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-heart text-primary mb-4"></i>
            <h3 class="h4 mb-2">Made with Love</h3>
            <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Form Register -->
  <section id="portfolio">
    <div class="container register">
      <div class="row">
        <div class="col-md-3 register-left">
          <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
          <h3>Welcome</h3>
          <p>You are 30 seconds away from earning your own money!</p>
        </div>
        <div class="col-md-9 register-right">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <h3 class="register-heading">Apply as a Employee</h3>
              <div class="row register-form">
                <?php if (isset($message)) {
                  echo $message;
                } ?>
                <form method="post" action="" autocomplete="off">
                <!-- <div class="col-md-6"> -->
                  <div class="form-group">
                    <input type="text" class="form-control" name="nama" placeholder="Nama *" value="" />
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="telp" id="telp" placeholder="Nomor Telp. *" value="" />
                  </div>
                <!-- </div> -->
                <!-- <div class="col-md-6"> -->
                  <div class="form-group">
                    <textarea class="form-control" name="domisili" placeholder="Domisili *"></textarea>
                    <!-- <input type="email" class="form-control" placeholder="Domisili *" value="" /> -->
                  </div>
                  <div class="form-group">
                    <div class="maxl">
                      <label> Jumlah Tiket :</label>
                    </div>
                    <div class="maxl">
                      <label class="radio inline"> 
                        <span> Laki-laki </span>
                        <input type="number" name="male" class="form-control" size="4" min="0" value="0">
                      </label>
                    </div>
                    <div class="maxl"> 
                        <!-- <input type="text" name="gender" value="male" checked> -->
                      <label class="radio inline"> 
                        <span>Perempuan </span>
                        <input type="number" name="female" class="form-control" size="4" min="0" id="perempuan" value="0">
                        <!-- <input type="radio" name="gender" value="female"> -->
                      </label>
                    </div>
                  <!-- </div> -->
                  <input type="submit" class="btnRegister" name="register"  value="Register"/>
                </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="page-section" id="contact">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="mt-0">Let's Get In Touch!</h2>
          <hr class="divider my-4">
          <p class="text-muted mb-5">Ready to start your next project with us? Give us a call or send us an email and we will get back to you as soon as possible!</p>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
          <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
          <div>+1 (202) 555-0149</div>
        </div>
        <div class="col-lg-4 mr-auto text-center">
          <i class="fas fa-globe fa-3x mb-3 text-muted"></i>
          <!-- Make sure to change the email address in anchor text AND the link below! -->
          <a class="d-block" href="mailto:contact@yourwebsite.com">contact@yourwebsite.com</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
      <div class="small text-center text-muted">Copyright &copy; 2019 - Start Bootstrap</div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/creative.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#telp').mask('000000000000000');
     });
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