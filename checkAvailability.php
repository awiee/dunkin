<?php
	function FindFirst($table,$whereClause,$fld) {
        include 'conn.php';

        if ($fld == "*") {
           $sql = "SELECT * FROM `".strtolower($table)."` ".$whereClause;
        } else if (stripos($fld,",") > 0) {
           $sql = "SELECT $fld FROM `".strtolower($table)."` ".$whereClause;
        } else {
           $sql = "SELECT $fld FROM `".strtolower($table)."` ".$whereClause;
        }
        $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($result);
        $numrow = mysqli_num_rows($result);
        mysqli_close($conn);
        if ($numrow <= 0) {
           return false;
        } else {
           if ($fld == "*" || stripos($fld,",") > 0) {
              return $row;
           } else {
              return $row[$fld];
           }
        }
    }
	include 'conn.php';

	$table = $_POST["hTable"];
	if ($table == "employees") {
		$fname = mysqli_real_escape_string($conn,$_POST["FirstName"]);
		$branchRefId = mysqli_real_escape_string($conn,$_POST["branchRefId"]);
		$positionRefId = mysqli_real_escape_string($conn,$_POST["positionRefId"]);
		$FirstName = mysqli_real_escape_string($conn,$_POST["FirstName"]);
		$LastName = mysqli_real_escape_string($conn,$_POST["LastName"]);
		$MiddleName = mysqli_real_escape_string($conn,$_POST["MiddleName"]);
		$clause = "WHERE FirstName = '$fname' AND LastName = '$LastName' AND MiddleName = '$MiddleName' LIMIT 1";
	} else if ($table == "donuts") {
		$name = mysqli_real_escape_string($conn,$_POST["Name"]);
		$Allergence = mysqli_real_escape_string($conn,$_POST["Allergence"]);
		$criteriaRefId = mysqli_real_escape_string($conn,$_POST["criteriaRefId"]);
		$clause = "WHERE Name = '$name' AND Allergence = '$Allergence' AND criteriaRefId = '$criteriaRefId' LIMIT 1";
	} else {
		$name = mysqli_real_escape_string($conn,$_POST["Name"]);
		$clause = "WHERE Name = '$name' LIMIT 1";
	}
	/*$row = FindFirst($table,$clause,"RefId");
	if (!$row) {
		echo 0;
	}*/
	$rs = mysqli_query($conn,"SELECT * FROM `$table`".$clause);
	if (mysqli_num_rows($rs) > 0) {
		echo 1;
	} else {
		echo 0;
	}

?>