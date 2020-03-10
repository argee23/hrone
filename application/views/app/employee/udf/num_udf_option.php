<div class="row">
  <div class="col-md-11">

    
    <div class="box box-success">  
    <div class="panel panel-success">

    <div class="panel-heading"><strong>Add</strong><small> (Option) </small></div>

    <div class="box-body">
    <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee_user_define_fields/save_udf_opt/<?php echo $this->uri->segment("4");?>" >
    
      <table class="table">
        <tbody>
          <tr>
          <div class="btn-group-vertical btn-block">
            <tr>
              <td>
                <input type="number" class="form-control" name="optlabel" id="optlabel" placeholder="Number of option" value="" required>
              </td>
              <td>
                <a onclick="addUDFOption(<?php echo $this->uri->segment("4"); ?>)" type="button" data-toggle="tooltip" data-placement="right" title="Add"><i class="fa fa-check-square fa-2x text-success"></i></a>
              </td>
            </tr>
            </div>
            </tr>
        </tbody>
      </table>

      <div id="addforTextfield">
                                
      </div>

      <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> Save</button>

    </form>
    </div>
    
    </div>
    </div>

  <div class="col-md-8" id="col_4"></div>
</div>
