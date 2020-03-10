  <table class="table table-hover" id="overtime">
                  <thead>
                      <tr class='danger'>
                        <th>ID</th>
                        <th>Date</th>
                        <?php if($option=='general'){} else{ ?><th>Group Name</th><?php } ?>
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
                        <?php if($option=='general'){} else{ ?><td><?php echo $p->group_name?></td><?php } ?>
                        <td><?php echo $p->reason?></td>
                        <td><?php echo $p->fullname?></td>
                        <td><?php echo $p->date_created?></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>