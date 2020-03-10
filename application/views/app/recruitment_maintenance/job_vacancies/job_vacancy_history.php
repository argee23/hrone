 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" > <i class="fa fa-times-circle pull-right text-danger fa-lg" style="cursor: pointer;" onclick="window.location.reload()"></i>
        <h4 style="font-weight: serif;"><center>Job Title : <?php echo $job_title;?></center>
       </h4>
      </div>

      <div class="modal-body">
       
        <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Job Vacancy History</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-12">
              <table class="table table-hover" id="history">
                  <thead>
                      <tr class="danger">
                        <th>Id</th>
                        <th>Action</th>
                        <th>Original Vacancy</th>
                        <th>Updated Vacancy</th>
                        <th>Added By</th>
                        <th>Date Added</th>
                        <th></th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach($history as $h){?>
                      <tr>
                        <td><?php echo $h->id;?></td>
                        <td><?php echo $h->action;?></td>
                        <td><?php echo $h->vacancy;?></td>
                        <td><?php echo $h->final_job_vacancy;?></td>
                        <td><?php echo $h->added_by;?></td>
                        <td><?php echo $h->date;?></td>
                        <td><?php echo $h->doc_no;?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
              </table>
          </span>
        </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger"  onclick="window.location.reload()">Close</button>
        </div>
      </div>
</div>
  
<script type="text/javascript">
   $(function () {
        $('#history').DataTable({
          "pageLength": -1,
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