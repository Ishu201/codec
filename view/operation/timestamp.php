<?php

  $time = '08:00:00';

  date_default_timezone_set("Asia/Colombo");
   $now = new DateTime();
  $date = new DateTime($time);

   echo $date->diff($now)->format("%H:%i:%s");

?>
