<table class="table table-hover table-striped">
  <tr>
    <th>Question</th>
    <th>Correct Answer</th>
    <th width="15%">Status</th>
    <th style="text-align: right;width: 10%;">Option</th>
  </tr>
  <?php 
if(!empty($qualifying_questionsList)){
   foreach($qualifying_questionsList as $qq){
?>
<tr style="<?php if($qq->InActive=="1"){ ?>color: #B62304;<?php }else{}?>">
    <td><?php echo $qq->question;?></td>
    <td><?php if($qq->correct_ans=="1"){ echo "yes";}elseif($qq->correct_ans=="0"){echo "no";}else{ echo "no correct answer setup yet.";} ;?></td>
    <td><?php if($qq->InActive=="0"){ 
        echo '<a href="'.base_url().'app/recruitment/disable_qua_que/'.$qq->id.'"  data-toggle="tooltip" data-placement="left" title="Disable --> '.$qq->question.' " role="button" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; enabled';
        }else {
        echo '<a href="'.base_url().'app/recruitment/enable_qua_que/'.$qq->id.'"  data-toggle="tooltip" data-placement="left" title="Enable --> '.$qq->question.' " role="button" class="btn btn-success btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; disabled';
           } ?></td>
    <td>
    <?php 
        $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editQuaQue('.$qq->id.')"></i>';
        $delete = anchor('app/recruitment/delete_qua_que/'.$qq->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$qq->question."?')"));
   
    if($qq->InActive=="1"){ }else{  echo $edit. $delete; }
    ?>
    </td>
 </tr>
<?php
}
}else{
?>
  <tr>
    <td colspan="4">No Qualifying Questions List yet.</td>
  </tr>
<?php
}
 ?>
    
 


  </table>