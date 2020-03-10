<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Section_management extends General {

	function __construct() {
		parent::__construct();	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/section_management_model");
		$this->load->model("general_model");
	}

	public function index()
	{
		
		$this->data["info"] =  $this->section_management_model->get_toBeManaged();
		$this->data["has_division"] = $this->section_management_model->has_division($this->session->userdata('company_id'));
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_management/index', $this->data);
		$this->load->view('employee_portal/footer');		
	}	

	public function plot_schedule($group_id)
	{
		$this->data["group_id"] = $group_id;
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_management/plot_schedule' , $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function sections($has_division, $division_id, $department_id)
	{

		$this->data["info"] = $this->section_management_model->get_department_sections($has_division, $division_id, $department_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_management/sections', $this->data);
		$this->load->view('employee_portal/footer');		
	}

	public function groups($has_division, $division_id, $department_id)
	{
		$dept_id = $this->input->post('dept_id');
		$this->data["info"] = $this->section_management_model->get_department_groups($has_division, $division_id, $department_id);
		$this->data["division_id"] = $division_id;
		$this->data['department_id'] = $department_id;
		$this->data['has_division'] = $has_division;
		$this->data['section_list'] = $this->section_management_model->section_list($division_id, $department_id,$this->session->userdata('employee_id')); 
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_management/groups', $this->data);
		$this->load->view('employee_portal/footer');	
	}

	public function test()
	{
		echo var_dump($this->section_management_model->get_department_groups(1, 6, 72));
	}

	public function schedule()
	{
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/section_management/schedule');
		$this->load->view('employee_portal/footer');		
	}

	public function edit_group($group_id)
	{
		$this->data['info'] = $this->section_management_model->get_group_info($group_id);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/section_management/edit_group', $this->data);
		$this->load->view('employee_portal/footer');	
	}

	public function add_schedule()
	{
		$data = $this->section_management_model->add_schedule();
		echo json_encode($data);
	}

	public function remove_schedule()
	{
		$this->section_management_model->remove_schedule();
	}

	public function get_schedule($emp_id)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');

		$data = $this->section_management_model->get_schedule_for_the_month($emp_id, $start, $end);
		echo json_encode($data);
	}

	public function create_group()
	{
		if (empty($this->input->post('member')))
		{
			$this->session->set_flashdata('error', "Unable to create a group. You need to select atleast 1 member.");
			redirect('employee_portal/section_management/index');
		}
		else 
		{
			$group_id = $this->section_management_model->create_group();
			$this->section_management_model->add_group_members($group_id);
			$this->session->set_flashdata('feedback', "You have successfully created a group!");
			redirect('employee_portal/section_management/index');
		}

	}

	public function save_group_changes()
	{
		if (empty($this->input->post('member')))
		{
			$this->session->set_flashdata('error', "Unable to edit group. You need to select atleast 1 member.");
			redirect('employee_portal/section_management/index');
		}
		else 
		{

			$this->section_management_model->edit_group_name();
			$group_id = $this->input->post('group_id');
			$this->section_management_model->deactivate_group_members($group_id);
			$this->section_management_model->add_group_members($group_id);
			$this->session->set_flashdata('feedback', "You have successfully edited a group!");
			redirect('employee_portal/section_management/index');
		}
	}

	public function delete_group()
	{
		$this->section_management_model->delete_group();
		$this->session->set_flashdata('feedback', "You have successfully deleted a group!");
		redirect('employee_portal/section_management/index');
	}

	public function redirect_to($page = "")
	{
		$this->load->view('employee_portal/section_management/' . $page);
	}

	public function view_schedule($employee_id)
	{
		$this->load->view('employee_portal/header');
		$this->data["info"] =  $this->section_management_model->getEmployeeInfo($employee_id);
		$this->load->view('employee_portal/section_management/personnel_schedule', $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get($function_name = "", $parameter = "", $parameter2 = "")
	{
		if ($function_name == '')
		{

		}
		else
		{
			if ($parameter2 != "")
			{
				$data = $this->section_management_model->$function_name($parameter, $parameter2);
				echo json_encode($data);
			}
			else
			{
				$data = $this->section_management_model->$function_name($parameter);
				echo json_encode($data);
			}
		}

	}	

	public function getClassList()
	{
		$data = $this->section_management_model->get_classifications();
		echo json_encode($data);
	}

	public function getSchedule($type)
	{
		$data = $this->section_management_model->get_schedule($type);
		echo json_encode($data);
	}

	public function download_template($type)
	{
		if ($type == 'template')
		{
			$this->load->helper('download');            
			$path    =   file_get_contents(base_url()."public/downloadable_templates/group_working_schedule.xls");
			$name    =   "group_working_schedule.xls";
			force_download($name, $path); 
		}
	}

	public function get_free_members($dept_id, $division_id)
	{
		$data = $this->section_management_model->get_free_members($dept_id, $division_id);
		echo json_encode($data);
	}

	function validateDate($date)
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') === $date;
	}

	function validateTime($time)
	{

		$falseey = false;
		if (preg_match("/([0-2][0-3]|[01][1-9]|10):([0-5][0-9])/", $time)) {
		    $falseey =  true;
		} else {
		    $falseey = false;
		}

		return $falseey;
	}

	function results()
	{
		$this->load->view('employee_portal/section_management/import_success');
	}

	public function upload_template()
	{
	    $foundError = false;

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

                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
           
            } catch(Exception $e) {
            	unlink($inputFileName);

				$this->session->set_flashdata('error', "You attempted to upload file that is not supported by the system. Try again.");
				redirect('employee_portal/section_management/index');
            }

            $objPHPExcel->setActiveSheetIndex(0);
			$sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

           	$forNull = 'Value cannot be null.';
            $forInt = 'Must either be 1 or nothing at all.';
            $forDate = 'Should be in YYYY-MM-DD format. Ex. 1993-12-13 for December 13, 1993';
            $forTime = 'Should be in HH:MM format. Ex. 13:00 for 01:00 PM';

            $styleArray = array(
		    'font'  => array(
		        'bold'  => true,
		        'color' => array('rgb' => 'FF0000')
			));


 			for ($row = 2; $row <= $highestRow; $row++)
 			{
		        $colLetter = 'A';
		        for($col = 0; $col <= $colNumber; $col++)
		        {
					$colrow = $colLetter.(string)$row;
					$getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

					if ($col == 0) //ID number column
					{
						if (empty($getCellvalue))
						{
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  $forNull);	
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							$foundError = True;
						}
					}

					else if ($col == 1) // Date column
					{
						if (!$this->validateDate($getCellvalue))
						{
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '. $forDate);	
							$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							$foundError = True;
						}
					}

					else if ($col == 2 || $col == 3) // Shift IN column
					{
						if (!empty($getCellvalue))
						{
							if (!$this->validateTime($getCellvalue))
							{
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '. $forTime);	
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
							}
						}
					}

					else if ($col == 4) // Rest Day Column
					{
						if (!empty($getCellvalue))
						{
							if ($getCellvalue != '1')
							{
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forInt);	
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
							}
						}
					}
					$colLetter++;
		        }
		    }

		   if(!$foundError)
		   { 
				$departments = $this->section_management_model->my_departments();
				$members = array();

				foreach ($departments as $dept)
				{
					$sections = $this->section_management_model->get_sections($dept->department);
					foreach ($sections as $sec)
					{
						$ppl = $this->section_management_model->getSectionPeople($dept->department, $sec->section, $sec->location);
						
						foreach ($ppl as $p) {
							array_push($members, $p);
						}
					}

				}

				$return = array();
				for ($row = 2; $row <= $highestRow; $row++)
				{
	                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
					$employee_id = $rowData[0][0];
					$date = $rowData[0][1];
					$shift_in = $rowData[0][2];
					$shift_out = $rowData[0][3];
					$rest_day = $rowData[0][4];

					$data = new \stdClass;
					$data->employee_id = $employee_id;
					$data->date = $date;
					$data->shift_in = $shift_in;
					$data->shift_out = $shift_out;
					$data->restday = $rest_day;

					if ($this->is_my_personnel($members, $employee_id)) //Check if employee is a personnel
					{
						$member = $this->get_personnel_data($members, $employee_id);
						$data->first_name = $member->first_name;
						$data->last_name = $member->last_name;
						if ($rest_day == '' || $rest_day == null)
						{
							if ($shift_in == '' || $shift_out == '')
							{
								$data->status = 2;
							}
							else
							{
								$this->section_management_model->insert_schedule($data, false);
								$data->status = 1;
							}
							
							$data->restday = 0;
						}
						else
						{
							$this->section_management_model->insert_schedule($data, true);
							$data->status = 1;
						}

						
					}

					else
					{
						$data->status = 0;
					}

					array_push($return, $data);
	            }

	            unlink($inputFileName);
	            $this->session->set_flashdata('feedback', "You have successfully imported a working schedule.");
	            $this->data["info"] = $return;
				$this->load->view('employee_portal/section_management/import_success', $this->data);

			}
			else
			{
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="' . $fileName. '"');
				header('Cache-Control: max-age=0');
				unlink($inputFileName);
				$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save('php://output');
				exit;
								
			}
	    }

	}

	public function get_personnel_data($members, $employee)
	{
		$member;
		foreach ($members as $m) 
		{
			if ($m->employee_id == $employee)
			{
				$member = $m;
				break;
			}
		}

		return $member;
	}

	public function is_my_personnel($members, $employee)
	{
		$mine = false;
		foreach ($members as $m)
		{
			if ($m->employee_id == $employee)
			{
				$mine = true;
				break;
			}
		}
		return $mine;
	}

	//added controller by mi
	public function get_subsection($section)
	{
		$subsection_list = $this->section_management_model->subsection_list($section,$this->session->userdata('employee_id')); 
		echo "<option selected disabled>Select Subsection</option>";
		foreach($subsection_list as $row){ echo "<option value='".$row->subsection."'>".$row->subsection_name."</option>"; }
	}

	public function employee_list($division,$department,$section,$subsection)
	{
		
		$this->data['employee_list'] = $this->section_management_model->employee_list($division,$department,$section,$subsection,$this->session->userdata('employee_id'),$this->session->userdata('company_id')); 
		$this->load->view('employee_portal/section_management/employee_list', $this->data);

	}

	public function add_group_form($has_division,$division_id,$department_id)
	{ 
		$this->data["division_id"] = $division_id;
		$this->data['department_id'] = $department_id;
		$this->data['has_division'] = $has_division;
		$this->data['section_list'] = $this->section_management_model->section_list($division_id, $department_id,$this->session->userdata('employee_id'));
		$this->load->view('employee_portal/section_management/add_group_form', $this->data);
	}

	public function save_group($has_division,$division,$department,$section,$subsection,$employee_list,$group_name)
	{
		$group_id = $this->section_management_model->create_group($division,$department,$section,$subsection,$employee_list,$group_name);
		$this->data["info"] = $this->section_management_model->get_department_groups($has_division, $division, $department);
		$this->data["division_id"] = $division;
		$this->data['department_id'] = $department;
		$this->data['has_division'] = $has_division;
		$this->data['section_list'] = $this->section_management_model->section_list($division, $department,$this->session->userdata('employee_id')); 
		$this->load->view('employee_portal/section_management/group_list', $this->data);
		
	}
	public function delete_group_one($has_division,$division,$department,$group_id)
	{
		$delete= $this->section_management_model->delete_group_one($group_id);
		$this->data["info"] = $this->section_management_model->get_department_groups($has_division, $division, $department);
		$this->data["division_id"] = $division;
		$this->data['department_id'] = $department;
		$this->data['has_division'] = $has_division;
		$this->data['section_list'] = $this->section_management_model->section_list($division, $department,$this->session->userdata('employee_id')); 
		$this->load->view('employee_portal/section_management/group_list', $this->data);
	}
	public function edit_group_one($has_division,$division,$department,$group_id)
	{  
		$this->data['group_details'] =  $this->section_management_model->edit_get_data($group_id);
		foreach ($this->data['group_details'] as $row) 
		{
		 	$section = $row->section; 
		 	$this->data['group'] = $row->group_name;
		 	$subsection = $row->sub_section;
		 	$this->data['section_list'] =  $this->section_management_model->section_name($section);
			$this->data['subsection_list'] = $this->section_management_model->subsection_name($subsection);
			$this->data['employee_list_selected'] = $this->section_management_model->employee_list_selected($department,$section,$subsection,$group_id);			
		 	$this->data['employee_list'] = $this->section_management_model->employee_list_edit($division,$department,$section,$subsection,$this->session->userdata('employee_id'),$this->session->userdata('company_id'),$group_id);
			$this->data['group_id']=$group_id;
			$this->data['has_division']=$has_division;
			$this->data['division']=$division;
			$this->data['department']=$department;
		}
		$this->load->view('employee_portal/section_management/edit_group', $this->data);
	}

	public function save_updated_group($has_division,$division,$department,$section,$subsection,$employee_list,$group_name,$group_id)
	{ 
		$group_id = $this->section_management_model->update_group($division,$department,$section,$subsection,$employee_list,$group_name,$group_id);
		$this->data["info"] = $this->section_management_model->get_department_groups($has_division, $division, $department);
		$this->data["division_id"] = $division;
		$this->data['department_id'] = $department;
		$this->data['has_division'] = $has_division;
		$this->data['section_list'] = $this->section_management_model->section_list($division, $department,$this->session->userdata('employee_id')); 
		$this->load->view('employee_portal/section_management/group_list', $this->data);
		
	}
	public function back($has_division,$division,$department)
	{
		
		$this->data["info"] = $this->section_management_model->get_department_groups($has_division, $division, $department);
		$this->data["division_id"] = $division;
		$this->data['department_id'] = $department;
		$this->data['has_division'] = $has_division;
		$this->data['section_list'] = $this->section_management_model->section_list($division, $department,$this->session->userdata('employee_id')); 
		$this->load->view('employee_portal/section_management/group_list', $this->data);
		
	}
}