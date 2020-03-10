
<?php 
    
    $company_id = $this->uri->segment("4");
   
?>
    <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id;?>">

  


   <div class="col-md-6">
      <label>Pay Type</label>
      <select class="form-control"  name="pay_type_id" id="pay_type_id" onchange="viewOption(this.value);" required>
        <option selected disabled>Select Pay Type</option>
        <?php foreach ($paytypeList_addition as $pay_type) {
         echo "<option value='".$pay_type->pay_type_id."'>".$pay_type->pay_type_name."</option>";
        }?>
      </select>
      <n class="text-danger">*required</n><br>
        <div style="margin-left:25px;display: none;" id="pay_type_option_main">
           <label style="margin-left:-25px;">Pay Type Option</label><br>
          <div id="c1" style="display: none;float: center;"><input type="checkbox" class="option" name="c" value="1" id="c_1" onclick="cutoff()"> 1st Cutoff&nbsp;&nbsp;</div>
          <div id="c2" style="display: none;float: center;"><input type="checkbox"  class="option" name="c" value="2" id="c_2" onclick="cutoff()"> 2nd Cutoff&nbsp;&nbsp;</div>
          <div id="c3" style="display: none;float: center;"> <input type="checkbox" class="option"  name="c" value="3" id="c_3" onclick="cutoff()"> 3rd Cutoff&nbsp;&nbsp;</div>
          <div id="c4" style="display: none;float: center;"> <input type="checkbox"  class="option" name="c" value="4" id="c_4" onclick="cutoff()"> 4th Cutoff&nbsp;&nbsp;</div>
          <div id="c5" style="display: none;float: center;"><input type="checkbox"  class="option" name="c" value="5" id="c_5" onclick="cutoff()"> 5th Cutoff&nbsp;&nbsp;</div>
          <div id="payday" style="display: none;float: center;"> <input type="checkbox" class="option" name="c" value="6" id="pay_day" onclick="checkbox_checker(this.value);">Per Payday&nbsp;&nbsp;</div><br>
          
        </div>



 <div class="col-md-6">
    <div class="form-group">
  
    <label for="company">Effective year</label>
    <input type="text" name="year" id="year" class="form-control" placeholder="<?php echo date('Y', strtotime(date("Y-m-d"))); ?>" value="" disabled>
  
    </div>
    </div>

  
    <div>
    <button type="submit"  onclick="sss_cutoff_edit_save();" class="btn btn-warning btn-xs pull-right"><i class="fa fa-check"></i> SAVE CHANGES</button>
    </div>

   








<!--<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/sss_cutoff_edit_save/<?php echo $this->uri->segment("4");?>" >
 -->
<!-- <div class="form-group">
        <label class="col-sm-4 control-label">PAY TYPE</label>
            <div class="col-sm-8">  
                <select  class="form-control" name="pay_type_id"  id="pay_type_id" onchange="viewOption_sss(this.value);" required >
                  <option selected="selected" value=""  required>~Select Pay Type~</option>
                      <?php
                       foreach($paytypeList_addition as $pay_type){

                       echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
                         }
                       ?>
                </select> 
             </div>
   </div>   -->


<!-- <div id="pay_type_option_main"> 

</div>
 -->


<!-- <div class="col-md-6">
    <div class="form-group">

  <label for="company">Deduction (cut-off)</label>
    <select class="form-control" name="cutoff" id="cutoff" required>
        <option selected="selected" value="" disabled>~select a cut-off~</option>
        <?php
          foreach($sss_cutoff as $cutoff){
            if($_POST['cutoff'] == $cutoff->param_id){
              $selected = "selected='selected'";
            }else{
              $selected = "";
            }
          ?>
          <option value="<?php echo $cutoff->param_id;?>" <?php echo $selected;?>><?php echo $cutoff->cValue;?></option>
        <?php }?>
    </select>