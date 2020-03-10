
<?php  $company_ =  $this->uri->segment('4');  ?>
<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Create Group
          
                  <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Add New Group</button>
</h4>

<!-- Modal -->
<div id="myModal" class="modal" tabindex="-1" role="dialog"   aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-small" style="top:5%;
  right:50px;
  outline: none;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>

      </div>
      <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_pms_appraisal_group/";?>
   
<form role="form"  id="save_pms" method="post" action="<?php echo $form_location?>">
      <div class="modal-body">
                        


        
         <div class="form-group">
                <label for="message">Group Name</label>
                  <input type="text" class="form-control" name="group_name" required />
         </div>
           <div class="form-group"><input type="hidden" name="company_" value="<?php  echo $this->uri->segment('4');  ?>">
                <label for="message">Group Details</label>
                  <textarea class="form-control" name="group_details" required></textarea>
         </div>



      
   

</div>
     
      <div class="modal-footer" style="border: none;">
     
       
<input type="submit" name="submit" class="btn btn-primary"  onclick="save_group_pms()" id="submit"  value="submit">
  
   	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           
     </div>
 </form>
  </div>
</div>
               
</h4></ol>


                  </div><!-- /.btn-toolbar/M11 -->
              </div>
          

		
<div class="col-md-12">
		 <div class="table-responsive">
        <table id="appraisal_group" class="table">
          <thead>
            <tr>
       
              <th>Group Name</th>
              <th>Group Details</th>
              <th>Options</th>
  
        
            </tr>
    
              
          </thead>
          <tbody>

              <?php foreach($appraisal_group as $appraisal_group){ ?>
           <tr>

  
                
               <td><?php echo $appraisal_group->appraisal_group_name; ?></td>
              <td><?php echo $appraisal_group->appraisal_group_details;?></td>
            
                 <td>
                  <div class="tooltop1">
                  <button class=" btn btn-warning btn-sm" onclick="view_update_appraisal_group(<?php echo $appraisal_group->appraisal_group_id ?>,<?php echo $company_; ?>);"><span class="glyphicon glyphicon-pencil"></span></button><span class="tooltiptext">edit</span></div>
                                          <div class="tooltop1"><button class="group btn btn-danger btn-sm" data-id="<?php echo $appraisal_group->appraisal_group_id?>"> <span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>
               <div class="tooltop1">
                <button class=" btn btn-success btn-sm" onclick="manage_member(<?php echo $appraisal_group->appraisal_group_id ?>,<?php  echo $this->uri->segment('4');  ?>);" ><span class="glyphicon glyphicon-plus"></span></button><span class="tooltiptext">add memeber</span></div>
                  </td>
               </tr>
      <?php } ?>
          </tbody>
        </table>



     
     </div>
      </div>
      <?php  $w =  $this->pms_model->lock($this->uri->segment('4'));?> <input type="hidden" id="w" value="<?php  if(!empty($w->lock)){ echo $w->lock;} ?>"> 
      <script type="text/javascript">
                if($('#w').val() == '1'){
  $(document).find("input,button,textarea,select").attr("disabled", "disabled");
  }
        
      </script>

