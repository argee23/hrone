<div class="well">
<!-- form start -->
<form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/leave_management/modify_leave/<?php echo $this->uri->segment("4");?>" >
    <table  class="table table-bordered table-striped">
      <thead>
        <tr>
          <th colspan="3"> <i class="fa fa-pencil-square-o fa-lg text-info pull-left"  data-toggle="tooltip" data-placement="left" ></i>Edit <strong> <?php echo $leave_type->leave_type?>
          </th>
        </tr>
      </thead>  
      <tbody> 
      </tbody>
    </table>
    <div class="box-body">
          <input type="hidden" class="form-control" name="leave_id" id="leave_id" placeholder="leave id" value="<?php echo $leave_type->id?>"> 
          <input type="hidden" name="hidden_leave_name" value="<?php echo $leave_type->leave_type ?>">
      
      <div class="form-group"   >
        <label for="cutoff" class="col-sm-2 control-label">Fiscal Year</label>
      <div class="col-sm-10" >
        <?php 
                          if($leave_type->cutoff=="yearly" OR $leave_type->cutoff=="date_hired"){  
                            $final_string_start_month="Month";
                            $final_substr_start_day="Day";
                            $string_start_month="";
                            $substr_start_day="";
                            $final_string_end_month="Month";
                            $final_substr_end_day="Day";
                            $string_end_month="";
                            $substr_end_day="";                          
                          }elseif($leave_type->cutoff !="yearly"){  
                                          
                          $string_start_month = substr($leave_type->cutoff, 0, -9); 
                          $substr_start_day = substr($leave_type->cutoff, 3, -6);     
                          $final_substr_start_day = substr($leave_type->cutoff, 3, -6);     

                          $string_end_month = substr($leave_type->cutoff, 6, -3); 
                          $substr_end_day = substr($leave_type->cutoff,  -2);
                          $final_substr_end_day = substr($leave_type->cutoff,  -2);

                          $final_string_start_month =date("F", mktime(0, 0, 0, $string_start_month, 10));
                          $final_string_end_month =date("F", mktime(0, 0, 0, $string_end_month, 10)); 
                         
                          }else{
                            $final_string_start_month="Month";
                            $final_substr_start_day="Day";
                            $string_start_month="";
                            $substr_start_day="";
                            $final_string_end_month="Month";
                            $final_substr_end_day="Day";
                            $string_end_month="";
                            $substr_end_day="";
                          }   
        ?>
        <select name="start_month" class="form-control" style="float:left;width:25%;" id="start_month">
        <option value="<?php echo $string_start_month;?>" selected=""><?php echo $final_string_start_month;?></option>
          <?php
          for($M =1;$M<=12;$M++){
          echo "<option value='".$month_no = sprintf("%02d", $M)."'>". date("F", mktime(0, 0, 0, $M, 10)) ."</option>";
          }
          ?>
        </select> 
        <select name="start_day" class="form-control" style="float:left;width:21%;" id="start_day" >
        <option value="<?php echo $substr_start_day;?>" selected=""><?php echo $final_substr_start_day;?></option>
          <?php
          $D = 1;
          while ( $D <= 31 ) {
          echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
          $D++;
          }
          ?>
        </select>

        <label class="form-control" style="float:left;width: 8%;background-color: transparent;border: none;text-align: center;">To</label>

        <select name="end_month" class="form-control" style="float:left;width:25%;" id="end_month"  >
        <option value="<?php echo $string_end_month;?>" selected="" ><?php echo $final_string_end_month;?></option>
          <?php
          for($M =1;$M<=12;$M++){
          echo "<option value='".$month_no = sprintf("%02d", $M)."'>". date("F", mktime(0, 0, 0, $M, 10)) ."</option>";
          }
          ?>
        </select> 
        <select name="end_day" class="form-control" style="float:left;width:21%;" id="end_day" >
        <option value="<?php echo $substr_end_day;?>" selected="" ><?php echo $final_substr_end_day;?></option>
          <?php
          $D = 1;
          while ( $D <= 31 ) {
          echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
          $D++;
          }
          ?>
        </select>   

        </div>
      </div>
      <div class="form-group" >
        <label for="reset_yearly" class="col-sm-2 control-label"></label>
      <div class="col-sm-10">

          <input type="radio"  onclick="enable_select_date(this.checked)" value="yearly" title="check if yearly" <?php if($leave_type->cutoff =="yearly"){ echo "checked"; }else{echo "";}?> name="yearly";> Yearly?  
      
          <input type="radio"  onclick="enable_select_date(this.checked)" value="date_hired" title="check if fiscal year is based on employee anniversary/hired date." <?php if($leave_type->cutoff =="date_hired"){ echo "checked"; }else{echo "";}?> name="yearly";> Anniversary Date of Employee?  
      </div>   


      <div class="form-group"   >
        <label for="cutoff" class="col-sm-2 control-label">Credit Type</label>
      <div class="col-sm-10" >
        <select class="form-control" name="is_manual_Credit">
        <?php
        if($leave_type->is_manual_credit>0){
          $imc="1";
          $imc_text="Manual Encode Credit"; 
        }else{
          $imc="0";
          $imc_text="Set/System will follow automatic setup";
        }
        ?>
        <option value="<?php echo $imc;?>" selected><?php echo $imc_text;?></option>
        <option disabled>&nbsp;----------</option>
        <option value="1">Manual Encode Credit </option>
        <option value="0">Set/System will follow automatic setup</option>
        </select>
      </div>


          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>