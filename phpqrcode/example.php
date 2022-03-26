<?php
  
  // include "phpqrcode/qrlib.php"; 
  include ('vendor/phpqrcode/qrlib.php');



  #produksi
  $tempdir = 'assets/barcode/';
  #local
  // $tempdir = 'temp/'; //Nama folder tempat menyimpan file qrcode

  // dd($tempdir);
  if (!file_exists($tempdir)) //Buat folder bername temp
  mkdir($tempdir);

 //ambil logo
  $logopath= 'assets/qrcode/B.png';

 //isi qrcode jika di scan
  $codeContents = $_GET['token']; 

 //simpan file qrcode
  QRcode::png($codeContents, $tempdir.$codeContents.'.png', QR_ECLEVEL_H, 10,4);


 // ambil file qrcode
  $QR = imagecreatefrompng($tempdir.$codeContents.'.png');

 // memulai menggambar logo dalam file qrcode
  $logo = imagecreatefromstring(file_get_contents($logopath));

  imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
  imagealphablending($logo , false);
  imagesavealpha($logo , true);

  $QR_width = imagesx($QR);
  $QR_height = imagesy($QR);

  $logo_width = imagesx($logo);
  $logo_height = imagesy($logo);

 // Scale logo to fit in the QR Code
  $logo_qr_width = $QR_width/8;
  $scale = $logo_width/$logo_qr_width;
  $logo_qr_height = $logo_height/$scale;

  imagecopyresampled($QR, $logo, $QR_width/2.3, $QR_height/2.3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

 // Simpan kode QR lagi, dengan logo di atasnya
  imagepng($QR,$tempdir.$codeContents.'.png');

?>