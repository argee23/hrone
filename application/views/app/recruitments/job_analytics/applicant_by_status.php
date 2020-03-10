 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>List of <?php if(empty($status_title)){} else{ echo "<b><u>".$status_title."</u></b>"; }?> Applicants</center></h4>
      </div>
  
      <div class="modal-body">
         <div class="panel panel-default">
        <div class="panel-body">
          <span class="dl-horizontal col-sm-12">

          <table class="table table-bordered" id="table_app<?php echo $job_id;?>">
            <thead>
                <tr class="danger">
                     <th>Name</th>
                     <th>Date Applied</th>
                     <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($applicants as $app){?>
                <tr>
                    <td><?php echo $app->fullname;?></td>
                    <td>
                      <?php 

                        $month=substr($app->date_applied, 5,2);
                        $day=substr($app->date_applied, 8,2);
                        $year=substr($app->date_applied, 0,4);
                        echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;

                      ?>
                    </td>
                    <td>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>app/recruitments/applicant_profile/<?php echo $app->employee_info_id;?>/<?php echo $app->applicant_id;?>/<?php echo $app->job_id;?>/<?php echo $app->company_id;?>/<?php echo $employer_type;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                               

                    </td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
           
          </span>
        </div>
        </div>

         
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>
      </div>

</div>

 
<script>
      $(function () {
        $('#table_app<?php echo $job_id;?>').DataTable({
          "pageLength": 10,
          "pagingType" : "simple",
          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
</script>