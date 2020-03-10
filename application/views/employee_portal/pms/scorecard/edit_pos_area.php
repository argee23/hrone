	<table class="table" id="edit_pos">
		<thead>
            <tr class='danger'>
              	<th scope="col" colspan="4">Edit Position Area<button id='close' class="pull-right close"> x </button></th>
          	</tr>
          	<tr>
              	<th>Position Area</th>
				<th>Description</th>
				<th>Weight</th>
				<th></th>
			</tr>
      	</thead>
		<tbody>
			<tr>
				<td><input type="text" id='pos_area_edit' class="form_control col-md-8" value="<?=$pos_area->pos_area;?>"></td>
				<td><textarea id='desc_edit' class="form_control col-md-9" rows="5"><?=$pos_area->area_desc;?></textarea></td>
				<td> 
                  	<select id="area_weight" class="form-control col-md-8" required="">
	                  <option selected disabled value="<?=$pos_area->area_weight?>"><?=$pos_area->area_weight?></option>
	                    <?php 
		                  for ($x = 1; $x <= 200; $x++) {
		                   
		                  echo '<option value="'.$x.'%" '.$selected.'>'.$x.'%</option>';
		                        
		                  } ?>
                	</select>
              	</td>
				<td><center><button onclick="update_pos_area('<?=$pos_area->id?>')" class="btn btn-info"> Update </button></center></td>
			</tr>
		</tbody>
	</table>

	<script type="text/javascript">
		function update_pos_area(id) {
			var pos_area = $('#pos_area_edit').val();
			var desc = $('textarea#desc_edit').val();
			var area_weight = $('#area_weight :selected').val();

			if(pos_area == "" || desc == "" || area_weight == null){
				alert('Please fill-up missing field.');
			} else {
				$.ajax({
					url: '<?=base_url()?>employee_portal/pms/update_pos_area/',
					type: 'POST',
					data: {id:id, pos_area:pos_area, desc:desc, area_weight:area_weight},
					success: function(data){
						location.reload();
					}
				});
			}

		}
	</script>