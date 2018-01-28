<?php
    $host = "sql12218252@ec2-52-8-112-233.us-west-1.compute.amazonaws.com";
    $username = "sql12218252";
    $password = "ARBn1864yi";

   $conn = mysqli_connect($host,$username, $password);
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   echo "Connected successfully";
   ?>
