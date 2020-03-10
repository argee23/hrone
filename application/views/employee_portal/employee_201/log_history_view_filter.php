

                  <table id="log_history" class="col-md-12 table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Dewqate</th>
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
                      <?php if(count($employee_log_history)<=0){?>
                      <tr>
                        <td colspan="4">
                        <p class='text-center'><strong>No Log history(ies) yet.</strong></p>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
         