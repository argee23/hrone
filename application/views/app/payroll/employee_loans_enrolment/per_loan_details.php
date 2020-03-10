<div style="margin-top: 5px;margin-bottom: 20px;">

<?php foreach ($loanquery as $row) {
$loan_id = $row->loan_type_id;
$company_id = $row->company_id;
?>
<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
    <n id="divmain"> 
      LIST OF EMPLOYEE APPLIED IN LOANS
    </n> 
    <n id="divadd" style="display: none;"> 
      ADD NEW EMPLOYEE LOAN
    </n> 
    <n id="divadditional" style="display: none;"> 
     ADD ADDITIONAL EMPLOYEE LOAN 
    </n> 


    <button type="button" class="btn btn-warning pull-right btn-xs" style="margin-left: 3px;margin-right: 3px;" onclick="empLoans(<?php echo $company_id.",".$loan_id ?>);">
      <i class="fa fa-arrow-left"></i>
    </button>
    <button type="button" class="btn btn-info pull-right btn-xs" style="margin-left: 3px;margin-right: 3px;" onclick="employee_loan_request(<?php echo $loan_id.",".$company_id ?>);">
      <i class="fa fa-paste"></i>Employee Loan Request
    </button>
    <button type="button" class="btn btn-danger pull-right btn-xs" style="margin-left: 3px;margin-right: 3px;" onclick="loanUpload(<?php echo $loan_id.",".$company_id ?>);">
        <i class="fa fa-download"></i><?php echo $row->loan_type;?> Mass Upload
    </button>
    <button  type="button" class="btn btn-success pull-right btn-xs"  onclick="loanAdd(<?php echo $loan_id.",".$company_id?>);">
        <i class="fa fa-plus"></i>Add <?php echo $row->loan_type;?>
    </button>
  </h4>
</ol>

</div>

<div id="fetch_actions">
       
        <?php }?>
        
              <?php 
                 if($this->session->flashdata('success_inserted_manual'))
                    { 
                      echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Loan for Employee ID - '.$flash_id.' is Successfully Added!</center></n></div>';
                    }
                 if($this->session->flashdata('duplicate_insert'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Employee ID - '.$flash_id.' exist.Please check the employee active record!</center></n></div>';
                    }
                 if($this->session->flashdata('error_insert'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Error!Report to Technical Support!</center></n></div>';
                    }
                 if($this->session->flashdata('success_delete'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID '.$flash_id.' is successfully Deleted</center></n></div>';
                    }
                 if($this->session->flashdata('success_update'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID  '.$flash_id.' successfully Updated!</center></n></div>';
                    }
                 if($this->session->flashdata('no_changes'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>No changes made in ID  '.$flash_id.'</center></n></div>';
                    }
                 if($this->session->flashdata('success_updatestatus'))
                    { 
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID  '.$flash_id.'  STATUS is successfully Updated!</center></n></div>';
                    }
                 if($this->session->flashdata('no_changes_updatestatus'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>No changes made in ID  '.$flash_id.' STATUS</center></n></div>';
                    }
                  if($this->session->flashdata('Delete_Record_additional'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Additional Loan id  '.$flash_id.' is successfully deleted!</center></n></div>';
                    }
                  if($this->session->flashdata('success_inserted_additional'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Additional Loan under loan id '.$flash_id.' is successfully added!</center></n></div>';
                    }
                   if($this->session->flashdata('success_active'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Employee Loan id '.$flash_id.' is successfully Activated!</center></n></div>';
                    }
                  if($this->session->flashdata('success_pause'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Employee Loan id '.$flash_id.' is successfully Paused!</center></n></div>';
                    }
                   if($this->session->flashdata('success_paid'))
                    {
                       echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Employee Loan id '.$flash_id.' is successfully Paid!</center></n></div>';
                    }

                  if($flash_id =="")
                  {}
              ?>
          <div class="col-md-12" style="padding-top: 10px;">  
          <div class="col-md-3"></div>  
            <div class="col-md-6">
              <select class="form-control" name="status_result" id="status_result" onchange="filter_status(this.value);" >
                <option selected value="All">All</option>
                <option value="Active" selected>Active</option>
                <option value="Pause">Pause</option>
                <option value="Paid">Paid</option>
              </select>
            </div>
          <div class="col-md-3"></div>
        </div>
          <br>
          <input type="hidden" value="<?php echo $company?>" id="filter_company">
           <input type="hidden" value="<?php echo $loan?>" id="filter_loan">
          <div id="status" style="margin: 0px 10px 0px 10px">
            <table id="per_loan_table" class="table table-hover table-striped">
                <thead>
                  <tr class="danger">
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Date Effective</th>
                    <th>Loan Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <div id="refresh_this">
                <?php foreach ($query_empall as $row) {
                  $fullname= $row->first_name." ".$row->last_name;
                  $status = $row->status;
                  echo "
                  <tr>
                    <td>".$row->emp_loan_id."</td>
                    <td>".$row->employee_id."</td>
                    <td>".$fullname."</td>
                    <td>".$row->date_effective."</td>
                    <td>".number_format($row->loan_amt,2)."</td>
                    <td>".$row->status."</td>";?>
                    <td>
                     <a class='fa fa-<?php echo $system_defined_icons->icon_view;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to View Details' onclick='viewDetails(<?php echo $row->emp_loan_id.",".$row->loan_type_id.",".$row->company_id?>)'></a>
                     
                    <?php if($row->status=='Active')
                    {?>
                      <a class='fa fa-<?php echo $system_defined_icons->icon_add;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_add_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to Add additional Loan!'  onclick='add_additional_loan(<?php echo $row->emp_loan_id.",".$row->loan_type_id.",".$row->company_id?>)'></a>
                    <?php }  ?>

<!-- //==========Loan Ledger -->
<?php
echo '  
<button onclick="view_loan_ledger('.$row->emp_loan_id.');" class="btn btn-danger">
      Loan Ledger
      </button>';

?>

<!-- //==========Loan Ledger -->



                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </div>
       </table>
       </div>
    </div>

