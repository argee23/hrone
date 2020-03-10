<div class="row">
<div class="col-md-8">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong>FAMILY</strong> (add)</div>
  <div class="box-body">

  <form method="post" action="<?php echo base_url()?>app/employee_201_profile/family_info_save/<?php echo $this->uri->segment("4");?>" >

          <div class="row">
            <div class="col-md-6">

            
            <div class="form-group" >
            <label for="relation">Relation</label>
              <select name="relation" class="form-control"  onchange="date_marriage(this.value)" required>
                  <option selected="selected" disabled="disabled" value="">~Select Relation~</option>
                  <?php 
                    foreach($relation_family as $relation){
                     $check =  $this->employee_201_model->check_rel_exist_fam($this->session->userdata('employee_id'),$relation->param_id);
                        if($check=='true'){ $d= ''; } else{ $d='disabled'; }
                    ?>
                    <option value="<?php echo $relation->param_id;?>" <?php echo $d;?>><?php echo $relation->cValue;?></option>
                    <?php }?>
                </select>
                <p style="color:#ff0000;">Relation is required</p>
            </div>

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" placeholder="name" required>
              <p style="color:#ff0000;">Name is required</p>
            </div>

            <div class="form-group" >
              <label for="occupation">Occupation</label>
              <input type="text" name="occupation" class="form-control" placeholder="Occupation" >
            </div>

            </div>

            <div class="col-md-6">

            <div class="form-group">
              <label>Contact no.</label>
            <input type="number" name="contact_no" class="form-control" placeholder="Contact No." >
            </div>

            <div class="form-group">
              <label for="birthday">Birthday</label>
              <input type="text" id="birthday" name="birthday" class="form-control" placeholder="birthday" value="<?php  echo date('Y-m-d'); ?>" required>
            </div>

            <div id="date_marriage">
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



