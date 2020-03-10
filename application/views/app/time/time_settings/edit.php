<?php 

$topic_id= $this->uri->segment('4');
$company_id= $this->uri->segment('5');

if($ts_topic->with_by_classification=="1"){
?>
 <div class="box box-danger">
        <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>

<select name="" id="min" class="form-control" width="5%" onChange="all_c();" >
<?php $hr=0; while($hr!=185){?>
		<option value="<?php echo $hr;?>"><?php echo $hr;?></option>
		<?php $hr+=5;}?>
</select>
</div>
        <div class="box-body">
<div class="table-responsive">
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_by_classification_and_employment/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

<?php
//===========night differential 0.13%
if($ts_topic->time_setting_id=="3"){

  echo '<div class="form-group">
  <label for="advanceType" class="col-sm-2 control-label">Time </label>
        <div class="col-sm-10">
  <select style="width:30%;" name="night_diff_time_from"  >
            <option value="'.$ts_topic->night_diff_time_from.'">'.$ts_topic->night_diff_time_from.'</option>';
$hr=1; while($hr!=25){
       echo '<option value="'.sprintf("%02d", $hr).':00">'.sprintf("%02d", $hr).':00</option>';
 $hr++;}
          echo '</select>';  
   echo' To
        <select style="width:30%;" name="night_diff_time_to" >
            <option value="'.$ts_topic->night_diff_time_to.'">'.$ts_topic->night_diff_time_to.'</option>';
$hr=1; while($hr!=25){
       echo '<option value="'.sprintf("%02d", $hr).':00">'.sprintf("%02d", $hr).':00</option>';
 $hr++;}
          echo '</select>
</div></div>
            ';

}else if($ts_topic->time_setting_id=="8"){

//===========regular night differential 

  echo '<div class="form-group">
  <label for="advanceType" class="col-sm-2 control-label">Time </label>
        <div class="col-sm-10">
  <select style="width:30%;" name="reg_night_diff_time_from"  >
            <option value="'.$ts_topic->reg_night_diff_time_from.'">'.$ts_topic->reg_night_diff_time_from.'</option>';
$hr=1; while($hr!=25){
       echo '<option value="'.sprintf("%02d", $hr).':00">'.sprintf("%02d", $hr).':00</option>';
 $hr++;}
          echo '</select>';  
   echo' To
        <select style="width:30%;" name="reg_night_diff_time_to" >
            <option value="'.$ts_topic->reg_night_diff_time_to.'">'.$ts_topic->reg_night_diff_time_to.'</option>';
$hr=1; while($hr!=25){
       echo '<option value="'.sprintf("%02d", $hr).':00">'.sprintf("%02d", $hr).':00</option>';
 $hr++;}
          echo '</select>
</div></div>
            ';
}else{

}
//===========

?>
      <table class="table table-hover table-striped">
      <thead>
        <tr>
          <td>Classification </td>
         <?php 
         foreach($employmentList as $employment){
          echo '<td>'.$employment->employment_name.'</td>';
         }//employment
         ?>   
        </tr>
      </thead>
      <tbody>
       <?php 
            foreach($myclassificationList as $cl){     
/*+++*/         $class_id=$cl->classification_id;      
        ?>
        <tr >
          <td><?php echo $cl->classification;?></td>
          <?php 
         foreach($employmentList as $employment){
/*+++*/         $employment_id=$employment->employment_id;

        $get_setting = $this->time_settings_model->get_settings_value2($topic_id,$class_id, $employment_id,$company_id);
          if(!empty($get_setting)){
              foreach($get_setting as $setting){
               $setting_value= $setting->setting_value;
              }
          }else{
            $setting_value= "no setting";
          }
$no_of_classifications= count($myclassificationList);
$no_of_employement= count($employmentList);

$total_no=$no_of_classifications * $no_of_employement;

echo '<td>';
//========
if(($ts_topic->time_setting_id=="1") OR ($ts_topic->time_setting_id=="2") OR ($ts_topic->time_setting_id=="4") OR ($ts_topic->time_setting_id=="71")){
echo '<select name="'.$class_id.$employment_id.'"  class="to" id="'.$total_no.'">
            <option value="'.$setting_value.'">'.$setting_value.'</option>';
              $hr=0; while($hr!=181){
       echo '<option>'.$hr.'</option>';
  $hr++;}
echo '</select>';  

}else if(($ts_topic->time_setting_id=="3") OR ($ts_topic->time_setting_id=="6") OR ($ts_topic->time_setting_id=="7") OR ($ts_topic->time_setting_id=="8") OR ($ts_topic->time_setting_id=="40")  OR ($ts_topic->time_setting_id=="43") OR ($ts_topic->time_setting_id=="44")  OR ($ts_topic->time_setting_id=="48") OR ($ts_topic->time_setting_id=="49")  OR ($ts_topic->time_setting_id=="50") OR ($ts_topic->time_setting_id=="51") OR ($ts_topic->time_setting_id=="52")  OR ($ts_topic->time_setting_id=="53")  OR ($ts_topic->time_setting_id=="54") OR ($ts_topic->time_setting_id=="55") OR ($ts_topic->time_setting_id=="28") OR ($ts_topic->time_setting_id=="33") ){
//========
echo '<select name="'.$class_id.$employment_id.'"  class="to">
            <option value="'.$setting_value.'">'.$setting_value.'</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>';

//========
}else if(($ts_topic->time_setting_id=="37")) {

echo '<select name="'.$class_id.$employment_id.'"  class="to">
            <option value="'.$setting_value.'">'.$setting_value.'</option>';
$hr=0;
 while($hr<=8){
  
    echo '<option value="'.$hr.'">'.$hr.' hrs</option>';
     $hr+=0.5;
    }
echo '</select>';


}else if(($ts_topic->time_setting_id=="59")) {

echo '<input type="text" name="'.$class_id.$employment_id.'" style="width:80px;" value="'.$setting_value.'"> ';

}else if(($ts_topic->time_setting_id=="70")) {
    $minimum_hrs = $this->time_settings_model->get_minimum_hours_minutes($company_id,'time_settings_minimum_hours_mins');
    $get_setting = $this->time_settings_model->get_settings_value2($topic_id,$class_id, $employment_id,$company_id);
    if(!empty($get_setting) && $get_setting!='no_setting'){
              foreach($get_setting as $setting){
               $setting_value= $setting->setting_value;
              }
    }else
        {
            $setting_value= "no_setting";
        }

?>
      <select name="<?php echo $class_id.$employment_id;?>">
          <option value="no_setting">no setting</option>
          <?php foreach($minimum_hrs as $mn){?>
              <option value="<?php echo $mn->total;?>" <?php if($setting_value==$mn->total){ echo "selected"; }?> ><?php echo $mn->total;?></option>
          <?php } ?>
      </select>   
<?php } else{

}




}//employment
         ?>  
        </tr>
          <?php 
            }//myclassificationList
            ?>

            </tbody>  
      </table>



          <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>

 </form>     
      </div>


		</div>
</div>
<?php } else{ echo '';}?>

