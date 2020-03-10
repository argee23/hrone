<br><br><br>

<div class="col-sm-3">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title">Transactions</h5>
        <span class="pull-right"><div class="box-tools"><input class="form-control input-sm" placeholder="Enter Search Criteria"  type="text" onkeyup="search(this.value)"></div></span></div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" id="search_res">
          <ul class="nav nav-pills nav-stacked" >
                <?php if(empty($notifications)){?>
                 <li class="my_hover">
                    <a data-toggle="tab" href="#filter_all_forms" >No Notification/s found.</a>
                </li>
                <?php } else { ?>                 

                <li class="my_hover">
                    <a style="cursor: pointer;" href="<?php echo base_url()?>employee_portal/employee_notifications/view_by_notifications/all">All Notifications</a>
                </li>
                <?php foreach($notifications as $notif){?>
                <li class="my_hover">
                    
                    <a  style="cursor: pointer;" href="<?php echo base_url()?>employee_portal/employee_notifications/view_by_notifications/<?php echo $notif->id; ?>"><?php echo $notif->form_name; if($notif->count==0){} else{?><span class="badge badge-warning"><?php echo $notif->count;?></span><?php }?></a>

                </li>
                <?php } } ?>
                <style type="text/css">
                  .badge-warning {
                    background-color: #f89406;
                  }
                  .badge-warning:hover {
                    background-color: #c67605;
                  }
                </style>
          </ul>
        </div>
      </div>
</div>
<div class="col-sm-9" id="notif_main">
    <div class="panel panel-default">
  <div class="panel-body">
    <div class="box-header with-border">
         <h3 class="box-title text-danger"><u>All Pending Notification/s</u></h3> 
         <button class="btn btn-danger pull-right btn-xs" onclick="view_filtering('filtering_notif','filtering_notif_val');">Click to filter history</button>
    </div>

     <div class="box box-primary">
      
        <div class="col-md-12" style="margin-top: 30px;margin-bottom: 20px;display: none;"  id="filtering_notif">
           <div class="col-md-12">
            <div class="col-md-12">
                  <div class="col-md-1"></div>
                   <div class="col-md-8">
                      <div class="col-md-4" style="text-align: right;">Notification</div>
                      <div class="col-md-8">
                          <select class="form-control" id="notifs">
                            <option value="">Select</option>
                             <option value="All">All</option>
                            <?php  foreach($notifications as $f){?>
                              <option value="<?php echo $f->id;?>"><?php echo $f->form_name;?></option>
                           <?php } ?>
                          </select>
                      </div>
                  </div>
                   <div class="col-md-3"></div>
            </div>
            </div>

            <div class="col-md-12"  style="margin-top: 10px;">
            <input type="hidden" id="filtering_notif_val" value="0">
            <div class="col-md-12">
                  <div class="col-md-1"></div>
                   <div class="col-md-8">
                      <div class="col-md-4" style="text-align: right;">Status</div>
                      <div class="col-md-8">
                          <select class="form-control" id="notif_status">
                            <option value="">Select</option>
                            <option value="all">all</option>
                            <option value="v">viewed</option>
                            <option value="a">acknowledged</option>
                            <option value="nv">not yet viewed</option>
                            <option value="na">not yet acknowledged</option>
                          </select>
                      </div>
                  </div>
                   <div class="col-md-3"></div>
            </div>

            

             <div class="col-md-12" style="margin-top: 10px;">
                  <div class="col-md-1"></div>
                   <div class="col-md-8">
                      <div class="col-md-4" style="text-align: right;">Date Range</div>
                      <div class="col-md-4">
                            <input type="date" class="form-control" id="date_from">
                      </div>
                       <div class="col-md-4">
                            <input type="date" class="form-control" id="date_to">
                      </div>
                  </div>
                   <div class="col-md-1">

                       <button type="button" class="btn btn-success" onclick="filter_notifications_all();"><i class="fa fa-search"></i></button>
                   </div>
            </div>
            </div>

            
            <br><br><br> <br><br> <br><br><div class="box box-default" class='col-md-12'></div>
        </div>
            <div class="box-body" id="filter_result">
                <table class="table table-responsive table-sm" id="notiff">
                  <thead>
                      <tr class="danger">
                        <th>Document No.</th>
                        <th>Notification</th>
                        <th>Date Filed</th>
                        <th>Approvers</th>
                        <th><center>Time Viewed</center></th>
                        <th><center>Time Acknowledged</center></th>
                        <th><center>Action</center></th>
                      </tr>
                  </thead>
                  <tbody> 
                    <?php $i=1; foreach($notifications as $f){
                      if($f->count==0){}
                      else{
                        $form_info  = $this->employee_notifications_model->get_all_notif_by_employee($f->t_table_name,$this->session->userdata('employee_id'));
                        foreach($form_info as $d)
                        {
                      ?>
                       <td>
                          <a style="cursor: pointer;" href="<?php echo base_url();?>app/issue_notifications/view_notif_form/<?php echo $d->doc_no."/".$this->session->userdata('company_id')."/".$this->session->userdata('employee_id'); ?>" target="_blank"><?php echo $d->doc_no;?></a>
                        </td>
                        <td><?php echo $f->form_name;?></td>
                        <td>
                          <?php
                              $month=substr($d->date_created, 5,2);
                              $day=substr($d->date_created, 8,2);
                              $year=substr($d->date_created, 0,4);

                              echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                            ?>
                        </td>
                        <td>
                          <?php 
                            if($f->issuance_type=='1'){
                              $get_approvers = $this->employee_notifications_model->get_approvers_by_doc($d->doc_no,$f->t_table_name."_approval");
                              ?>
                           <a data-toggle='collapse' data-target='#app<?php echo $d->doc_no;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view approver/s'><?php echo count($get_approvers)." approver/s";?></a>
                            <div id="app<?php echo $d->doc_no;?>" class="collapse">
                              <?php if(empty($get_approvers)){ echo "No approver/s found."; } else { 
                                foreach ($get_approvers as $app) {
                                  echo "<n class='text-danger'>".$app->first_name." ".$app->last_name."</n><br>";
                                ?>
                                  
                              <?php } } ?>
                            </div>

                            <?php  } 
                            else{ echo "no approvers"; }
                          ?>
                        </td>
                        <td>
                            <?php 
                              if(empty($d->time_viewed))
                                { echo "not yet viewed"; }
                                else
                                {
                                  echo $d->time_viewed;  
                                }
                            ?>
                        </td>
                        <td>
                            <?php 

                              if(empty($d->time_acknowledge))
                                { echo "not yet acknowledged"; }
                                else
                                {
                                  echo $d->time_acknowledge;  
                                }

                            ?>
                        </td>
                        <td>
                          <?php 

                           $eff=$this->employee_notifications_model->get_employee_fields_tofill($f->id,$d->doc_no,$f->t_table_name);
                            if($eff==0)
                            {
                                  if(empty($d->time_acknowledge))
                                   { ?>
                                    <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$f->t_table_name;?>"><span class="badge bg-green">Acknowledge</span></a></center></td>
                    
                                    <?php } else{?>
                                      <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall'  href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$f->t_table_name;?>"><span class="badge bg-green">View Answer</span></a></center></td>
                                    <?php }
                            }
                            else{

                          if(empty($d->time_acknowledge))
                                { ?>
                                    <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$f->t_table_name;?>"><span class="badge bg-green">Answer</span></a></center></td>
                    
                                <?php } else{?>
                                      <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$f->t_table_name;?>"><span class="badge bg-green">View Answer</span></a></center></td>
                                <?php } }?>
                        </tr>
                    <?php }}  $i++;  }?>
                  </tbody> 
                </table>
            </div>
      </div>
    </div>
  </div>
