<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Code_of_discipline extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/code_of_discipline_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->load->view('include/header',$this->data); //header	
		$this->load->view('include/sidebar',$this->data); //sidebar	

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message'); 
		$this->load->view('app/notification/code_of_discipline/index',$this->data);

	}


public function chart(){	
		
		$this->load->view('app/notification/code_of_discipline/chart',$this->data);

	}



public function view_all_cod(){	
		$company_id = $this->uri->segment('4');
		//$location_id = $this->uri->segment('5');
		
		$this->data['code_of_discipline'] = $this->code_of_discipline_model->getcod_list($company_id);
		

		$this->load->view('app/notification/code_of_discipline/view_all_cod',$this->data);

	}


public function view_all_cod_disob(){	
		$cod_id = $this->uri->segment('4');
		$company_id = $this->uri->segment('5');
		//$location_id = $this->uri->segment('6');
		
		$this->data['code_of_discipline'] = $this->code_of_discipline_model->getcod_list_disob($cod_id,$company_id);
		

		$this->load->view('app/notification/code_of_discipline/view_all_cod_disob',$this->data);

	}




public function view_company_location(){	
		$company_id = $this->uri->segment("4");
		$this->load->helper('text');
		$autoload['helper'] = array('url', 'form', 'html', 'text');
		$this->data['locationlist'] = $this->code_of_discipline_model->get_company_location($company_id);

		$this->load->view('app/notification/code_of_discipline/company_location',$this->data);

	}


public function view_comploc_discipline(){	


		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message'); 
		$company_id  = $this->uri->segment("4");
		//$location_id = $this->uri->segment("5");
		
		$this->data['comlocnum'] = $this->code_of_discipline_model->getcomlocnum($company_id);

		$this->data['numberinglist'] = $this->code_of_discipline_model->get_cod_numbering();

		$this->data['result'] = $this->code_of_discipline_model->showallcod();

		$this->load->view('app/notification/code_of_discipline/comp_loc_discipline',$this->data);

	}

public function showallcod(){
		$this->load->helper('text');
		$autoload['helper'] = array('url', 'form', 'html', 'text');
		$result = $this->code_of_discipline_model->showallcod();
		echo json_encode($result);

}

function check_numbering(){

		if($this->code_of_discipline_model->is_numbering_available($_POST['cod_num'],$_POST['company_id']) ){
				echo '<label class="text-danger" style="background-color:white;"><span class="glyphicon glyphicon-remove"></span> Numbering is Already Exist </label>';
			  

		}else{
				echo '<label class="text-success" style="background-color:white;"><span class="glyphicon glyphicon-ok"></span> Numbering is Available </label>';
				
				
		}

}


/*function check_title(){
		$title = $this->input->get('title');
		$company_id = $this->input->get('company_id');
		$location_id = $this->input->get('location_id');

		$result = $this->code_of_discipline_model->checking_title($title,$company_id,$location_id);
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);

}*/

public function save_add_cod(){

		$company_id = $this->input->post('company_id');
		//$location_id = $this->input->post('location_id');
		//$codnumbering = $this->input->post('codnumbering');
		$title = $this->input->post('newtitle');
		$check_title = $this->input->post('check_title');
		
		$desc = $this->input->post('newdesc');

		$alreadyexist =	$this->code_of_discipline_model->checking_title($company_id,$check_title);
		
		if($alreadyexist ==1){

			$msg['success'] = 	True;	
			$msg['type'] = 'exist';
			echo json_encode($msg);
		}else{

		$result = $this->code_of_discipline_model->save_add_cod();
		General::logfile('Code of Discipline','ADDED',$check_title);
		//$msg['success'] = 	False;	
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);
		}

}

public function edit_code_discipline(){

	$result = $this->code_of_discipline_model->get_code_discipline();
	echo json_encode($result);
}


public function save_update_cod(){

		$company_id = $this->input->post('company_id');
		//$location_id = $this->input->post('location_id');
		$codnumbering = $this->input->post('codnumbering');
		$title = $this->input->post('newtitle');
		$desc = $this->input->post('newdesc');
		$check_title = $this->input->post('check_title');
		$check_desc = $this->input->post('check_desc');
		

		$alreadyexist =	$this->code_of_discipline_model->checking_title_edit($company_id,$check_title,$check_desc);
		
		if($alreadyexist ==1){

			$msg['success'] = 	True;	
			$msg['type'] = 'exist';
			echo json_encode($msg);
		}else{


	$result = $this->code_of_discipline_model->save_update_cod();
	General::logfile('Code of Discipline','UPDATED',$check_title);
	//$msg['success'] = false;
	$msg['type'] = 'update';
	if($result){
		$msg['success'] = true;
			}
	echo json_encode($msg);
		
	}

}

