<?php
	
	/*
	kapag marked as absent pero
	hindi restday , hindi reg holiday , hindi snw holiday
	*/
	if(($checkhol_regular_hour=="absent")AND($checkhol_isrestday=="")AND($checkhol_is_regular_holiday=="")AND($checkhol_is_snw_holiday=="")){
	$Datesforchecked_verdict="deductme";  
	}
	elseif(($checkhol_isrestday=="<i class='fa fa-check'></i>" OR $checkhol_is_regular_holiday=="<i class='fa fa-check'></i>" OR $checkhol_is_snw_holiday=="<i class='fa fa-check'></i>")AND($checkhol_regular_hour=="")){  
		/*
		kapag restday ,  reg holiday ,  snw holiday
		*/
		// minus 1 date : check the result date //1st prev day
		$the_date = new DateTime($the_date);
		$the_date->modify($to_check_day.' day');
		$the_date=$the_date->format('Y-m-d');

		$the_date_state=$this->time_dtr_model->check_holiday_policy_on_date($employee_id,$the_date);
		if(!empty($the_date_state)){
				$checkhol_regular_hour=$the_date_state->checkhol_regular_hour;
				$checkhol_isrestday=$the_date_state->checkhol_isrestday;
				$checkhol_isrestday_snw_holiday=$the_date_state->checkhol_isrestday_snw_holiday;
				$checkhol_isrestday_reg_holiday=$the_date_state->checkhol_isrestday_reg_holiday;

				$checkhol_is_regular_holiday=$the_date_state->checkhol_is_regular_holiday;
				$checkhol_is_snw_holiday=$the_date_state->checkhol_is_snw_holiday;
				$checkhol_is_leave=$the_date_state->leave_fast_hol_reference;

			
				if(($checkhol_regular_hour=="absent")AND($checkhol_isrestday=="")AND($checkhol_is_regular_holiday=="")AND($checkhol_is_snw_holiday=="")){
				$Datesforchecked_verdict="deductme";

				}
				// previous date was restday OR regular holiday OR snw holiday
				elseif(($checkhol_isrestday=="<i class='fa fa-check'></i>" OR $checkhol_is_regular_holiday=="<i class='fa fa-check'></i>" OR $checkhol_is_snw_holiday=="<i class='fa fa-check'></i>")AND($checkhol_regular_hour=="absent")){
					// minus 1 date : check the result date //2nd prev day
					$the_date = new DateTime($the_date);
					$the_date->modify($to_check_day.' day');
					$the_date=$the_date->format('Y-m-d');

					$the_date_state=$this->time_dtr_model->check_holiday_policy_on_date($employee_id,$the_date);
					if(!empty($the_date_state)){
							$checkhol_regular_hour=$the_date_state->checkhol_regular_hour;
							$checkhol_isrestday=$the_date_state->checkhol_isrestday;
							$checkhol_isrestday_snw_holiday=$the_date_state->checkhol_isrestday_snw_holiday;
							$checkhol_isrestday_reg_holiday=$the_date_state->checkhol_isrestday_reg_holiday;

							$checkhol_is_regular_holiday=$the_date_state->checkhol_is_regular_holiday;
							$checkhol_is_snw_holiday=$the_date_state->checkhol_is_snw_holiday;
							$checkhol_is_leave=$the_date_state->leave_fast_hol_reference;

							// previous date was not restday, not regular holiday,not snw holiday
							if(($checkhol_regular_hour=="absent")AND($checkhol_isrestday=="")AND($checkhol_is_regular_holiday=="")AND($checkhol_is_snw_holiday=="")){
							$Datesforchecked_verdict="deductme";
							}
							// previous date was restday OR regular holiday OR snw holiday
							elseif(($checkhol_isrestday=="<i class='fa fa-check'></i>" OR $checkhol_is_regular_holiday=="<i class='fa fa-check'></i>" OR $checkhol_is_snw_holiday=="<i class='fa fa-check'></i>")AND($checkhol_regular_hour=="absent")){

								// minus 1 date : check the result date //3rd prev day
								$the_date = new DateTime($the_date);
								$the_date->modify($to_check_day.' day');
								$the_date=$the_date->format('Y-m-d');

								$the_date_state=$this->time_dtr_model->check_holiday_policy_on_date($employee_id,$the_date);
								if(!empty($the_date_state)){
										$checkhol_regular_hour=$the_date_state->checkhol_regular_hour;
										$checkhol_isrestday=$the_date_state->checkhol_isrestday;
										$checkhol_isrestday_snw_holiday=$the_date_state->checkhol_isrestday_snw_holiday;
										$checkhol_isrestday_reg_holiday=$the_date_state->checkhol_isrestday_reg_holiday;

										$checkhol_is_regular_holiday=$the_date_state->checkhol_is_regular_holiday;
										$checkhol_is_snw_holiday=$the_date_state->checkhol_is_snw_holiday;
										$checkhol_is_leave=$the_date_state->leave_fast_hol_reference;
										// previous date was not restday, not regular holiday,not snw holiday
										if(($checkhol_regular_hour=="absent")AND($checkhol_isrestday=="")AND($checkhol_is_regular_holiday=="")AND($checkhol_is_snw_holiday=="")){
										$Datesforchecked_verdict="deductme";
										}
										// previous date was restday OR regular holiday OR snw holiday
										elseif(($checkhol_isrestday=="<i class='fa fa-check'></i>" OR $checkhol_is_regular_holiday=="<i class='fa fa-check'></i>" OR $checkhol_is_snw_holiday=="<i class='fa fa-check'></i>")AND($checkhol_regular_hour=="absent")){
											// end of checking
										}else{
											$Datesforchecked_verdict="";
										}

								}else{
										$checkhol_regular_hour="";	
										$Datesforchecked_verdict="";
								}

							}else{
								$Datesforchecked_verdict="";
							}

					}else{
							$checkhol_regular_hour="";
							$Datesforchecked_verdict="";	
					}


				}else{
					$Datesforchecked_verdict="";
				}

		}else{
				$checkhol_regular_hour="";	
				$Datesforchecked_verdict="";
		}


	}else{
		$Datesforchecked_verdict="";
	}

	?>