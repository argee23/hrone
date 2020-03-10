 <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">
<br><br>

<div ng-app="app" ng-controller="appCtrl">
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">My PMS Forms</h2>
<div class="container">
    <!-- Success Feedback -->
        <?php if ($this->session->flashdata('feedback')) { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('feedback'); ?>
            </div>
        <?php } ?>

        <!-- Failed Feedback -->
        <?php if ($this->session->flashdata('error')) { ?>
         <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>


  <div class="panel panel-body table-responsive">
  
    <div class="box box-danger">
        <?php if($my_forms){?>
      <div class="box-header with-border">
        <h3 class="box-title"> PMS FORMS</h3>
      </div>
      <div class="box-body">
        <table class="table table-responsive">
          
          <thead>
            <tr>
              <th>Document No.</th>
              <th>File Date</th>
              <th>Appraisal Period</th>
              <th>Status</th>
              <th>Form Details</th>
            </tr>
          </thead>
          <tbody>
            
              <?php foreach($my_forms as $mf):?>
              <tr>
                <td><?=$mf->doc_no?></td>
                <td><?=date("F d, Y", strtotime($mf->date_added));?></td>
                <td><?=date("F d, Y", strtotime(32453245235));?> to <?=date("F d, Y", strtotime(325345));?></td>
                <td>
                  <?php if($mf->status == 'pending'){?>
                    <span class="label label-warning">Pending</span>
                  <?php }else if($mf->status == 'completed'){?>
                    <span class="label label-success">Approved</span>
                  <?php }else if($mf->status == 'cancelled'){?>
                    <span class="label label-info">Cancelled</span>
                  <?php }else{?>
                    <span class="label label-danger">Rejected</span>
                  <?php }?>
                </td>
                <td>
                  <?php if($mf->status != 'completed'){?>
                  <span class="badge bg-red">Waiting for Approval</span>
                  <?php } else {?>
                  <a href="<?php echo base_url();?>employee_portal/pms/view_pms_form/<?=$mf->employee_id?>/<?=$mf->doc_no?>/" target="_blank"><span class="badge bg-blue">View Details</span></a>
                  <?php } ?>
                </td>
              </tr>
              <?php endforeach?>

          </tbody>
        </table>
      </div>
      <?php } else {?>
         <br><center><h3><strong>NO PMS FORMS CREATED</strong></h3></center><br>
      <?php }?>
    </div>

  </div>
</div>
</div>
</div>


</div>

