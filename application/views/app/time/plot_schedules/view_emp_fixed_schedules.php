 <div class="modal-content">
       <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Employee Fixed Schedules</center></h4>
      </div>
     
      <div class="modal-body">
 
            <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i> <?php echo $emp_info->fullname."(".$emp_info->employee_id.")";?></i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">
         <?php foreach($check_if_fixed_schedule as $cc){?> 
            <dt>Monday</dt>
            <dd><?php echo $cc->mon;?></dd>
             <dt>Tuesday</dt>
            <dd><?php echo $cc->tue;?></dd>
             <dt>Wednesday</dt>
            <dd><?php echo $cc->wed;?></dd>
             <dt>Thursday</dt>
            <dd><?php echo $cc->thu;?></dd>
             <dt>Friday</dt>
            <dd><?php echo $cc->fri;?></dd>
             <dt>Saturday</dt>
            <dd><?php echo $cc->sat;?></dd>
             <dt>Sunday</dt>
            <dd><?php echo $cc->sun;?></dd>
          <?php } ?>
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