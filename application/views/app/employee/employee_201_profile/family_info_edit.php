<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>family_info</strong> (edit)</div>
  <div class="box-body">

  <form method="post" action="<?php echo base_url()?>app/employee_201_profile/family_info_modify/<?php echo $this->uri->segment("4");?>" >

    	 <div class="box-body">

          <div class="row">
            <div class="col-md-6">

            <div class="form-group" >
            <label for="relation">Relation</label>
              <select name="relation" class="form-control" onchange="date_marriage(this.value)" required>
                  <option selected="selected" value="<?php echo $family_info_view->relationship;
                  ?>"><?php echo $family_info_view->relationship_name;?></option>
                  <?php 
                    foreach($relation_family as $relation){
                    if($_POST['relation'] == $relation->param_id){
                        $selected = "selected='selected'";
                    }else{
                        $selected = "";
                    }
                     $check =  $this->employee_201_model->check_rel_exist_fam($this->session->userdata('employee_id'),$relation->param_id);
                        if($check=='true'){ $d= ''; }  elseif($relation->param_id==$_POST['relation'] AND $check!='true') { $d='';  } else{ $d='disabled'; }
                          if($family_info_view->relationship==$relation->param_id){} else{
                  ?>
                    <option value="<?php echo $relation->param_id;?>" <?php echo $selected;?> <?php echo $d?>><?php echo $relation->cValue;?></option>
                    <?php } }?>
                </select>
                <p style="color:#ff0000;">Relation is required</p>
            </div>

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" placeholder="name" value="<?php echo $family_info_view->name;
                  ?>" required>
              <p style="color:#ff0000;">Name is required</p>
            </div>

            <div class="form-group" >
              <label for="occupation">Occupation</label>
              <input type="text" name="occupation" class="form-control" placeholder="Occupation" value="<?php echo $family_info_view->occupation;
                  ?>">
            </div>

            </div>

            <div class="col-md-6">

            <div class="form-group">
              <label>Contact no.</label>
              <input type="number" name="contact_no" class="form-control" placeholder="Contact No." value="<?php echo $family_info_view->contact_no;
                  ?>">
            </div>

            <div class="form-group">
              <label for="birthday">Birthday</label>
              <input type="text" id="birthday" name="birthday" class="form-control" placeholder="birthday" value="<?php  echo $family_info_view->birthday; ?>" required>
            </div>

            <div id="date_marriage">
              <?php if($family_info_view->relationship==72){ ?>
              <div class="form-group">
                <label>Marriage date</label>
                <input type="text" id="date_of_marriage" name="date_of_marriage" class="form-control" placeholder="Marriage Date" value="<?php echo $family_info_view->date_of_marriage;?>" required>
              </div>
              <?php } ?>
            </div>
            
            </div>
            </div>
            </div><!-- /.box-body -->   
  

     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> Save Changes</button>
     </div>
     </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>


