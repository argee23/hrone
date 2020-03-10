<table class="col-md-12 table table-hover" id="crystal_report">
  <thead>
      <tr class="danger">
      	<?php foreach($fields as $f){?>
          <th><?php echo $f->udf_label;?></th>
        <?php } ?>
      </tr>
  </thead>
  <tbody>
  		

  <?php 
  			if($trans->IsUserDefine==0)
  			{
				$checker=''; 
  				foreach($details as $d){
  					 $ppid = $d->idd;
  					    if(empty($checker))
                     	{	   
                            $checker.=$ppid."/";
                            $res = true;
                        }
                        else
                        {
                            $explode =  explode('/',$checker);
                            if (in_array($ppid, $explode)) {
                                $res = false;
                            } else  {
                                    $checker.=$ppid."/";
                                     $res = true;
                                    }
                            }
                            if($res==true){
  				?>
  				
  				<tr>	
  					<?php foreach($fields as $f){
  						$ff=$f->TextFieldName;
  						
  					?>
				        <td>
				          	<?php 
				          		if($transaction_id==1)
				          		{
				          			if($ff=='request_list')
				          			{
				          					$requestlist = explode('-',$d->$ff);
						          			$i_requestlist=1;
						          			foreach($requestlist as $e)
						          			{
						          				$requestlist_data = $this->report_transaction->get_employee_request_list_data($e);
						          				if(empty($requestlist_data)){} else{ echo $i_requestlist."). ".$requestlist_data."<br>"; }
						          				$i_requestlist++;
						          			}
				          			}
				          			else
				          			{
				          					echo $d->$ff;
				          			}

				          			
				          		}
				          		else if($transaction_id==2)
				          		{
				          			if($ff=='transaction_dates')
				          			{
				          				$leave_dates = 	$this->report_transaction->transaction_dates($d->doc_no,'employee_leave_days');
				          				$i_leave_dates=1;
				          				foreach($leave_dates as $ld)
				          				{
				          					echo $i_leave_dates."). ".$ld->the_date."<br>";
				          					$i_leave_dates++;
				          				}
				          			}
				          			else if($ff=='leave_type_id')
				          			{
				          				$leave_type_name = $this->report_transaction->get_leave_type_name($d->$ff);
				          				if(empty($leave_type_name)){ echo "-"; } else{ echo $leave_type_name; }
				          			}
				          			else if($ff=='with_pay')
				          			{
				          				if($d->$ff==1){ echo "with pay";} else{ echo "without pay";}
				          			}
				          			else
				          			{
				          				echo $d->$ff;	
				          			}
				          			
				          		}
				          		else if($transaction_id==3)
				          		{
				          			if($ff=='transaction_dates')
				          			{
				          				$cs_dates = 	$this->report_transaction->transaction_dates($d->doc_no,'emp_change_sched_days');
				          				$i_cs_dates=1;
				          				foreach($cs_dates as $ld)
				          				{
				          					echo $i_cs_dates."). ".$ld->the_date."<br>";
				          					$i_cs_dates++;
				          				}
				          			}
				          			else if($ff=='rest_day')
				          			{
				          				if($d->$ff=='1'){ echo "yes"; } else{ echo "no"; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;	
				          			}
				          		}
				          		else if($transaction_id==5)
				          		{
				          			if($ff=='loan_type')
				          			{
				          				$loan_type = $this->report_transaction->get_loan_type_name($d->$ff);
				          				if(empty($loan_type)){} else{ echo $loan_type; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else if($transaction_id==6)
				          		{
				          			if($ff=='type_of_advance')
				          			{
				          				$type_of_advance = $this->report_transaction->get_tran_details('id','advance_type','advance_type',$d->$ff);
				          				if(empty($type_of_advance)){} else{ echo $type_of_advance; }
				          			}
				          			else if($ff=='deduction_type')
				          			{
				          				$deduction_type = $this->report_transaction->get_tran_details_parameters('cut_off','cDesc','cValue',$d->$ff);
				          				if(empty($deduction_type)){} else{ echo $deduction_type; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else if($transaction_id==7)
				          		{
				          			if($ff=='last_payroll_period')
				          			{
				          				$pperiod = $this->report_transaction->get_pp($d->$ff);
				          				if(empty($pperiod)){} else{ echo $pperiod->complete_from." to ".$pperiod->complete_to; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else if($transaction_id==12)
				          		{
				          			if($ff=='payroll_period')
				          			{
				          				$pperiod = $this->report_transaction->get_pp($d->$ff);
				          				if(empty($pperiod)){} else{ echo $pperiod->complete_from." to ".$pperiod->complete_to; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else if($transaction_id==14)
				          		{
				          			if($ff=='payroll_period')
				          			{
				          				$pperiod = $this->report_transaction->get_pp($d->$ff);
				          				if(empty($pperiod)){} else{ echo $pperiod->complete_from." to ".$pperiod->complete_to; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else if($transaction_id==15)
				          		{
				          			if($ff=='transaction_dates')
				          			{
				          				$ob_dates = 	$this->report_transaction->transaction_dates($d->doc_no,'emp_official_business_days');
				          				$i_ob_dates=1;
				          				foreach($ob_dates as $ob)
				          				{
				          					echo $i_ob_dates."). ".$ob->the_date."<br>";
				          					$i_ob_dates++;
				          				}
				          			}
				          			else if($ff=='with_meal' || $ff=='will_return')
				          			{
				          				if($d->$ff==1){ echo "yes"; } else{ echo "no"; }
				          			}
				          			
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else if($transaction_id==27)
				          		{
				          			if($ff=='payroll_period')
				          			{
				          				$pperiod = $this->report_transaction->get_pp($d->$ff);
				          				if(empty($pperiod)){} else{ echo $pperiod->complete_from." to ".$pperiod->complete_to; }
				          			}
				          			else
				          			{
				          				echo $d->$ff;
				          			}
				          		}
				          		else
				          		{
				          			echo $d->$ff;
				          		}

				          	?>
				          	
				        </td>

				    <?php } ?>
				 </tr>


  			<?php } } }
  			else
  			{ 
  				foreach($details as $d){?>
  				<tr>


  					<?php foreach($fields as $f){
  						$ff=$f->TextFieldName;
  						$data = $d->$ff;
  						?>
				          <td><?php echo $data;?></td>
				    <?php } ?>

			    </tr> 
				<?php } ?>
  			<?php  }?>



  </tbody>
</table>