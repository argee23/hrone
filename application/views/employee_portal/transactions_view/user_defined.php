<div class="col-sm-8">
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header"><?php echo strtoupper($name); ?> REQUESTS
  <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <i class="fa fa-history"></i>Filter Data<span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a onclick="filter_form('show_payroll');" style="cursor: pointer;">Filter Data by Payroll Period</a></li>
            <li><a onclick="filter_form('show_date');" style="cursor: pointer;">Filter Data by Date Range</a></li>
          </ul>
        </div> 
    </h4>
  <hr>
  <div class="box box-danger"></div>
       <!-- filtering by payroll period and status-->
       <div class="content-body" style="background-color: #D7EFF7;">
        <div class="col-lg-12">

         <div class="col-md-12" style="display: none;" id="filter_payroll">
            <div class="panel panel-default">
              <div class="panel-body">
                  <h5 class="control-label col-sm-2" for="email" required><u>Payroll Period</u></h5>
                    <div class="col-sm-4">
                      <select class="form-control" style="border:1px solid brown;" id="payroll">
                        <option disabled value="" selected>Select</option>
                            <?php foreach($payrollPeriods as $per)
                              {
                                $from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
                            ?>
                        <option value="<?php echo $per->id; ?>"><?php echo $formatted; ?></option>
                            <?php  } ?>
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
                      <button type="button" class="btn btn-success btn-flat btn-md btn-block" onclick="getFiledInBetween('payroll','<?php echo $table_name?>','<?php echo $form_name?>')"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col-lg-12">

                      <n style="font-size: 15px;" class="text-danger">
                      <i><?php if($t_id==2 || $t_id==3 || $t_id==8|| $t_id==15 || $t_id==23 || $t_id==25 || $t_id==26 || $t_id==27 ){ echo "Note: Date is based on effective date / transaction date."; } else{ echo "Note: Date is based on date filed."; } ?></i></n>
                    </div>
              
                </div>
            </div>
          </div>

          <div class="col-md-12" style="display: none;" id="filter_date">
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
                      <button type="button" class="btn btn-success btn-flat btn-md btn-block" onclick="getFiledInBetween('date','<?php echo $table_name?>','<?php echo $form_name?>')"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
          </div>
        
        </div>
      </div>
      <div id="view_results">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td>Document Number</td>
                  <td>Date Filed</td>
                  <td>Status</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($transList as $file){?>
                <tr>
                <td><a href="view/<?php echo $file->doc_no; ?>/<?php echo $table_name;?>/<?php echo $form_name; ?>" target="_blank"><?php echo $file->doc_no; ?></a></td>
                <td><?php echo date("F d, Y", strtotime($file->date_created)); ?> </td>
                <td><strong><?php if ($file->status!='approve') 
                {
                  echo "<p style='color: #FF0000'>" . strtoupper($file->status) . "</p>";
                }
                else {
                  echo "<p style='color: #2E8B57'>" . strtoupper($file->status) . "</p>";
                } ?>
                </strong></td>
                <td>
                  <?php  if ($file->is_cancellable)
                  { ?>
                      <center><a href="<?php echo base_url();?>employee_portal/employee_transactions/cancel_transaction/<?php echo $table_name; ?>/<?php echo $file->doc_no; ?>" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i> Cancel Request</a></center>
                  <?php } ?>
                </td>
                </tr>
                 <?php } ?>  
              </tbody>
            </table>
      </div>
  </div>
</div>
</div>


<script type="text/javascript">
  
  function filter_form(option)
  {
    if(option=='show_payroll')
    {
        $("#filter_payroll").show();
        $("#filter_date").hide();
    }
    else
    {
        $("#filter_payroll").hide();
        $("#filter_date").show();
    }
  }
  
  function getFiledInBetween(option,table_name,form_name)
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
        if(status=='none' || c1=='' || c2=='' || cc==''){ alert("Please fill up all to fields to continue."); }
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
                document.getElementById("view_results").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/get_filed_in_between/"+payroll+"/"+status+"/"+table_name+"/"+form_name+"/"+option+"/"+date_from+"/"+date_to,true);
            xmlhttp.send();

       } }

  }
</script>
