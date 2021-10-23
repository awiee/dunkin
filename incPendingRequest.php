<?php
   include 'conn.php';
   date_default_timezone_set("Asia/Manila");
   $t = time();
   $date_today    = date("Y-m-d",$t);
   $curr_time     = date("h:i A",$t);
   $EmployeesRefId = $_SESSION["RefId"];
   $BranchRefId = $_SESSION["BranchRefId"];
   $sql = "SELECT * FROM delivery WHERE EmployeesRefId = $EmployeesRefId AND branchRefId = $BranchRefId AND Status = 'P' AND RequestDate = '$date_today'";
   $rs = mysqli_query($conn,$sql);
?>
<div class="row margin-top" style="padding: 1%;">
   <div class="panel-group">
      <?php
         if (mysqli_num_rows($rs) > 0) {
            $Delivery = mysqli_fetch_assoc($rs);
            $DelRefId = $Delivery["RefId"];
      ?>
      <div class="panel-design">
         <div class="panel-top">
            <div class="row">
               <div class="col-xs-12">REQUEST NO. [<?php echo $DelRefId; ?>]</div>
            </div>
            <div class="row margin-top">
               <div class="col-xs-12">STATUS: <strong>PENDING</strong></div>
            </div>
            <div class="row margin-top">
               <div class="col-xs-3">REQUEST DATE: <?php echo $Delivery["RequestDate"]; ?> </div>
               <div class="col-xs-3">REQUEST TIME: <?php echo $Delivery["RequestTime"]; ?> </div>
            </div>
         </div>
         <div class="panel-mid">
            <div class="row">
               <div class="col-xs-1"></div>
               <div class="col-xs-10">
                  <div class="row">
                     <table style="width:100%;color:#000;border:1px solid black;" border=1 class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr class="text-center" style="background:#4d0000;font-size:10pt;color:#fff;">
                              <td>#</td>
                              <td>DONUT NAME</td>
                              <td>REQUEST QUANTITY (Pcs)</td>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              $sql = "SELECT * FROM delivery_request_details WHERE DeliveryRefId = $DelRefId";
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
      </div>
      <?php
         } else {
            echo '<h4><label>NO PENDING REQUEST</label></h4>';
         }
      ?>
   </div>
</div>
