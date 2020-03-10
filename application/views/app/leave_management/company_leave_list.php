<?php $company_id= $this->uri->segment('4');

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $edit_leave_type_cutoff=$this->session->userdata('edit_leave_type_cutoff');
    $manage_leave_type_setting=$this->session->userdata('manage_leave_type_setting');
    $view_employees_under_leave_type_conditions=$this->session->userdata('view_employees_under_leave_type_conditions');
   
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */

?>

     <table id="companyleavelist" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Leave Type</th>          
                    <th><a title="This will be the basis of employee leave credits deduction coverage.">Fiscal Year</a></th>
                    <th>Credits Type</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                  
 if(!empty($default_leave_type)){
  foreach ($default_leave_type as $sys_def) {

    echo '
    <tr>
      <td> '.$sys_def->leave_type.' </td>
      <td> '.$sys_def->cutoff.' </td>
      <td> Automatic Credits Base on Approved OT </td>

      <td> System Default';

    echo '<a href="'.base_url().'app/leave_management/leave_manage_manual_credit/'.$sys_def->id.'/'.$company_id.'" title="Check Earned '.$sys_def->leave_type.' From approved OT">
<i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>
   </a>';
      echo '</td>
    </tr>
    ';
  

  }
 }else{

 }


                  foreach($leave_type as $leave_type){if($leave_type->IsDisabled == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($leave_type->IsDisabled == 1){echo 'class="text-danger"';}else{echo 'class="text-success"';} ?>>
                    <td ><?php echo $leave_type->leave_type?></td>                   
                    <td><?php 
                    
                        if($leave_type->cutoff=="yearly"){  
                            echo "<span title='Calendar Year : Jan 1 to Dec 31'>".$leave_type->cutoff."</span>";
                        }elseif($leave_type->cutoff=="date_hired"){  
                            echo "Employee's Hired Date";

                        }elseif($leave_type->cutoff !="yearly"){  
                              //01/01-12/31                  
                              $string_start_month = substr($leave_type->cutoff, 0, -9); 
                              $substr_start_day = substr($leave_type->cutoff, 3, -6);     

                              $string_end_month = substr($leave_type->cutoff, 6, -3); 
                              $substr_end_day = substr($leave_type->cutoff,  -2);

                              echo date("F", mktime(0, 0, 0, $string_start_month, 10))."&nbsp;".$substr_start_day." to ".
                              date("F", mktime(0, 0, 0, $string_end_month, 10))."&nbsp;".$substr_end_day;  

                        }else{
                              echo $leave_type->cutoff;
                        }
                        ?>
                    </td>
                   <td <?php 
                   if($leave_type->is_manual_credit>0){ echo 'class="bg-primary"';}else{echo 'class="bg-success"';} 
                   ?>>
                   <?php 
                   if($leave_type->is_manual_credit>0){ echo "Manual Credit Entry";}else{echo "Automatic Credits";} 
                   ?>                    
                   </td> 
                    <td>

                    <?php 
                     // foreach ($companyList as $comp){
                        //echo $comp->company_name;
                    if($leave_type->IsDisabled == 0){ 
                    
    echo    $edit = '<i class="'.$edit_leave_type_cutoff.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit Fiscal Year And Credits Type" onclick="editLeave('.$leave_type->id.')"></i>';  

if($leave_type->is_manual_credit>0){
      if($view_employees_under_leave_type_conditions=="hidden "){

         echo '<a title="Not Allowed to Manage Credits. Check Access Rights.">
        <i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:#ccc;"></i>
        </a>'; 
     }else{
 

         echo '<a href="'.base_url().'app/leave_management/leave_manage_manual_credit/'.$leave_type->id.'/'.$leave_type->company_id.'" title="Manually Encode/Check Employee Credits">
        <i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>
        </a>';  


      }



}else{
  
    echo    $manage = '<i class="'.$manage_leave_type_setting.' fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_manage_color.';" data-toggle="tooltip" data-placement="left" title="Click to Manage Automatic Condition of '.$leave_type->leave_type.' " onclick="leave_manage_condition('.$leave_type->id.','.$company_id.')"></i>';
}


                         
                          $check_class_setting = $this->leave_management_model->check_if_leave_type_has_assigned_class_settings($leave_type->id);
                          $check_emp_setting = $this->leave_management_model->check_if_leave_type_has_assigned_emp_settings($leave_type->id);
                          $check_loc_setting = $this->leave_management_model->check_if_leave_type_has_assigned_loc_settings($leave_type->id);

                          if (!empty($check_class_setting) AND !empty($check_emp_setting) AND !empty($check_loc_setting) ){
                           //can view employees under leave 

                          echo    $view_credits = anchor('app/leave_management/details/'.$leave_type->id.'/view/'.$leave_type->company_id,'<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Click to View Employees/Credits Under '.$leave_type->leave_type.' ','onclick'=>"return confirm('Are you sure you want to View leave type?')"));

                 
                          }else{
                           //cannot view employees under leave  

if($leave_type->is_manual_credit>0){
}else{

                                    echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:#999;" " data-toggle="tooltip" data-placement="left" title="Leave Type: '.$leave_type->leave_type.' : Has No Automatic Credit Setup. "></i>';
}



             
                          }  


 if($leave_type->is_manual_credit>0){
    if($view_employees_under_leave_type_conditions=="hidden "){
        echo '<i class="fa fa-upload fa-'.$system_defined_icons->icon_size.'x" style="color:#ccc;" " data-toggle="tooltip" data-placement="left" title="Not Allowed to Manage Credits. Check Access Rights." ></i>';
    }else{
        echo '<i class="fa fa-upload fa-'.$system_defined_icons->icon_size.'x" style="color:#5E0461;" " data-toggle="tooltip" data-placement="left" title="Manual Upload Leave Credits for : '.$leave_type->leave_type.'. " onclick="dl_upl_leavecredit('.$leave_type->id.','.$company_id.')"></i>&nbsp;';
        
        echo '<a href="'.base_url().'app/leave_management/download_leave_template/" ><i class="fa fa-download fa-'.$system_defined_icons->icon_size.'x" style="color:#C8C81C;" " data-toggle="tooltip" data-placement="right" title="Download Leave Template"></i></a> ';

    }

 }else{

 } 
 




                          }else{


                            echo "Leave Type was disabled in Administrator > Leave Type";

                          }




                        echo "<br>";
                      //}


                     ?>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>