<div class="row margin-top card">
   <?php
      $sql = "SHOW FULL COLUMNS FROM `delivery`";
      $rs = mysqli_query($conn,$sql);
      $flds = "";
      $vals = "";
      if ($rs) {
         while ($row = mysqli_fetch_array($rs)) {
            echo "<label style='color:black;'>".$row["Field"]."</label><br>";   
            $flds .= $row["Field"].",";
         }
      }
      $new_sql = "SELECT * FROM delivery";
      $new_rs = mysqli_query($conn,$new_sql);
      if ($new_rs) {
         $row = mysqli_fetch_array($new_rs);
         for ($i=0;$i<=((count($row)/2)-1);$i++) {
            $vals .= "[".$i."] ".$row[$i]."<br>";   
         }
      }
      echo "<label style='color:black;'>".$vals."</label><br>";   
   ?>
</div>