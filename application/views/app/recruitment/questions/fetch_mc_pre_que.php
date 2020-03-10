<table class="table table-hover table-striped">
  <tr>
    <th width="30%">Question</th>
    <th>Choices</th>
    <th width="12%">Status</th>
    <th style="text-align: right;width: 10%;">Option</th>
  </tr>
  <?php 
if(!empty($mc_preQueList)){
   foreach($mc_preQueList as $mc_pre_ques){
?>
<tr style="<?php if($mc_pre_ques->InActive=="1"){ ?>color: #B62304;<?php }else{}?>">
    <td><?php echo $mc_pre_ques->question;?></td>
    <td>
<?php 
if($mc_pre_ques->InActive=="0"){  
?>    
  <a onclick="addMCPreQue_choice(<?php echo $mc_pre_ques->id;?>)" class="" title="Click to Add Choice"><i class="fa fa-plus"></i></a><br> 
     
<?php
}else{
  // not allowed to add choices if question is already disabled
}


$id=$mc_pre_ques->id;
$choice_list=$this->general_model->mc_preque_choiceList($id);

if(!empty($choice_list)){
  foreach($choice_list as $cl){ 
    echo "<li class='text-success'>".$cl->mc_choice;
if($mc_pre_ques->InActive=="0"){

        $edit = '<i class="fa fa-pencil-square-o fa-sm text-primary"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editMCPreQue_choice('.$cl->mc_id.')"></i>';

        $delete = anchor('app/recruitment/delete_mc_pre_que_choice/'.$cl->mc_id,'<i class="fa fa-times-circle fa-sm text-danger delete" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$mc_pre_ques->question."? : ".$cl->mc_choice." ')"));


      if($cl->mc_InActive=="0"){
             echo '&nbsp;&nbsp;<a href="'.base_url().'app/recruitment/disable_mc_choice/'.$cl->mc_id.'/'.$mc_pre_ques->id.'"  data-toggle="tooltip" data-placement="left" title="Disable --> '.$cl->mc_choice.' ?"><i class="fa fa-power-off text-success"></i></a>&nbsp;&nbsp;'.$edit."&nbsp;".$delete."</li>";
      }else{
             echo '&nbsp;&nbsp;<a href="'.base_url().'app/recruitment/enable_mc_choice/'.$cl->mc_id.'/'.$mc_pre_ques->id.'"  data-toggle="tooltip" data-placement="left" title="Enable --> '.$cl->mc_choice.' ?"><i class="fa fa-power-off text-danger"></i></a>&nbsp;&nbsp;'.$edit."&nbsp;".$delete."</li>";
      }



}else{  // not allowed to manage choices if question is already disabled
 }   
  }

}else{ echo "<span class='text-danger'>no choices added for this question yet.</span>";}

?>
    </td>
    <td><?php if($mc_pre_ques->InActive=="0"){ 
        echo '<a href="'.base_url().'app/recruitment/disable_mc_pre_que/'.$mc_pre_ques->id.'"  data-toggle="tooltip" data-placement="left" title="Disable --> '.$mc_pre_ques->question.' " role="button" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; enabled';
        }else {
        echo '<a href="'.base_url().'app/recruitment/enable_mc_pre_que/'.$mc_pre_ques->id.'"  data-toggle="tooltip" data-placement="left" title="Enable --> '.$mc_pre_ques->question.' " role="button" class="btn btn-success btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; disabled';
           } ?></td>
    <td>
    <?php 
        $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editMCPreQue('.$mc_pre_ques->id.')"></i>';
        $delete = anchor('app/recruitment/delete_mc_pre_que/'.$mc_pre_ques->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$mc_pre_ques->question."?')"));
   
    if($mc_pre_ques->InActive=="1"){ }else{  echo $edit. $delete; }
    ?>
    </td>
 </tr>
<?php
}
}else{
?>
  <tr>
    <td colspan="4">No Mulitple Choice Questions List yet.</td>
  </tr>
<?php
}
 ?>
  </table>