public function delete_cod(){
		$id = $this->input->get("id");
		$result = $this->code_of_discipline_model->deleting_cod();
		General::logfile('Code of Discipline','DELETED',$id);
		$msg['success'] = 	False;	
		
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);


}

public function disabled_cod(){

		$id = $this->input->get("id");
		//$cod = $this->code_of_discipline_model->get_lists($id);

		$result = $this->code_of_discipline_model->deactivate_cod_list($id);

		// logfile
		//$value = $cod->cod_id." (".$cod->cod_id.")";

		General::logfile('Code of Discipline','DISABLED',$id);
			
		$msg['success'] = 	False;	
		
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);


}

public function enabled_cod(){

		$id = $this->input->get("id");
		//$cod = $this->code_of_discipline_model->get_lists($id);

		$result = $this->code_of_discipline_model->activate_cod_list($id);

		// logfile
		//$value = $cod->cod_id." (".$cod->cod_id.")";

		General::logfile('Code of Discipline','ENABLED',$id);
			
		$msg['success'] = 	False;	
		
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);


}




public function view_disobedience(){	


		$this->load->view('include/header',$this->data); //header	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message'); 
		$company_id  = $this->uri->segment("4");
		//$location_id = $this->uri->segment("5");
		$cod_id = $this->uri->segment("5");
		
		$this->data['comlocnum'] = $this->code_of_discipline_model->getcomlocnum($company_id);

		$this->data['numberinglist'] = $this->code_of_discipline_model->get_cod_numbering();

		$this->data['result'] = $this->code_of_discipline_model->showallcoddis();

		$this->load->view('app/notification/code_of_discipline/view_disobedience',$this->data);

	}


public function showallcoddis(){
		
		$result = $this->code_of_discipline_model->showallcoddis();
		echo json_encode($result);

}

public function showallcoddislist(){
		
		$result = $this->code_of_discipline_model->showallcoddislist();
		echo json_encode($result);

}


public function showallcodpunishlist(){
		
		$result = $this->code_of_discipline_model->showallcodpunishlist();
		echo json_encode($result);

}

public function next_create_new(){

       	$nof = $this->uri->segment("4");
        $company_id = $this->uri->segment("5");
       
        
        $this->load->view('app/notification/code_of_discipline/create_next',$this->data);
    } 

public function next_create_newb(){

       	$nof = $this->uri->segment("4");
       	$company_id = $this->uri->segment("5");
       	
        
        $this->load->view('app/notification/code_of_discipline/create_nextb',$this->data);
    } 


public function save_add_disob(){

		$cod_id 		= $this->input->post('cod_id');
		$company_id		= $this->input->post('company_id');
		$location_id	= $this->input->post('location_id');
		$disob_title	= $this->input->post('newdistitle');
		$check_title	= $this->input->post('newdischktitle');

		$alreadyexist =	$this->code_of_discipline_model->checking_disobtitle($cod_id,$check_title,$company_id,$location_id);
		
		if($alreadyexist ==1){

			$msg['success'] = 	True;	
			$msg['type'] = 'exist';
			echo json_encode($msg);
		}else{

		$result = $this->code_of_discipline_model->save_add_disob();

		General::logfile('Code of Discipline Disobedience','ADDED',$check_title);
		//$msg['success'] = 	False;	
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);
	}

}

public function edit_disobedience(){

	$result = $this->code_of_discipline_model->get_disobedience();
	echo json_encode($result);
}



