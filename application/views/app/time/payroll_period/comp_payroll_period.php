<?php $company_id=$this->uri->segment('4');

/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$view_emp_group=$this->session->userdata('view_emp_group');
$add_emp_group=$this->session->userdata('add_emp_group');
$enable_disable_emp_group=$this->session->userdata('enable_disable_emp_group');
$edit_emp_group=$this->session->userdata('edit_emp_group');
$delete_emp_group=$this->session->userdata('delete_emp_group');
$check_emp_group=$this->session->userdata('check_emp_group');

$add_pay_period=$this->session->userdata('add_pay_period');
$edit_pay_period=$this->session->userdata('edit_pay_period');
$delete_pay_period=$this->session->userdata('delete_pay_period');

/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/
?>
      <div class="box box-info">
        <div class="box-header">
        <a onclick="add(<?php echo $company_id;?>)" type="button"  class="<?php echo $add_pay_period;?>btn btn-default btn-xs pull-right">
<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i> Add Payroll Period';
?>
        </a>

<a class="<?php echo $view_emp_group;?> btn btn-default btn-xs pull-right" data-toggle="collapse" href="#collapse_manage_pp" aria-expanded="false" aria-controls="collapseExample">
<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_manage_color.';" "></i> Manage Payroll Period Employee Groups';
?>
                       
</a>
        </div>
        <div class="box-body">

<div class="col-md-12 collapse" id="collapse_manage_pp">
  <div class="panel panel-info">
    <div class="panel-heading"><strong>Payroll Period Employee Groups</strong>
    <?php

     $add = '<a onclick="add_pay_per_group('.$company_id.')" type="button" class="'.$add_emp_group.'btn btn-sm btn-default pull-right" title="Add Employee Groups"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>';
    echo $add.' ';
     ?>
     <a href="#myModal" data-toggle="modal" id="<?php echo $this->uri->segment("4"); ?>" data-target="#view_employee">

     <?php
     echo '<i  class="'.$check_emp_group.'fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_view_color.';" " data-placement="left" title="View to Check Employee Group Details"></i>';
     ?>

<!--     <i  class="fa fa-user fa-2x text-success pull-right" class="hidden"  data-toggle="tooltip" data-placement="left" title="View employee"></i> -->


    </a>
     </div>
      <div class="panel-body">

