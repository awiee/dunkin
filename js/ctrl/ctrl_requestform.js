$(document).ready(function () {
   $("#reqValid, #gSave, #reedit, #hValue").hide();
   requestValidation($("#hEmpRefId").val());
   tabClick(1);
   $("[name='btnTab_1']").click(function() {
      tabClick(1);
   });
   $("[name='btnTab_2']").click(function() {
      tabClick(2);
   });
   $("[name='btnTab_3']").click(function() {
      tabClick(3); 
   });
   $("#check").click(function () {
      $("[id*='item_']").each(function () {
         if ($(this).val() != "" && $(this).val() != 0){
            var id = $(this).attr("id");
            var val = $(this).val();
            id = id.split("_")[1];
            var hdn = id + ":" + val + ",";
            $("#hValue").append(hdn);
         }
      });
      $("[id*='item_']").prop("disabled",true);
      alert("Please Recheck Your Request");
      $("#check").hide();
      $("#gSave").show();
      $("#reedit").show();
   });
   $("#reedit").click(function () {
      $("#hValue").html('');
      $("[id*='item_']").prop("disabled",false);
      $(this).hide();
      $("#gSave").hide();
      $("#check").show();
   });
   $("#gSave").click(function () {
      var obj = $("#hValue").html();
      delivery_request(obj);
   });
   $("#sent_special_req").click(function () {
      sent_special_req();
   });
});
function tabClick(tabidx) {
   $("[name='hTabIdx']").val(tabidx);
   $("[id*='tab_']").hide();
   $("#tab_" + tabidx).show();
}
function afterRequest(){
   alert("Request Sent!!!");
   self.location = "requestform.php";
}
function delivery_request(obj){
   $.post("system.php",
   {
      task:"delivery_request",
      obj:obj,
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
             eval(code);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
}
function requestValidation(refid){
   $.post("system.php",
   {
      task:"requestValidation",
      refid:refid,
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
            eval(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
}
function specialDel(remarks){
   $.post("system.php",
   {
      task:"specialDel",
      remarks:remarks,
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
            eval(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
}
function sent_special_req() {
   $.post("system.php",
   {
      task:"sent_special_req"
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
            eval(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
}