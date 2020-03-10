<div class="box box-warning collapse" id="standard">
    <div class="box-header with-border">
      <center><h4 class="box-title">Manage Timecard/Overtime Tables</h4></center>
      <div class="box-tools pull-right">
        <button data-toggle="collapse" data-target="#collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i> timecard/overtime descriptions</button>
      </div>
    </div>
    <div class="box-body">

      <div class="collapse" id="collapse">
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-success">
              <div class="panel-heading">
                <strong>Timecard/Overtime Description</strong><span class="pull-right"><button class="btn btn-link" data-toggle="modal" data-target="#addDesc"><small><i class="fa fa-plus"></i> add timecard/ot description</small></button></span>
              </div>
              <div class="panel-body">
                <table class="table table-hover table-bordered" id="timecard_table">
                  <tr>
                    <td><strong>Code</strong></td>
                    <td><strong>Timecard/Overtime Name</strong></td>
                    <td><strong>Description</strong></td>
                    <td></td>
                  </tr>
                  <?php foreach ($timecard_description as $timecard): ?>
                    <tr id="<?php echo $timecard->timecard_id?>">
                      <td><?php echo $timecard->prefix.$timecard->timecard_id ?></td>
                      <td><?php echo $timecard->timecard_desc_name ?></td>
                      <td><?php echo $timecard->timecard_description ?></td>
                      <td>
                        <a class="edit_timecard" title="Edit Timecard Details" style="cursor: pointer" data-id="<?php echo $timecard->timecard_id?>">
                          <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                          </span>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <ul class="nav nav-pills nav-justified">
        <?php $no2 = 1; foreach ($paytypeList as $pay):
            if($no2 == 1){$active = "class = 'active'";}else{$active = "";}
         ?>
          <li <?php echo $active ?> role="presentation"><a href="#pay_<?php echo $pay->pay_type_id ?>" data-toggle="pill"><?php echo ucwords($pay->pay_type_name) ?></a></li>
        <?php $no2--; endforeach ?>
      </ul>
       <div class="tab-content">
         <?php $no = 1; foreach ($paytypeList as $pay2):
            if($no == 1){$active = "active";}else{$active = "";}
         ?>
           <div class="tab-pane <?php echo $active?>" id="pay_<?php echo $pay2->pay_type_id ?>">               
      
            <?php foreach ($employmentList as $employment): ?>
              <div class="box box-solid box-success">
                <div class="box-header">
                  <h4 class="header-title"><?php echo $employment->employment_name ?></h4>
                </div>
                <div class="box-body">
                  <table class="table table-responsive table-bordered table-hover">
                    <tr align="center">
                      <td class="warning" rowspan="2"><strong>Code</strong></td>
                      <td class="warning" rowspan="2"><strong>Description</strong></td>
                      <td class="danger" colspan="2"><strong>Regular</strong></td>
                      <td class="info" colspan="2"><strong>Overtime</strong></td>
                      <td class="warning"></td>
                    </tr>
                    <tr align="center">
                      <td><strong>with ND</strong></td>
                      <td><strong>without ND</strong></td>
                      <td><strong>with ND</strong></td>
                      <td><strong>without ND</strong></td>
                      <td></td>
                    </tr>

                    <?php foreach ($timecard_description as $tc): 

                            $ci = & get_instance();
                            $ci->load->model("app/timecard_table_model");
                            $timecard_check = $ci->timecard_table_model->timecard_check($employment->employment_id,$pay2->pay_type_id,$tc->timecard_id);
                        ?>
                          <tr >
                            <td><?php echo $tc->prefix.$tc->timecard_id?></td>
                            <td><?php echo ucwords($tc->timecard_desc_name) ?></td>
                        <?php if ($timecard_check): ?>                            
                            <td align="center"><?php echo number_format($timecard_check->reg_wnd,2) ?></td>
                            <td align="center"><?php echo number_format($timecard_check->reg_nd,2) ?></td>
                            <td align="center"><?php echo number_format($timecard_check->ot_wnd,2) ?></td>
                            <td align="center"><?php echo number_format($timecard_check->ot_nd,2) ?></td>
                            <td align="center"><i class="fa fa-pencil text-success" title="Edit" style="cursor:pointer" id="<?php echo $timecard_check->id?>" onclick="editToTimecardTable(this.id)"></i></td>
                        <?php else: ?>  
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center"><i class="fa fa-pencil text-success" title="Add" style="cursor:pointer" id="<?php echo $tc->timecard_id?>" data-id="<?php echo $employment->employment_id?>" data-value="<?php echo $pay2->pay_type_id?>" onclick="addToTimecardTable(this.id,this.getAttribute('data-id'),this.getAttribute('data-value'))"></i></td>
                        <?php endif ?>
                          </tr>
                    <?php endforeach ?>
                  </table>
                </div>
              </div>
              <!-- /.box -->
            <?php endforeach ?>
            <!-- $employment -->
           </div>
         <?php $no--; endforeach ?>
            <!-- $pay2 -->
       </div>
      
    </div>

    <div class="overlay hidden" id="overlay">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>

