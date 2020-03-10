<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class code_of_discipline_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	
//GET COMPANY=============================================================	

	public function get_company_name($company){
		$this->db->select('company_name');
		$this->db->where('company_id',$company);
		$query = $this->db->get("company_info");
		return $query->result();
	}
	public function get_company($company_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'InActive'		=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}
	
	public function get_company_location($company_id){

		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
		

	}

	
	public function get_cod_numbering(){

		$this->db->select('*');
		$this->db->order_by('num_id','asc');
		$query = $this->db->get("cod_numbering");
		return $query->result();
		

	}

	public function get_company_loc($company_id){ 
		$this->db->where(array(
			'A.company_id'			=>		$company_id,
			'B.InActive'			=>		0,
		));	
		
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}

	public function get_company_locations($company_id){ 
		$this->db->where(array(
			'A.company_id'			=>		$company_id,
			'B.InActive'			=>		0,
		));	
		
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}


	public function get_company_locations_cod($company_id){ 
		$this->db->where(array(
			'A.company_id'			=>		$company_id,
			'B.InActive'			=>		0,
		));	
		
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$this->db->join('company_code_of_discipline C','C.location_id=A.location_id');
 		$this->db->where('C.company_id',$company_id);
		$query = $this->db->get("company_location A");
		return $query->result();
	}


	public function getcomlocnum($company_id){

		$this->db->select('*');
		$this->db->where(array(
					'company_id' => $company_id
					//'location_id' => $location_id
			));
		$query = $this->db->get('company_code_of_discipline');
		return $query->result();

	}
//START OF VIEW FULL CODE=========================
	public function getcod_list($company_id){

		$company_id  = $this->uri->segment("4");
		//$location_id = $this->uri->segment("5");
		
		$this->db->select('A.cod_id,A.company_id,A.location_id,A.title,A.description,B.num_id,B.numbering');
		$this->db->order_by('A.numbering', 'ASC');
		$this->db->where(array(
					'A.company_id' => $company_id
					//'A.location_id' => $location_id
			));
		$this->db->join("cod_numbering B","B.num_id = A.numbering","left outer");
		$query = $this->db->get('company_code_of_discipline A');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}

	}


	//START OF VIEW FULL CODE=========================
	public function getcod_list_disob($cod_id,$company_id){
		$cod_id  = $this->uri->segment("4");
		$company_id  = $this->uri->segment("5");
		//$location_id = $this->uri->segment("6");
		
		$this->db->select('A.cod_id,A.company_id,A.location_id,A.title,A.description,B.num_id,B.numbering');
		$this->db->order_by('A.numbering', 'ASC');
		$this->db->where(array(
					'A.company_id' => $company_id,
					//'A.location_id' => $location_id,
					'A.cod_id' => $cod_id
			));
		$this->db->join("cod_numbering B","B.num_id = A.numbering","left outer");
		$query = $this->db->get('company_code_of_discipline A');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}

	}

	public function get_disob_for_view_full($company_id,$location_id,$cod_id){

		$company_id  = $this->uri->segment("4");
		$location_id = $this->uri->segment("5");
		$cod_id = $this->uri->segment("6");

		$this->db->select('disob_title');
		$this->db->order_by('cod_disob_id', 'ASC');
		$this->db->where(array(
					'company_id' => $company_id,
					'cod_id' => $cod_id,
					'location_id' => $location_id
			));
	$query = $this->db->get('cod_disobedience');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}


	}

//END OF VIEW FULL CODE==========================

 	public function showallcod(){
		$company_id  = $this->input->get('company_id');
		//$location_id = $this->input->get('location_id');
		//$company_id  = $this->uri->segment("4");
		//$location_id = $this->uri->segment("5");
		
		$this->db->select('A.cod_id,A.company_id,A.location_id,A.title,A.InActive,A.description,B.num_id,B.numbering');
		$this->db->order_by('A.numbering', 'ASC');
		$this->db->where(array(
					'A.company_id' => $company_id
					//'A.location_id' => $location_id
			));
		$this->db->join("cod_numbering B","B.num_id = A.numbering","left outer");
		$query = $this->db->get('company_code_of_discipline A');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}

	

}



 	public function showallcoddis(){
		$company_id  = $this->input->get('company_id');
		//$location_id = $this->input->get('location_id');
		$cod_id = $this->input->get('id');
		/*$company_id  = $this->uri->segment("4");
		$location_id = $this->uri->segment("5");*/
		
		$this->db->select('A.cod_id,A.company_id,A.location_id,A.title,A.description,B.num_id,B.numbering');
		$this->db->order_by('A.numbering', 'asc');
		$this->db->where(array(
					'A.company_id' => $company_id,
					//'A.location_id' => $location_id,
					'A.cod_id' => $cod_id
			));
		$this->db->join("cod_numbering B","B.num_id = A.numbering","left outer");
		$query = $this->db->get('company_code_of_discipline A');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}

}

