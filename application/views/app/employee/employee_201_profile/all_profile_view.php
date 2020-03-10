<?php include('header.php');?>
        
        <div id="col_2">
                
              <!-- <div id="printablediv" > -->

<style>
#des {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#des td, #des th {
    border: 1px solid #ddd;
    padding: 8px;
}

#des tr:nth-child(even){background-color: #f2f2f2;}

#des tr:hover {background-color: #ddd;}

#des th {
    padding-top: 12px;
    padding-bottom: 12px;
}
</style>
<div class="row">
<div class="col-md-8" >
<link rel="stylesheet" type="text/css" href="/css/print.css" media="print" />
<div class="col-md-12" >
  <div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body" style='height:auto;overflow: auto;'>
        <!--start here-->
          <div class="col-md-12">
              <div class="box box-solid" id='printableArea'>
              <?php $cID=$this->session->userdata('company_id'); 
                $company=$this->employee_201_model->get_emp_company($cID);
                foreach($company as $comp_det){
                  $company_name =$comp_det->company_name;
                  $company_logo =$comp_det->logo;
                  $company_address =$comp_det->company_address;
                  $company_contact_no =$comp_det->company_contact_no;
                  $company_tin =$comp_det->TIN; ?>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                     <tr>
                        <th colspan="4" style="text-align: center"><img src="<?php echo base_url();?>public/company_logo/<?php echo $company_logo ;?>" class="img-rounded" id="company_logo" width="120" height="120"><br>
                          <strong>
                           <?php 
                            echo $company_name."<br>". $company_address."<br>Tel:". $company_contact_no;
                          ?><br><?php// echo date("F j, Y");?></strong>
                         </th>
                      </tr>
                      <tr>
                      <th colspan="4"><br></th>
                      </tr>
                      <tr>
                      <th colspan="4" style="text-align: center"><h4>Employee 201 Information</h4></th>
                    </tr>
                    </thead>
                  </table><br>
              <?php } ?>
              <table class="table table-bordered" id="des">
                <thead>
                <tr>
                </tr>
                </thead>
                <tbody>
                <!--Personal Information-->
                  <tr class='success'>
                    <td colspan="7"><i class="glyphicon glyphicon-user"></i><b>Personal Information</b></td>
                  </tr>
                  <tr>

                    <td  style="width:10%"><n class='text-success'>First Name </n></td>
                    <td colspan='2'><n class='text-danger'><?php echo $info->first_name?></n></td>
                    <td> <n class='text-success'>Middle Name </n></td>
                    <td><n class='text-danger'><?php echo $info->middle_name?></n></td>
                    <td><n class='text-success'>Last Name </n></td>
                    <td><n class='text-danger'><?php echo $info->last_name?></n></td>
                  </tr>
                  <tr>
                    <td  style="width:10%"><n class='text-success'>Nickname </n></td>
                    <td colspan='2'><n class='text-danger'><?php echo $info->nickname?></n></td>
                    <td><n class='text-success'>Birthday </n></td>
                    <td><n class='text-danger'><?php echo date("F d, Y", strtotime($info->birthday));?></n></td>
                    <td colspan="2" rowspan="3">
                    <center><i>Employee Picture</i>
                       <img class="img img-thumbnail bg-gray" style="width: 150px;" src="<?php echo $this->employee_201_model->get_general_url(); ?>employee_picture/<?php echo $info->picture; ?>">
                      </center> 
                    </td>
                  </tr>
                  <tr>
                    <td   style="width:10%"><n class='text-success'>Birth Place </n></td>
                    <td colspan='2'><n class='text-danger'><?php echo $info->birth_place?></n></td>
                    <td><n class='text-success'>Age </n></td>
                    <td>  <n class='text-danger'><?php if (empty($info->birthday)) {} else { echo $this->employee_201_model->calculate_interval($info->birthday);?> <?php }?></n></td>
      
                  </tr>
                  <tr>
                    <td  style="width:10%"><n class='text-success'>Gender </n></td>
                    <td colspan='2'><n class='text-danger'><?php echo $info->gender_name?></n></td>
                    <td><n class='text-success'>Civil Status </n></td>
                    <td><n class='text-danger'><?php echo $info->civil_status_name;?></n></td>
                  </tr>

                <!--End of Personal Information-->
                <!--Start of address details-->
                  <tr class='success'>
                    <td colspan="4"><i class="glyphicon glyphicon-map-marker"></i><b>Address Information</b></td>
                    <td colspan="3"><i class="glyphicon glyphicon-map-marker"></i><b>Residence Information</b></td>
                  </tr>
                  <tr>
                    <td colspan='4' align="left" style="width:20%">Permanent Address </td>
                  </tr>
                  <tr>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>City </n></td>
                    <td><n class='text-danger'><?php echo $address->permanent_city_name?></n></td>
                    <td><n class='text-success'>Province </n></td>
                    <td><n class='text-danger'><?php echo $address->permanent_province_name?></n></td>
                    <td rowspan='7' colspan="7"> <center><img class="img img-thumbnail bg-gray" style="width: 250px;height:150px; " src="<?php echo base_url(); ?>public/employee_files/residence/<?php echo $residence;?>"></center></td>
                  </tr>
                  <tr>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Address</n></td>
                    <td><n class='text-danger'><?php echo $address->permanent_address?></n></td>
                    <td><n class='text-success'>Years of Stay </n></td>
                    <td><n class='text-danger'><?php echo $address->permanent_address_years_of_stay?></n></td>
                  </tr>
                  <tr>
                    <td colspan='4' align="left" style="width:20%">Present Address </td>
                  </tr>
                  <tr>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>City :</n></td>
                    <td><n class='text-danger'><?php echo $address->present_city_name?></n></td>
                    <td><n class='text-success'>Province </n></td>
                    <td><n class='text-danger'><?php echo $address->present_province_name?></n></td>
                    
                  </tr>
                  <tr>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Address :</n></td>
                    <td><n class='text-danger'><?php echo $address->present_address?></n></td>
                    <td><n class='text-success'>Years of Stay </n></td>
                    <td><n class='text-danger'><?php echo $address->present_address_years_of_stay?></n></td>
                  </tr>
                  
                <!--end of address detaiils-->

                <!--Start of contact details-->
                  <tr class='success'>
                    <td colspan="7"><i class="glyphicon glyphicon-phone"></i><b>Contact Information</b></td>
                  </tr>
                  <tr>
                    <td colspan='7' align="left" style="width:20%"><i></i> Contact Accounts </td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Mobile Number </n></td>
                    <td colspan="1"><n class='text-danger'><?php echo $contact->mobile_1?></n></td>
                    <td colspan="1"><n class='text-danger'><?php echo $contact->mobile_2?></n></td>
                    <td colspan="1"><n class='text-danger'><?php echo $contact->mobile_3?></n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $contact->mobile_4?></n></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Telephone Number </n></td>
                    <td colspan="1"><n class='text-danger'><?php echo $contact->tel_1?></n></td>
                    <td colspan="4"><n class='text-danger'><?php echo $contact->tel_2?></n></td>

                  </tr>
                  <tr>
                    <td colspan='7' align="left" style="width:20%"> <i></i>Social Media Accounts</td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Email Address </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $contact->email?></n></td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Facebokk </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $contact->facebook?></n></td>
                  </tr>
                  
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Twitter </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $contact->twitter?></n></td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Instagram </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $contact->instagram?></n></td>
                  </tr>
                  
                <!--end of contact detaiils-->
                <!--start of employment details-->
                  <tr class='success'>
                    <td colspan="7"><i class="fa fa-building margin-r-5"></i><b>Employment Information</b></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Division </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->division_name;?></n></td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Department </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->dept_name;?></n></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Section </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->section_name;?></n></td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Subsection </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->subsection_name;?></n></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Position </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->position_name;?></n></td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Employment </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->employment_name;?></n></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Classification </n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $employment->classification_name;?></n></td>
                  </tr>

                <!--end of employment details-->
                <!--start of government details-->
                  <tr class='success'>
                    <td colspan="7"><i class="fa fa-building margin-r-5"></i><b>Government Details</b></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Bank Account </n></td>
                    <td colspan="2"><n class='text-danger'>
                        <?php 
                          if($account->bank != null){
                             $bank = $account->bank_name; 
                          }
                          else { $bank = ""; }
                          echo $bank;
                          ?></n>
                    </td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>SSS No</n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $account->sss;?></n></td>
                  </tr>
                  <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Philhealth No</n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $account->philhealth;?></n></td>
                    <td colspan='1' align="right" style="width:20%"><n class='text-success'>Pagibig No</n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $account->pagibig;?></n></td>
                  </tr>
                    <tr>
                    <td colspan='2' align="right" style="width:20%"><n class='text-success'>Tin No</n></td>
                    <td colspan="2"><n class='text-danger'><?php echo $account->tin;?></n></td>
                    <td colspan='1'></td>
                    <td colspan="2"></td>
                  </tr>

                <!--end of government details-->
                </tbody>
              </table>
              <table class="table table-bordered" id="des">
                <thead>
                <tr class='danger'>
                  <th colspan="7"><i class="fa fa-users fa-border"></i>Family Data</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($family)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($family as $fam) { ?>
                  <tr>
                    <td colspan="7"><i>Name : <?php echo $fam->name;?></i></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Occupation</n></td>
                    <td><n class='text-danger'><?php echo $fam->occupation?></n> </td>
                    <td><n class='text-success'>Birthday </n></td>
                    <td><n class='text-danger'><?php echo date("F d, Y", strtotime($fam->birthday));?></n> </td>
                    <td><n class='text-success'>Age </n></td>
                    <td><n class='text-danger'><?php if (empty($fam->birthday)) {} else { echo $this->employee_201_model->calculate_interval($fam->birthday);?> <?php }?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Contact No.</n></td>
                    <td><n class='text-danger'><?php echo $fam->contact_no?></n> </td>
                    <td><n class='text-success'>Relationship </n></td>
                    <td><n class='text-danger'><?php echo $fam->relationship_name?></n> </td>
                    <?php if($fam->relationship==72){?>
                    <td><n class='text-success'>Date of Marriage </n></td>
                    <td><n class='text-danger'><?php if (empty($fam->date_of_marriage)) {?> <td colspan="2"></td> <?php } else { echo date("F d, Y", strtotime($fam->date_of_marriage)); }?></n> </td>
                    <?php } else{  ?> <td colspan="2"></td><?php }?>
                  </tr>
                <?php } } ?>
                </tbody>
              </table>

              <table class="table table-bordered" id="des">
                <thead>
                <tr class='info'>
                  <th colspan="7"><i class="fa fa-graduation-cap"></i>Educational Attainment</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($education)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($education as $ed) { ?>
                  <tr>
                    <td colspan="7"><i>Education Name : <?php echo  $ed->education_name;?></i></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>School Name</n></td>
                    <td><n class='text-danger'><?php echo $ed->school_name?></n> </td>
                    <td><n class='text-success'>School Address </n></td>
                    <td><n class='text-danger'><?php echo $ed->school_address;?></n> </td>
                    <td><n class='text-success'>Honors </n></td>
                    <td><n class='text-danger'><?php echo $ed->honors?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><n class='text-success'>Education Duration </n></td>
                    <td><n class='text-danger'><?php echo date("F d, Y", strtotime($ed->date_start)); if($ed->isGraduated==0){ echo ' to <i> Present</i>'; } else{  echo ' to '.date("F d, Y", strtotime($ed->date_end));  } ?></n> </td>
                    <?php if($ed->education_type_id==1 || $ed->education_type_id==2){?> <td colspan="4"></td><?php }else{?>
                    <td><n class='text-success'>Course </n></td>
                    <td><n class='text-danger'><?php echo $ed->course?></n> </td>
                    <?php } ?>
                  </tr>
                <?php } } ?>
                </tbody>
              </table>
              <!--start of employment experience-->
              <table class="table table-bordered" id="des">
                <thead>
                <tr class='info'>
                  <th colspan="7"><i class="fa fa-black-tie"></i>Employment Experience</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($employment_exp)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($employment_exp as $w) { ?>
                  <tr>
                    <td colspan="7"><i>Company Name : <?php echo  $w->company_name;?></i></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Company Address</n></td>
                    <td><n class='text-danger'><?php echo $w->company_address?></n> </td>
                    <td><n class='text-success'>Company Contact</n></td>
                    <td><n class='text-danger'><?php echo $w->company_contact;?></n> </td>
                    <td><n class='text-success'>Salary </n></td>
                    <td><n class='text-danger'><?php echo $w->salary?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><n class='text-success'>Work Duration </n></td>
                    <td><n class='text-danger'><?php echo date("F d, Y", strtotime($w->date_start)); if($w->isPresentWork==1){ echo ' to <i> Present</i>'; } else{  echo ' to '.date("F d, Y", strtotime($w->date_end));  } ?></n> </td>
                    <td><n class='text-success'>Position</n></td>
                    <td><n class='text-danger'><?php echo $w->position_name?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><n class='text-success'>Reason for Leaving </n></td>
                    <td><n class='text-danger'><?php echo $w->reason_for_leaving ?></n> </td>
                    <td><n class='text-success'>Job Description</n></td>
                    <td><n class='text-danger'><?php echo $w->job_description?></n> </td>
                    <td colspan="2"></td>
                  </tr>
                <?php } } ?>
                </tbody>
              </table>
              <!--end of employment experience-->
              

              <!--start of trainings and seminar-->
              <table class="table table-bordered" id="des">
                <thead>
                <tr class='warning'>
                  <th colspan="7"><i class="glyphicon glyphicon-certificate"></i>Training and Seminars Attended</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($training_seminar)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($training_seminar as $t) { ?>
                  <tr>
                    <td colspan="7"><i>Training : <?php echo  $t->training_title; ?></i></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Training Type</n></td>
                    <td><n class='text-danger'><?php echo $t->training_type;?></n> </td>
                    <td><n class='text-success'>Sub Type </n></td>
                    <td><n class='text-danger'><?php echo $t->sub_type;?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Purpose</n></td>
                    <td><n class='text-danger'><?php echo $t->purpose;?></n> </td>
                    <td><n class='text-success'>Conducted By Type</n></td>
                    <td><n class='text-danger'><?php echo $t->conducted_by_type;?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Conducted By</n></td>
                    <td><n class='text-danger'><?php if(empty($t->fullname)){ echo $t->training_type; } else{ echo $t->fullname;}?></n> </td>
                    <td><n class='text-success'>Address</n></td>
                    <td><n class='text-danger'><?php echo $t->training_address;?></n> </td>
                  </tr>
                   <tr>
                    <td colspan="2" align='right'><n class='text-success'>Fee Type</n></td>
                    <td><n class='text-danger'><?php echo $t->fee_type;?></n> </td>
                    <td><n class='text-success'>Fee Amount</n></td>
                    <td><n class='text-danger'><?php if(empty($t->fee_amount)){ echo "not included";} else { echo number_format($t->fee_amount,2); }?></n> </td>
                  </tr>

                   <tr>
                    <td colspan="2" align='right'><n class='text-success'>Payment Status</n></td>
                    <td><n class='text-danger'><?php if(empty($t->fee_amount)){ echo "not included";} else { echo $t->payment_status; }?></n> </td>
                    <td><n class='text-success'>Required Length of Service</n></td>
                    <td><n class='text-danger'><?php if($t->fee_type=='company'){ echo $t->monthsRequired." Month/s"; } else{ echo "not included"; }?></n> </td>
                  </tr>

                  <tr>
                    <td colspan="2" align='right'><n class='text-success'><?php echo ucfirst($t->training_type);?> Date</n></td>
                    <td><n class='text-danger'><?php if($t->datefrom==$t->dateto){ echo $t->datefrom; } else{ echo "From ".$t->datefrom." until ".$t->dateto; }?></n> </td>
                    <td><n class='text-success'>Total Hours</n></td>
                    <td><n class='text-danger'><?php echo $t->total_hours;?> Hour/s</n> </td>
                  </tr>

                  
                <?php } } ?>
                </tbody>
              </table>


              <!--end of trainings and seminar-->
            
              <!--start of character references-->
              <table class="table table-bordered" id="des">
                <thead>
                <tr class='active'>
                  <th colspan="7"><i class="fa fa-users"></i>Character References</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($character_ref)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($character_ref as $c) { ?>
                  <tr>
                    <td colspan="7"><i>Reference Name : <?php echo  $c->reference_name." / ".$c->reference_position;?></i></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Company</n></td>
                    <td><n class='text-danger'><?php echo $c->reference_company?></n> </td>
                    <td><n class='text-success'>Address</n></td>
                    <td><n class='text-danger'><?php echo $c->reference_address ?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Contact No.</n></td>
                    <td><n class='text-danger'><?php echo $c->reference_contact?></n> </td>
                    <td><n class='text-success'>Reference Email</n></td>
                    <td><n class='text-danger'><?php echo $c->reference_email?></n> </td>
                  </tr>
                  
                  
                <?php } } ?>
                </tbody>
              </table>
              <!--end of character references-->
            
              <!--start of dependents-->
              <table class="table table-bordered" id="des">
                <thead>
                <tr class='success'>
                  <th colspan="7"><i class="fa fa-child"></i>Dependents</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($dependent)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($dependent as $d) {  $name=$d->first_name." ".$d->middle_name." ".$d->last_name. "".$d->name_ext."";?>
                  <tr>
                    <td colspan="7"><i>Name : <?php echo  $name;?></i></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Birthday</n></td>
                    <td><n class='text-danger'><?php echo date("F d, Y", strtotime($d->birthday));?></n> </td>
                    <td><n class='text-success'>Gender</n></td>
                    <td><n class='text-danger'><?php echo $d->gender_name ?></n> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'><n class='text-success'>Civil Status.</n></td>
                    <td><n class='text-danger'><?php echo $d->civil_status_name?></n> </td>
                    <td><n class='text-success'>Relationship</n></td>
                    <td><n class='text-danger'><?php echo $d->relationship_name?></n> </td>
                  </tr>
                  
                  
                <?php } } ?>
                </tbody>
              </table>
              <!--end of dependents-->
              <!--start of -->
              <table class="table table-bordered" id="des">
                <thead>
                <tr class='danger'>
                  <th colspan="7"><i class="glyphicon glyphicon-adjust"></i>Skills</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($skill)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ foreach ($skill as $s) { ?>
                  <tr>
                    <td colspan="7"><i>Skill Name : <?php echo  $s->skill_name;?></i></td>
                  </tr>
                  <tr>
                    <td align='center'><n class='text-success'>Description</n></td>
                    <td colspan="5"><n class='text-danger'><?php echo $s->skill_description ?></n> </td>
                  </tr>
                <?php } } ?>
                </tbody>
              </table>
              <!--end of dependents-->

               <table class="table table-bordered" id="des">
                <thead>
                <tr class='danger'>
                  <th colspan="7"><i class="fa fa-link"></i>Other/s Information</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($employee_udf)){ echo "<tr><td colspan='7'><n class='text-info'> NO DATA FOUND.</n></td></tr>";} else{ 
                  foreach ($employee_udf as $udf) { ?>
                 
                  <tr>
                    <td align='center'><n class='text-success'><?php echo $udf->udf_label?></n></td>
                    <td colspan="5"><n class='text-danger'>                         
                          <?php 
                              $data = $this->employee_201_profile_model->get_udf_data($udf->emp_udf_col_id,$this->uri->segment("4"));
                              if(count($data)==0){ $datas=''; } else{ $datas = $data->data; } 
                          ?>
                          <label><?php echo $datas?></label></n> </td>
                  </tr>
                <?php } } ?>
                </tbody>
              </table>

              </div>
          </div>
          <div  class="col-md-10" ><br>
              <button type="submit" class="btn btn-danger pull-right btn-xs" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
          <div>
     </div>
  </div>
</div>
<script type="text/javascript">
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    }
    </script>
    <style type="text/css" media="print">
     @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
    
    </style>

        </div>  
</div>

<script>
  

</script>

        </div>

        </div>
 <?php include('footer.php');?>