<div class="box box-info">
	<div class="box-header with-border">

		<!-- <img src="<?php echo base_url()?>public/img/bir.png" alt="" class="profile-user-img img-responsive img-circle"> -->
        <center><h3 class="text-primary" id="company_name"><strong><?php echo strtoupper($company->company_name) ?></strong></h3></center>
        <center><h4 class="box-title">Overtime/Timecard Tables</h4></center><br>

		<div class="box-tools">    	
	      <!-- <a href="<?php echo base_url()?>app/payroll_wtax" class="btn btn-link btn-box-tool" style="float:left"><i class="fa fa-arrow-left"></i> back to standard tax tables</a> -->
	      <button class="btn btn-link btn-box-tool" data-toggle="modal" data-target="#addTimecardTable" id="<?php echo $company->company_id?>" onclick="viewPaytype(this.id)"><i class="fa fa-plus"></i> add overtime table</button>
	    </div>
	</div>

	<div class="box-body">
		<?php if (!$this->db->table_exists("timecard_table_".$company->company_id)): ?>
			<center>
				<div class="jumbotron">
					<h1><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></h1>
					<h1>OOPS! NO OVERTIME/TIMECARD TABLES ADDED!</h1>
					<blockquote>
						<p>Click <a href="" data-toggle="modal" data-target="#addTimecardTable" id="<?php echo $company->company_id?>" onclick="viewPaytype(this.id)">here</a> to add tables.</p>
					</blockquote>
				</div>
			</center>
		<?php else :?>
      <center><h4 class="bg-warning"><strong>SALARY RATE</strong></h4></center>
      <ul class="nav nav-pills nav-justified">
        <?php $no = 1; foreach ($salaryRate as $salary_rate): if($no == 1){$active = "class = 'active'";}else{$active = "";}?>          
            <li <?php echo $active ?> role="presentation"><a href="#salary_rate_<?php echo $salary_rate->salary_rate_id ?>" data-toggle="pill"><?php echo ucwords($salary_rate->salary_rate_name) ?></a></li>
        <?php $no--; endforeach ?>
      </ul>

      <div class="tab-content">
        <?php $no2 = 1; foreach ($salaryRate as $salary_rate2): if($no2 == 1){$active = "active";}else{$active = "";}?>
          <div class="tab-pane <?php echo $active ?>" id="salary_rate_<?php echo $salary_rate2->salary_rate_id ?>">
            <?php 
              $ci = & get_instance();
              $ci->load->model("app/timecard_table_model");
              $get_payType = $ci->timecard_table_model->get_per_pay_type_c($salary_rate2->salary_rate_id,$company->company_id); 
             ?>

              
              <center><h4 class="bg-success"><strong>PAY TYPE</strong></h4></center>
             <ul class="nav nav-pills nav-justified red">
              <?php $no3 = 1; foreach ($get_payType as $pay_type): if($no3 == 1){$active = "class = 'active'";}else{$active = "";}?>          
                  <li <?php echo $active ?> role="presentation"><a href="#salary_rate_<?php echo $pay_type->pay_type_id ?>" data-toggle="pill"><?php echo ucwords($pay_type->pay_type_name) ?></a></li>
              <?php $no3--; endforeach ?>
            </ul>

            <div class="tab-content">
              <?php $no4 = 1; foreach ($get_payType as $pay_type2): if($no4 == 1){$active = "active";}else{$active = "";}?>
                <div class="tab-pane <?php echo $active ?>" id="pay_type_<?php echo $pay_type2->pay_type_id ?>">
                  <?php

                    $get_employment = $ci->timecard_table_model->get_per_employment_c($salary_rate2->salary_rate_id,$pay_type2->pay_type_id,$company->company_id);
                   ?>

                   <?php foreach ($get_employment as $employment): ?>
                      <div class="box box-solid box-success">
                        <div class="box-header">
                          <h4 class="header-title"><?php echo $employment->employment_name ?></h4>
                        </div>
                        <div class="box-body">
                          <table class="table table-responsive table-bordered table-hover">
                            <tr align="center">
                              <td class="warning" rowspan="2"><strong>Code</strong></td>
                              <td class="warning" rowspan="2"><strong>Description</strong></td>
                              <td class="danger" colspan="2"><strong>Regular</strong></td>
                              <td class="info" colspan="2"><strong>Overtime</strong></td>
                              <td class="warning"></td>
                            </tr>
                            <tr align="center">
                              <td><strong>without ND</strong></td>
                              <td><strong>with ND</strong></td>
                              <td><strong>without ND</strong></td>
                              <td><strong>with ND</strong></td>
                              <td></td>
                            </tr>

                            <?php 

                            $get_timecard = $ci->timecard_table_model->get_timecard_per_c($salary_rate2->salary_rate_id,$pay_type2->pay_type_id,$employment->employment_id,$company->company_id); ?>

                            <?php foreach ($get_timecard as $tc2): 
                                
                                $tc_check = $ci->timecard_table_model->timecard_check_c($salary_rate2->salary_rate_id,$employment->employment_id,$pay_type2->pay_type_id,$tc2->t_id,$company->company_id);
                            ?>
                              <tr >
                                <td><?php echo $tc2->prefix.$tc2->timecard_id?></td>
                                <td><?php echo ucwords($tc2->timecard_desc_name) ?></td>
                            <?php if ($tc_check):?>                            
                                <td align="center"><?php echo number_format($tc_check->reg_wnd,4) ?></td>
                                <td align="center"><?php echo number_format($tc_check->reg_nd,4) ?></td>
                                <td align="center"><?php echo number_format($tc_check->ot_wnd,4) ?></td>
                                <td align="center"><?php echo number_format($tc_check->ot_nd,4) ?></td>
                                <td align="center"><i class="fa fa-pencil text-success" title="Edit" style="cursor:pointer" id="<?php echo $tc_check->tc_table_id?>" data-id="<?php echo $company->company_id ?>" onclick="editToTimecardTable_c(this.id,this.getAttribute('data-id'))"></i></td>                            
                            <?php endif ?>
                              </tr>
                            <?php endforeach ?>
                          </table>
                        </div>
                      </div>
                      <!-- /.box -->
                    <?php endforeach ?>
                    <!-- $employment -->
                </div>
              <?php $no4--; endforeach ?>
              <!-- pay_type -->
            </div>

          </div>
        <?php $no2--; endforeach ?>
      </div>
      
		<?php endif ?>
	</div>
	<!-- ./box-body -->

</div>
<!-- ./box -->
