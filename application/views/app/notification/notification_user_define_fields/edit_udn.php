<div class="row">
<div class="col-md-7">

 <?php 

        $company_id = $this->uri->segment('4');
    //echo $company_id."UDN ni NEMZ";
        $current_comp=$this->notification_user_define_fields_model->get_company($company_id);
         if(!empty($current_comp)){
             $company_name = $current_comp->company_name;
         }else{
             $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>

<div class="box box-danger">
<div class="panel panel-danger">
     <div class="panel-heading"><strong>Edit</strong><strong> (<?php echo $company_name; ?>) </strong></div>

<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/notification_user_define_fields/modify_udn_new/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
        

        <input type="hidden"  name="company_id" id="company_id" placeholder="Company ID" value="<?php echo $user_define_edit->company_id; ?>"  required>
        <input type="hidden"  name="tudf_identifier" id="tudf_identifier" placeholder="Form tudf_identifier" value="<?php echo $user_define_edit->tudf_identifier; ?>"  required> 




      <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="fname" id="fname" placeholder="Form name" value="<?php echo $user_define_edit->form_name ?>" required>
        </div>
      </div>

        <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text"  class="form-control" name="fdesc" id="fdesc" placeholder="Form description" value="<?php echo $user_define_edit->form_desc ?>"  required> 
        </div>
      </div>



      <div id="editforTextfield">
                                
      </div>      

     

          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>
  </div>

    <div class="col-md-6" id="col_3"></div>
  </div>
  </div>
