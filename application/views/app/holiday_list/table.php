<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$disable_enable_holiday=$this->session->userdata('disable_enable_holiday');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<thead>
                  <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Holiday</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($holiday_list as $holiday_list){if($holiday_list->holiday_InActive == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($holiday_list->holiday_InActive == 1){echo 'class="text-danger"';}else{echo 'class="text-success"';} ?>>

             <td><?php echo $holiday_list->hol_id?></td> 
                 <td><?php echo $holiday_list->year ?></td> 
                    <td><?php echo $holiday_list->holiday?></td>
                    <td><?php echo 
                        date("F", mktime(0, 0, 0, $holiday_list->month, 10)).
                        "&nbsp;". $holiday_list->day;?></td>
                    <td ><?php 

                   $code_type = $this->holiday_list_model->get_holiday_type_string($holiday_list->type);
                  foreach($code_type as $string_type){ 
                    echo $string_holiday=$string_type->cValue;
                  }

                   ?></td>
                    <td > 
<!-- //==================================================================================== -->

                  <?php 

                 // $data = $this->holiday_list_model->getBranches();
                  foreach($locationList as $row){ 

                  $data2 = $this->holiday_list_model->check_if_holiday_is_applicable($row->location_id,$holiday_list->hol_id);

                  if (!empty($data2)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }


                  $branch =$row->location_name;
                  echo "<input type='checkbox'".$applicable.">&nbsp;".$branch."<br>";        

                  }

                  ?>  
<!-- //==================================================================================== -->
                    </td>
                    <td><?php echo $inactive ?></td> 
                    <td>

                    <?php 


       echo $en_dis = anchor('app/holiday_list/activate_holiday/'.$holiday_list->hol_id,'<i class="'.$disable_enable_holiday.'fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to activate ".$holiday_list->holiday." ?')"));


                    ?>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>