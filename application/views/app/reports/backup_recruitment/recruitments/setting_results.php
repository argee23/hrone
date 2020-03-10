<?php if($option=='req'){?>
<table class="col-md-12 table table-hover" id="req_report">
   <thead>
      <tr class="danger">
          <th>No.</th>
          <th>Company Name</th>   
          <th>Title</th>              
          <th>IsUploadable</th> 
          <th>Status</th>
      </tr>
    </thead>
    
    <tbody>
        <?php
    $i=1;
      foreach($results as $res){?>
      <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $res->company_name;?></td>
          <td><?php echo $res->title;?></td>
          <td><?php if($res->IsUploadable==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($res->InActive==0){ echo "Active"; } else{ echo "InActive"; }?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
 </table>
<?php } else if($option=='stat'){?>

  <table class="col-md-12 table table-hover" id="req_report">
   <thead>
      <tr class="danger">
          <th>No.</th>
          <th> Company Name</th>   
          <th>Status Title</th>              
          <th>Description</th> 
          <th>Color Code</th>
          <th>IsDefault</th>
          <th>Status</th>
      </tr>
    </thead>
    
    <tbody>
        <?php
    $i=1;
      foreach($results as $res){?>
      <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $res->company_name;?></td>
          <td><?php echo $res->status_title;?></td>
          <td><?php echo $res->status_description;?></td>
          <td><input type="color" class="form-control" value="<?php echo $res->color_code;?>" style="width:100%;"></td>
          <td><?php if($res->IsDefault==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($res->InActive==0){ echo "Active"; } else{ echo "InActive"; }?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
 </table>

<?php } else if($option=='q') {?>
 <table class="col-md-12 table table-hover" id="req_report">
   <thead>
      <tr class="danger">
          <th>No.</th>
          <th>Company Name</th>   
          <th>Question</th>              
          <th>Correct Answer</th> 
          <th>Status</th>
      </tr>
    </thead>
    
    <tbody>
        <?php
    $i=1;
      foreach($results as $res){?>
      <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $res->company_name;?></td>
          <td><?php echo $res->question;?></td>
          <td><?php if($res->correct_ans==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($res->InActive==0){ echo "Active"; } else{ echo "InActive"; }?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
 </table>
<?php }  else if($option=='h'){?>
   <table class="col-md-12 table table-hover" id="req_report">
   <thead>
      <tr class="danger">
          <th>No.</th>
          <th>Company Name</th>   
          <th>Question</th>         
          <th>Status</th>
      </tr>
    </thead>
    
    <tbody>
        <?php
    $i=1;
      foreach($results as $res){?>
      <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $res->company_name;?></td>
          <td><?php echo $res->question;?></td>
          <td><?php if($res->InActive==0){ echo "Active"; } else{ echo "InActive"; }?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
 </table>
<?php } else if($option=='m'){?>

<table class="col-md-12 table table-hover" id="req_report">
   <thead>
      <tr class="danger">
          <th style="width:5%;">No.</th>
          <th style="width:30%;">Company Name</th>   
          <th style="width:50%;">Question</th>   
          <th style="width:10%;">Status</th> 
      </tr>
    </thead>
    
    <tbody>
        <?php
    $i=1;
      foreach($results as $res){
        $get_options = $this->report_recruitment_model->get_multiple_options($res->id);
        ?>
      <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $res->company_name;?></td>
          <td>
              <?php echo $res->question;?>
              <div class="col-md-12">
              <?php $i=1; foreach($get_options as $go){?>
              <n><?php echo $i."). ".$go->mc_choice;?></n><br>
              <?php $i++; } ?>
              </div>
          </td>
          <td><?php if($res->InActive==0){ echo "Active"; } else{ echo "InActive"; }?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
 </table>

<?php } ?>
