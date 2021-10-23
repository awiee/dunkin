<?php
	include 'conn.php';
	include '214Function.php';
	include 'external.php';

	$DelRefId = $_POST["delRefId"];
	$EmpRefId = $_POST["empRefId"];
	$BranchRefId = $_POST["branchRefId"];
	$DriverRefId = $_POST["driverRefId"];
	$DelShift = $_POST["delShift"];
	$Status = $_POST["status"];
	$ReqDateFrom = $_POST["reqDateFrom"];
	$ReqDateTo = $_POST["reqDateTo"];
	$ApprvDateFrom = $_POST["apprvDateFrom"];
	$ApprvDateTo = $_POST["apprvDateTo"];
	$CancelDateFrom = $_POST["cancelDateFrom"];
	$CancelDateTo = $_POST["cancelDateTo"];
	$DelDateFrom = $_POST["delDateFrom"];
	$DelDateTo = $_POST["delDateTo"];
	$DelDetail = $_POST["delDetails"];
	$Req_delDetails = $_POST["Req_delDetails"];
	$Apprv_delDetails = $_POST["Apprv_delDetails"];
	$Cncl_delDetails = $_POST["Cncl_delDetails"];

	if ($ReqDateTo == ""){
		$ReqDateTo = date("Y-m-d", time());
	}
	if ($ApprvDateTo == ""){
		$ApprvDateTo = date("Y-m-d", time());
	}
	if ($CancelDateTo == ""){
		$CancelDateTo = date("Y-m-d", time());
	}
	if ($DelDateTo == ""){
		$DelDateTo = date("Y-m-d", time());
	}

	if ($Status == "P"){
		$Stat = "Pending";
	} else if ($Status == "A"){
		$Stat = "Approved";
	} else if ($Status == "D"){
		$Stat = "Delivered";
	} else if ($Status == "C"){
		$Stat = "Cancelled";
	}
	
	$thDate = "";
	$whereclause = "";
	$srcCriteria = "";
	if ($DelRefId != ""){
		$whereclause .= "WHERE RefId = $DelRefId";
		$srcCriteria .= '
			<div class="row">
				Delivery Reference Id: '.$DelRefId.'
			</div>
		';
	} else {
		$whereclause .= "WHERE RefId != ''";
	}

	if ($EmpRefId != ""){
		$whereclause .= " AND EmployeesRefId = $EmpRefId";
		$fullname = get("employees",$EmpRefId,"LastName").", ".get("employees",$EmpRefId,"FirstName");
		$srcCriteria .= '
			<div class="row">
				Employee: '.$fullname.'
			</div>
		';
	}
	if ($BranchRefId != ""){
		$whereclause .= " AND BranchRefId = $BranchRefId";
		$srcCriteria .= '
			<div class="row">
				Branch: '.get("branch",$BranchRefId,"Name").'
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
	if ($Status != ""){
		$whereclause .= " AND Status = '$Status'";
		$srcCriteria .= '
			<div class="row">
				Status: '.$Stat.'
			</div>
		';
	}
	if ($ReqDateFrom != ""){
		$whereclause .= " AND RequestDate BETWEEN '$ReqDateFrom' AND '$ReqDateTo'";
		$thDate = " <th class='head'>REQUESTED DATE</th>";
		$srcCriteria .= '
			<div class="row">
				Request Date From: '.$ReqDateFrom.'
			</div>
			<div class="row">
				Request Date To: '.$ReqDateTo.'
			</div>
		';
	}
	if ($ApprvDateFrom != ""){
		$whereclause .= " AND ApprovedDate BETWEEN '$ApprvDateFrom' AND '$ApprvDateTo'";	
		$thDate = " <th class='head'>APPROVED DATE</th>";
		$srcCriteria .= '
			<div class="row">
				Approved Date From: '.$ApprvDateFrom.'
			</div>
			<div class="row">
				Approved Date To: '.$ApprvDateTo.'
			</div>
		';
	}
	if ($CancelDateFrom != ""){
		$whereclause .= " AND CancelledDate BETWEEN '$CancelDateFrom' AND '$CancelDateTo'";	
		$thDate = " <th class='head' class='head'>CANCELLED DATE</th>";
		$srcCriteria .= '
			<div class="row">
				Cancelled Date From: '.$CancelDateFrom.'
			</div>
			<div class="row">
				Cancelled Date To: '.$CancelDateTo.'
			</div>
		';
	}
	if ($DelDateFrom != ""){
		$whereclause .= " AND DeliveredDate BETWEEN '$DelDateFrom' AND '$DelDateTo'";	
		$thDate = " <th class='head'>DELIVERED DATE</th>";
		$srcCriteria .= '
			<div class="row">
				Delivered Date From: '.$DelDateFrom.'
			</div>
			<div class="row">
				Delivered Date To: '.$DelDateTo.'
			</div>
		';
	}

	if ($thDate != ""){
		$colspan = 7;
	} else {
		$colspan = 6;
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
				<button type="button" class="btn btn-danger" onclick="self.location = 'rptDelivery.php'">BACK</button>
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
							<th class="head">STATUS</th>
							<th class="head">DELIVERY TYPE</th>
							<?php echo $thDate; ?>
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
									$Type = $row["DeliveryType"];
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
									if ($Status == "P"){
										$Status = "Pending";
									} else if ($Status == "A"){
										$Status = "Approved";
									} else if ($Status == "D"){
										$Status = "Delivered";
									} else if ($Status == "C"){
										$Status = "Cancelled";
									}
									if ($ReqDateFrom != "") {
										$tdDate = '<td class="body">'.$ReqDate.'</td>';
									}
									if ($ApprvDateFrom != "") {
										$tdDate = '<td class="body">'.$ApprvDate.'</td>';
									}
									if ($CancelDateFrom != "") {
										$tdDate = '<td class="body">'.$CancelDate.'</td>';
									}
									if ($DelDateFrom != "") {
										$tdDate = '<td class="body">'.$DelDate.'</td>';
									}
									echo '
									<tr>
										<td class="body">'.$RefId.'</td>
										<td class="body" style="text-align:left;padding-left:15px;">[ '.$EmpRefId.' ] - '.$EmpName.'</td>
										<td class="body" style="text-align:left;padding-left:15px;">[ '.$BranchRefId.' ] - '.$BranchName.'</td>
										<td class="body">'.$DelShift.'</td>
										<td class="body">'.$DelBy.'</td>
										<td class="body">'.$Status.'</td>
										<td class="body">'.$Type.'</td>
										'.$tdDate.'
									</tr>';
									if ($DelDetail == 1 || $Apprv_delDetails == 1) {	
										echo '
										<tr>
											<td  colspan="11" style="padding:3px;">
												<table width="100%" class="table">
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
													$dntAllergence = get("donuts",$dntRow["DonutsRefId"],"Allergence");
													$dntType = get("donuts",$dntRow["DonutsRefId"],"Type");
													$dntCriteria = get("donuts",$dntRow["DonutsRefId"],"criteriaRefId");
													$dntCriteria = get("criteria",$dntCriteria,"Name");
													if ($dntRow["ApprvValue"] == "") {
														$dntQty = $dntRow["DonutsQty"];
													} else {
														$dntQty = $dntRow["ApprvValue"];
													}
													if ($dntAllergence == 1) {
														$dntAllergence = "Allergence";
													} else {
														$dntAllergence = "Non-Allergence";
													}
													echo '
														<tr>
															<td class="body" style="text-align:left;padding-left:25px;">
																[ '.$dntAllergence.' ] [ '.$dntType.' ] [ '.$dntCriteria.' ] '.$dntName.'
															</td>
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
											<td colspan="11" style="background:#d9d9d9; padding-top:15px; padding-bottom:15px;">
											<div style="border:1px dashed #a6a6a6;"></div>
											</td>
										</tr>
										';
									}

									if ($Cncl_delDetails == 1 || $Req_delDetails == 1) {	
										echo '
										<tr>
											<td  colspan="11" style="padding:3px;">
												<table width="100%" border="1">
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
											$dntSql = "SELECT * FROM delivery_request_details ".$dntClause;
											$dntRs = mysqli_query($conn,$dntSql);
											if ($dntRs) {
												while($dntRow = mysqli_fetch_assoc($dntRs)) {
													$dntName = get("donuts",$dntRow["DonutsRefId"],"Name");
													$dntAllergence = get("donuts",$dntRow["DonutsRefId"],"Allergence");
													$dntType = get("donuts",$dntRow["DonutsRefId"],"Type");
													$dntQty = $dntRow["DonutsQty"];
													$dntCriteria = get("donuts",$dntRow["DonutsRefId"],"criteriaRefId");
													$dntCriteria = get("donuts",$dntCriteria,"Name");
													if ($dntAllergence == 1) {
														$dntAllergence = "Allergence";
													} else {
														$dntAllergence = "Non-Allergence";
													}
													echo '
														<tr>
															<td class="body" style="text-align:left;padding-left:25px;">
																[ '.$dntAllergence.' ] [ '.$dntType.' ] [ '.$dntCriteria.' ] '.$dntName.'
															</td>
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
											<td colspan="11" style="background:gray;">&nbsp;</td>
										</tr>
										';
									}
								}
							} else {
								echo "
									<tr>
										<td class='body' colspan='15'>
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
						<?php echo $srcCriteria; ?>
					</div>
				</div>
			</div>
		</div>
		<?php rptFooter(); ?>
	</body>
</html>