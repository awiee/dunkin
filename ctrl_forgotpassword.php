<?php
   include 'conn.php';
   include '214Function.php';
   
   $fname = $_POST["FirstName"];
   $lname = $_POST["LastName"];
   $position = $_POST["positionRefId"];
   $branch = $_POST["branchRefId"];
   $ans = $_POST["Answer"];
   $pass = $_POST["Password"];
   $encrypt = md5($pass);

   $sql = "SELECT * FROM `employees` WHERE FirstName = '$fname' AND LastName = '$lname' AND positionRefId = '$position' AND branchRefId = '$branch'";
   $rs = mysqli_query($conn,$sql);
    if (mysqli_num_rows($rs) > 0) {
     	$row = mysqli_fetch_assoc($rs);
      	$empRefId = $row["RefId"];
      	$chkEmpAcct = "SELECT * FROM sysuser WHERE employeesRefId = '$empRefId' AND Answer = '$ans'";
      	$rsEmpAcct = mysqli_query($conn,$chkEmpAcct);
      	if (mysqli_num_rows($rsEmpAcct) > 0){
      		$sys_row = mysqli_fetch_assoc($rsEmpAcct);
      		$sys_refid = $sys_row["RefId"];
      		$update = update("sysuser","Password = '$encrypt',",$sys_refid);
      		if ($update == "") {
      			$new_sql = "SELECT * FROM acctbackup WHERE employeesRefId = $empRefId";
		        $new_rs = mysqli_query($conn,$new_sql);
		        if (mysqli_num_rows($new_rs) > 0) {
		        	$acct_row = mysqli_fetch_assoc($new_rs);
		        	$acct_refid = $acct_row["RefId"];
		        	$acct_update = update("acctbackup","Password = '$pass',",$acct_refid);
		        	if ($acct_update != "") {
		        		echo '
				          	<script>
				             	alert("Error in Creating Backup!!!");
				            	self.location = "forgotpassword.php";
				          	</script>
				       	'; 		
		        	} else {
		        		echo '
				          	<script>
				             	alert("Successfully Change Password!!!");
				            	self.location = "index.php";
				          	</script>
				       	'; 	
		        	}
		        } else {
		        	echo '
			          	<script>
			             	alert("You Dont Have Any Account Backup \n Report To The Admin!!!");
			            	self.location = "forgotpassword.php";
			          	</script>
			       	'; 	
		        }
      		} else {
      			echo '
		          	<script>
		             	alert("Error in Updating Password!!!");
		            	self.location = "forgotpassword.php";
		          	</script>
		       	'; 
      		}
	        
      	} else {
	        echo '
	          <script>
	             alert("Secret Answer is Incorrect!!!");
	             self.location = "forgotpassword.php";
	          </script>
	       	'; 
      	}
   } else {
      echo '
         <script>
            alert("Your Information Doesnt Match!!!");
            self.location = "forgotpassword.php";
         </script>
      ';
   }
   
?>