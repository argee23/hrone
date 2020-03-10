

<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Approver

          
                  <!-- Trigger the modal with a button -->

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

   
<form role="form"  id="save_pms" method="post">
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
<div class="panel panel-danger">
  <div class="panel-body">
	<div class="col-md-12">
		<br>
		<br>
<form  role="form">

  
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="form-group">
   
      <select class="form-control" id="select" name="id" onchange="get_selected_approvers(this.value)" >
        <?php if ($row->creators_type != ''){?>
        <option selected="" value="<?php echo $row->id; ?>"> <?php echo $row->creators_type; ?>  </option>
      <?php }else{ ?>
        <option selected=""> Select Approver </option>
      <?php  } ?>
        <?php foreach($get_form_def as $e){?> 
        <?php if($row->id != $e->id){ ?>
        <option value="<?php echo $e->id ?>">                                 
          <?php  echo $e->creators_type ?>

      </option>

          <?php } ?>
        <?php  } ?>


   </select>


    </div>
</div>
<div class="col-md-2"></div>

  </form>   
<br>
<br>

<hr style="border:2px solid #dd4b39;">
	
<div class="col-md-12" id="show">
  <center><div class="loader"></div></center>

 </div>
      </div>
  </div>
      </div>


<script type="text/javascript">

  get_selected_approvers('<?php echo $get_selected_approv->creators_type ?>');

</script>






