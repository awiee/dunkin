<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="rptDonutProjection">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div>
                     <form method="post" action="ctrl_rptDonutProjection.php">
                        <div class="panel-group">
                           <div class="panel-design">
                              <div class="panel-top">DONUT PROJECTION</div>
                              <div class="panel-mid">
                                 <div class="row">
                                    <div class="col-xs-12">
                                       <div class="form-group">
                                          <div class="row margin-top">
                                             <div class="col-xs-4">
                                                <label>DATE FROM:</label>
                                                <input type="text" class="form-control date--" name="datefrom">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>DATE TO:</label>
                                                <input type="text" class="form-control date--" name="dateto">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>DELIVERY SHIFT</label>
                                                <select class="form-control" name="delShift" required="true">
                                                   <option value="">SELECT SHIFT</option>
                                                   <option value="1">FIRST SHIFT</option>
                                                   <option value="2">SECOND SHIFT</option>
                                                   <option value="3">THIRD SHIFT</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-bot">
                                 <button type="submit" class="btn btn-info" id="btn_generate">GENERATE REPORT</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="footer">
                  <label>DUNKIN <?php echo date("Y",time()); ?></label>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>