<?php
include '214Function.php';
include 'conn.php';
$task = $_POST["task"];
date_default_timezone_set("Asia/Manila");
$t = time();
$date_today    = date("Y-m-d",$t);
$curr_time     = date("h:i A",$t);

if ($task == "save"){
   $objnvalue = $_POST["objnvalue"];
   $table = $_POST["tbl"];
   $RefId = $_POST["refid"];
   $file = $_POST["file"];
   $Fields = "";
   $Values = "";
   $FldnVal = "";
   $js = "";
   $dataArr = explode(",",$objnvalue);
   for ($i=0;$i<count($dataArr) - 1;$i++) {
      $dummy = $dataArr[$i];
      $itemArr = explode("_",$dummy);
      $Fields .= "`$itemArr[0]`, ";
      $Values .= "'".mysqli_real_escape_string($conn,$itemArr[1])."', ";
      $FldnVal .= "`$itemArr[0]` = '".mysqli_real_escape_string($conn,$itemArr[1])."',";
   }
   $Fields = $Fields;
   $Values = $Values;
   if ($RefId == ""){
      $rs = save($table,$Fields,$Values);
      if (is_numeric($rs)){
         $sql = "SELECT * FROM `$table` WHERE RefId = '$rs'";
         $rs = mysqli_query($conn,$sql);
         $rowcount = mysqli_num_rows($rs);
         $row = mysqli_fetch_assoc($rs);
         if ($rowcount) {
            $audit = json_encode($row);
            $EmployeesRefId = $_SESSION["RefId"];
            $MAC = getMAC();
            $flds = "EmployeesRefId,MACAddress,InTable,Movement,Status,";
            $vals = "'$EmployeesRefId','$MAC','$table','$audit','A',";
            $result = save("audit_trail",$flds,$vals);
            if (is_numeric($result)){
               $js .= "afterSave('".$file."')";
            } else {
               echo "SAVING ERROR IN AUDIT TRAIL!";
            }
         } else {
            echo "No Record Found";
         }
      }else {
         echo 'Error In Saving For Table '.$table;
      }
   } else {
      $sql = "SELECT * FROM `$table` WHERE RefId = '$RefId'";
      $rs = mysqli_query($conn,$sql);
      $rowcount = mysqli_num_rows($rs);
      $row = mysqli_fetch_assoc($rs);
      if ($rowcount) {
         $audit = json_encode($row);
         $EmployeesRefId = $_SESSION["RefId"];
         $MAC = getMAC();
         $NewFldnVal = str_replace("`", "", $FldnVal);
         $NewFldnVal = str_replace("'", "", $NewFldnVal);
         $flds = "EmployeesRefId,MACAddress,InTable,LastValue,NewValue,Status,";
         $vals = "'$EmployeesRefId','$MAC','$table','$audit','$NewFldnVal','E',";
         $result = save("audit_trail",$flds,$vals);
         if (is_numeric($result)){
            $result = update($table,$FldnVal,$RefId);
            if ($result != ""){
               echo "alert('Error in Updating Record ".$RefId."');";
            }else {
               $js .= "afterEdit('".$file."');";
            }
         } else {
            echo "SAVING ERROR IN AUDIT TRAIL!";
         }
      } else {
         echo 'No Record Found!';
      }
   }
   echo $js;
} else if ($task == "Delete"){
   $js = "";
   $tbl = $_POST["table"];
   $refid = $_POST["refid"];
   $file = $_POST["file"];
   $rs = mysqli_query($conn,"SELECT * FROM `$tbl` WHERE RefId = '$refid'");
   $rowcount = mysqli_num_rows($rs);
   $row = mysqli_fetch_assoc($rs);
   if ($rowcount) {
      $audit = json_encode($row);
      $EmployeesRefId = $_SESSION["RefId"];
      $MAC = getMAC();
      $flds = "EmployeesRefId,MACAddress,InTable,Movement,Status,";
      $vals = "'$EmployeesRefId','$MAC','$tbl','$audit','D',";
      $result = save("audit_trail",$flds,$vals);
      if (is_numeric($result)){
         $sql = "DELETE FROM `$tbl` WHERE RefId = $refid";
         if ($conn->query($sql) === TRUE) {
            $js .= "afterDelete('".$file."');";
         } else {
            $js .= "alert('ERROR IN DELETING !!!\n');";
         }
      } else {
         echo "SAVING ERROR!";
      }
   } else {
      $js .= "alert('No Record Found');";
   }
   echo $js;
} else if ($task == "View") {
   $tbl = $_POST["table"];
   $refid = $_POST["refid"];
   $rs = mysqli_query($conn,"SELECT * FROM `$tbl` WHERE RefId = '$refid'");
   if (mysqli_num_rows($rs) > 0) {
      $row = mysqli_fetch_assoc($rs);
      echo json_encode($row);
   }
} else if ($task == "delivery_request") {
   $hour = date("H",$t);
   $obj = $_POST["obj"];
   $EmployeesRefId = $_SESSION["RefId"];
   $BranchRefId = $_SESSION["BranchRefId"];
   if ($hour >= 5 && $hour <= 12){
      $DelShift = 1;
   } else if ($hour >= 13 && $hour <= 21){
      $DelShift = 2;
   } else {
      $DelShift = 3;
   }
   $sql = "SELECT * FROM delivery WHERE EmployeesRefId = $EmployeesRefId AND DeliveryShift = $DelShift AND RequestDate = '$date_today' AND Special = 1";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0){
      $DelType = "SPECIAL";
   } else {
      $DelType = "NORMAL";
   }
   $Fields = "";
   $Values = "";
   $flds = "EmployeesRefId,BranchRefId,DeliveryShift,RequestDate,RequestTime,Status,Special,DeliveryType,";
   $vals = "'$EmployeesRefId','$BranchRefId','$DelShift','$date_today','$curr_time','P',0,'$DelType',";
   $rs = save("delivery",$flds,$vals);
   if (is_numeric($rs)){
      $obj_arr = explode(",", $obj);
      for ($i=0;$i<count($obj_arr) - 1;$i++) {
         $item_arr = explode(":", $obj_arr[$i]);
         $Fields = "EmployeesRefId,BranchRefId,DeliveryRefId,DonutsRefId,DonutsQty,";
         $Values = "'$EmployeesRefId','$BranchRefId','$rs','$item_arr[0]','".mysqli_real_escape_string($conn,$item_arr[1])."',";
         save("delivery_request_details",$Fields,$Values);
      }
      $js = "afterRequest();";
   } else {
      echo "Error in Savings";
   }
   echo $js;
} else if ($task == "getRequest") {
   $RefId = $_POST["refid"];
   $sql = "SELECT * FROM delivery_request_details WHERE DeliveryRefId = $RefId";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0){
      echo '
         <table style="width:100%;color:#000;" border=1 class="table table-striped table-bordered table-hover">
            <thead>
               <tr class="text-center" style="background:#4d0000;font-size:10pt;color:#fff;">
                  <td width="30%">NAME</td>
                  <td width="10%">QUANTITY (Pcs)</td>
                  <td width="10%">INITIAL VALUE (Optional)</td>
                  <td width="50%">REMARKS</td>
               </tr>
            </thead>
            <tbody>
      ';
      while ($row = mysqli_fetch_assoc($rs)) {
         $Donuts = get("donuts",$row["DonutsRefId"],"Name");
         $DonutsQty = $row["DonutsQty"];
         $ReqRefId = $row["RefId"];
         echo '
            <tr>
               <td style="padding-left:2%;">
                  <label>'.$Donuts.'</label>
               </td>
               <td class="text-center">
                  <input type="text" class="form-control number-- text-center" id="qty_'.$ReqRefId.'" style="border:1px solid black;" 
                    value="'.$DonutsQty.'" disabled>
               </td>
               <td class="text-center">
                  <input type="text" class="form-control number--" id="donuts_'.$ReqRefId.'" name="donuts_'.$ReqRefId.'" style="border:1px solid black;">
               </td>
               <td class="text-center">
                  <input type="hidden" value="'.$row["DonutsRefId"].'" id="dRefId_'.$ReqRefId.'">
                  <textarea type="text" class="form-control" id="remarks_'.$ReqRefId.'" placeholder="Remarks Here" rows="2"></textarea>
               </td>
            </tr>
         ';
      }
      echo '
            </tbody>
         </table>
      ';
   }
} else if ($task == "getDelivery") {
   $RefId = $_POST["refid"];
   $EmployeesRefId = $_SESSION["RefId"];
   $BranchRefId = $_POST["branchrefId"];
   $sql = "SELECT * FROM delivery WHERE RefId = $RefId AND DeliveryBy = $EmployeesRefId AND BranchRefId = $BranchRefId";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0){
      $DelRow = mysqli_fetch_assoc($rs);
      echo '
         <table style="width:100%;color:#000;" border=1 class="table table-striped table-bordered table-hover">
            <thead>
               <tr class="text-center" style="background:#4d0000;font-size:10pt;color:#fff;">
                  <td width="5%">#</td>
                  <td width="30%">DONUT NAME</td>
                  <td width="15%">DONUT QUANTITY (Pcs)</td>
                  <td width="35%">REMARKS</td>
               </tr>
            </thead>
            <tbody>
      ';
      $sql = "SELECT * FROM delivery_approved_details WHERE DeliveryRefId = ".$DelRow["RefId"]." AND BranchRefId = ".$DelRow["BranchRefId"];
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
         $i = 0;
         $DonutDelQty = "";
         while ($row = mysqli_fetch_assoc($result)) {
            if ($row["ApprvValue"] == ""){
               $DonutDelQty = $row["DonutsQty"];
            } else {
               $DonutDelQty = $row["ApprvValue"];
            }
            $i++;
            echo '
               <tr>
                  <td class="text-center">
                   '.$i.'
                  </td>
                  <td style="padding-left:4%;">
                     <label> '.get("donuts",$row["DonutsRefId"],"Name").'</label>
                  </td>
                  <td class="text-center">
                     <label> '.$DonutDelQty.'</label>
                  </td>
                  <td class="text-center">
                     <textarea type="text" class="form-control" readonly> '.$row["Remarks"].'</textarea>
                  </td>
               </tr>
            ';
         }
      }
      echo '
            </tbody>
         </table>
      ';
   } else {
      echo 'No Deliveries';
   }
} else if ($task == "CancelReq") {
   $RefId = $_POST["refid"];
   $result = update("delivery","Status = 'C',CancelledDate = '$date_today', CancelledTime = '$curr_time',",$RefId);
   if ($result != ""){
      echo 'alert("Error in Cancelling Request!!!")';
   } else {
      echo 'alert("Request Has Been Cancelled!");self.location="notification.php";';
   }
} else if ($task == "ReqApproved") {
   $reqRefId = $_POST["refid"];
   $obj = $_POST["obj"];
   $driverRefId = $_POST["driver"];
   $select = mysqli_query($conn,"SELECT * FROM delivery WHERE RefId = $reqRefId");
   if (mysqli_num_rows($select) > 0 ){
      $selectRow = mysqli_fetch_assoc($select);
      $EmployeesRefId = $selectRow["EmployeesRefId"];
      $BranchRefId = $selectRow["BranchRefId"];
   } else {
      echo 'No Record Found.';
      return false;
   }
   $result = update("delivery","Status = 'A',DeliveryBy = '$driverRefId', ApprovedDate = '$date_today', ApprovedTime = '$curr_time',",$reqRefId);
   if ($result == ""){
      $donuts_arr = explode(",", $obj);
      for ($i=0;$i<count($donuts_arr) - 1;$i++) {
         $first_arr = explode("_", $donuts_arr[$i]);
         $requestVal = $first_arr[0];
         $second_arr = explode("!", $first_arr[1]);
         $givenVal = $second_arr[0];
         $third_arr = explode(":", $second_arr[1]);
         $donutRefId = $third_arr[0];
         $remarks = $third_arr[1];
         $Fields = "EmployeesRefId,BranchRefId,DeliveryRefId,DonutsRefId,DonutsQty,ApprvValue,Remarks,";
         $Values = "'$EmployeesRefId','$BranchRefId','$reqRefId','$donutRefId','$requestVal','$givenVal','$remarks',";
         save("delivery_approved_details",$Fields,$Values);
      }
      echo 'alert("Request Has Been Approved!!!");self.location="notification.php"';
   } else {
      echo 'alert("Error in Approving..");return false;';
   }
} else if ($task == "requestValidation") {
   $EmployeesRefId = $_POST["refid"];
   $hour = date("H",$t);
   if ($hour >= 5 && $hour <= 12){
      $DelShift = 1;
   } else if ($hour >= 13 && $hour <= 21){
      $DelShift = 2;
   } else {
      $DelShift = 3;
   }
   $sql = "SELECT * FROM delivery WHERE EmployeesRefId = $EmployeesRefId AND DeliveryShift = $DelShift AND RequestDate = '$date_today' AND Special = 0";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0){
      echo '
         $("#reqValid").show();
         $("#reqForm").hide();
      ';
      $new_sql = "SELECT * FROM delivery WHERE EmployeesRefId = $EmployeesRefId AND DeliveryShift = $DelShift AND RequestDate = '$date_today' AND Special = 1";
      $new_rs = mysqli_query($conn,$new_sql);
      if (mysqli_num_rows($new_rs) > 0){
         echo '
            $("#sent_special_req").hide();
         ';
      }
   } else {
      echo '$("#reqView").show();';
   }
} else if ($task == "deliveryOkay") {
   $DelRefId = $_POST["refid"];
   $BranchRefId = $_POST["branchrefId"];
   $chkDel = "SELECT * FROM delivery WHERE RefId = $DelRefId AND BranchRefId = $BranchRefId";
   $delResult = mysqli_query($conn,$chkDel);
   if (mysqli_num_rows($delResult) > 0) {
      $delResultRow = mysqli_fetch_assoc($delResult);
      $delRefId = $delResultRow["RefId"];
      $FldnVal = "DeliveredDate = '$date_today', DeliveredTime = '$curr_time', Status = 'D',";
      $updateRs = update("delivery",$FldnVal,$delRefId);
      if ($updateRs == ""){
         $sql = "SELECT * FROM delivery_approved_details WHERE DeliveryRefId = $DelRefId AND BranchRefId = $BranchRefId";
         $rs = mysqli_query($conn,$sql);
         if (mysqli_num_rows($rs) > 0){
            while($row = mysqli_fetch_assoc($rs)){
               $reqVal = $row["DonutsQty"];
               $apprvVal = $row["ApprvValue"];
               if ($apprvVal == ""){
                  $donutQty = $reqVal;
               } else {
                  $donutQty = $apprvVal;
               }
               $donutRefId = $row["DonutsRefId"];
               $BranchRefId = $row["BranchRefId"];

               $stock_sql = "SELECT * FROM branch_stock WHERE DonutRefId = $donutRefId AND BranchRefId = $BranchRefId";
               $newTime = time();
               $trigger = 0;
               $stock_rs = mysqli_query($conn,$stock_sql);
               if (mysqli_num_rows($stock_rs) > 0) {  
                  $stock_row = mysqli_fetch_assoc($stock_rs);
                  $curr_stock = $stock_row["Stock"];
                  $new_stock = $curr_stock + $donutQty;

                  $flds = "`BranchRefId`, `DonutRefId`, `Current_Stock`, `Delivered_Stock`, `New_Stock`, `DeliveryDate`, `DeliveryTime`, ";
                  $vals = "'$BranchRefId', '$donutRefId', '$curr_stock', '$donutQty', '$new_stock', '$date_today', '$newTime',";
                  $stock_save = save("stock_trail",$flds,$vals);
                  if (!is_numeric($stock_save)) {
                     echo "Error in saving in Stock Trailing";
                     $trigger = 0;
                  } else {
                     $trigger = 1;
                  }
               } else {
                  $flds = "`BranchRefId`, `DonutRefId`, `Current_Stock`, `Delivered_Stock`, `New_Stock`, `DeliveryDate`, `DeliveryTime`, ";
                  $vals = "'$BranchRefId', '$donutRefId', 0, '$donutQty', '$donutQty', '$date_today', '$newTime',";
                  $stock_save = save("stock_trail",$flds,$vals);
                  if (!is_numeric($stock_save)) {
                     echo "Error in saving in Stock Trailing";
                     $trigger = 0;
                  } else {
                     $trigger = 1;
                  }
               }
               if ($trigger > 0) {
                  $chkDonut = "SELECT * FROM branch_stock WHERE DonutRefId = $donutRefId AND BranchRefId = $BranchRefId";
                  $result = mysqli_query($conn,$chkDonut);
                  if (mysqli_num_rows($result) > 0) {
                     while ($chkDonutRow = mysqli_fetch_assoc($result)){
                        $newStock = $donutQty + $chkDonutRow["Stock"];
                        $rs_update = update("branch_stock","`Stock` = '$newStock',",$chkDonutRow["RefId"]);  
                        if ($rs_update != "") {
                           echo "Error in Adding Stock";
                        }
                     }
                  } else {
                     $flds = "BranchRefId,DonutRefId,Stock,";
                     $vals = "'$BranchRefId','$donutRefId','$donutQty',";
                     $rs_save = save("branch_stock",$flds,$vals);
                     if (!is_numeric($rs_save)) {
                        echo "Error in Adding Stock";
                     }
                  }   
               }
            }
            echo "alert('Delivery Okay');self.location='myRequest.php'";
         } else {
            echo "alert('No Record Found');";
         }
      } else {
         echo "Error in Updating Record";
      }
   } else {
      echo 'No Delivery Record Found';
   }
   
} else if ($task == "getEmpInfo") {
   $EmpRefId = $_SESSION["RefId"];
   $BranchRefId = $_SESSION["BranchRefId"];
   $sql = "SELECT * FROM employees WHERE RefId = $EmpRefId AND BranchRefId = $BranchRefId";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0) {
      $row = mysqli_fetch_assoc($rs);
      $RefId = $row["RefId"];
      $Branch = get("branch",$row["branchRefId"],"Name");
      $Position = get("position",$row["positionRefId"],"Name");
      $FName = $row["FirstName"];
      $LName = $row["LastName"];
      $MName = $row["MiddleName"];
      $ExtName = $row["ExtName"];
      $Gender = $row["Sex"];
      $CvlStatus = $row["CivilStatus"];
      echo '$("#hEmpRefId, #emprefid").val("'.$RefId.'");';
      echo '$("[name=\'Branch\']").val("'.$Branch.'");';
      echo '$("[name=\'Position\']").val("'.$Position.'");';
      echo '$("[name=\'FirstName\']").val("'.$FName.'");';
      echo '$("[name=\'LastName\']").val("'.$LName.'");';
      echo '$("[name=\'MiddleName\']").val("'.$MName.'");';
      echo '$("[name=\'ExtName\']").val("'.$ExtName.'");';
      echo '$("[name=\'Sex\']").val("'.$Gender.'");';
      echo '$("[name=\'CivilStatus\']").val("'.$CvlStatus.'");';
   } else {
      echo "Error No Record Found.<br>".$sql;
   }
} else if ($task == "updateEmpInfo") {
   $RefId = mysqli_real_escape_string($conn,$_POST["EmpRefId"]);
   $FName = mysqli_real_escape_string($conn,$_POST["FName"]);
   $LName = mysqli_real_escape_string($conn,$_POST["LName"]);
   $MName = mysqli_real_escape_string($conn,$_POST["MName"]);
   $ExtName = mysqli_real_escape_string($conn,$_POST["ExtName"]);
   $Sex = mysqli_real_escape_string($conn,$_POST["Sex"]);
   $CivilStatus = mysqli_real_escape_string($conn,$_POST["CvlStat"]);
   $FldnVal = "FirstName = '$FName',
               LastName = '$LName',
               MiddleName = '$MName',
               ExtName = '$ExtName',
               Sex = '$Sex',
               CivilStatus = '$CivilStatus',";
   $result = update("employees",$FldnVal,$RefId);
   if ($result == ""){
      echo 'alert("Successfully Updated");self.location = "myProfile.php"';
   } else {
      echo "Error in Updating the Record.<br>".$FldnVal."<br>".$RefId;
   }

} else if ($task == "chkUsername") {
   $uname = $_POST["uname"];
   $rs = mysqli_query($conn,"SELECT * FROM sysuser WHERE Username = '$uname'");
   echo mysqli_num_rows($rs);
} else if ($task == "updatePW") {
   $RefId = $_POST["refid"];
   $curr_pw = md5($_POST["currpw"]);
   $newpw = $_POST["newpw"];
   $js = "";
   $pw = md5($newpw);
   $PWSql = "SELECT * FROM sysuser WHERE employeesRefId = '$RefId' AND Password = '$curr_pw'";
   $rs = mysqli_query($conn,$PWSql);
   if (mysqli_num_rows($rs) > 0){
      $row = mysqli_fetch_assoc($rs);
      $sysRefId = $row["RefId"];
      $new_sql = "SELECT * FROM acctbackup WHERE employeesRefId = $RefId";
      $new_rs = mysqli_query($conn,$new_sql);
      if (mysqli_num_rows($new_rs) > 0) {
      $acct_row = mysqli_fetch_assoc($new_rs);
      $acct_refid = $acct_row["RefId"];
      $acct_update = update("acctbackup","Password = '$newpw',",$acct_refid);
         if ($acct_update != "") {
            $js .= '
                  alert("Error in Creating Backup!!!");
                  self.location = "forgotpassword.php";
               ';       
         } else {
            $result = update("sysuser","Password = '$pw',",$sysRefId);
            if ($result == "") {
               $js .= 'alert("Successfully Updated.");';
               $js .= 'self.location="myProfile.php?'.$_SESSION["Session"].'"';
            } else {
               $js .= "Error in Updating Password.";
            } 
         }
      } else {
      $js .= 'alert("You Dont Have Any Account Backup \n Report To The Admin!!!");';    
      }
   } else {
      $js .= 'alert("Wrong Password");';
      $js .= '$("#curr_PW").focus();';
   }
   echo $js;
} else if ($task == "lessStock") {
   $obj = $_POST["obj"];
   $EmployeesRefId = $_SESSION["RefId"];
   $BranchRefId = $_SESSION["BranchRefId"];
   $Flds = "BranchRefId,EmployeesRefId,OrderDate,OrderTime,";
   $Vals = "'$BranchRefId','$EmployeesRefId','$date_today','$curr_time',";
   $order_id = save("order",$Flds,$Vals);
   if (is_numeric($order_id)) {
      $obj_arr = explode(",", $obj);
      for ($i=0;$i<count($obj_arr) - 1;$i++) {
         $arr = explode("_", $obj_arr[$i]);
         $donutRefId = $arr[1];
         $qty = $arr[0];
         $price = get("donuts",$donutRefId,"Price");
         $total = $qty * $price;
         $orderFld = "BranchRefId,EmployeesRefId,OrderRefId,DonutRefId,Quantity,Total,";
         $orderVal = "'$BranchRefId','$EmployeesRefId','$order_id','$donutRefId','$qty','$total',";
         $rsSave = save("order_details",$orderFld,$orderVal);
         if (!is_numeric($rsSave)){
            echo 'Error in Saving in order_details Table';
         }
         $sql = "SELECT * FROM branch_stock WHERE BranchRefId = '$BranchRefId' AND DonutRefId = '$donutRefId'";
         $rsChkStock = mysqli_query($conn,$sql);
         if ($rsChkStock){
            $row = mysqli_fetch_assoc($rsChkStock);
            $oldVal = $row["Stock"];
            $stockRefId = $row["RefId"];
            $newVal = $oldVal - $qty;
            $FldnVal = "Stock = '$newVal',";
            $rsUpdateStock = update("branch_stock",$FldnVal,$stockRefId);
            if ($rsUpdateStock != "") {
               echo 'Error in Updating Branch Stock.';
            }
         } else {
            echo 'No Donuts Available';
         }
         
      }
      echo 'alert("Purchased!!!");self.location="order.php"';
   } else {
      echo "Error in Saving in Order Table";
   }
} else if ($task == "sent_special_req") {
   $EmployeesRefId = $_SESSION["RefId"];
   $hour = date("H",$t);
   if ($hour >= 5 && $hour <= 12){
      $DelShift = 1;
   } else if ($hour >= 13 && $hour <= 21){
      $DelShift = 2;
   } else {
      $DelShift = 3;
   }
   $sql = "SELECT * FROM delivery WHERE EmployeesRefId = $EmployeesRefId AND DeliveryShift = $DelShift AND RequestDate = '$date_today' AND Special = 0";
   $rs = mysqli_query($conn,$sql);
   if (mysqli_num_rows($rs) > 0){
      $row = mysqli_fetch_assoc($rs);
      $refid = $row["RefId"];
      $update = update("delivery","Special = 1,",$refid);
      if ($update != "") {
         echo "Error in Updating Request";
      } else {
         echo 'alert("You can now create a special request");';
         echo 'self.location = "requestform.php";';
      }
   } else {
      echo "No Request Yet";
   }
} else if ($task == "throwaway") {
   $obj = $_POST["obj"];
   $EmployeesRefId = $_SESSION["RefId"];
   $BranchRefId = $_SESSION["BranchRefId"];
   $Flds = "BranchRefId,EmployeesRefId,ThrowawayDate,ThrowawayTime,";
   $Vals = "'$BranchRefId','$EmployeesRefId','$date_today','$curr_time',";
   $throwaway_id = save("throwaway",$Flds,$Vals);
   if (is_numeric($throwaway_id)) {
      $obj_arr = explode(",", $obj);
      for ($i=0;$i<count($obj_arr) - 1;$i++) {
         $arr = explode("_", $obj_arr[$i]);
         $donutRefId = $arr[1];
         $qty = $arr[0];
         $orderFld = "BranchRefId,EmployeesRefId,ThrowawayRefId,DonutRefId,Quantity,";
         $orderVal = "'$BranchRefId','$EmployeesRefId','$throwaway_id','$donutRefId','$qty',";
         $rsSave = save("throwaway_details",$orderFld,$orderVal);
         if (!is_numeric($rsSave)){
            echo 'Error in Saving in order_details Table';
         }
         $sql = "SELECT * FROM branch_stock WHERE BranchRefId = '$BranchRefId' AND DonutRefId = '$donutRefId'";
         $rsChkStock = mysqli_query($conn,$sql);
         if ($rsChkStock){
            $row = mysqli_fetch_assoc($rsChkStock);
            $oldVal = $row["Stock"];
            $stockRefId = $row["RefId"];
            $newVal = $oldVal - $qty;
            $FldnVal = "Stock = '$newVal',";
            $rsUpdateStock = update("branch_stock",$FldnVal,$stockRefId);
            if ($rsUpdateStock != "") {
               echo 'Error in Updating Branch Stock.';
            }
         } else {
            echo 'No Donuts Available';
         }
         
      }
      echo 'alert("THROW AWAY!!!");self.location="throwaway.php"';
   } else {
      echo "Error in Saving in Order Table";
   }
}
mysqli_close($conn);
?>

