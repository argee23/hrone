<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class transaction_user_define_fields extends General {



    function __construct(){
        parent::__construct();  
        $this->load->model("app/transaction_user_define_fields_model");
        $this->load->model("general_model");
        $this->load->dbforge();

        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();
    }



    public function index(){    
        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  



        $this->load->view('app/transaction/tudf/user_define_transactions',$this->data);   
    }

    public function transaction_user_define_fields(){
        
        $this->data['message'] = $this->session->flashdata('message');       
        $this->load->view('app/transaction/tudf/user_define_transactions',$this->data);       
    }

      public function add_new_emp_udf(){
        
        $this->load->view('app/transaction/tudf/add_udf_emp',$this->data);
    }



       public function add_new_emp_udf1(){
        
        $this->load->view('app/transaction/tudf/add_udf_emp1',$this->data);
    }


          public function view_add_forTextfield1(){
        $value = $this->uri->segment("4");
        if($value === 'Textfield'){
            $this->load->view('app/transaction/tudf/add_forTextfield1',$this->data);
        }
        else if($value === 'Selectbox'){
            $this->load->view('app/transaction/tudf/add_forSelectbox1',$this->data);
        }
         else if($value === 'Textarea'){
            $this->load->view('app/transaction/tudf/add_forTextarea1',$this->data);
        }

    }

  



//TESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSST

        public function create(){   
        
        $this->session->set_userdata(array(
                 'tab'          =>      'administrator',
                 'module'       =>      'user_management',
                 'subtab'       =>      '',
                 'submodule'    =>      ''));
        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  
        
        $this->load->view('app/transaction/create1',$this->data);
    }   

        public function next(){ 
        
        $this->session->set_userdata(array(
                 'tab'          =>      'administrator',
                 'module'       =>      'user_management',
                 'subtab'       =>      '',
                 'submodule'    =>      ''));
        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  
        
        $this->load->view('app/transaction/next1',$this->data);
    } 



        public function view_company_udt(){
        $company_id = $this->uri->segment("4");

        $this->data['tran_udf_add']=$this->session->userdata('tran_udf_add');
        $this->data['tran_udf_edit']=$this->session->userdata('tran_udf_edit');
        $this->data['tran_udf_del']=$this->session->userdata('tran_udf_del');
        $this->data['tran_udf_enable_disable']=$this->session->userdata('tran_udf_enable_disable');
        $this->data['tran_udf_mng_form_fields']=$this->session->userdata('tran_udf_mng_form_fields');

        $this->data['system_defined_icons'] = $this->general_model->system_defined_icons();


        if($company_id == "none" || $company_id == ""){
            echo "<br>";
            echo "<br>";
            echo "<b style='color:orange;'> PLEASE SELECT COMPANY FIRST!</b>";
            echo "<br>";
            echo "<br>";
        }elseif($company_id == 0){

             $this->data['udfLists'] = $this->general_model->udfList();
            $this->load->view('app/transaction/tudf/udf_company_selected',$this->data);
        }else{
     
        $this->data['udfLists'] = $this->transaction_user_define_fields_model->get_udf_by_company($company_id);
        $this->load->view('app/transaction/tudf/udf_company_selected',$this->data);
        }

       /* if($value==0){
            $this->data['udfLists'] = $this->general_model->udfList();
            $this->load->view('app/transaction/tudf/udf_company_selected',$this->data);
        }
        else{
            $this->data['udfLists'] = $this->transaction_user_define_fields_model->get_udf_company($value);
            $this->load->view('app/transaction/tudf/udf_company_selected',$this->data);
        }*/
    }


  

//TESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSST

    //SEARCHJULY3
    public function edit_emp_udf(){
        $id = $this->uri->segment("4");
      //  $this->udf_label = $this->transaction_user_define_fields_model->get_studios();
        $this->data['user_define_edit'] = $this->transaction_user_define_fields_model->get_udf_col5($id);    
            $this->load->view('app/transaction/tudf/edit_udf_emp',$this->data);
    }


       public function edit_emp_udf1(){
        $id = $this->uri->segment("4");
      //  $this->udf_label = $this->transaction_user_define_fields_model->get_studios();
        $this->data['user_define_edit'] = $this->transaction_user_define_fields_model->get_udf_col1($id);    
            $this->load->view('app/transaction/tudf/edit_udf_emp1',$this->data);
    }

    public function edit_emp_udf_opt(){
        $id = $this->uri->segment("4");
        $this->data['user_define_edit'] = $this->transaction_user_define_fields_model->get_udf_opt($id);
        $this->load->view('app/transaction/tudf/edit_udf_opt',$this->data);
    }






    ///////////////////////////////////////////////////////////////////////////////BAGO PARA MA VIEW YUNG BAWAT ROW
    public function view_emp_udf(){ 
 
        $id = $this->uri->segment("4");

        $Optvalue = $this->transaction_user_define_fields_model->get_udf_col_All($id); 

           if(count($Optvalue)== 0){
             $Optvalue1 = $this->transaction_user_define_fields_model->get_udf_col_none($id); 
             $Optlabel = $Optvalue1[0]->form_name;
             $transaction_user_define_fields = $this->transaction_user_define_fields_model->getOptlabel3($id);
                $get_table_name = $this->transaction_user_define_fields_model->getttablename($id);
                $companyName1 = $this->general_model->companyName1($id);
                  $system_defined_icons = $this->general_model->system_defined_icons();
                foreach ($get_table_name as $gettname) {
                    $t_table_name = $gettname->t_table_name;
                    $company_id = $gettname->company_id;
                }
                      $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
                        $this->table->set_template($tmpl);
                        $this->table->set_empty("&nbsp;");

                        $this->table->set_heading( 'Company: ('. $companyName1->company_name.' )', '',
                        /* anchor('app/transaction_user_define_fields/excel/' .$id ,'<i class="fa fa-arrow-circle-down fa-2x text-success pull-left" data-toggle="tooltip" data-placement="left" title="Download template"></i> ').*/
                          '<a class="pull-right" data-toggle="tooltip" data-placement="right" title="Add" onclick="addNewUDFCol1('.$id.')"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>'
                           

                            );

                         $this->table->add_row('<strong>Form Name: ('.$Optlabel.') </strong><input type="hidden" name="t_table_name" id="t_table_name" value="'.$t_table_name.'"><input type="hidden" name="company_id" id="company_id" value="'.$company_id.'">' );
    $this->table->add_row('<strong>List of fields</strong>','<strong>Type</strong>','<strong>Action</strong>');
        foreach($transaction_user_define_fields as $transaction_user_define_fields){
            
                
               
                 $delete = anchor('app/transaction_user_define_fields/del_udf_opt_new/'.$transaction_user_define_fields->tran_udf_col_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_delete_color.';" " data-toggle="tooltip" data-placement="top" title="Delete"></i>',array('onclick'=>"return confirm('Are you sure you want to delete User Define fields (field) : ".$transaction_user_define_fields->udf_label."?')")); 

                 $edit = '<i data-toggle="tooltip" data-placement="left" title="Edit"onclick="editUDFCol('.$transaction_user_define_fields->tran_udf_col_id.')" class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_edit_color.';" ">&nbsp;</i>';
   
                 $view = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x pull-left" style="color:'.$system_defined_icons->icon_view_color.';" " data-toggle="tooltip" data-placement="right" title="View option" onclick="viewUDFOPT('.$transaction_user_define_fields->tran_udf_col_id.')"></i>'; 
           
                 
            /* if($transaction_user_define_fields->udf_type == 'Selectbox'){
                 echo '<i class="fa fa-list fa-lg text-primary pull-left" data-toggle="tooltip" data-placement="right" title="View option" onclick="viewUDFOPT('.$transaction_user_define_fields->tran_udf_col_id.')"></i>';  
              } */

   
                      
                       if($transaction_user_define_fields->udf_type == 'Selectbox'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete.''.$view);}


                     if($transaction_user_define_fields->udf_type == 'Datepicker'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete);}

       if($transaction_user_define_fields->udf_type == 'Textfield'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete);}

       if($transaction_user_define_fields->udf_type == 'Textarea'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete);}

}

        }else{

        $Optlabel = $Optvalue[0]->form_name;
        $transaction_user_define_fields = $this->transaction_user_define_fields_model->getOptlabel3($id);
        $get_table_name = $this->transaction_user_define_fields_model->getttablename($id);
        $companyName1 = $this->general_model->companyName1($id);
        $system_defined_icons = $this->general_model->system_defined_icons();
        foreach ($get_table_name as $gettname) {
            $t_table_name = $gettname->t_table_name;
            $company_id = $gettname->company_id;
        }


        $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        $this->table->set_heading( 'Company: ('. $companyName1->company_name.' )', '',
        /* anchor('app/transaction_user_define_fields/excel/' .$id ,'<i class="fa fa-arrow-circle-down fa-2x text-success pull-left" data-toggle="tooltip" data-placement="left" title="Download template"></i> ').*/
          '<a class="pull-right" data-toggle="tooltip" data-placement="right" title="Add" onclick="addNewUDFCol1('.$id.')"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>'
           

            );

      

        $this->table->add_row('<strong>Form Name: ('.$Optlabel.') </strong><input type="hidden" name="t_table_name" id="t_table_name" value="'.$t_table_name.'"><input type="hidden" name="company_id" id="company_id" value="'.$company_id.'">' );
    $this->table->add_row('<strong>List of fields</strong>','<strong>Type</strong>','<strong>Action</strong>');
        foreach($transaction_user_define_fields as $transaction_user_define_fields){
            
           
                 $delete = anchor('app/transaction_user_define_fields/del_udf_opt_new/'.$transaction_user_define_fields->tran_udf_col_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_delete_color.';" " data-toggle="tooltip" data-placement="top" title="Delete"></i>',array('onclick'=>"return confirm('Are you sure you want to delete User Define fields (field) : ".$transaction_user_define_fields->udf_label."?')")); 

                 $edit = '<i data-toggle="tooltip" data-placement="left" title="Edit"onclick="editUDFCol('.$transaction_user_define_fields->tran_udf_col_id.')" class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_edit_color.';" ">&nbsp;</i>';
                                      
                 $view = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x pull-left" style="color:'.$system_defined_icons->icon_view_color.';" " data-toggle="tooltip" data-placement="right" title="View option" onclick="viewUDFOPT('.$transaction_user_define_fields->tran_udf_col_id.')"></i>'; 
           
                       if($transaction_user_define_fields->udf_type == 'Selectbox'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete.''.$view);}


                     if($transaction_user_define_fields->udf_type == 'Datepicker'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete);}

       if($transaction_user_define_fields->udf_type == 'Textfield'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete);}

       if($transaction_user_define_fields->udf_type == 'Textarea'){
       $this->table->add_row($transaction_user_define_fields->TextFieldName,
                    $transaction_user_define_fields->udf_type,$edit.''.$delete);}



   }


        }

        $this->data['table_user_define_fields'] = $this->table->generate();         
        $this->load->view('app/transaction/tudf/view_udf_emp',$this->data);
    }
          

     public function view_emp_udf_opt(){ 
        $id = $this->uri->segment("4");
        $Optvalue = $this->transaction_user_define_fields_model->get_udf_col_All3($id);
        $Optlabel = $Optvalue[0]->udf_label;
        $transaction_user_define_fields = $this->transaction_user_define_fields_model->getOptlabel($id);
        $system_defined_icons = $this->general_model->system_defined_icons();


        $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('<strong>Field label: ('.$Optlabel.') </strong>', '&nbsp;','<a class="pull-right" data-toggle="tooltip" data-placement="left" title="Add" onclick="addUDFOption('.$id.')"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x pull-right" style="color:'.$system_defined_icons->icon_add_color.';" "></i></a>');
     
$this->table->add_row('<strong>ID</strong>','<strong>Option</strong>','<strong>Action</strong>');
        foreach($transaction_user_define_fields as $transaction_user_define_fields){

            $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left"  title="Edit" onclick="editUDFOpt('.$transaction_user_define_fields->tran_udf_opt_id.')"></i>';
            $delete = anchor('app/transaction_user_define_fields/del_udf_opt1/'.$transaction_user_define_fields->tran_udf_opt_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x pull-center" style="color:'.$system_defined_icons->icon_delete_color.';" " data-toggle="tooltip" data-placement="right" title="Delete"></i>',array('onclick'=>"return confirm('Are you sure you want to delete User Define fields (option) : ".$transaction_user_define_fields->optionLabel."?')"));    
            
            
            $this->table->add_row(   
            $transaction_user_define_fields->tran_udf_opt_id,      
                $transaction_user_define_fields->optionLabel,
                $edit.' '.$delete
            );
        }

        $this->data['table_udf_opt'] = $this->table->generate();            
        $this->load->view('app/transaction/tudf/view_udf_emp_opt',$this->data);
    }


     ///////// PARA SA SELECT BOX NG ........... JULY 3
      public function view_emp_udf_opt1(){ 
        $id = $this->uri->segment("4");
        $Optvalue = $this->transaction_user_define_fields_model->get_udf_col_All3($id);
        $Optlabel = $Optvalue[0]->udf_label;
        $transaction_user_define_fields = $this->transaction_user_define_fields_model->getOptlabel($id);

        $tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($Optlabel,'<i class="fa fa-plus-square fa-lg text-warning pull-right" data-toggle="tooltip" data-placement="left" title="Add" onclick="addUDFOption('.$id.')"></i>');

        foreach($transaction_user_define_fields as $transaction_user_define_fields){
            
            $edit = '<i class="fa fa-pencil-square-o fa-lg text-warning pull-right" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUDFOpt('.$transaction_user_define_fields->tran_udf_opt_id.')"></i>';
            $delete = anchor('app/user_define_fields/del_udf_opt/'.$transaction_user_define_fields->tran_udf_opt_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'right','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete User Define fields (option) : ".$transaction_user_define_fields->optionLabel."?')"));    
            
            $this->table->add_row(          
                $transaction_user_define_fields->optionLabel,
                $delete.' '.$edit
            );
        }

        $this->data['table_udf_opt1'] = $this->table->generate();            
        $this->load->view('app/transaction/tudf/view_udf_emp_opt1',$this->data);
    }




//////////////////////////////////////////////////////////////////////////////////////////////////////

  

    public function view_edit_forTextfield(){

        $value = $this->uri->segment("4");
        if($value === 'Textfield'){ 
            $this->load->view('app/transaction/tudf/add_forTextfield1',$this->data);
        }
        else if($value === 'Selectbox'){
            $this->load->view('app/transaction/tudf/add_forSelectbox1',$this->data);
        }
         else if($value === 'Textarea'){
            $this->load->view('app/transaction/tudf/add_forTextarea1',$this->data);
        }

    }

    

/////////////////////////JUNE 28/////////

    function myinvoice()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('label[]', 'Label', 'trim');
        $this->form_validation->set_rules('type[]', 'DESCRIPTIONS', 'trim'); 
        $this->form_validation->set_rules('notNull[]', 'DESCRIPTIONS', 'trim'); 
      

        if($this->form_validation->run())
        {
            $this->load->database();
            $this->load->model('transaction_user_define_fields_model');

            $label =  $this->input->post('label');
            $type = $this->input->post('type');
            $notNull = $this->input->post('notNull');
            
             $i = 0;
             if($description){
            foreach($description as $row)
            {
            $data['udf_label'] = $label[$i];
            $data['udf_type'] = $type[$i];
            $data['udf_not_null'] = $notNull[$i];
           
             $this->db->insert("transaction_udf_column",$data);
            $i++;
            }}
            }else{
            print_r(validation_errors());
            }}