<!--//=======================================with single field settings  -->
<?php 
if($ts_topic->with_single_field_setting=="1"){
?>
<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
<!--//=======================================*Time Computation (by) -->
<?php if($ts_topic->time_setting_id=="9"){  ?>      
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
<input type="hidden" name="setting" value="na">
<?php

$t_from=substr($ts_topic->single_field_setting, 0,5);
$t_to=substr($ts_topic->single_field_setting, -5,5);

 echo ' <select style="width:30%;" name="ot_nd_time_from"  >
            <option value="'.$t_from.'">'.$t_from.'</option>';
            echo '<option disabled>&nbsp;</otpion>';
$hr=1; while($hr!=25){
       echo '<option value="'.sprintf("%02d", $hr).':00">'.sprintf("%02d", $hr).':00</option>';
 $hr++;}
          echo '</select>';  
   echo' To
        <select style="width:30%;" name="ot_nd_time_to" >
            <option value="'.$t_to.'">'.$t_to.'</option>';
             echo '<option disabled>&nbsp;</otpion>';
$hr=1; while($hr!=25){
       echo '<option value="'.sprintf("%02d", $hr).':00">'.sprintf("%02d", $hr).':00</option>';
 $hr++;}
          echo '</select>';

?>


          </div>
        </div>
          <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>
<!--//=======================================*Over Time filing -->
<?php }else if($ts_topic->time_setting_id=="10"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="filing">
            <option value="<?php echo $ts_topic->overtime_filing;?>"><?php echo $ts_topic->overtime_filing;?></option>
            <option value="0" disabled=""></option>
            <option value="general">general</option>
            <!-- <option value="single_and_by_batch">single filing and by batch filing</option> -->
            <option value="by_group">by group</option>
            
              
            </select>
          </div>
        </div>        
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>"><?php echo $ts_topic->single_field_setting;?></option>
            <option value="0" disabled=""></option>
            <option value="by_group">by group</option>
            <option value="advance">advance</option>
            <option value="late">late</option>
            <option value="pre_approve">pre_approve</option>
              
            </select>
          </div>
        </div>

                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>
<!--//=======================================*Allowing of supervisor before filing of over time -->
<?php }else if($ts_topic->time_setting_id=="11"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>"><?php echo $ts_topic->single_field_setting;?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
              
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>   

<!--//=======================================*Number of days per year -->
<?php }else if($ts_topic->time_setting_id=="12"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>      


<!--//=======================================*day(s) allowance  for late approved leave transaction -->
<?php }else if($ts_topic->time_setting_id=="13" OR ($ts_topic->time_setting_id=="69")){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>        

<!--//=======================================*Start of Overtime -->
<?php }else if($ts_topic->time_setting_id=="70"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

<select name="setting" id="min" class="form-control" width="5%">
<?php $hr=0; while($hr!=185){
if($hr==$ts_topic->single_field_setting){
  $sel="selected";
}else{
  $sel="";
}


  ?>
    <option value="<?php echo $hr;?>" <?php echo $sel;?> >After <?php echo $hr;?> Minutes From Shift Out</option>
    <?php $hr+=5;}?>
</select>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>        


<!--//=======================================*Number of hours daily -->
<?php }else if($ts_topic->time_setting_id=="14"){ ?>  
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>           

<!--//=======================================*DTR decimal place -->
<?php }else if($ts_topic->time_setting_id=="56"){ ?>  
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>           


<!--//=======================================*Number of days monthly -->
<?php }else if($ts_topic->time_setting_id=="15"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>         


<!--//=======================================*Number of hours to count tardiness as half day absent -->
<?php }else if($ts_topic->time_setting_id=="16"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>         


<!--//=======================================*Number of hours to count under time as half day absent -->
<?php }else if($ts_topic->time_setting_id=="17"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>         


<!--//=======================================*Machine attendance option -->
<?php }else if($ts_topic->time_setting_id=="18"){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="FILO"){
echo "First IN Last OUT";
            }else if($ts_topic->single_field_setting=="FIFO"){
echo "First IN First OUT";
            }else if($ts_topic->single_field_setting=="LIFO"){
echo "Last IN First OUT";
            }else if($ts_topic->single_field_setting=="LILO"){
echo "Last IN Last OUT";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="FILO">First IN Last OUT</option>
            <option value="FIFO">First IN First OUT</option>
            <option value="LIFO">Last IN First OUT</option>
            <option value="LILO">Last IN Last OUT</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>   


<!--//=======================================*Over time filing -->
<?php }else if($ts_topic->time_setting_id=="19"){ ?>  


<!--//=======================================*No work shedule treatment -->
<?php }else if($ts_topic->time_setting_id=="20"){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="mark_as_absent"){
echo "mark as absent";
            }else if($ts_topic->single_field_setting=="no_absent_but_no_reg_hour_work"){
echo "no absent but no reg work";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="mark_as_absent">mark as absent</option>
            <option value="no_absent_but_no_reg_hour_work">no absent but no reg work</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>         


<!--//=======================================*Allow employee to view DTR -->
<?php }else if($ts_topic->time_setting_id=="21"){ ?>       
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="1_dtr_view"){
echo "YES";
            }else if($ts_topic->single_field_setting=="2_dtr_view"){
echo "After posting of payroll";
            }else if($ts_topic->single_field_setting=="3_dtr_view"){
echo "NO";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="1_dtr_view">YES</option>
            <option value="2_dtr_view">After posting of payroll</option>
            <option value="3_dtr_view">No</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>           


<!--//=======================================*Regular Holiday hours allocation -->
<?php }else if($ts_topic->time_setting_id=="22"){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="1_reg_hol_hrs_alloc"){
echo "will add to regular hours work";
            }else if($ts_topic->single_field_setting=="2_reg_hol_hrs_alloc"){
echo "will NOT add to regular hours work";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="1_reg_hol_hrs_alloc">will add to regular hours work</option>
            <option value="2_reg_hol_hrs_alloc">will NOT add to regular hours work</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>               


<!--//=======================================*Filing of leave on half day regular schedule treatment -->
<?php }else if($ts_topic->time_setting_id=="24"){ ?>      
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
           echo $ts_topic->single_field_setting;
            
            ?> day</option>
            <option value="0" disabled=""></option>
            <option value="1">1 day</option>
            <option value="0.5">0.5 day</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                  
           


<!--//=======================================*Allow web bundy attendance -->
<?php }else if($ts_topic->time_setting_id=="29"){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
           echo $ts_topic->single_field_setting;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                   


<!--//=======================================*Advance DTR computation -->
<?php }else if($ts_topic->time_setting_id=="30"){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="yes_absent_adv_dtr_comp"){
echo "Yes (mark as absent)";
            }else if($ts_topic->single_field_setting=="yes_present_adv_dtr_comp"){
echo "Yes (mark as present";
            }else if($ts_topic->single_field_setting=="no_adv_dtr_comp"){
echo "NO";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes_absent_adv_dtr_comp">Yes (mark as absent</option>
            <option value="yes_present_adv_dtr_comp">Yes (mark as present</option>
            <option value="no_adv_dtr_comp">NO</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                 


<!--//=======================================*
31: Required Actual Hrs rendered of halfday employees 
32:
-->
<?php }else if($ts_topic->time_setting_id=="31" OR $ts_topic->time_setting_id=="32"){ ?>      
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-12" >
          <input type="number" class="form-control" step="0.01" name="setting" value="<?php echo $ts_topic->single_field_setting?>">
<!--             <select class="form-control select2" name="setting">
            <option value="<?php //echo $ts_topic->single_field_setting;?>">
            <?php 
//             if($ts_topic->single_field_setting=="1_attendance_flagging"){
// echo "use in/out code";
//             }else if($ts_topic->single_field_setting=="2_attendance_flagging"){
// echo "automatic";
//             }else{
// echo "code not found";
//             }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="1_attendance_flagging">use in/out code</option>
            <option value="2_attendance_flagging">automatic</option>
            </select> -->
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                   

<!--//=======================================*time summary separate leave hours to regular hours -->
<?php //}else if($ts_topic->time_setting_id=="32"){ ?>   
<!--         <form class="form-horizontal" name="f1" method="post" action="<?php //echo base_url()?>app/time_settings/modify/<?php //echo $ts_topic->time_setting_id;?>/<?php// echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php// echo $ts_topic->single_field_setting;?>">
            <?php 
           //echo $ts_topic->single_field_setting;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php //echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
          //  echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>     -->               
   


<!--//=======================================*Rest day falling on Regular Hol. w/o attendance -->
<?php // }else if($ts_topic->time_setting_id=="33"){ ?>       
<!--         <form class="form-horizontal" name="f1" method="post" action="<?php //echo base_url()?>app/time_settings/modify/<?php //echo $ts_topic->time_setting_id;?>/<?php //echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php //echo $ts_topic->single_field_setting;?>">
            <?php 
//             if($ts_topic->single_field_setting=="1_rd_on_reg_hol_wo_attendance"){
// echo "add another column for rest day regular holiday without attendance type 2";
//             }else if($ts_topic->single_field_setting=="2_rd_on_reg_hol_wo_attendance"){
// echo "add to regular hours";
//             }else{
// echo "code not found";
//             }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="1_rd_on_reg_hol_wo_attendance">add another column for rest day regular holiday without attendance type 2</option>
            <option value="2_rd_on_reg_hol_wo_attendance">add to regular hours</option>
            </select>
          </div>
        </div>
      
        </form>         -->            


<!--//=======================================*ATRO allow late filing -->
<?php }else if($ts_topic->time_setting_id=="34"){ ?>   
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <input type="text" onkeydown="return isNumeric(event.keyCode);" name="setting" class="form-control" value="<?php echo $ts_topic->single_field_setting;?>">
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>      
   


<!--//=======================================*web bundy type -->
<?php }else if($ts_topic->time_setting_id=="35"){ ?>          
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="1_web_bundy_type"){
echo "3 function buttons";
            }else if($ts_topic->single_field_setting=="2_web_bundy_type"){
echo "8 function buttons";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="1_web_bundy_type">3 function buttons</option>
            <option value="2_web_bundy_type">8 function buttons</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                    


<!--//=======================================*show actual hours on DTR -->
<?php }else if($ts_topic->time_setting_id=="36"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
           echo $ts_topic->single_field_setting;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                    


<!--//=======================================*automatic over time option -->
<?php }else if($ts_topic->time_setting_id=="38"){ ?>          
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="1_aut_ot_option"){
echo "automatic file OT";
            }else if($ts_topic->single_field_setting=="2_aut_ot_option"){
echo "built in OT + employee file";
            }else{
echo "code not found";
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="1_aut_ot_option">automatic file OT</option>
            <option value="2_aut_ot_option">built in OT + employee file</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                    
  


<!--//=======================================*Training OT (ATRO form filing from RD to REG OT) -->
<?php }else if($ts_topic->time_setting_id=="39"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
           echo $ts_topic->single_field_setting;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>     

<!--//=======================================*day(s) allowance  for late approved leave transaction (from date reference) -->
<?php }else if($ts_topic->time_setting_id=="58"){ ?>    
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
           echo $ts_topic->single_field_setting;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="cutoff start date">cutoff start date</option>
            <option value="payroll process date">payroll process date</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                      

<!--//=======================================*Late deduction minus the grace period -->
<?php }else if(($ts_topic->time_setting_id=="41") OR ($ts_topic->time_setting_id=="45") OR ($ts_topic->time_setting_id=="48") OR ($ts_topic->time_setting_id=="57")){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
           echo $ts_topic->single_field_setting;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                     

<!--//=======================================*DTR Absences occurence composition -->
<?php }else if($ts_topic->time_setting_id=="68"){ ?>     
        <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >
        <div class="form-group"   >
            <label for="" class="col-sm-4 control-label"></label>
          <div class="col-sm-8" >
            <select class="form-control select2" name="setting">
            <option value="<?php echo $ts_topic->single_field_setting;?>">
            <?php 
            if($ts_topic->single_field_setting=="ao_actual_total_absent"){
            echo "Actual DTR total absent value";
            }
            else if($ts_topic->single_field_setting=="ao_wholeday_absent"){
            echo "Count whole day absences only";
            }
            else if($ts_topic->single_field_setting=="ao_wholeday_halfday_absent"){
            echo "Count whole day & halfday absent ( will count 0.5 absent as +1 occurence not as occurence +0.5 occurence )";
            }else{
            echo $ts_topic->single_field_setting;
            }   

            ?></option>
            <option value="0" disabled=""></option>
            <option value="ao_actual_total_absent">same with actual total absent value</option>
            <option value="ao_wholeday_absent">whole day absent only</option>
            <option value="ao_wholeday_halfday_absent">whole day & halfday absent ( will count 0.5 absent as +1 occurence not as occurence +0.5 occurence )</option>
            </select>
          </div>
        </div>
                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
        </form>                     


<!--//=======================================*Ignore if id not exist -->
<?php }else{} ?>
      </div><!--//end box- body -->
</div><!--//end box- danger -->



<?php }else{ echo '';}?>

<!--//=======================================process employee with date hired on current period -->
<?php 
//datehired_on_cur_period_sts : process employee with date hired on current period SAVE TIME SUMMARY (sts)
//datehired_on_cur_period_dwa : process employee with date hired on current period MARK DAYS W/O ATTENDANCE (dwa)
if(($ts_topic->datehired_on_cur_period_sts<>"not_included")AND($ts_topic->datehired_on_cur_period_dwa<>"not_included")) {
?>
<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
 <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_process_emp_with_datehired_on_cur_period/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">save time summary </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="datehired_on_cur_period_sts">
            <option value="<?php echo $ts_topic->datehired_on_cur_period_sts;?>">
            <?php 
           echo $ts_topic->datehired_on_cur_period_sts;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
        </div>
    </div>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">mark days not yet hired as</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="datehired_on_cur_period_dwa">
            <option value="<?php echo $ts_topic->datehired_on_cur_period_dwa;?>">
            <?php 
           echo $ts_topic->datehired_on_cur_period_dwa;
            ?></option>
            <option value="0" disabled=""></option>
            <option value="absent">absent</option>
            <option value="not_paid_not_absent">not paid but not counted as absent</option>
            <option value="paid">paid</option>
            </select>
        </div>
    </div>

                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
</form>
</div>
</div>

<?php }else{echo '';}?>        
<!--//=======================================absent before the holiday -->
<?php 
//regular_holiday_multi_policy : absent before the regular holiday
//snw_holiday_multi_policy : absent before the special holiday
if(($ts_topic->regular_holiday_multi_policy<>"not_included")AND($ts_topic->snw_holiday_multi_policy<>"not_included")) {
?>
<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
 <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_absent_bef_holiday/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

<?php
if($ts_topic->time_setting_id=="25" OR $ts_topic->time_setting_id=="60" OR $ts_topic->time_setting_id=="61" OR $ts_topic->time_setting_id=="62" OR $ts_topic->time_setting_id=="63" OR $ts_topic->time_setting_id=="64"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">Regular Holiday </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="regular_holiday_multi_policy">
            <option value="<?php echo $ts_topic->regular_holiday_multi_policy;?>">
            <?php 
           echo $ts_topic->regular_holiday_multi_policy;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="absent">absent</option>
            <option value="paid">paid</option>
            </select>
        </div>
    </div>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">Special Holiday</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="snw_holiday_multi_policy">
            <option value="<?php echo $ts_topic->snw_holiday_multi_policy;?>">
            <?php 
           echo $ts_topic->snw_holiday_multi_policy;
            ?></option>
            <option value="0" disabled=""></option>
            <option value="absent">absent</option>
            <option value="paid">paid</option>
            </select>
        </div>
    </div>

<?php
}else if($ts_topic->time_setting_id=="65"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label"><span style="color:#ff0000">working day </span>: regular holiday<br> next day : regular day </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="regular_holiday_multi_policy">
            <option value="<?php echo $ts_topic->regular_holiday_multi_policy;?>">
            <?php 
            if($ts_topic->regular_holiday_multi_policy=="att_ot_followInDate"){
              echo 'Follow type of day of "IN" date( for attendance and OT)';
            }elseif($ts_topic->regular_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo 'Follow Actual Date( OT type falls on "IN" Date )';
            }elseif($ts_topic->regular_holiday_multi_policy=="att_ot_actual"){
              echo 'Follow Actual Date( for attendance and OT)';
            }else{
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="att_ot_followInDate" style="color:#ff0000">Follow type of day of "IN" date( for attendance and OT)</option>
            <option value="att_actual_otBaseIsInDate">Follow Actual Date( OT type falls on "IN" Date )</option>
            <option value="att_ot_actual">Follow Actual Date( for attendance and OT)</option>
            </select>
        </div>
    </div>
    <br><br><br>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : regular day<br><span style="color:#ff0000">next day </span>: regular holiday</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="snw_holiday_multi_policy">
            <option value="<?php echo $ts_topic->snw_holiday_multi_policy;?>">
            <?php 
            if($ts_topic->snw_holiday_multi_policy=="att_ot_followInDate"){
              echo 'Follow type of day of "IN" date( for attendance and OT)';
            }elseif($ts_topic->snw_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo 'Follow Actual Date( OT type falls on "IN" Date )';
            }elseif($ts_topic->snw_holiday_multi_policy=="att_ot_actual"){
              echo 'Follow Actual Date( for attendance and OT)';
            }else{
            }           
            ?>
            </option>
            <option value="0" disabled=""></option>
            <option value="att_ot_followInDate" style="color:#ff0000">Follow type of day of "IN" date( for attendance and OT)</option>
            <option value="att_actual_otBaseIsInDate">Follow Actual Date( OT type falls on "IN" Date )</option>
            <option value="att_ot_actual">Follow Actual Date( for attendance and OT)</option>
            </select>
        </div>
    </div>

<?php
}else if($ts_topic->time_setting_id=="66"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label"><span style="color:#ff0000">working day </span>: special non-working holiday<br> next day : regular day </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="regular_holiday_multi_policy">
            <option value="<?php echo $ts_topic->regular_holiday_multi_policy;?>">
            <?php 
            if($ts_topic->regular_holiday_multi_policy=="att_ot_followInDate"){
              echo 'Follow type of day of "IN" date( for attendance and OT)';
            }elseif($ts_topic->regular_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo 'Follow Actual Date( OT type falls on "IN" Date )';
            }elseif($ts_topic->regular_holiday_multi_policy=="att_ot_actual"){
              echo 'Follow Actual Date( for attendance and OT)';
            }else{
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="att_ot_followInDate" style="color:#ff0000">Follow type of day of "IN" date( for attendance and OT)</option>
            <option value="att_actual_otBaseIsInDate">Follow Actual Date( OT type falls on "IN" Date )</option>
            <option value="att_ot_actual">Follow Actual Date( for attendance and OT)</option>
            </select>
        </div>
    </div>
    <br><br><br>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : regular day<br><span style="color:#ff0000">next day </span>: special non-working holiday</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="snw_holiday_multi_policy">
            <option value="<?php echo $ts_topic->snw_holiday_multi_policy;?>">
            <?php 
            if($ts_topic->snw_holiday_multi_policy=="att_ot_followInDate"){
              echo 'Follow type of day of "IN" date( for attendance and OT)';
            }elseif($ts_topic->snw_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo 'Follow Actual Date( OT type falls on "IN" Date )';
            }elseif($ts_topic->snw_holiday_multi_policy=="att_ot_actual"){
              echo 'Follow Actual Date( for attendance and OT)';
            }else{
            }           
            ?>
            </option>
            <option value="0" disabled=""></option>
            <option value="att_ot_followInDate" style="color:#ff0000">Follow type of day of "IN" date( for attendance and OT)</option>
            <option value="att_actual_otBaseIsInDate">Follow Actual Date( OT type falls on "IN" Date )</option>
            <option value="att_ot_actual">Follow Actual Date( for attendance and OT)</option>
            </select>
        </div>
    </div>


<?php
}else if($ts_topic->time_setting_id=="67"){
?>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label"><span style="color:#ff0000">working day </span>: special non-working holiday<br> next day : regular holiday </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="regular_holiday_multi_policy">
            <option value="<?php echo $ts_topic->regular_holiday_multi_policy;?>">
            <?php 
            if($ts_topic->regular_holiday_multi_policy=="att_ot_followInDate"){
              echo 'Follow type of day of "IN" date( for attendance and OT)';
            }elseif($ts_topic->regular_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo 'Follow Actual Date( OT type falls on "IN" Date )';
            }elseif($ts_topic->regular_holiday_multi_policy=="att_ot_actual"){
              echo 'Follow Actual Date( for attendance and OT)';
            }else{
            }
            ?></option>
            <option value="0" disabled=""></option>
            <option value="att_ot_followInDate" style="color:#ff0000">Follow type of day of "IN" date( for attendance and OT)</option>
            <option value="att_actual_otBaseIsInDate">Follow Actual Date( OT type falls on "IN" Date )</option>
            <option value="att_ot_actual">Follow Actual Date( for attendance and OT)</option>
            </select>
        </div>
    </div>
    <br><br><br>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">working day : regular holiday<br><span style="color:#ff0000">next day </span>: special non-working holiday</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="snw_holiday_multi_policy">
            <option value="<?php echo $ts_topic->snw_holiday_multi_policy;?>">
            <?php 
            if($ts_topic->snw_holiday_multi_policy=="att_ot_followInDate"){
              echo 'Follow type of day of "IN" date( for attendance and OT)';
            }elseif($ts_topic->snw_holiday_multi_policy=="att_actual_otBaseIsInDate"){
              echo 'Follow Actual Date( OT type falls on "IN" Date )';
            }elseif($ts_topic->snw_holiday_multi_policy=="att_ot_actual"){
              echo 'Follow Actual Date( for attendance and OT)';
            }else{
            }           
            ?>
            </option>
            <option value="0" disabled=""></option>
            <option value="att_ot_followInDate" style="color:#ff0000">Follow type of day of "IN" date( for attendance and OT)</option>
            <option value="att_actual_otBaseIsInDate">Follow Actual Date( OT type falls on "IN" Date )</option>
            <option value="att_ot_actual">Follow Actual Date( for attendance and OT)</option>
            </select>
        </div>
    </div>
    
<?php
}else{

}
?>    

                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
</form>
</div>
</div>

<?php }else{echo '';}?> 
<!--//=======================================COUNTING OF NO. OF DAYS/ REGULAR DAYS PRESENT(AUTO ADDITION/DEDUCTION FORMULA REFERENCE) -->
<?php 
//countdays_present_option: counting option
//countdays_present_rd: count if present on rest day
//countdays_present_rh: count if present on regular holiday
//countdays_present_sh: count if present on special holiday
//countdays_present_lwp: count if present on leave with pay

//countdays_not_present_rd: count if NOT present on rest day
//countdays_not_present_rh: count if NOT present on regular holiday
//countdays_not_present_sh: count if NOT present on special holiday
//countdays_not_present_lwp: count if NOT present on leave with pay

if(($ts_topic->countdays_present_option<>"not_included")
  AND($ts_topic->countdays_present_rd<>"not_included")
  AND($ts_topic->countdays_present_rh<>"not_included")
  AND($ts_topic->countdays_present_sh<>"not_included")
  AND($ts_topic->countdays_present_lwp<>"not_included")
  AND($ts_topic->countdays_not_present_rd<>"not_included")
  AND($ts_topic->countdays_not_present_rh<>"not_included")
  AND($ts_topic->countdays_not_present_sh<>"not_included")
  AND($ts_topic->countdays_not_present_lwp<>"not_included")) {
?>
<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
 <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_days_counting/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading"><strong> counting option </strong>
      </div>
       <div class="panel-body">
          <div class="form-group"   >
          <div class="col-sm-12" >
            <select class="form-control select2" name="countdays_present_option">
            <option value="<?php echo $ts_topic->countdays_present_option;?>">
             <?php if($ts_topic->countdays_present_option=="1"){echo "always count 1 on present";}else{ echo "count only 0.5 on half day";} ?></option>
            <option value="0" disabled=""></option>
            <option value="1">always count 1 on present</option>
            <option value="0.5">count only 0.5 on half day</option>
            </select>
          </div>
          </div>
    </div>
  </div>
</div>
  <div class="col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading"><strong> count if present on </strong>
      </div>
       <div class="panel-body">
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Rest Day</label>
            <div class="col-sm-4" >
            <input name="countdays_present_rd" type="checkbox" <?php if($ts_topic->countdays_present_rd=="on"){ echo "checked";}else{echo "";}  ?>  >
            </div>
            </div>

            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Regular Holiday</label>
            <div class="col-sm-4" >
            <input name="countdays_present_rh" type="checkbox" <?php if($ts_topic->countdays_present_rh=="on"){ echo "checked";}else{echo "";}  ?> >
            </div>
            </div>
      
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Special Holiday</label>
            <div class="col-sm-4" >
            <input name="countdays_present_sh" type="checkbox" <?php if($ts_topic->countdays_present_sh=="on"){ echo "checked";}else{echo "";}  ?> >
            </div>
            </div>
    
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Leave with pay</label>
            <div class="col-sm-4" >
            <input name="countdays_present_lwp" type="checkbox" <?php if($ts_topic->countdays_present_lwp=="on"){ echo "checked";}else{echo "";}  ?> >
            </div>
            </div>
       </div>
      </div>
      </div>
 <div class="col-md-6">
    <div class="panel panel-danger">
      <div class="panel-heading"><strong> count if NOT present on</strong>
      </div>
       <div class="panel-body">
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Rest Day</label>
            <div class="col-sm-4" >
            <input name="countdays_not_present_rd" type="checkbox" <?php if($ts_topic->countdays_not_present_rd=="on"){ echo "checked";}else{echo "";}  ?>  >
            </div>
            </div>

            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Regular Holiday</label>
            <div class="col-sm-4" >
            <input name="countdays_not_present_rh" type="checkbox" <?php if($ts_topic->countdays_not_present_rh=="on"){ echo "checked";}else{echo "";}  ?> >
            </div>
            </div>
  
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Special Holiday</label>
            <div class="col-sm-4" >
            <input name="countdays_not_present_sh" type="checkbox" <?php if($ts_topic->countdays_not_present_sh=="on"){ echo "checked";}else{echo "";}  ?>  >
            </div>
            </div>
   
            <div class="form-group"   >
            <label for="single_field_setting" style="text-align: right;" class="col-sm-8 control-label">Leave with pay</label>
            <div class="col-sm-4" >
            <input name="countdays_not_present_lwp" type="checkbox" <?php if($ts_topic->countdays_not_present_lwp=="on"){ echo "checked";}else{echo "";}  ?> >
            </div>
            </div>
       </div>
      </div>
      </div>

          <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
</form>
      </div>
</div>



<?php }else{echo '';}?> 
<!--//=======================================Rest day auto match schedule-->
<?php 
//countdays_present_option: counting option

if(($ts_topic->rd_auto_match_sched_allow<>"not_included")
  AND($ts_topic->rd_auto_match_sched_base_sched_at<>"not_included")
  AND($ts_topic->rd_auto_match_sched_match_at<>"not_included")) {
?>

<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
 <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_rd_auto_match_sched/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">allow schedule matching </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="rd_auto_match_sched_allow">
            <option value="<?php echo $ts_topic->rd_auto_match_sched_allow;?>">
            <?php if($ts_topic->rd_auto_match_sched_allow=="1"){echo "YES";}else{echo "NO";} ?></option>
            <option value="0" disabled=""></option>
            <option value="1">yes</option>
            <option value="0">no</option>
            </select>
        </div>
    </div>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">base schedule at</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="rd_auto_match_sched_base_sched_at">
            <option value="<?php echo $ts_topic->rd_auto_match_sched_base_sched_at;?>">
            <?php if($ts_topic->rd_auto_match_sched_base_sched_at=="actual_in"){echo "Actual IN";}else{echo "actual OUT";} ?></option>
<!--             <option value="0" disabled=""></option>
            <option value="actual_in">Actual IN</option>
            <option value="actual_out">actual OUT</option> -->
            </select>
        </div>
    </div>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">match at</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="rd_auto_match_sched_match_at">
            <option value="<?php echo $ts_topic->rd_auto_match_sched_match_at;?>">
           <?php if($ts_topic->rd_auto_match_sched_match_at=="rd_hol_shift_table"){echo "Rest day auto match schedule references";}else{echo "Regular Shift Table";} ?></option>
<!--             <option value="0" disabled=""></option>
            <option value="rd_hol_shift_table">Rest Day/Holiday Shift Table Reference</option>
            <option value="reg_shift_table">Regular Shift Table</option> -->
            </select>
        </div>
    </div>

                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
</form>
</div>
</div>

<?php }else{echo '';}?>        
<!--//======================================= -->





<!--//=======================================Case treated as halfday by the system due to count undertime as halfday absent policy  -->
<?php 
//ut_display_to_dtr : display undertime on dtr for representation purpose ?
//ut_include_to_occurence : add to counting of undertime occurrence ?
if(($ts_topic->ut_display_to_dtr<>"not_included")AND($ts_topic->ut_include_to_occurence<>"not_included")) {
?>
<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
 <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_case_ut_treated_as_halfday/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">display undertime on dtr for representation purpose ? </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="ut_display_to_dtr">
            <option value="<?php echo $ts_topic->ut_display_to_dtr;?>">
            <?php 
           echo $ts_topic->ut_display_to_dtr;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
        </div>
    </div>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-12 control-label text-danger">note: if above is set to no "(add to counting of undertime occurrence ?) as below will be forcely set to "no" as well. </label>
      </div>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">add to counting of undertime occurrence ?</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="ut_include_to_occurence">
            <option value="<?php echo $ts_topic->ut_include_to_occurence;?>">
            <?php 
           echo $ts_topic->ut_include_to_occurence;
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
        </div>
    </div>

                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
</form>
</div>
</div>

<?php }else{echo '';}?>        

<!--//=======================================Case treated as halfday by the system due to count late as halfday absent policy -->
<?php 
//late_display_to_dtr : display late on dtr for representation purpose ?
//late_include_to_occurence : add to counting of late occurrence ?
if(($ts_topic->late_display_to_dtr<>"not_included")AND($ts_topic->late_include_to_occurence<>"not_included")) {
?>
<div class="box box-danger">
    <div class="box-header"><strong> Edit
         <?php echo $ts_topic->time_setting_topic;?></strong>
    </div>
      <div class="box-body">
 <form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/time_settings/modify_case_late_treated_as_halfday/<?php echo $ts_topic->time_setting_id;?>/<?php echo $company_id;?>" >

    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">display late on dtr for representation purpose ? </label>
        <div class="col-sm-8" >
            <select class="form-control select2" name="late_display_to_dtr">
            <option value="<?php echo $ts_topic->late_display_to_dtr;?>">
            <?php 
           echo $ts_topic->late_display_to_dtr;
            
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
        </div>
    </div>
    <div class="form-group"   >
      <label for="single_field_setting" style="text-align: right;" class="col-sm-12 control-label text-danger">note: if above is set to no "(add to counting of late occurrence ?) as below will be forcely set to "no" as well. </label>
      </div>
    <div class="form-group">
      <label for="single_field_setting" style="text-align: right;" class="col-sm-4 control-label">add to counting of late occurrence ?</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="late_include_to_occurence">
            <option value="<?php echo $ts_topic->late_include_to_occurence;?>">
            <?php 
           echo $ts_topic->late_include_to_occurence;
            ?></option>
            <option value="0" disabled=""></option>
            <option value="yes">yes</option>
            <option value="no">no</option>
            </select>
        </div>
    </div>

                  <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
          ?>

          </button>
</form>
</div>
</div>

<?php }else{echo '';}?>        


