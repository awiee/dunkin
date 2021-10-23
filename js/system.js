$(document).ready(function () {
   timedate();
   var sess = $("#hSess").val();
   $("[id*='dataList']").DataTable();
   $("#btn_update, #btn_back, #view, #fm, #rpt").hide();
   $("#filemanager").click(function () {
      $("#fm").toggle(200);
   });
   $("#reports").click(function () {
      $("#rpt").toggle(200);
   });
   $("#btn_insert").click(function () {
      $("#btn_update, #btn_back").hide();
      $("#btn_save, #btn_cancel").show();
      $("#list").slideUp(500);
      $(".save--").val("");
      $("#view").slideDown(500);
      $("#btn_save, #btn_update").prop("disabled",false);
   });
   $("#btn_cancel").click(function () {
      $("#view").slideUp(500);
      $("#list").slideDown(500);
   });
   $("#btn_back").click(function () {
      $("#view").slideUp(500);
      $(".save--").val("");
      $("#list").slideDown(500);
   });
   $("#btn_close").click(function () {
      $(".card").fadeOut(500);
   });
   $("#logout").click(function () {
      if (confirm("Do you want to Log Out?")) {
         self.location = "logout.php";
      }
   });
   $("#btn_save").click(function () {
      var req = false;
      $(".mandatory--").each(function () {
         if($(this).val() == ""){
            //alert("Field Required!!!");
            $(this).notify("Field Required","error");
            $(this).focus();
            req = true;
            return false;
         }
      });
      if (!req){
         checkAvailability();
      }
   });
   $("#btn_update").click(function () {
      var req = false;
      $(".mandatory--").each(function () {
         if($(this).val() == ""){
            $(this).notify("Field Required","error");
            $(this).focus();
            req = true;
            return false;
         }
      });
      if (!req){
         $(this).prop("disabled",true);
         fnSave();
      }
   });
   $("#donut").click(function () {
      self.location = "donuts.php?" + sess;
   });
   $("#branch").click(function () {
      self.location = "branch.php?" + sess;
   });
   $("#item").click(function () {
      self.location = "items.php?" + sess;
   });
   $("#position").click(function () {
      self.location = "position.php?" + sess;
   });
   $("#criteria").click(function () {
      self.location = "criteria.php?" + sess;
   });
   $("#employees").click(function () {
      self.location = "employees.php?" + sess;
   });
   $("#notification").click(function () {
      self.location = "notification.php?" + sess;
   });
   $("#requestform").click(function () {
      self.location = "requestform.php?" + sess;
   });
   $("#myRequest").click(function () {
      self.location = "myRequest.php?" + sess;
   });
   $("#myDelivery").click(function () {
      self.location = "myDelivery.php?" + sess;
   });
   $("#stockCheck").click(function () {
      self.location = "stockCheck.php?" + sess;
   });
   $("#audittrail").click(function () {
      self.location = "audit_trail.php?" + sess;
   });
   $("#myProfile").click(function () {
      self.location = "myProfile.php?" + sess;
   });
   $("#rptDelivery").click(function () {
      self.location = "rptDelivery.php?" + sess;
   });
   $("#order").click(function () {
      self.location = "order.php?" + sess;
   });
   $("#stock_trail").click(function () {
      self.location = "stock_trail.php?" + sess;
   });
   $("#throwaway").click(function () {
      self.location = "throwaway.php?" + sess;
   });
   $("#rptThrowAway").click(function () {
      self.location = "rptThrowAway.php?" + sess;
   });
   $("#help").click(function () {
      self.location = "help.php?" + sess;
   });
   
   /********UTILITIES********/
   $("input[class*='alpha--']").each(function(){
      var e = arguments[0];
      fnAlphaClass($(this).attr("name"),e);     
   });

   $("input[class*='alphanum--']").each(function(){
      var e = arguments[0];
      fnAlphaNumClass($(this).attr("name"),e);     
   });
   $("input[class*='number--']").each(function(){
      var e = arguments[0];
      fnNumberClass($(this).attr("name"),e);     
   });

   $(function() {
      $("input[class*='date--']").each(function () {
         fnDateClass($(this).attr("name"));
      });
   });
   /********UTILITIES********/
});
/********UTILITIES FUNCTION********/
function fnDateClass(objname) {
   $("[name='"+objname+"']").attr("data-date-format","yyyy-mm-dd");
   $("[name='"+objname+"']").datepicker();
}
function fnNumberClass(objname,e) {
   $("[name='"+objname+"']").keypress(function (e) {
      var isNumber = false;
         if (e.which >= 48 && e.which <= 57) {
            isNumber = true;
         } else if (e.which == 8 || e.which == 127 || e.which == 0 || e.which == 250) {
            isNumber = true;
         }
         if (!isNumber) e.preventDefault();
   });
}
function fnAlphaClass(objname,e) {
   $("[name='"+objname+"']").keypress(function(e) {
      var isLetter = false;
      if (e.which >= 97 && e.which <= 122) {
         isLetter = true;
      } else if (e.which >= 65 && e.which <= 90) {
         isLetter = true;
      } else if (e.which == 8 ||
                 e.which == 127 ||
                 e.which == 0 ||
                 e.which == 46 ||
                 e.which == 32)  {
         isLetter = true;
      }
      if (!isLetter) e.preventDefault();
   });
}
function fnAlphaNumClass(objname,e) {
   $("[name='"+objname+"']").keypress(function (e) {
      var isAlphaNumber = false;
      if (e.which >= 48 && e.which <= 57) {
         isAlphaNumber = true;
      } else if (e.which >= 97 && e.which <= 122) {
         isAlphaNumber = true;
      } else if (e.which >= 65 && e.which <= 90) {
         isAlphaNumber = true;
      } else if (e.which == 8 || e.which == 127 || e.which == 0 || e.which == 46 || e.which == 32 || e.which == 250)  {
         isAlphaNumber = true;
      }
      if (!isAlphaNumber) e.preventDefault();
   });
}
/********UTILITIES FUNCTION********/


