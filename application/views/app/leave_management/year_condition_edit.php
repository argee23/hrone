<?php
    $display_year=$year_condition->year;
    if($display_year==1){
      $extension="st";
    }else if($display_year==2){$extension="nd";
    }else if($display_year==3){$extension="rd";
    }else{$extension="th";}
?>

<div class="well">
<form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/leave_management/modify_leave_year/<?php echo $this->uri->segment("4");?>" >
<table  class="table table-bordered table-striped">
    <thead>
        <tr>
          <th colspan="3"><i class="fa fa-pencil-square-o fa-lg text-info pull-left"  data-toggle="tooltip" data-placement="left" ></i>Edit <?php echo $year_condition->leave_type ?> <font color="#ff0000"><?php echo $display_year.$extension;?>  Year Auto Increment Conditions</font>
          </th>      
        </tr>
    </thead>  
<tbody> </tbody>
</table>
    <div class="box-body">
        <input type="hidden" class="form-control" name="leave_id" id="leave_id" placeholder="leave id" value="<?php echo $year_condition->id?>"> 
        <input type="hidden" name="hidden_leave_name" value="<?php echo $year_condition->leave_type ?>">

      <div class="form-group">
          <label for="increment" class="col-sm-2 control-label">Increment</label>
        <div class="col-sm-10" >
            <select name="increment" class="form-control">
            <option value="<?php echo $year_condition->increment ?>" selected >every <?php echo $year_condition->increment ?> month</option>
            <?php $increment=0; while($increment<12){?>
            <option value='<?php echo $increment+=1;?>'>every <?php echo $increment;?> month</option>
            <?php } $increment=0;?>
            </select>
        </div>
      </div>
      <div class="form-group" >
          <label for="leave_balance" class="col-sm-2 control-label">Credit</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="leave_balance" value="<?php echo $year_condition->add_leave_bal ?>">
        </div>   
      </div>
      <div class="form-group">
          <label for="max" class="col-sm-2 control-label">Max</label>
        <div class="col-sm-10">
           <input type="number" class="form-control" name="max" value="<?php echo $year_condition->max ?>">
        </div>
      </div>     
<!--       <div class="form-group">
          <label for="replenish" class="col-sm-2 control-label">Replenish</label>
        <div class="col-sm-10">
          <select name="replenish" class="form-control">
          <option value="<?php 
          //echo $year_condition->replenish ?>">
          <?php
           // if($year_condition->replenish==1){
           //  echo "YES";
           // }  else{
           //  echo "NO";
           // }

          ?></option>
          <option value="1">YES</option>
          <option value="0">NO</option>
          </select>
        </div>
      </div>  -->    
      <div class="form-group">
          <label for="isyearly_setup" class="col-sm-2 control-label">Is this a yearly <span class="text-danger">(monthly increment)</span> setup?</label>
        <div class="col-sm-10">
          <select name="isyearly_setup" class="form-control">
          <option value="<?php echo $year_condition->isyearly_setup ?>"><?php
           if($year_condition->isyearly_setup==1){
            echo "YES";
           }  else{
            echo "NO";
           }

          ?></option>
          <option value="1">YES</option>
          <option value="0">NO</option>
          </select>
        </div>
      </div>     
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>