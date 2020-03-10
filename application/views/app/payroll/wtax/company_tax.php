<div class="box box-info">
	<div class="box-header with-border">

		<img src="<?php echo base_url()?>public/img/bir.png" alt="" class="profile-user-img img-responsive img-circle">
        <center><h4 class="box-title">BIR Tax Tables</h4></center>
        <center><h4 class="box-title" id="company_name"><strong><?php echo strtoupper($company->company_name) ?></strong></h4></center><br>

    <div class="row">
      <div class="col-md-8">
        <div class="panel panel-info">
          <div class="panel-heading">
            <center><strong>TAX EXEMPTION</strong></center>
          </div>
          <div class="panel-body">
            <table class="table table-hover">
              <tr class="danger" align="center">
                <td><strong>Location</strong></td>
                <td><strong>Daily Minimum Wage</strong></td>
                <td><strong>Effectivity Date</strong></td>
                <td><strong>Declaration Date</strong></td>
                <td width="20%"></td>
              </tr>
              <?php foreach ($locations as $location):
                $ci3 = & get_instance();
                $ci3->load->model("app/payroll_wtax_model");
                $minimum = $ci3->payroll_wtax_model->get_location_minimum($company->company_id,$location->location_id);  
              ?>
                <tr align="center" id="<?php echo $company->company_id."min".$location->location_id ?>">
                  <td><?php echo $location->location_name ?></td>
                  <?php if ($minimum): ?>
                  <td>
                    <?php echo number_format($minimum->minimum_amount,2) ?>                    
                  </td> 
                  <td><?php echo $minimum->effectivity_date; ?></td>
                  <td><?php echo $minimum->declaration_date; ?></td>
                  <td>
                    <span class="pull-right"><a href="#" data-id="<?php echo $minimum->company_id?>" id="<?php echo $minimum->location_id ?>" onclick="editMinimum(this.id,this.getAttribute('data-id'))"><i class="fa fa-pencil"></i> edit</a></span>
                  </td>
                  <?php else: ?>
                  <td>
                    0.00                    
                  </td>
                  <td>
                    <span class="pull-right"><a href="#" data-id="<?php echo $company->company_id?>" id="<?php echo $location->location_id ?>" onclick="editMinimum(this.id,this.getAttribute('data-id'))"><i class="fa fa-pencil"></i> edit</a></span>
                  </td>
                  <?php endif ?>
                </tr>
              <?php endforeach ?>
            </table>
          </div>
        </div>
      </div>
    </div>

		<div class="box-tools">    	
	      <a href="<?php echo base_url()?>app/payroll_wtax" class="btn btn-link btn-box-tool" style="float:left"><i class="fa fa-arrow-left"></i> back to standard tax tables</a>
	      <button class="btn btn-link btn-box-tool" data-toggle="modal" data-target="#addTaxTable" id="<?php echo $company->company_id?>" onclick="viewPaytype(this.id)"><i class="fa fa-plus"></i> add tax table</button>
	    </div>
	</div>

	<div class="box-body">
		<?php if (!$this->db->table_exists("tax_table_".$company->company_id)): ?>
			<center>
				<div class="jumbotron">
					<h1><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></h1>
					<h1>OOPS! NO TAX TABLES ADDED!</h1>
					<blockquote>
						<p>Click <a href="" data-toggle="modal" data-target="#addTaxTable" id="<?php echo $company->company_id?>" onclick="viewPaytype(this.id)">here</a> to add tables.</p>
					</blockquote>
				</div>
			</center>
		<?php else :?>
      <ul class="nav nav-pills nav-justified">
  			<?php $no = 1; foreach ($salaryRate as $salary_rate): if($no == 1){$active = "class = 'active'";}else{$active = "";}?>          
            <li <?php echo $active ?> role="presentation"><a href="#salary_rate_<?php echo $salary_rate->salary_rate_id ?>" data-toggle="pill"><?php echo ucwords($salary_rate->salary_rate_name) ?></a></li>
        <?php $no--; endforeach ?>
      </ul>
      <div class="tab-content">
        <?php $no2 = 1; foreach ($salaryRate as $salary_rate2): if($no2 == 1){$active = "active";}else{$active = "";}?>
          <div class="tab-pane <?php echo $active ?>" id="salary_rate_<?php echo $salary_rate2->salary_rate_id ?>">
            <?php foreach ($payType as $pay_type):  

              $ci = & get_instance();
              $ci->load->model("app/payroll_wtax_model");
              $order = $ci->payroll_wtax_model->get_order_per_pay_type_c($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$company->company_id); 
              $order2 = $ci->payroll_wtax_model->get_order_per_pay_type_c($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$company->company_id);
              $order3 = $ci->payroll_wtax_model->get_order_per_pay_type_c($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$company->company_id);
              $order4 = $ci->payroll_wtax_model->get_order_per_pay_type_c($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$company->company_id);

              $check_salary_paytype = $ci->payroll_wtax_model->check_salary_paytype($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$company->company_id);
              ?>
              <?php if ($check_salary_paytype > 0): ?>
                
              <table class="table table-bordered table-hover">
                <tr class="success">
                  <td><strong><?php echo $pay_type->pay_type_name ?></strong></td>
                  <?php foreach ($order as $order): ?>
                  <td align="center">
                   <strong><?php echo $order->order_no ?></strong>
                  </td>
                  <?php endforeach ?>
                </tr>

                <tr class="warning">
                  <td><strong>EXEMPTION</strong></td>
                  <?php foreach ($order2 as $order2): ?>
                  <td align="center">
                    <?php echo number_format($order2->exempt_value,2, '.', ',') ?>
                  </td>
                  <?php endforeach ?>
                </tr>

                <tr class="info">
                  <td>STATUS</td>
                  <?php foreach ($order3 as $order3): ?>
                  <td align="center">
                    <?php echo "+".number_format($order3->exempt_percentage,2, '.', ',')."% over" ?>
                  </td>
                  <?php endforeach ?>
                </tr>

                <?php foreach ($taxcodeList as $tax_code): 

                $ci2 = & get_instance();
                $ci2->load->model("app/payroll_wtax_model");
                $tax = $ci2->payroll_wtax_model->get_exempt_per_tax_code_c($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$tax_code->taxcode_id,$company->company_id); 
                $tax2 = $ci2->payroll_wtax_model->get_exempt_per_tax_code_c($salary_rate2->salary_rate_id,$pay_type->pay_type_id,$tax_code->taxcode_id,$company->company_id); 
                ?>
                  
                <tr id="<?php echo $pay_type->pay_type_id."tc".$tax_code->taxcode_id ?>">
                  <td title="<?php echo $tax_code->description ?>"> 
                    <?php echo strtoupper($tax_code->taxcode);?>
                  </td>
                  <?php foreach ($tax as $tax): ?>
                  <td align="center" id="<?php echo $pay_type->pay_type_id."tc".$tax_code->taxcode_id ?>">
                    <?php echo number_format($tax->tax_code_exempt,2, '.', ',');?>
                  </td>
                  <?php endforeach ?>
                </tr>

                <?php endforeach ?>
                <!-- $taxcodeList -->

                <tr align="center">
                  <td><button class="btn btn-link" data-toggle="modal" data-target="#myModal2_c" id="<?php echo $pay_type->pay_type_id?>" value="<?php echo $pay_type->pay_type_name?>" data-id="<?php echo $company->company_id ?>" data-value="<?php echo $company->company_name ?>" data-rate="<?php echo $salary_rate2->salary_rate_id?>" onclick="addTier(this.id,this.value,this.getAttribute('data-value'),this.getAttribute('data-id'),this.getAttribute('data-rate'))"><i class="fa fa-plus"></i> add bracket</button></td>
                  <?php foreach ($order4 as $order4): ?>
                  <td title="Edit"><button class="btn btn-link" id="<?php echo $order4->order_no ?>" value="<?php echo $pay_type->pay_type_id?>" data-toggle="modal" data-target="#myModal_c" data-id="<?php echo $company->company_id ?>" data-rate="<?php echo $salary_rate2->salary_rate_id?>" onclick="editTier(this.id,this.value,this.getAttribute('data-id'),this.getAttribute('data-rate'))"><i class="fa fa-pencil"></i></button></td>
                  <?php endforeach ?>
                </tr>

              </table>
              <br>
                
              <?php endif ?>
            <?php endforeach ?>
            <!-- $paytypeList -->
          </div>
        <?php $no2--; endforeach ?>
        <!-- $salary_rate2 -->
      </div>
		<?php endif ?>
	</div>
	<!-- ./box-body -->

</div>
<!-- ./box -->
