
<div class="col-md-8" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
        //$key_location="1";
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_other_deduction_excel_upload_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(PAYROLL OTHER DEDUCTION MANUAL EXCEL MASS UPLOAD)
            <a onclick="back_option('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Back"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
      </strong>
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">


<form target="_blank" action="<?php echo base_url(); ?>app/other_deduction_manual_upload/mass_upload" method="post" name="upload_excel" enctype="multipart/form-data">

      
              

      
              <div class="col-md-12" >
                    <div class="form-group">
              
                       <div class="form-group"> 

                       <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id?>">
                            <label for="next" class="col-sm-5 control-label">Pay Type</label>
                        <div class="col-md-7">
                            <select name="pay_type" class="form-control" id="pay_type"  required onchange="fetch_excel_pay_period_group_mass();"> <!-- fetch_payroll_period(); -->
                                <option disabled selected="">Select Pay Type</option>
                                <?php
                                 foreach($paytypeList_addition as $pay_type){

                            echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
                                }
                                ?>

                            </select>
                          
                          </div>
                        </div>
                       <div><br></br></div>
                    <div id="by_group"></div>

                    <div><br></br></div>
                    <div id="by_payroll_period">
                    </div>

                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

           

      <!-- ===================================================================================== -->
      </div>
      </section>
             
<!-- Loading (remove the following to stop the loading) -->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
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
        $('#inactive-employee').on('show.bs.modal', function(e) {
            
            var $modal = $(this),
                employee_id = e.relatedTarget.id;
                    //$modal.find('.edit-content').html(employee_id);
                     $(".modal-body #employeeID").val( employee_id );
        })

    </script>

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
    
 
                   
                    </div>

      
              </div> 
        

          </div>
          </div><!-- /.box-body --> 
  </div>
  </div>
</div>
</div>

</div>
</div>

</div>


<div class="col-md-4"  id="col_3">
    
  </div>


