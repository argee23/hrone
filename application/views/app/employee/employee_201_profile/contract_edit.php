<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>CONTRACT</strong> (edit)</div>
  <div class="box-body">

    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/employee_201_profile/contract_modify/<?php echo $this->uri->segment("4");?>" >
    

            <div class="row">
            <div class="col-md-12">

            <div class="form-group">
            <label >Date start</label>
              <input type="text" id="start_date" name="start_date" class="form-control" placeholder="date start" value="<?php echo $contract->start_date; ?>" required>
              <p style="color:#ff0000;">Date start is required</p>
            </div>

            <div class="form-group">
            <label >Date end</label>
              <input type="text" id="end_date" name="end_date" class="form-control" placeholder="date end" value="<?php echo $contract->end_date; ?>" required>
              <p style="color:#ff0000;">Date end is required</p>
            </div>

            <div class="form-group" >
              <label for="employment_type">Employment type</label>
              <select class="form-control" name="employment_type" required>
              <option selected="selected" value="<?php echo $contract->employment_id; ?>" ><?php echo $contract->employment_name; ?></option>
              <?php 
                foreach($employmentList as $employment){
                if($_POST['employment'] == $employment->employment_id){
                    $selected = "selected='selected'";
                }else{
                    $selected = "";
                }
                ?>
                <option value="<?php echo $employment->employment_id;?>" <?php echo $selected;?>><?php echo $employment->employment_name;?></option>
                <?php }?>
            </select>
            <p style="color:#ff0000;">Employment type is required</p>
            </div>

            
            <label><?php echo $contract->file; ?></label>
            <div class="form-group">
            <div class="btn btn-info">
              <input type="file" name="file" id="file">
            </div>
            <p style="color:#ff0000;">Allowed file type jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc.</p>
            </div>
            
            <div class="form-group">
              <label for="remark">Remark</label>
              <textarea name="remark" rows="5" cols="50" class="form-control" placeholder="Remark(s)" ><?php echo $contract->remark; ?></textarea>
            </div>
            </div>
            </div>


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


