<?php $topic_location=$this->uri->segment('4');?>

<br> <ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>General Form | Update</h4>
  </ol><br>



<div class="col-md-12 text-center">
<?php $form_location   = base_url()."app/pms/update_general_form";?>
<form role="form" class="form-horizontal" id="update_general_form" method="post" action="<?php echo $form_location?>">
<div class="row">
  <?php foreach($res as $row){?>

  <div class="col-md-3">
    <label>Form Title</label>

    <input type="text" class="form-control" required name="update_form_title" value="<?php echo $row->form_title?>">
  </div>
   <div class="col-md-3">
    <label>Form Desc</label>

    <input type="text" class="form-control" required name="update_form_description" value="<?php echo $row->form_description?>">
  </div> 
 
  <div class="col-md-3">
    <label>Weight</label>

       <div class="input-group">
  <input required="" name="update_weight" type="number" class="form-control" id="recipient-name" value="<?php echo $row->weight  ?>">
            <span class="input-group-addon">%</span>
    </div><!-- /input-group -->
  </div>
 
  <div class="col-md-3">
    <label>Grading type</label>
    <?php $r = $row->grading_type; if($r < 2){?>
                  <div class="input-group">
      <span class="input-group-addon">
        <input  type="radio" value="1" aria-label="..." checked name="update_grading_type">
      </span>
      <input type="text" class="form-control" aria-label="..." disabled="" value="numbers">
    </div><!-- /input-group -->
              <div class="input-group">
      <span class="input-group-addon">
        <input name="update_grading_type" type="radio" aria-label="..." value="2" >
      </span>
      <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
    </div><!-- /input-group -->


      <?php  }else{?>
       <div class="input-group">
      <span class="input-group-addon">
        <input  type="radio" value="1" aria-label="..." name="update_grading_type">
      </span>
      <input type="text" class="form-control" aria-label="..." checked disabled="" value="numbers or letters">
    </div><!-- /input-group -->
              <div class="input-group">
      <span class="input-group-addon">
        <input checked name="update_grading_type" type="radio" aria-label="..." value="2" >
      </span>
      <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
    </div><!-- /input-group -->


      <?php } ?>
  </div>

</div>
  </br>  <input type="hidden" name="hidden" value="<?php echo $topic_location?>">
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <label>Form instruction</label>
    <textarea id="txtArea" rows="10" cols="70" class="form-control"required name="update_form_instruction" ><?php echo $row->form_instruction ?></textarea>
  </div>
  <div class="col-md-2"></div>
</div>
<div class="row text-center">
  <div class="col-md-6 col-md-offset-6 text-center  "></div>

  
   <input type="submit" class=" btn btn-primary" value="Update" onclick="save_update_general_form();" >
</div>
<?php } ?>
</form>
</div>
