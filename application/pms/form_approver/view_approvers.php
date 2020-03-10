<div class="collapse" id="collapse_manage_pp_emp">
  <div class="box box-warning">
    <div class="panel panel-warning">
      <div class="panel-heading">   
        <strong>
          Add <?=$ratee->first_name;?> <?=$ratee->middle_name;?> <?=$ratee->last_name;?>'s Approvers
        </strong>
      </div>
      <div class="panel-body">

        <form method="post" action="<?php echo base_url()?>employee_portal/pms/save_approver/<?=$ratee->employee_id;?>" >
 
  

        <div class="col-md-7">
            <label>Approver Level</label><br>
          <div class="form-group">

          <div class='col-md-6'>
            <select class="form-control pull" name="approval_result" style="margin-left: -14px;" required>
                 <option value="set">Set As</option>
                <option value="align">Align On</option>
            </select>
          </div>

          <div class='col-md-6'>
           <select class="form-control" name="level" style="margin-left: -38px;" required>
              <?php 
              $eval_setting = $this->pms_model->getNumApp($this->session->userdata('company_id'));
              if(empty($eval_setting->setting_value)){
                echo "<option disabled>No setup for Number of Approver in this company. Please add first to continue.</option>";
              } else {
                echo "<option disabled></option>";
                $x = 1; 
                      while($x <= $eval_setting->setting_value) {
                        if($x=="1"){
                            $ext="st";
                      }else if($x=="3"){
                            $ext="rd";
                        }else if($x=="2"){
                            $ext="nd";
                        }else{
                            $ext="th";
                        }
                          echo '<option value="'.$x.'" >'.$x.$ext.' Approver</option>';
                          $x++;
                      }
              } ?>
            </select>
          </div>


        </div>
        </div>

        <div class="col-md-4">
        <div class="form-group">
        <label>Option</label>
        <select class="form-control" name="applyOption_result" required>
          <option value='this_form'>Apply to this form only</option>
          <option value='all'>Apply to all form</option>
        </select>
        </div>
        </div>

            <div class="form-group">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                </tr>
              </thead>
              <tbody>
               <?php foreach($available_employee as $employee): ?>
                <tr>
                  <td>
                  <input type="checkbox" name="employeeselected" onClick="ckChange(this)" class="case" name="case" value="<?php echo $employee->employee_id?>" required>
                  <?php echo '   '.$employee->employee_id?> 
                  </td>
                  <td><?php echo $employee->fullname; ?></td>

                </tr>
               <?php endforeach ?>
              </tbody>
            </table>

            </div>

          <div class="form-group">
            <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> ADD</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>




<div class="panel panel-default" id="custom_page">
    <div class="panel-body">
        <div class="box-header with-border">
		    <h3 class="box-title"><strong style="color:#3c8dbc;"><?=$ratee->first_name;?> <?=$ratee->middle_name;?> <?=$ratee->last_name;?></strong></h3>
		    <i class="fa fa-files-o pull-left">&nbsp;</i>
		    <button type="button" data-toggle="collapse" href="#collapse_manage_pp_emp" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" title="Add Approvers" aria-expanded="false" aria-controls="collapseExample">Add Approvers</button>
	    	<br><br>

	    	<table id='evaluators' class="table table-alternate">
	    		<thead>
	    			<th>Employee ID</th>
	    			<th>Approver Name</th>
	    			<th>Approval Level</th>
	    			<th>Action</th>
	    		</thead>
	    		<tbody>
	    			<?php 
             $system_defined_icons = $this->general_model->system_defined_icons();
            foreach($apps as $e):?>
		    			<tr>
	    				<td><?=$e->employee_id?></td>
							<td><?=$e->fullname?></td>
							<td>
              <?php 
                $ends = array('th','st','nd','rd','th','th','th','th','th','th');
                if (($e->approval_level %100) >= 11 && ($e->approval_level%100) <= 13)
                  echo $abbreviation = $e->approval_level. 'th';
                else
                  echo $abbreviation = $e->approval_level. $ends[$e->approval_level % 10];

                 ?> Approver
              </td>
							<td><a href="javascript:void(0)"><i onclick='delete_app("<?=$e->employee_id?>", "<?=$ratee->employee_id?>");' class="fa fa-<?=$system_defined_icons->icon_delete?> fa-<?=$system_defined_icons->icon_size?>x" data-toggle="tooltip" data-placement="left" title="Delete" style="color:<?=$system_defined_icons->icon_delete_color?>;"></i></a></td>
		    			</tr>
	    			<?php endforeach?>
	    		</tbody>
	    	</table>

	    </div>
  	</div>
</div>



<script type="text/javascript">
	$("#evaluators").DataTable();
  $('#example1').DataTable( {
      "scrollY":        "400px",
      "scrollCollapse": true,
      "paging":         false
  } );


function delete_app(employee_id, evaluee_id){
  
  if(confirm("Are you sure you want to remove approver?")){
    $.ajax({
      url: "<?php echo base_url();?>employee_portal/pms/delete_app",
      data: {employee_id:employee_id, evaluee_id:evaluee_id},
      type: 'post',
      success: function(data){
        location.reload();  
      }
    });
  }

}

function ckChange(ckType) {
  var ckName = document.getElementsByName(ckType.name);

  for (var i = 0; i < ckName.length; i++) {
    if (!ckType.checked) {
      ckName[i].disabled = false;
    } else {
      if (!ckName[i].checked) {
        ckName[i].disabled = true;
      } else {
        ckName[i].disabled = false;
      }
    }
  }

}

</script>

