
<div class="box-body">
<div class="panel panel-danger">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/pagibig_edit_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">

			<table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width:15%" >EMPLOYEE ID</th>
                    <th style="width:35%" > EMPLOYEE NAME</th>
                    <th> AMOUNT</th>
                    <th style="width:15%" >DEDUCTION PER</th>
                    <th style="width:15%" >TYPE</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

              <tr>
                <td align="center" ><?php echo $pagibig->employee_id; ?></td>
                <td align="center" ><?php echo $pagibig->last_name.', '.$pagibig->first_name.' '.$pagibig->middle_name.' '.$pagibig->name_extension; ?></td>
                <td align="center" ><input type="number" name="amount" class="form-control" placeholder="Amount" value="<?php echo $pagibig->amount; ?>" step="any" required></td>
                <td align="center" >
<?php
$co=$pagibig->cut_off_id;
            if($co=="1"){
                $extension="st";
            }elseif($co=="2"){
                $extension="nd";
            }elseif($co=="3"){
                $extension="rd";
            }elseif($co=="4" OR $co=="5" ){
                $extension="th";
            }else{
                $extension="";
            }

?>
<select class="form-control" name="cutoff" id="cutoff" required>
<option value="<?php echo $co;?>" selected><?php echo $pagibig->cut_off_name;;?></option>
<option disabled></option>
<?php

$employee_pay_type=$pagibig->employee_pay_type;

foreach($cut_off_typeList as $c){

if($employee_pay_type=="1"){
    echo '<option value="'.$c->param_id.'">'.$c->cValue.'</option>';
}elseif($employee_pay_type=="2" OR $employee_pay_type=="3"){
    if($c->param_id=="97" OR $c->param_id=="98" OR $c->param_id=="102"){
        echo '<option value="'.$c->param_id.'">'.$c->cValue.'</option>';
    }else{

    }
}elseif($employee_pay_type=="4"){
    if($c->param_id=="97"){
        echo '<option value="'.$c->param_id.'">'.$c->cValue.'</option>';
    }else{

    }
}else{

}
}


                ?>
     
</select>

                </td>
                <td align="center" >
                	<?php $type = $pagibig->pagibig_type_id; ?>
                	<select class="form-control" name="type" id="type" required>
                	<?php if(empty($type)){ ?>
			        <option selected="selected" value="" disabled>~select a type~</option>
			        <?php }
			        if(!empty($type)){ ?>
			        <option selected="selected" value="<?php echo $pagibig->pagibig_type_id; ?>"><?php echo $pagibig->pagibig_type_name; ?></option>
			        <?php } ?>
 			        <?php
			          foreach($pagibig_type as $type){
			            if($_POST['type'] == $type->param_id){
			              $selected = "selected='selected'";
			            }else{
			              $selected = "";
			            }
			          ?>
			          <option value="<?php echo $type->param_id;?>" <?php echo $selected;?>><?php echo $type->cValue;?></option>
			        <?php }?>
    				</select>
                </td>
                <td>
				<button type="submit" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
				</td>
              </tr>

            </tbody>
            </table>

</div>
</div>

</form>  

</div>
</div>