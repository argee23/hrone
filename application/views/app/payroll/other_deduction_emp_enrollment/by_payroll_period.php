      <?php

        $company_id=$this->uri->segment("4");
        $pay_type=$this->uri->segment("5");

        $comp_details=$this->general_model->get_company_info($company_id);
        $division_setting=$comp_details->wDivision;

        ?>

<div class="form-group"   >
        <label for="next" class="col-sm-5 control-label">Payroll Period</label>
    <div class="col-sm-7">
        <select name="pay_period" class="form-control" id="pay_period"  required >
        <?php
        if(!empty($pay_per_deduction)){
            foreach($pay_per_deduction as $pay_period){
                $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
                $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
                echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
            }
        }else{
            echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';        

        }
        ?>
        </select>
    </div>
</div>  

<div class="form-group"   >
        <label for="next" class="col-sm-5 control-label">Location</label>
    <div class="col-sm-7" style="margin-bottom:5px;">
        <?php
        $comp_loc=$this->general_model->get_company_locations($company_id);
        if(!empty($comp_loc)){
            foreach($comp_loc as $loc){
                echo '<input type="checkbox" value="'.$loc->location_id.'" checked name="location[]">'.$loc->location_name.'<br>';  
            }
        }else{
            echo 'warning: no location setup yet.';     

        }
        ?>

    </div>
</div>  
<?php
if($division_setting=="1"){// show division option
?>
<div class="form-group"   >
        <label for="next" class="col-sm-5 control-label">Division</label>
    <div class="col-sm-7" style="margin-bottom:5px;">
        <select name="division" class="form-control" id="division_id"  required  onchange="fetch_division_dept();">
        <option value="All" selected>All</option>   
        <?php
        $comp_div=$this->general_model->get_company_divisions($company_id);
        if(!empty($comp_div)){
            foreach($comp_div as $div){
                echo '<option value="'.$div->division_id.'">'.$div->division_name.'</option>';
            }
        }else{
            echo '<option value="" disabled selected>warning : no division created yet.</option>';  

        }
        ?>
</select>
    </div>
</div> 
<div  id="show_div_dept">
<div class="form-group" >
        <label for="department" class="col-sm-5 control-label">Division - Department(s)</label>
    <div class="col-sm-7" style="margin-bottom:5px;">
        <select name="department" class="form-control" id="department_id"  required onchange="fetch_section()">
        <option value="All" selected>All</option>
        
        </select>
    </div>
</div> 
</div> 
<?php
}else{
?>
<div class="form-group"  >
        <label for="department" class="col-sm-5 control-label">Department</label>
    <div class="col-sm-7" style="margin-bottom:5px;">
        <select name="department" class="form-control" id="department_id"  required onchange="fetch_section()">
        <option value="All" selected>All</option>
        <?php
        $comp_dept=$this->general_model->get_company_departments($company_id);
        if(!empty($comp_dept)){
            foreach($comp_dept as $dept){
                echo '<option value="'.$dept->department_id.'">'.$dept->dept_name.'</option>';
            }
        }else{
            echo '<option value="" disabled selected>warning : no department created yet.</option>';        

        }
        ?>
        </select>
    </div>
</div> 

<?php
}
?>

 
<div class="form-group"   >
        <label for="section" class="col-sm-5 control-label">Section</label>
    <div class="col-sm-7" id="show_section">
        <select name="section" class="form-control" id="section"  required >
        <option value="All" selected>-All-</option>
        
        </select>
    </div>
</div>  

<div style="margin-top: 5px;" id="show_sub_section">

</div>
<div class="form-group"   >
        <label for="next" class="col-sm-5 control-label">Classification</label>
    <div class="col-sm-7">
        <?php
        $comp_class=$this->general_model->get_company_classifications($company_id);
        if(!empty($comp_class)){
            foreach($comp_class as $clas){
                echo '<input type="checkbox" value="'.$clas->classification_id.'" checked name="classification[]">'.$clas->classification.'<br>';   
            }
        }else{
            echo '<span class="text-danger">warning: no classification setup yet.</span>';      

        }
        ?>

    </div>
</div>  
&nbsp;
<div class="form-group text-info">
        <label for="next" class="col-sm-5 control-label"><br>Employment</label>
    <div class="col-sm-7"><br>
        <?php

        if(!empty($employmentList)){
            foreach($employmentList as $emp){
                echo '<input type="checkbox" value="'.$emp->employment_id.'" checked name="employment[]">'.$emp->employment_name.'<br>';    
            }
        }else{
            echo 'warning: no employment setup yet.';     

        }
        ?>

    </div>
</div>  


<div class="form-group">
    <label for="next" class="col-sm-5 control-label"><br>Other Deduction Types</label>
      <div class="col-sm-7"><br>
    <?php
    if(!empty($deduction_type)){
        $d_count=0;
        foreach($deduction_type as $d){
            $d_count++;
            if($d_count=="1"){
                $check_me="checked";
            }else{
                $check_me="";
            }
                echo '<input type="checkbox" value="'.$d->id.",".$d->other_deduction_type.'" '.$check_me.' name="od_types[]">'.$d->other_deduction_type.'<br>'; 
           
            
        }
    }else{
                echo '<input type="hidden" value="0,0" name="od_types[]">'; 
                echo 'warning: no other deduction setup yet.';  
    }
    ?>
    </div>
</div>
 
 <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Generate</button>
