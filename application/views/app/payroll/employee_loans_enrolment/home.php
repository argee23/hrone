<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">

    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
  </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
<body>
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Payroll
       <small>Employee Loans Enrolment</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Payroll</a></li>
      <li class="active">Employee Loans Enrolment</li>
    </ol>
  </section>
  <br>
    <input type="hidden" id="result_of_company">
    <input type="hidden" id="result_of_loan">
    <input type="hidden" id="result_of_employee">

   <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
       <div class="box box-solid box-success">
       <div class="box-header">
        <h5 class="box-title"><i class='fa fa-cogs'></i> <span>Payroll Loans</span></h5>
        </div>
        <div class="panel panel-danger">
         <div class="panel-heading">
              <h4 class="panel-title">
                  
          <select class="form-control" name="fetch_company" id="fetch_company" onchange="chooseCompany(this.value)">
            <option selected disabled>Select Company</option>
            <?php foreach ($companyList as $row) {
               echo "<option value='".$row->company_id."'>".$row->company_name."</option>";
            }?>
            </select>

              </h4>
            </div>
            <div class="panel">
                <div class="panel-body" style="height:auto;">
                  <div id="fetch_company_result" >

                    <n class="text-success"><center>Select company to start the employee loans.</center></n>
                  </div>
                </div>
            </div>
            
           
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse"><h4 class="box-title"><i  class='glyphicon glyphicon-cog '></i> <span>Loan Requests and Uploading</span></h4></a>
              </h4>
            </div>
            <div id="collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="set_text"><a style='cursor: pointer;' onclick="emp_loan_request_forms();"><i class='fa fa-circle-o'></i>List of Employee Loan Request Forms</a></li>
                     <li class="set_text"><a style='cursor: pointer;' onclick="emp_loan_mass_upload();"><i class='fa fa-circle-o'></i>Employee Loan Mass Uploading</a></li>
                  </ul>
                </div>
            </div><br>
        </div>
        </div>
        <div class="btn-group-vertical btn-block"></div>  
        </div>
      </div>


  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>List of Employee Loans Enrolment</h4></ol>

            <div class="col-md-12" style="margin-bottom: 30px;">
            
                <div class="col-md-4">
                  <select class="form-control" id="fcompany" name="fcompany" onchange="get_company_loantype(this.value);">
                      <option selected disabled value="all">Select Company</option>
                      <option value="all">All</option>
                      <?php foreach($companyList as $comp){?>
                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="col-md-4">
                  <select class="form-control" id="floantype" name="floantype" onchange="get_filtered_loan();">
                      <option value="all" disabled selected>Select Loan Type</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <select class="form-control" id="fstatus" name="fstatus" onchange="get_filtered_loan();">
                     <option selected disabled value="all">Select Status</option>
                     <option value="all">All</option>
                     <option value="Active">Active</option>
                     <option value="Paid">Paid</option>
                     <option value="Pause">Pause</option>
                  </select>
                </div>
                <br><br><br>
              <div class="box box-danger" class='col-md-12'></div>
            </div>
            <div class="col-md-12" id="loan_main_action">
            <table id="table_home" class="table table-hover table-striped">
                <thead>
                  <tr class="success">
                    <th>ID</th>
                    <th>Loan Type</th>
                    <th>Employee ID</th>
                    <th>Full Name</th>  
                    <th>Company</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 
  <!---END LIST-->
   <!---START ADD/EDIT/UPLOAD form-->
   <div class="col-md-4" style="padding-bottom: 50px;" id="actions">
   </div>  
   <!---END ADD/EDIT/UPLOAD form-->
  <!--START MODAL-->
    <div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Result"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
    </div>  
    <!--End Employee List Modal Container-->
    <!-- End Content Wrapper. Contains page content -->

    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
   <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <!--//==========End Js/bootstrap==============================//-->

  <!--Start AJAX FUNCTIONS-->   
 <script>
      //for datatables
          $(function () {

                  //Initialize Select2 Elements
                  $(".select2").select2();
                  $("#table_home").DataTable( { lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]   });
                });
      //end datatables

      //start result company loans
          function chooseCompany(val)
            {    
              //store the data in hidden input type
              document.getElementById("result_of_company").value = val;
              //refresh the div actions
              $("#actions").load(location.href + " #actions");
               document.getElementById("cSearch").value = "";
                 {
                if (window.XMLHttpRequest)
                  {
                  xmlhttp=new XMLHttpRequest();
                  }
                else
                  {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                  }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      //output the result
                    document.getElementById("fetch_company_result").innerHTML=xmlhttp.responseText;

                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/companyLoans/"+val,true);
                xmlhttp.send();
                } 
            }
       //end result company loans

    //start list of employees applied in loan/per company and loan
           function empLoans(val,val2)
              {  
                //refresh div action
                $("#actions").load(location.href + " #actions");
                //store the result in hidden input type
                document.getElementById("result_of_loan").value = val2; 
                $("#Search_Employee_Result").load(location.href + " #Search_Employee_Result");
                 document.getElementById("cSearch").value = "";  
                {
                  if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                        //output the result
                      document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                      //table per_loan_table datatables
                       $("#per_loan_table").DataTable({
                        
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/resultLoan/"+val+"/"+val2,true);
                  xmlhttp.send();
                  }  
               
            }
    //end list of employees applied in loan/per company and loan

    //add form
    function loanAdd(val,val2)
    {
      $("#divadd").show();
      $("#divmain").hide();
      $("#divadditional").hide();
      //store the data of company id and loan id in hidden input type
      document.getElementById("result_of_loan").value = val; 
      document.getElementById("result_of_company").value = val2;

      {
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            { 
              //output results
            document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/loanAdd/"+val+"/"+val2,true);
        xmlhttp.send();
        } 
    }

    //upload,download form
    function loanUpload(val,val2)
        {
          {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/loanUpload/"+val+"/"+val2,true);
            xmlhttp.send();
            } 
        }

     //list of search employees
      function employee_list(val)
      {

      var company_id= document.getElementById("result_of_company").value;

      {
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            { 
            document.getElementById("Search_Employee_Result").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/search_employee_list/"+val+"/"+company_id,true);
        xmlhttp.send();
        } 

    }

    //store the employee id in hidden input type
     function select_emp(id,name)
    {
      document.getElementById("result_of_employee").value = id;
      document.getElementById("result_employee").value = id;  
      document.getElementById("search_employee").value = name;
      document.getElementById("cSearch").value =''; 

    }

    function isNumberKey(txt, evt) {
      
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }

    
    function add_commas(number){
      //remove any existing commas...
      number=number.replace(/,/g, "");
      //start putting in new commas...
      number = '' + number;
      if (number.length > 3) {
        var mod = number.length % 3;
        var output = (mod > 0 ? (number.substring(0,mod)) : '');
        for (i=0 ; i < Math.floor(number.length / 3); i++) {
          if ((mod == 0) && (i == 0))
            output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
          else
            output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
        }
        return (output);
      }
      else return number;
    }
   //pay tpe option result
    function viewOption()
    {
      document.getElementById("c_1").checked = false;
      document.getElementById("c_2").checked = false;
      document.getElementById("c_3").checked = false;
      document.getElementById("c_4").checked = false;
      document.getElementById("c_5").checked = false
      document.getElementById("c_6").checked = false;
      $("#pay_type_option_main").show();

      if(document.getElementById("pay_type").value==1)
      {

         $("#c1").show();
         $("#c2").show();
         $("#c3").show();
         $("#c4").show();
         $("#c5").show();
         $("#c6").show();
      }
      else if(document.getElementById("pay_type").value==2 || document.getElementById("pay_type").value==3)
      {
         $("#c1").show();
         $("#c2").show();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
         $("#c6").show();
       
      }
     
      else{
          document.getElementById("c_6").checked = true;
         $("#c6").show();
         $("#c2").hide();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
      }
        
    }

    function checkbox_checker(val)
    {
      var ckbox = $('#c_6');
       if (ckbox.is(':checked')) {
            document.getElementById("c_1").disabled = true;
            document.getElementById("c_2").disabled = true;
            document.getElementById("c_3").disabled = true;
            document.getElementById("c_4").disabled = true;
            document.getElementById("c_5").disabled = true;

            document.getElementById("c_1").checked = false;
            document.getElementById("c_2").checked = false;
            document.getElementById("c_3").checked = false;
            document.getElementById("c_4").checked = false;
            document.getElementById("c_5").checked = false;
        } else {
            document.getElementById("c_1").disabled = false;
            document.getElementById("c_2").disabled = false;
            document.getElementById("c_3").disabled = false;
            document.getElementById("c_4").disabled = false;
            document.getElementById("c_5").disabled = false;

        }  
    }

    //save the added emp[loyee loan
      function saveLoan(cc)
     {  
        var doc_no = document.getElementById('result_docno').value;
        var checks = document.getElementsByClassName("option");
        

        var pay_type_option='';

        for (i=0;i<cc; i++)
        {
          if (checks[i].checked === true)
          {
            pay_type_option +=checks[i].value + "-";
            
          }
        }
          
        var employee= document.getElementById("result_employee").value;
        var loan= document.getElementById("result_loan").value;
        var company= document.getElementById("result_company").value;

        var date_effective= document.getElementById("date_effective").value;
        var date_granted= document.getElementById("date_granted").value;

        var loan_amt= document.getElementById("loan_amt").value;
        var amortization= document.getElementById("amortization").value;
        var prin_amt= document.getElementById("prin_amt").value;

        var pay_type= document.getElementById("pay_type").value;
        var ref_no= document.getElementById("ref_no").value;

        if(pay_type_option == '' || pay_type == '' || date_effective == '' || date_granted == '' || loan_amt =='' || amortization == '' || prin_amt == '')
        {
          alert("Check all fields required");
          alert(pay_type_option + "/" + pay_type +"/"+ date_effective +"/"+ date_granted +"/"+ loan_amt +"/"+ amortization  +"/"+prin_amt );
        }
        else
            { 
             

              {
                if (window.XMLHttpRequest)
                  {
                  xmlhttp=new XMLHttpRequest();
                  }
                else
                  {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                  }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                    
                      $("#per_loan_table").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
                       setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                    }
                  }

                 xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/save_emp_loan/"+employee+"/"+loan+"/"+company+"/"+date_effective+"/"+date_granted+"/"+loan_amt+"/"+amortization+"/"+prin_amt+"/"+pay_type+"/"+pay_type_option+"/"+ref_no+"/"+doc_no,true);
                xmlhttp.send();
                } 
                   document.getElementById("ref_no").value = "";
                   document.getElementById("search_employee").value = "";
                   document.getElementById("result_employee").value = "";
                   document.getElementById("date_effective").value = "";
                   document.getElementById("date_granted").value = "";
                   document.getElementById("loan_amt").value = "";
                   document.getElementById("amortization").value = "";
                   document.getElementById("prin_amt").value = "";
                   document.getElementById("pay_type").value = "";
                   $("#pay_type_option_main").hide();
                   document.getElementById("c_1").disabled = false;
                   document.getElementById("c_2").disabled = false;
                   document.getElementById("c_3").disabled = false;
                   document.getElementById("c_4").disabled = false;
                   document.getElementById("c_5").disabled = false;
                   document.getElementById("c_6").disabled = false;
              } 
               
      }

      //edit loan record
       function editDetails(emp_loan_id,loan,company)
        {

          {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("actions").innerHTML=xmlhttp.responseText;
                }

              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/editDetails/"+emp_loan_id+"/"+loan+"/"+company,true);
            xmlhttp.send();
          } 

        }
    function hide()
    {
     $("#update_loan_details").load(location.href + " #update_loan_details");
    }
        //update employee loan status
    function updateStatus(status,emp_loan_id,loan,company)
    {
        //refresh div action
      $("#actions").load(location.href + " #actions");
      var result = confirm("Are you sure you want to update the ststus?");
      if(result == true)
      {
       {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                  $("#per_loan_table").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                      });
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/updateStatus/"+status+"/"+emp_loan_id+"/"+loan+"/"+company,true);
            xmlhttp.send();
        } }
        else{}

    }




    //delete employee loan records
    function deleteDetails(emp_loan_id,loan,company)
    {
     
     $("#actions").load(location.href + " #actions");
      var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
      {
       {
          if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#per_loan_table").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/deleteDetails/"+emp_loan_id+"/"+loan+"/"+company,true);
            xmlhttp.send();
          }
      }
      else{}
    }

  function enable_disable(emp_loan_id,loan,company,action,option,idd)
  {
  	if(action=='Paid')
  	{
  		var f = 'Are you sure you want to mark this loan as "PAID"?';
  	}
  	else
  	{
  		var f = 'Are you sure you want to' + action + 'this loan record?';
  	}

  	var result = confirm(f);
    if(result == true)
       {

      if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#per_loan_table").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/enable_disable/"+emp_loan_id+"/"+loan+"/"+company+"/"+action+"/"+option+"/"+idd,true);
      xmlhttp.send();
     }
  }

  function deleteDetails_additional(emp_loan_id,loan,company,id)
    {
    
     $("#actions").load(location.href + " #actions");
      var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
      {
       {
          if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#per_loan_table").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
                  setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/deleteDetails_additional/"+emp_loan_id+"/"+loan+"/"+company+"/"+id,true);
            xmlhttp.send();
          }
      }
      else{}
    }


  //filter status
    function filter_status(status)
    {

        var loan= document.getElementById("filter_loan").value;
        var company= document.getElementById("filter_company").value;
       {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("status").innerHTML=xmlhttp.responseText;
                
                      $("#per_loan_table").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/filter_status/"+status+"/"+loan+"/"+company,true);
            xmlhttp.send();
            }
    }

    //reset add fields
    function reset()
    {

     document.getElementById("ref_no").value = "";
     document.getElementById("search_employee").value = "";
     document.getElementById("result_employee").value = "";
     document.getElementById("date_effective").value = "";
     document.getElementById("date_granted").value = "";
     document.getElementById("loan_amt").value = "";
     document.getElementById("amortization").value = "";
     document.getElementById("prin_amt").value = "";
     document.getElementById("pay_type").value = "";
      $("#pay_type_option_main").hide();
    }

    //update employee loan
    function saveUpdate(emp_loan_id,loan,company)
    {

       var checks = document.getElementsByClassName("option");
       var pay_type_option='';

        for (i=0;i<6; i++)
        {
          if (checks[i].checked === true)
          {
            pay_type_option +=checks[i].value + "-";
            
          }
        }
        var result = confirm("Are you sure you want to update this record?");
        if(result == true)
            {
              var loan_amt= document.getElementById("loan_amt").value;
              var principal_amt= document.getElementById("principal_amt").value;
              var date_effective= document.getElementById("date_effective").value;
             var pay_type= document.getElementById("pay_type").value;
              var amortization= document.getElementById("amortization").value;
              var ref_no= document.getElementById("ref_no").value;

              if(loan_amt == '' || principal_amt == '' || date_effective == '' || pay_type == '' || ref_no =='' || pay_type_option == '' || amortization == '')
                  {
                    alert("Check all empty field");
                  }
                  else{

                      $("#actions").load(location.href + " #actions");
                  {
                  if (window.XMLHttpRequest)
                      {
                      xmlhttp=new XMLHttpRequest();
                      }
                    else
                    {// code for IE6, IE5
                      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
                        xmlhttp.onreadystatechange=function()
                      {
                      if (xmlhttp.readyState==4 && xmlhttp.status==200)
                        { 
                         document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                           $("#per_loan_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                              });
                            setTimeout(function() {
                              $('#flashdata_result').fadeOut('fast');
                              }, 3000);
                        }
                      }
                      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/saveUpdate/"+emp_loan_id+"/"+loan+"/"+company+"/"+loan_amt+"/"+principal_amt+"/"+date_effective+"/"+pay_type+"/"+pay_type_option+"/"+amortization+"/"+ref_no,true);
                      xmlhttp.send();
                    }
                  }
              }
        else
          {}
    }


    function saveUpdate_additional(emp_loan_id,loan,company,addloan_id)
    {
     
      var amount = document.getElementById('additional_loanamount').value;
      var desc = document.getElementById('additional_description').value;
      if(desc=='')
      {
        var desc='not_included';
      }
      else
      {
        function_escape('additional_description_final',desc);
        var desc = document.getElementById('additional_description_final').value;
      }
      var reference = document.getElementById('additional_ref').value;
      if(reference=='')
      {
        var reference='not_included';
      }
      var loan_app = document.getElementById('additional_appnum').value;
      if(loan_app=='')
      {
        var loan_app='not_included';
      }

      if(amount=='')
      {
        alert("Please fill up loan amount fields");
      }
      else
      {
      
        if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                      $("#per_loan_table").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                       setTimeout(function() {
                              $('#flashdata_result').fadeOut('fast');
                              }, 3000);
                       
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/saveUpdate_additional/"+amount+"/"+desc+"/"+loan_app+"/"+reference+"/"+emp_loan_id+"/"+loan+"/"+company+"/"+addloan_id,true);
        xmlhttp.send();
      }

    }  
     //upload,download form
   
    function massupload_all()
        {

          {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("actions").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/massupload_all",true);
            xmlhttp.send();
            } 
        }

    function MassUpload() {

            var company= document.getElementById("company").value;
            var action= document.getElementById("action").value;
            var loan= document.getElementById("loan").value;
            var fileName= document.getElementById("file").value;

            if(action == '' || file == '' )
            {
              alert('Choose a file to continue.');
            }
            else{
              alert("NOTE: If there's a downloaded file open/check it to correct the template!");
              {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/upload"+company+"/"+loan+"/"+fileName+"/"+action,true);
            xmlhttp.send();
            } 
            }
        }

    function myFunction() {
            alert("NOTE: If there's a downloaded file open/check it to correct the template!");
           if(document.getElementById("file").value =='' || document.getElementById("file").value ==null)
           {
            alert("Select File to continue");
           }
           if(document.getElementById("action").value =="")
           {
              alert("Select Action to continue");
           }
      }
  
    $(document).ready(function(){
        if($(".has-warning").value()){
          $("#submit").removeAttr("disabled");
                };
                });

 	  function pay_type(id,name)
 	  {
   		if(id=='')
   		{
   			alert('The Pay Type ID is null! Please Check.');
   		}
   		else
   		{
   		document.getElementById("pay_type").value = id;
   		}
 	  }




    //additonal code for emp_loans request list
    function employee_loan_request(id,company)
    {
      if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
                       $("#employee_loan_list").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/get_employee_loan_request/"+id+"/"+company,true);
                  xmlhttp.send();
    }

    function emp_loan_request_forms()
    {
      if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                        //output the result
                      document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                      //table per_loan_table datatables
                      $("#employee_loan_list").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/emp_loan_request_forms/",true);
                  xmlhttp.send();
    }

    function get_company_loan_type(company)
    {
      if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                        
                      document.getElementById("loan_filter").innerHTML=xmlhttp.responseText;
                     
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/get_company_loan_type/"+company,true);
                  xmlhttp.send();

      filter_forms();
       var xmlhttp; 
    }

    function check_status(val)
    {
      if(val=='approved')
      {
        document.getElementById('approved_filter').disabled=false;
      }
      else
      {
        document.getElementById('approved_filter').disabled=true;
      }
      filter_forms();
    }

    function filter_forms()
    {

      var company = document.getElementById('company_filter').value;
      var loan = document.getElementById('loan_filter').value;
      var status = document.getElementById('status_filter').value;
      var for_approved = document.getElementById('approved_filter').value;

       var xmlhttp; 
       if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                        
                      document.getElementById("status").innerHTML=xmlhttp.responseText;
                      //table per_loan_table datatables
                      $("#employee_loan_list").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/filter_forms/"+company+"/"+loan+"/"+status+"/"+for_approved,true);
                  xmlhttp.send();


    }


    function add_additional_loan(loan_id,loan_type,company)
    {
       $("#divadd").hide();
       $("#divmain").hide();
       $("#divadditional").show();

        if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/add_additional_loan/"+loan_id+"/"+loan_type+"/"+company,true);
        xmlhttp.send();
    }

     //view employee record
   function viewDetails(emp_loan_id,loan,company)
    {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/viewDetails/"+emp_loan_id+"/"+loan+"/"+company,true);
            xmlhttp.send();
          
    }


    function viewDetailss(emp_loan_id,loan,company)
    {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/viewDetailss/"+emp_loan_id+"/"+loan+"/"+company,true);
            xmlhttp.send();
          
    }

    function collapse()
    {
      var x = document.getElementById('datagridd');
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        } 
    }

    function get_all_approved_forms(val)
    {
     
      if(val=='forms')
      {
        document.getElementById('additional_approved').disabled=false;
        get_all_approvedforms();
      }
      else
      {
         document.getElementById('additional_approved').value='';
        document.getElementById('additional_approved').disabled=true;
      }
    }

    function get_all_approvedforms()
    {
      var loan = document.getElementById('loan_type').value;
      var company = document.getElementById('company_id').value;

        if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("additional_approved").innerHTML=xmlhttp.responseText;
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/get_all_approved_forms/"+loan+"/"+company,true);
        xmlhttp.send();
    }


    function get_docno_details(id)
    {
       var data = id;
       $.ajax({
      type: "POST",
      data: {id: data},
      url: '<?=base_url()?>app/payroll_emp_loan_enrolment/get_docno_details/',
      dataType: 'json',
      success: function(data){
            var info = data.data;
            if(info.loan_amount!=''){  document.getElementById('addditonal_amount').value=info.loan_amount;  }
            if(info.reason!=''){  document.getElementById('addditonal_description').value=info.reason;  }
            if(info.doc_no!=''){ document.getElementById('loan_app').value=info.doc_no; }
            document.getElementById("doc_no_details").innerHTML = "<a style='cursor:pointer;' href='<?php echo base_url();?>/app/transaction_employees/form_view/"+info.doc_no+"/emp_loans/HR005' target='_blank'>View Doc Number Form</a>";
        }
    });
    }

    function save_additional_loan(loan_id,loan_type,company)
    {
      var option = document.getElementById('addditonal_option').value;
      if(option=='forms')
      {
       var doc = document.getElementById('additional_approved').value;
      }
      else
      {
        var doc='not_included';
      }
      var amount = document.getElementById('addditonal_amount').value;
      var date_effective = document.getElementById('date_effective').value;

      var desc = document.getElementById('addditonal_description').value;
      if(desc=='')
      {
        var desc='not_included';
      }
      else
      {
        function_escape('addditonal_description_final',desc);
        var desc = document.getElementById('addditonal_description_final').value;
      }
      var reference = document.getElementById('addditonal_reference').value;
      if(reference=='')
      {
        var reference='not_included';
      }
      var loan_app = document.getElementById('loan_app').value;
      if(loan_app=='')
      {
        var loan_app='not_included';
      }

      if(option=='' || amount=='' || date_effective=='')
      {
        alert("Please fill up all required fields");
      }
      else
      {
        if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                       $("#per_loan_table").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      setTimeout(function() {
                              $('#flashdata_result').fadeOut('fast');
                              }, 3000);
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/save_additional_loan/"+option+"/"+doc+"/"+amount+"/"+desc+"/"+reference+"/"+loan_app+"/"+loan_id+"/"+loan_type+"/"+company+"/"+date_effective,true);
        xmlhttp.send();
      }


    }

    function add_new_approved_loan(loan_type,company,id)
    {
      if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/add_new_approved_loan/"+loan_type+"/"+company+"/"+id,true);
        xmlhttp.send();

    }

    function editDetails(option,emp_loan_id,loan_type_id,company)
    { 
       if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("update_loan_details").innerHTML=xmlhttp.responseText;
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/editDetails/"+option+"/"+emp_loan_id+"/"+loan_type_id+"/"+company,true);
        xmlhttp.send();
    }

    function get_company_loantype(val)
    {
       var xmlhttp;
       if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("floantype").innerHTML=xmlhttp.responseText;
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/get_company_loantype/"+val,true);
        xmlhttp.send();

        get_filtered_loan();
    }

    function get_filtered_loan()
    {
        var company = document.getElementById('fcompany').value;
        var loan = document.getElementById('floantype').value;
        var status = document.getElementById('fstatus').value;

        var xmlhttp;
        if (window.XMLHttpRequest)
                    {
                    xmlhttp=new XMLHttpRequest();
                    }
                  else
                    {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                  xmlhttp.onreadystatechange=function()
                    {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("loan_main_action").innerHTML=xmlhttp.responseText;
                        $("#table_home").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                        });
                      }
                    }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/get_filtered_loan/"+company+"/"+loan+"/"+status,true);
        xmlhttp.send();

    }

    function function_escape(ids,titles)
    {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }

   function view_loan_ledger(emp_loan_id)
    {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_actions").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/view_loan_ledger/"+emp_loan_id,true);
            xmlhttp.send();
          
    }
   function view_loan_ledger2(emp_loan_id)
    {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("loan_ledger").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/view_loan_ledger/"+emp_loan_id,true);
            xmlhttp.send();
          
    }


    //mass upload

    function emp_loan_mass_upload()
    {
       if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/payroll_emp_loan_enrolment/emp_loan_mass_upload/",true);
            xmlhttp.send();     
    }


  </script>
  <!--END ajaxX FUNCTIONS-->