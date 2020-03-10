 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b><?php echo $job_details->company_name;?></center></b></h4>
        <h5><center><?php echo $job_details->job_title;?></center> </h5>
      </div>

     
      <div class="modal-body">
          <div class="col-md-12">
          <table class="col-md-12 table table-bordered" id="tt_app">
              <thead>
                <tr class="danger"> 
                  <th>No</th>
                  <th>Applicant Name</th>
                  <th>Date Applied</th>
                </tr>
              </thead>
              <tbody>
              <?php $i=1; foreach ($applicants as $app) {
               ?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $app->fullname;?></td>
                  <td><?php echo $app->date_applied;?></td>
                  
              <?php $i++; } ?>
              </tbody>
          </table>

          </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
  
  </div>
  

  <script type="text/javascript">
   
      $(function () {
        $('#tt_app').DataTable({
           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] ,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
  </script>