////////////////////////NEW CODES NI NEMZ FOR USER DEFINE FIELDS/////////////////////////////////////////

     public function del_udf_opt_new(){

        $id = $this->uri->segment("4");
        $colName = $this->transaction_user_define_fields_model->colName_udf_store($id);
        $delcolName = $colName->form_name;

        $get_field_name = $this->transaction_user_define_fields_model->get_old_name($id);
        foreach ($get_field_name as $field_name) {
            $f_name = $field_name->udf_label;
            $tf_id = $field_name->id;
        }
        $get_udf = $this->transaction_user_define_fields_model->get_udf($tf_id);
        foreach ($get_udf as $udf) {
            $t_table_name = $udf->t_table_name;
        }

            $this->transaction_user_define_fields_model->del_field_table($f_name,$t_table_name);
            $this->transaction_user_define_fields_model->del_udf_option1_new($id);
        

        General::logfile('User Define Fields Option','DELETE','Option');    
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Define Field: <strong>".$delcolName."</strong>Option is Successfully Deleted!</div>");

                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
    }

     public function modify_udf_col_new(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('label');
        $type = $this->input->post('type');
        $accept_value = $this->input->post('accept_value');
        $max_length = $this->input->post('max_length');
        $not_null = $this->input->post('not_null');
        $company_id = $this->input->post('company_id');
        

        $get_udf = $this->transaction_user_define_fields_model->get_udf($id);
        foreach ($get_udf as $udf) {
            $tudf_identifier = $udf->tudf_identifier;
            $t_table_name = $udf->t_table_name;
        }

       

        $get_field_name = $this->transaction_user_define_fields_model->get_old_name($id);
        foreach ($get_field_name as $field_name) {
            $old_name = $field_name->TextFieldName;
            $old_av = $field_name->udf_accept_value;
            $old_length = $field_name->udf_max_length;
            $old_type = $field_name->udf_type;
            $old_not_null = $field_name->udf_not_null;
            $tf_id = $field_name->id;
        }
        $get_udf = $this->transaction_user_define_fields_model->get_udf($tf_id);
        foreach ($get_udf as $udf) {
            $tudf_identifier = $udf->tudf_identifier;
            $t_table_name = $udf->t_table_name;
        }

         if($type == 'Datepicker'){
                $checkexist = $this->transaction_user_define_fields_model->check_udf_exist_tudfcol_dp($value,$type,$not_null,$company_id); 
        
                        if($checkexist===true){
                            
                                $this->transaction_user_define_fields_model->modify_udf_new($id);
                                $this->transaction_user_define_fields_model->modify_table_field_new($id,$t_table_name,$old_name,$old_av,$old_length,$old_type,$old_not_null);
                                
                                General::logfile('User Define Fields','MODIFY',$value);
                                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                                redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
                        }
                        else{
                            $this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                                redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
                        }

        }else{

            $checkexist = $this->transaction_user_define_fields_model->check_udf_exist_tudfcol($value,$type,$accept_value,$max_length,$not_null,$company_id); 

                    if($checkexist===true){
                        
                            $this->transaction_user_define_fields_model->modify_udf_new($id);
                            $this->transaction_user_define_fields_model->modify_table_field_new($id,$t_table_name,$old_name,$old_av,$old_length,$old_type,$old_not_null);
                            
                            General::logfile('User Define Fields','MODIFY',$value);
                            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                            redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
                    }
                    else{
                        $this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                            redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
                    }

    }

    } 
        public function edit_emp_udf_col_new(){
        $id = $this->uri->segment("4");
      //  $this->udf_label = $this->transaction_user_define_fields_model->get_studios();
        $this->data['user_define_edit'] = $this->transaction_user_define_fields_model->get_udf_col5($id);    
            $this->load->view('app/transaction/tudf/edit_udf_emp',$this->data);
    }


        public function del_udf_col_new(){
        $id = $this->uri->segment("4");
        $colName = $this->transaction_user_define_fields_model->colName_udf_store($id);
        $delcolName = $colName[0]->form_name;
        $get_udf = $this->transaction_user_define_fields_model->get_udf($id);
        foreach ($get_udf as $udf) {
            $tudf_identifier = $udf->tudf_identifier;
            $t_table_name = $udf->t_table_name;
        }

             $this->transaction_user_define_fields_model->del_tran_udf_new($tudf_identifier);
             $this->transaction_user_define_fields_model->del_udf_new($id);
             $this->transaction_user_define_fields_model->del_tran_new($id);
             //$this->transaction_user_define_fields_model->del_emp_new($id);
             $this->transaction_user_define_fields_model->del_table($t_table_name);
       

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Transaction','User Define Forms','logfile_transaction_udf',''.$delcolName.'','DELETE',$id);



            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$delcolName."</strong> is Successfully Deleted!</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
      

    }


         public function edit_emp_udf1_new(){
        $id = $this->uri->segment("4");
      //  $this->udf_label = $this->transaction_user_define_fields_model->get_studios();
        $this->data['user_define_edit'] = $this->transaction_user_define_fields_model->get_udf_col1($id);    
            $this->load->view('app/transaction/tudf/edit_udf_emp1',$this->data);
    }


   public function modify_udf_col1_new(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('fname');
        $company_id = $this->input->post('company_id');
        $fdesc = $this->input->post('fdesc');

        $checkexist = $this->transaction_user_define_fields_model->check_udf_exist($value,$company_id,$fdesc); 
        if($checkexist===true){

          //     $this->transaction_user_define_fields_model->modify_udf_store($delcolName);
                $this->transaction_user_define_fields_model->modify_udf1_new($id);
                $this->transaction_user_define_fields_model->modify_udf_emp_new($id);
                //$this->transaction_user_define_fields_model->modify_udf_emp_new2($id);
                $this->transaction_user_define_fields_model->modify_tran_udf_new($value,$company_id,$tudf_identifier);
                  
        /*
        --------------audit trail composition--------------
        (module,module dropdown,logfiletable,detailed action,action type,key value)
        --------------audit trail composition--------------
        */
        General::system_audit_trail('Transaction','User Define Forms','logfile_transaction_udf','value|company_id|tudf_identifier'.$value.$company_id.$tudf_identifier,'UPDATE',$value);


                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
        }
        else{
            $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>ERROR: User Define Fields<strong>".$value."</strong> is Already Exist!</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
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
        
        $this->load->view('app/transaction/tudf/create_new',$this->data);
    }   

        public function next_create_new(){ 
        
        $this->session->set_userdata(array(
                 'tab'          =>      'administrator',
                 'module'       =>      'user_management',
                 'subtab'       =>      '',
                 'submodule'    =>      ''));
        $this->data['onload'] = $this->session->flashdata('onload');
        $this->data['message'] = $this->session->flashdata('message');  
        
        $this->load->view('app/transaction/tudf/next_create_new',$this->data);
    } 

  public function save_udf_col_new(){

   $value = $this->input->post('fname');
   $company_id = $this->input->post('company');

        $checkexist = $this->transaction_user_define_fields_model->check_udf_exist($value,$company_id); 
    if($checkexist===true){
        $this->transaction_user_define_fields_model->create_udf123_new($company_id);
        $this->transaction_user_define_fields_model->save_new_table($company_id);   
        $this->transaction_user_define_fields_model->create_udf_new($company_id);                       

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Transaction','User Define Forms','logfile_transaction_udf','Add','INSERT',$value);



                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define field&nbsp;<strong>".$value."</strong> Successfully Added!</div>");
        }else{

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Transaction','User Define Forms','logfile_transaction_udf','Add,','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>ERROR: User Define Field&nbsp; <strong>".$value."</strong> is Already Exist!</div>");

        }


                    redirect(base_url().'app/transaction_user_define_fields/index',$this->data);

  }

  public function save_udf_col1_new(){
        $id = $this->uri->segment("4");
        $t_table_name = $this->input->post('t_table_name');
        $company_id = $this->input->post('company_id');
        $value = $this->input->post('label');
        $form = $this->input->post('fname');        
        $checktemp = true;
        $udfList = $this->general_model->udfList();

      
       
            $check = $this->transaction_user_define_fields_model->check_udf_label1($form);
            if($check===true){
        
                $this->transaction_user_define_fields_model->create_udf5_new($form);
                $this->transaction_user_define_fields_model->create_udf5_col_new($form);
                
                General::logfile('User Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields:  <strong>".$value."</strong> is Successfully Added!</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
            else{
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>ERROR: User define fields&nbsp; <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
        

    }

public function change_label($val,$nof){
      
        if ($val == 'Selectbox')
        {

         $this->load->view('app/transaction/tudf/for_selectbox',$this->data);
        }else if($val == 'Datepicker'){
            echo "";

        }else{

         $this->load->view('app/transaction/tudf/for_other',$this->data);
        }

}


    //DEACTIVATEandACTIVATE OTHER ADDITIONS AUTOMATIC==============================================================
    public function deactivate_trans_form(){

        $id = $this->uri->segment("4");
        $transaction = $this->transaction_user_define_fields_model->get_lists($id);

        $this->transaction_user_define_fields_model->deactivate_notif_list($id);

        // logfile
        $value = $transaction->form_name." (".$transaction->id.")";

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Transaction','User Define Forms','logfile_transaction_udf',''.$value.'','DISABLED',$id);

            
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

        redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
    }

    public function activate_trans_form(){

        $id = $this->uri->segment("4");

        $transaction = $this->transaction_user_define_fields_model->get_lists($id);

        $this->transaction_user_define_fields_model->activate_notif_list($id);

        // logfile
        $value = $transaction->form_name." (".$transaction->id.")";



            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Transaction','User Define Forms','logfile_transaction_udf',''.$value.'','ENABLED',$id);

            
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

        redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
    }





//END OF NEW CODES NI NEMZ/////////////////////////////////////////////////////////////////
      

        
        public function save_udf_col(){

        $value = $this->input->post('fname');
        $company = $this->input->post('company');
        $checktemp = true;
        $companyList = $this->general_model->companyList();

        if($company==0){
            foreach($companyList as $company){
                $companyid = $company->company_id;
                $check = $this->transaction_user_define_fields_model->check_udf_label($companyid);
                if($check===false){
                    $checktemp = false;
                }
            }

            if($checktemp===true){
                foreach($companyList as $company){
                    $companyid = $company->company_id;
            //      $this->transaction_user_define_fields_model->create_udf_store($companyid);

                        $this->transaction_user_define_fields_model->create_udf123($companyid);
                        $this->transaction_user_define_fields_model->create_udf1($companyid);
                        $this->transaction_user_define_fields_model->create_udf($companyid);
                      



                }
                General::logfile('User Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields successfully Added!</div>");
                    redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
            else{
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields already exist.</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
        }
        else{
            $check = $this->transaction_user_define_fields_model->check_udf_label($company);
            if($check===true){
            //  $this->transaction_user_define_fields_model->create_udf_store($company); // uncomment this
$this->transaction_user_define_fields_model->create_udf123($company);
                                    $this->transaction_user_define_fields_model->create_udf1($company);
                $this->transaction_user_define_fields_model->create_udf($company);
                      //    $this->transaction_user_define_fields_model->download_employee_info_template();
              

          


                General::logfile('User Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields:  <strong>".$value."</strong> is Successfully Added!</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
                  
            } 
            else{
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
        }

    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function save_udf_col1(){
 $id = $this->uri->segment("4");
        $value = $this->input->post('label');
        $form = $this->input->post('fname');
        $checktemp = true;
        $udfList = $this->general_model->udfList();

      
       
            $check = $this->transaction_user_define_fields_model->check_udf_label1($form);
            if($check===true){
        //        $this->transaction_user_define_fields_model->create_udf_store($form);
                $this->transaction_user_define_fields_model->create_udf5($form);
                
                General::logfile('User Define Fields','INSERT',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields:  <strong>".$value."</strong> is Successfully Added!</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
            else{
                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
            }
        

    }


/////////////////////////////////////////////////////





        public function excel()

        {
 $id = $this->uri->segment("4");
     $companyName3 = $this->general_model->companyName55($id);
               
  

              $this->load->model('transaction_user_define_fields_model');

                $tasks = new transaction_user_define_fields_model;
                $tasks->table = 'transaction_udf_column';
                $tasks->primary_key ='id';
                $data['transaction_udf_column'] = $tasks->read();


            require (APPPATH .'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
           require (APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

            $objPHPExcel = new PHPExcel();
             $objPHPExcel->getProperties()->setCreator("");
             $objPHPExcel->getProperties()->setLastModifiedBy("");
             $objPHPExcel->getProperties()->setTitle("");
             $objPHPExcel->getProperties()->setSubject("");
             $objPHPExcel->getProperties()->setDescription("");
             $objPHPExcel->setActiveSheetIndex(0);

       //       $objPHPExcel->getActiveSheet()->SetCellValue('A1','udf_label');
         /*     $objPHPExcel->getActiveSheet()->SetCellValue('B1',);
              $objPHPExcel->getActiveSheet()->SetCellValue('C1',);
              $objPHPExcel->getActiveSheet()->SetCellValue('D1',);
              $objPHPExcel->getActiveSheet()->SetCellValue('E1',);
              $objPHPExcel->getActiveSheet()->SetCellValue('F1',);
              $objPHPExcel->getActiveSheet()->SetCellValue('G1',);
              $objPHPExcel->getActiveSheet()->SetCellValue('H1',); */


  /* echo "<pre>";
   print_r($data['transaction_udf_column']);
   echo "</pre>"; */

   
                  $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(80);
                  
        
              $row = 1;
              $col = 0;
            //  $colRow = $col;
             foreach ($data['transaction_udf_column'] as $key => $value) 
              { 

 if($value->udf_type == 'Datepicker'){$objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($col,$row,$value->udf_label."\r (MM-DD-YY)");}
if($value->udf_type == 'Selectbox'){$objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($col,$row,$value->udf_label."\r (see:'$value->udf_label'->view option->put ID eg. 1,2,3)");}
    if($value->udf_type == 'Textarea'){$objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($col,$row,$value->udf_label);}
        if($value->udf_type == 'Textfield'){$objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($col,$row,$value->udf_label);}


//EDITED JULY 13 enhances the design in excel template

        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25); //july 13 edited loop of column
              $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getAlignment()->setWrapText(true);

                  $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getFill()->getStartColor()->setARGB('29bb04');
                // Add some data
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
  
              $col++; 


 
   

  

              }  


               $filename = $companyName3->template_name. '.xls';
               $objPHPExcel->getActiveSheet()->setTitle("Task-Overview");

               header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
               header('Content-Disposition: attachment;filename="'.$filename.'"');
               header('Cache-Control: max-age=0');

               $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
               $writer->save('php://output');
               exit; 

        }

        public function csv($value='')

        {

            $filename = "CSV_FILE_".date("YmdH_i_s").'.csv';

            header('Content-type:text/csv');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: no-store, no cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0');
            header('Pragma: no-cache');
            header('Expires:0');
            
            $handle =fopen('php://output','w');

            fputcsv($handle, array(
                'udf_label'));

            $this->db->select('*');
            $this->db->from('transaction_udf_column');
            $query = $this->db->get();
            $data['transaction_udf_column'] = $query->result_array();

            foreach ($data['transaction_udf_column'] as $key => $row)
            {
                fputcsv($handle, $row);
            }
            fclose($handle);
            exit;
        }

        public function text($value='')
        {

            $filename = "TXT_FILE_".date("YmdH_i_s"). '.txt';

               header('Content-type:text/plain');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: no-store, no cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0');
            header('Pragma: no-cache');
            header('Expires:0');

                        $handle =fopen('php://output','w');

                        $this->load->model('Task');

                        $tasks = new Task;
                        $tasks->table = 'tasks';
                        $tasks->primary_key ='task_id';
                        $data['tasks'] = $tasks->read();

                        foreach ($data['tasks'] as $as => $row)
                        {
                            foreach ($row as $key => $value)
                            {
                                fwrite($handle, ucfirst(str_replace("_"," ",$key)) . ": $value\r\n");
                            }
                            fwrite($handle, "\r\n");
                        }

                        fclose($handle);
                        exit;



        }




        public function del_udf_col(){
        $id = $this->uri->segment("4");
        $colName = $this->transaction_user_define_fields_model->colName_udf_store($id);
        $delcolName = $colName[0]->form_name;
    //  $labelold = str_replace(' ', '_', $delcolName);
    //  $delcolCom = $colName[0]->company_id;
    //  $delColumn = $labelold.'_'.$delcolCom;
    //  $this->transaction_user_define_fields_model->del_udf_store($delColumn);
        $data = $this->transaction_user_define_fields_model->del_udf($id);
        $delopt = $this->transaction_user_define_fields_model->del_udf_optcol($id);

        if($data){
            General::logfile('User Define Fields','DELETE',$delcolName);
            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$delcolName."</strong> is Successfully Deleted!</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
        }

    }

    public function del_udf_opt(){

        $id = $this->uri->segment("4");
        $udf_option = $this->transaction_user_define_fields_model->del_udf_option1($id);

        General::logfile('User Define Fields Option','DELETE','Option');    
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Define Field: <strong>".$delcolName."</strong>Option is Successfully Deleted!</div>");

                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
    }

        public function del_udf_opt1(){

        $id = $this->uri->segment("4");
        $udf_option = $this->transaction_user_define_fields_model->del_udf_option($id);

        General::logfile('User Define Fields Option','DELETE','Option');    
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Define Field: <strong>".$delcolName."</strong>Option is Successfully Deleted!</div>");

                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
    }





        public function modify_udf_col(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('label');
        $check = $this->transaction_user_define_fields_model->check_udf_label($id);
        if($check===true){
                $colName = $this->transaction_user_define_fields_model->colName_udf_store($id);
                $label = $colName[0]->udf_label;
                $company = $colName[0]->company_id;
        //      $delcolName = $label.'_'.$company;

        //      $this->transaction_user_define_fields_model->modify_udf_store($delcolName);
                $this->transaction_user_define_fields_model->modify_udf($id);
                
                General::logfile('User Define Fields','MODIFY',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
        }
        else{
            $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
        }

    } 



    public function modify_udf_col1(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('fname');
        $check = $this->transaction_user_define_fields_model->check_udf_label($id);
        if($check===true){
                $colName = $this->transaction_user_define_fields_model->colName_udf_store($id);
                $label = $colName[0]->form_name;
                $company = $colName[0]->company_id;
             //   $delcolName = $label.'_'.$company;

          //     $this->transaction_user_define_fields_model->modify_udf_store($delcolName);
                $this->transaction_user_define_fields_model->modify_udf1($id);
                  $this->transaction_user_define_fields_model->modify_udf33($id);
                General::logfile('User Define Fields','MODIFY',$value);
                $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
        }
        else{
            $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> already exist.</div>");
                redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
        }

    } 
    
    public function modify_udf_opt(){

        $id = $this->uri->segment("4");
        $value = $this->input->post('optlabel');

          $checkexist = $this->transaction_user_define_fields_model->check_udf_exist_tudfcol_opt(); 

        if($checkexist===true){

        $this->transaction_user_define_fields_model->modify_udf_opt($id);

            General::logfile('User Define Fields Option','MODIFY',$value);
            $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is Successfully Modified!</div>");

                redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
        }else{
              $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: <strong>".$value."</strong> is ALready Exist!</div>");

                redirect(base_url().'app/transaction_user_define_fields/index',$this->data);
        }
    }

    

  public function add_opt_emp_udf(){
        $id = $this->uri->segment("4");
        $this->data['user_define_edit'] = $this->transaction_user_define_fields_model->get_udf_col5($id);    
        $this->load->view('app/transaction/tudf/add_opt_udf_emp',$this->data);
    }

        public function save_udf_opt(){
        $id = $this->uri->segment("4");
        $max_length = $this->transaction_user_define_fields_model->colName_udf_store22($id);

        $maxLength = $max_length[0]->udf_max_length;
        $num1=1;
        for($num=0;$num<$maxLength;$num++){
            $label = 'option_'.$num1;   
            $value = $this->input->post($label);
            $this->transaction_user_define_fields_model->create_udf_opt($value);
            $num1++;
        }

        General::logfile('User Define Fields Option','INSERT',$value);
        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User define fields: Option <strong>".$value."</strong> is Successfully Added!</div>");

        redirect(base_url().'app/transaction_user_define_fields/transaction_user_define_fields',$this->data);
    }








}

?>