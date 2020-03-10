<div class="row">
<div class="col-md-7">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong><?php echo $company_name->company_name; ?></strong> (add group)
  <a onclick="view_company_group('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Group list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
 </div>
  <div class="box-body">

   <form method="post" action="<?php echo base_url()?>app/time_flexi_schedule/save_add_group/<?php echo $this->uri->segment("4");?>" >
        

          <div class="row">
            <div class="col-md-12">

            <div class="form-group">
              <label>Group name</label>
              <input type="text" name="group_name" class="form-control" placeholder="group name" onchange="return trim(this)" value="" required>
              <p style="color:#ff0000;">Group name is required</p>
            </div>

            <div class="form-group">
              <label>Group description</label>
              <input type="text" name="group_description" class="form-control" placeholder="group description" onchange="return trim(this)" value="" required>
              <p style="color:#ff0000;">Group description is required</p>
            </div>

            <div class="form-group">
              <label>Group type</label>
              <select class="form-control" name="group_type" id="group_type" onchange="get_timelimit(this.value)" required>
                  <option selected="selected" value="" disabled>~select a group type~</option>
                  <option value="controlled_flexi" >Controlled flexi</option>
                  <option value="full_flexi" >Full flexi</option>
              </select>
              <p style="color:#ff0000;">Group type is required</p>
            </div>

            <div id="time_limit">
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


