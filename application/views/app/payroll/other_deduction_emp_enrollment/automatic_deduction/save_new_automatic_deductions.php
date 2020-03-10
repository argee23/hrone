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

   <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <script>
    function printProfile(divID) {

      var printContents = document.getElementById(divID).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;

    }
    </script>

<div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">
              <div id ="flashdata_result" class="container-fluid">
                <br>
                  <?php echo $message;?>
                  <?php echo validation_errors(); ?>
                   
                <br>
              </div>

      
          <div class="col-md-12" >
      <div class="table-responsive">
      
     <table id="example1" class="table table-striped table-striped table-bordered table-condensed">
        <thead >
            <tr>
                <th style="text-align:center;">DEDUCTION</th>
                <th  style="text-align:center;">DATE EFFECTIVE</th>
                <th  style="text-align:center;">DATETIME CREATED</th>
                 <th  style="text-align:center;">PAY TYPE</th>
                <th  style="text-align:center;">PER</th>
                <th  style="text-align:center;">STATUS</th>
                <th  style="text-align:center;">ACTION</th>
            </tr>
        </thead>
        <tbody>
             <?php foreach($deductiontype_list as $deductionlist){if($deductionlist->InActive == 0){ $inactive = 'Active';}else{ $inactive = 'InActive';}?>

                  <tr <?php if($deductionlist->InActive == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                         <input type="hidden" name="oa_id" id="oa_id" value="<?php echo $deductionlist->other_deduction_id;  ?>"> 
                        <input type="hidden" name="pay_type" id="pay_type" value="<?php echo $deductionlist->pay_type;  ?>"> 
                        <input type="hidden" name="company_id" id="company_id" value="<?php echo $deductionlist->company_id;  ?>">
                        <input type="hidden" name="date_effective" id="date_effective" value="<?php echo $deductionlist->auto_effectivity_date;  ?>">                        
                        <input type="hidden" name="cutoff" id="cutoff" value="<?php echo $deductionlist->cutoff;  ?>">                         
                        <td align="center" ><?php
                              $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?></td>
                        <td align="center" ><?php echo $deductionlist->auto_effectivity_date; ?></td>
                        <td align="center" ><?php echo $deductionlist->date_added;?></td>
                        <td align="center" >
                                              <?php 

                                              if($deductionlist->pay_type == 1 ){

                                                echo "WEEKLY";
                                              }
                                              elseif($deductionlist->pay_type == 2){

                                                 echo "BI-WEEKLY"; 
                                              }
                                              elseif($deductionlist->pay_type == 3){
                                                 echo "SEMI-MONTHLY";
                                              }else{
                                                echo "MONTHLY";
                                              }
        
                                               ?>
                           
                         </td>
                       <td align="center" >
                                              <?php 
                                                  $cut_off_id = $deductionlist->cutoff;

                                                  if($cut_off_id == 6){
                                                      $c_off ="Per Payday";

                                                  }elseif($cut_off_id == '1-2-3-4'){

                                                        $c_off = "1st,2nd,3rd and 4th Cutoff";
                                                  }elseif($cut_off_id == '1-2-3'){

                                                        $c_off = "1st,2nd and 3rd Cutoff";
                                                  }elseif($cut_off_id == '1-2'){

                                                        $c_off = "1st and 2nd Cutoff";
                                                  }elseif($cut_off_id == '1'){

                                                        $c_off = "1st Cutoff";
                                                  }elseif($cut_off_id == '2'){

                                                        $c_off = "2nd Cutoff";
                                                  }elseif($cut_off_id == '3'){

                                                        $c_off = "3rd Cutoff";
                                                  }elseif($cut_off_id == '4'){

                                                        $c_off = "4th Cutoff";
                                                  }elseif($cut_off_id == '5'){

                                                        $c_off = "5th Cutoff";
                                                  }elseif($cut_off_id == '1-2-3-5'){

                                                        $c_off = "1st,2nd,3rd and 5th Cutoff";
                                                  }elseif($cut_off_id == '1-2-4-5'){

                                                        $c_off = "1st,2nd,4th and 5th Cutoff";
                                                  }elseif($cut_off_id == '1-2-4'){

                                                        $c_off = "1st,2nd and 4th Cutoff";
                                                  }elseif($cut_off_id == '1-2-5'){

                                                        $c_off = "1st,2nd,3rd and 5th Cutoff";
                                                  }elseif($cut_off_id == '1-3-4'){

                                                        $c_off = "1st,3rd and 4th Cutoff";
                                                  }elseif($cut_off_id == '1-3-5'){

                                                        $c_off = "1st,3rd and 5th Cutoff";
                                                  }elseif($cut_off_id == '1-3'){

                                                        $c_off = "1st and 3rd Cutoff";
                                                  }elseif($cut_off_id == '1-4'){

                                                        $c_off = "1st and 4th Cutoff";
                                                  }elseif($cut_off_id == '1-4-5'){

                                                        $c_off = "1st,4th and 5th Cutoff";
                                                  }elseif($cut_off_id == '1-5'){

                                                        $c_off = "1st and 5th Cutoff";
                                                  }elseif($cut_off_id == '2-3'){

                                                        $c_off = "2nd and 3rd Cutoff";
                                                  }elseif($cut_off_id == '2-3-5'){

                                                        $c_off = "2nd,3rd and 5th Cutoff";
                                                  }elseif($cut_off_id == '2-4-5'){

                                                        $c_off = "2nd,4th and 5th Cutoff";
                                                  }elseif($cut_off_id == '2-4'){

                                                        $c_off = "2nd and 4th Cutoff";
                                                  }elseif($cut_off_id == '2-5'){

                                                        $c_off = "2nd and 5th Cutoff";
                                                  }elseif($cut_off_id == '3-4'){

                                                        $c_off = "3rd and 4th Cutoff";
                                                  }elseif($cut_off_id == '3-5'){

                                                        $c_off = "3rd and 5th Cutoff";
                                                  }elseif($cut_off_id == '4-5'){

                                                        $c_off = "4th and 5th Cutoff";
                                                  }elseif($cut_off_id == '2-3-4'){

                                                        $c_off = "2nd,3rd and 4th Cutoff";
                                                  }elseif($cut_off_id == '3-4-5'){

                                                        $c_off = "3rd,4th and 5th Cutoff";
                                                  }elseif($cut_off_id == 'per_pay_day'){
                                                        $c_off ="Per Payday";
                                                  }


                                                    echo $c_off;
                                               ?>
                           
                         </td>
                    
                      
                   
                       <td align="center"><?php echo $inactive?></td> 

                       <td align="center" style="padding-right: 35px;">

                    <?php if($deductionlist->InActive == 0){ 


                        $pay_type = $deductionlist->pay_type;
                        $cut_off_id = $deductionlist->cutoff;
                        $od_id = $deductionlist->other_deduction_id;
                        $company_id = $deductionlist->company_id;
                      
                         
                         $paytype_auto = $this->payroll_other_deduction_automatic_model->list_enroll_emp_paytypes($od_id,$cut_off_id,$pay_type,$company_id);
                         // echo $paytype_auto;
                          if(empty($paytype_auto)){
                      ?>
        
                          <a><i class="fa fa-times fa-lg text-danger pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Delete&nbsp;<?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>" onclick="is_automatic_to_zero_deduct('<?php echo $deductionlist->other_deduction_id;?>','<?php echo $deductionlist->id;?>','<?php echo $deductionlist->company_id;?>')"></i></a>
                          <?php }else{ ?>
                           <a><i class="fa fa-times fa-lg text-danger pull-right"  data-toggle="tooltip" data-placement="left" title="This Deduction <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?> is in used")"></i></a>
                          <?php } ?>
                           
                            <a><i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Edit <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>" onclick="set_auto_edit('<?php echo $deductionlist->id; ?>','<?php echo $deductionlist->company_id; ?>','<?php echo $deductionlist->other_deduction_id?>','<?php echo $deductionlist->auto_effectivity_date?>','<?php echo $deductionlist->pay_type?>','<?php echo $deductionlist->cutoff?>')"></i></a>


                            <a href="<?php echo base_url()?>app/payroll_other_deduction_automatic/deactivate_deduction_auto/<?php echo $deductionlist->id;?>"><i <?php echo $this->session->userdata('check_leave_type_todisable_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to Disable <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>" onclick="return confirm('Are you sure you want to disable <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?> Other Deduction Type?')"></i></a>
                             
                        
                            <i class="fa fa-list text-info pull-right" class="hidden" data-toggle="tooltip" data-placement="left" title="Enroll Employee <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>" onclick="enroll_emp_deduct('<?php echo $deductionlist->company_id ?>','<?php echo $deductionlist->pay_type ?>','<?php echo $deductionlist->cutoff ?>','<?php echo $deductionlist->other_deduction_id ?>','<?php echo $deductionlist->auto_effectivity_date; ?>')"></i>        
     

                            <a onclick="manual_excel_upload_auto('<?php echo $deductionlist->company_id; ?>','<?php echo $deductionlist->other_deduction_id?>','<?php echo $deductionlist->auto_effectivity_date?>','<?php echo $deductionlist->pay_type?>','<?php echo $deductionlist->cutoff?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Manual Upload Automatic Deduction 
                              <?php
                              $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?> for  <?php 

                                              if($deductionlist->pay_type == 1 ){

                                                echo "WEEKLY";
                                              }
                                              elseif($deductionlist->pay_type == 2){

                                                 echo "BI-WEEKLY"; 
                                              }
                                              elseif($deductionlist->pay_type == 3){
                                                 echo "SEMI-MONTHLY";
                                              }else{
                                                echo "MONTHLY";
                                              }
        
                                               ?>"><i class="fa fa-upload text-info pull-right"></i></a>

                    <?php  } else{ ?>
                   
                          <a><i class="fa fa-times fa-lg text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="cannot Delete Set Automatic <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>: enable first" disabled></i></a>

                            <a><i class="fa fa-pencil-square-o fa-lg text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="cannot Edit Set Automatic  <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>: enable first" disabled></i></a>
                            
                            <a href="<?php echo base_url()?>app/payroll_other_deduction_automatic/activate_deduction_auto/<?php echo $deductionlist->id;?>"><i <?php echo $this->session->userdata('check_leave_type_toenable_icon'); ?> class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Enable  <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>'" onclick="return confirm('Are you sure you want to enable  <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?> Other Deduction Type?')"></i></a>
                            
                            <i class="fa fa-list text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="cannot Enroll Employee  <?php $od_id = $deductionlist->other_deduction_id;
                              $od_type = $this->payroll_other_deduction_automatic_model->getting_deduction($od_id);
                              echo $od_type->other_deduction_type; ?>: enable first" disabled></i>

                              <a type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Manual Upload Automatic Deduction"><i class="fa fa-upload text-muted pull-right "></i></a>
                       
                      
                       
                    <?php 

                    }?>
                    
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
            </table>



      </div>
      </div>

  
     </div> 
         </div><!-- /.box-body --> 

   </div>

   </div>



      <div class="overlay" hidden="hidden" id="loading">
        <i class="fa fa-spinner fa-spin"></i>
      </div>
      <!-- ./ end loading -->


    <!-- REQUIRED JS SCRIPTS -->

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

 

     <script>  
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();

      });
    
    </script>