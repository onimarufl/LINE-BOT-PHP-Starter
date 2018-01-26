<?php
   $host        = "host=192.168.100.1";
   $port        = "port=5432";
   $dbname      = "dbname=testline";
   $credentials = "user=postgres password=root";

   $db = pg_connect( "$host $port $dbname $credentials"  ) ;
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

   pg_close($db) ;
?>
