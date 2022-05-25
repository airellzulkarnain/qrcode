<!DOCTYPE html>
<html>
  <head>
    <title>Instascan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="text/javascript" src="./instascan.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        #preview { width: 50%;margin: 10px auto;display: block;}
        .form {display: block;text-align: center;}
         button {transition: color 0.3s;font-size:20px;}
         button:hover {color: gray;}
    </style>
  </head>
  <body>
  <?php 
        session_start();
        if(isset($_GET['qrcode']) && !empty($_GET['qrcode'])){
           $_SESSION['vLPN'] = $_GET['qrcode'];
           echo '<p>'.$_SESSION['vLPN'].'</p>';
           ?>
           <script>location.replace("some.php");</script>
   <?php
        }
   ?>
   <div class="form">
   <form method="get" action="<?php $_SERVER['PHP_SELF']; ?>">
      <input type="text" id="qrcode" name="qrcode"/>
      <input type="submit" value="Submit"/>
   </form>
   </div>
    <video id="preview"></video>
    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror:false});
      scanner.addListener('scan', function (content) {
        $("#qrcode").val(content);
      });
      function changeCam(i) {
         Instascan.Camera.getCameras().then(function (cameras) {
            scanner.start(cameras[i]);
         }).catch(function(e){console.error(e);});
      }
      Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
	        scanner.start(cameras[0]);
          for(let i = 0; i < cameras.length; i++){
              $(`<li><button onclick="changeCam(${i});" style="margin: 20px;">${cameras[i].name}</button></li>`).appendTo("ul");
          }
      } else {
          console.error('No cameras found.');
      }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
    <ul></ul>
  </body>
</html>