<?php //$i=0; 

for ($i = 0; $i <= 10; $i++) { 
  $i = $i + 1; 
} 

echo "<input type='hidden' id='topic_count' value='".$i."'>";?>

<script type="text/javascript">
function checkbox_stat()
{
var count= document.getElementById("topic_count").value;
var checks = document.getElementsByClassName("case1");

if(document.getElementById('check_uncheck').checked==true)
{  
for (i=0;i < count; i++)
{
checks[i].checked =true;
}  
}
else{      
for (i=0;i < count; i++)
{
checks[i].checked =false;
}   
}
}
</script>    

    <div class="box-body">
      <div class="panel panel-success">
         <div class="box-body">
         <div class="row">


         <form method="post" action="<?php echo base_url()?>app/time_flexi_schedule/save_employee_group/<?php echo $this->uri->segment("4");?>" >

 
             <div class="col-md-12">
<input type="checkbox" name="case1" class="checkbox_stat" id="check_uncheck" onclick="checkbox_stat();"><span class="text-danger">Check | Uncheck All</span>
             
	           <table id="example1" class="table table-bordered table-striped">
	              <thead>
	                <tr>
	                  <th>Employee ID</th>
	                  <th>Employee Name</th>
	                  <th>Classification</th>
	                </tr>
	              </thead>
	              <tbody>
	               <?php foreach($available_employee as $employee){ ?>
	                <tr>
	                  <td><input type="checkbox" name="employeeselected[]" class="case" name="case" value="<?php echo $employee->employee_id?>">
	                  <?php echo $employee->employee_id?> </td>
	                  <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
	                  <td><?php echo $employee->classification ?></td>
	                </tr><?php } ?>
	              </tbody>
	            </table>

	            <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> ADD</button> 

              </div>


         </div> 
         </div><!-- /.box-body --> 
      </div>
      </div>

      </form>