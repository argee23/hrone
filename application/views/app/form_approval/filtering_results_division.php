<?php 
 /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $clear_all_from_approver=$this->session->userdata('clear_all_from_approver');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
if(empty($resultss)) { echo "<h1 class='text-danger'>No Department added in this company</h1> "; } else { foreach ($resultss as $d) {
  ?>

<table class="table table-bordered table-striped">
              <thead>
                <tr  class="info">
                   <th colspan="7"><n class="text-danger" style="font-weight:bold;">Department: </n><n><b><?php echo  $d->dept_name?></b></n>
                   <n class='<?php echo $clear_all_from_approver;?> pull-right'><i class='btn btn glyphicon glyphicon-remove'  onclick="delete_applocclassdiv_all('<?php echo $company?>','<?php echo $d->department_id?>','<?php echo $identification?>','department','<?php echo $location?>','<?php echo $classification?>','<?php echo $division?>')"></i>[Delete Approvers in this department]</n></th>
                 </tr>
              </thead>  
              <tbody>
              <?php $section = $this->form_approval_model->filtering($d->department_id,'department_id','section');
                if(empty($section)){ echo "<tr class='text-success'><td colspan='2'></td><td colspan='3' class='text-danger'>No Section/s yet.</td></tr>";} else { foreach ($section as $s) { 
                ?>
                <tr class="danger">
                <td colspan="7" style="width:20%;" class='text-info'><i><b> <n class='text-danger'>Section:</n> <?php echo $s->section_name?></b></i>
                 <a class='<?php echo $clear_all_from_approver;?> pull-right' style='cursor: pointer;' onclick="delete_applocclassdiv_all('<?php echo $company?>','<?php echo $s->section_id?>','<?php echo $identification?>','section','<?php echo $location?>','<?php echo $classification?>','<?php echo $division?>')">[Delete Approvers in this section]</a></td>
                </tr>
                <?php $subsection = $this->form_approval_model->filtering($s->section_id,'section_id','subsection'); ?>
                <tr class='success'>
                
                  <td colspan="2">Subsection</td>
                  <td style="width:15%;color: black;">Level </td>
                  <td style="width:25%;color: black;">Employee Name </td>
                  <td style="width:15%;color: black;">Classification </td>
                  <td style="width:10%;color: black;">Location </td>
                  <td style="width:5%;color: black;">Action </td>
                </tr>
                <?php 

                  $division = $d->division_id;
                  $department = $d->department_id;
                  $section = $s->section_id;
                  $subsection = '0';
                $approver_data = $this->form_approval_model->approver_data_filter_classification($identification,$d->company_id,$division,$department,$section,$subsection,$location,$classification); 
                if(empty($approver_data)){ echo "<tr class='text-success'><td colspan='2'></td><td colspan='3' class='text-danger'>No Approver/s yet.</td></tr>"; }else{
                   foreach ($approver_data as $a) {
                      $approver_details = $this->form_approval_model->approver_details_filter($a->id);
                       foreach ($approver_details as $det) {
                        $sub_namee = $this->form_approval_model->sub_namee($det->sub_section); 
                ?>
                <tr>
                  <td colspan="2"><n class="text-danger">For</n>[<n class="text-primary"><?php if(empty($sub_namee)){ echo "No subsection"; } else{ echo $sub_namee; }?></n>] </td>
                  <td><?php $x = $det->approval_level;
                    if($x=="1"){
                      $ext="st";
                    }else if($x=="3"){
                      $ext="rd";
                    }else if($x=="2"){
                      $ext="nd";
                    }else{
                      $ext="th";
                    } echo $x.$ext." Approver"?></td>
                  <td><?php echo "[".$det->employee_id."]".$det->fullname?></td>
                  <td><?php echo "for ".$det->classification?></td>
                  <td><?php echo "for ".$det->location_name?></td>
                  <td><i class='<?php echo $clear_all_from_approver;?> btn btn fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor: pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="delete_applocclassdiv_all('<?php echo $company?>','<?php echo $a->id?>','<?php echo $identification?>','id','<?php echo $location?>','<?php echo $classification?>','<?php echo $division?>')"></i></td>
                </tr>
              <?php } } } } }?>
                
              </tbody>
            </table>
<?php echo "<div class='col-md-12' style='border:1px solid gray;margin-bottom:10px;'></div>"; }}?>