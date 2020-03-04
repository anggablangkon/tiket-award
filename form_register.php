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
  </style>

</head>

<body style="background-color: black" style="padding-top:none;">
<div class="col-md-12">
  <center>
  <!-- Form Register -->
  <div class="wrapper" >
    <div class="inner">
      <form action="" method="post">
        <div class="row">
          <!-- <div class="col-lg-12"> -->
        <div class="form-group">
          <div class="form-wrapper">
            <label for="">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" required="" placeholder="Nama Lengkap">
          </div>
          <div class="form-wrapper">
            <label for="">Nomor Whatsapp</label>
            <input type="text" class="form-control" id="telp" name="telp" placeholder="08...." required="">
          </div>
        </div>
        </div>
        <div class="row">
        <div class="form-group">
          <div class="form-wrapper">
            <label for="">Jumlah Laki-laki</label>
          </div>
          <div class="form-wrapper">
            <input type="number" class="form-control" name="male" placeholder="Laki-Laki" min="0" id="male" required="" value="0">
          </div>
        </div>
        </div>
        <div class="row">
        <div class="form-group">
          <div class="form-wrapper">
            <label for="">Jumlah Perempuan</label>
          </div>
          <div class="form-wrapper">
            <input type="number" class="form-control" name="female" placeholder="Perempuan" min="0" required="" id="female" value="0">
          </div>
        </div>
        </div>
        <div class="form-wrapper">
          <label for="">Domisili</label>
          <input type="text" class="form-control" name="domisili" placeholder="Domisili" required="">
        </div>
        <div class="form-wrapper">
        <button type="submit" name="register">Register</button>
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
    $(document).ready(function(){
      $('#telp').mask('000000000000');
     });
  </script>

</body>

</html>