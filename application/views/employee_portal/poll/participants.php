<style type="text/css">.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height:640px;
    overflow-y: auto;
}</style>




<br><br><br><br>



  <div class="container">

 <div class="panel panel-success">
    
        <div class="panel-body">
                 


<!-- Button trigger modal -->
<center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    <span class="glyphicon glyphicon-plus"></span>
  Add Participants
</button>
 </center>
<!-- Modal -->
<form id="appro">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add participant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
      		Company
       		<select name="c" class="form-control" ><?php foreach($c as $c){ ?><option value="<?php echo $c->company_id; ?>"><?php echo $c->company_name ?></option><?php } ?></select> Department
          <select name="c" class="form-control" ><?php foreach($departmentList as $departmentList){ ?><option value="<?php echo $departmentList->department_id; ?>"><?php echo $departmentList->dept_name ?></option><?php } ?></select>
          Section
          <select  class="form-control" ><option>All</option></select> 
          Classification
           <select  class="form-control" ><?php foreach($classificationList as $classificationList){ ?><option value="<?php echo $classificationList->classification_id; ?>"><?php echo $classificationList->classification ?></option><?php } ?></select> 
           <br>
       		<button class="btn btn-primary" id="search" type="button">Filter</button>
          <br>
          <br>
       		<table  class="table displ"><thead><th>Select</th><th>employee id</th><th>Name</th></thead><tbody id="lsit"></tbody></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saved">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
<table class="table displ" >
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Department</th>
      <th scope="col">Delete</th>

    </tr>
  </thead>
  <tbody>
  	<?php foreach($get_participant as $get_participant) {?>
    <tr>
      <td><?php echo $get_participant->employee_id; ?></td>
      <td><?php echo $get_participant->fullname; ?></td>
      <td><?php echo $get_participant->dept_name; ?></td>
      <td><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
      
  
    </tr>
<?php } ?>

  </tbody>
</table>
</div>
</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
    $('table.displ').DataTable();
} );;
	$('#search').click(function(ew){


ew.preventDefault();
var data = $("#appro").serialize();
  $.ajax({
   data: data,
   type: "post",
   url: "<?php echo base_url().'employee_portal/poll/get_filter/'?>",
   success: function(e){

    $('#lsit').html(e);
  }
});

	})


	  $(function(){
      $('#saved').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
          poll_name = <?php echo $poll ?>

          $.ajax({
   data: {val:val,poll_name:poll_name},
   type: "post",
   url: "<?php echo base_url().'employee_portal/poll/saved_participants/'?>",
   success: function(e){
        window.location.reload(false);
    $('#lsit').html(e);
  }
});
      });
    });

</script>