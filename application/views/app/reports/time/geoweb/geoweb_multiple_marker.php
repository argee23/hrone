<html>
<head>
  <meta charset="utf-8" />
  <title>GEO WEB MAP</title>
  <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />

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

  <style>
    body { margin:0; padding:0; }
    #map { position: absolute; top:0; bottom:0; right:0; left:0; }
  </style>
</head>
<body>

<div style="width:36%;float:right;margin-left: 2%;margin-right: 2%;">
	<div style="background-color:#AFEEEE;height: 95%;overflow: scroll;">
	<?php $i=1; foreach($locations as $l){?>
		<table style="width: 100%;">
			<thead>
				<tr>
					<th style="width: 5%;"></th>
					<th style="width: 20%;"></th>
					<th style="width: 60%;"></th>
					<th style="width: 5%;"></th>
				</tr>
				<tr style="background-color:white;">
					<th colspan="4" ><center>LOCATION <?php echo $i;?></center></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td>Address</td>
					<td><span id="location<?php echo $i;?>"></span></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Latitude</td>
					<td><?php echo $l->latitude;?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Longtitude</td>
					<td><?php echo $l->longitude;?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Punch Type</td>
					<td><?php echo $l->punch_type;?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Entry Time</td>
					<td><?php echo $l->entry_time;?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Log Date</td>
					<td><?php echo $l->logdate;?></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	<?php $i++; } ?>
	</div>
	<input type="hidden" id="checker">
</div>

<div id="map" style="width: 60%;float:right;">
	
</div>

<script>
 var locations = [<?php echo $data;?>];

        var map = L.map('map').setView([<?php echo $lat;?>, <?php echo $long;?>], 19);
        mapLink = 
            '';
       
    <?php if($mapid==5){?>

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '',
              maxZoom:30
            }).addTo(map);

    <?php } else if($mapid==1){?>

         googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
          maxZoom: 30,
          subdomains:['mt0','mt1','mt2','mt3']
         }).addTo(map);

    <?php } else if($mapid==2){ ?> 

        googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 30,
        subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);


    <?php } else if($mapid==3){ ?>

        googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
        maxZoom: 30,
        subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

    <?php } else if($mapid==4){ ?>

        googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
        maxZoom: 30,
        subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);


    <?php } ?>

    <?php if($mb==0){ }else{?>
		var osmb = new OSMBuildings(map).load('https://{s}.data.osmbuildings.org/0.2/anonymous/tile/{z}/{x}/{y}.json');
	<?php  } ?>

    var geocodeService = L.esri.Geocoding.geocodeService();


		for (var i = 0; i < locations.length; i++) {
			var ii = 1+i;
			
			
			geocodeService.reverse().latlng([locations[i][0],locations[i][1]]).run(function (error, result) {
			    if (error) {

			       return;
			    }
			    message = result.address.Match_addr;
			 	var checker = document.getElementById("checker").value;
			 	checker_value = (+checker) + (+1);
			 	document.getElementById('checker').value=checker_value;
			 	document.getElementById("location"+checker_value).innerHTML = message;
      		 });
			//marker = new L.marker([locations[i][0],locations[i][1]]).addTo(map);
			marker = new L.marker([locations[i][0],locations[i][1]]).addTo(map)
                  .bindPopup("LOCATION "+ii, {closeOnClick: false, autoClose: false});
		}

		map.on('click', function (e) 
		{
			geocodeService.reverse().latlng(e.latlng).run(function (error, result) {
			    if (error) {
			       return;
			    }
			    address = message = result.address.Match_addr;
		        SelectedAddress('none');
      		 });
    	});

	function SelectedAddress(i)
	{
	  alert(address);
	}

</script>



</body>
</html>                                                                                 