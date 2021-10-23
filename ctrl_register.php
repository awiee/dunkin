<?php
   include 'conn.php';
   include '214Function.php';
   
   $fname = mysqli_real_escape_string($conn,$_POST["FirstName"]);
   $lname = mysqli_real_escape_string($conn,$_POST["LastName"]);
   $position = mysqli_real_escape_string($conn,$_POST["positionRefId"]);
   $branch = mysqli_real_escape_string($conn,$_POST["branchRefId"]);
   $username = mysqli_real_escape_string($conn,$_POST["Username"]);
   $pass = $_POST["Password"];
   $ans = mysqli_real_escape_string($conn,$_POST["Answer"]);
   $encrypted = md5($pass);
   
   $rs = mysqli_query($conn,"SELECT * FROM `employees` WHERE FirstName = '$fname' AND LastName = '$lname' AND positionRefId = '$position' AND branchRefId = '$branch'");
   if (mysqli_num_rows($rs) > 0) {
      $row = mysqli_fetch_assoc($rs);
      $empRefId = $row["RefId"];

      $chkEmpAcct = "SELECT * FROM sysuser WHERE employeesRefId = '$empRefId'";
      $rsEmpAcct = mysqli_query($conn,$chkEmpAcct);
      if (mysqli_num_rows($rsEmpAcct) > 0){
         echo '
            <script>
               alert("Employees Id No. [ '.$empRefId.' ] already have an account.");
               self.location = "register.php";
            </script>
         ';
      } else {
         $flds = "";
         $vals = "";
         $remarks = "FOR BACK UP USE ONLY";
         $flds .= "`employeesRefId`,`Username`,`Password`,`Remarks`,";
         $vals .= "'$empRefId','$username','$pass','$remarks',";
         $fields = $flds;
         $values = $vals;
         $result = save('acctbackup',$fields,$values);
         if (is_numeric($result)){
            $newflds = "";
            $newVals = "";
            $newflds .= "`employeesRefId`,`Username`,`Password`,`positionRefId`,`branchRefId`,`isLogin`,`Answer`,";
            $newVals .= "'$empRefId','$username','$encrypted','$position','$branch','0','$ans',";
            $newflds = $newflds;
            $newVals = $newVals;
            $result = save('sysuser',$newflds,$newVals);
            if (is_numeric($result)){
               echo '
                  <script>
                     alert("Successfully Register!!!");
                     self.location = "index.php";
                  </script>
               ';
            } else {
               echo 'Error in Saving!!!';
               return false;
            }
         } else {
            echo 'Error in Saving in Account Backup!!!';
            return false;
         }   
      }
   } else {
      echo '
         <script>
            alert("Your Information Doesnt Match!!!");
            self.location = "register.php";
         </script>
      ';
   }
   
?>