<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>LOG HISTORY</strong>
   <n class="pull-right"  > Filter by date:<input type="date" id="date_from"> to <input type="date" id="date_to"> <button onclick="filter_logs();">Go</button> </n></div>
  <div class="box-body">

    	 <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">

          <div class="row">
            <div class="col-md-12">
            <div class="form-group" id="log_view">

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Event</th>
                        <th>Computer name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($employee_log_history as $log_history){?>

                      <tr>
                        <td><?php echo $log_history->date; ?></td>
                        <td><?php echo $log_history->time; ?></td>
                        <td><?php echo $log_history->event; ?></td>
                        <td><?php echo $log_history->computer_name; ?></td>
                      </tr>
                      <?php } ?>
                      <?php if(count($employee_log_history)<=0){?>
                      <tr>
                        <td>
                        <p class='text-center'><strong>No Log history(ies) yet.</strong></p>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>

            </div>
            </div>

             </div>
             </div>
     </div> 
     </div>

</div>
</div>

</div>  
</div>

<script>
  function filter_logs()
{
  var from = document.getElementById('date_from').value;
  var to = document.getElementById('date_to').value;
  if(from=='' || to==''){ alert('Please fill up date fields to continue'); }
  else{
  if(from > to){  alert("Date to must me be greater than date from"); }
  else{
      var xmlhttp;

         
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            
            document.getElementById("log_view").innerHTML=xmlhttp.responseText;
            $("#log_history").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/filter_logs/"+from+"/"+to,true);
        xmlhttp.send();
  }}
}
</script>
