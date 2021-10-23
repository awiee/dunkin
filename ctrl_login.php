<?php
   include 'conn.php';
   session_start();
   date_default_timezone_set("Asia/Manila");

   function get($table,$RefId,$fields){
      include 'conn.php';
      $sql = "SELECT `$fields` FROM `$table` where RefId = $RefId LIMIT 1";
      $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
      $row = mysqli_fetch_assoc($result);
      mysqli_close($conn);
      $numrow = mysqli_num_rows($result);
      if ($numrow <= 0) {
         return "";
      } else {
         if ($fields == "*") return $row;
         else return $row[$fields];
      }
   }
   $user = $_POST["Username"];
   $pass = md5($_POST["Password"]);
   $t = time();
   $session = $t.date("Ymd",$t);
   $session = base64_encode(base64_encode(base64_encode($session))).md5(base64_encode(base64_encode($session)));
   $sql = "SELECT * FROM `sysuser` WHERE Username = '$user' AND Password = '$pass'";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0) {
      while($row = mysqli_fetch_assoc($rs)){
         $empRefId = $row["employeesRefId"];
         $sql = "UPDATE sysuser SET isLogin = '1', Session = '$session' WHERE employeesRefId = '$empRefId'";
         if (mysqli_query($conn, $sql)) {
            $sql = "SELECT * FROM `employees` WHERE RefId = '$empRefId'";
            $recordSet = mysqli_query($conn,$sql);
            if (mysqli_num_rows($recordSet)){
               while($row = mysqli_fetch_assoc($recordSet)){
                  $_SESSION["RefId"] = $row["RefId"];
                  $_SESSION["FirstName"] = $row["FirstName"];
                  $_SESSION["LastName"] = $row["LastName"];
                  $_SESSION["MiddleName"] = $row["MiddleName"];
                  $_SESSION["Branch"] = get("branch",$row["branchRefId"],"Name");
                  $_SESSION["Position"] = get("position",$row["positionRefId"],"Name");
                  $_SESSION["FullName"] = $row["LastName"].", ".$row["FirstName"];
                  $_SESSION["BranchRefId"] = $row["branchRefId"];
                  $_SESSION["PositionRefId"] = $row["positionRefId"];

                  /*SESSION QUERY*/
                  $sessQry = mysqli_query($conn,"SELECT * FROM sysuser WHERE employeesRefId = '$empRefId'");
                  $rowSess = mysqli_fetch_assoc($sessQry);
                  $_SESSION["Session"] = $rowSess["Session"];
                  /*---------*/
                  if ($_SESSION["Position"] == "Driver"){
                     header ("Location: myDelivery.php?");   
                  } else if ($_SESSION["Position"] == "Employee"){
                     header("Location: myRequest.php?");
                  } else {
                     header("Location: notification.php?");
                  }
               }
            }else {
               echo 'No Record!!!';
            }
         } else {
             echo "Error updating record: " . mysqli_error($conn);
         }
      }
      
   }else {
      echo '
         <script>
            alert("Username And Password Doesnt Match!!!");
            self.location = "index.php";
         </script>
      ';
   }
?>