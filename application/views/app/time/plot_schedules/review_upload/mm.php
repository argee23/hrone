	<?php 
	$numOfEmp 		= 0;
    	$foundError 	= False;
    	
    	$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$company = '1';
		$loan = '1';	

			$config['upload_path'] 		= './public/import_template/'; 
	        $config['file_name'] 		= $fileName;
	        $config['allowed_types'] 	= 'xlsx|xls';
	        $config['max_size'] 		= 10000;

	        $this->load->library('upload');
	        $this->upload->initialize($config);
	         if(! $this->upload->do_upload('file'))
	        	$this->upload->display_errors();

	        $media = $this->upload->data('file');
	        $inputFileName = './public/import_template/'.$fileName;
	        $imagepath    =   "user.png";
	          try {
	            $inputFileType 	= IOFactory::identify($inputFileName);
	            $objReader 		= IOFactory::createReader($inputFileType);
	            $objPHPExcel 	= $objReader->load($inputFileName);
	           } catch(Exception $e) {
			       echo "<script>alert('Invalid file format.Please use the template')</script>";
					echo " <script type='text/javascript'>
							    open(location, '_self').close();
							</script>";     	
			   	 }
	        	$objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);
	            //get the number of license
	            	$data 		= $this->employee_model->get_employeee_license(1);
	            	$numLicense = $data[0]->myhris;
	            //end of get the number of license

	            //count the number of isEmployee
	            	$numisEmployee = $this->employee_model->get_employee_isEmployee(1);
	            
	            //number of import data
	            	$numImportexcel		= $highestRow - 1;
	            //$numisEmployee + $numImportexcel
	            	$totalEmployee		= $numImportexcel + $numisEmployee;
	            //Allowed
	            	$allowedEmployee 	= $numLicense - $numisEmployee;
		if(isset($_POST["import"]))
	    {
	    	if($action == 'Save')
	    	{
	    			 //For license purpose
	        if($totalEmployee  <= 	$numLicense){
	        	$forNull 		= 'Value cannot be Null';
	           	 $forDate 		= 'Format:yyyy-mm-dd';
		       		$styleArray = array(
				    	'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => 'FF0000')
				    ));

		         	$nameIndex		= 0;
				 	//check and rewrite the error of imported excel
		          for ($row = 2; $row <= $highestRow; $row++){
		         	$colLetter 		= 'A';
		         	$companyTemp 	= 0;
		         	$divisionTemp 	= 0;
		         	$departmentTemp = 0;
		         	$sectionTemp 	= 0;
		         	$isSubsection 	= false;
				 	$isDivision   	= false;
		         	
		           for($col = 0; $col < $colNumber; $col++){
		            	$colrow = $colLetter.(string)$row;    
					    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
					 
					    	if(empty($getCellvalue)){//If null
					    		if($col == 0 || $col == 1 || $col == 2 || $col == 3 || $col == 4 || $col == 5){ // for null
								$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row,  $forNull);
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
								}
			            	}
			            	else{//If not null
				       //      		if($col==2)
							    //         {
							    //         	$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
											// $check = $this->plot_schedules_model->validateDate($date);
													
											// //echo '<br>'.$new_date;
											// //echo '<br>'.date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($new_date));
											// if($check === false){
											// $objPHPExcel->getActiveSheet()->
											// 			setCellValueByColumnAndRow($col, $row,  $date.' -> '.$forDate);//doesn't exist
											// $objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											// 			$foundError = True;
											// 		}
							    //         		}
				            	}					
				        }
		         	$colLetter++;// increment A
					}//end of col for loop
		         }//end of row for loop
		     
		         //End of check and rewrite the error of imported excel
		         if($foundError==False){ // insert to employee_info table
		        	for ($row = 2; $row <= $highestRow; $row++){
							$numOfEmp++;                                  
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                NULL,TRUE,FALSE);
								        
								        $dt = $date_array = getdate();
								        $formated_date  = "ws";
										$formated_date .= $date_array['mon'];
										$formated_date .= $date_array['mday'];
										$formated_date .= $date_array['year'] . "_";
										$formated_date .= $date_array['hours'];
										$formated_date .= $date_array['minutes'];
										$formated_date .= $date_array['seconds'];
		                				$date_created 	= date('Y-m-d H:i:s');
								        $date_o = $rowData[0][2];
								        $month = date('m', strtotime($date_o));
								        $day = date('d', strtotime($date_o));
								        $year = date('Y', strtotime($date_o));
								        $company_id = $this->plot_schedules_model->get_company($rowData[0][0]);
								        if($rowData[0][4]=='no'){ $restday =0; } else{ $restday =1;}
								       	$data = array(
												'date'					=>				$rowData[0][2],
												'company_id'			=>				$company_id,
												'employee_id'			=>				$rowData[0][0],
												'mm'					=>				$month,
												'dd'					=>				$day,
												'yy'					=>				$year,
												'shift_in'				=>				$rowData[0][5],
												'shift_out'				=>				$rowData[0][6],
												'plotter'				=>				$this->session->userdata('employee_id'),
												'group_id'				=>				0,
												'shift_category'		=>				$rowData[0][3],
												'restday'				=>				$restday,
												'date_plotted'			=> 				date('Y-m-d')
												);
	                							$query = $this->db->insert('working_schedule_07',$data);
	                							$insert = 'inserted';
	            	}//end of insert
			            if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->data['company']=$company;
								$this->load->view('app/time/plot_schedules/review_upload/template_header',$this->data);
								for ($row = 2; $row <= $highestRow; $row++){
									$this->data['col_0']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
									$this->data['col_1']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
									$this->data['col_2']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
									$this->data['col_3']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
									$this->data['col_4']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
									$this->data['col_5']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
									$this->data['col_6']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
									$this->data['col_7']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$this->data['col_8']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$this->load->view('app/time/plot_schedules/review_upload/template_content',$this->data);
								}
								$this->load->view('app/time/plot_schedules/review_upload/template_footer',$this->data);
							       $dt = $date_array = getdate();
							       $formated_date  = "ws_";
							       $formated_date .= $date_array['mon'];
							       $formated_date .= $date_array['mday'];
								   $formated_date .= $date_array['year'] . "_";
								   $formated_date .= $date_array['hours'];
							       $formated_date .= $date_array['minutes'];
								   $formated_date .= $date_array['seconds'];
							    	rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
						} //end of file name for successfully imported
				}//end of else find error
				else{//download if found an error
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' ."employee_loans_enrolment_errr". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
					header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
				}//end of download if found an error
			}//end of For license purpose
			
	    }
	    
		else
		{
			echo "<script>alert('Error report to technical support')</script>";
		}