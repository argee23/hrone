

<div id="col_2">
<div class="row">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>RESIGNED DATES HISTORY</strong>
  <?php if(empty($resigned_history_view)){}else{?><a class="btn btn-success btn-xs pull-right" style="cursor: pointer;" onclick="view_detailed_history();">View more details</a><?php } ?>

  </div>
    <div class="box-body" style="height: 560px;">
    	 <div class="scrollbar_all" id="style-1" style="height: 470px;">
         <div class="force-overflow">
          <div class="row">
            <div class="col-md-12" style="margin-top: 20px;" id="notso_detailed">
            <table class="table table-bordered" id="example1">
              <thead>
                <tr class="danger">
                    <th>Date Resigned</th>
                    <th>Date Employed</th>
                    <th>Reason</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($resigned_history_view as $res){?>
                <tr>
                  <td>
                      <?php $month=substr($res->date_resigned, 5,2);
                      $day=substr($res->date_resigned, 8,2);
                      $year=substr($res->date_resigned, 0,4);

                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>

                  </td>
                  <td>
                    <?php $month=substr($res->date_employed, 5,2);
                                  $day=substr($res->date_employed, 8,2);
                                  $year=substr($res->date_employed, 0,4);

                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>
                  </td>
                  <td><?php echo $res->reason;?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
            </div>
            <div class="col-md-12" style="margin-top: 20px;display: none;" id="more_detailed">
            <?php if(!empty($resigned_history_view))
            { foreach($resigned_history_view as $res){ ?>
                <div class="panel panel-danger">
                  <div class="panel-heading"><strong>Resigned Date :
                    <?php $month=substr($res->date_resigned, 5,2);
                      $day=substr($res->date_resigned, 8,2);
                      $year=substr($res->date_resigned, 0,4);

                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>
                       </strong>
                       </div>
                     <div class="box-body">
                        <table class="table table-bordered table-striped">
                          <tbody>
                            <tr>
                              <td>Date Employed: </td>
                              <td><n class="text-info">
                                 <?php $month=substr($res->date_employed, 5,2);
                                  $day=substr($res->date_employed, 8,2);
                                  $year=substr($res->date_employed, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>
                              </n></td>
                              <td>Reason: </td>
                              <td><n class="text-info"><?php echo $res->reason;?></n></td>
                            </tr>

                            <tr>
                              <td>Division: </td>
                              <td><n class="text-info">
                                 <?php echo $res->division_name;?>
                              </n></td>
                              <td>Department: </td>
                              <td><n class="text-info">
                                 <?php echo $res->dept_name;?>
                              </n></td>
                            </tr>

                             <tr>
                              
                              <td>Section: </td>
                              <td><n class="text-info"><?php echo $res->section_name;?></n></td>
                               <td>Location: </td>
                              <td><n class="text-info"><?php echo $res->location_name;?></n></td>

                            </tr>

                             <tr>
                              <td>Subsection: </td>
                              <td><n class="text-info">
                                 <?php echo $res->subsection_name;?>
                              </n></td>
                               <td>Classification: </td>
                              <td><n class="text-info">
                                 <?php  echo $res->classification;?>
                              </n></td>
                            </tr>

                             <tr>
                              <td>Employment: </td>
                              <td><n class="text-info"><?php echo $res->employment_name;?></n></td>
                               <td>Position: </td>
                              <td><n class="text-info"><?php echo $res->position_name;?></n></td>
                            </tr>

                          </tbody>
                        </table>
                  </div>
                </div>
            <?php } }?>
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


<script type="text/javascript">
  function view_detailed_history()
  {
    $('#more_detailed').show();
    $('#notso_detailed').hide();
    $('#back_btn').show();
    
  }
</script>

