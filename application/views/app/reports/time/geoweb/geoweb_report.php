<?php
if($report_result_type=="excel"){
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$report_area.xls");
    header("Pragma: no-cache");   
    header("Expires: 0");
}else{

}

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
  <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
  <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

  <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
  <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
  <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
  <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
  <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">


</head>
<body>

<div class="col-md-12">
    <div class="table-responsive"  style="background-color: white;height: 100px;">

           <div class="col-md-4"></div>
                  <div class="col-md-4" style="margin-top: 10px;">
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
                         <input type="hidden" id="baseurl" value="<?php echo base_url();?>">
                  </div>
                  <div class="col-md-4"></div>
    </div>
    <br>
    <?php if($option=='punch_type'){?>
      <div class="col-md-12 table-responsive"  style="background-color: white;">
        <br><br>
        <table  class="table table-hover table-striped"  id="result_report">
          <thead>
              <tr class="danger">
                <?php if($report=='default'){?>
                    <th>No.</th>
                    <th>Employee ID</th>
                    <th>Covered Date</th>
                    <th>Punch Type</th>
                    <th>Entry Time</th>
                    <th>Purpose</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Log Date</th>
                <?php 
                } else{ foreach($report_fields as $f){ ?>

                    <th><?php echo $f->title;?></th>

                <?php } } ?>
                  <th></th>
              </tr>
          </thead>
          <tbody>
          <?php $i=1; foreach($results as $r){?>
              <tr>
                  <?php if($report=='default'){?>
                    <td><?php echo $i;?></td>
                    <td><?php echo $r->employee_id;?></td>
                    <td><?php echo $r->geo_covered_date;?></td>
                    <td><?php echo $r->punch_type;?></td>
                    <td><?php echo $r->entry_time;?></td>
                    <td><?php echo $r->purpose;?></td>
                    <td><?php echo $r->latitude;?></td>
                    <td><?php echo $r->longitude;?></td>
                    <td><?php echo $r->logdate;?></td>
                  <?php } else{ foreach($report_fields as $f){ $field= $f->field_name; ?>

                    <td>
                        <?php 
                            if($field =='date') { echo $r->geo_covered_date; }
                            else if($field=='InActive'){ if($r->InActive==0){ echo "Active"; } else{ echo "InActive"; }}
                            else if($field=='mm' || $field == 'dd' || $field=='yy')
                            {   
                                if($field=='mm'){ $v='m'; } elseif($field == 'dd'){ $v='d'; } else{ $v='y'; }
                                $value = date($v, strtotime($r->geo_covered_date));

                                echo $value;
                            }
                            else{ 
                              echo $r->$field;
                            }
                        ?>
                          
                    </td>

                  <?php } } ?>
                  <td><a style="cursor: pointer;" onclick="view_map('<?php echo $r->id;?>','<?php echo $r->latitude;?>','<?php echo $r->longitude;?>');"> <i class="fa fa-map-marker" style="font-size:23px;color:red"></i></a></td>
              </tr>
            <?php $i++; } ?>
          </tbody>
        </table>
      </div>

    <?php } else{?>

       <div class="table-responsive"  style="background-color: white;">
       <br><br>
        <table class="table table-hover table-striped" id="result_report">
          <thead>
              <tr class="danger">
                <?php if($report=='default'){?>
                    <th>No.</th>
                    <th>Employee ID</th>
                    <th>Covered Date</th>
                    <th>Punch Type</th>
                    <th>Entry Time</th>
                    <th>Purpose</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Log Date</th>
                <?php 
                } else{ foreach($report_fields as $f){ ?>

                    <th><?php echo $f->title;?></th>

                <?php } } ?>
                  <th></th>
              </tr>
          </thead>
          <tbody>
          <?php $i=1; foreach($results as $r){
               $get_geo_details = $this->report_time_geoweb_model->get_geo_details($r->employee_id,$r->geo_covered_date);
          ?>
              <tr>
                  <?php if($report=='default'){?>
                    <td><?php echo $i;?></td>
                    <td><?php echo $r->employee_id;?></td>
                    <td><?php echo $r->geo_covered_date;?></td>
                    <td>
                        <?php 
                                $i=1;
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->punch_type.'<br>';
                                             $i++;
                                    }
                        ?>
                    </td>
                    <td>
                      <?php 
                                $i=1;
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->entry_time.'<br>';
                                             $i++;
                                    }
                        ?>
                    </td>
                    <td>
                        <?php 
                                $i=1;
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->purpose.'<br>';
                                             $i++;
                                    }
                        ?>
                    </td>
                    <td>
                       <?php 
                                $i=1;
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->latitude.'<br>';
                                             $i++;
                                    }
                        ?>
                    </td>
                    <td>
                       <?php 
                                $i=1;
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->longitude.'<br>';
                                             $i++;
                                    }
                        ?>
                    </td>
                    <td>
                        <?php 
                                $i=1;
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->logdate.'<br>';
                                             $i++;
                                    }
                        ?>
                    </td>
                  <?php } else{ foreach($report_fields as $f){ $field= $f->field_name; ?>

                    <td>
                        <?php 
                            if($field=='punch_type' || $field =='entry_time' || $field=='purpose' || $field=='latitude' || $field=='longitude' || $field=='logdate'){

                                $get_geo_details = $this->report_time_geoweb_model->get_geo_details($r->employee_id,$r->geo_covered_date);
                                $i=1;

                                
                                    foreach($get_geo_details as $g)
                                    {

                                            echo $i.').&nbsp;'.$g->$field.'<br>';
                                             $i++;
                                    }
                                   


                            }
                            else if($field=='InActive'){ if($r->InActive==0){ echo "Active"; } else{ echo "InActive"; }}
                            else if($field=='mm' || $field == 'dd' || $field=='yy')
                            {   
                                if($field=='mm'){ $v='m'; } elseif($field == 'dd'){ $v='d'; } else{ $v='y'; }
                                $value = date($v, strtotime($r->geo_covered_date));

                                echo $value;
                            }
                            else
                            {
                              echo $r->$field;
                            }
                        ?>
                    </td>

                  <?php } } ?>
                  <td><a style="cursor: pointer;" onclick="view_map('<?php echo $r->geo_covered_date;?>','all','<?php echo $r->employee_id;?>');"> <i class="fa fa-map-marker" style="font-size:23px;color:red"></i></a></td>
              </tr>
            <?php $i++; } ?>
          </tbody>
        </table>
      </div>
      

    <?php } ?>
</div>    
</body>
</html>

<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
   function view_map(id,l,ll)
    {
      var mb = document.getElementById('mapbuilding').value;
      var map = document.getElementById('mapselector').value;
      var base_url = document.getElementById('baseurl').value;
      if(l=='all')
      {
        var location_href =base_url + "app/reports_time_geoweb/view_map" +"/"+id+"/"+l +"/"+ ll +"/"+map+"/"+mb;
      }
      else
      {
          var location_href =base_url + "employee_portal/employee_geoweb_dtr/view_map" +"/"+id+"/"+l +"/"+ ll +"/"+map+"/"+mb;
      }
      
      window.open(location_href);
    }

       $(function () {
        $('#result_report').DataTable({
          "pageLength": -1,
           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] ,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

</script>