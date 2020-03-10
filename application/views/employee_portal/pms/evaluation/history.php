







<!------ Include the above in your HEAD tag ---------->
<br><br>
<?php echo $message; ?>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">

<h2 class="page-header">Section Management  </h2>
<div class="container">
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i> Employee List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
              <table class="table table-bordered" id="tablenodiv">
                  <thead>
                      <tr>   

                        <th id="no" style="left:10px;"><center><input type="checkbox"  onclick="checkall(this);"></center></th>
                        <th><center>Name</center></th>

                           <th><center>date</center></th>
                          <th><center>status</center></th>
                                 <th><center>doc_no</center></th>

                      </tr>
                  </thead>
                  <tbody>
                    
                    <?php foreach ($his as $employee) { ?>
                      <tr style="text-align: center;">
                              <td><input type="checkbox" name="check" class="check" value="<?php echo $employee->employee_id; ?>"></td>
                                <td><a href="<?php echo base_url().'employee_portal/pms/evaluate_form/'.$employee->employee_id.'/'.$employee->doc_no?>" onclick="scorecard(<?php echo $employee->employee_id?>,'<?php echo $employee->fullname; ?>');"><?php echo $employee->fullname; ?></a>
                              <td><?php echo $employee->date ?></td>
                                  <td><?php echo $employee->status ?></td>
                                  <td><?php echo $employee->doc_no ?></td>
                     </tr>
                    <?php } ?>
                  </tbody>
              </table>
              </div>
           
            </div>
          </div>


          <script type="text/javascript">
            $(document).ready( function () {
    $('#tablenodiv').DataTable();
} );
          </script>

	
