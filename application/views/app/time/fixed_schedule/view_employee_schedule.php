<div class="row">
<div class="col-md-9">

<div class="box box-success">
<div class="panel panel-success">

  <div class="panel-heading"><strong><?php echo $employee->group_name; ?></strong>
  <i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $employee->group_id; ?>')"></i>
  </div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>
    <div class="row">

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Employee ID</p>
        </div>
        <div class="col-sm-7">
          <label><?php echo $employee->employee_id; ?></label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Employee Name</p>
        </div>
        <div class="col-sm-7">
          <label><?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' '.$employee->name_extension; ?></label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Company</p>
        </div>
        <div class="col-sm-7">
          <label>
              <label><?php echo $employee->company_name; ?></label>
          </label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Classification</p>
        </div>
        <div class="col-sm-7">
          <label>
              <label><?php echo $employee->classification; ?></label>
          </label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="col-md-12">
      <div class="form-group">
      <table id="example1" class="table table-bordered table-striped">
      <thead style="background-color:#00ff80">
        <tr>
          <th>DAY</th>
          <th>SHIFT</th>
        </tr>
      </thead>
      <tbody>

        <?php if($employee->mon === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Monday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
        </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Monday</strong></td>
          <td>
              <label><?php echo $employee->mon;?></label>
          </td>
          </tr>
        <?php } ?>

        <?php if($employee->tue === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Tuesday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
          </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Tuesday</strong></td>
          <td>
              <label><?php echo $employee->tue;?></label>
          </td>
          </tr>
        <?php } ?>

        <?php if($employee->wed === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Wednesday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
          </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Wednesday</strong></td>
          <td>
              <label><?php echo $employee->wed;?></label>
          </td>
          </tr>
        <?php } ?>

        <?php if($employee->thu === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Thursday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
          </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Thursday</strong></td>
          <td>
              <label><?php echo $employee->thu;?></label>
          </td>
          </tr>
        <?php } ?>

        <?php if($employee->fri === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Friday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
          </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Friday</strong></td>
          <td>
              <label><?php echo $employee->fri;?></label>
          </td>
          </tr>
        <?php } ?>

        <?php if($employee->sat === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Saturday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
          </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Saturday</strong></td>
          <td>
              <label><?php echo $employee->sat;?></label>
          </td>
          </tr>
        <?php } ?>

        <?php if($employee->sun === 'restday'){?>
          <tr style="background-color:#FA9E47">
          <td><strong>Sunday</strong></td>
          <td>
              <label>Rest day</label>
          </td>
          </tr>
        <?php } 
        else{?>
          <tr style="background-color:#C9FFE5">
          <td><strong>Sunday</strong></td>
          <td>
              <label><?php echo $employee->sun;?></label>
          </td>
          </tr>
        <?php } ?>
        
      </tbody>
      </table>
      </div>
      </div>
      </div>

     </div>
     <br>
    </div>
    </div><!-- /.box-body -->

</div>
</div>

</div>  
</div>


