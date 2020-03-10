 <div class="panel-heading"><h4><center>GEO WEB ATTENDANCES <br><b>[ <?php echo $formatted_date;?> ]</b></center></h4></div> 
              <div class="col-md-12" style="margin-top: 20px;"> 
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                        <select class="form-control" id="mapselector" name="mapselector">
                            <option value="5" disabled selected>Select Map choices</option>
                            <option value="1">Street Map</option>
                            <option value="2"> Hybrid Map</option>
                            <option value="3">Satellite Map</option>
                            <option value="4">Terrain Map</option>
                            <option value="5">Standard Map</option>
                        </select>
                        <select class="form-control" id="mapbuilding" name="mapbuilding" style="margin-top: 2px;">
                            <option value="0" disabled selected>Include Building View</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>

                  </div>
                  <div class="col-md-4"></div>
              </div>

              <div class="panel-body" id="group_members">
                     <table class="table table-hover" id="geoweb">
                        <thead>
                            <tr class='danger'>
                                <th>ID</th>
                                <th>Covered Date</th>
                                <th>Punch Type</th>
                                <th>Entry Time</th>
                                <th>Geo Purpose</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Log Date</th>
                                <th>Map</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach($geoweb as $g){?>
                            <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo $g->geo_covered_date;?></td>
                              <td><?php echo $g->punch_type;?></td>
                              <td><?php echo $g->entry_time;?></td>
                              <td><?php echo $g->purpose;?></td>
                              <td><?php echo $g->latitude;?></td>
                              <td><?php echo $g->longitude;?></td>
                              <td><?php echo $g->logdate;?></td>
                             <td><a style="cursor: pointer;" onclick="view_map('<?php echo $g->id;?>','<?php echo $g->latitude;?>','<?php echo $g->longitude;?>','<?php echo $g->geo_covered_date;?>');"> <i class="fa fa-map-marker" style="font-size:23px;color:red"></i></a></td>
                            </tr>
                            <?php $i++; } ?>
                          </tbody>
                      </table>
              </div>