</div>


</div>
 <div class="modal fade" id="modall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content modal-lg">
       </div>
    </div>
</div>
<style type="text/css">
  .modal {
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 120%;

}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: left;

}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
 /*   width:inherit;
    height:inherit;*/
    /* To center horizontally */
    margin: 0 auto;
    margin-left:-60px;
}
</style>

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
     <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
  
  $(function () {
        $('#notiff').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
  });

  function filter_notifications(table,id,identification)
  {
     var status = document.getElementById('notif_status').value;
     var from = document.getElementById('date_from').value;
     var to = document.getElementById('date_to').value;
     if(status=='' || from=='' || to=='')
     {
      alert("Please fill up all fields to continue");
     }
     else
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
                  document.getElementById("filter_result").innerHTML=xmlhttp.responseText;
                   $("#notif").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_notifications/filter_notifications/"+table+"/"+id+"/"+identification+"/"+status+"/"+from+"/"+to,true);
            xmlhttp.send();
     }
  }
  function view_filtering(div,option)
  {
      var i= document.getElementById(option).value;
      if(i=='0')
      {
          $("#"+div).show();
          document.getElementById(option).value=1;
      }
      else
      {
        $("#"+div).hide();
         document.getElementById(option).value=0;
      }
    
  }

  function filter_notifications_all()
  {
     var status = document.getElementById('notif_status').value;
     var from = document.getElementById('date_from').value;
     var to = document.getElementById('date_to').value;
     var notif = document.getElementById('notifs').value;

     if(status=='' || from=='' || to=='' || notif=='')
     {
      alert("Please fill up all fields to continue");
     }
     else
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
                  document.getElementById("filter_result").innerHTML=xmlhttp.responseText;
                   $("#notif").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                  }
                }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_notifications/filter_notifications_all/"+notif+"/"+status+"/"+from+"/"+to,true);
            xmlhttp.send();
     }
  }

  function search(val)
  {
    var v = val+'-';
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
                document.getElementById("search_res").innerHTML=xmlhttp.responseText;
               
                }
              }
             xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_notifications/search_notif/"+v,true);
            
            xmlhttp.send();
  }
 
</script>

