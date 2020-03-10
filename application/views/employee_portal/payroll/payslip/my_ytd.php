<style type="text/css">
  h2 {
  text-align: center;
}

table caption {
  padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>
<div class="col-md-12">
 	<div class="panel panel-success">
	</div>
</div>

<div class="col-md-12">
 	<div class="panel panel-success">
 		<div class="panel-heading">
 		<b>My Year to Date Register</b>
 		</div>
 		<div class="panel-body">

		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Year From </label>
			<div class="col-sm-10">
				<select name="covered_year_from" class="form-control" id="covered_year_from" >
					<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
						<option disabled>-----</option>
					<?php
					if(!empty($myYears)){
						foreach ($myYears as $ly) {
							echo '<option value="'.$ly->year_cover.'">'.$ly->year_cover.'</option>';
						}
					}else{}

					?>
				</select>
			</div>			
		</div>  

		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Year To </label>
			<div class="col-sm-10">
				<select name="covered_year_to" class="form-control" id="covered_year_to" >
					<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
						<option disabled>-----</option>
					<?php
					if(!empty($myYears)){
						foreach ($myYears as $ly) {
							echo '<option value="'.$ly->year_cover.'">'.$ly->year_cover.'</option>';
						}
					}else{}

					?>
				</select>
			</div>			
		</div>  



			<div class="form-group"   >
			<label for="next" class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
			<button onclick="view_my_ytd();" class="btn btn-success align-right col-md-2">
			Filter
			</button>
			</div>


<div id="show_loans">
	
<h2><?php echo date('Y');?> Year to date Register</h2>

  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">

        <table class="table table-bordered table-hover" id="table_home">
          <thead>
            <tr>
<?php
if(!empty($reg_column)){
	foreach ($reg_column as $r) {
  // if($r->sum_me=="1"){
    $sum_var=$r->field_name."_sum";
    $sum_var_fin="$sum_var";
    $$sum_var_fin=0;
  // }else{

  // }
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

  if($r->sum_me=="1"){
		$add_me_var=$r->field_name."_sum";
		$add_me_var_fin="$add_me_var";
		$$add_me_var_fin+=$y->$fn;     
  }else{

  }


				echo "<td>".$y->$fn."</td>";
			}
		}
		echo '</tr>';
	}
}
?>	 
			

          </tbody>
            <tr>
<?php
if(!empty($reg_column)){
	foreach ($reg_column as $r) {
		echo '<th>';
                       
   
                                $c=$r->field_name."_sum";
                                echo $$c;                            
                              
                          
        echo '</th>';
	}
}
?>
            </tr>
        </table>
     
      
      </div><!--end of .table-responsive-->
    </div> <!-- row -->


  </div>



 		</div>	

</div>
</div>
</div>