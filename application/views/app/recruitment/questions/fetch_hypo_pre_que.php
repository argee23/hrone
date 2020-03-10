<table class="table table-hover table-striped">
  <tr>
    <th>Question</th>
    <th width="15%">Status</th>
    <th style="text-align: right;width: 10%;">Option</th>
  </tr>
  <?php 
if(!empty($hypothetical_preQueList)){
   foreach($hypothetical_preQueList as $hypo_pre_ques){
?>
<tr style="<?php if($hypo_pre_ques->InActive=="1"){ ?>color: #B62304;<?php }else{}?>">
    <td><?php echo $hypo_pre_ques->question;?></td>
    <td><?php if($hypo_pre_ques->InActive=="0"){ 
        echo '<a href="'.base_url().'app/recruitment/disable_hypo_pre_que/'.$hypo_pre_ques->id.'"  data-toggle="tooltip" data-placement="left" title="Disable --> '.$hypo_pre_ques->question.' " role="button" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; enabled';
        }else {
        echo '<a href="'.base_url().'app/recruitment/enable_hypo_pre_que/'.$hypo_pre_ques->id.'"  data-toggle="tooltip" data-placement="left" title="Enable --> '.$hypo_pre_ques->question.' " role="button" class="btn btn-success btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; disabled';
           } ?></td>
    <td>
    <?php 
        $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editHypoPreQue('.$hypo_pre_ques->id.')"></i>';
        $delete = anchor('app/recruitment/delete_hypo_pre_que/'.$hypo_pre_ques->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$hypo_pre_ques->question."?')"));
   
    if($hypo_pre_ques->InActive=="1"){ }else{  echo $edit. $delete; }
    ?>
    </td>
 </tr>
<?php
}
}else{
?>
  <tr>
    <td colspan="4">No hypothetical Questions List yet.</td>
  </tr>
<?php
}
 ?>
  </table>