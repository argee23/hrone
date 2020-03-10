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
    tr { height: 30px; }
  </style>
</head>
<body>

<div style="width: 30%;float: right;">

  <div style="background-color:#AFEEEE;height: 100%;overflow: scroll;">

  <?php $i=1; foreach($locations as $l){?>
    <table style="width: 100%;margin-top: 20%;">
      <tbody>
        <tr style="background-color: white;">
          <td colspan="2" ><center>ADDRESS</center></td>
        </tr>
        <tr  style="height: 50px;">
          <td colspan="2"><center><span id="address"></span></center></td>
        </tr>
         <tr style="background-color: white;">
          <td colspan="2"><center>COVERED DATE</center></td>
        </tr>
        <tr>
          <td colspan="2"><center> <?php echo date("F d, Y", strtotime($l->geo_covered_date)); ?></center></td>
        </tr>

         <tr style="background-color: white;">
          <td colspan="2"><center>LATITUDE</center></td>
        </tr>
        <tr>
          <td colspan="2"><center><?php echo $l->latitude;?></center></td>
        </tr>

         <tr style="background-color: white;">
          <td colspan="2"><center>LONGITUDE</center></td>
        </tr>
        <tr>
          <td colspan="2"><center><?php echo $l->longitude;?></center></td>
        </tr>

         <tr style="background-color: white;">
          <td colspan="2"><center>PUNCH TYPE</center></td>
        </tr>
        <tr>
          <td colspan="2"><center><?php echo $l->punch_type;?></center></td>
        </tr>

         <tr style="background-color: white;">
          <td colspan="2"><center>ENTRY TIME</center></td>
        </tr>
        <tr>
          <td colspan="2"><center><?php echo $l->entry_time;?></center></td>
        </tr>

         <tr style="background-color: white;">
          <td colspan="2"><center>LOG DATE</center></td>
        </tr>
        <tr>
          <td colspan="2"> <center><?php echo date("F d, Y", strtotime($l->logdate)); ?></center></td>
        </tr>
      </tbody>
    </table>
  <?php $i++; } ?>
</div>

<div id="map" style="width: 70%;"></div>

<script>
  var map = L.map('map').setView([<?php echo $lat;?>, <?php echo $long;?>], 19);

 
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

   
      
    var geocodeService = L.esri.Geocoding.geocodeService();
    geocodeService.reverse().latlng([<?php echo $lat;?>, <?php echo $long;?>]).run(function(error, result) {
    message =result.address.Match_addr;
    document.getElementById("address").innerHTML = result.address.Match_addr;
    marker = new L.marker([<?php echo $lat;?>, <?php echo $long;?>]).addTo(map);
    <?php if($mb==0){ }else{?>
     var osmb = new OSMBuildings(map).load('https://{s}.data.osmbuildings.org/0.2/anonymous/tile/{z}/{x}/{y}.json');
    <?php  } ?>
   
    });

    map.on('click', function (e) {
      geocodeService.reverse().latlng(e.latlng).run(function (error, result) {
        if (error) {
          return;
        }
        address = message =result.address.Match_addr;
        SelectedAddress();
      });
    });


function SelectedAddress()
{
  alert(address);
}

</script>


</body>
</html>                                                                                 