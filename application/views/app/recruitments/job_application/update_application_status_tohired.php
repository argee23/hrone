
 <div class="modal-content">
     
       <input type="hidden" id="current_date" value="<?php echo date('Y-m-d');?>">
        <div class="modal-body">



          <div class="row">
            <div class="col-md-12 " id="printablediv">

              <div>
                <div class="box-body">
<div class="col-lg-12">      
     <div class="box box-widget widget-user">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-blue-active">
        <h3 class="widget-user-username"><?php echo $app_info->fullname;?>
        <?php 
if(!empty($app_info->nick_name)){
 echo '<span style="font-size: 12px">( '.$app_info->nick_name.' ) </span>';
}else{  
//do not display nickname if its blank 
}
?>
        </h3>
         
        <h3 class="widget-user-username pull-right"><?php echo $app_info->job_title;?></h3>
 
<h5 class="widget-user-desc">
<?php
if(!empty($app_info->mobile_1)){
?> 
<i class="fa fa-mobile"></i> <?php echo $app_info->mobile_1;?>
<?php
}else{
}
echo " &nbsp;  &nbsp; ";
if(!empty($app_info->mobile_2)){
?>
<i class="fa fa-mobile"></i> <?php echo $app_info->mobile_2;

}else{
}
?>
</h5> 

<?php
if(!empty($app_info->email)){
?> 
<h5 class="widget-user-desc">
<i class="fa fa-envelope"></i> <?php echo $app_info->email;?>
</h5>
<?php
}else{
}

if(!empty($app_info->tel_1)){
?> 
<h5 class="widget-user-desc">

<i class="fa fa-phone"></i> <?php echo $app_info->tel_1;?>
<?php
}
else{
}
echo " &nbsp;  &nbsp; ";
if(!empty($app_info->tel_2)){
?>
<i class="fa fa-phone"></i> <?php echo $app_info->tel_2;

}else{
}
?>
</h5>


      </div>
      <div class="widget-user-image">
        <img class="img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $app_info->picture;?>" alt="User Avatar">
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-6 border-right">
<span class="info"><i class="fa fa-calendar"></i> Date Applied:  <?php echo $app_info->date_applied;?></span><br>
<span class="info"><i class="fa fa-check-circle-o"></i> Application Status:  
<?php
$id=$app_info->ApplicationStatus;
$mystat=$this->recruitment_model->get_status_option($id);
if(!empty($mystat)){
  echo $mystat->status_title;
}else{
  echo "new";
}
?>

</span><br>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-sm-6">
         <span class="info pull-right"><i class="fa fa-map"></i>
 <?php echo $app_info->present_address.", ";
                     $province_id= $app_info->present_province;

                     $city_id= $app_info->present_city;

                     if(!empty($city_id)){
$mycity=$this->general_model->myCity($city_id);
echo $mycity->city_name." "; 
                     }

                     if(!empty($province_id)){
$myprov=$this->general_model->myProvince($province_id);
echo $myprov->name;                      
                     }
?>

         </span><br>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </div>
</div>              
<div class="col-md-12">
  <div class="box-body">
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Personal Information<i class="fa fa-newspaper-o pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<tr>
<td width="30%">Birthday</td>
<td><?php echo $app_info->birthday;?> <i class="fa fa-birthday-cake text-danger"></i></td>
</tr>
<tr class="alt">
<td>Civil Status</td>
<td><?php
$civil_status_id=$app_info->civil_status;
$mycivil_stat=$this->general_model->getCivil_status($civil_status_id);
if(!empty($mycivil_stat)){
  echo $mycivil_stat->civil_status;
}else{
  echo "";
}
?> </td>
</tr>
<tr>
<td>Blood Type</td>
<td><?php
$myblood_type=$this->general_model->getBloodType($app_info->blood_type);
if(!empty($myblood_type)){
  echo $myblood_type->cValue;
}else{
  echo "";
}
?>      
</td>
</tr>
<tr class="alt">
<td>Citizenship</td>
<td><?php
$mycitizenship=$this->general_model->getCitizenship($app_info->citizenship);
if(!empty($mycitizenship)){
  echo $mycitizenship->cValue;
}else{
  echo "";
}
?> </td>
</tr>
<tr>
<td>Religion</td>
<td><?php
$myreligion=$this->general_model->getReligion($app_info->religion);
if(!empty($myreligion)){
  echo $myreligion->cValue;
}else{
  echo "";
}
?> </td>
</tr>

