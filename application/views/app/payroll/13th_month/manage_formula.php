<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$pr_add_13th_month_formula=$this->session->userdata('pr_add_13th_month_formula');
$pr_edit_13th_month_formula=$this->session->userdata('pr_edit_13th_month_formula');
$pr_del_13th_month_formula=$this->session->userdata('pr_del_13th_month_formula');
$pr_enable_disable_13th_month_formula=$this->session->userdata('pr_enable_disable_13th_month_formula');


/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-danger">
      <!-- Default panel contents -->
      <div class="panel-heading">
      <strong>
Manage 13th Month Formula
    	</strong>

      </div>

<div class="panel-body">

  
<div class="col-md-12">
      <div class="panel-heading"><strong>General Variables</strong></div>

<?php

if(!empty($general_formula_variable)){
	foreach ($general_formula_variable as $f ) {
		
echo ' <button class="btn-md col-md-3" id="'.$f->variable_id.'" value="'.$f->the_13th_month_letter.'" style="background-color:#E10F8E;color:#fff;">
<center>['.$f->the_13th_month_letter.'] '.$f->variable_name.'</center></button>';

	}
}else{

}

echo '</div><br>
<div class="col-md-12">
      <div class="panel-heading"><strong>Other Addition/Income</strong></div>

';
// ================
if(!empty($comp_oa)){
	foreach($comp_oa as $oa){	

echo ' <button class="btn-md col-md-3" id="'.$oa->id.'" value="'.$oa->id.'" style="background-color:#F984D7;color:#000;">
<center>[OA'.$oa->id.'] '.$oa->other_addition_type.'</center></button>';


	}
}else{

}

echo '</div><br>
<div class="col-md-12">
      <div class="panel-heading"><strong>Other Deduction</strong></div>
';
// ================
if(!empty($comp_od)){
	foreach($comp_od as $od){
// echo ' <button class="btn-md" id="'.$od->id.'" value="'.$od->other_deduction_type.'" style="background-color:#AF067E;color:#fff;"><center>'.$od->other_deduction_type.'</center></button>';		


echo ' <button class="btn-md col-md-3" id="'.$od->id.'" value="'.$od->id.'" style="background-color:#AF067E;color:#fff;">
<center>[OD'.$od->id.'] '.$od->other_deduction_type.'</center></button>';


	}
}else{

}




?>

</div>



		<div class="col-md-12">
		      <div class="panel-heading"><strong>Formula Options</strong>

 <div class="col-md-12 collapse" id="collapse_manage_pp">
    <div class="panel panel-primary">
      <div class="panel-heading">   
        <strong>
          Add 13th Month Formula
        </strong>
      </div>
        <div class="panel-body">
 <label class="text-danger col-md-3">Example Formula:</label>
 <label class="text-danger col-md-9">[A]/12</label>
 <label class="text-danger col-md-3">Example Formula Meaning</label>
 <label class="text-danger col-md-9">Net Pay/12</label>
 <br><br>
  <form name="" method="post" action="<?php echo base_url()?>app/payroll_generate_13th_month/add_formula" >
  			  <input type="hidden" name="company_id" value="<?php echo $company_id?>">
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Formula Name</label>
                  <div class="col-sm-7" >
                   <input type="text" name="the_formula_n" class="form-control">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">Formula Composition</label>
                  <div class="col-sm-7" >
                   <textarea name="the_formula_c" class="form-control" ></textarea>
                  </div>
              </div>

                    <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
                    <?php
                      echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
                    ?>

                    </button>

  </form>

        </div>
     </div>
 </div>	


        <a class="<?php echo $pr_add_13th_month_formula;?> btn btn-default btn-xs pull-right" data-toggle="collapse" href="#collapse_manage_pp" aria-expanded="false" aria-controls="collapseExample">
        <?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?>
                               
        </a>

		      </div>
		 <table id="example1" class="table table-bordered table-striped">
		            <thead>
		              <tr>
		              <th>Formula Name</th>
		              <th>Formula Meaning</th>
		              <th>Formula Composition</th>
		              <th>Formula Variable</th>
		              </tr>
		              </thead>
		              <tbody>

<?php
if(!empty($my13th_formula)){
	foreach($my13th_formula as $f){
		echo '<tr>';
		echo '<td>'.$f->formula_text.'</td>';
		echo '<td>meaning</td>';
		echo '<td>'.$f->formula_var.'</td>';
		echo '<td>variable</td>';
		echo '</tr>';
	}
}else{

}

?>
		              </tbody>
		</table>
    <!-- //======== -->
                <div class="text-center">
                  <?php foreach ($general_formula_variable as $btn_var): ?>
                    <button class="btn btn-sm btn-foursquare variable" id="<?php echo $btn_var->variable_abbrv ?>" title="<?php echo $btn_var->var_description ?>" value="[<?php echo $btn_var->variable?>]"><center><?php echo $btn_var->variable_abbrv?> </center></button>
                  <?php endforeach ?>
                </div>
                <div class="text-center">
                  <?php 
                    $count = 0;
                    while($count <= 9){ ?>
                      <button class="btn btn-social-icon btn-success variable" id="<?php echo $count ?>" value="<?php echo $count ?>"><center><?php echo $count ?></center></button>              
                  <?php $count++;}?>
<!-- added -->
 <button class="btn btn-social-icon btn-success variable" id="." value="."><center>.</center></button>
<!--  <button class="btn btn-social-icon btn-success variable" id="%" value="%"><center>%</center></button> -->
<!-- added-->

                </div>
              <div class="form-group">
                <div class="input-group">
                <input type="text" class="form-control text-center" id="formula_description" name="formula_description" readonly style="background-color: #fff">
                <div class="input-group-addon"><a id="reset_formula" title="reset_formula"><i class="fa fa-refresh"></i></a></div>
                </div>
              </div>
                <input type="hidden" class="form-control text-center" id="formula" name="formula" readonly>

              <button class="btn btn-sm btn-warning btn-block" id="btnAddFormula">Add Payroll Formula</button>
                <!-- //======== -->




		</div>




</div>
</div>
</div>



