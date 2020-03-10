<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Checking_tools extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model('login_model');
		$this->load->model('serttech/checking_tools_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('general_model');
		General::variable();
	}

	public function index(){

		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->data['message'] = $this->session->flashdata('message');	

		$my_db_tables=$this->checking_tools_model->show_db_tables();
		

		$count=0;
		if(!empty($my_db_tables)){
			foreach($my_db_tables as $d){	
				//$count++;
				//echo $d->Tables_in_serttech." $count <br>";
				$tables[] =$d->Tables_in_serttech;
			}

			$return = '';
			$name_of_db="serttech";
			$connection = mysqli_connect('localhost','root','',$name_of_db);
			foreach($tables as $table){
			  //$this->checking_tools_model->select_showed_tables();
				$result = mysqli_query($connection,"SELECT * FROM ".$table);
				$num_fields = mysqli_num_fields($result);

			// $result=$this->checking_tools_model->test($table);
			// $num_fields = $result;

			  $return .= '/*==============='.$table.'*/';
			  $return .= "\n";
			  $return .= 'DROP TABLE IF EXISTS `'.$table.'`;';
			  $row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
			  $return .= "\n\n".$row2[1].";\n\n";
			  
			  for($i=0;$i<$num_fields;$i++){
			    while($row = mysqli_fetch_row($result)){
			      $return .= "INSERT INTO ".$table." VALUES(";
			      for($j=0;$j<$num_fields;$j++){
			        $row[$j] = addslashes($row[$j]);
			        if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
			        else{ $return .= '""';}
			        if($j<$num_fields-1){ $return .= ',';}
			      }
			      $return .= ");\n";
			    }
			  }
			  $return .= "\n\n\n";
			}
			// ============== Save a file but dont open. ============== 
			// $extension=".sql";
			// $date=date('YmdHis');
			// $handle = fopen("backup.sql","w+");
			// fwrite($handle,$return);
			//fclose($handle);
			//echo "Successfully backed up";

			// ============== Open the downloaded file ============== 
			Header('Content-type: application/octet-stream');
			Header('Content-Disposition: attachment; filename=backup.sql');
			echo $return;



		}else{

		}
		
		//$this->load->view('serttech/checking_tool_index',$this->data);
	}

}