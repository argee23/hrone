<div class="row">
<div class="col-md-8">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong>CHARACTER REFERENCE</strong> (add)</div>
  <div class="box-body">

   <form method="post" action="<?php echo base_url()?>app/employee_201_profile/character_ref_save/<?php echo $this->uri->segment("4");?>" >
        

          <div class="row">
            <div class="col-md-6">

            <div class="form-group">
              <label for="title">Title</label>
              <select class="form-control" name="reference_title">
              <option selected="selected" disabled="disabled" value=""> ~select title~ </option>
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
              <label for="reference_name">Name</label>
              <input type="text" name="reference_name" class="form-control" placeholder="Name" required>
              <p style="color:#ff0000;">Name is required</p>
            </div>

            <div class="form-group">
              <label for="reference_position">Position</label>
              <input type="text" name="reference_position" class="form-control" placeholder="Position">
              
            </div>

            <div class="form-group" >
              <label for="reference_company">Company</label>
              <input type="text" name="reference_company" class="form-control" placeholder="Company" >
     
            </div>

            </div>

            <div class="col-md-6">


            <div class="form-group">
              <label for="reference_address">Address</label>
            <input type="text" name="reference_address" class="form-control" placeholder="Address">
            </div>

            <div class="form-group" >
              <label for="reference_contact">Contact No.</label>
              <input type="number" name="reference_contact" class="form-control" placeholder="Contact No." required>
              <p style="color:#ff0000;">Contact No. is required</p>
            </div>

            <div class="form-group">
              <label for="reference_email">Email add</label>
            <input type="email" name="reference_email" class="form-control" placeholder="Email add">
            </div>

            </div>
            </div>
     
      <div class="form-group">
       <button type="submit" class="form-control btn btn-warning"><i class="fa fa-floppy-o"></i> SAVE </button>
       </div>
      </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>


