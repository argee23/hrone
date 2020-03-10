<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Trainings and Seminars File Maintenance
<a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/employee_training_seminars_final/adding_file_maintenance');?>" class="btn btn-success pull-right btn-xs" ><i class="fa fa-plus"></i>Add</a>
</h4></ol>

            <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_training_seminars/save_individual_adding/individual_adding" >
                  <div class="col-md-12">
                        <div class="col-md-12">
                            <h4 class="text-danger"><center></center></h4>
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                  <select class="form-control" onchange="get_file_maintence_trainingseminars(this.value);">
                                        <option disabled selected value="">Select Company</option>
                                        <?php foreach($companyList as $company){?>
                                            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?> </option>
                                        <?php } ?>
                                  </select>
                              </div>
                              <div class="col-md-2"></div>
                            <br><hr><br>
                            <div class="col-md-12" id="file_maintenance_results">
                                <table class="table table-hover" id="file_maintenance">
                                    <thead>
                                      <tr class="danger">
                                        <th>ID</th>
                                        <th>Company Name</th>
                                        <th>Type</th>
                                        <th>Tiltle / Topic</th>
                                        <th>Type</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php  foreach($file_maintenance as $f){?>
                                        <tr>
                                          <td><?php echo $f->id;?></td>
                                          <td><?php echo $f->company_name;?></td>
                                          <td><?php echo $f->training_type;?></td>
                                          <td><?php echo $f->training_title;?></td>
                                          <td><?php echo $f->type;?></td>
                                          <td><?php echo $f->date_created;?></td>
                                          <td>
                                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_fincoming_trainingsseminars(<?php echo $f->id;?>);"  aria-hidden='true' data-toggle='tooltip' title='Update Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="view_fincoming_trainingsseminars(<?php echo $f->id;?>);" aria-hidden='true' data-toggle='tooltip' title='View Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="delete_fincoming_trainings(<?php echo $f->id;?>);" aria-hidden='true' data-toggle='tooltip' title='Delete Incoming Trainings and Semianr'><i class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                                          </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                  </div>
            </form>
           

    
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

     
