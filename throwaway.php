<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
         include 'conn.php';
      ?>
      <script type="text/javascript" src="js/ctrl/ctrl_throwaway.js"></script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="throwaway">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">THROW AWAY</div>
                           <div class="panel-mid">
                              <div class="row">
                                 <div class="col-xs-12">
                                    <a href="empThrowAway.php" class="btn btn-success">PRINT THROW AWAY REPORT</a>
                                 </div>
                              </div>
                              <div class="row margin-top">
                                 <div class="col-xs-9">
                                    <table id="dataList" style="color:#000;" class="table table-striped table-bordered table-hover">
                                       <thead>
                                          <tr class="text-center" style="background:#4d0000;font-size:10pt;color:#fff;">
                                             <td width="5%">#</td>
                                             <td width="20%">TYPE</td>
                                             <td width="35%">DONUT NAME</td>
                                             <td width="15%">STOCK</td>
                                             <td width="10%">QTY</td>
                                             <td width="15%">ACTION</td>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                             $BranchRefId = $_SESSION["BranchRefId"];
                                             $sql = "SELECT * FROM branch_stock WHERE BranchRefId = $BranchRefId AND Stock != 0";
                                             $rs = mysqli_query($conn,$sql);
                                             if ($rs) {
                                                $i = 0;
                                                while($row = mysqli_fetch_assoc($rs)) {
                                                   $i++;
                                                   $Code = get("donuts",$row["DonutRefId"],"Code");
                                                   $Name = get("donuts",$row["DonutRefId"],"Name");
                                                   $Type = get("donuts",$row["DonutRefId"],"Type");
                                                   $Criteria = get("donuts",$row["DonutRefId"],"criteriaRefId");
                                                   $Criteria = get("criteria",$Criteria,"Name");
                                                   $Qty = $row["Stock"];
                                          ?>
                                          <tr>
                                             <td class="text-center">
                                                <?php echo $i; ?>
                                             </td>
                                             <td class="text-center">
                                                <?php echo $Criteria." ".$Type; ?>
                                             </td>
                                             <td style="padding-left:4%;" id="name_<?php echo $row["DonutRefId"]; ?>">
                                                <?php echo $Name; ?>
                                             </td>
                                             <td class="text-center" id="stock_<?php echo $row["DonutRefId"]; ?>"><?php echo $Qty; ?></td>
                                             <td>
                                                <input type="text" class="form-control number-- text-center" id="qty_<?php echo $row["DonutRefId"]; ?>" name="qty_<?php echo $row["DonutRefId"]; ?>">
                                             </td>
                                             <td class="text-center">
                                                <button type="button" class="btn btn-info" id="action_<?php echo $row["DonutRefId"]; ?>">THROW AWAY</button>
                                             </td>
                                          </tr>
                                          <?php
                                                }
                                             }

                                          ?>
                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="col-xs-3">
                                    <div class="row" style="padding: 5px;">
                                       <div class="col-xs-12" style="border: 1px solid black;">
                                          <div class="row" style="border-bottom: 1px solid black;background: gray; color: #fff;">
                                             <div class="col-xs-4">
                                                QTY
                                             </div>
                                             <div class="col-xs-8 text-right">
                                                DONUT NAME
                                             </div>
                                          </div>
                                          <div class="row" style="height: 400px; overflow: auto;">
                                             <div class="col-xs-12" id="cart"></div>
                                          </div>
                                          <div class="row" id="hcart"></div>
                                          <div class="row" style="border-top: 1px solid black; padding: 3px;">
                                             <div class="col-xs-6">
                                                <button type="button" class="btn btn-danger" id="clr">CLEAR</button>
                                             </div>
                                             <div class="col-xs-6 text-right">
                                                <button type="button" class="btn btn-info" id="prcd">PROCEED</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
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