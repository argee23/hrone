




<!------ Include the above in your HEAD tag ---------->
<br><br>
<?php $this->db->select('*');
    $this->db->from('pms_evaluation_employeeportal a');
          $this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');

        $this->db->where('b.appraisal_period_type_dates >=', date('y-m-d'));  
          $this->db->where('form_tagging!=','completed' );
              $this->db->where('a.status!=','done');
      $this->db->where('a.status!=','');

    $query1 = $this->db->get();
    $q = $query1->row();
      	$res =$this->pms_model->get_evaluator_($company);
  $this->db->select('*');


   if(!empty($res->creators_type) == 4){

    $this->db->from('transaction_approvers');
    $this->db->where('approver', $this->session->userdata('employee_id'));
     $query = $this->db->get()->num_rows();
    }elseif(!empty($res->creators_type) == 2){
    $this->db->from('pms_form_evaluators');
    $this->db->where('evaluator_id', $this->session->userdata('employee_id'));
     $query = $this->db->get()->num_rows();
    }
  
   
    if(!empty($q->appraisal_period_type_dates)){
  $date = $q->appraisal_period_type_dates;
    $dates = date('y-m-d');
    $qw = $q->number_days;
    $q = '-'.$qw.'day';
    $before=  date('y-m-d', strtotime($q, strtotime($date)));



}


if(!empty($query)>0){ 

     ?>        
<?php   if(!empty($this->session->flashdata('result'))){
    echo '<p>'.$this->session->flashdata('result').'</p>';
  } ?>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">

<h2 class="page-header">Section Management  </h2>
<div class="container">
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i> Employee List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
              <table class="table table-bordered" id="tablenodiv">
                  <thead>
                      <tr>   
      
                        <th id="no" style="left:10px;"><center><input type="checkbox"  onclick="checkall(this);"></center></th>
                        <th><center>Name</center></th>
                        <th><center>appraisal period date</center></th>
                        <th><center>Due date</center></th>
                        <th><center>Action</center></th>
                   
                      </tr>
                  </thead>  
                  <tbody>
                  
               
                    <?php foreach ($employee as $employee) {  $q = $this->pms_model->employee_evaluation($employee->employee_id); foreach($q as $q){ ?>
                      <tr style="text-align: center;">
                              <td><input type="checkbox" name="check" class="check" value="<?php echo $employee->employee_id; ?>"></td>
                              <td><?php echo $q->fullname; ?></td>
                               <td><?php echo  $q->coverage; ?></td>
                                 <td><?php $originalDate = "2010-03-21";
                                  
                                    
                                     echo date("F d, Y", strtotime($q->appraisal_period_type_dates));

                                    
 
                                     ?>
   
                                </td>

                              <td>
                                 
                                  <?php 
                                          if($q->appraisal_period_type != 'montly'){
                                                if(($dates >= $before) && ($dates <= $date)){?>
                                               <span class="badge bg-blue"><a style="color:white;" href="<?php echo base_url().'employee_portal/pms/evaluate_form/'.$q->employee_id.'/'.$q->doc_no.'/'.$q->appraisal_period_type_dates.'/'.$company ?>" onclick="scorecard(<?php echo $q->employee_id?>,'<?php echo $q->fullname; ?>');">Start the evaluation</a></span>
                                            <?php }else{?>
                                                <span class="badge bg-red"><a class="unselectable" style="color:white;" href="#">Start of Evaluation:<?php echo date('M-d-Y', strtotime('-'.$q->number_days.'days', strtotime($q->appraisal_period_type_dates))); ?> </a></span>
                                            <?php }

                                          }else{
                                             if((date('y-m-d') >= $before) && (date('y-m-d') <= $date)){?>
                                               <span class="badge bg-blue"><a style="color:white;" href="<?php echo base_url().'employee_portal/pms/evaluate_form/'.$q->employee_id.'/'.$q->doc_no.'/'.$q->appraisal_period_type_dates.'/'.$company ?>" onclick="scorecard(<?php echo $q->employee_id?>,'<?php echo $q->fullname; ?>');">Start the evaluation</a></span>
                                            <?php }else{?>
                                                <span class="badge bg-red"><a class="unselectable" style="color:white;" href="#">Start of Evaluation:<?php echo date('M-d-Y', strtotime('-'.$q->number_days.'days', strtotime($q->appraisal_period_type_dates))); ?> </a></span>
                                            <?php }
                                          }
                                       
                                   ?>
                               </td>

                      </tr>
                          <?php }} ?>
                  </tbody>
              </table>
              </div>
           
            </div>
          </div>
<?php }else{?>
     <center><h4 style="background-color: white;padding:10px;"><strong>NO EVALUATION FOUND</strong></h4></center>
<?php } ?>

          <script type="text/javascript">



 
            $(document).ready( function () {
              $('#tablenodiv').DataTable();
           } );
          </script>

	
