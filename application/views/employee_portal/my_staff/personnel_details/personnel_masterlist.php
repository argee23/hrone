

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script> 
    <div class="content-wrapper2">
      <section class="content-header">
        <h1>
          <br>
          My Staff
           <small>Personnel Mastelist</small>
        </h1>
       <ol class="breadcrumb">
          <br>
          <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="">My Staff</a></li>
          <li class="active">Personnel Mastelist</li>
        </ol>
      </section>
    
  <div class="col-md-12" style="padding-bottom: 50px;padding-top: 10px;" id="action"> 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>PERSONNEL MASTELIST [201, attendances and schedule viewing]</b></n></a></li>
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
              
              <div class="col-md-12">
                <table class="table table-hover" id="masterlist">
                    <thead>
                          <tr class="danger">
                              <th>Employee ID</th>
                              <th>Full Name</th>
                              <th>Department</th>
                              <th>Section</th>
                              <th>Location</th>
                              <th>Classification</th>
                              <th>Employment</th>
                              <th>Action</th>
                          </tr>
                    </thead>
                    <tbody>
                      <?php foreach($masterlist as $m){
                        
                      ?>
                          <tr>
                             <td><?php echo $m->employee_id;?></td>
                             <td><?php echo $m->first_name.' '.$m->middle_name.' '.$m->last_name;?></td>
                             <td><?php echo $m->dept_name;?></td>
                             <td><?php echo $m->section_name;?></td>
                             <td><?php echo $m->location_name;?></td>
                             <td><?php echo $m->classification;?></td>
                             <td><?php echo $m->employment_name;?></td>
                             <td>
                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employee 201 Information'    href="<?php echo base_url();?>employee_portal/my_staff_201_details/personnel_details/<?php echo $m->employee_id; ?>/<?php echo $m->company_id;?>/<?php echo $m->location;?>" target="_blank"><i class="fa fa-user text-info" style="font-size:18px"></i></a>&nbsp;|&nbsp;
                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Plotted Schedule'   href="<?php echo base_url();?>employee_portal/my_staff_201_details/schedule_details/<?php echo $m->employee_id; ?>/<?php echo $m->company_id;?>/<?php echo $m->location;?>" target="_blank"><i class="fa fa-calendar text-danger" style="font-size:18px"></i></a>&nbsp;|&nbsp;
                               <a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Attendances'  href="<?php echo base_url();?>employee_portal/my_staff_201_details/attendance_details/<?php echo $m->employee_id; ?>/<?php echo $m->location;?>/<?php echo $m->company_id;?>" target="_blank"><i class="fa fa-clock-o text-success" style="font-size:18px"></i></a>
                             </td>
                          </tr>
                      <?php }  ?>
                    </tbody>
                </table>
              </div>   
            <div class="col-md-12" id="main_action" style="margin-top: 30px;"></div>
      </div>
      <div class="panel panel-info"><div class="btn-group-vertical btn-block"> </div></div>             
    </div> 
  </div> 
 
 <script type="text/javascript">
    $(function () {
        $('#masterlist').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
           lengthMenu: [[-1,20, 50, 100], ["All",20, 50, 100]],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
 </script>