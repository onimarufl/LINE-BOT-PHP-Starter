<?php
    $host = "id4450855_root1234@2a02:4780:bad:c0de::13";
    $username = "id4450855_root1234";
    $password = "root1234";

   $conn = mysqli_connect($host,$username, $password);
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   echo "Connected successfully";
   ?>
