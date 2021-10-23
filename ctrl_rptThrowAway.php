<?php
	include 'conn.php';
	include '214Function.php';
	include 'external.php';


	$EmpRefId = $_POST["empRefId"];
	$BranchRefId = $_POST["branchRefId"];
	$datefrom = $_POST["DateFrom"];
	$dateto = $_POST["DateTo"];
	$whereclause = "";
	$srcCriteria = "";
	if ($dateto == ""){
		$dateto = date("Y-m-d", time());
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
	if ($datefrom != ""){
		$whereclause .= " AND ThrowawayDate BETWEEN '$datefrom' AND '$dateto'";
		$srcCriteria .= '
			<div class="row">
				Throw away Date From: '.$datefrom.'
			</div>
			<div class="row">
				Throw away Date To: '.$dateto.'
			</div>
		';
	}
	$sql = "SELECT * FROM throwaway WHERE RefId != 0".$whereclause;
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
				<button type="button" class="btn btn-danger" onclick="self.location = 'rptThrowAway.php'">BACK</button>
			</div>
		</div>
		<div class="row card">
			<div class="col-xs-12">
				<?php rptHeader("THROW AWAY REPORT"); ?>
				<table border="1" width="100%" style="color: #000;">
					<thead>
						<tr>
							<th class="head">REF ID</th>
							<th class="head">EMPLOYEES NAME</th>
							<th class="head">BRANCH</th>
							<th class="head">THROW AWAY DATE</th>
							<th class="head">THROW AWAY TIME</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if (mysqli_num_rows($result) > 0){
								while ($row = mysqli_fetch_assoc($result)){
									$RefId = $row["RefId"];
									$EmpRefId = $row["EmployeesRefId"];
									$BranchRefId = $row["BranchRefId"];
									$TADate = $row["ThrowawayDate"];
									$TATime = $row["ThrowawayTime"];
									/*DRIVER*/
									/*EMPLOYEE*/
									$EmpRS = mysqli_query($conn,"SELECT * FROM employees WHERE RefId = $EmpRefId");
									$EmpRow = mysqli_fetch_assoc($EmpRS);
									$EmpName = $EmpRow["LastName"].", ".$EmpRow["FirstName"];

									/*BRANCH*/
									$BranchRs = mysqli_query($conn,"SELECT * FROM branch WHERE RefId = $BranchRefId");
									$BranchRow = mysqli_fetch_assoc($BranchRs);
									$BranchName = $BranchRow["Name"];

									
									echo '
									<tr>
										<td class="body">'.$RefId.'</td>
										<td class="body" style="text-align:left;padding-left:15px;">[ '.$EmpRefId.' ] - '.$EmpName.'</td>
										<td class="body" style="text-align:left;padding-left:15px;">[ '.$BranchRefId.' ] - '.$BranchName.'</td>
										<td class="body">'.$TADate.'</td>
										<td class="body">'.$TATime.'</td>
									</tr>';
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
										$dntSql = "SELECT * FROM throwaway_details WHERE ThrowawayRefId = $RefId";
										$dntRs = mysqli_query($conn,$dntSql);
										if ($dntRs) {
											while($dntRow = mysqli_fetch_assoc($dntRs)) {
												$dntName = get("donuts",$dntRow["DonutRefId"],"Name");
												$dntAllergence = get("donuts",$dntRow["DonutRefId"],"Allergence");
												$dntType = get("donuts",$dntRow["DonutRefId"],"Type");
												$dntQty = $dntRow["Quantity"];
												$dntCriteria = get("donuts",$dntRow["DonutRefId"],"criteriaRefId");
												$dntCriteria = get("criteria",$dntCriteria,"Name");
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
										<td colspan="5" style="background:#d9d9d9; padding-top:15px; padding-bottom:15px;">
										<div style="border:1px dashed #a6a6a6;"></div>
										</td>
									</tr>
									';
								}
							} else {
								echo "
									<tr>
										<td class='body' colspan='5'>
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