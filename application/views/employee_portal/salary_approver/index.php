
 <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">
<br><br>

<div class="col-md-12">
<div class="col-md-12 content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Salary Approval</h2>
<div class="col-md-12 container">
 <?php echo $message;?>
        <?php echo validation_errors(); ?>
  <div class="panel panel-body table-responsive">
  <?php if(empty($approvals)){ echo "<h3 class='text-danger'><center>No Pending Approval/s . .</center></h3>"; }else{?>
        <div class="box box-primary">
        
            <div class="box-header with-border">
                  <h3 class="box-title text-danger"><u></u></h3>
                      <div class="pull-right box-tools">
                      <a href="<?php echo base_url();?>employee_portal/salary_approver/mass_approval/" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                      Mass Approval</a>
                  </div>
            </div>
            <div class="box-body">
         		<script type="text/javascript">
			      $(function () {
			        $('#approvers_salary').DataTable({
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

              <table class="table table-responsive" id="approvers_salary">
                <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Employee</th>
                      <th>Salary ID</th>
                      <th>Date</th>
                      <th><center>Details</center></th>
                    </tr>
                </thead>
                <tbody>   
                  <?php $i=1; foreach($approvals as $ap){?>
                    <tr>
                      <td><?php echo $i."). ";?></td>
                      <td><a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/salary_approver/approve_salary')."/".$ap->id."/".$ap->employee_id."/".$ap->salary_info_id."/".$ap->approver_id;?>"><?php echo $ap->fullname;?></a></td>
                      <td><?php echo $ap->salary_info_id;?></td>
                      <td><?php echo $ap->date_time;?></td>
                      <td>
                        <center>
                          <a  href="<?php echo base_url();?>employee_portal/salary_approver/salary_approver_view/<?php echo $ap->salary_info_id."/".$ap->employee_id; ?>" target="_blank"><span class="badge bg-green">View Details</span></a>

                         </center>

                      </td>
                    </tr>
                  <?php $i++; } ?>
                </tbody>
              </table>
          </div>
          </div>
  </div>
  <?php } ?>
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