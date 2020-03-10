 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Applicants Applied in other company</center></h4>
      </div>
  
      <div class="modal-body">
         <div class="panel panel-default">
        <div class="panel-body">
          <span class="dl-horizontal col-sm-12">

          <table class="table table-bordered" id="table_app<?php echo $job_id;?>">
            <thead>
                <tr class="danger">
                     <th>Name</th>
                     <th>Company Name</th>
                     <th>Date Applied</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($applicants as $app){?>
                <tr>
                    <td><?php echo $app->fullname;?></td>
                     <td><?php echo $app->company_name;?></td>
                    <td>
                      <?php 
                        $month=substr($app->date_applied, 5,2);
                        $day=substr($app->date_applied, 8,2);
                        $year=substr($app->date_applied, 0,4);

                        echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                      ?>
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