<div class="col-md-6" id="add_pay_per_group">
<!-- add payroll period group-->
</div>

    <table id="" class="table table-bordered table-striped">
      <thead>
      <tr>
      <th >Pay Type</th>
      <th >Group Name</th>
      <th >Group Description</th>
      <th >Current Status</th>
      <th >Option</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($pay_per_group as $my_pp_group){
if($my_pp_group->InActive=="1"){
  $background_color="background-color:#DBDBDA;";
}else{
  $background_color="";
}
        ?>
      <tr>

      <td ><?php echo $my_pp_group->pay_type_name; ?></td>
      <td><?php echo $my_pp_group->group_name; ?></td>
      <td><?php echo nl2br($my_pp_group->group_description); ?></td>
      <td>
      <?php 
          if($my_pp_group->InActive=="0"){ 
            echo 'active';
          }else {
            echo 'deactivated';
          } 
      ?> 
      </td>
      <td>
      <?php
      $view = null;
      $edit = null;
      $delete= null;
      if($my_pp_group->InActive=="0"){ 
        echo '<a href="'.base_url().'app/time_payroll_period/deactivate_group/'.$my_pp_group->payroll_period_group_id.'"  title="Click To Deactivate/Disable : '.$my_pp_group->group_name.' " role="button" class="'.$enable_disable_emp_group.'btn btn-default btn-xs"><i class="fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_disable_color.';""></i></a>&nbsp;&nbsp; ';
        }else {
        echo '<a href="'.base_url().'app/time_payroll_period/activate_group/'.$my_pp_group->payroll_period_group_id.'"  title="Click To Activate/Enable : '.$my_pp_group->group_name.' " role="button" class="'.$enable_disable_emp_group.'btn btn-default btn-xs"><i class="fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_enable_color.';""></i></a>&nbsp;&nbsp; ';
       } 

      $view = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "  data-toggle="tooltip" data-placement="left" title="Click To View Employee(s) Enrolled To This Group" onclick="view_employee_period_group('.$my_pp_group->payroll_period_group_id.')"></i>';
      
      if($my_pp_group->InActive==0){
        
        $edit = '<i class="'.$edit_emp_group.'fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" "  data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_payroll_period_group('.$my_pp_group->payroll_period_group_id.')"></i>';

         $delete = anchor('app/time_payroll_period/delete_group/'.$my_pp_group->payroll_period_group_id,'<i class="'.$delete_emp_group.'fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" " ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$my_pp_group->group_name."?')"));     
      }



       echo $view.'  '.$edit.' '.$delete; 

      ?>



      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>  
      </div>
  </div>
</div>


<!-- <div class="col-md-4" id="col_2">
add payroll period
</div> -->


        <div class="table-responsive">

                <input type="hidden" id="current_company" value="<?php echo $company_id?>">

<!-- //=============== start filter options -->
                 <div class="col-md-2">
                        <div class="form-group">
                          <label for="company">Cover Year</label>
                          <select class="form-control" name="year_cover" id="year_cover" style="width: 100%;" onchange="fetch_payroll_period_year(this.value);">

                            <?php
                                if(!empty($oldestPayPeriod)){
                                  $startyear = $oldestPayPeriod->year_cover;
                                  $current_year=date("Y");
                                  $next_year=$current_year+1;
                                  echo '<option selected="selected" value="'.$current_year.'">-All-</option>';
                                    for($i =$next_year; $i >= $startyear ;$i--){

                                      if($this->uri->segment("5") == $i){
                                          $selected = "selected='selected'";
                                      }else{
                                          $selected = "";
                                      } 

                                       echo '<option value='.$i.' '.$selected.'>'.$i.'</option>';

                                    }
                                }else{
                                   $current_year=date("Y");
                                  echo '<option selected="selected" value="'.$current_year.'">-All-</option>';
                                }
                            ?>
                           
                          </select>
                        </div>
                  </div>
                 <div class="col-md-6">
                        <div class="form-group">
                          <label for="company">Payroll Period Group</label>
                          <select class="form-control" name="pay_period_group" id="pay_period_group" style="width: 100%;" onchange="fetch_payroll_period_group(this.value);">
                            <option selected="selected" value="">-All-</option>
                            <?php
                            foreach($pay_per_group as $my_pp_group){

                                     if($this->uri->segment("6") == $my_pp_group->payroll_period_group_id){
                                          $selected = "selected='selected'";
                                      }else{
                                          $selected = "";
                                      } 

                              echo '<option value='.$my_pp_group->payroll_period_group_id.' '.$selected.'>'.$my_pp_group->group_name.'</option>'; //
                            }

                            ?>                 
                          </select>
                        </div>
                  </div>
<!-- //=============== end filter options -->

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td>Group</td>
                  <td>Pay Type</td>
                  <td>Cut-Off</td>
         <!--          <td>Pay Code</td> -->
                  <td>Date From - Date To</td>
                  <td>Cut-Off Day</td>
                  <td>Covered Year/Month</td>
                  <td>No. of Days</td>
                  <td>Pay Date</td>
                  <td>Description</td>
                  <td>Option</td>
                </tr>
              </thead>
              <tbody>
              <?php 
              if(!empty($pay_per)){
              foreach($pay_per as $pay_period){?>
                <tr>
                <td><?php echo $pay_period->group_name; ?></td>
                   <td><?php 
                   if($pay_period->pay_type=="1"){
                    echo "Weekly";
                   }else if($pay_period->pay_type=="2"){
                    echo "Bi - Weekly";
                   }else if($pay_period->pay_type=="3"){
                    echo "Semi - Monthly";
                   }else if($pay_period->pay_type=="4"){
                    echo "Monthly";
                   }else{
                    echo "pay type incorrect.";
                   }
                   ?></td>
<td><?php
if($pay_period->cut_off=="1"){
  $extension="st";
}else if($pay_period->cut_off=="2"){
  $extension="nd";
}else if($pay_period->cut_off=="3"){
  $extension="rd";
}else if($pay_period->cut_off=="4"){
  $extension="th";
}else if($pay_period->cut_off=="5"){
  $extension="th";
}else{
  $extension="";
}
echo $pay_period->cut_off.$extension. " cut off"; ?></td>                   
    <!--                <td><?php //echo $pay_period->pay_code;?></td> -->
                   <td><?php 
echo "<span class='text-danger'>Payroll Period ID: ".$pay_period->id."</span><br>";
                   echo $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 

echo " to<br> ". $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
                   ?></td>

                   
                   <td><?php echo $pay_period->cut_off_day; ?></td>
                   <td><?php echo "year cover: ".$pay_period->year_cover."<br> month cover: ". date("F", mktime(0, 0, 0, $pay_period->month_cover, 10)); ?></td>

                   <td><?php echo $pay_period->no_of_days; ?></td>
                   <td><?php //echo $pay_period->pay_date;

                  $pd_y= substr($pay_period->pay_date, 0,4); //pay date year
                  $pd_m= substr($pay_period->pay_date, 5,2); //pay date month
                  $pd_d= substr($pay_period->pay_date, 8,2); //pay date day
                  //pay date
                  echo $pd= date("F", mktime(0, 0, 0, $pd_m, 10))." ".$pd_d." ".$pd_y;
                   ?></td>
                   <td><?php echo $pay_period->description;?></td>
                   <td><?php 

           echo $edit = '<i class="'.$edit_pay_period.'fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_payroll_period('.$pay_period->id.')"></i>';


           echo anchor('app/time_payroll_period/delete_payroll_period/'.$pay_period->id,'<i class="'.$delete_pay_period.'fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$df." to ".$dt." Payroll Period?')"));

            ?></td>
                </tr>
                 <?php }
                 }
                 else{ ?>  
                 <tr>
                   <td >-</td>
                   <td >-</td>
                   <td>-</td>
                   <td>-</td>
                   <td>-</td>
                   <td align="center" class="text-danger"><i class="fa fa-warning"></i></td>
                   <td align="center" class="text-danger"> no payroll period yet.</td>
                   <td>-</td>
                   <td>-</td>
                   <td>-</td>
                   <td>-</td>
                   <td>-</td>
                 </tr>
                 <?php } ?>
              </tbody>
            </table>       
        </div>





        </div>
      </div>

<!-- Modal to view employee with no group -->
<div id="view_employee" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="box box-success">
    <div class="panel panel-success">
    <div class="panel-heading"><strong>LIST OF EMPLOYEE(S)</strong>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
      </button>
    </div>
    </div>

    <div class="box-body">
    <div class="modal-body">

      <div class="col-md-12">
      <table class="table datatable table-bordered">
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Pay type </th>
            <th>Location / Classification </th>
            <th>Group Name</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
         <?php 
         foreach($employee_company_available as $employee){ 
              $company_id=$employee->company_id;
              $location=$employee->location; //location id
              $classification=$employee->classification; //classification id
              require(APPPATH.'views/include/loc_class_restriction.php');

          if($allowed>0){ // check this variable at loc_class_restriction
          ?>
          <tr>
            <td style="color:#ff0000;" ><?php echo $employee->employee_id; ?> </td>
            <td style="color:#ff0000;" ><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
            <td style="color:#ff0000;" ><?php echo $employee->pay_type_name; ?></td>
            <td style="color:#ff0000;" ><?php echo $employee->location."/".$employee->classification; ?></td>
            <td style="color:#ff0000;" >No Assigned Group</td>
            <td></td>
          </tr>
          <?php 

          }else{

          }

        }
          foreach($employee_company_unavailable as $employee){ 
              $company_id=$employee->company_id;
              $location=$employee->location; //location id
              $classification=$employee->classification; //classification id
              require(APPPATH.'views/include/loc_class_restriction.php');
          if($allowed>0){ // check this variable at loc_class_restriction
            ?>
          <tr>
            <td><?php echo $employee->employee_id; ?> </td>
            <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
            <td><?php echo $employee->pay_type_name;?></td>
            <td><?php echo $employee->location."/".$employee->classification;?></td>
            <td><?php echo $employee->group_name; ?></td>
            <?php if($employee->InActive === '1'){ ?>
            <td style="color:#ff0000;">InActive</td>
            <?php } ?>
            <?php if($employee->InActive === '0'){ ?>
            <td>Active</td>
            <?php } ?>
          </tr>
          <?php 
        }else{

        }

          } ?>
        </tbody>
      </table>
      </div>

    </div>
    </div><!-- /.box-body -->

</div>
</div>
</div>
<!-- End  Modal to view employee with no group -->