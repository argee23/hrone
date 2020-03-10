<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Add Incoming Trainings and Seminars

<n id="assign_employee_id">
   
</n>


</h4></ol>
  
            <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars_final/save_incoming_trainings" >
                
            <div class="col-md-12">

              <div class="col-md-6">
                  <div class="col-md-4"><label>Company</label></div>
                  <div class="col-md-8">
                      <select class="form-control" id="company" name="company" onchange="get_location(this.value);">
                          <option value="" disabled selected>Select</option>
                            <?php foreach($companyList as $comp){?>
                          <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                            <?php } ?>
                      </select>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="col-md-4"><label>Training Type</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="training_type" name="training_type" onchange="get_all_trainings_individual(this.value,'incoming');" required>
                        <option value="" disabled selected>Select</option>
                        <option value="training">Training</option>
                        <option value="seminar">Seminar</option>
                      </select>
                  </div>
              </div>

            </div>


            <div class="col-md-12" style="margin-top: 5px;">

              <div class="col-md-6">
                  <div class="col-md-4"><label>Sub Type</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="sub_type" name="sub_type" required onchange="get_all_trainings_individual(this.value,'incoming');">
                          <option disabled selected value="">Select Sub Type</option>
                          <option value="internal">Internal(conducted by the company)</option>
                          <option value="external">External(conducted by other agency/company)</option>
                      </select>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="col-md-4"><label>Training Title</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="title" name="title" required onchange="get_all_trainings_details_incoming(this.value);">
                          <option disabled selected>Select Training and Seminar</option>
                      </select>
                  </div>
              </div>

            


            </div>

            <div class="col-md-12"><hr class="c"></div>

            <div class="col-md-12" style="margin-top: 5px;" id="for_training_details">

            </div>

            
            </form>
           

    <style type="text/css">
      hr.c {
          border: 1px solid yellowgreen;
        }
    </style>
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

     
