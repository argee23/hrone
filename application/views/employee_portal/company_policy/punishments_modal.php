 <div class="modal-content">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Disobedience with Equivalent Punishment</center></h4>
      </div>
   
       <div class="panel panel-default">
        <div class="panel-heading">
       
        <div class="panel-body">
          <div class="dl-horizontal col-sm-12">
                <table class="table table-hover" id="disobedience">
                  <thead>
                    <tr class="danger">
                      <th><center>ID</center></th>
                      <th><center>Disobedience</center></th>
                      <th><center>No of days</center></th>
                      <th><center>NO. OF DISOBEDIENCE SUSPENSION/PUNISHMENT</center></th>
                   </tr>
                  </thead>
                  <tbody>   
                  <?php foreach($details as $d){?>
                    <tr>
                      <td><center><?php echo $d->pun_id;?></center></td>
                      <td><center><?php echo $d->disob;?></center></td>
                      <td><center><?php echo $d->num_days;?></center></td>
                      <td><center><?php echo $d->punish;?></center></td>
                    </tr>   
                  <?php } ?>
                  </tbody>
               </table>

          </div>
        </div>
        </div>    

      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
      </div>
      </div>

    </div>


<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>