public function showallcoddislist(){
		$company_id  = $this->input->get('company_id');
		//$location_id = $this->input->get('location_id');
		$cod_id = $this->input->get('id');

		$this->db->select('A.cod_disob_id,A.disob_title,B.disob,B.punish,B.num_days,B.offense,B.pun_id');	
		$this->db->order_by('A.cod_disob_id', 'asc');
		$this->db->where(array(
					'A.company_id' => $company_id,
					//'A.location_id' => $location_id,
					'A.cod_id' => $cod_id
			));
	
		$this->db->join("cod_disob_punish B","B.cod_disob_id = A.cod_disob_id","left outer");
		$this->db->group_by('A.cod_disob_id');
		$query = $this->db->get('cod_disobedience A');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}

}

public function showallcodpunishlist(){
		$cod_disob_id = $this->input->get('id');
		
		$this->db->order_by('pun_id', 'asc');
		$this->db->where('cod_disob_id', $cod_disob_id);
		$query = $this->db->get('cod_disob_punish');
		
		if($query->num_rows() > 0){
		return $query->result();
		}else{
			return false;
		}

}

//CHECK IF ALREADY EXIST=====================================================================================
 public function is_numbering_available($numbering,$company_id){
 	
 	$this->db->where('numbering', $numbering);
 	$this->db->where('company_id', $company_id);
 	//$this->db->where('location_id', $location_id);
 	$query = $this->db->get('company_code_of_discipline');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }

 public function checking_title($company_id,$check_title){
 	//$numbering = $this->input->get('cod_num');

 	//$location = $location_id;

/*	$temp = count($location);
	for($i=0; $i<$temp;$i++){
	
	}*/

	//$this->db->where('numbering', $cod_numbering);
 	$this->db->where('company_id', $company_id);
 	$this->db->where('check_title', $check_title);
 
 	$query = $this->db->get('company_code_of_discipline');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }

  public function checking_title_edit($company_id,$check_title,$check_desc){
 
 	$this->db->where('company_id', $company_id);
 	$this->db->where('check_title', $check_title);
 	$this->db->where('check_desc', $check_desc);
 
 	$query = $this->db->get('company_code_of_discipline');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }


	public function save_add_cod(){

	/*$location = $this->input->post('location');

	$temp = count($this->input->post('location'));
	for($i=0; $i<$temp;$i++){
	}
*/

		$field = array(
				'company_id' 	=> $this->input->post('company_id'),
				//'location_id'	=> $location[$i],
				'numbering'		=> $this->input->post('codnumbering'),
				'title'			=> $this->input->post('newtitle'),
				'description'	=> $this->input->post('newdesc'),
				'check_title'	=> $this->input->post('check_title'),
				'check_desc'	=> $this->input->post('check_desc'),
				'InActive'		=> 0,
				'date_added' 	=> date('Y-m-d H:i:s')
			);
		$this->db->insert('company_code_of_discipline', $field);


		if($this->db->affected_rows() > 0){

			$company_id = $this->input->post('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'add','Company Code Discipline',date('Y-m-d H:i:s'));


			return true;
		}else{
			return false;
		}

}


	public function get_code_discipline(){

			$id = $this->input->get('id');
			$this->db->where('cod_id', $id);
			$query = $this->db->get('company_code_of_discipline');
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}

}

	public function save_update_cod(){
		$id = $this->input->post('cod_id');
		$field = array(
					'company_id' 	=> $this->input->post('company_id'),
					'location_id'	=> $this->input->post('location_id'),
					'numbering'		=> $this->input->post('codnumbering'),
					'title'			=> $this->input->post('newtitle'),
					'description'	=> $this->input->post('newdesc'),
					'check_title'	=> $this->input->post('check_title'),
					'check_desc'	=> $this->input->post('check_desc'),
					'InActive'		=> 0,
					'date_updated' 	=> date('Y-m-d H:i:s')
				);
		$this->db->where('cod_id', $id);
		$this->db->update('company_code_of_discipline', $field);
		if($this->db->affected_rows() > 0){

			$company_id = $this->input->post('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'update','Company Code Discipline',date('Y-m-d H:i:s'));


			return true;
		}else{
			return false;
		}
}


public function deleting_cod(){
		$id = $this->input->get('id');
		$this->db->where('cod_id', $id);
		$this->db->delete('company_code_of_discipline');
		if($this->db->affected_rows() > 0){

			$company_id = $q->row('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'delete','Company Code Discipline',date('Y-m-d H:i:s'));


			return true;
		}else{
			return false;
		}

}


//== FOR DISABLING AUTOMATIC=======================================================================
	public function get_lists($id){
		$this->db->where(array(
			'cod_id'		=>	$id
		));		
		$query = $this->db->get("company_code_of_discipline");
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function deactivate_cod_list($id){

		$this->db->where('cod_id', $id);
		$q = $this->db->get('company_code_of_discipline');

		$company_id = $q->row('company_id');
		$add_logtrails = $this->add_company_policy_logtrail($company_id,'Deactivate','Company Code Discipline id - '.$id,date('Y-m-d H:i:s'));


		$this->db->where('cod_id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("company_code_of_discipline",$this->data);	
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function activate_cod_list($id){

		$this->db->where('cod_id', $id);
		$q = $this->db->get('company_code_of_discipline');


		$this->db->where('cod_id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("company_code_of_discipline",$this->data);

		if($this->db->affected_rows() > 0){
			$company_id = $q->row('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'Activate','Company Code Discipline id - '.$id,date('Y-m-d H:i:s'));

			return true;
		}else{
			return false;
		}		
	}

public function checking_disobtitle($cod_id,$check_title,$company_id){
 	//$numbering = $this->input->get('cod_num');

 	$this->db->where('check_title', $check_title);
 	$this->db->where('cod_id', $cod_id);
 	$this->db->where('company_id', $company_id);
 	//$this->db->where('location_id', $location_id);
 	$query = $this->db->get('cod_disobedience');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }

public function save_add_disob(){

	//$auto_increment=$this->db->insert_id();

		$field = array(
				'cod_id' 		=> $this->input->post('cod_id'),
				'company_id'	=> $this->input->post('company_id'),
				//'location_id'	=> $this->input->post('location_id'),
				'disob_title'	=> $this->input->post('newdistitle'),
				'check_title'	=> $this->input->post('newdischktitle'),
				'InActive'		=> 0,
				'date_added' 	=> date('Y-m-d H:i:s')
			);
		$this->db->insert('cod_disobedience', $field);
		/*if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
*/
	$auto_increment=$this->db->insert_id();

	$cod_id = $this->input->post('cod_id');
	$company_id = $this->input->post('company_id');
	//$location_id = $this->input->post('location_id');
	$disob = $this->input->post('disobedience');
	$punish = $this->input->post('suspun');
	$num_days = $this->input->post('numdays');
	$offense = $this->input->post('numdis');
	


	$temp=count($this->input->post('disobedience'));// count total description

   for($i=0; $i<$temp; $i++){
   $field[$i] = array(
				
				
				'disob' 		=> $disob[$i],
				'punish'		=> $punish[$i],
				'num_days' 		=> $num_days[$i],
				'offense' 		=> $offense[$i],
				'cod_disob_id'  => $auto_increment,
				'cod_id' 		=> $cod_id,
				'company_id' 	=> $company_id,
				//'location_id' 	=> $location_id,
				'InActive'		=> 0,
				'date_added' 	=> date('Y-m-d H:i:s')
            );

        
            $this->db->insert('cod_disob_punish', $field[$i]);
			
   }	  
  			if($this->db->affected_rows() > 0){
  			$add_logtrails = $this->add_company_policy_logtrail($company_id,'add','Disobedience and Punishment under company code discipline'.$cod_id,date('Y-m-d H:i:s'));
				

			return true;
			}else{
			return false;
			}

}


public function get_disobedience(){

			$id = $this->input->get('id');
			$this->db->where('cod_disob_id', $id);
			$query = $this->db->get('cod_disobedience');
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}

}

public function save_update_disobedience(){
		$id = $this->input->post('cod_disob_id');
		$field = array(
					'cod_id' 		=> $this->input->post('cod_id'),
					'company_id'	=> $this->input->post('company_id'),
					//'location_id'	=> $this->input->post('location_id'),
					'disob_title'	=> $this->input->post('newdistitles'),
					'check_title'	=> $this->input->post('newdischktitles'),
					'InActive'		=> 0,
					'date_updated' 	=> date('Y-m-d H:i:s')
				);
		$this->db->where('cod_disob_id', $id);
		$this->db->update('cod_disobedience', $field);
		if($this->db->affected_rows() > 0){

			$company_id = $this->input->post('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'update','Disobedience id -'.$id,date('Y-m-d H:i:s'));



			return true;
		}else{
			return false;
		}
}


public function delete_disobedience(){
			
		$id = $this->input->get('id');

		$this->db->where('cod_disob_id', $id);
		$q = $this->db->get('cod_disobedience');


		$this->db->where('cod_disob_id', $id);
		$this->db->delete('cod_disobedience');

		

		if($this->db->affected_rows() > 0){
			$company_id = $q->row('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'delete','Disobedience id -'.$id,date('Y-m-d H:i:s'));

			return true;
		}else{
			return false;
		}

}


public function checking_punishment($cod_id,$cod_disob_id,$suspun,$numdays,$numdis,$disob,$company_id){
 	//$numbering = $this->input->get('cod_num');
	

 	$this->db->where('disob', $disob);
 	$this->db->where('punish', $suspun);
 	$this->db->where('num_days', $numdays);
 	//$this->db->where('offense', $numdis);
 	$this->db->where('cod_disob_id', $cod_disob_id);
 	$this->db->where('cod_id', $cod_id);
 	$this->db->where('company_id', $company_id);
 	//$this->db->where('location_id', $location_id);
 	$query = $this->db->get('cod_disob_punish');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }

//CHECK IF ALREADY EXIST=====================================================================================
 public function is_disob_available($disobedience,$company_id,$cod_id,$cod_disob_id){
 	//$numbering = $this->input->get('cod_num');

 	$this->db->where('disob', $disobedience);
 	$this->db->where('cod_id', $cod_id);
 	$this->db->where('cod_disob_id', $cod_disob_id);
 	$this->db->where('company_id', $company_id);
 	//$this->db->where('location_id', $location_id);
 	$query = $this->db->get('cod_disob_punish');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }


 public function is_disob_number_available($numdis,$company_id,$cod_id,$cod_disob_id){
 	//$numbering = $this->input->get('cod_num');

 	$this->db->where('offense', $numdis);
 	$this->db->where('cod_id', $cod_id);
 	$this->db->where('cod_disob_id', $cod_disob_id);
 	$this->db->where('company_id', $company_id);
 	//$this->db->where('location_id', $location_id);
 	$query = $this->db->get('cod_disob_punish');
 	if($query->num_rows() > 0){
 		return true;
 	}else{
 		return false;
 	}

 }




public function save_add_punishment(){

	$cod_id = $this->input->post('cod_id');
	$cod_disob_id = $this->input->post('cod_disob_id');
	$company_id = $this->input->post('company_id');
	//$location_id = $this->input->post('location_id');
	$disob = $this->input->post('disobedience');
	$punish = $this->input->post('suspun');
	$num_days = $this->input->post('numdays');
	$offense = $this->input->post('numdis');
	


/*	$temp=count($this->input->post('suspun'));// count total description

   for($i=0; $i<$temp; $i++){*/
   $field = array(
				
				
				'disob' 		=> $disob,
				'punish'		=> $punish,
				'num_days' 		=> $num_days,
				'offense' 		=> $offense,
				'cod_disob_id'  => $cod_disob_id,
				'cod_id' 		=> $cod_id,
				'company_id' 	=> $company_id,
				//'location_id' 	=> $location_id,
				'InActive'      => 0,
				'date_added' 	=> date('Y-m-d H:i:s')
            );
           
            $this->db->insert('cod_disob_punish', $field);
			
 /* }	*/

  			if($this->db->affected_rows() > 0){

  				$add_logtrails = $this->add_company_policy_logtrail($company_id,'add','Punishment under Disobedience id - '.$disob,date('Y-m-d H:i:s'));

			return true;
			}else{
			return false;
			}

}

public function get_punishment(){

			$id = $this->input->get('id');
			$this->db->where('pun_id', $id);
			$query = $this->db->get('cod_disob_punish');
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}

}

public function save_update_punishment(){
		$id = $this->input->post('pun_id');
		$field = array(
			
					'disob' 		=> $this->input->post('disobedience'),
					'punish'		=> $this->input->post('suspun'),
					'num_days' 		=> $this->input->post('numdays'),
					'offense' 		=> $this->input->post('numdis'),
					'cod_disob_id'  => $this->input->post('cod_disob_id'),
					'cod_id' 		=> $this->input->post('cod_id'),
					'company_id' 	=> $this->input->post('company_id'),
					//'location_id' 	=> $this->input->post('location_id'),
					'InActive'      => 0,
					'date_updated' 	=> date('Y-m-d H:i:s')
				);
		$this->db->where('pun_id', $id);
		$this->db->update('cod_disob_punish', $field);
		if($this->db->affected_rows() > 0){

			$company_id = $this->input->post('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'update','Punishment id - '.$id,date('Y-m-d H:i:s'));

			return true;
		}else{
			return false;
		}
}


public function delete_punishment(){
		$id = $this->input->get('id');
		$this->db->where('pun_id', $id);
		$this->db->delete('cod_disob_punish');
		if($this->db->affected_rows() > 0){
			
			$company_id = $q->row('company_id');
			$add_logtrails = $this->add_company_policy_logtrail($company_id,'delete','Punishment id - '.$id,date('Y-m-d H:i:s'));


			return true;
		}else{
			return false;
		}

}

public function add_company_policy_logtrail($company_id,$action,$content,$date)
{
	$this->db->insert('log_trails_company_policy',array('company_id'=>$company_id,'action'=>$action,'content'=>$content,'date_created'=>$date,'added_by'=>$this->session->userdata('employee_id')));
}


}   


