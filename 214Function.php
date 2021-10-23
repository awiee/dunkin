<?php
   session_start();
   date_default_timezone_set("Asia/Manila");


   function sideBar() {
      include 'conn.php';
      if (isset($_SESSION["Session"])) {
         $sessSql = "SELECT * FROM sysuser WHERE employeesRefId = ".$_SESSION["RefId"];
         $sessQry = mysqli_query($conn,$sessSql);
         $rowSess = mysqli_fetch_assoc($sessQry);
         $session = $rowSess["Session"];
         if ($session == $_SESSION["Session"]){
            echo '
               <div id="sidebar-wrapper">
                  <div class="sidebar-nav">
                     <div class="margin-top" style="padding:5px;">
                        <img src="images/ddlogo.png" width="100%">
                     </div>
                     <div class="sideMenu margin-top" id="myProfile">
                        <img src="images/emp.png">&nbsp;&nbsp;&nbsp;CHANGE PASSWORD
                     </div>
            ';
               if ($_SESSION["Position"] == "Driver"){
                  echo '
                     <div class="sideMenu margin-top" id="myDelivery">
                        <img src="images/notif.png">&nbsp;&nbsp;&nbsp;MY DELIVERIES
                     </div>
                  ';
               } else if ($_SESSION["Position"] == "Employee") {
                  echo '
                     <div class="sideMenu margin-top" id="myRequest">
                        <img src="images/notif.png">&nbsp;&nbsp;&nbsp;MY REQUESTS
                     </div>
                     <div class="sideMenu" id="requestform">
                        <img src="images/request.png">&nbsp;&nbsp;&nbsp;REQUEST FORM
                     </div>
                     <div class="sideMenu" id="stockCheck">
                        <img src="images/audit.png">&nbsp;&nbsp;&nbsp;STOCK CHECK
                     </div>
                     <div class="sideMenu" id="order">
                        <img src="images/sales.png">&nbsp;&nbsp;&nbsp;SALES
                     </div>
                     <div class="sideMenu" id="stock_trail">
                        <img src="images/throwaway.png">&nbsp;&nbsp;&nbsp;DELIVERIES
                     </div>
                     <div class="sideMenu" id="throwaway">
                        <img src="images/del.png">&nbsp;&nbsp;&nbsp;THROW AWAY
                     </div>
                  ';
               } else {
                  echo '
                     <div class="sideMenu margin-top" id="notification">
                        <img src="images/notif.png">&nbsp;&nbsp;&nbsp;NOTIFICATIONS
                     </div>
                     <div class="sideMenu" id="employees">
                        <img src="images/employees.png">&nbsp;&nbsp;&nbsp;EMPLOYEES
                     </div>
                     <div class="sideMenu" id="reports">
                        <img src="images/reports.png">&nbsp;&nbsp;&nbsp;REPORTS
                     </div>
                     <div id="rpt">
                        <div class="sideMenu" id="rptDelivery">
                           <i class="fa fa-file">&nbsp;&nbsp;&nbsp;</i>DELIVERY
                        </div>
                        <div class="sideMenu" id="rptThrowAway">
                           <i class="fa fa-file">&nbsp;&nbsp;&nbsp;</i>THROW AWAY
                        </div>
                     </div>
                     <div class="sideMenu" id="audittrail">
                        <img src="images/audit.png">&nbsp;&nbsp;&nbsp;AUDIT TRAIL
                     </div>
                     <div class="sideMenu" id="filemanager">
                        <img src="images/filemanager.png">&nbsp;&nbsp;&nbsp;FILE MANAGER
                     </div>
                     <div id="fm">
                        <div class="sideMenu" id="branch">
                           <i class="fa fa-file">&nbsp;&nbsp;&nbsp;</i>BRANCH
                        </div>
                        <div class="sideMenu" id="position">
                           <i class="fa fa-file">&nbsp;&nbsp;&nbsp;</i>POSITION
                        </div>
                        <div class="sideMenu" id="donut">
                           <i class="fa fa-file">&nbsp;&nbsp;&nbsp;</i>DONUTS
                        </div>
                        <div class="sideMenu" id="criteria">
                           <i class="fa fa-file">&nbsp;&nbsp;&nbsp;</i>CRITERIA
                        </div>
                     </div>
                  ';
               }
               echo '
                     <div class="sideMenu" id="logout">
                        <img src="images/logout.png">&nbsp;&nbsp;&nbsp;LOG OUT
                     </div>
                     <input type="hidden" id="hSess" value="'.$_SESSION["Session"].'">
                  </div>
               </div>
            ';
         } else {
            echo '<script>self.location = "index.php?sess=expired";</script>';         
         }
      } else {
         echo '<script>self.location = "index.php?sess=expired";</script>';
      }
   }
   function userBar() {
      echo '
         <div class="row titleBar">
            <div class="col-xs-6">
               ['.$_SESSION["RefId"].'] '.$_SESSION["FullName"].'
            </div>
            <div class="col-xs-6 text-right" id="TimeDate">
            </div>
         </div>
      ';
   }
   function DataTable($sql,$tblHdr,$tblFld) {
      echo '
         <table id="dataList" class="table table-striped table-bordered table-hover">
            <thead>
               <tr style="background:#4d0000;font-size:10pt;color:#fff;">
                  <th style="text-align:center;">ACTION</th>
                  <th style="text-align:center;">ID</th>';
                  for ($j=0;$j<count($tblHdr);$j++) {
                     echo '<th style="text-align:center;">'.$tblHdr[$j].'</th>';
                  }
                  
      echo '
               </tr>
            </thead>
            <tbody style="color:#000;">
               ';
                  ListData($tblFld,$sql);
      echo '   
            </tbody>
         </table>
      ';
      
   }
   function ListData($tblFld,$sql) {
      require 'conn.php';
      $result = mysqli_query($conn,$sql);
      $rowcount = mysqli_num_rows($result);
      if ($rowcount) {
         while ($row = mysqli_fetch_assoc($result)) {
            $refid   = $row['RefId'];
            echo
            '<tr>
               <td style="width:20%;text-align:center;">
                  <button type="button" class="btn btn-info" onclick="edit('.$refid.');">
                     <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;EDIT
                  </button>
                  <button type="button" class="btn btn-danger" onclick="del('.$refid.');">
                     <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;DELETE
                  </button>
               </td>
               <td style="width:5%;text-align:center;color:#000;">'.$refid.'</td>
               ';
               
            for ($j=0;$j<count($tblFld);$j++) {
               echo
                  '<td style="color:#000;">'.$row[$tblFld[$j]].'</td>';
            }
            echo '
            </tr>';
         }
      }
   }
   function save($table,$Fields,$Values){
      include 'conn.php';
      /*$Fields = "";
      $Values = "";*/
      $t = time();
      $date_today    = date("Y-m-d",$t);
      $curr_time     = date("H:i:s",$t);
      if (isset($_SESSION["FullName"])){
         $user = $_SESSION["FullName"];   
      } else {
         $user = "ADMIN";
      }
      $trackingFld = "`LastUpdateDate`,`LastUpdateTime`,`LastUpdateBy`,`Data`";
      $trackingVal = "'$date_today','$curr_time','$user','A'";
      $Fields = $Fields.$trackingFld;
      $Values = $Values.$trackingVal;
      $sql = "INSERT INTO `$table` ($Fields) VALUES ($Values)";
      /*echo $sql;
      return false;*/
      if (mysqli_query($conn, $sql)) {
         return mysqli_insert_id($conn);
      } else {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
   }
   function update($table,$FldnVal,$RefId) {
      include 'conn.php';
      $msg = "";
      $t = time();
      $date_today    = date("Y-m-d",$t);
      $curr_time     = date("H:i:s",$t);
      if (isset($_SESSION["FullName"])){
         $user = $_SESSION["FullName"];   
      } else {
         $user = "ADMIN";
      }
      $editTrack = "`LastUpdateDate` = '$date_today', `LastUpdateTime` = '$curr_time', `LastUpdateBy` = '$user', `Data` = 'E'";
      $FldnVal = $FldnVal.$editTrack;
      $qry_update = "UPDATE `$table` SET $FldnVal WHERE RefId = $RefId";
      /*echo $qry_update;
      var_dump($conn->query($qry_update));
      return false;*/
      if ($conn->query($qry_update) === TRUE) {
         return "";
      } else {
         $msg .= " Saving Error: ".$conn->error;
         return $msg;
      }
   }
   function select($table,$objname,$title,$mandatory) {
      echo '<select name="'.$objname.'"class="form-control save-- '.$mandatory.'">
                  <option value="">SELECT '.$title.'</option>';
      include "conn.php";
      $sql = "SELECT * FROM ".$table." ORDER BY RefId";
      $result = $conn->query($sql);
      
         while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["RefId"].'">';
            echo ''.$row["Name"].'</option>';
         }
      echo '<select>';
   }
   function get($table,$RefId,$fields){
      include 'conn.php';
      $sql = "SELECT `$fields` FROM `$table` where RefId = $RefId LIMIT 1";
      $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
      $row = mysqli_fetch_assoc($result);
      mysqli_close($conn);
      $numrow = mysqli_num_rows($result);
      if ($numrow <= 0) {
         return "";
      } else {
         if ($fields == "*") return $row;
         else return $row[$fields];
      }
   }
   function btn(){
      echo '
         <button type="button" class="btn btn-info" id="btn_update">
            <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;UPDATE
         </button>
         <button type="button" class="btn btn-info" id="btn_save">
            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;SAVE
         </button>
         <button type="button" class="btn btn-danger" id="btn_back">
            <i class="fa fa-backward" aria-hidden="true"></i>&nbsp;&nbsp;BACK
         </button>
         <button type="button" class="btn btn-danger" id="btn_cancel">
            <i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;CANCEL
         </button>
      ';
   }
   function INCLO() {
      echo '
         <button type="button" class="btn btn-info" id="btn_insert">
            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD NEW
         </button>
         <button type="button" class="btn btn-danger" id="btn_close">CLOSE</button>
      ';
   }
   function getMAC() {
      /*
      * Getting MAC Address using PHP
      * PHP Fresher
      */
      
      ob_start(); // Turn on output buffering
      system('ipconfig /all'); //Execute external program to display output
      $mycom = ob_get_contents(); // Capture the output into a variable
      ob_clean(); // Clean (erase) the output buffer

      $findme = "Physical";
      $pmac = strpos($mycom, $findme); // Find the position of Physical text
      $mac = substr($mycom,($pmac+36),17); // Get Physical Address

      //echo "MAC ADD -- >".$mac;
      return $mac;
   }
   function Tabs($idx,$title,$iFile) {
      echo
         '
         <div id="tab_'.$idx.'" style="margin-top:10px;">
            <div class="panel panel-primary">
               <div class="panel-heading">
                  <h4 class="panel-title">'.$title.'</h4>
               </div>
               <div class="panel-mid">';
                  require $iFile.".php";
      echo
               '</div>
            </div>
         </div>
         '."\n";
   }
   function rptHeader($title) {
      $t = time();
      $date_today    = monthName(date("m"),0)." ".date("d, Y",$t);
      $curr_time     = date("H:i:s",$t);
      echo
      '<table style="width:100%; color:black;">
         <tr>
            <td class="text-left" style="width:20%;">
               <img src="images/ddlogo.png" width="75%">
            </td>
            <td style="width:*%;text-align:center;font-size:12px;">
                  <label>DUNKIN DONUTS REPORT <br>FOR THESIS PURPOSE</label>
            </td>
            <td style="width:20%;">&nbsp;</td>
         </tr>
         <tr>
            <td colspan="3" style="text-align:center;font-size:10px;">
               '.$title.'
            </td>
         </tr>
      </table><br>';
   }
   function monthName($m,$j) {
      if ($j == 0) {
         $month = explode(",","Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec");
      } else {
         $month = explode(",","January,February,March,April,May,June,July,August,September,October,November,December");
      }
      return $month[$m - 1];
   }
   function rptFooter() {
      $t = time();
      $date_today    = monthName(date("m"),0)." ".date("d, Y",$t);
      $curr_time     = date("H:i:s",$t);
      echo
      '<div class="rptFooter footer runDate row">
         <div class="col-xs-4 text-left">
            RUN DATE : '.$date_today.' - '.$curr_time.'
         </div>
         <div class="col-xs-4 text-center">
            THESIS '.date("Y",$t).'
         </div>
         <div class="col-xs-4 text-right">
            PRINTED BY: '.$_SESSION['FullName'].'
         </div>
      </div>';
   }

?>