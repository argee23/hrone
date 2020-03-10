<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" onclick="Refresh()"><span class="glyphicon glyphicon-remove"></span></button>
        <h3 class='text-danger' style="font-weight:bold;font-family: serif;"><center>Basic Information</center></h3><hr>
</div>
<div class="modal-body" style="height:500px;overflow: auto;">
      
    
</div>



<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>

