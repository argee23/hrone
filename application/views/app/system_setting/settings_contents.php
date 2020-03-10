<div class="panel panel-success">

  <div class="panel-heading">
  <label>System Settings</label> 
   </div>

     <div class="panel-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Topic</th>
              <th>Module</th>
              <th>Genral Settings</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>

<?php
if(!empty($topics)){
  foreach($topics as $t){
    echo '
        <tr>
          <td>'.$t->topic.'</td>
          <td>'.$t->module.'</td>
          <td>';

  if($t->single_value_type=="yes-no" OR $t->single_value_type=="mainpage_theme"){
    //Show Web Bundy (yes-no)
    //Show Biometrics Machine Syncronizer (yes-no)
    //SMS App Table Name (input)
     echo $t->single_value;
  }else if(($t->is_single_setting=="1")AND($t->single_value_type=="specific_web_function_type")){
    //Web Bundy Functions Type
    if($t->single_value=="144"){// see system_parameters param_id : 144 
      echo "general all functions ( in & out and 3 breaks )";
    }elseif($t->single_value=="145"){// see system_parameters param_id : 145 
      echo "general in & out only";
    }elseif($t->single_value=="146"){// see system_parameters param_id : 146
      echo "general in & out, lunch break out & lunch break in";
    }elseif($t->single_value=="147"){// see system_parameters param_id : 147
      echo "individual setup"; echo " <label class='text-danger'>(Set/Manage the individual company setting at Time > Web Bundy > Web Bundy Settings)</label>";
    }else{
      echo "";
    }
  }elseif($t->single_value_type=="specific_system_trial"){
    echo $t->single_value;
  }else{

  }



    echo '</td>
          <td>';
?>
    <a href="<?php echo site_url('app/system_settings/manage_setting/'. $t->id); ?>" >
    <?php
    echo '<i class="fa fa-'.$system_defined_icons->icon_manage.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_manage_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to manage this setting"></i>';
    ?>
    </a>

<?php

    echo '
          </td>
          </tr>
    ';

  }

}else{

}
?>

          </tbody>
                  </table>

   </div>   


   
   </div> 