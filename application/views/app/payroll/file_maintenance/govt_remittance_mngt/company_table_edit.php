<div class="col-md-12">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">MONTH</th>
        <th scope="col">COVERED YEAR</th>
        <th scope="col">GOVERNMENT TYPE</th>
        <th scope="col">SBR NUMBER</th>
        <th scope="col">REMITTANCE DATE</th>
        <th scope="col">SSS DISKETTE</th>
        <th scope="col">ACTIONS</th>
      </tr>
    </thead>
    <tbody>
      <tr>

        <td align="center" >
        	<select name="month_cover_edit" id="month_cover_edit" class="form-control" required>
            <option value="<?php echo $contri_table_edit->month_cover; ?>" selected="selected" disabled>
              <?php 
                $monthNum  = $contri_table_edit->month_cover;
                $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));

                echo $monthName;
              ?>         
            </option>
            <?php foreach ($month as $m) {?>
              <option value="<?php echo $m->cDesc; ?>"><?php echo $m->cValue;?></option>
            <?php }?>
          </select>
        </td>

        <td align="center" >
        	<select name="year_cover_edit" id="year_cover_edit" class="form-control" required>
            <option value="<?php echo $contri_table_edit->year_cover; ?>" selected="selected" disabled><?php echo $contri_table_edit->year_cover; ?></option>
            <?php foreach ($payroll_period as $year):?>
              <option value="<?php echo $year->year_cover; ?>"><?php echo $year->year_cover; ?></option>
            <?php endforeach ?>
          </select>
        </td>

        <td align="center" >
        	<select name="gov_edit" id="gov_edit" class="form-control" value="<?php echo $contri_table_edit->gov; ?>" required>
            <option value="<?php echo $contri_table_edit->gov; ?>" selected="selected" disabled><?php echo $contri_table_edit->gov; ?></option>
            <?php foreach ($gov_type as $gov):?>
              <option value="<?php echo $gov->cValue; ?>" selected="selected"><?php echo $gov->cValue; ?></option>
            <?php endforeach ?>
          </select>
        </td>

        <td align="center" >
          <input type="text" name="sbr_number_edit" id="sbr_number_edit" class="form-control" step="any" value="<?php echo $contri_table_edit->sbr_number; ?>" required />
        </td>

        <td align="center" >
          <input type="date" name="remittance_date_edit" id="remittance_date_edit" step="any" class="form-control" value="<?php echo $contri_table_edit->remittance_date; ?>" required />
        </td>

        <td align="center" >
          <input type="text" name="sss_diskette_edit" id="sss_diskette_edit" step="any" class="form-control" value="<?php echo $contri_table_edit->sss_diskette; ?>" disabled />
        </td>

  			<td>
          <button id="contri_save_update" class="btn btn-danger btn-xs pull-left"><i class="fa fa-check fa-lg" data-toggle="tooltip" data-placement="right" title="Modify"></i></button>
  			</td>

	    </tr>
    </tbody>
  </table>
</div>