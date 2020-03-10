<?php $topic_location=$this->uri->segment('4');?>
<?php $company =$this->uri->segment('5');?>
<?php $fid =$this->uri->segment('6');?>

<br> <ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Time Summary Reports | <?php echo $topic_location;?></h4>
</ol><br>



<div class="col-md-12 text-center">
<?php $form_location   = base_url()."app/pms/update_grading_table";?>
<form role="form" class="form-horizontal" id="grading_table" method="post" action="<?php echo $form_location?>">
<div class="row">
<?php foreach($res as $row){?>

<div class="col-md-3">
  <label>Grading Type</label>

        
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
    <input type="text" class="form-control" aria-label="..."  disabled="" value="numbers or letters">
  </div><!-- /input-group -->
            <div class="input-group">
    <span class="input-group-addon">
      <input checked name="update_grading_type" type="radio"  checked aria-label="..." value="2" >
    </span>
    <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
  </div><!-- /input-group -->


    <?php } ?>

</div>
 <div class="col-md-3">
  <label>Ranking</label>
  <input type="number" class="form-control" required name="update_ranking" value="<?php echo $row->ranking?>">
</div>


 <div class="col-md-3">

  <label>score</label>
      <div class="input-group">
<input required="" name="update_score" type="number" class="form-control" id="recipient-name" value="<?php echo $row->score  ?>">
          <span class="input-group-addon">%</span>
  </div><!-- /input-group -->
</div>


<div class="col-md-2">
  <label>Score equivalent</label>
  <input type="text" class="form-control" required name="update_score_equivalent" value="<?php echo $row->score_equivalent?>">
</div>

<div class="col-md-2"></div>
</div>
</br>  <input type="hidden" name="hidden" value="<?php echo $topic_location?>">
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
  <label>Score guide</label>
  <textarea id="txtArea" rows="10" cols="70" class="form-control"required name="update_scoring_guide" ><?php echo $row->scoring_guide ?></textarea>
</div>
<div class="col-md-2"></div>
</div>
<div class="row text-center">
<div class="col-md-6 col-md-offset-6 text-center  "></div>

 <input type="submit" class=" btn btn-primary" value="Update" onclick="save_update_grading_table(<?php echo $fid;?>,<?php echo $company ?><?php echo $topic_location;?>,);" >
<!-- <button type="submit" class="btn btn-primary"><i class="fa fa-user-plus"></i>Update</button> -->
</div>
<?php } ?>
</form>
</div>
