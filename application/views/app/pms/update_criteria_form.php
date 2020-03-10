	<?php $topic_location=$this->uri->segment('4');?>
	<?php $fid=$this->uri->segment('4');?>
	<?php $company = $this->uri->segment('6');?><br>


	<br> <ol class="breadcrumb">
	<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Form | Update</h4>
	  </ol><br>



	<div class="col-md-12 text-center">
	<?php $form_location   = base_url()."app/pms/update_criteria_form";?>
	<form role="form" class="form-horizontal" id="save_update_criteria_form" method="post" action="<?php echo $form_location?>">
	<div class="row">

	  <?php foreach($res as $row){?>

	  <div class="col-md-6">
	    <label>Area</label>

	    <input type="text" class="form-control" required name="area" value="<?php echo $row->area?>">
	  </div>

	  <div class="col-md-6">
	    <label>Covered</label>

	<!--     <input type="text" class="form-control" required name="cover" value="<?php echo $row->position?>" > -->
	        <select  name="cover" class="form-control">
                                     <option value="all" >All</option> 
                                     	<option value="<?php echo $row->position?>" selected><?php echo $row->position?></option>
                          <?php $res = $this->pms_model->position(); foreach($res as $res){?>
							
                            <option value="<?php echo $res->position_name ?>"><?php  echo $res->position_name;?></option>
                            
                          <?php } ?>
                        </select>
	  </div>

	 

	</div>

	<input type="hidden" name="id" value="<?php echo $row->criteria_id?>">
	  </br>  <input type="hidden" name="hidden" value="<?php echo $topic_location?>">
	<div class="row">
	  <?php $res = $this->pms_model->get_weight_and_description($row->criteria_id);
	            foreach($res as $row1){ ?>
	  <div class="col-md-8">

	    <label>Form instruction</label>
	       
	              <input type="hidden" name="idd[]" value="<?php echo $row1->id?>">
	             <textarea id="txtArea"  class="form-control" required name="description[]" ><?php echo $row1->description;  ?></textarea>
	             
	              
	 
	   
	  </div> 
	   <div class="col-md-2"><label>weight</label> <div class="input-group">

	            <input required="" name="weight[]" type="number" class="form-control" id="recipient-name" value="<?php echo $row1->weight  ?>">
	            <span class="input-group-addon">%</span>
	              </div>
	</div>
	    <?php }?>
	</div>
	<div class="row text-center">
	  <div class="col-md-6 col-md-offset-6 text-center  "></div>


	</div>
		<div class="row">
	  <?php if($row->level != ""){?>
	    <div class="col-md-4">
	    <label>level</label>

	    <input type="number" class="form-control"  name="level" value="<?php echo $row->level?>">
	  </div> 
	 	<?php } ?>
	 		  <?php if($row->target != ""){?>
	  <div class="col-md-4">
	    <label>target</label>

	    <textarea class="form-control"  name="target"    ><?php echo $row->target?>  </textarea>
	  </div>
	  	<?php } ?>
	  	 <?php if($row->measurement != ""){?>
	   <div class="col-md-4">
	    <label>level</label>

	    <input type="text" class="form-control"  name="measurement" value="<?php echo $row->measurement?>">
	  </div> 
	  	<?php } ?>
	</div>
	<?php } ?>

	<input type="submit" name="submit" class="btn btn-primary" onclick="save_update_criteria_form(<?php echo $fid?>,<?php echo $company ?>);" value="Update" >
	</form>

	</div>