<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
      </style>
      <script>
         $(document).ready(function () {
            
         });
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="stock_trail">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">LIST OF</div>
                           <div class="panel-mid">
                              <table id="dataList" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr style="background:#4d0000;font-size:10pt;color:#fff;">
                                       <th style="text-align:center;width: 5%;">#</th>
                                       <th style="text-align:center;width: 35%;">DONUT NAME</th>
                                       <th style="text-align:center;width: 15%;">DELIVERY DATE</th>
                                       <th style="text-align:center;width: 15%;">DELIVERY TIME</th>
                                       <th style="text-align:center;width: 10%;">CURRENT</th>
                                       <th style="text-align:center;width: 10%;">DELIVERED</th>
                                       <th style="text-align:center;width: 10%;">NEW</th>
                                    </tr>
                                 </thead>
                                 <tbody style="color: #000;">
                                    <?php
                                       include 'conn.php';
                                       $BranchRefId = $_SESSION["BranchRefId"];
                                       $sql = "SELECT * FROM `stock_trail` WHERE BranchRefId = '$BranchRefId' ORDER BY RefId DESC";
                                       $rs = mysqli_query($conn,$sql);
                                       if (mysqli_num_rows($rs) > 0){
                                          while($row = mysqli_fetch_assoc($rs)) {
                                             $allergence = get("donuts",$row["DonutRefId"],"Allergence");
                                             if ($allergence == 0) {
                                                $allergence = "NA";
                                             } else {
                                                $allergence = "A";
                                             }
                                             $type = get("donuts",$row["DonutRefId"],"Type");
                                             $crit = get("donuts",$row["DonutRefId"],"CriteriaRefId");
                                             $crit = get("criteria",$crit,"Name");
                                             $donut = get("donuts",$row["DonutRefId"],"Name");

                                    ?>
                                       <tr>
                                          <td style="color:#000;text-align: center;">
                                             <?php echo $row["RefId"]; ?>
                                          </td>
                                          <td style="width:70px;color:#000;">
                                             <?php echo '[ '.$allergence.' ]--[ '.$crit.'-'.$type.' ] <label>'.$donut.'</label>'; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $row["DeliveryDate"]; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo date("h:i A",$row["DeliveryTime"]); ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $row["Current_Stock"]; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $row["Delivered_Stock"]; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $row["New_Stock"]; ?>
                                          </td>
                                       </tr>
                                    <?php
                                          }
                                       }
                                    ?>
                                 </tbody>
                              </table>
                           </div>
                           <div class="panel-bot">
                              &nbsp;
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="footer">
                  <label>DUNKIN 2017</label>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>