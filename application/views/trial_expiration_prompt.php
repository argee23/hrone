<style type="text/css">
.blink_me {
  animation: blinker 3s linear infinite;
  color:#000;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}  
</style>
<?php
if(!empty($is_system_trial)){
    $trial_only=$is_system_trial->single_value;
}else{
    $trial_only="no";// if theres no setup default not trial system.

}
$disble_submit_button="";
$trial_countdown="";
$trial_warning="";
$cd=date('Y-m-d');

  if($trial_only=="yes"){
    if(!empty($system_trial_duration)){
      $trial_duration=$system_trial_duration->single_value;
         // to 
         list($ff,$tt) = explode(" to ",$trial_duration);
         if($tt==""){
            $trial_warning="Notice: Date End of System Free Trial Not Set!";
         }else{
            if($tt<$cd){//end of trial na
            //$trial_warning='System Free Trial Ends. Contact <img src="'.base_url().'/public/img/s_logo.png" width="10%">';
            $trial_warning='System Free Trial Ends.';
            }else{

            }


        $date1 = new DateTime($cd);
        $date2 = new DateTime($tt);
        $interval = $date1->diff($date2);
        //echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 



            if($interval->d<=14){//warning or alert in 1 week time of free trial
              if($trial_warning!=""){
                $trial_countdown=$trial_warning;
              }else{
                $trial_countdown="<span class='blink_me'>YOU HAVE ".$interval->m." Month(s) ".$interval->d." Day(s) LEFT OF FREE TRIAL.</span>";
              }
              
            }else{

            }

         }
    }else{
        $trial_duration="";
        $trial_warning="Notice: System Free Trial Duration Not Set!";
    }


    if($trial_warning!=""){
      $disble_submit_button="disabled";

    }else{
      $disble_submit_button="";
    }
if($des=="1"){

}else{

?>
    <div class="container col-md-12"  >
    <div class="panel panel-danger">
    <div class="panel-heading">
      <strong>Note: Free System Trial Duration:<br> <?php echo $trial_duration."<br><br>".$trial_countdown;?></strong>
    </div>
    </div>
    </div>

<?php


}

  }else{
    
  }

?>