<title><?php echo $this->session->userdata('sys_name');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
<!-- //=======================export to excel -->
<script type="text/javascript" src="<?php echo base_url()?>/public/jquery-1.9.0.js"></script>
      <table class="table table-bordered" id="table_grp_admin">
          <thead>
           <tr  class="success">
              <th style="width:5%;"></th>
              <th style="width:25%;">Company Name</th>
              <th style="width:30%;">Group Name</th>
              <th style="width:25%;">Group Description</th>
              <th style="width:15%;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($groups as $grp){
            $count = $this->plot_schedules_model->employee_enrolled($grp->id);?>
            <tr>
              <td><span class="badge"><?php echo $count?></span></td>
              <td><?php echo $grp->company_name?></td>
              <td><?php echo $grp->group_name?></td>
              <td><?php echo $grp->group_desc?></td>
               <td>
               <a onclick="edit_grp_admin('edit_admin_action_filter','<?php echo $grp->id?>')"><i  class="fa fa-pencil fa-lg text-warning pull-left"></i></a>
                <a onclick="edd_group('delete','<?php echo $grp->id?>')" ><i  class="fa fa-times fa-lg text-info pull-left"></i></a>
                <?php if($grp->stat==0){?>
                <a onclick="edd_group('disabled','<?php echo $grp->id?>')" ><i  class="fa fa-power-off fa-lg text-success pull-left"></i></a>
                <?php } else{ ?>
                <a onclick="edd_group('enabled','<?php echo $grp->id?>')" ><i  class="fa fa-power-off fa-lg text-danger pull-left"></i></a>
                <?php } ?>
                  <a onclick="enrol_employees('<?php echo $grp->id?>','<?php echo $grp->company_id?>')"><i  class="fa fa-user fa-lg text-danger pull-left"></i></a>
                  <a href="<?php echo base_url()?>app/plot_schedules/admin_group_plot_sched/<?php echo $grp->id;?>/<?php echo $grp->company_id;?>" target="_blank"><i  class="fa fa-calendar fa-lg text-warning pull-left"></i></a>
              </td>
            </tr>
          <?php } ?>
          </tbody>
      </table>    