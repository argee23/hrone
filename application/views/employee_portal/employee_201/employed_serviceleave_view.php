
<div id="col_2">
<div class="row">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>LONG LEAVE SERVICE HISTORY</strong>

  </div>
    <div class="box-body" style="height: 560px;">
    	 <div class="scrollbar_all" id="style-1" style="height: 470px;">
         <div class="force-overflow">
          <div class="row">
            <div class="col-md-12" style="margin-top: 20px;" id="notso_detailed">
            <table class="table table-bordered" id="example1">
              <thead>
                <tr class="danger">
                    <th>Date</th>
                    <th>Date Employed</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Details</th>
                    <th>Date Return</th>
                    <th>Return Details</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($employed_serviceleave_view as $res){?>
                <tr>
                    <td><?php echo $res->date_added;?></td>
                    <td><?php echo $res->date_employed;?></td>
                    <td><?php echo $res->date_from;?></td>
                    <td><?php echo $res->date_to;?></td>
                    <td><?php echo $res->details;?></td>
                    <td><?php if(empty($res->date_return)){ echo "<n class='text-danger'>ongoing</n>"; } else{  echo $res->date_return; }?></td>
                    <td><?php if(empty($res->date_return_details)){ echo "<n class='text-danger'>ongoing</n>";  } else{ echo $res->date_return_details; }?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
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