</tbody>
</table>
</div>
<!-- //=================Other Info -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Other Information<i class="fa fa-info pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<tr class="alt">
<td width="30%">Philhealth</td>
<td><?php
echo $app_info->philhealth;
?> </td>
</tr>
<tr>
<td>SSS</td>
<td><?php
echo $app_info->sss;
?>  </td>
</tr>
<tr class="alt">
<td>Pagibig</td>
<td><?php
echo $app_info->pagibig;
?> </td>
</tr>
<tr>
<td>TIN</td>
<td><?php
echo $app_info->tin;
?> </td>
</tr>
</tbody>
</table>
</div>
<!-- //===========================work experiences -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Work Experience<i class="fa fa-black-tie pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php
$mywork_exp=$this->general_model->getMyWorkExperience($app_info->id);
if(!empty($mywork_exp)){
  foreach($mywork_exp as $work){
?>
 <tr class="alt">
    <td colspan="2" class="educ_head"><?php echo $work->position_name;?></td>
  </tr>
  <tr >
    <td  width="30%">&nbsp;</td>
    <td><?php echo $work->company_name;?></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td><?php echo $work->company_address;?></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td>Job Description</td>
  </tr>
  <tr >
    <td >&nbsp;</td>
    <td><?php
if($work->isPresentWork=="1"){
  $to_date="Present";
}else{
  $to_date=$work->date_end;
}
     echo $work->date_start." - ".$to_date;?></td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no work experience yet.<td></tr>";
}
?>
</tbody>

</table>
</div>

<!-- //===========================educational background -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Educational Background<i class="fa fa-book pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$myeducation=$this->general_model->getMyEducation($app_info->id);
if(!empty($myeducation)){
  foreach($myeducation as $myEd){
?>
 <tr class="alt">
    <td colspan="2" class="educ_head"><?php echo $myEd->education_name;?></td>
  </tr>
  <tr >
    <td width="30%">&nbsp;</td>
    <td><?php echo $myEd->school_name;?></td>
  </tr>
  <!-- course -->
 <?php
 if(empty($myEd->course)){
  //do not display honor
 }else{
 ?> 
  <tr>
    <td >&nbsp;</td>
    <td><?php echo $myEd->course;?></td>
  </tr>
<?php
}
?>  

  <tr>
    <td >&nbsp;</td>
    <td><?php echo $myEd->school_address;?></td>
  </tr>
  <!-- honors -->
 <?php
 if(empty($myEd->honors)){
  //do not display honor
 }else{
 ?> 
  <tr>
    <td >&nbsp;</td>
    <td><?php echo $myEd->honors;?></td>
  </tr>
<?php
}
?>

  <tr >
    <td >&nbsp;</td>
    <td><?php echo $myEd->date_start." - ".$myEd->date_end;?></td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no educational background yet.<td></tr>";
}
?>
</tbody>

</table>
</div>

<!-- //===========================Skills -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Skills<i class="fa fa-info-circle pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$myskill=$this->general_model->getMySkills($app_info->id);
if(!empty($myskill)){
  foreach($myskill as $skill){
?>
 <tr class="alt">
    <td colspan="2" class="educ_head"><?php echo $skill->skill_name;?></td>
  </tr>
  <tr >
    <td width="30%">&nbsp;</td>
    <td><?php echo $skill->skill_description;?></td>
  </tr>
 
<?php
  }//end of foreach
}else{
    echo "<tr><td>no skills yet.<td></tr>";
}
?>
</tbody>

</table>
</div>
<!-- //===========================Training & Seminars -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Training & Seminars<i class="fa fa-users pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$mytraining=$this->general_model->getMyTrainings($app_info->id);
if(!empty($mytraining)){

foreach($mytraining as $train){
?>
  <tr >
    <td width="30%">
      <img src="<?php echo base_url()?>public/applicant_files/certificates/<?php echo $train->file_name;?>" class="img-responsive img-thumbnail" style="width:200px">
    </td>
    <td>
<p><?php echo $train->training_title;?></p>      
<p><?php echo $train->training_institution;?></p>    
<p><?php echo $train->training_address;?></p>        
<p><?php echo $train->conducted_by;?></p>         
<p><?php 
if($train->isOneDay=="1"){
  echo $train->date_start." - ".$train->date_start;
}else{
  echo $train->date_start." - ".$train->date_end;
}
    ?></p>      

    </td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no training & seminars yet.<td></tr>";
}
?>
</tbody>

</table>
</div>

<!-- //===========================Character Reference -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Character References<i class="fa fa-users pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$myreference=$this->general_model->getMyCharacterReference($app_info->id);
if(!empty($myreference)){

foreach($myreference as $myRef){
  if(empty($myRef->reference_company)){
//if blank si company do not display 
  }else{
?>
  <tr class="alt">
    <td width="30%">Company Name</td>
    <td><?php echo $myRef->reference_company;?></td>
  </tr>
  <?php } ?>
  <tr >
    <td>Name</td>
    <td><?php echo $myRef->cValue." ".$myRef->reference_name;?></td>
  </tr>
  <tr>
    <td>Designation</td>
    <td><?php echo $myRef->reference_position;?></td>
  </tr>
  <tr>
    <td>Contact No</td>
    <td><?php echo $myRef->reference_contact;?></td>
  </tr>
  <tr >
    <td>Email</td>
    <td><?php echo $myRef->reference_email;?></td>
  </tr>
    <td colspan="2">&nbsp;</td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no character reference yet.<td></tr>";
}
?>
</tbody>

</table>
</div>
</div>
</div>

  <div class="col-md-12">
             <i><n class="text-danger"><b>Note :</b>If you will update the application status to HIRED. Applicant Information will be moved to the official masterlist data of employed employees.</i></n>
  </div>
          
        </div>
          <div class="col-md-12 modal-footer">
            <button type="button" class="btn btn-danger" onclick="location.reload();">Close</button>

            <button type="button" class="btn btn-success" style="margin-left: 10px;" onclick="hired('<?php echo $employer_type;?>','<?php echo $app_id;?>');">HIRED APPLICANT</button>
          </div> 
      </div>
    </div>



<script type="text/javascript">
  
  function hired(employer_type,app_id)
  {
    var result = confirm("Are you sure?");
    if(result == true)
    {

    if (window.XMLHttpRequest)
                {
                  xmlhttp=new XMLHttpRequest();
                }
              else
                {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                  xmlhttp.onreadystatechange=function()
                    {
                      if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                        location.reload(); 
                      }
              }
    xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/hired_applicant/"+employer_type+"/"+app_id,true);
    xmlhttp.send();

    }
  }

</script>




