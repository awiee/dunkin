<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
         include 'conn.php';
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
         <input type="hidden" name="hTable" id="hTable" value="stockCheck">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">STOCK OF DONUTS</div>
                           <div class="panel-mid">
                              <div class="row" style="margin-bottom: 10px;">
                                 <div class="col-xs-12">
                                    <button type="button" class="btn btn-warning" onclick="self.location='stock.php';">
                                       <i class="fa fa-print" aria-hidden="true"></i>&nbsp;PRINT STOCK
                                    </button>
                                 </div>
                              </div>
                              <table id="dataList" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr style="background:#4d0000;font-size:10pt;color:#fff;">
                                       <th style="width: 10%;text-align:center;">ID</th>
                                       <th style="width: 15%;text-align:center;">DONUT CODE</th>
                                       <th style="width: 25%;text-align:center;">DONUT NAME NAME</th>
                                       <th style="width: 15%;text-align:center;">STOCK (Pcs)</th>
                                       <th style="width: 35%;text-align:center;">DESCRIPTION</th>
                                    </tr>
                                 </thead>
                                 <tbody style="color: #000;">
                                    <?php
                                       $sql = "SELECT * FROM branch_stock WHERE BranchRefId = ".$_SESSION["BranchRefId"];
                                       $rs = mysqli_query($conn,$sql);
                                       if (mysqli_num_rows($rs) > 0){
                                          while($row = mysqli_fetch_assoc($rs)) {
                                             $DonutName = get("donuts",$row["DonutRefId"],"Name");
                                             $DonutDes = get("donuts",$row["DonutRefId"],"Remarks");
                                             $DonutCode = get("donuts",$row["DonutRefId"],"Code");
                                    ?>
                                       <tr>
                                          <td style="text-align:center;">
                                             <?php echo $row["RefId"]; ?>
                                          </td>
                                          <td style="width:70px;text-align:center;color:#000;">
                                             <?php echo $DonutCode; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $DonutName; ?>
                                          </td>
                                          <td style="color:#000;text-align: center;">
                                             <?php echo $row["Stock"]; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $DonutDes; ?>
                                          </td>
                                       </tr>
                                    <?php
                                          }
                                       }
                                    ?>
                                 </tbody>
                              </table>
                              <div style="background:#bbb;height:1px;margin-top:10px;margin-bottom:10px;"></div>
                              <div class="row">
                                 <div class="col-xs-12">
                                    <div class="row" style="margin-left: 1%;">
                                       <label>DONUTS WITH CRITICAL STOCK(s):</label>
                                    </div>
                                    <?php
                                       $sql = "SELECT * FROM branch_stock WHERE BranchRefId = ".$_SESSION["BranchRefId"]." AND Stock < 20";
                                       $result = mysqli_query($conn,$sql);
                                       if (mysqli_num_rows($result) > 0){
                                          while ($stock = mysqli_fetch_assoc($result)) {
                                    ?>
                                       <div class="row margin-top">
                                          <div class="col-xs-10">
                                             <div class="row">
                                                <div class="col-xs-3">
                                                   CODE:&nbsp;&nbsp;&nbsp;<label><?php echo get("donuts",$stock["DonutRefId"],"Code"); ?></label>
                                                </div>
                                                <div class="col-xs-4">
                                                   NAME:&nbsp;&nbsp;&nbsp;<label><?php echo get("donuts",$stock["DonutRefId"],"Name"); ?></label>
                                                </div>
                                                <div class="col-xs-2">
                                                   STOCK:&nbsp;&nbsp;&nbsp;<label style="color: red;"><?php echo $stock["Stock"]; ?></label>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                          }
                                       } else {
                                          echo "<label>No Items on Critical Level.</label>";
                                       }
                                    ?>
                                 </div>
                              </div>
                           </div>
                           <div class="panel-bot">
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