<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
         include 'conn.php';
      ?>
      <link rel="stylesheet" type="text/css" href="css/rpt.css">
      <style>
         td{
            padding: 5px;
         }
      </style>
      <script>
         $(document).ready(function () {
            
         });
      </script>
   </head>
   <body>
      <div class="row noPrint" >
         <div class="col-xs-12" style="margin-left: 15px; margin-top: 10px;">
            <button type="button" class="btn btn-warning" onclick="self.print();">PRINT</button>
            <button type="button" class="btn btn-danger" onclick="self.location = 'stockCheck.php'">BACK</button>
         </div>
      </div>
      <div class="row card">
         <div class="col-xs-12">
            <?php rptHeader("STOCK REPORT"); ?>
            <table border="1" width="100%" style="color: #000;">
               <thead>
                  <tr>
                     <th class="head">#</th>
                     <th class="head">ALLERGENCE</th>
                     <th class="head">DONUT CODE</th>
                     <th class="head">DONUT CRITERIA</th>
                     <th class="head">DONUT TYPE</th>
                     <th class="head">DONUT NAME</th>
                     <th class="head">STOCKS LEFT</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $sql = "SELECT * FROM branch_stock WHERE BranchRefId = ".$_SESSION["BranchRefId"];
                     $rs = mysqli_query($conn,$sql);
                     if (mysqli_num_rows($rs) > 0){
                        $i = 0;
                        while($row = mysqli_fetch_assoc($rs)) {
                           $i++;
                           $DonutName = get("donuts",$row["DonutRefId"],"Name");
                           $Allergence = get("donuts",$row["DonutRefId"],"Allergence");
                           if ($Allergence == 0) {
                              $Allergence = "Non-Allergence";
                           } else {
                              $Allergence = "Allergence";
                           }
                           $Code = get("donuts",$row["DonutRefId"],"Code");
                           $Type = get("donuts",$row["DonutRefId"],"Type");
                           $Criteria = get("donuts",$row["DonutRefId"],"criteriaRefId");
                  ?>
                     <tr>
                        <td class="body">
                           <?php echo $i; ?>
                        </td>
                        <td class="body">
                           <?php echo $Allergence; ?>
                        </td>
                        <td class="body">
                           <?php echo $Code; ?>
                        </td>
                        <td class="body">
                           <?php echo get("criteria",$Criteria,"Name"); ?>
                        </td>
                        <td class="body">
                           <?php echo $Type; ?>
                        </td>
                        <td class="body">
                           <?php echo $DonutName; ?>
                        </td>
                        <td class="body">
                           <?php echo $row["Stock"]; ?>
                        </td>
                     </tr>
                  <?php
                        }
                     }
                  ?>
               </tbody>
            </table>
         </div>
         <?php rptFooter(); ?>
      </div>
   </body>
</html>