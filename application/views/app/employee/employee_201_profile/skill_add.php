<div class="row">
<div class="col-md-8">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong>SKILL</strong> (add)</div>
  <div class="box-body">

   <form method="post" action="<?php echo base_url()?>app/employee_201_profile/skill_save/<?php echo $this->uri->segment("4");?>" >
        

          <div class="row">
            <div class="col-md-12">

            <div class="form-group">
              <label>Skill name</label>
              <input type="text" name="skill_name" class="form-control" placeholder="Skill name" required>
              <p style="color:#ff0000;">Skill name is required</p>
            </div>

            <div class="form-group">
              <label>Skill Description</label>
              <textarea name="skill_description" rows="5" cols="50" class="form-control" placeholder="Skill description" required></textarea>
              <p style="color:#ff0000;">Skill description is required</p>
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


