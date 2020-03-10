 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New Skill/s</center></h4>
      </div>
     
      <div class="modal-body">
      
            <?php foreach ($skills_add as $add) {?> 
         <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                        <a class="text-danger"><b><?php echo $add->skill_name?></b></a>
                      
                </strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">
             
              <dt>Skill Description:  </dt>
              <dd> <?php  echo $add->skill_description;  ?></dd>
              
             </span>
             </div>
        </div>

       
      <?php }  ?>

        <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>



</div>

<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
