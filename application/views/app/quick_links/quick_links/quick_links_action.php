<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
<?php foreach($details as $d){ echo $d->portal." | ".$d->module; }?>

<button class="btn btn-danger btn-xs pull-right" style="margin-right: 5px;" onclick="show_hide_system_help('actionn_add');">Filter</button>


</h4></ol>
<div class="col-md-12"><br>

  
 
  <div class="col-md-12" id="actionn_add" style="display: none;">
        <div class="col-md-3"></div>
          <div class="col-md-6" id="actionnn">

            <div class="col-md-12">
               <select class="form-control" name="topic" required onchange="get_sub_topic_list(this.value,'subtopic_add');">
               <?php if(empty($topic)){ echo "<option value=''>No Topic found</option>"; } else{?>
                  <option value="">Select Topic</option>
                  <option value="All">All</option>
                  <?php foreach($topic as $t){?>
                    <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                  <?php } }?>
               </select>
            </div>
          </div>
          <div class="col-md-3"></div>
      
  </div>


  <div class="col-md-12" style="margin-top: 20px;" id="system_help_file_maintenance_view">
        <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Topic</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($quick_links as $ql){
              // if($ql->portal_id==1)
              // {
            	 // if(empty($this->session->userdata($ql->table))){ $checker = true; }
              //  else { $checker =false; }
              // }
              // else if($ql->portal_id==2)
              // {
              //     if($ql->topic=='Form Approval')
              //     {
              //        if($this->session->userdata('is_form_approver')){ $checker=true; } else{ $checker=false;}
              //     }
              //     else if($ql->topic == 'Notification Approval'){ if($this->session->userdata('is_notification_approver')){ $checker=true; } else{ $checker=false;} }
              //     else if($ql->topic=='Salary Approval'){ if($this->session->userdata('is_salary_approver')){ $checker=true; } else{ $checker=false;} }
              // }
              // else
              // {
              //   $checker = true;
              // }

              // if($checker==1){
              
              ?>
         
                <tr>
                    <td><?php echo $ql->id;?></td>
                    <td><?php echo $ql->topic;?></td>
                    <td>
                        <a href="<?php echo base_url().$ql->link;?>" target="_blank">Access link</a> 
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>    
  </div>    
</div>  
<div class="btn-group-vertical btn-block"> </div>   
     
   
    