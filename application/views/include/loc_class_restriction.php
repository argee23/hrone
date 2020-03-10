<?php
if($this->session->userdata('user_role')=="serttech"){//if serttech account
  $allowed=1;
}else{
        $loc_role=$this->general_model->check_location_restriction($company_id,$location);
        if(!empty($loc_role)){
         $loc_allowed=1;
        }else{
         $loc_allowed=0;
        }

        $class_role=$this->general_model->check_classification_restriction($company_id,$classification);
        if(!empty($class_role)){
                if($loc_allowed>0){
                  $allowed=1;
                }else{
                  $allowed=0;
                }
        }else{
                $allowed=0;
        }

}
?>