public function save_update_disobedience(){
		$cod_id 		= $this->input->post('cod_id');
		$company_id		= $this->input->post('company_id');
		$location_id	= $this->input->post('location_id');
		$disob_title	= $this->input->post('newdistitle');
		$check_title	= $this->input->post('newdischktitles');

		$alreadyexist =	$this->code_of_discipline_model->checking_disobtitle($cod_id,$check_title,$company_id);
		
		if($alreadyexist ==1){

			$msg['success'] = 	True;	
			$msg['type'] = 'exist';
			echo json_encode($msg);
		}else{



	$result = $this->code_of_discipline_model->save_update_disobedience();
	General::logfile('Code of Discipline Disobedience','UPDATED',$check_title);
	//$msg['success'] = false;
	$msg['type'] = 'update';
	if($result){
		$msg['success'] = true;
	}
	echo json_encode($msg);

}

}

public function delete_disobedience(){
		$id = $this->input->get('id');
	
		$result = $this->code_of_discipline_model->delete_disobedience();
		General::logfile('Code of Discipline Disobedience','DELETED',$id);
		$msg['success'] = 	False;	
		
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);


}



function check_disob_punish(){

		if($this->code_of_discipline_model->is_disob_available($_POST['disobedience'],$_POST['company_id'],$_POST['cod_id'],$_POST['cod_disob_id']) ){
				echo '<label class="text-danger" style="background-color:white;"><span class="glyphicon glyphicon-remove"></span> Disobedience Punishment is Already Exist </label>';
			  

		}else{
				echo '<label class="text-success" style="background-color:white;"><span class="glyphicon glyphicon-ok"></span> disobedience Punishment is Available </label>';
				
				
		}

}

function check_disob_punish_number(){

		if($this->code_of_discipline_model->is_disob_number_available($_POST['numdis'],$_POST['company_id'],$_POST['cod_id'],$_POST['cod_disob_id']) ){
				echo '<label class="text-danger" style="background-color:white;"><span class="glyphicon glyphicon-remove"></span> Disobedience No. is Already Exist </label>';
			  

		}else{
				echo '<label class="text-success" style="background-color:white;"><span class="glyphicon glyphicon-ok"></span>  Disobedience No. is Available </label>';
				
				
		}

}

public function save_add_punishment(){

	$cod_id = $this->input->post('cod_id');
	$cod_disob_id = $this->input->post('cod_disob_id');
	$company_id = $this->input->post('company_id');
	$location_id = $this->input->post('location_id');
	$disob = $this->input->post('disobedience');
	$suspun = $this->input->post('suspun');
	$numdays = $this->input->post('numdays');
	$numdis = $this->input->post('numdis');
	
		$alreadyexist =	$this->code_of_discipline_model->checking_punishment($cod_id,$cod_disob_id,$suspun,$numdays,$numdis,$disob,$company_id);
		
		if($alreadyexist ==1){

			$msg['success'] = 	True;	
			$msg['type'] = 'exist';
			echo json_encode($msg);
		}else{

		$result = $this->code_of_discipline_model->save_add_punishment();
		General::logfile('Code of Discipline Punishment','ADDED',$disob);

		//$msg['success'] = 	False;	
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);
	}
	
}


public function edit_punishment(){

	$result = $this->code_of_discipline_model->get_punishment();
	echo json_encode($result);
}




public function save_update_punishment(){

	$cod_id = $this->input->post('cod_id');
	$cod_disob_id = $this->input->post('cod_disob_id');
	$company_id = $this->input->post('company_id');
	//$location_id = $this->input->post('location_id');
	$disob = $this->input->post('disobedience');
	$suspun = $this->input->post('suspun');
	$numdays = $this->input->post('numdays');
	$numdis = $this->input->post('numdis');
	
		$alreadyexist =	$this->code_of_discipline_model->checking_punishment($cod_id,$cod_disob_id,$suspun,$numdays,$numdis,$disob,$company_id);
		
		if($alreadyexist ==1){

			$msg['success'] = 	True;	
			$msg['type'] = 'exist';
			echo json_encode($msg);
		}else{

	$result = $this->code_of_discipline_model->save_update_punishment();
	General::logfile('Code of Discipline Punishment','UPDATED',$disob);

	//$msg['success'] = false;
	$msg['type'] = 'update';
	if($result){
		$msg['success'] = true;
	}
	echo json_encode($msg);

	}
}


public function delete_punishment(){
		$id = $this->input->get('id');
	
	
		$result = $this->code_of_discipline_model->delete_punishment();
		General::logfile('Code of Discipline Punishment','DELETED',$disob);

		$msg['success'] = 	False;	
		
		if($result){
			$msg['success'] = 	True;
		}
		echo json_encode($msg);


}


}//controller

