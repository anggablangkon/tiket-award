<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="css/tiket.css" media="print">
</head>
<body>
<?php
if (isset($_GET["tiketdetail"]) && $_GET["tiketdetail"]!=""){
  $tiketdetail = $_GET["tiketdetail"];
  $nama = $_GET["nama"];
  $seat = $_GET["seat"];
}
?>
<div class="cardWrap">
  <div class="card cardLeft">
    <img src="img/Berl-award.png" style="width: 150px; height: 70px">
    <div class="title">
      <h2 style="letter-spacing: 10px"><?php echo $tiketdetail ?></h2>
    </div>
    <div class="name">
      <h2>Berl Award 2020</h2>
    </div>
    <div class="seat">
      <h2 style="font-size: 12px">A/n <?php echo $nama ?></h2>
    </div>&nbsp;
    <div class="name">
      <table border="1" style="border: solid;">
        <tr>
          <td>
            <h2 style="font-size: 12px">SEAT <?php echo strtoupper($seat) ?></h2>
          </td>
        </tr>
      </table>
    </div>
    <div class="name">
      <h2 style="font-size: 10px;text-transform: lowercase;">www.berlcosmetics.com</h2> 
    </div>
  </div>

  <div class="card cardRight">
    <center><img src="img/berl-logo.png" style="width: 20px; height: 20px;"></center>
      <table>
        <tr>
          <td class="number rotation" style="padding-bottom: 20px;">
            <span style="letter-spacing: 10px; padding-bottom:50px; padding-top: 15px"><h1><?php echo $tiketdetail ?></h1></span>
          </td>
        </tr>
      </table>
  </div>
</div>

<script>
    window.print();
    window.close();
</script>
</body>
</html>