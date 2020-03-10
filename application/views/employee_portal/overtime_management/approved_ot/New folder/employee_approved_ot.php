
                     <table class="table table-hover" id="overtime">
                        <thead>
                            <tr class='danger'>
                                <th>ID</th>
                                <th>Date</th>
                                <th>OT hour/s</th>
                                <th>Group Name</th>
                                <th>Reason</th>
                                <th>Plotted By</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach ($plotted as $p) {?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $p->date;?></td>
                                <td><?php echo $p->hours;?></td>
                                <td><?php echo $p->group_name;?></td>
                                <td><?php echo $p->reason;?></td>
                                <td><?php echo $p->plotted_by;?></td>
                          </tr>
                          <?php $i++; } ?>
                          </tbody>
                      </table>

                      <div class="col-md-12">
                         <button class="pull-right" onClick="window.location.reload();"><i class="fa fa-arrow-left pull-right">BACK </i></button>
                      </div>  