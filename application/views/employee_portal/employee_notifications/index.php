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
  <h4 class="panel-header">All Pending Notifications</h4>
 
 
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