<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_mass_update extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_mass_update_model");
		$this->load->model("general_model");
		//M11
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		//M11
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}


	
	public function index(){


		$this->data['message'] = $this->session->flashdata('message');	
		$employee_mass_update = $this->employee_mass_update_model->getAll();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		//$this->table->set_heading('Select Fields to Update');

		foreach($employee_mass_update as $employee_mass_update){

				$links = '<button class="btn-link" onclick="viewImportTemplate('.$employee_mass_update->id.')">'.$employee_mass_update->field_desc.'</button>';
				
				$this->table->add_row(		
					$links
					);
		}

		$this->data['table_employee_mass_update'] = $this->table->generate();	
		$this->load->view('app/employee/employee_mass_update/employee_mass_update',$this->data);	
	}

	public function mass_update(){
		
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/employee/employee_mass_update/employee_mass_update',$this->data);			
	}

	public function view_ImportTemplate(){
	    $checkboxvalue['fieldselectedvalue'] = $this->input->post('fieldselected');	
		$this->load->view('app/employee/employee_mass_update/view_employee_mass_update',$checkboxvalue);
	}
	

	//Download template
	public function download_employee_mass_update_template() {
		$fieldselectedval 	= $this->uri->segment("4");
		$fieldvalue 		= explode(".",$fieldselectedval);

	
		$fileName   		=   "employee_mass_update.xls";
		$inputFileName 		= './public/downloadable_templates/'.$fileName;
		

        $inputFileType 		= IOFactory::identify($inputFileName);
        $objReader 			= IOFactory::createReader($inputFileType);
        $objPHPExcel 		= $objReader->load($inputFileName);
           

        $objPHPExcel->setActiveSheetIndex(0);
		$sheet 				= $objPHPExcel->getSheet(0);
		$sheet->setTitle("employee mass update");
        $highestRow 		= $sheet->getHighestRow();
        $highestColumn 		= $sheet->getHighestColumn();
        $colNumber 			= PHPExcel_Cell::columnIndexFromString($highestColumn);

	    
        //company
        $count 						= count($fieldvalue);
		$checkcompany				= false;
		$checkdivision				= false;
		$checkdepartment			= false;
		$checksection				= false;
		$bloodtype 					= false;
		$citizenship 				= false;
		$religion 					= false;
		$checkperprovince 			= false;
		$checkpreprovince 			= false;
		$province 					= false;
		$cityper 					= false;
		$citypre 					= false;
		$col 						= 3;
		$row 						= 1;
		$tempprovinceper 			= 0;
		$tempprovincepre 			= 0;
	    $colLetter 					= 'D';
	    $refdate 					= '(yyyy-mm-dd)';
		$refID 						= '(ref: Administrator->File Maintenance';

		//company: cls:13 dep:15 sec:16 com:17 loc:18 rep:22 div:46 sub:47 
		for($val=0;$val<$count;$val++){
			$id = $fieldvalue[$val];

			if($id==17){
				$checkcompany 				= true;
			}
			else if($id==46){
				$checkdivision 				= true;
				//$checksubsection			= true;
			}
			else if($id==15){
				$checkdepartment 			= true;
				//$checksubsection			= true;
			}
			else if($id==16){
				$checksection 				= true;
				//$checksubsection			= true;
			}
			//address: per_pro:31 per_cit:32  pre_pro:35 pre_city:36
			else if($id==31||$id==32){
				$checkperprovince 				= true;
				$province 						= true;
			}
			else if($id==35||$id==36){
				$checkpreprovince 				= true;
				$province 						= true;
			}
		}

		//Company
		if($checkcompany === true){
			for($index = 0; $index < 8; $index++){

				if($index == 0){
					$id = 17;
				}
				else if($index == 1){
					$id = 18;
				}
				else if($index == 2){
					$id = 46;
				}
				else if($index == 3){
					$id = 15;
				}
				else if($index == 4){
					$id = 16;
				}
				else if($index == 5){
					$id = 47;
				}
				else if($index == 6){
					$id = 13;
				}
				else if($index == 7){
					$id = 22;
				}

				$colrow = $colLetter.(string)$row; 
				////echo '<br>'.$id,'::';
				$getvalue = $this->employee_mass_update_model->get_employee_mass_update_data($id);
				$value = $getvalue->field_desc;
				////echo $value;
				$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
				$colLetter++;

			}
		}
        //END COMPANY

        //division
        //company:dep:15 sec:16 div:46 sub:47 
		else if($checkdivision === true){
			for($index = 0; $index < 4; $index++){
				if($index == 0){
					$id = 46;
				}
				else if($index == 1){
					$id = 15;
				}
				else if($index == 2){
					$id = 16;
				}
				else if($index == 3){
					$id = 47;
				}

				$colrow = $colLetter.(string)$row; 
				////echo '<br>'.$id,'::';
				$getvalue = $this->employee_mass_update_model->get_employee_mass_update_data($id);
				$value = $getvalue->field_desc;
				////echo $value;
				$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
				$colLetter++;
			}
		}
        //End division

        //department
        //company:dep:15 sec:16 div:46 sub:47 
		else if($checkdepartment === true){
			for($index = 0; $index < 3; $index++){
				if($index == 0){
					$id = 15;
				}
				else if($index == 1){
					$id = 16;
				}
				else if($index == 2){
					$id = 47;
				}

				$colrow = $colLetter.(string)$row; 
				////echo '<br>'.$id,'::';
				$getvalue = $this->employee_mass_update_model->get_employee_mass_update_data($id);
				$value = $getvalue->field_desc;
				////echo $value;
				$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
				$colLetter++;
			}
		}
        //End department

        //section
        //section: sec:16 sub:47 
		else if($checksection === true){
			for($index = 0; $index < 2; $index++){
				if($index == 0){
					$id = 16;
				}
				else if($index == 1){
					$id = 47;
				}

				$colrow 	= $colLetter.(string)$row; 
				////echo '<br>'.$id,'::';
				$getvalue 	= $this->employee_mass_update_model->get_employee_mass_update_data($id);
				$value 		= $getvalue->field_desc;
				////echo $value;
				$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
				$colLetter++;
			}
		}
        //End section
        //Address
        //per_pro:31 per_cit:32  pre_pro:35 pre_city:36
		if($checkperprovince === true){

			for($index = 0; $index < 2; $index++){
				if($index == 0){
					$id = 31;
				}
				else if($index == 1){
					$id = 32;
				}

				$colrow 	= $colLetter.(string)$row; 
				////echo '<br>'.$id,'::';
				$getvalue 	= $this->employee_mass_update_model->get_employee_mass_update_data($id);
				$value 		= $getvalue->field_desc;
				////echo $value;
				if($id==31){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> provinces)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
				}
				else if($id==32){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> cities)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
				}
				$col++;
				$colLetter++;
			}
		}
		//pre_pro:35 pre_city:36
		if($checkpreprovince === true){

			for($index = 0; $index < 2; $index++){
				if($index == 0){
					$id = 35;
				}
				else if($index == 1){
					$id = 36;
				}

				$colrow 	= $colLetter.(string)$row; 
				////echo '<br>'.$id,'::';
				$getvalue 	= $this->employee_mass_update_model->get_employee_mass_update_data($id);
				$value 		= $getvalue->field_desc;
				////echo $value;
				if($id==35){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> provinces)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
				}
				else if($id==36){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> cities)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
				}
				$col++;
				$colLetter++;
			}
		}
        //End of address

		
		for($val=0;$val<$count;$val++){
			$id = $fieldvalue[$val];
			$colrow = $colLetter.(string)$row; 
			$getvalue = $this->employee_mass_update_model->get_employee_mass_update_data($id);
			$value = $getvalue->field_desc;

			//company: cls:13 dep:15 sec:16 com:17 loc:18 rep:22 div:46 sub:47 
			if($checkcompany === false){
				if($id==13||$id==18||$id==22||$id==47){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
				}
			}

			if($checkdivision === false || $checkdepartment === false || $checksection === false){
				if($id==47){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
				}
			}

			if($id==1||$id==8||$id==9||$id==14||$id==19||$id==20||$id==21||$id==25){
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value.' '.$refID.'->'.$value.')');
				$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

				$col++;
			}
			//per_pro:31 per_cit:32  pre_pro:35 pre_city:36
			/*if($checkpreprovince === false || $checkperprovince === false){
				if($id==32){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' id (ref -> cities)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
					$cityper = true;
					$col++;
				}
				else if($id==36){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $value.' id (ref -> cities)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
					$citypre = true;
					$col++;
				}
			}*/


			if($id==6||$id==45){
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value.' '.$refdate);
				$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

			$col++;
			}
			
			if($id==2||$id==3||$id==4||$id==5||$id==7||$id==23||$id==30||$id==34||$id==38||$id==39||$id==40||$id==41||$id==42||$id==43||$id==44){
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value);
				$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);

			$col++;
			}
			//system parameter: bt:10 cit:11 rel:12 
			if($id==10||$id==11||$id==12){
				if($id==10){
					$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> blood type)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
					$bloodtype = true;
				}
				else if($id==11){
					$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> citizenship)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
					$citizenship = true;
				}
				else if($id==12){
					$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value.' id (ref: sheet -> religion)');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
					$religion = true;
				}
				$col++;
			}
			//End of for system parameters
			//for government fields
			else if($id==24||$id==26||$id==27||$id==28||$id==29){
				$field_name = $getvalue->field_name;
				if($field_name == 'account_no'){
					$field_name = 'account';
				}
				$government_field   =  $this->employee_mass_update_model->get_employee_government_field($field_name);
				$field_format 		=  $government_field->field_format;
				if(!empty($field_format)){
					$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value.' (Format -> '.$field_format.')');
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
				}
				else{
					$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $value);
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->getAlignment()->setWrapText(true);
				}

			$col++;
			}
			//end of for government fields
			$colLetter++;
		}
		//$colLetter++;


		//for reference
		for($sheetindex = 1; $sheetindex < 6; $sheetindex++){
			 $objPHPExcel->createSheet();
        	 $sheet = $objPHPExcel->setActiveSheetIndex($sheetindex);
			 $rowref 		= 2;
			if($sheetindex == 1){
				$sheet->setTitle("blood_type");
				$blood_type		=  $this->employee_mass_update_model->get_bloodtype();
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(0, 1, 'id');
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(1, 1, 'Blood type');

				foreach($blood_type as $blood){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $rowref, $blood->param_id);
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(1, $rowref, $blood->cValue);
						$rowref ++;
				}
			}
			else if($sheetindex == 2){
				$sheet->setTitle("citizenship");
				$citizenship =  $this->employee_mass_update_model->get_citizenship();
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(0, 1, 'id');
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(1, 1, 'Citizenship');

				foreach($citizenship as $citizenship){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $rowref, $citizenship->param_id);
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(1, $rowref, $citizenship->cValue);
						$rowref ++;
				}
			}
			else if($sheetindex == 3){
				$sheet->setTitle("religion");
				$religion		=  $this->employee_mass_update_model->get_religion();
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(0, 1, 'id');
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(1, 1, 'Religion');

				foreach($religion as $religion){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $rowref, $religion->param_id);
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(1, $rowref, $religion->cValue);
						$rowref ++;
				}
			}
			else if($sheetindex == 4){
				$sheet->setTitle("provinces");
				$province			=  $this->employee_mass_update_model->get_province();
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(0, 1, 'id');
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(1, 1, 'Province');

				foreach($province as $province){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $rowref, $province->id);
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(1, $rowref, $province->name);
						$rowref ++;
				}
			}
			else if($sheetindex == 5){
				$sheet->setTitle("cities");
				$city			=  $this->employee_mass_update_model->get_city();
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(0, 1, 'id');
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(1, 1, 'City');
				$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow(2, 1, 'Province id');

				foreach($city as $city){
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $rowref, $city->id);
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(1, $rowref, $city->city_name);
					$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(2, $rowref, $city->province_id);
						$rowref ++;
				}
			}
		}
		
		$objPHPExcel->setActiveSheetIndex(0);
		//end of for reference

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName. '"');
		header('Cache-Control: max-age=0');

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit; 
		
                     
    }
    //End download template

    public function validateDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    if($d && $d->format($format) == $date){
	    	return true;
	    }
	    else{
	    	return false;
	    }
	}

	function _s_has_letters( $string ) {
	    return preg_match( '/[a-zA-Z]/', $string );
	}

	function numbers( $string ) {
	    return preg_match( '/\d/', $string );
	}

	function _s_has_special_chars( $string ) {
	    return preg_match('/[^a-zA-Z\d]/', $string);
	}


    
    //M11: Import Controller import_employee_info_template
    public function update_employee_mass_update()
    {

    	$fieldselectedval 			= $this->uri->segment("4");
		$fieldvalue2 				= explode(".",$fieldselectedval);
		$checkcompany 				= false;
		$checkcompany				= false;
		$checkdivision				= false;
		$checkdepartment			= false;
		$checksection				= false;
		$checkperprovince 			= false;
		$checkpreprovince 			= false;
		$indexaddress 				= 0;
		$count 						= count($fieldvalue2);
		$fieldvalue 				= array();
		$indextemp 					= 0;

		//CHECK COMPANY EXIST
		for($val=0;$val<$count;$val++){

			$id = $fieldvalue2[$val];
			////echo '<br>'.$id;
			/*if($id==17||$id==46||$id==47||$id==15||$id==16||$id==18||$id==13||$id==22){
				$checkcompany = true;
			}*/
			if($id==17){
				$checkcompany 				= true;
			}
			else if($id==46){
				$checkdivision 				= true;
				//$checksubsection			= true;
			}
			else if($id==15){
				$checkdepartment 			= true;
				//$checksubsection			= true;
			}
			else if($id==16){
				$checksection 				= true;
				//$checksubsection			= true;
			}
			else if($id==31||$id==32){
				$checkperprovince 			= true;
			}
			else if($id==35||$id==36){
				$checkpreprovince 			= true;
			}
		}
		//company: cls:13 dep:15 sec:16 com:17 loc:18 rep:22 div:46 sub:47
		if($checkcompany === true){

			$fieldvalue[0] = 17;
			$fieldvalue[1] = 18;
			$fieldvalue[2] = 46;
			$fieldvalue[3] = 15;
			$fieldvalue[4] = 16;
			$fieldvalue[5] = 47;
			$fieldvalue[6] = 13;
			$fieldvalue[7] = 22;

			$count 		= $count + 8;
			$val 		= 0;
			$indextemp 	= 8;

			if($checkpreprovince === true && $checkpreprovince === true){
				$fieldvalue[8]	= 31;
				$fieldvalue[9] 	= 32;
				$fieldvalue[10]	= 35;
				$fieldvalue[11] = 36;
				$count 			= $count + 4;
				$val 			= 0;
				$indextemp 		= 12;
				for($index=12; $index < $count;){
					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '35' && $value != '36' && $value != '17'&& $value != '18' && $value != '46' && $value != '15' && $value != '16' && $value != '47' && $value != '13' && $value != '22'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}

			else if($checkperprovince === true){
				$fieldvalue[8]	= 31;
				$fieldvalue[9] 	= 32;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 10;
				for($index=10; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '35' && $value != '36' && $value != '17'&& $value != '18' && $value != '46' && $value != '15' && $value != '16' && $value != '47' && $value != '13' && $value != '22'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}
			else if($checkpreprovince === true){
				$fieldvalue[8]	= 35;
				$fieldvalue[9] 	= 36;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 10;
				for($index=10; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '35' && $value != '36' && $value != '17'&& $value != '18' && $value != '46' && $value != '15' && $value != '16' && $value != '47' && $value != '13' && $value != '22'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}

			}
			else{
				for($index=8; $index < $count;){
					$value = $fieldvalue2[$val];
					if($checkcompany === true){
						if($value != '17'&& $value != '18' && $value != '46' && $value != '15' && $value != '16' && $value != '47' && $value != '13' && $value != '22'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
						}
					}
					$index++;	
					$val++;	
				}
			}
			//$indexaddress = $indexcom;
		}
		//company: cls:13 dep:15 sec:16 com:17 loc:18 rep:22 div:46 sub:47
		else if($checkdivision === true){

			$fieldvalue[0] = 46;
			$fieldvalue[1] = 15;
			$fieldvalue[2] = 16;
			$fieldvalue[3] = 47;

			$count 		= $count + 4;
			$val 		= 0;
			$indextemp 	= 4;

			if($checkpreprovince === true && $checkpreprovince === true){
				$fieldvalue[4]	= 31;
				$fieldvalue[5] 	= 32;
				$fieldvalue[6]	= 35;
				$fieldvalue[7] 	= 36;
				$count 			= $count + 4;
				$val 			= 0;
				$indextemp 		= 8;
				for($index=8; $index < $count;){
					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '35' && $value != '36' && $value != '46' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}

			else if($checkperprovince === true){
				$fieldvalue[4]	= 31;
				$fieldvalue[5] 	= 32;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 6;
				for($index=6; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '46' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}
			else if($checkpreprovince === true){
				$fieldvalue[4]	= 35;
				$fieldvalue[5] 	= 36;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 6;
				for($index=6; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '35' && $value != '36' && $value != '46' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}

			}

			else{
				for($index=4; $index < $count;){
					$value = $fieldvalue2[$val];
					if($checkdivision === true){
						if($value != '46' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
						}
					}
					$index++;	
					$val++;	
				}
			}
		}
		//company: cls:13 dep:15 sec:16 com:17 loc:18 rep:22 div:46 sub:47
		//address: per_pro:31 per_cit:32  pre_pro:35 pre_city:36
		else if($checkdepartment === true){
			$fieldvalue[0] = 15;
			$fieldvalue[1] = 16;
			$fieldvalue[2] = 47;

			$count 		= $count + 3;
			$val 		= 0;
			$indextemp 	= 3;

			if($checkpreprovince === true && $checkpreprovince === true){
				$fieldvalue[3]	= 31;
				$fieldvalue[4] 	= 32;
				$fieldvalue[5]	= 35;
				$fieldvalue[6] 	= 36;
				$count 			= $count + 4;
				$val 			= 0;
				$indextemp 		= 7;
				for($index=7; $index < $count;){
					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '35' && $value != '36' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}

			else if($checkperprovince === true){
				$fieldvalue[3]	= 31;
				$fieldvalue[4] 	= 32;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 5;
				for($index=5; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}
			else if($checkpreprovince === true){
				$fieldvalue[3]	= 35;
				$fieldvalue[4] 	= 36;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 5;
				for($index=5; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '35' && $value != '36' && $value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}

			}

			else{
				for($index = 3; $index < $count;){
					$value = $fieldvalue2[$val];
					if($checkdepartment === true){
						if($value != '15' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
						}
					}
					$index++;	
					$val++;	
				}
			}
		}
		//address: per_pro:31 per_cit:32  pre_pro:35 pre_city:36
		else if($checksection === true){
			$fieldvalue[0] = 16;
			$fieldvalue[1] = 47;

			$count 		= $count + 2;
			$val 		= 0;
			$indextemp 	= 2;
			
			if($checkpreprovince === true && $checkpreprovince === true){
				$fieldvalue[2]	= 31;
				$fieldvalue[3] 	= 32;
				$fieldvalue[4]	= 35;
				$fieldvalue[5] 	= 36;
				$count 			= $count + 4;
				$val 			= 0;
				$indextemp 		= 6;
				for($index=6; $index < $count;){
					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '35' && $value != '36' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}

			else if($checkperprovince === true){
				$fieldvalue[2]	= 31;
				$fieldvalue[3] 	= 32;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 4;
				for($index=4; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '31' && $value != '32' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}
			else if($checkpreprovince === true){
				$fieldvalue[2]	= 35;
				$fieldvalue[3] 	= 36;
				$count 			= $count + 2;
				$val 			= 0;
				$indextemp 		= 4;
				for($index=4; $index < $count;){

					$value = $fieldvalue2[$val];
					if($value != '35' && $value != '36' && $value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}

			}
			
			else{
				for($index=2; $index < $count;){
					$value = $fieldvalue2[$val];
					if($value != '16' && $value != '47'){
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
					}
					$index++;	
					$val++;	
				}
			}
		}
		//else if($id==31||$id==32){
		/*else if($id==31||$id==32){
				$checkperprovince 			= true;
			}
			else if($id==35||$id==36){
				$checkpreprovince 			= true;
			}*/
		else if($checkperprovince === true){
			$fieldvalue[0] = 31;
			$fieldvalue[1] = 32;

			$count 		= $count + 2;
			$val 		= 0;
			$indextemp 	= 2;

			if($checkpreprovince === true){
				$fieldvalue[0] 	= 31;
				$fieldvalue[1] 	= 32;
				$fieldvalue[2] 	= 35;
				$fieldvalue[3] 	= 36;
				$indextemp	   	= 4;
				$count 			= $count + 2;
			}

			for($index=$indextemp; $index < $count;){
				$value = $fieldvalue2[$val];
				
					if($checkpreprovince === true){
						if($value != '35' && $value != '36' && $value != '31' && $value != '32'){
							////echo '<br>value true'.$value;
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							////echo '<br>fieldvalue:'.$fieldvalue[4];
							$indextemp++;
						}
					}
					else{
						if($value != '31' && $value != '32'){
							////echo '<br>value false:'.$value;
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
						}
					}
				
				$index++;	
				$val++;	
			}
		}

		else if($checkpreprovince === true){
			$fieldvalue[0] = 35;
			$fieldvalue[1] = 36;

			$count 		= $count + 2;
			$val 		= 0;
			$indextemp 	= 2;

			if($checkperprovince === true){
				$fieldvalue[0] 	= 31;
				$fieldvalue[1] 	= 32;
				$fieldvalue[2] 	= 35;
				$fieldvalue[3] 	= 36;
				$indextemp	   	= 4;
				$count 			= $count + 2;
			}

			for($index=$indextemp; $index < $count;){
				$value = $fieldvalue2[$val];
				
					if($checkperprovince === true){
						if($value != '35' && $value != '36' && $value != '31' && $value != '32'){
							//////echo '<br>value true'.$value;
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							////echo '<br>fieldvalue:'.$fieldvalue[4];
							$indextemp++;
						}
					}
					else{
						if($value != '35' && $value != '36'){
							////echo '<br>value false:'.$value;
							$fieldvalue[$indextemp] = $fieldvalue2[$val];
							$indextemp++;
						}
					}
				
				$index++;	
				$val++;	
			}
		}

		else{
			for($index=0; $index < $count; $index++){
					$fieldvalue[$index] = $fieldvalue2[$index];
			}
		}
        //END OF COMPANY EXIST

        ////echo '<br>Count:'.count($fieldvalue);
    	
    	$numOfEmp 	= 0;
    	$foundError = False;
    	$excelEmpID = array();
    	$result 	= 0;
    	
	    if(isset($_POST["import"]))
	    {

			$fileName = $_FILES['file']['name'];

	        $config['upload_path'] = './public/import_template/'; 
	        $config['file_name'] = $fileName;
	        $config['allowed_types'] = 'xlsx|xls';
	        $config['max_size'] = 10000;

	        $this->load->library('upload');
	        $this->upload->initialize($config);

	        if(! $this->upload->do_upload('file') )
	        	$this->upload->display_errors();

	        $media = $this->upload->data('file');
	        $inputFileName = './public/import_template/'.$fileName;

        	try {

                $inputFileType 	= IOFactory::identify($inputFileName);
                $objReader 		= IOFactory::createReader($inputFileType);
                $objPHPExcel 	= $objReader->load($inputFileName);
           
            } catch(Exception $e) {
            	unlink($inputFileName);
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Please resave the data in diffrent folder. Error file type/file name. Allowed file type: .xlsx/.xls. filename should not have charset.</div>");
				redirect('app/employee_mass_update/index');	
            }

            $objPHPExcel->setActiveSheetIndex(0);
			$sheet 			= $objPHPExcel->getSheet(0);
            $highestRow 	= $sheet->getHighestRow();
            $highestColumn 	= $sheet->getHighestColumn();
            $colNumber 		= count($fieldvalue) + 3;
            ////echo '<br>count:'.count($fieldvalue);
            //$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            

	        $forNull 	= 'Value cannot be Null';
	        $forInt 	= 'Must be Number. ID number is required';
	        $forIDNull 	= 'ID must not be null';
	        $existDB 	= '*Please check the Employee_id. Employee ID does not exist in the Database*';
	        $existdata 	= 'Please check ID does not exist please';
	        $forDate 	= 'Format:yyyy-mm-dd';
	        $forZero 	= 'Emp ID Must not start with zero';
	        $forRef 	= 'ID does not exist please check the reference';
	        $forGov 	= 'Format does not coincide with the format given';

            $styleArray = array(
		    'font'  => array(
		        'bold'  => true,
		        'color' => array('rgb' => 'FF0000')
		    ));

		     //check and rewrite the error of imported excel
	        for ($row = 2; $row <= $highestRow; $row++){

            	$colLetter 			= 'A';
            	$companyTemp 		= 0;
	         	$divisionTemp 		= 0;
	         	$departmentTemp 	= 0;
	         	$sectionTemp 		= 0;
	         	$perprovinceTemp 	= 0;
	         	$preprovinceTemp 	= 0;
	         	$isSubsection 		= false;
			 	$isDivision   		= false;
			 	////echo '<br>colNumber:'.$colNumber;
            	for($col = 0; $col < $colNumber; $col++){
            		////echo 'colnum:'.$colNumber;
            		////echo '<br>id:'.$fieldvalue[$col];
            		if($col>2){
						$id 		= $fieldvalue[$col-3];
						//echo '<br>idhaha:'.$id;
						////echo '<br>fieldvalue:'.($col-3);
						$getvalue 	= $this->employee_mass_update_model->get_employee_mass_update_data($id);
						$table 		= $getvalue->field_table;
						$field 		= $getvalue->field_name;
					}

            	$colrow = $colLetter.(string)$row;  //get column and row e.g A1        
		            	//put a variable here that will handle the column and row(col start at 0, row start at 1)
			    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

	           if($col == 0){//check the error of employee ID column
	           	    $excelEmpID[] = $getCellvalue; // pass the value to array $excelEmpID[]
					if(empty($getCellvalue)){
						$objPHPExcel->getActiveSheet()->
					setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forNull);//null
					$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
						$foundError = True;
	            	}
	            	else{//if not empty
            			if ($getCellvalue{0}=="0") { // empID that start with zero
							$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '. $forZero);//start zero
						$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							$foundError = True;
						}
						else{
							$numisEmployee 	= $this->employee_mass_update_model->get_employee_isEmployee(1);
							$getDBEmpID 	= $this->employee_mass_update_model->get_all_employeeID_DB();
							$result 		= count($excelEmpID);
							$rowdb			= 2;
							$colLetter = 'A';
							for($value = 0; $value < $result; $value++){//for compare db employee_id
								$checkdb = false;
								$excelID = $excelEmpID[$value];
								$colrow = $colLetter.(string)$rowdb;
								$getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $rowdb)->getValue();
								////echo '$excelID:'.$excelID;
								for($valuedb = 0; $valuedb < $numisEmployee; $valuedb++){
									$tempvalue = $getDBEmpID[$valuedb]->employee_id;
									if($excelID == $tempvalue){
										$checkdb = true;
									}
									
								}
								if($checkdb===false){
										$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow(0, $rowdb, $getCellvalue.' -> '.$existDB);//
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
								}
								$rowdb++;
							}//value in the excel
							//End of if the empID doesn't exist in the database
							if($checkdb === true){
								$employee_id 	 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$employment_info = $this->employee_mass_update_model->get_employment_info($employee_id);
								////echo '<br>company:'.$employment_info[0]->company_id;
								$companyTemp 	= $employment_info->company_id;
					         	$divisionTemp 	= $employment_info->division_id;
					         	$departmentTemp = $employment_info->department;
					         	$sectionTemp 	= $employment_info->section;
					         	$isSubsection 	= $this->employee_mass_update_model->check_isSubsection($sectionTemp);
							 	$isDivision   	= $this->employee_mass_update_model->check_isDivision($companyTemp);

							}
						}
	            	}//end of if not empty
	            }//end of check error of column
	            else if($col > 2){
	            	//	           //echo '<br>'.$id; 	
	            	if($id==1||$id==8||$id==9||$id==13||$id==14||$id==15||$id==16||$id==17||$id==18||$id==19||$id==20||$id==21||$id==22||$id==25||$id==10||$id==11||$id==12||$id==31||$id==32||$id==35||$id==36){
	            		//system parameter: bt:10 cit:11 rel:12
	            		//address: per_pro:31 per_cit:32  pre_pro:35 pre_city:36 
	            		if(empty($getCellvalue)){
	            			if($id != 22){
								$objPHPExcel->getActiveSheet()->
							setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forNull);//null
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
							}
		            	}
	            		else if(!is_numeric($getCellvalue)){//if value must be number
							$objPHPExcel->getActiveSheet()->
							setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forInt);//Number
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							$foundError = True;
						}
						
						else{//if value doesn't exist
						//company: cls:13 dep:15 sec:16 com:17 loc:18 rep:22 div:46 sub:47 
							if($id == 8){
								$gender =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isGenderExist = $this->employee_mass_update_model->check_isGenderExist($gender);
		            			if($isGenderExist === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 9){
								$civil_status =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();;
		            			$isCivilStatusExist = $this->employee_mass_update_model->check_isCivilStatusExist($civil_status);
		            			if($isCivilStatusExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 13){ // classification
								$classification =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isClassificationExist = $this->employee_mass_update_model->check_isClassificationExist($companyTemp, $classification);
		            			if($isClassificationExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 14){
								$employment =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isEmploymentExist = $this->employee_mass_update_model->check_isEmploymentExist($employment);
		            			if($isEmploymentExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 15){
								$department =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								if ($isDivision === true){
		            				$isDepartmentExist = $this->employee_mass_update_model->check_isDepartmentDivisionExist($divisionTemp, $department);
		            			}
		            			else{
		            				$isDepartmentExist = $this->employee_mass_update_model->check_isDepartmentCompanyExist($companyTemp, $department);
		            			}

		            			if($isDepartmentExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
		            			else{
		            				$departmentTemp = $department;
		            			}
							}
							else if($id == 16){
								$section 		= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$isSubsection 	= $this->employee_mass_update_model->check_isSubsection($section);
		            			$isSectionExist = $this->employee_mass_update_model->check_isSectionExist($departmentTemp,$section);
		            			if($isSectionExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
		            			else{
		            				$sectionTemp = $section;
		            			}
							}
							else if($id == 17){
								$company 		= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$isDivision 	= $this->employee_mass_update_model->check_isDivision($company);
		            			$isCompanyExist = $this->employee_mass_update_model->check_isCompanyExist($company);
		            			if($isCompanyExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
		            			else{
		            				$companyTemp = $company;
		            			}
							}
							else if($id == 18){
								$location =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isLocationExist = $this->employee_mass_update_model->check_isLocationExist($companyTemp,$location);
		            			if($isLocationExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 19){
								$position = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isPositionExist = $this->employee_mass_update_model->check_isPositionExist($position);
		            			if($isPositionExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 20){
								$taxcode =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isTaxcodeExist = $this->employee_mass_update_model->check_isTaxcodeExist($taxcode);
		            			if($isTaxcodeExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 21){
								$paytype =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isPaytypeExist = $this->employee_mass_update_model->check_isPaytypeExist($paytype);
		            			if($isPaytypeExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 22){
								$reportTo =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isReportToExist = $this->employee_mass_update_model->check_isReportToExist($companyTemp,$reportTo);
		            			if($isReportToExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 25){
								$bank  =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isBankExist 	= $this->employee_mass_update_model->check_isBankExist($bank);
		            			if($isBankExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							//system parameter: bt:10 cit:11 rel:12 
							else if($id == 10){
								$bloodtype  		=  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isBloodtypeExist 	= $this->employee_mass_update_model->check_isBloodTypeExist($bloodtype);
		            			if($isBloodtypeExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 11){
								$citizenship  		=  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isCitizenshipExist 	= $this->employee_mass_update_model->check_isCitizenshipExist($citizenship);
		            			if($isCitizenshipExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							else if($id == 12){
								$religion  		=  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isReligionExist 	= $this->employee_mass_update_model->check_isReligionExist($religion);
		            			if($isCitizenshipExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							//address: per_pro:31 per_cit:32  pre_pro:35 pre_city:36
							else if($id == 31){
								$perprovince 	 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isProvinceExist = $this->employee_mass_update_model->check_isProvinceExist($perprovince);
		            			if($isProvinceExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
		            			else{
		            				$perprovinceTemp 	= $perprovince;
		            			}
							}
							else if($id == 32){
								$percity 		= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isCityExist = $this->employee_mass_update_model->check_isCityExist($perprovinceTemp,$percity);
		            			if($isCityExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}

							else if($id == 35){
								$preprovince 	 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isProvinceExist = $this->employee_mass_update_model->check_isProvinceExist($preprovince);
		            			if($isProvinceExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
		            			else{
		            				$preprovinceTemp 	= $preprovince;
		            			}
							}
							else if($id == 36){
								$precity 		= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
		            			$isCityExist = $this->employee_mass_update_model->check_isCityExist($preprovinceTemp,$precity);
		            			if($isCityExist  === false){
		            				$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
		            			}
							}
							//sss:24 acc:26 tin:27 pag:28 ph:29
							//if($id==17){
							//	$field_name = $field;
							//}
							//else{
							//	$field_name = $field.'_id';
							//}
							//$checkvalue = $this->employee_mass_update_model->check_value_exist($table,$field_name,$getCellvalue);
							//if($checkvalue){
							//	$objPHPExcel->getActiveSheet()->
							//	setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$existdata);//doesn't exist
							//	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							//	$foundError = True;
							//}
							
						}
	            	}
	            	//sss:24 acc:26 tin:27 pag:28 ph:29
	            	else if($id==24||$id==26||$id==27||$id==28||$id==29){
	            		////echo '<br>'.$id;
	            		if(empty($getCellvalue)){
							$objPHPExcel->getActiveSheet()->
							setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forNull);//null
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
		            	}
		            	else{
							$split_value	= str_split($getCellvalue);
							if($id==24){
								$format_id	= 1;
							}
							else if($id==26){
								$format_id	= 5;
							}
							else if($id==27){
								$format_id	= 2;
							}
							else if($id==28){
								$format_id	= 4;
							}
							else if($id==29){
								$format_id	= 3;
							}


							$format 	= $this->employee_mass_update_model->get_format_data($format_id);
							if(!empty($format->field_format)){
								$split_format	= str_split($format->field_format);
								if(count($split_format) != count($split_value)){
									$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forGov);//Number
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
								}
								else{
									for($num = 0; $num < count($split_format); $num++){

										if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', ($split_format[$num]))){
											if($split_format[$num] != $split_value[$num]){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forGov);//Number
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
											}	
										}

									}
								}
							}   

						}   		

	            	}
	            	else if($id==6||$id==45){
	            		//$date = DateTime::createFromFormat('Y-m-d', $getCellvalue);
	            		if(empty($getCellvalue)){
							$objPHPExcel->getActiveSheet()->
							setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forNull);//null
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
		            	}
		            	else{
							$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$check = $this->validateDate($date);
								
								if($check === false){
									$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
								}
						}
	            	}
	            	else if($id == 46){
						if ($isDivision === true){
							$division =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
	            			$isDivisionExist = $this->employee_mass_update_model->check_isDivisionExist($companyTemp,$division);
	            			if(empty($getCellvalue)){
								$objPHPExcel->getActiveSheet()->
							setCellValueByColumnAndRow($col, $row,  $forNull);//null
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
			            	}
	            			if($isDivisionExist  === false){
	            				$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
	            			}
	            			else{
	            				$divisionTemp = $division;
	            			}
            			}
					}
					else if($id == 47){
						if ($isSubsection === true ){
							$subsection =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
	            			$isSubsectionExist = $this->employee_mass_update_model->check_isSubsectionExist($sectionTemp,$subsection);
	            			if(empty($getCellvalue)){
								$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forNull);//null
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
			            	}
	            			if($isSubsectionExist  === false){
	            				$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
	            			}
            			}
					}
					else{
	            		if(empty($getCellvalue)){
							$objPHPExcel->getActiveSheet()->
							setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forNull);//null
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
		            	}
	            	}
	            }
				$colLetter++;// increment A
				} //end of col for loop
			} // end of row for loop
			
			
			
			if($foundError==False){ // insert to employee_info table
				//echo '<br>highest:'.$highestRow;
				for ($row = 2; $row <= $highestRow; $row++){
	            	$numOfEmp++;     
	            	//echo '<br>highest:'.$highestRow;
	            	//echo '<br>colNumber:'.$colNumber;                             
	                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
	                                                NULL,
	                                                TRUE,
	                                                FALSE);
	                                                                             
	                for($val=3;$val<$colNumber;$val++){
		                $empID 		= $rowData[0][0];
		                $fieldValue = $rowData[0][$val];
		                $company_id = $rowData[0][3];
		                $data 		= array();

							$id 		= $fieldvalue[$val-3];
							$getvalue 	= $this->employee_mass_update_model->get_employee_mass_update_data($id);
							$field 		= $getvalue->field_name;

						if($id === 17){
							//Payroll_pagibig_table
							if($checkcompany === true){
								$check_employee_exist 	= $this->employee_mass_update_model->check_pagibig_employee_exist($empID);
								if($check_employee_exist === true){ 
									$pagibig_setting 		= $this->employee_mass_update_model->get_pagibig_employee_setting();
									$checkpagibig 			= false;
									$current_year 			= date('Y', strtotime(date("Y-m-d")));

									foreach($pagibig_setting as $pagibig){

										$data_pagibig = array(
											'employee_id'		=> $empID,
											'company_id'		=> $company_id,
											'amount'			=> $pagibig->amount,
											'cut_off_id'		=> $pagibig->cut_off_id,
											'pagibig_type_id'	=> $pagibig->pagibig_type_id,
											'year'				=> $current_year
										);
										$this->employee_mass_update_model->insert_pagibig_employee_setting($data_pagibig);
										$checkpagibig = true;
									}
									if($checkpagibig === false){
										$data_pagibig = array(
											'employee_id'		=> $empID,
											'company_id'		=> $company_id,
											'year'				=> $current_year
										);
										$this->employee_mass_update_model->insert_pagibig_employee_setting($data_pagibig);
									}
								}
							}
							//End of Payroll_pagibig_table
						}
		                if($id==6||$id==45){
		                	//$fieldValue = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($rowData[0][3]));
		                	$fieldValue 	 = date('Y-m-d', strtotime($rowData[0][$val]));
		                	 if($id==6){
		                	 	$age = floor((time() - strtotime($fieldValue))/31556926);
		                	 	$data = array(
									$field  => $fieldValue,
									'age' => $age 
		                     	);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Mass Update','logfile_employee_mass_update','update : '.$field.'|'.$fieldValue.' ','UPDATE',$empID);


		                	 }
		                	 else{
		                	 	$data = array(
									$field  => $fieldValue
		                     	);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Mass Update','logfile_employee_mass_update','update : '.$field.'|'.$fieldValue.' ','UPDATE',$empID);


		                	 }
		                	 $update = $this->employee_mass_update_model->updateImport($data,$empID);
		                }
		                //normal : fn:2 md:3 ln:4 nn:5 bp:7 bt:10 rel:12 email:23 pa:30 pp:31 pc:32 py:33 pa:34 pp:35 pc:36 py:37 mob1:38 mob2:39 tel1:40 tel2:41  fb:42 tw:43 ig:44
		                else if($id==2||$id==3||$id==4||$id==5||$id==7||$id==10||$id==11||$id==12||$id==23||$id==30||$id==31||$id==32||$id==33||$id==34||$id==35||$id==36||$id==37||$id==38||$id==39||$id==40||$id==41||$id==42||$id==43||$id==44){
		                	if($id==2||$id==3||$id==4){
			                	$fieldValue = ucfirst($rowData[0][$val]);
			                	$empInfo 	= $this->employee_mass_update_model->get_row_employee_info($empID);
			                	$fullname;
			                	 if($id==2){
			                	 	$middlename = $empInfo->middle_name;
			                	 	$lastname 	= $empInfo->last_name;
			                	 	$name_ext 	= $empInfo->name_extension;
			                	 	$fullname 	= $fieldValue." ".$middlename." ".$lastname." ".$name_ext;
			                	 }
			                	 else if($id==3){
			                	 	$firstname 	= $empInfo->first_name;
			                	 	$lastname 	= $empInfo->last_name;
			                	 	$name_ext 	= $empInfo->name_extension;
			                	 	$fullname 	= $firstname." ".$fieldValue." ".$lastname." ".$name_ext;
			                	 }
			                	 else{
			                	 	$firstname 	= $empInfo->first_name;
			                	 	$middlename = $empInfo->middle_name;
			                	 	$name_ext 	= $empInfo->name_extension;
			                	 	$fullname 	= $firstname." ".$middlename." ".$fieldValue." ".$name_ext;
			                	 }
			                	 $data = array(
									$field  	=> $fieldValue,
									'fullname' 	=> $fullname
			                     );
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Mass Update','logfile_employee_mass_update','update : '.$field.'|'.$fieldValue.' ','UPDATE',$empID);


		                	}
		                	else{
		                		$fieldValue = $rowData[0][$val];
			                	 $data = array(
									$field  => $fieldValue
			                     );
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Mass Update','logfile_employee_mass_update','update : '.$field.'|'.$fieldValue.' ','UPDATE',$empID);


		                	}
		                	$update = $this->employee_mass_update_model->updateImport($data,$empID);
		                }
		                else{
		                	 $data = array(
								$field  => $fieldValue
		                     );
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Mass Update','logfile_employee_mass_update','update : '.$field.'|'.$fieldValue.' ','UPDATE',$empID);


			

		                     $update = $this->employee_mass_update_model->updateImport($data,$empID);
		                }
	                }
	            }//end of insert							
	            if($update){ //file name for successfully imported
				    $dt = $date_array = getdate();
				       $formated_date  = "employee_mass_update_";
				       $formated_date .= $date_array['mon'];
				       $formated_date .= $date_array['mday'];
					   $formated_date .= $date_array['year'] . "_";
					   $formated_date .= $date_array['hours'];
				       $formated_date .= $date_array['minutes'];
					   $formated_date .= $date_array['seconds'];
				    rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );

				    General::logfile('Mass update','INSERT',$numOfEmp.' employee(s) added');




					$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$numOfEmp." Employee(s) Successfully Modified!</div>");
					redirect('app/employee_mass_update/index');	
				} //end of file name for successfully imported
				
			}//end of else find error
			else{//download if found an error
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' . $fileName. '"');
					header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
			}//end of download if found an error
		
	    }//End of if has imported value
	    else{
	    	unlink($inputFileName);
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Something is wrong with your data!</div>");
				redirect('app/employee_mass_update/index');	
	    }//Start of if no value
		
	}//M11: End of Import Controller import_employee_info_template
	
}