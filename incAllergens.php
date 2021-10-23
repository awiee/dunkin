<div class="container-fluid">
	<div class="row">
			<?php
				include 'conn.php';
				$sql = "SELECT * FROM donuts WHERE Allergence = 1 ORDER BY criteriaRefId";
				$rs = mysqli_query($conn,$sql);
				if (mysqli_num_rows($rs) > 0){
					while($row = mysqli_fetch_assoc($rs)) {
						$Name = $row["Name"];
						$Code = $row["Code"];
						$Type = $row["Type"];
						$Criteria = get("criteria",$row["criteriaRefId"],"Name");
			?>
				
				<div class="col-xs-6">
					<div class="form-group" style="border:1px groove black;padding: 10px;border-radius: 5px;">
						<div class="row">
							<div class="col-xs-3 text-center">
								<label><?php echo $Criteria." ".$Type; ?></label>
							</div>
							<div class="col-xs-6">
								<label><?php echo $Name; ?></label>
							</div>
							<div class="col-xs-3">
								<input type="text" class="form-control number-- text-center" name="donut_<?php echo $row["RefId"]; ?>" id="item_<?php echo $row["RefId"]; ?>" style="border: 1px solid black;" placeholder="QTY">
							</div>
						</div>
					</div>
				</div>
			<?php
					}
				} else {
			?>
				<div class="col-xs-12">
					<label>No Record Found</label>
				</div>
			<?php
				}
			?>
	</div>
</div>