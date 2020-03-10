
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading"><n class='text-success'> <?php if($option=='pre_approved'){ echo "Pre-Approved Overtime"; } else{ echo "Approved Overtime"; }?>| General Pre approved </n> 
              <i class="btn btn fa fa-home pull-right" aria-hidden='true' data-toggle='tooltip' title='Click to go back to home.' onClick="window.location.reload()"></i>
              <i class="btn btn fa fa-dedent pull-right" aria-hidden='true' data-toggle='tooltip' title='Click to Filter Dates Plotted' onclick="view_filter_pre_approved('general');"></i>
            </div>
            <div class="panel-body" id="filtering_">
                  <div class="form-group">
                  <input type="hidden" value="general" id="option">
                    <label class="control-label col-sm-4" for="email">Date</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" id="date" name="date" onchange="get_employees_for_general(event);">
                    </div>
                  </div>
                    <br><br>
                  <div class="form-group">
                    <input type="hidden" name="group" id="group" value="general">
                  </div> 
              </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="panel panel-success">
            <div class="panel-heading"> Personnel List </div>  
              <div class="panel-body" id="group_members">
                     <table class="table table-hover" id="overtime">
                        <thead>
                            <tr class='danger'>
                              <th>ID</th>
                              <th>Date</th>
                              <th>Reason</th>
                              <th>Plotted By</th>
                              <th>Date Plotted</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach ($plotted as $p) {?>
                            <tr>
                              <td><?php echo $i?></td>
                              <td><?php echo $p->date?></td>
                              <td><?php echo $p->reason?></td>
                              <td><?php echo $p->fullname?></td>
                              <td><?php echo $p->date_created?></td>
                          </tr>
                          <?php $i++; } ?>
                          </tbody>
                      </table>
              </div>
          </div>
        </div>