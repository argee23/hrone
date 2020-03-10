 <div class="modal-content">
       <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>COLOR CODE DESCRIPTION</center></h4>
      </div>
     
      <div class="modal-body">
 
            <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i>Color Code description</i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-12">
            <div class="col-sm-12">
                <table class="col-sm-12 table table-bordered">
                  <thead>
                    <tr class="danger">
                      <td style="width: 40%;">Legend</td>
                      <td style="width: 60%;">Description</td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($color_code as $cc){?>
                     <tr>
                        <td><input type="color" class="form-control"  value="<?php echo $cc->color_code;?>"></td>
                        <td><?php echo $cc->title;?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
            </div>
          </span>
        </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>


<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

   $(function () {
        $('#Schedules').DataTable({
          "pageLength": 6,
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