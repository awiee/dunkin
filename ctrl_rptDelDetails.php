<?php
	include 'conn.php';
	include '214Function.php';
	include 'external.php';

	$DelRefId = $_POST["delRefId"];
	$EmpRefId = $_POST["empRefId"];
	$BranchRefId = $_POST["branchRefId"];
	$DriverRefId = $_POST["driverRefId"];
	$DelShift = $_POST["delShift"];

	$whereclause = "";
	$srcCriteria = "";
	$whereclause .= "WHERE Status = 'D'";
	if ($DelRefId != ""){
		$whereclause .= " AND RefId = $DelRefId";
		$srcCriteria .= '
			<div class="row">
				Delivery Reference Id: '.$DelRefId.'
			</div>
		';
	} else {
		$whereclause .= " AND RefId != ''";
	}

	if ($EmpRefId != ""){
		$whereclause .= " AND EmployeesRefId = $EmpRefId";
		$srcCriteria .= '
			<div class="row">
				Employees Reference Id: '.$EmpRefId.'
			</div>
		';
	}
	if ($BranchRefId != ""){
		$whereclause .= " AND BranchRefId = $BranchRefId";
		$srcCriteria .= '
			<div class="row">
				Branch Reference Id: '.$BranchRefId.'
			</div>
		';
	}
	if ($DriverRefId != ""){
		$whereclause .= " AND DeliveryBy = $DriverRefId";
		$srcCriteria .= '
			<div class="row">
				Delivery By: '.$DriverRefId.'
			</div>
		';
	}
	if ($DelShift != ""){
		$whereclause .= " AND DeliveryShift = '$DelShift'";
		$srcCriteria .= '
			<div class="row">
				Delivery Shift: '.$DelShift.'
			</div>
		';
	}
	
	$sql = "SELECT * FROM delivery ".$whereclause;
	$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/rpt.css">
		<style type="text/css">
		
		</style>
	</head>
	<body>
		<div class="row noPrint" >
			<div class="col-xs-12" style="margin-left: 15px; margin-top: 10px;">
				<button type="button" class="btn btn-warning" onclick="self.print();">PRINT</button>
				<button type="button" class="btn btn-danger" onclick="self.location = 'rptDelDetails.php'">BACK</button>
			</div>
		</div>
		<div class="row card">
			<div class="col-xs-12">
				<?php rptHeader("DELIVERY REPORT"); ?>
				<table border="1" width="100%" style="color: #000;">
					<thead>
						<tr>
							<th class="head">REF ID</th>
							<th class="head">EMPLOYEES NAME</th>
							<th class="head">BRANCH</th>
							<th class="head">DELIVERY SHIFT</th>
							<th class="head">DELIVERY BY</th>
							<th class="head">REQUESTED DATE</th>
							<th class="head">REQUESTED TIME</th>
							<!--<th class="head">APPROVED DATE</th>
							<th class="head">APPROVED TIME</th>-->
							<th class="head">DELIVERED DATE</th>
							<th class="head">DELIVERED TIME</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if (mysqli_num_rows($result) > 0){
								while ($row = mysqli_fetch_assoc($result)){
									$RefId = $row["RefId"];
									$EmpRefId = $row["EmployeesRefId"];
									$BranchRefId = $row["BranchRefId"];
									$DelShift = $row["DeliveryShift"];
									$DelBy = $row["DeliveryBy"];
									$Status = $row["Status"];
									$ReqDate = $row["RequestDate"];
									$ApprvDate = $row["ApprovedDate"];
									$CancelDate = $row["CancelledDate"];
									$DelDate = $row["DeliveredDate"];
									/*DRIVER*/
									$sqlDriver = "SELECT * FROM employees WHERE RefId = $DelBy";
									$DriverRS = mysqli_query($conn,$sqlDriver);
									if ($DriverRS) {
										$DriverRow = mysqli_fetch_assoc($DriverRS);	
										$DelBy = $DriverRow["LastName"].", ".$DriverRow["FirstName"];
									} else {
										$DelBy = "";
									}
									

									

									/*EMPLOYEE*/
									$EmpRS = mysqli_query($conn,"SELECT * FROM employees WHERE RefId = $EmpRefId");
									$EmpRow = mysqli_fetch_assoc($EmpRS);
									$EmpName = $EmpRow["LastName"].", ".$EmpRow["FirstName"];

									/*BRANCH*/
									$BranchRs = mysqli_query($conn,"SELECT * FROM branch WHERE RefId = $BranchRefId");
									$BranchRow = mysqli_fetch_assoc($BranchRs);
									$BranchName = $BranchRow["Name"];

									$tdDate = "";
									if ($DelShift == "1"){
										$DelShift = "First Delivery";
									} else if ($DelShift == "2") {
										$DelShift = "Second Delivery";
									} else if ($DelShift == "3") {
										$DelShift = "Third Delivery";
									}
									echo '
									<tr>
										<td class="body">'.$RefId.'</td>
										<td class="body">[ '.$EmpRefId.' ] - '.$EmpName.'</td>
										<td class="body">[ '.$BranchRefId.' ] - '.$BranchName.'</td>
										<td class="body">'.$DelShift.'</td>
										<td class="body">'.$DelBy.'</td>
										<td class="body">'.$ReqDate.'</td>
										<td class="body">'.$row["RequestTime"].'</td>
										<!--<td class="body">'.$ApprvDate.'</td>
										<td class="body">'.$row["ApprovedTime"].'</td>-->
										<td class="body">'.$DelDate.'</td>
										<td class="body">'.$row["DeliveredTime"].'</td>
									</tr>
									<tr>
										<td  colspan="11" style="padding:3px;">
											<table width="50%" border="1">
												<thead>
													<tr>
														<th class="head" width="60%">DONUT NAME</th>
														<th class="head" width="40%">DONUT QUANTITY</th>
													</tr>
												</thead>
												<tbody>
									';
										$dntClause = "";
										if ($RefId != ""){
											$dntClause .= " WHERE DeliveryRefId = $RefId";
										} else {
											$dntClause .= " WHERE DeliveryRefId != ''";
										}

										if ($EmpRefId != ""){
											$dntClause .= " AND EmployeesRefId = $EmpRefId";
										}
										if ($BranchRefId != ""){
											$dntClause .= " AND BranchRefId = $BranchRefId";
										}
										$dntSql = "SELECT * FROM delivery_approved_details ".$dntClause;
										$dntRs = mysqli_query($conn,$dntSql);
										if ($dntRs) {
											while($dntRow = mysqli_fetch_assoc($dntRs)) {
												$dntName = get("donuts",$dntRow["DonutsRefId"],"Name");
												if ($dntRow["ApprvValue"] == "") {
													$dntQty = $dntRow["DonutsQty"];
												} else {
													$dntQty = $dntRow["ApprvValue"];
												}
												echo '
													<tr>
														<td class="body">'.$dntName.'</td>
														<td class="body">'.$dntQty.'</td>
													</tr>

												';
											}
										}

									echo '		

												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td colspan="11">&nbsp;</td>
									</tr>
									';
								}
							} else {
								echo "
									<tr>
										<td class='body' colspan='".$colspan."'>
											No Record Found Base On Your Criteria.
										</td>
									</tr>
								";
							}
						?>
					</tbody>
				</table>
				<div class="row margin-top noPrint">
					<div class="col-xs-12">
						<div class="row">
							<label>No. of Record: <?php echo mysqli_num_rows($result) ?></label>
						</div>
						<div class="row">
							<label>Search Criteria:</label>
						</div>
						<?php 
							if ($srcCriteria == "") {
								$srcCriteria = "No Search Criteria.";
							}
							echo $srcCriteria; 
						?>
					</div>
				</div>
			</div>
		</div>
		<?php rptFooter(); ?>
	</body>
</html>