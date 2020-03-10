 <style type="text/css">
   .modal-dialog{
    overflow-y: initial !important
}
.modal-body{
  height: 450px;
       max-height: calc(100vh - 210px);
    overflow-y: auto;
}
 </style>
<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Group Management

 
                  <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#mem"><i class="fa fa-plus"></i>Add New Member</button>
<!-- Trigger the modal with a button -->
</h4>

<!-- Modal -->
  <?php $form_location   = base_url()."app/pms/e/";?>
<form id="save_appraisal_member" method="post" onsubmit="submit.disabled = true; return true;" action="<?php echo $form_location;?>">
    <div id="mem" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            Department
      	    <select id="s" class="form-control" name="department">

		<option   data-id="all" value="all" selected="">all</option>
    	<?php $s = $this->pms_model->get_department($this->uri->segment('5')); foreach($s as $e){?>

    	<option value="<?php  echo $e->department_id; ?>"  data-id="<?php echo $e->department_id?>" ><?php echo $e->dept_name ?></option>
			<?php } ?>
    </select>
    </div>
        <div class="col-md-4">
            Section
            <select class="form-control" name="section" id="section">

    <option value="all" selected="">all</option>
      <?php $s = $this->pms_model->get_section(); foreach($s as $e){?>

      <option value="<?php  echo $e->section_id; ?>"></option>
      <?php } ?>
    </select>
    </div>
  <div class="col-md-4">
    classification
	    <select class="form-control" name="classification">
  <option value="all" selected="" id="all">all</option>
    	<?php $s = $this->pms_model->get_classification($this->uri->segment('5')); foreach($s as $e){?>
    	<option value="<?php  echo $e->classification_id; ?>"><?php echo $e->classification ?></option>
			<?php } ?>
    	</select>
<input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>">
    </div>
      <div class="col-md-2">
        location
      <select class="form-control" name="location">
  <option value="all" selected="">all</option>
      <?php $s = $this->pms_model->get_location(); foreach($s as $e){?>
      <option value="<?php  echo $e->location_id; ?>"><?php echo $e->location_name ?></option>
      <?php } ?>
      </select>

    </div>
       <div class="col-md-2">
  <br>
<button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
    </div>
</div>
<br>

			<input type="hidden" name="id" value="<?php echo $this->uri->segment('4'); ?>">
            <input type="hidden" name="group_id" value="<?php echo $this->uri->segment('5'); ?>">




        
         <div class="table-responsive">
    <table class="table table-bordered" >
      <thead>
        <tr class="danger"> 
		
        <th><input type="checkbox" id="checkAll" >Select</th>
        <th>Name</th>
         <th>Name</th>
      </tr>
      </thead>
      <tbody id="listing">	   
    
   
  

      
       				

          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">

        <input type="submit" name="submit" class="btn btn-primary"  onclick="save_appraisal_member('<?php echo $this->uri->segment('4'); ?>')"  id="submit"  value="submit">
      </div>
    </div>

  </div>
</div>
</div>

</form>


</h4>
</ol>

 <div class="table-responsive">
    <table class="table table-bordered" id="members" >
      <thead>
        <tr class="danger"> 

                  <th>Members Name</th>
                  <th>Classification</th>
                <th>Classification</th>
                  <th>Classification</th>
                  <th>option</th>

        
        </tr>
      </thead>
      <tbody>
      	<?php $s = $this->pms_model->get_member($this->uri->segment('4')); foreach($s as $e){?>	

       <tr><td><?php echo $e->name;?></td>      <td><?php echo $e->classification_name;?></td>
           <td><?php echo $e->location_name;?></td>
             <td><?php echo $e->department_name;?></td><td>     <div class="tooltop1"><button class=" btn btn-warning btn-sm" ><span class="glyphicon glyphicon-pencil"></span></button><span class="tooltiptext">edit</span></div>
        <div class="tooltop1"><button class="delete_member btn btn-danger btn-sm" data-id ="<?php echo $e->id ?>"><span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div></td></tr>
   <?php } ?>
          </tbody>
        </table>
      </div>

            <script type="text/javascript">


  $('#s').change(function(){

  val = $("#s option:selected").attr('data-id');

      $.ajax({ 
            url: "<?php echo site_url('app/pms/get_department_sec'); ?>",
            type: 'POST',
            dataType: "JSON",
            data: { "text1": val },
            success: function(data) {
              $('#section').empty();
                $.each(data, function(index, element){
                  $('#section').append($('<option>', {
    value: element.id,
    text: element.name
}));
    });   


            }
          });
    
  });
    


</script>