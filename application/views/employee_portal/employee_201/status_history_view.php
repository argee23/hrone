<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>STATUS HISTORY</strong></div>
  <div class="box-body">

    	 <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">

          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Acted by</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($employee_status_history as $status_history){?>
                      <tr>
                        <td><?php echo $status_history->event; ?></td>
                        <td><?php echo $status_history->date_event ?></td>
                        <td><?php echo $status_history->reason; ?></td>
                        <td><?php echo $status_history->fullname; ?></td>
                      </tr>
                      <?php } ?>
                     
                    </tbody>
                  </table>
                  <?php if(count($employee_status_history)<=0){?>
                    <p class='text-center'><strong>No Status history(ies) yet.</strong></p>
                  <?php } ?>

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


