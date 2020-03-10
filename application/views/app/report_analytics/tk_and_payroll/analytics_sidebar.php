<div class="box box-danger box-solid">
  <div class="box-header">
    <h4 class="box-title"><a href="#quickview" data-toggle="collapse">Choose Topic</a></h4>
  </div>
<input type="hidden" id="time_analytics_loc" value="<?php echo $ml;?>">

  <div class="box-body" id="quickview">              
      <ul class="list-group">

<?php
foreach($AnalyticsTopic as $a){
    $fn=$a->field_name;
    $tn=$a->topic_name;
?>
 <li class="list-group-item"><a onclick="show_filter('<?php echo $fn?>');" ><?php echo $tn?></a></li>
<?php
}

?>

      </ul>
  </div>


<!--  -->





</div>
<!-- box -->