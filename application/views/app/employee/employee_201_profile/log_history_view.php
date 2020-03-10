<?php include('header.php');?>
        
        <div id="col_2">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>LOG HISTORY</strong>  <n class="pull-right"  > Filter by date:<input type="date" id="date_from"> to <input type="date" id="date_to"> <button onclick="filter_logs();">Go</button> </n></div>
  <div class="box-body">
       <div style="height:430px;" id="log_view">
                  <table id="example1" class="col-md-12 table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Event</th>
                        <th>Computer name</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach($employee_log_history as $log_history){?>

                      <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo $log_history->date; ?></td>
                        <td><?php echo $log_history->time; ?></td>
                        <td><?php echo $log_history->event; ?></td>
                        <td><?php echo $log_history->computer_name; ?></td>
                      </tr>
                      <?php $i++;} ?>
                     
                    </tbody>
                  </table>
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
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/filter_logs/"+from+"/"+to,true);
        xmlhttp.send();
  }
}
</script>

        </div>

        </div>
 <?php include('footer.php');?>


