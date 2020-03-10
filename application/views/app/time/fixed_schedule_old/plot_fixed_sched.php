<title><?php echo $this->session->userdata('sys_name');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
<!-- //=======================export to excel -->
<script type="text/javascript" src="<?php echo base_url()?>/public/jquery-1.9.0.js"></script>
<script type="text/javascript">
$(function(){
$('#export').click(function(){
     //getting values of current time for generating the file name
        var dt = new Date();
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        var hour = dt.getHours();
        var mins = dt.getMinutes();
        var postfix = year + "-" + month + "-" + day ;
        //creating a temporary HTML link element (they support setting file names)
        var a = document.createElement('a');
        //getting data from our div that contains the HTML table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('tableWrap');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        //setting the file name
        a.download = postfix + '_Mass_Transaction_Encoding' + '.xls';
        //triggering the function
        a.click();
        //just in case, prevent default behaviour
        e.preventDefault();
   
})
})
</script>



<?php
$company_id =$this->uri->segment('5'); //company id
$group_id =$this->uri->segment('4');

$group_detail=$this->time_fixed_schedule_model->delete($group_id); 
if(!empty($group_detail)){
    $group_name= $group_detail->group_name;

}else{
    $group_name='group not found';
}

  $company=$this->general_model->get_company_info($company_id);
  if(!empty($company)){
    $company_name =$company->company_name;
    $company_logo =$company->logo;
    $company_address =$company->company_address;
    $company_contact_no =$company->company_contact_no;
    $company_tin =$company->TIN;
  }else{
    $company_name ='company not found';
    $company_logo ='company not found';
    $company_address ='company not found';
    $company_contact_no ='company not found';
    $company_tin ='company not found';
  }

?>
<input type="hidden" value="<?php echo $company_id; ?>" id="company_id">
<input type="hidden" value="<?php echo $group_id; ?>" id="group_id">

<form name="f" method="post" action="<?php echo base_url()?>app/time_fixed_schedule/save_plot_fixed_sched/<?php echo $group_id;?>/<?php echo $company_id;?>" > 

<div class="table-responsive">
<table style="margin-left: auto;margin-right: auto;">
<tr>
    <th  style="text-align: center"><img src="<?php echo base_url();?>public/company_logo/<?php echo $company_logo ;?>" class="img-rounded" id="company_logo" width="120" height="120"><br>
    <strong>
    <?php 
    echo $company_name."<br>". $company_address."<br>Tel:". $company_contact_no;
    ?><br><small><?php echo date("F j, Y");?></small></strong>
    </th>
</tr>
</table>

    <div id="tableWrap" style="margin-left: 10px;margin-right: 10px;">
<?php echo $message;?>
<?php echo validation_errors(); ?>
<table style="font-size: 11px;" class="table table-bordered table-striped">
<thead>
    <tr style="border-top:2px solid #000;">
        <th colspan="2">Fixed Schedule</th>
        <th colspan="8">Group Name: <?php echo $group_name; ?></th>
        
    </tr>
    </thead>
    <tr>
        <th> Employee ID</th>
        <th> Employee Name</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
         <th > Date Registered </th>
    </tr>

<?php 
$members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id);  
if(!empty($members)){
    foreach($members as $member){
         $classification_id=$member->classification;
         $mon=$member->mon;
         $tue=$member->tue;
         $wed=$member->wed;
         $thu=$member->thu;
         $fri=$member->fri;
         $sat=$member->sat;
         $sun=$member->sun;

        echo
         '<tr>'.
            '<td>'.$member->employee_id. '</td>'.
            '<td>'.$member->member_name. '</td>';
            
?>
<!-- ::::::::::::::::::: monday -->
<td>
<select name="mon_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($mon)){
    echo '<option value="'.$mon.'" selected="" style="color:#409015;">'.$mon.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>

<!-- ::::::::::::::::::: tuesday -->
<td>
<select name="tue_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($mon)){
    echo '<option value="'.$tue.'" selected="" style="color:#409015;">'.$tue.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>

<!-- ::::::::::::::::::: wednesday -->
<td>
<select name="wed_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($wed)){
    echo '<option value="'.$wed.'" selected="" style="color:#409015;">'.$wed.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>

<!-- ::::::::::::::::::: thursday -->
<td>
<select name="thu_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($thu)){
    echo '<option value="'.$thu.'" selected="" style="color:#409015;">'.$thu.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>

<!-- ::::::::::::::::::: friday -->
<td>
<select name="fri_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($fri)){
    echo '<option value="'.$fri.'" selected="" style="color:#409015;">'.$fri.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>

<!-- ::::::::::::::::::: saturday -->
<td>
<select name="sat_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($sat)){
    echo '<option value="'.$sat.'" selected="" style="color:#409015;">'.$sat.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>

<!-- ::::::::::::::::::: sunday -->
<td>
<select name="sun_<?php echo $member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:230px;">
<?php if(!empty($sun)){
    echo '<option value="'.$sun.'" selected="" style="color:#409015;">'.$sun.'</option>';
    echo '<option value="restday" style="color:#ff0000;">Rest day</option>';
  }else{
    echo '<option value="restday" selected="" style="color:#409015;">Rest day</option>';
    }
?>
<option disabled>~~ Regular Whole day Schedule ~~</option>
<?php 
$ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
if(!empty($ws_regular)){
    foreach($ws_regular as $whole_sched){
        //reg_ : regular working schedule / whole day
        echo '<option style="color:#0B93B1;" value="'.$whole_sched->time_in.' to '.$whole_sched->time_out.'-regular">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
    } 
}else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Half Schedule ~~</option>
<?php 
$ws_halfday=$this->general_model->get_ws_halfday($classification_id,$company_id);

if(!empty($ws_halfday)){
    foreach($ws_halfday as $half_sched){
        //haf_ : halfday working schedule
            echo '<option style="color:#16810B;" value="'.$half_sched->time_in.' to '.$half_sched->time_out.'-halfday">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
        } 
    }
else{
    echo '<option value="" disabled>  </option>';
}
?>
<option disabled>~~ Restday/Holiday Schedule ~~</option>
<?php 
$ws_rd_hol=$this->general_model->get_ws_restday_holiday($classification_id,$company_id);

if(!empty($ws_rd_hol)){
    foreach($ws_rd_hol as $rd_hol_sched){
        //rdh : restday holiday working schedule
        echo '<option style="color:#DC172C;" value="'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'-restday-holiday">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
    } 
}
else{
    echo '<option value="" disabled> </option>';
}
?>
</select>
</td>
<?php
           echo 
            '<td>'.$member->date_added. '</td>'.
        '</tr>';
    }
}else{
        echo '<tr><td colspan="10" class="text-center text-danger"> -- no employee/group members yet -- </td></tr>';
}
?>

</table>

    </div>
</div>

<?php
$members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id);  
if(!empty($members)){
?>
    <div style="position: fixed;
    bottom: 15px;
    right: 0px;border:0px solid #000;width: 100%">
        <button type="submit" class="btn btn-danger btn-md pull-right"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Save Schedule"><i class="fa fa-floppy-o"></i> Save</button>
    </div>
<?php 
}else{

    // do not show save button
}
?>
</form>

