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

<h2 align="center" style="color:darkgreen;"><b>PAYROLL SET AUTOMATIC DEDUCTION EMPLOYEE ENROLLMENT</b></h2>

<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">View Payroll Formula List</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <b><h4 class="modal-title">Payroll Formulas Description</h4></b>
        </div>
        <div class="modal-body">
             
                 <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                        <th style="text-align:center;">Formula</th>
                        <th style="text-align:center;">Formula Description</th>
                    </tr>
                  </thead>
       
                  <tbody>
                   <?php foreach ($payroll_formula_list as $formulalists) { ?>
                    <tr>
                        <td align="center">Formula [<?php echo $formulalists->formula_id; ?>]</td>
                        <td align="center"><?php echo $formulalists->formula_description; ?></td>
                    </tr>
                  <?php  } ?>

                  </tbody>
                </table>

 
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<br>
<form  method="post" action="<?php echo base_url()?>app/payroll_other_deduction_automatic/save_deduction_enroll_automatic/" target="_blank">  

<?php
$wDivision=$company_info->wDivision;
$company_name=$company_info->company_name;
$company_id=$this->input->post('company_id');
$pay_type=$this->input->post('pay_type');
$pay_type_group =$this->input->post('pay_type_group');

$pay_period=$this->input->post('pay_period');
$division=$this->input->post('division');
$department=$this->input->post('department');
$section=$this->input->post('section');

$o_d_id=$this->input->post('od_id');
$effective_date=$this->input->post('effective_date');
$cutoff=$this->input->post('cutoff');



