
<?php include('header.php');?>
<div id="col_2">
<div class="row">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>PERMANENTLY DELETE EMPLOYEE</strong>

  </div>
    <div class="box-body" style="height: 560px;">
    	 <div class="scrollbar_all" id="style-1" style="height: 470px;">
         <div class="force-overflow">
          <div class="row">
            <div class="col-md-12" style="margin-top: 20px;" id="notso_detailed">
          <form method="post" action="<?php echo base_url()?>app/employee_201_profile/delete_employee_proceed/<?php echo $this->uri->segment("4");?>" >

          Are you sure you want to permanently delete this employee ? State reason why .
          <input type="hidden" name="employee_id" value="<?php echo $employee_id;?>">
          <textarea name="delete_emp_reason" class="form-control" rows="10" maxlength="200" required >
          </textarea>

          Note : Once you delete this employee, you can no longer restore the employee data.
          <br>
          <input type="checkbox" name="iagree_delete_employee"> Check me if you agree and aware of the note written above.

          <div class="form-group">
            <button type="submit" disabled class="form-control btn btn-danger" title="Currently Not Allowed" ><i class="fa fa-warning"></i> Click to Proceed Deleting Employee </button>
          </div>

          </form>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12"><a class="btn btn-danger btn-xs pull-right" style="display: none;" id="back_btn" onclick="location.reload();">BACK</a></div>
    </div>
  </div>
</div>
</div>  
</div>
</div>
</div>

 <?php include('footer.php');?>


