<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Notification_user_define_fields extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/notification_user_define_fields_model");
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
		$this->load->view('app/notification/notification_user_define_fields/index',$this->data);

	}

    
    public function view_company_udn(){
        $company_id = $this->uri->segment("4");

        if($company_id == "none" || $company_id == ""){
            echo "<br>";
            echo "<br>";
            echo "<b style='color:orange;'> PLEASE SELECT COMPANY FIRST!</b>";
            echo "<br>";
            echo "<br>";
        }elseif($company_id == 0){

        	 $this->data['udnLists'] = $this->general_model->udnList();
             $this->load->view('app/notification/notification_user_define_fields/udn_company_selected',$this->data);
        }else{
     
        $this->data['udnLists'] = $this->notification_user_define_fields_model->get_udn_by_company($company_id);
        $this->load->view('app/notification/notification_user_define_fields/udn_company_selected',$this->data);
        }

      
    }

    public function create_new(){   
        
        $this->session->set_userdata(array(
                 'tab'          =>      'administrator',
                 'module'       =>      'user_management',
                 'subtab'       =>      '',
                 'submodule'    =>      ''));
        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  
        
        $this->load->view('app/notification/notification_user_define_fields/create_new',$this->data);
    }   

    public function next_create_new(){ 
        
        $this->session->set_userdata(array(
                 'tab'          =>      'administrator',
                 'module'       =>      'user_management',
                 'subtab'       =>      '',
                 'submodule'    =>      ''));
        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  
        
        $this->load->view('app/notification/notification_user_define_fields/next_create_new',$this->data);
    } 

    public function save_udn_col_new(){

   $value = $this->input->post('fname');
   
   $company_id = $this->input->post('company');
  
        $checkexist = $this->notification_user_define_fields_model->check_udn_exist($value,$company_id); 
    if($checkexist===true){
        $this->notification_user_define_fields_model->create_udn123_new($company_id);
        $this->notification_user_define_fields_model->save_new_table($company_id);   
        $this->notification_user_define_fields_model->create_udn_new($company_id);
        
                      

            General::logfile('Notification Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define field&nbsp;<strong>".$value."</strong> Successfully Added!</div>");
        }else{

             General::logfile('Notification Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>ERROR: User Define Field&nbsp; <strong>".$value."</strong> is Already Exist!</div>");

        }



               redirect(base_url().'app/notification_user_define_fields/index',$this->data);

  
  }

    public function del_udn_col_new(){
        $id = $this->uri->segment("4");
        $colName = $this->notification_user_define_fields_model->colName_udn($id);
        $delcolName = $colName[0]->form_name;
        $get_udf = $this->notification_user_define_fields_model->get_udn($id);
        foreach ($get_udf as $udf) {
            $tudf_identifier = $udf->tudf_identifier;
            $t_table_name = $udf->t_table_name;
        }

             $this->notification_user_define_fields_model->del_notif_udf_new($tudf_identifier);
             $this->notification_user_define_fields_model->del_udn_new($id);
             $this->notification_user_define_fields_model->del_notif_new($id);
             //$this->transaction_user_define_fields_model->del_emp_new($id);
             $this->notification_user_define_fields_model->del_table($t_table_name);
       
            General::logfile('Notification Define Fields','DELETE',$delcolName);
            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$delcolName."</strong> is Successfully Deleted!</div>");
                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
      

    }

    public function edit_udn_new(){
        $id = $this->uri->segment("4");

        $this->data['user_define_edit'] = $this->notification_user_define_fields_model->get_udn_col1($id);    
            $this->load->view('app/notification/notification_user_define_fields/edit_udn',$this->data);
    }

     public function view_edit_forTextfield(){

        $value = $this->uri->segment("4");
        if($value === 'Textfield'){ 
            $this->load->view('app/notification/notification_user_define_fields/add_forTextfield1',$this->data);
        }
        else if($value === 'Selectbox'){
            $this->load->view('app/notification/notification_user_define_fields/add_forSelectbox1',$this->data);
        }
         else if($value === 'Textarea'){
            $this->load->view('app/notification/notification_user_define_fields/add_forTextarea1',$this->data);
        }

    } 
    public function modify_udn_new(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('fname');
        $company_id = $this->input->post('company_id');
        $fdesc = $this->input->post('fdesc');

        $checkexist = $this->notification_user_define_fields_model->check_udn1_exist($value,$company_id,$fdesc); 
        if($checkexist===true){

          //     $this->transaction_user_define_fields_model->modify_udf_store($delcolName);
                $this->notification_user_define_fields_model->modify_udn1_new($id);
                $this->notification_user_define_fields_model->modify_udn_emp_new($id);
                //$this->transaction_user_define_fields_model->modify_udf_emp_new2($id);
                $this->notification_user_define_fields_model->modify_notif_udf_new($value,$company_id,$tudf_identifier);
                  
                General::logfile('Notification Define Fields','MODIFY',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }
        else{
            $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>ERROR: User Define Fields<strong>".$value."</strong> is Already Exist!</div>");
                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }

    } 

    public function view_emp_udn(){ 
   
        $id = $this->uri->segment("4");
       
        $Optvalue = $this->notification_user_define_fields_model->get_udn_col_All($id);
         if(count($Optvalue)== 0){
             $Optvalue1 = $this->notification_user_define_fields_model->get_udf_col_none($id); 
             $Optlabel = $Optvalue1[0]->form_name;
              $notification_user_define_fields = $this->notification_user_define_fields_model->getOptlabel3_notif($id);
        $get_table_name = $this->notification_user_define_fields_model->getttablename_notif($id);
        $companyName1 = $this->notification_user_define_fields_model->companyName1($id);
        $system_defined_icons = $this->general_model->system_defined_icons();

        foreach ($get_table_name as $gettname) {
            $t_table_name = $gettname->t_table_name;
            $company_id = $gettname->company_id;
        }


        $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        $this->table->set_heading( 'Company: ('. $companyName1->company_name.' )', '',
         /*anchor('app/transaction_user_define_fields/excel/' .$id ,'<i class="fa fa-arrow-circle-down fa-2x text-success pull-left" data-toggle="tooltip" data-placement="left" title="Download template"></i> ').*/
          '<a text-warning pull-right" data-toggle="tooltip" data-placement="right" title="Add" onclick="addNewUDNCol1('.$id.')"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>'
           

            );

       

        $this->table->add_row('<strong>Form Name: ('.$Optlabel.') </strong><input type="hidden" name="t_table_name" id="t_table_name" value="'.$t_table_name.'"><input type="hidden" name="company_id" id="company_id" value="'.$company_id.'">' );
$this->table->add_row('<strong>List of fields</strong>','<strong>Type</strong>','<strong>Action</strong>');
				

        foreach($notification_user_define_fields as $notification_user_define_fields){
            
                  
                 
             	 $view = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x pull-left" style="color:'.$system_defined_icons->icon_view_color.';" " data-toggle="tooltip" data-placement="right" title="View option" onclick="viewUDFOPT('.$notification_user_define_fields->tran_udf_col_id.')"></i>'; 
        
                 $delete = anchor('app/notification_user_define_fields/del_udf_opt_new/'.$notification_user_define_fields->tran_udf_col_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_delete_color.';" " data-toggle="tooltip" data-placement="top" title="Delete"></i>',array('onclick'=>"return confirm('Are you sure you want to delete User Define fields (field) : ".$notification_user_define_fields->udf_label."?')")); 

                 $edit = '<i data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUDFCol('.$notification_user_define_fields->tran_udf_col_id.')" class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_edit_color.';" ">&nbsp;</i>';
   
   
                    
   
                      
                       if($notification_user_define_fields->udf_type == 'Selectbox'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete.''.$view);}


                     if($notification_user_define_fields->udf_type == 'Datepicker'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete);}

       if($notification_user_define_fields->udf_type == 'Textfield'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete);}

       if($notification_user_define_fields->udf_type == 'Textarea'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete);}

}

        }else{


        $Optlabel = $Optvalue[0]->form_name;
        $notification_user_define_fields = $this->notification_user_define_fields_model->getOptlabel3_notif($id);
        $get_table_name = $this->notification_user_define_fields_model->getttablename_notif($id);
        $companyName1 = $this->notification_user_define_fields_model->companyName1($id);
        $system_defined_icons = $this->general_model->system_defined_icons();

        foreach ($get_table_name as $gettname) {
            $t_table_name = $gettname->t_table_name;
            $company_id = $gettname->company_id;
        }


        $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        $this->table->set_heading( 'Company: ('. $companyName1->company_name.' )', '',
         /*anchor('app/transaction_user_define_fields/excel/' .$id ,'<i class="fa fa-arrow-circle-down fa-2x text-success pull-left" data-toggle="tooltip" data-placement="left" title="Download template"></i> ').*/
          '<a text-warning pull-right" data-toggle="tooltip" data-placement="right" title="Add" onclick="addNewUDNCol1('.$id.')"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>'
           

            );

       

        $this->table->add_row('<strong>Form Name: ('.$Optlabel.') </strong><input type="hidden" name="t_table_name" id="t_table_name" value="'.$t_table_name.'"><input type="hidden" name="company_id" id="company_id" value="'.$company_id.'">' );
$this->table->add_row('<strong>List of fields</strong>','<strong>Type</strong>','<strong>Action</strong>');
				

        foreach($notification_user_define_fields as $notification_user_define_fields){
            
                  
                 
             	 $view = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x pull-left" style="color:'.$system_defined_icons->icon_view_color.';" " data-toggle="tooltip" data-placement="right" title="View option" onclick="viewUDFOPT('.$notification_user_define_fields->tran_udf_col_id.')"></i>'; 
        
                 $delete = anchor('app/notification_user_define_fields/del_udf_opt_new/'.$notification_user_define_fields->tran_udf_col_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_delete_color.';" " data-toggle="tooltip" data-placement="top" title="Delete"></i>',array('onclick'=>"return confirm('Are you sure you want to delete User Define fields (field) : ".$notification_user_define_fields->udf_label."?')")); 

                 $edit = '<i data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUDFCol('.$notification_user_define_fields->tran_udf_col_id.')" class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_edit_color.';" ">&nbsp;</i>';
                      
                       if($notification_user_define_fields->udf_type == 'Selectbox'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete.''.$view);}


                     if($notification_user_define_fields->udf_type == 'Datepicker'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete);}

       if($notification_user_define_fields->udf_type == 'Textfield'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete);}

       if($notification_user_define_fields->udf_type == 'Textarea'){
       $this->table->add_row($notification_user_define_fields->TextFieldName,
                    $notification_user_define_fields->udf_type,$edit.''.$delete);}

  			 }

        }

        $this->data['table_user_define_fields'] = $this->table->generate();         
        $this->load->view('app/notification/notification_user_define_fields/view_udn',$this->data);
    }


  public function add_new_notif_udf1(){
        
        $this->load->view('app/notification/notification_user_define_fields/add_udf_notif1',$this->data);
    }


   public function save_udn_col1_new(){
        $id = $this->uri->segment("4");
        $t_table_name = $this->input->post('t_table_name');
        $company_id = $this->input->post('company_id');
        $value = $this->input->post('label');
        $form = $this->input->post('fname');
        $checktemp = true;
        $udfList = $this->notification_user_define_fields_model->udfList();

            
            $check = $this->notification_user_define_fields_model->check_udn_label1($form);
            if($check===true){


      			$this->notification_user_define_fields_model->create_udf5_col_new($form);
                $this->notification_user_define_fields_model->create_udf5_new($form);
                
                
                General::logfile('Notification Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields:  <strong>".$value."</strong> is Successfully Added!</div>");
                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
            }
            else{
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>ERROR: User define fields&nbsp; <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
            }
        

    }

     public function del_udf_opt_new(){

        $id = $this->uri->segment("4");
        //echo $id."DEL ID";
        $colName = $this->notification_user_define_fields_model->colName_udf_store($id);
        $delcolName = $colName->form_name;
        //echo $delcolName;

        $get_field_name = $this->notification_user_define_fields_model->get_old_name($id);
        foreach ($get_field_name as $field_name) {
            $f_name = $field_name->udf_label;
            $tf_id = $field_name->id;
        }
        $get_udf = $this->notification_user_define_fields_model->get_udf($tf_id);
        foreach ($get_udf as $udf) {
            $t_table_name = $udf->t_table_name;
        }

            $this->notification_user_define_fields_model->del_field_table($f_name,$t_table_name);
            $this->notification_user_define_fields_model->del_udf_option1_new($id);
        

        General::logfile('Notification Define Fields Option','DELETE','Option');    
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Define Field: <strong>".$delcolName."</strong>Option is Successfully Deleted!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
    }

     public function edit_emp_udf_col_new(){
        $id = $this->uri->segment("4");
      //  $this->udf_label = $this->transaction_user_define_fields_model->get_studios();
        $this->data['user_define_edit'] = $this->notification_user_define_fields_model->get_udf_col5($id);    
            $this->load->view('app/notification/notification_user_define_fields/edit_udf_notif',$this->data);
    }

    public function modify_udn_col_new(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('label');
        $type = $this->input->post('type');
        $accept_value = $this->input->post('accept_value');
        $max_length = $this->input->post('max_length');
        $not_null = $this->input->post('not_null');
        $company_id = $this->input->post('company_id');
        

        $get_udf = $this->notification_user_define_fields_model->get_udf($id);
        foreach ($get_udf as $udf) {
            $tudf_identifier = $udf->tudf_identifier;
            $t_table_name = $udf->t_table_name;
        }

       

        $get_field_name = $this->notification_user_define_fields_model->get_old_name($id);
        foreach ($get_field_name as $field_name) {
            $old_name = $field_name->TextFieldName;
            $old_av = $field_name->udf_accept_value;
            $old_length = $field_name->udf_max_length;
            $old_type = $field_name->udf_type;
            $tf_id = $field_name->id;
        }
        $get_udf = $this->notification_user_define_fields_model->get_udf($tf_id);
        foreach ($get_udf as $udf) {
            $tudf_identifier = $udf->tudf_identifier;
            $t_table_name = $udf->t_table_name;
        }

        if($type == 'Datepicker'){
 				$checkexist = $this->notification_user_define_fields_model->check_udf_exist_tudfcol_dp($value,$type,$not_null,$company_id); 
        
          if($checkexist===true){
            
                $this->notification_user_define_fields_model->modify_udf_new($id);
                $this->notification_user_define_fields_model->modify_table_field_new($id,$t_table_name,$old_name,$old_av,$old_length,$old_type);
                
                General::logfile('Notification Define Fields','MODIFY',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }
        else{
            $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }

        }else{

       $checkexist = $this->notification_user_define_fields_model->check_udf_exist_tudfcol($value,$type,$accept_value,$max_length,$not_null,$company_id); 

        if($checkexist===true){
            	
                $this->notification_user_define_fields_model->modify_udf_new($id);
                $this->notification_user_define_fields_model->modify_table_field_new($id,$t_table_name,$old_name,$old_av,$old_length,$old_type);
                
                General::logfile('Notification Define Fields','MODIFY',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }
        else{
            $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }
    }

    } 

    public function view_emp_udf_opt(){ 
        $id = $this->uri->segment("4");
        $Optvalue = $this->notification_user_define_fields_model->get_udf_col_All3($id);

        $Optlabel = $Optvalue[0]->udf_label;
        $notification_user_define_fields = $this->notification_user_define_fields_model->getOptlabel($id);
        $system_defined_icons = $this->general_model->system_defined_icons();

        $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('<strong>Field label: ('.$Optlabel.') </strong>', '&nbsp;','<a text-warning pull-right" data-toggle="tooltip" data-placement="right" title="Add" onclick="addUDFOption('.$id.')"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>');
     
$this->table->add_row('<strong>ID</strong>','<strong>Option</strong>','<strong>Action</strong>');
        foreach($notification_user_define_fields as $notification_user_define_fields){
            
            $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left"  title="Edit" onclick="editUDFOpt('.$notification_user_define_fields->tran_udf_opt_id.')"></i>';
            $delete = anchor('app/transaction_user_define_fields/del_udf_opt1/'.$notification_user_define_fields->tran_udf_opt_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_delete_color.';" " data-toggle="tooltip" data-placement="right" title="Delete"></i>',array('onclick'=>"return confirm('Are you sure you want to delete User Define fields (option) : ".$notification_user_define_fields->optionLabel."?')"));    
            
            $this->table->add_row(   
            	$notification_user_define_fields->tran_udf_opt_id,      
                $notification_user_define_fields->optionLabel,
                $edit.' '.$delete
            );
        }

        $this->data['table_udf_opt'] = $this->table->generate();            
        $this->load->view('app/notification/notification_user_define_fields/view_udf_notif_opt',$this->data);
    }
   

    public function view_add_forTextfield1(){
        $value = $this->uri->segment("4");
        if($value === 'Textfield'){
            $this->load->view('app/notification/notification_user_define_fields/add_forTextfield1',$this->data);
        }
        else if($value === 'Selectbox'){
            $this->load->view('app/notification/notification_user_define_fields/add_forSelectbox1',$this->data);
        }
        else if($value === 'Textarea'){
            $this->load->view('app/notification/notification_user_define_fields/add_forTextarea1',$this->data);
        }
    }

    public function add_opt_emp_udf(){
        $id = $this->uri->segment("4");
        $this->data['user_define_edit'] = $this->notification_user_define_fields_model->get_udf_col5($id);    
        $this->load->view('app/notification/notification_user_define_fields/add_opt_udf_emp',$this->data);
    }

        public function save_udf_opt(){
        $id = $this->uri->segment("4");
        $max_length = $this->notification_user_define_fields_model->colName_udf_store22($id);

        $maxLength = $max_length[0]->udf_max_length;
        $num1=1;
        for($num=0;$num<$maxLength;$num++){
            $label = 'option_'.$num1;   
            $value = $this->input->post($label);
            $this->notification_user_define_fields_model->create_udf_opt($value);
            $num1++;
        }

        General::logfile('User Define Fields Option','INSERT',$value);
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: Option <strong>".$value."</strong> is Successfully Added!</div>");

        redirect(base_url().'app/notification_user_define_fields/index',$this->data);
    }

  	public function del_udf_opt1(){

        $id = $this->uri->segment("4");
        $udf_option = $this->notification_user_define_fields_model->del_udf_option($id);

        General::logfile('User Define Fields Option','DELETE','Option');    
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Define Field: <strong>".$delcolName."</strong>Option is Successfully Deleted!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
    }

    public function edit_emp_udf_opt(){
        $id = $this->uri->segment("4");
        $this->data['user_define_edit'] = $this->notification_user_define_fields_model->get_udf_opt($id);
        $this->load->view('app/notification/notification_user_define_fields/edit_udf_opt',$this->data);
    }

     public function modify_udf_opt(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('optlabel');

         $checkexist = $this->notification_user_define_fields_model->check_udf_exist_tudfcol_opt(); 

        if($checkexist===true){

        	$this->notification_user_define_fields_model->modify_udf_opt($id);

            General::logfile('User Define Fields Option','MODIFY',$value);
            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }else{
        	 $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Already Exist!</div>");

                redirect(base_url().'app/notification_user_define_fields/index',$this->data);
        }
    }

   	//DEACTIVATEandACTIVATE OTHER ADDITIONS AUTOMATIC==============================================================
	public function deactivate_notif_form(){

		$id = $this->uri->segment("4");
		$notification = $this->notification_user_define_fields_model->get_lists($id);

		$this->notification_user_define_fields_model->deactivate_notif_list($id);

		// logfile
		$value = $notification->form_name." (".$notification->id.")";

		General::logfile('Notification Form','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/notification_user_define_fields/index',$this->data);
	}

	public function activate_notif_form(){

		$id = $this->uri->segment("4");

		$notification = $this->notification_user_define_fields_model->get_lists($id);

		$this->notification_user_define_fields_model->activate_notif_list($id);

		// logfile
		$value = $notification->form_name." (".$notification->id.")";

		General::logfile('Notification Form','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/notification_user_define_fields/index',$this->data);
	}



}//controller

