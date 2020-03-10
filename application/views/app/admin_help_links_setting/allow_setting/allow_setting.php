<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Settings | <?php echo $company_name;?>

</h4></ol>
<div class="col-md-12" ><br>
  
  <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/system_help_link_settings/save_allow_settings/<?php echo $company;?>" >
    <div class="col-md-12">
        <table id="table1" class="table table-hover">
            <thead>
                <tr class="danger">
                    <th>ID</th>
                    <th>Portal</th>
                    <th>Allow to View System Help</th>
                    <th>Allow to View Quick Links</th>
                </tr>
            </thead>
            <tbody>
              <?php $i = 1; foreach($portal_list as $p){
                if($p->portal_id==3 || $p->portal_id==4){} else{
                $value = $this->system_help_link_settings_model->get_allow_setting_value($p->portal_id,$company);
              ?>
                  <tr>
                    <td><?php echo $p->portal_id;?></td>
                    <td><?php echo $p->portal;?></td>
                    <td>
                        <select class="form-control" style="width: 100%;" name="system_help<?php echo $p->portal_id;?>">
                         <option value="0" <?php if(empty($value->allow_system_help) || $value->allow_system_help==0){ echo "selected"; }?>>No</option>
                         <option value="1" <?php if(!empty($value->allow_system_help) AND $value->allow_system_help=='1'){ echo "selected"; } ?>>Yes</option>
                       
                        </select>
                    </td>
                    <td>
                        <select class="form-control" style="width: 100%;" name="quick_links<?php echo $p->portal_id;?>">
                          <option value="0" <?php if(empty($value->allow_quick_links) || $value->allow_quick_links==0){ echo "selected"; }?>>No</option>
                          <option value="1" <?php if(!empty($value->allow_quick_links) AND $value->allow_quick_links=='1'){ echo "selected"; } ?>>Yes</option>
                        </select>
                    </td>
                  </tr>
              <?php $i++;  } }?>
            </tbody>
        </table>
    </div>

    <div class="col-md-3 pull-right" style="margin-top: 30px;">
        <?php if(!empty($portal_list)){ ?> <button class="col-md-12 btn btn-success"> <i class="fa fa-check"></i>SAVE SETTING</button> <?php  } 
        else { echo "No portal found."; }?>
    </div>
  </form>
</div>  
<div class="btn-group-vertical btn-block"> </div>   
     