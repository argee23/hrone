
<br><br>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Section Management  </h2>
   

    <?php if ($has_division) { 
         $i=1; foreach ($info as $division) { ?>

         <div class="panel panel-success">
            <div class="panel-heading">
              <span class="pull-right">Division Level</span>
              <a data-toggle='collapse' data-target='#dept<?php echo $i;?>'> <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i> <?php echo $division->division_name; ?> </h4></a>
            </div>
            <div class="panel-body">
            <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
            <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
            <script type="text/javascript">
             
              $(function () {
                $('#table<?php echo $i?>').DataTable({
                  "pageLength": 5,
                  "pagingType" : "simple",
                  "paging": true,
                   lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
                  "lengthChange": true,
                  "searching": true,
                  "ordering": true,
                  "info": true,
                  "autoWidth": true
                });
              });
            </script>
            <div class="col-md-12" id="dept<?php echo $i?>" class="collapse">
              <table class="table table-bordered" id="table<?php echo $i?>">
                  <thead>
                      <tr>   
                        <th><center>Department</center></th>
                        <th><center>Sections</center></th>
                        <th><center>View Sections</center></th>
                        <th><center>View Groups</center></th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $ii=1; foreach ($division->departments as $dept) { ?>
                      <tr style="text-align: center;">
                          <td>
                                  <?php echo $dept->dept_name; ?> Department
                          </td>
                          <td> 
                                  <?php $s=1; foreach ($dept->sections as $section) 
                                        { if($section->wSubsection == 1) { $sss = 'subsec'; } else{ $sss='nosubsec'; }?> 
                                           <a data-toggle='collapse' data-target='#<?php echo $sss.$s.$ii;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view the subsection list'><?php echo $section->section_name."<br>"; ?>  </a>
                                  <?php  }  ?>
                          </td>
                          <td>
                                 <a target="_blank" href="<?php echo base_url().'employee_portal/my_staff_manage_schedules/sections_personnel/' . $has_division . '/' . $division->division . '/' . $dept->department.'/'.$company_id; ?>" target="_blank" class="btn btn-primary btn-flat btn-sm"><span class="badge"><?php echo count($dept->sections); ?></span>  Sections</a>
                          </td>
                          <td> 
                                  <a href="<?php echo base_url().'employee_portal/section_mngr_management/groups/' . $has_division . '/' . $division->division . '/' . $dept->department; ?>" target="_blank" class="btn btn-primary btn-flat btn-sm"><span class="badge"><?php echo count($dept->groups); ?></span> Groups</a>
                          </td>
                      </tr>
                    <?php $ii++; } ?>
                  </tbody>
              </table>
              </div>
            </div>
        </div>
    <?php $i++; } } else {?>
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i> Department List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
              <table class="table table-bordered" id="tablenodiv">
                  <thead>
                      <tr>   
                        <th><center>Department</center></th>
                        <th><center>Sections</center></th>
                        <th><center>View Sections</center></th>
                        <th><center>View Groups</center></th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $ii=1; foreach ($info as $dept) { ?>
                      <tr style="text-align: center;">
                          <td>
                                <?php echo $dept->dept_name; ?> Department
                          </td>
                          <td> 
                              <?php $s=1; foreach ($dept->sections as $section) 
                                      { if($section->wSubsection == 1) { $sss = 'subsec'; } else{ $sss='nosubsec'; }?> 
                                         <a data-toggle='collapse' data-target='#<?php echo $sss.$s.$ii;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view the subsection list'><?php echo $section->section_name."<br>"; ?>  </a>
                              <?php  }  ?>
                          </td>
                          <td>
                              <a target="_blank" href="<?php echo base_url().'employee_portal/my_staff_manage_schedules/sections_personnel/' . 0 . '/' . 0 . '/' . $dept->department.'/'.$company_id; ?>" class="btn btn-primary btn-flat btn-sm"><span class="badge"><?php echo count($dept->sections); ?></span> Sections</a>
                              </td>
                          <td> 
                              <a href="<?php echo base_url().'employee_portal/section_mngr_management/groups/' . 0 . '/' . 0 . '/' . $dept->department; ?>" class="btn btn-primary btn-flat btn-sm"><span class="badge"><?php echo count($dept->groups); ?></span>  Groups</a>
                          </td>
                      </tr>
                    <?php $ii++; } ?>
                  </tbody>
              </table>
              </div>
            </div>
          </div>
    <?php } ?>


 
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  
              $(function () {
                $('#tablenodiv').DataTable({
                  "pageLength": 5,
                  "pagingType" : "simple",
                  "paging": true,
                   lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
                  "lengthChange": true,
                  "searching": true,
                  "ordering": true,
                  "info": true,
                  "autoWidth": true
                });
              });
</script>

</div>
</div>  
