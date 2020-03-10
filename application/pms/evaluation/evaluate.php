







<!------ Include the above in your HEAD tag ---------->
<br><br>
<?php $this->db->select('*');
    $this->db->from('pms_manage_appraisal_schedule');
    $this->db->where('appraisal_period_type_dates >=', date('y-m-d'));
    $query1 = $this->db->get();
    $q = $query1->row();
  $this->db->select('*');
    $this->db->from('pms_form_evaluators');
    $this->db->where('evaluator_id', $this->session->userdata('employee_id'));
  
    $query = $this->db->get();
  $date = $q->appraisal_period_type_dates;
    $dates = date('y-m-d');
    $qw = '-'.$q->number_days;
    $q = $qw.' day';
    $before=  date('y-m-d', strtotime($q, strtotime($date)));


if(($query->num_rows()>0) && ($dates >= $before) && ($dates <= $date)){


     ?>
<?php echo $message; ?>
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
                   
                      </tr>
                  </thead>
                  <tbody>
                    
                    <?php foreach ($employee as $employee) { ?>
                      <tr style="text-align: center;">
                              <td><input type="checkbox" name="check" class="check" value="<?php echo $employee->employee_id; ?>"></td>
                                <td><a href="<?php echo base_url().'employee_portal/pms/evaluate_form/'.$employee->employee_id.'/'.$employee->doc_no?>" onclick="scorecard(<?php echo $employee->employee_id?>,'<?php echo $employee->fullname; ?>');"><?php echo $employee->fullname; ?></a>
                                  

                      </tr>
                    <?php } ?>
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

	
