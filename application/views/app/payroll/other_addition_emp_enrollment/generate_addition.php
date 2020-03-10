<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

   
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
	<style type="text/css">
		.dtr_center{
			text-align: center;
		}
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 10px/100% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #006699; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #0070A8; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #E1EEF4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #E1EEF4; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #006699;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #006699;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #006699; color: #FFFFFF; background: none; background-color:#00557F;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
.datagrid{
	width: 100%;
 margin: auto;
}
.shift_time{
	background-color: #F9D4BD;
}
.actual_time{
	background-color: #D9F9BD;
}
.hours_worked{
	background-color: #BDF9EE;
}


	</style>    
  </head>



<div id="flashdata_result">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
  </div>
  
<h2 align="center" style="color:darkgreen;"><b>PAYROLL OTHER ADDITION EMPLOYEE ENROLLMENT</b>
<small><?php if(!empty($this->input->post('od_types'))){}else{ echo "You must choose a addition type OR You must create a addition type.";}?></small>

</h2>

<br>
<form  method="post" action="<?php echo base_url()?>app/payroll_other_addition_emp_enrollment/save_addition_enrollment/" target="_blank">  

<?php

$wDivision=$company_info->wDivision;
$company_name=$company_info->company_name;
$company_id=$this->input->post('company_id');
$pay_type=$this->input->post('pay_type');
$pay_type_group=$this->input->post('pay_type_group');

$pay_period=$this->input->post('pay_period');
$section=$this->input->post('section');
$division = $this->input->post('division');
$department = $this->input->post('department');
$sub_section = $this->input->post('sub_section');


?>
<input type="hidden" name="pay_period" value="<?php  echo $pay_period; ?>">
<input type="hidden" name="company_id" value="<?php  echo $company_id; ?>">
<input type="hidden" name="pay_type" value="<?php  echo $pay_type; ?>">
<input type="hidden" name="pay_type_group" value="<?php  echo $pay_type_group; ?>">
<input type="hidden" name="section" value="<?php  echo $section; ?>">
<input type="hidden" name="division" value="<?php  echo $division; ?>">
<input type="hidden" name="department" value="<?php  echo $department; ?>">
<input type="hidden" name="wDivision" value="<?php  echo $wDivision; ?>">
<input type="hidden" name="sub_section" value="<?php  echo $sub_section; ?>">


<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th style="text-align: center;"><input type="checkbox" class="chk_boxes" label="check all"/>check all</th>
                        <th style="text-align: center;">EMP. ID</th>
                        <th style="text-align: center;">EMPLOYEE NAME</th>
                        <th style="text-align: center;">RECORD</th>
                        
                        <?php
                          //foreach ($addition_type as $addtype){
                        if(!empty($this->input->post('od_types'))){                      
                          foreach ($this->input->post('od_types') as $key => $addtype)
                          {
                            list($od_id,$other_addition_type) = explode(",",$addtype);
                           
                            echo "<th style='text-align: center;'>(".$od_id.')'.$other_addition_type.'<br>'."<input type='number' name='master".$od_id."' class='mirror' id='master' placeholder='0.00' step='0.01' style='width:70px; float:center; text-align:center;' onclick='f_c_a".$od_id."();' onkeyup='master_change".$od_id."(this.value);'>"."</th>";
                          }

                        }else{

                        }

                        ?>

                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($employee as $employees){ 

                          if (is_array($addition_enrollment) || is_object($addition_enrollment))
                                    {
                                        foreach ($addition_enrollment as $bb)  
                                        {

                                                           $arr_value_of_enrolled_employee["oa".$bb->other_addition_id."-".$bb->employee_id] = $bb->amount;
                                                        
                                          }
                                         
                                      } 

                          $arr_emp[$employees->employee_id] = $employees->employee_id;            
          
                        ?>

                      <tr>
                       <td align='center'>  
                            <input type='checkbox' class='chk_boxes1' name='coa<?php echo $employees->employee_id;?>' id='coa<?php echo $employees->employee_id;?>' value='1'  />
                            <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employees->employee_id;?>">
                        </td>
                        <td align="center"><?php echo $employees->employee_id?></td>
                        <td align="center"><?php echo $employees->name?></td>
                        <input type="hidden" name="company_id" id="company_id" value="<?php echo $employees->company_id ?>">
                       <!-- <?php var_dump($count)?> -->

                        <td align="center"><?php
                              $employee_id = $employees->employee_id;
                              $query = $this->db->query('SELECT * FROM other_addition_enrollment WHERE `employee_id` = '.$employee_id.' and `payroll_period_id`='.$pay_period.' and `company_id`= '.$company_id.'');
                              echo $query->num_rows();
                              ?></td>
                        <?php 

                        //foreach ($addition_type as $addtype){

if(!empty($this->input->post('od_types'))){
                          foreach ($this->input->post('od_types') as $key => $odtypes)
                          {
                            list($od_id,$other_addition_type) = explode(",",$odtypes);
                            $arr_oa[$od_id] = $od_id;
                          ?>
                        <input type="hidden" name="add_type_id" value="<?php echo $od_id;?>">
                        <input type="hidden" name="entry_type" value="manual_encode">
                        
                        <td align="center"><input class="mirror" type="number" step="0.01" id="oa<?php echo $od_id;?>-<?php echo $employees->employee_id;?>" name="oa<?php echo $od_id;?>-<?php echo $employees->employee_id;?>" value="<?php if(isset( $arr_value_of_enrolled_employee["oa".$od_id."-".$employees->employee_id]) &&  $arr_value_of_enrolled_employee["oa".$od_id."-".$employees->employee_id]){ echo  $arr_value_of_enrolled_employee["oa".$od_id."-".$employees->employee_id]; }?>" placeholder="0.00" style="text-align:center;" onkeyup="f_c_e('<?php echo $employees->employee_id;?>');" onclick="f_c_e('<?php echo $employees->employee_id;?>');"></td>
                        <?php }
}else{
}

                        ?>

                        
                
                      </tr>
                      <?php }?>

 
           </tbody>
      </table>
    </div>

     <center><input type="submit" name="submit" value="SAVE SELECTED RECORD"   class="btn btn-primary"></center>
 </form>
       



</div>


<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script> 
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>

   
    <script type="text/javascript"> 
      

       $(".chk_boxes").click(function()   //SCIPT for Checkall
         {
         var checked_status = this.checked;
         $(".chk_boxes1").each(function()
           {
            this.checked = checked_status;
           });
        });

    
    //FLASHDATA FADE======================================================================

          setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);



       //==================================================================
  

      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });

      //================================== change all by master textbox  ==============

      <?php foreach($arr_oa as $oa_id){?>
        function master_change<?php echo $oa_id;?>(str){
          <?php foreach($arr_emp as $emp_id){?>
            document.getElementById('oa<?php echo $oa_id;?>-<?php echo $emp_id;?>').value = str;

          <?php }?>
        }



      <?php }?>

      function f_c_e(str){ 
          document.getElementById('coa'+str).checked = true;
        }



     <?php foreach($arr_oa as $oa_id){?>
        function f_c_a<?php echo $oa_id;?>(){ 
         
           <?php foreach($arr_emp as $emp_id){?>
              document.getElementById('coa<?php echo $emp_id;?>').checked = true;
            <?php }?>
          
          }
        <?php }?>   
    </script>





