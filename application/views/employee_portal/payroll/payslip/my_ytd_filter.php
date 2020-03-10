<h2><?php echo $covered_year_from." to ".$covered_year_to;?> Year to date Register</h2>

  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">

        <table class="table table-bordered table-hover" id="table_home">
          <thead>
            <tr>
<?php
if(!empty($reg_column)){
	foreach ($reg_column as $r) {
		echo '
			<th>'.$r->title.'</th>
		';
	}
}
?>
            </tr>
          </thead>
          <tbody>
          	
<?php
if(!empty($my_ytd)){
	foreach($my_ytd as $y){
		echo ' <tr>';
		if(!empty($reg_column)){
			foreach($reg_column as $r){
				//fn : field name
				$fn=$r->field_name;
				echo "<td>".$y->$fn."</td>";
			}
		}
		echo '</tr>';
	}
}
?>	 
			

          </tbody>
        </table>
     
      
      </div><!--end of .table-responsive-->
    </div> <!-- row -->


  </div>
