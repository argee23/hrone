<div class="col-sm-9" style="font-size: 15px;">
  <div class="panel panel-default">
    <div class="panel-body">
      <h4 class="panel-header">All Forms
        <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <i class="fa fa-history"></i>Filter Data<span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a onclick="filter_form_all('show_payroll');" style="cursor: pointer;">Filter data by payroll period</a></li>
            <li><a onclick="filter_form_all('show_date');" style="cursor: pointer;">Filter data by date range</a></li>
          </ul>
        </div> 

      <br><br><br>  
        <div class="box box-danger"></div>
       <!-- filtering by payroll period and status-->
       <div class="content-body" style="background-color: #D7EFF7;">
        <div class="col-lg-12">

         <div class="col-md-12" style="display: none;" id="filter_payroll_all">
            <div class="panel panel-default">
              <div class="panel-body">
                  <h5 class="control-label col-sm-2" for="email" required><u>Payroll Period</u></h5>
                    <div class="col-sm-4">
                      <select class="form-control" style="border:1px solid brown;" id="payroll">
                        <option disabled value="" selected>Select</option>
                            <?php
                              $checker_pp =''; 
                              foreach($payrollPeriods as $per)
                              {
                                $ppid = $per->id;
                                $from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));

                                 if(empty($checker_pp))
                                  {   
                                     $checker_pp.=$ppid."/";
                                      $res = true;
                                  }
                                  else
                                  {
                                      $explode =  explode('/',$checker_pp);
                                     
                                      if (in_array($ppid, $explode)) {
                                            $res = false;
                                      } else {
                                         
                                            $checker_pp.=$ppid."/";
                                            $res = true;
                                      }
                                  }

                                  if($res==true){

                            ?>
                        <option value="<?php echo $per->id; ?>"><?php echo $formatted; ?></option>
                            <?php  } } ?>
                      </select>
                    </div>
                    <h5 class="control-label col-sm-2" for="email" required><u>Status</u></h5>
                    <div class="col-sm-3">
                      <select class="form-control" style="border:1px solid brown;" id="p_status">
                        <option disabled value="none" selected>Select</option>
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="rejected">Rejected</option>
                      </select>
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-success btn-flat btn-md btn-block" onclick="getFiledInBetween_all('payroll','All','All')"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-md-12" style="display: none;" id="filter_date_all">
            <div class="panel panel-default">
              <div class="panel-body">
                  <h5 class="control-label col-sm-1" for="email" required><u>Date</u></h5>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" id="date_from">
                    </div>
                    <div class="col-sm-1">
                      <label>to </label>
                    </div>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" id="date_to">
                    </div>
                    <h5 class="control-label col-sm-1" for="email" required><u>Status</u></h5>
                    <div class="col-sm-2">
                      <select class="form-control" style="border:1px solid brown;" id="d_status">
                        <option disabled value="none" selected>Select</option>
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="rejected">Rejected</option>
                      </select>
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-success btn-flat btn-md btn-block"  onclick="getFiledInBetween_all('date','All','All')"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
          </div>
        
        </div>
      </div>
     
      <div id="view_results_all" style="font-size: 15px;">
      <table id="example1" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <td>Transaction</td>
                  <td>Document Number</td>
                  <td>Details</td>
                  <td>Date Filed</td>
                  <td>Status</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
              <?php 
              $transactions = $this->employee_transactions_model->getActiveTransactions();
              foreach ($transactions as $trans) {
               $transList= $this->employee_transactions_model->getEmployeeTransactions($trans->t_table_name);
                foreach ($transList as $file) {
                  
              ?>
               <tr>
                <td><?php echo $trans->form_name?></td>
                <td>
                    <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $file->doc_no; ?>/<?php echo $trans->t_table_name; ?>/<?php echo $trans->identification; ?>" target="_blank">
                    <?php echo $file->doc_no; ?>
                    </a>
                </td>
                 <td>
                    <?php
                      if($trans->identification=='HR015')
                      {
                        $ob_date = $this->employee_transactions_model->get_ob_dates($file->doc_no);
                        echo "<n class='text-info'>Company:&nbsp;</n>".$file->company_name."<br>
                              <n class='text-info'>Date/s:&nbsp;</n>";
                              $i=1;
                              foreach($ob_date as $dd)
                              {
                                if(count($ob_date)==$i)
                                  { echo $dd->the_date; } else{  echo $dd->the_date.","; }
                               
                                $i++;
                              }

                      }
                      else if($trans->identification=='HR027')
                      {
                          echo "<n class='text-info'>Original:&nbsp;</n> ".$file->orig_rest_day."<br>
                                <n class='text-info'>Requested:&nbsp;</n> ".$file->request_rest_day."
                                ";
                      }
                      else if($trans->identification=='HR023')
                      {
                         echo "<n class='text-info'>Date:&nbsp;</n> ".$file->covered_date."<br>
                                <n class='text-info'>Hours:&nbsp;</n> ".$file->hours."
                                ";
                      }
                      else if($trans->identification=='HR025')
                      {
                           echo "<n class='text-info'>Covered Date:&nbsp;</n> ".$file->covered_date."<br>
                                <n class='text-info'>Time:&nbsp;</n> ".$file->time_in." IN /  ".$file->time_out." OUT
                                ";
                      }
                      else if($trans->identification=='HR003')
                      {
                           $sched_date = $this->employee_transactions_model->get_sched_dates($file->doc_no);
                           echo "<n class='text-info'>New Sched:&nbsp;</n>".$file->time_to."<br>
                              <n class='text-info'>Date/s:&nbsp;</n>";
                              $i=1;
                              foreach($sched_date as $dd)
                              {
                                if(count($sched_date)==$i)
                                  { echo $dd->the_date; } else{  echo $dd->the_date.","; }
                               
                                $i++;
                              }
                      }

                      else if($trans->identification=='HR002')
                      {
                           $leave_date = $this->employee_transactions_model->get_leave_dates($file->doc_no);
                           echo "
                              <n class='text-info'>Date/s:&nbsp;</n>";
                              $i=1;
                              foreach($leave_date as $dd)
                              {
                                if(count($leave_date)==$i)
                                  { echo $dd->the_date; } else{  echo $dd->the_date.","; }
                               
                                $i++;
                              }
                      }
                      else if($trans->identification=='HR005')
                      {
                        $loan_type = $this->employee_transactions_model->loan_type_d($file->loan_type);
                          echo " <n class='text-info'>Loan Type:&nbsp;</n> ".$loan_type."<br>
                                 <n class='text-info'>Loan Amount:&nbsp;</n> ".number_format($file->loan_amount,2)."
                              ";
                      }
                      else if($trans->identification=='HR024')
                      {?>
                        <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $file->cancelled_doc_no; ?>/employee_leave/HR002" target="_blank"><n class='text-info'>(click to view leave details): &nbsp;</n><?php echo $file->cancelled_doc_no;?><br></a>
                      <?php }
                      else if($trans->identification=='HR008')
                      {
                          echo " <n class='text-info'>Date:&nbsp;</n> ".$file->atro_date."<br>
                                 <n class='text-info'>Hours:&nbsp;</n> ".$file->no_of_hours." (".$file->atro_conversion.")<br>

                              ";
                      }
                    ?>
                </td>

                <td><?php echo date("F d, Y", strtotime($file->date_created)); ?> </td>
                <td><strong><?php if ($file->status!='approved') 
                {
                  echo "<p class='text-danger'>" . strtoupper($file->status) . "</p>";
                }
                else {
                  echo "<p class='text-success'>" . strtoupper($file->status) . "</p>";
                } ?>
                </strong></td>

                <td>
                  <?php if ($file->is_cancellable)
                  { ?>
                      <center><a href="<?php echo base_url();?>employee_portal/employee_transactions/cancel_transaction/<?php echo $trans->t_table_name; ?>/<?php echo $file->doc_no; ?>" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i> Cancel Request</a></center>
                  <?php } ?>
                </td>
                </tr>
                <?php } }?>
              </tbody>
            </table>   
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  
  function filter_form_all(option)
  {
    if(option=='show_payroll')
    {
        $("#filter_payroll_all").show();
        $("#filter_date_all").hide();
    }
    else
    {
        $("#filter_payroll_all").hide();
        $("#filter_date_all").show();
    }
  }
  function getFiledInBetween_all(option,table_name,form_name)
  {

      if(option=='payroll'){
        var payroll = document.getElementById('payroll').value;
        var c1 = payroll;
        var c2 = payroll; 
        var cc = 'none';
        var status = document.getElementById('p_status').value;
      }
      else{
        var date_from = document.getElementById('date_from').value;
        var date_to = document.getElementById('date_to').value;
        var c1=date_from;
        var c2 = date_to;
        var cc = '0000-00-00';
        var status = document.getElementById('d_status').value;
      }
        if(status=='none'){ alert("Please fill up all to fields to continue."); }
        else{ 
        {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                  document.getElementById("view_results_all").innerHTML=xmlhttp.responseText;
                  $("#example1").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/get_filed_in_between/"+payroll+"/"+status+"/"+table_name+"/"+form_name+"/"+option+"/"+date_from+"/"+date_to,true);
            xmlhttp.send();

       } }
  }
</script>