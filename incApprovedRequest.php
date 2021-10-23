<?php
   include 'conn.php';
   date_default_timezone_set("Asia/Manila");
   $t = time();
   $date_today    = date("Y-m-d",$t);
   $curr_time     = date("h:i A",$t);
   $EmployeesRefId = $_SESSION["RefId"];
   $BranchRefId = $_SESSION["BranchRefId"];
   $sql = "SELECT * FROM delivery WHERE EmployeesRefId = $EmployeesRefId AND branchRefId = $BranchRefId AND Status = 'A' AND ApprovedDate = '$date_today'";
   $rs = mysqli_query($conn,$sql);
?>
<div class="row margin-top" style="padding: 1%;">
   <div class="panel-group">
      <?php
         if (mysqli_num_rows($rs) > 0) {
            $Delivery = mysqli_fetch_assoc($rs);
            $DelRefId = $Delivery["RefId"];
            $DelDriver = $Delivery["DeliveryBy"];
            $DelShiftId = $Delivery["DeliveryShift"];
            if ($DelShiftId == 1){
               $DelShift = "First Delivery";
            } else if ($DelShiftId == 2) {
               $DelShift = "Second Delivery";
            } else {
               $DelShift = "Third Delivery";
            }
      ?>
      <div class="panel-design">
         <div class="panel-top">
            <div class="row">
               <div class="col-xs-6">REQUEST NO. [<?php echo $DelRefId; ?>]</div>
               <div class="col-xs-6 text-right">STATUS: <strong>APPROVED</strong></div>
            </div>
            <div class="row margin-top">
               <div class="col-xs-12">SHIFT: <strong><?php echo $DelShift; ?></strong></div>
            </div>
            <div class="row margin-top">
               <div class="col-xs-4">
                  <?php
                        $sql = "SELECT * FROM employees WHERE RefId = $DelDriver";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result) > 0){
                           $drvRow = mysqli_fetch_assoc($result);
                           $drvFullName = $drvRow["LastName"].", ".$drvRow["FirstName"];
                           echo 'TO BE DELIVERED BY: <strong>'.$drvFullName.'</strong>';
                        }
                  ?>   
               </div>
               <div class="col-xs-4">APPROVED DATE: <?php echo $Delivery["ApprovedDate"]; ?> </div>
               <div class="col-xs-4">APPROVED TIME: <?php echo $Delivery["ApprovedTime"]; ?> </div>
            </div>
         </div>
         <div class="panel-mid">
            <div class="row">
               <div class="col-xs-12">
                  <div class="row" style="padding: 1%;">
                     <table style="width:100%;color:#000;border:1px solid black;" border=1 class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr class="text-center" style="background:#4d0000;font-size:10pt;color:#fff;">
                              <td width="5%">#</td>
                              <td width="30%">DONUT NAME</td>
                              <td width="15%">REQUEST QUANTITY (Pcs)</td>
                              <td width="15%">APPROVED VALUE</td>
                              <td width="35%">REMARKS</td>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              $sql = "SELECT * FROM delivery_approved_details WHERE DeliveryRefId = $DelRefId AND EmployeesRefId = $EmployeesRefId AND branchRefId = $BranchRefId";
                              $result = mysqli_query($conn,$sql);
                              if (mysqli_num_rows($result) > 0) {
                                 $i = 0;
                                 while($row = mysqli_fetch_assoc($result)) {
                                    $i++;

                                 
                           ?>
                           <tr>
                              <td class="text-center">
                              <?php echo $i; ?>
                              </td>
                              <td style="padding-left:4%;">
                                 <label><?php echo get("donuts",$row["DonutsRefId"],"Name"); ?></label>
                              </td>
                              <td class="text-center">
                                 <label><?php echo $row["DonutsQty"]; ?></label>
                              </td>
                              <td class="text-center">
                                 <label><?php echo $row["ApprvValue"]; ?></label>
                              </td>
                              <td class="text-center">
                                 <textarea type="text" class="form-control" readonly><?php echo $row["Remarks"]; ?></textarea>
                              </td>
                           </tr>
                           <?php
                                 }
                              }
                           ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-bot">
            <input type="hidden" id="hRefId" value="<?php echo $DelRefId; ?>">
            <input type="hidden" id="hBranchRefId" value="<?php echo $BranchRefId;?>">
            <button type="button" class="btn btn-info" id="reqDeliver">DELIVERED</button>
         </div>
      </div>
      <?php
         } else {
            echo '<h4><label>NO APPROVED REQUEST</label></h4>';
         }
      ?>
   </div>
</div>
