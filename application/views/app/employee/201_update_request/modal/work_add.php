 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New  Working Experience</center></h4>
      </div>
     
       
      <div class="modal-body">
      

        <?php foreach ($work_add as $add) {  ?>


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $add->company_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>Company Address:  </dt>
              <dd> <?php echo $add->company_address ?></dd>

              <dt>Company Contact:  </dt>
              <dd> <?php echo $add->company_contact ?></dd>

              <dt>Reason of Leaving:  </dt>
              <dd>  <?php  echo $add->reason_for_leaving?></dd>

              <dt>Job Description:  </dt>
              <dd> <?php echo $add->job_description ?></dd>

              <dt>Work Duration:  </dt>
              <dd><?php if($add->isPresentWork==0){ echo $add->date_start." to ".$add->date_end; } else{ echo $add->date_start." to Present"; } ?></dd>

              <dt>Salary:  </dt>
              <dd><?php echo number_format($add->salary,2); ?></dd>

          
             </span>
             </div>
        </div>

       
      <?php } ?>

      

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
