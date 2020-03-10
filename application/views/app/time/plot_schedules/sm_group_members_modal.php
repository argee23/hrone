 <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title text-danger"><b><center><u><?php echo $group->group_name;?></u></center></b></h4>
      </div>
      <div class="modal-body">
     <input type="hidden" id="kkk" value="<?php echo $id?>">
      <div id="nn">
      <script>
        $(function () {
          var a=document.getElementById("kkk").value;
                        $('#sm_grp_members'+a).DataTable({
                          "pageLength": 5,
                          "pagingType" : "simple",
                          "paging": true,
                           lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
                          "lengthChange": true,
                          "searching": true,
                          "ordering": true,
                          "info": true,
                          "autoWidth": false
                        });
                      });

      </script>
      </div>
                 <table class="table table-bordered" id="sm_grp_members<?php echo $id?>">
                    <thead>
                     <tr  class="success">
                        <th style="width:5%;">ID</th>
                        <th style="width:20%;">Employee ID</th>
                        <th style="width:35%;">Employee Name</th> 
                        <th style="width:40%;">Department</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($g_members as $gm) {?>
                      <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo $gm->employee_id?> </td>
                        <td><?php echo $gm->first_name." ".$gm->middle_name." ".$gm->last_name?></td>
                        <td><?php echo $gm->dept_name?></td>
                      </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table> 
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

<script>

$('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
  $("#nn").load(location.href + " #nn");
});
    

</script>