?>
<input type="hidden" name="company_id" value="<?php  echo $company_id; ?>">
<input type="hidden" name="pay_type" value="<?php  echo $pay_type; ?>">
<input type="hidden" name="pay_type_group" value="<?php  echo $pay_type_group; ?>">
<input type="hidden" name="section" value="<?php  echo $section; ?>">
<input type="hidden" name="division" value="<?php  echo $division; ?>">
<input type="hidden" name="department" value="<?php  echo $department; ?>">
<input type="hidden" name="wDivision" value="<?php  echo $wDivision; ?>">
<input type="hidden" name="od_id" value="<?php  echo $o_d_id; ?>">
<input type="hidden" name="effective_date" value="<?php  echo $effective_date; ?>">
<input type="hidden" name="cutoff" value="<?php  echo $cutoff; ?>">



  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th style="text-align: center;"><input type="checkbox" class="chk_boxes" label="check all"  />check all</th>
                        <th style="text-align: center;">EMP. ID</th>
                        <th style="text-align: center;">EMPLOYEE NAME</th>
                        <th style="text-align: center;">RECORD</th>
                        
                        <?php
                         $query_od_id = $this->payroll_other_deduction_automatic_model->getodid($o_d_id,$company_id);
                          foreach ($query_od_id as $deducttype) 

                          {
                           
                            echo "<th style='text-align: center;'>(".$deducttype->id.')'.$deducttype->other_deduction_type.'<br>'."<input type='text' name='master".$deducttype->id."' class='mirror' id='master' placeholder='0.00' step='0.01' style='width:70px; float:center; text-align:center;' onclick='f_c_a".$deducttype->id."(this.value);' onkeyup='master_change".$deducttype->id."(this.value);'>"."</th>";
                          }

                        ?>
                        <th style="text-align: center;">FORMULA</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach($employee as $employees){ 

                          if (is_array($automatic_enrollment) || is_object($automatic_enrollment))
                                    {
                                        foreach ($automatic_enrollment as $bb)  
                                        {

                                                           $arr_value_of_enrolled_employee["od".$bb->other_deduction_id."-".$bb->employee_id] = $bb->open_entry;

                                                           $arr_value_of_enrolled_formula["pf".$bb->other_deduction_id."-".$bb->employee_id] = $bb->payroll_formulas_id;
                                                        
                                          }
                                         
                                      } 

                          $arr_emp[$employees->employee_id] = $employees->employee_id;            
          
                        ?>

                      <tr>
                       <td align='center'>  
                            <input type='checkbox' class='chk_boxes1' name='cod<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>' id='cod<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>' value='1'  />
                            <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employees->employee_id;?>">
                        </td>
                        <td align="center"><?php echo $employees->employee_id?></td>
                        <td align="center"><?php echo $employees->name?></td>
                        <input type="hidden" name="company_id" id="company_id" value="<?php echo $employees->company_id ?>">
                       <!-- <?php var_dump($count)?> -->

                        <td align="center"><?php
                              $employee_id = $employees->employee_id;
                              $query = $this->db->query('SELECT * FROM other_deduction_automatic WHERE `employee_id` = '.$employee_id.' and `cutoff` = '.$cutoff.' and `other_deduction_id` = '.$o_d_id.' and `pay_type` = '.$pay_type.' and  `company_id`= '.$company_id.'');
                              echo $query->num_rows();
                              ?></td>
                        <?php 

                        foreach ($query_od_id as $deducttype){

                          $arr_od[$deducttype->id] = $deducttype->id;
                          ?>
                        <input type="hidden" name="deduct_type_id" value="<?php echo $deducttype->id;?>">
                        <input type="hidden" name="entry_type" value="manual_encode">
                        
                        <td align="center"><input class="mirror" type="number" step="0.01" id="od<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>" name="od<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>" value="<?php if(isset( $arr_value_of_enrolled_employee["od".$deducttype->id."-".$employees->employee_id]) &&  $arr_value_of_enrolled_employee["od".$deducttype->id."-".$employees->employee_id]){ echo  $arr_value_of_enrolled_employee["od".$deducttype->id."-".$employees->employee_id]; }?>" placeholder="0.00" style="text-align:center;" onkeyup="f_c_e('<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>');" onclick="f_c_e('<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>');"></td>
                        <?php }?>
                        <td  align="center" >

                           <select  class="form-control" id="pf<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>" name="pf<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>" onkeyup="f_c_e('<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>');" onclick="f_c_e('<?php echo $deducttype->id;?>-<?php echo $employees->employee_id;?>');">
                                      <option selected="selected" value="" required>Formula [<?php if(isset( $arr_value_of_enrolled_formula["pf".$deducttype->id."-".$employees->employee_id]) &&  $arr_value_of_enrolled_formula["pf".$deducttype->id."-".$employees->employee_id]){ echo  $arr_value_of_enrolled_formula["pf".$deducttype->id."-".$employees->employee_id]; } else{ echo "none"; }?>] </option>
                                     
                                     <?php 
                                      
                                      foreach($formula_list as $formulalist){

                                          
                                      echo "<option value='".$formulalist->formula_id."' >Formula [".$formulalist->formula_id."]</option>";
                                      }
                                      ?> 
                                   </select> 
                      
                        </td>
                       
                      </tr>
                      <?php }?>

 
           </tbody>
      </table>

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
      

       $(".chk_boxes").click(function()   //SCRIPT for Checkall
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

      <?php foreach($arr_od as $od_id){?>
        function master_change<?php echo $od_id;?>(str){
          <?php foreach($arr_emp as $emp_id){?>
            document.getElementById('od<?php echo $od_id;?>-<?php echo $emp_id;?>').value = str;
          <?php }?>
        }



      <?php }?>

      function f_c_e(str){ 
          document.getElementById('cod'+str).checked = true;
        }

       <?php foreach($arr_od as $od_id){?>
      function f_c_a<?php echo $od_id;?>(str){ 
       
         <?php foreach($arr_emp as $emp_id){?>
            document.getElementById('cod<?php echo $od_id;?>-<?php echo $emp_id;?>').checked = true;
          <?php }?>
        
        }
      <?php }?>   
    </script>





