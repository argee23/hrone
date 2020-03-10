<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>CHARACTER REFERENCE</strong> (edit)</div>
  <div class="box-body">
  <form method="post" action="<?php echo base_url()?>app/employee_201_profile/character_ref_modify/<?php echo $this->uri->segment("4");?>" >
        


    	 <div class="box-body">
       <?php  $title_employee = 'select title'; ?>

        <?php foreach($UserTitles as $title_emp){
          if($title_emp->param_id === $character_ref->reference_title){
            $title_employee = $title_emp->cValue;
          }
        }
        ?>

          <div class="row">
            <div class="col-md-6">

            <div class="form-group">
              <label for="title">Title</label>
              <select class="form-control" name="reference_title" id="title">
              <option selected="selected" value="<?php echo $character_ref->reference_title;?>"><?php echo $title_employee;?></option>
              <?php 
                foreach($UserTitles as $title){
                if($_POST['title'] == $title->param_id){
                    $selected = "selected='selected'";
                }else{
                    $selected = "";
                }
                ?>
                <option value="<?php echo $title->param_id;?>" <?php echo $selected;?>><?php echo $title->cValue;?></option>
                <?php }?>
                </select>
            </div>

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="reference_name" class="form-control" placeholder="Name" value="<?php echo $character_ref->reference_name; ?>" required>
              <p style="color:#ff0000;">Name is required</p>
            </div>

            <div class="form-group">
              <label for="reference_position">Position</label>
              <input type="text" name="reference_position" class="form-control" placeholder="Position" value="<?php echo $character_ref->reference_position; ?>">
              <p style="color:#ff0000;">Position is required</p>
            </div>

             <div class="form-group" >
              <label for="reference_company">Company</label>
              <input type="text" name="reference_company" class="form-control" placeholder="Company" value="<?php echo $character_ref->reference_company; ?>">
              <p style="color:#ff0000;">Company is required</p>
            </div>

            </div>

            <div class="col-md-6">

            <div class="form-group">
              <label for="reference_address">Address</label>
            <input type="text" name="reference_address" class="form-control" placeholder="Address" value="<?php echo $character_ref->reference_address; ?>">
            </div>

            <div class="form-group" >
              <label for="reference_contact">Contact Number</label>
              <input type="number" name="reference_contact" class="form-control" placeholder="Contact Number" value="<?php echo $character_ref->reference_contact; ?>" required>
              <p style="color:#ff0000;">Contact No. is required</p>
            </div>

            <div class="form-group">
              <label for="reference_email">Email add</label>
            <input type="text" name="reference_email" class="form-control" placeholder="Email add" value="<?php echo $character_ref->reference_email; ?>">
            </div>

            </div>
            </div>
     
       </div><!-- /.box-body -->   
    
     <div class="form-group">
       <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
     </form>

     </div> 
     </div>

</div>
</div>

</div>  
</div>


