
<br><br>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Section Management  </h2>
   

    
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i> Company List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
              <table class="table table-bordered" id="tablenodiv">
                  <thead>
                      <tr>   
                        <th><center>Company ID</center></th>
                        <th><center>Company Name</center></th>
                        <th><center>Department</center></th>
                        <th><center>Action</center></th>
                      </tr>
                  </thead>
                  <tbody>
                    
                    <?php foreach($company as $c){?>

                      <tr style="text-align: center;">
                          <td><?php echo $c->company_id;?></td>
                          <td><?php echo $c->company_name;?></td>
                          <td>
                              <?php
                                $dept_list = $this->my_staff_manage_schedules_model->get_section_departments($c->company_id);
                                foreach($dept_list as $d)
                                {
                                  echo $d->dept_name.'<br>';
                                }
                              ?>
                          </td>
                          <td> <a target='_blank' class="btn btn-primary btn-flat btn-sm" href="<?php echo base_url().'employee_portal/my_staff_manage_schedules/company_id/' . $c->company_id; ?>">MANAGE SCHEDULE</a></td>
                      </tr>
                    <?php } ?>
                  </tbody>
              </table>
              </div>
            </div>
          </div>
  