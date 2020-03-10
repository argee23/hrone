 
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  

     	<!-- Load Leaflet from CDN -->
	  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
	  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	  crossorigin=""/>
	  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
	  integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
	  crossorigin=""></script>

	  <!-- Load Esri Leaflet from CDN -->
	  <script src="https://unpkg.com/esri-leaflet@2.3.0/dist/esri-leaflet.js"
	  integrity="sha512-1tScwpjXwwnm6tTva0l0/ZgM3rYNbdyMj5q6RSQMbNX6EUMhYDE3pMRGZaT41zHEvLoWEK7qFEJmZDOoDMU7/Q=="
	  crossorigin=""></script>

	  <!-- Load Esri Leaflet Geocoder from CDN -->
	  <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.css"
	    integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
	    crossorigin="">
	  <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.js"
	    integrity="sha512-uK5jVwR81KVTGe8KpJa1QIN4n60TsSV8+DPbL5wWlYQvb0/nYNgSOg9dZG6ViQhwx/gaMszuWllTemL+K+IXjg=="
	    crossorigin=""></script>

	   <!--  //building -->
	  <script src="https://cdn.osmbuildings.org/classic/0.2.2b/OSMBuildings-Leaflet.js"></script>

        <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>


<br><br>
<div id="app">
  <div class="col-lg-12"><h2 class="page-header">GEO WEB ATTENDANCES</h2></div>
    <input type="hidden" id="baseurl" value="<?php echo base_url();?>employee_portal/">

  		<div class="col-md-3">
  			   <div class="panel panel-default">
           	 <div class="panel-heading"><n class='text-success'> <b>FILTERING BY PAYROLL PERIOD</b></n> </div>
           		<div class="panel-body" id="filtering_">
                  	<div class="form-group">
                            <div class="col-md-12">
                                <label>Select Payroll Period</label>
                                <select class='form-control' name='ppayroll_period' id='ppayroll_period'>
                                     <?php
                                        $checker_pp =''; 
                                        foreach($payrollPeriods as $per)
                                        {
                                            $ppid = $per->id;
                                            $from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                                            $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                                            $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
                                            if(empty($checker_pp))
                                            {   
                                                $checker_pp.=$ppid."/";
                                                $res = true;
                                            }
                                            else
                                            {
                                                $explode =  explode('/',$checker_pp);
                                                if (in_array($ppid, $explode)) {
                                                      $res = false;
                                                } else {
                                                      $checker_pp.=$ppid."/";
                                                      $res = true;
                                                   }
                                                }
                                                if($res==true){
                                            ?>
                                        <option value="<?php echo $per->id; ?>"><?php echo $formatted; ?></option>
                                      <?php  } } ?>
                                </select>

                                <label>PUNCH TYPE</label>
                                <select class='form-control' name='ppunch_type' id='ppunch_type'>
                                      <option value="All">ALL</option>
                                      <option value="in">IN</option>
                                      <option value="out">OUT</option>
                                </select>

                                <button class="col-md-12 btn btn-info btn-sm" style="margin-top: 10px;" onclick="get_payroll_period_geo();"><b>FILTER &nbsp;<i class="fa fa-arrow-right"></i></b></button>

                            </div>
                    </div>
              </div>

              <div class="panel-heading"><n class='text-success'> <b>FILTERING BY DATE RANGE</b></n> </div>
              <div class="panel-body" id="filtering_">
                    <div class="form-group">
                            <div class="col-md-12">
                                <label>DATE FROM</label>
                                <input type="date" class="form-control" name="dfrom" id="dfrom" value="<?php echo date('Y-m-d');?>">
                                <label>DATE TO</label>
                                <input type="date" class="form-control" name="dto" id="dto" value="<?php echo date('Y-m-d');?>">
                                <label>PUNCH TYPE</label>
                                <select class='form-control' name="dpunch_type" id="dpunch_type">
                                      <option value="All">ALL</option>
                                      <option value="in">IN</option>
                                      <option value="out">OUT</option>
                                </select>

                                <button class="col-md-12 btn btn-info btn-sm" style="margin-top: 10px;" onclick="get_daterange_geo();"><b>FILTER&nbsp;<i class="fa fa-arrow-right"></i></b></button>
                            </div>
                    </div>
              </div>


            </div>
  		</div>



        <div class="col-md-9">
          <div class="panel panel-success" id="geoweb_main">
            <div class="panel-heading"><h4><center>GEO WEB ATTENDANCES <b>[<?php echo strtoupper(date("F Y", strtotime(date('Y-m-d'))));?> ]</b></center></h4></div>  
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
          </div>
        </div>

</div>
  
	



	<!-- DataTables -->
	<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  



  	<script type="text/javascript">

    $(function () {
        $('#geoweb').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[30, 35, 40, -1], [30, 35, 40, "All"]],

          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });	


    function get_payroll_period_geo()
    {
      var payroll_period = document.getElementById('ppayroll_period').value;
      var punch_type = document.getElementById('ppunch_type').value;

      if(payroll_period=='' || punch_type=='') { alert("Fill up all fields to continue"); }
      else
      {
          if (window.XMLHttpRequest)
          {
            xmlhttp2=new XMLHttpRequest();
          }
          else
          {
              // code for IE6, IE5
              xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp2.onreadystatechange=function()
          {
            if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
              {
                document.getElementById("geoweb_main").innerHTML=xmlhttp2.responseText;
                $("#geoweb").DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]     
                });
              }
          }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_geoweb_dtr/get_payroll_period_geo/"+payroll_period+"/"+punch_type,false);
          xmlhttp2.send();
      }
    }


    function get_daterange_geo()
    {

      var from = document.getElementById('dfrom').value;
      var to = document.getElementById('dto').value;
      var punch_type = document.getElementById('dpunch_type').value;

      if(from=='' || to=='') { alert("Fill up all fields to continue"); }
      else
      {
          if (window.XMLHttpRequest)
          {
            xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
               xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp2.onreadystatechange=function()
          {
            if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
              {
                document.getElementById("geoweb_main").innerHTML=xmlhttp2.responseText;
                $("#geoweb").DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]     
                });
              }
          }
          xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_geoweb_dtr/get_daterange_geo/"+from+"/"+to+"/"+punch_type,false);
          xmlhttp2.send();
      }
    }

    function view_map(id,l,ll,date)
    {
      var mb = document.getElementById('mapbuilding').value;
      var map = document.getElementById('mapselector').value;
      var base_url = document.getElementById('baseurl').value;
      var location_href =base_url + "employee_geoweb_dtr/view_map" +"/"+id+"/"+l +"/"+ ll +"/"+map+"/"+mb+"/"+date;
      window.open(location_href);
    }
  </script>