function getFld_Entry(parentId) {
   var objvalue = "";
   var idx = 0;
   $("#"+parentId+" .save--").each(function() {
      objvalue += $(this).attr("name") + "_" + $(this).val() + ",";
   });
   return objvalue;
}
function getObjField(parentId) {
   var objvalue = new Array();
   var idx = 0;
   $("#"+parentId+" .save--").each(function() {
      objvalue[idx] = $(this).attr("name");
      idx++;
   });
   return objvalue;
}
function ActiveModule() {
   var scrn = $("#hTable").val();
   switch (scrn) {
      case "notification":
         $("#notification").addClass("activeModule",500);
      break;
      case "requestform":
         $("#requestform").addClass("activeModule",500);
      break;
      case "employees":
         $("#employees").addClass("activeModule",500);
      break;
      case "":
         $("#reports").addClass("activeModule",500);
      break;
      case "":
         $("#audittrail").addClass("activeModule",500);
      break;
      case "branch":
         $("#branch").addClass("activeModule",500);
      break;
      case "position":
         $("#position").addClass("activeModule",500);
      break;
      case "donuts":
         $("#donut").addClass("activeModule",500);
      break;
      case "items":
         $("#item").addClass("activeModule",500);
      break;
      case "criteria":
         $("#criteria").addClass("activeModule",500);
      break;
      case "request":
         $("#myRequest").addClass("activeModule",500);
      break;
      case "delivery":
         $("#myDelivery").addClass("activeModule",500);
      break;
      case "stockCheck":
         $("#stockCheck").addClass("activeModule",500);
      break;
      case "audit_trail":
         $("#audittrail").addClass("activeModule",500);
      break;
      case "myProfile":
         $("#myProfile").addClass("activeModule",500);
      break;
      case "rptDelivery":
         $("#rptDelivery").addClass("activeModule",500);
      break;
      case "rptThrowAway":
         $("#rptThrowAway").addClass("activeModule",500);
      break;
      case "order":
         $("#order").addClass("activeModule",500);
      break;
      case "stock_trail":
         $("#stock_trail").addClass("activeModule",500);
      break;
      case "throwaway":
         $("#throwaway").addClass("activeModule",500);
      break;
      case "help":
         $("#help").addClass("activeModule",500);
      break;
      
   }
}

function afterSave(file){
   alert("Record Save!!!");
   self.location = file;
}
function afterEdit(file){
   alert("Record Updated!!!");
   self.location = file;
}
function afterDelete(file){
   alert("Record Successfully Deleted!!!");
   self.location = file;
}
function checkAvailability(){
   $.ajax({
      url: "checkAvailability.php",
      type: "POST",
      data: new FormData($("[name='currentForm']")[0]),
      success : function(responseTxt){
         //alert(responseTxt);
         /*return false;*/
         if (responseTxt != 1) {
            $(this).prop("disabled",true);
            fnSave();
         } else {
            alert("Ooops!!! Record Already Exist.");
         }
      },
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      cache: false
   });
}
function fnSave(){
   var table = $("#hTable").val();
   var file = table + ".php";
   var RefId = $("#hRefId").val();
   var objvalue = getFld_Entry("EntryScreen");
   $.post("system.php",
   {
      task:"save",
      objnvalue:objvalue,
      refid:RefId,
      tbl:table,
      file:file
   },
   function(data,status) {
      //alert (data,status);
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
function del(refid) {
   var table = $("#hTable").val();
   var file = table + ".php";
   if (refid > 0)
   {
      if (table!="") {
         DeleteRecord(table,refid,file);
      }
      else {
         alert("Err : No db Table assigned");
         return false;
      }      
   }
   else {
      alert("Err : No Id assigned");
      return false;
   }
}
function DeleteRecord(table,refid,file) {
   if (confirm("Are you sure you want to delete this record " + refid + "?")) {
      $.post("system.php",
      {
         task:"Delete",
         refid:refid,
         table:table,
         file:file
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
}
function edit(refid){
   $("#hRefId").val(refid);
   var table = $("#hTable").val();
   $.post("system.php",
   {
      task:"View",
      refid:refid,
      table:table
   },
   function(data,status) {
      if (status == "success") {
         try {
            $("#view, #btn_update, #btn_back").show();
            $("#list, #btn_save, #btn_cancel").hide();
            $("#templateTitle").html("UPDATING RECORD " + refid);
            var objs = getObjField("EntryScreen");
            //alert (objs);
            var o = JSON.parse(data);
            data.RefId = data["RefId"]
            $("#hRefid").html(o["RefId"]);
            for (k=0; k<objs.length; k++) {
               obj = objs[k].split("_");
               $("[name='" + objs[k] + "']").val( o[obj[0]] );
            }
         } catch (e) {
             if (e instanceof SyntaxError) {
                 alert(e.message);
             }
         }
      }
      
   });
}
function timedate() {
   var today = new Date();
   var daylist = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
   var n = today.toLocaleString();
   var x = daylist[today.getDay()] + " " + n;
   $("#TimeDate").html(x);
   var t = setTimeout(timedate,1000);
}
function reloadJS() {
   var head = document.getElementByTagName('head')[0];
   var script = document.createElement('script');
   script.type = 'text/javascript';
   script.src = 'js/system.js';
   head.appendChild(script);
}