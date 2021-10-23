<?php
	include 'conn.php';
	include '214Function.php';
	include 'external.php';

	$datefrom = $_POST["datefrom"];
	$dateto = $_POST["dateto"];
	$delShift = $_POST["delShift"];
	if ($dateto == ""){
		$dateto = date("Y-m-d", time());
	}
	$del_sql = "SELECT * FROM delivery WHERE Status = 'D'";
	if ($delShift != "") {
		$del_sql .= " AND DeliveryShift = $delShift";
	}
	if ($datefrom != "") {
		$del_sql .= " AND DeliveredDate BETWEEN '$datefrom' AND '$dateto'";
	}
	if ($delShift == 1) {
		$shift = "FIRST DELIVERY";
	} else if ($delShift == 2) {
		$shift = "SECOND DELIVERY";
	} else {
		$shift = "THIRD DELIVERY";
	}
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
				<button type="button" class="btn btn-danger" onclick="self.location = 'rptDonutProjection.php'">BACK</button>
			</div>
		</div>
		<div class="row card">
			<div class="col-xs-12">
				<?php rptHeader("DONUT PROJECTION REPORT"); ?>
				<table border="1" width="100%" style="color: #000;">
					<thead>
						<?php
							$branch_rs = mysqli_query($conn,"SELECT * FROM branch");
							$branch_rowcount = mysqli_num_rows($branch_rs);
							$w = 75 / $branch_rowcount;
							if ($branch_rowcount > 0) {
								echo '
									<tr>
										<th colspan="'.($branch_rowcount + 3).'" class="head">'.$shift.'</th>
									</tr>
									<tr>
										<th class="head" style="width:25%;" colspan=3> &nbsp; </th>
								';
									while ($branch_row = mysqli_fetch_assoc($branch_rs)) {
										echo '
										<th class="head" style="width:'.$w.'%;">'.$branch_row["Name"].'</th>
										';
									}
								echo '
									</tr>
								';
							}
						?>
					</thead>
					<tbody>
						<td class="body"></td>
						<td class="body"></td>
						<td class="body"></td>
						<?php
							/*$A_rs = mysqli_query($conn,"SELECT * FROM donuts WHERE Allergence = 0");
							$A_count = mysqli_num_rows($A_rs);
							if ($A_count > 0) {
								while ($A_row = mysqli_fetch_assoc($A_rs)) {
									echo '
										<tr>
											<td class="body">NA</td>
											<td class="body">'.get("criteria",$A_row["criteriaRefId"],"Name").' '.$A_row["Type"].'</td>
											<td class="body" style="text-align: left;">'.$A_row["Name"].'</td>
									';*/
										
												//-----------//
												$branch_2nd_rs = mysqli_query($conn,"SELECT * FROM branch");
												if ($branch_2nd_rs) {
													while ($branch_2nd_row = mysqli_fetch_assoc($branch_2nd_rs)) {
														$branchrefid = $branch_2nd_row["RefId"];
														echo '<td>'.$branchrefid.'</td>';


														$del_rs = mysqli_query($conn,$del_sql);
														if (mysqli_num_rows($del_rs) > 0) {
															while ($del_row = mysqli_fetch_assoc($del_rs)) {
																$delrefid = $del_row["RefId"];
														
														$donut_del_sql = "SELECT SUM(`ApprvValue`) AS 'TOTAL' FROM delivery_approved_details WHERE DeliveryRefId = $delrefid AND BranchRefId = $branchrefid";
														echo $donut_del_sql."<br>";
														$donut_del_rs = mysqli_query($conn,$donut_del_sql);
														if (mysqli_num_rows($donut_del_rs) > 0) {
															$total_row = mysqli_fetch_assoc($donut_del_rs);
															$total = $total_row["TOTAL"];
															echo '
																<td class="body">'.$total.'</td>
															';
														} else {
															echo '
																<td class="body">0</td>
															';
														}
														}
													}
												//---------//
												}
										}
										
									/*echo '
										</tr>
									';
								}
							}*/
						?>
					</tbody>
				</table>
			</div>
		</div>
		<?php rptFooter(); ?>
	</body>
</html>