
 <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">
<br><br>

<div class="col-md-12">
<div class="col-md-12 content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Notification Approval</h2>
<div class="col-md-12 container">

  <div class="panel panel-body table-responsive">
        <div class="box box-primary">
         <?php
          if (count($approvals) == 0)
          {
            echo "<center><h3></h3></center>";
          } else  {  
              $i=1; foreach ($approvals as $approval){
               if (count($approval->forms) != 0) { 
           
          ?>
            <div class="box-header with-border">
                  <h3 class="box-title text-danger"><u><?php echo $approval->form_name;?></u></h3>
                      <div class="pull-right box-tools">
                        <a href="<?php echo base_url();?>employee_portal/notification_approver/mass_approval/<?php echo $approval->t_table_name;?>" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                      Mass Approval</a>
                      </div>
            </div>
            <div class="box-body">
         		<script type="text/javascript">
			      $(function () {
			        $('#new_hired<?php echo $i;?>').DataTable({
			          "pageLength":10,
			          "pagingType" : "simple",
			          "paging": true,
			          lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
			          "searching": true,
			          "ordering": true,
			          "info": true,
			          "autoWidth": true
			        });
			      });
			      </script>

              <table class="table table-responsive" id="new_hired<?php echo $i;?>">
                <thead>
                    <tr class="danger">
                      <th>Document No.</th>
                      <th>Employee</th>
                      <th>File Date</th>
                      <th><center>Details</center></th>
                    </tr>
                </thead>
                <tbody>   
                 <?php foreach ($approval->forms as $form)
                  { ?>
                    <tr  class="my_hover">
                      <td><a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/notification_approver/approve_notification')."/".$form->doc_no."/".$this->session->userdata('company_id')."/".$form->form_info->employee_id;?>"><?php echo $form->doc_no; ?></a></td>
                      <td><?php echo $form->form_info->employee_id;?></td>
                      <td><?php echo date("F d, Y", strtotime($form->form_info->date_created)); ?></td>
                      <td>
                        <center><a  href="<?php echo base_url();?>app/issue_notifications/view_notif_form/<?php echo $form->doc_no."/".$this->session->userdata('company_id')."/".$form->form_info->employee_id; ?>" target="_blank"><span class="badge bg-green">View Details</span></a></center>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
          </div>

      <?php $i++; }else{ echo "<h3 class='text-danger' style='margin-top:50px;'><center></center></h3>"; } }} ?>
          </div>
  </div>
</div>
</div>
</div>
</div>

 <div class="modal fade" id="modall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content modal-lg">
       </div>
    </div>
</div>
<style type="text/css">
  .modal {
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 120%;

}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: left;

}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
 /*   width:inherit;
    height:inherit;*/
    /* To center horizontally */
    margin: 0 auto;
    margin-left:-60px;
}
</style>
<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
      <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
      $(function () {
        $('#new_hired').DataTable({
          "pageLength":10,
          "pagingType" : "simple",
          "paging": true,
          lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });


    function set_status(val)
    {
      document.getElementById("approver_status").value =val; 
       

      if(val=='cancelled' || val=='rejected')
      { 
        var comment = document.getElementById('comment').value;
        if(comment==''){
          document.getElementById("submit").disabled = true;
        }
        else
        {

          document.getElementById("submit").disabled = false;
        }
        
        $("#status_comment").show();
      } 
      else
      {
        document.getElementById("submit").disabled = false;
        $("#status_comment").hide();
      }
    
    }

    function check_comment(val)
    {
      var stat =  document.getElementById("approver_status").value;
      var comment = document.getElementById("comment").value;

      if(stat=='cancelled' || stat=='rejected')
      { 
       
        if(comment==''){
          document.getElementById("submit").disabled = true;
        }
        else
        {

          document.getElementById("submit").disabled = false;
        }
        
      } 
      else if(stat=='approved')
      {
        document.getElementById("submit").disabled = false;
      }

    }
   
</script>