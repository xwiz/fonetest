<?php
   if( isset($HTTP_RAW_POST_DATA))
   {
      $cad = $HTTP_RAW_POST_DATA;
      $stringas = explode(":",$cad);
      $type = explode(";", $stringas[1]);
      $base = explode(",", $type[1]);
      $base64 = $base[1];
      print_r ( $base64 );
      $myFile = "record_".time().".wav";
      $fh = fopen($myFile, 'w');
      fwrite($fh, base64_decode($base64));
      echo $myFile;
   }
   else{
    header('Location: /', 'refresh');
   }