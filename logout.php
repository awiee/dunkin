<?php
   include 'conn.php';
   session_start();
   $empRefId = $_SESSION["RefId"];
   $sql = "UPDATE sysuser SET isLogin ='0', Session = '' WHERE employeesRefId = '$empRefId'";
   if (mysqli_query($conn, $sql)) {
      
      echo '<script>alert("Thank You!!!");self.location = "index.php";</script>';
      session_destroy();
   } else {
      echo "Error updating record: " . mysqli_error($conn);
   }
?>