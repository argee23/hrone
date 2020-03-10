 
<?php 

      $count_em = count($withEmployees);
      if($count_em > 0)
      {
         $d='style=display:none;';
         $dd='style=display:block;';

      }
      else
      {
         $d='style=display:block;';
         $dd='style=display:none;';
      }

?>
 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b>EMPLOYEE REFERRAL POINTS</center></b></h4>
      </div>

     <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/application_forms/save_referral_points/<?php echo $job_id."/".$applicant_id."/".$app_id;?>">
      
      <div class="modal-body">
          <div class="col-md-12" id="companyyy" <?php echo $d;?>>
              <div class="col-md-2"></div>
              <div class="col-md-8">
                  <select class="form-control" onchange="get_all_employees(this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <option value="All">All</option>
                      <?php foreach($companyL as $c)
                      {?>
                          <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="col-md-2"></div>

          </div>
          <br><br><br>

        

          <div class="panel panel-default" <?php echo $dd;?> id="savedemployee">
          <div class="panel-heading">
          <strong><a class="text-danger">Assigned Employee Referral Points</i></a></strong>
          </div>

          <div class="panel-body">
            <span class="dl-horizontal col-sm-12">
              <div class="col-md-12" style="padding-bottom: 30px;" id="">
                  <table class="table table-hover" id="selectedemp">
                      <thead>
                        <tr class="danger">
                          <th>Company</th>
                          <th>Employee ID</th>
                          <th>Employee Name</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($withEmployees as $e){?>
                        <tr>
                          <td><?php echo $e->company_name;?></td>
                          <td><?php echo $e->employee_id;?></td>
                          <td><?php echo $e->fullname;?></td>
                        </tr>
                      <?php } ?>
                      </tbody>
                  </table>
              </div>
            </span>
          </div>
          </div>

        
          <div class="panel panel-default" <?php echo $d;?> id="addedEmployee">
          <div class="panel-heading">
          <strong><a class="text-danger">Employee List</i></a></strong>
          </div>

          <div class="panel-body">
            <span class="dl-horizontal col-sm-12">
              <div class="col-md-12" style="padding-bottom: 30px;" id="for_referral">

                  <table class="table table-hover" id="referral_points">
                      <thead>
                        <tr class="danger">
                          <th></th>
                          <th>Company</th>
                          <th>Employee ID</th>
                          <th>Employee Name</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>

                  
                  <input type="hidden" id="selected_employee" name="selected_employeee"  class="form-control" value="<?php echo $string;?>">
                  
              </div>
            </span>
          </div>
          </div>

          <div class="panel panel-default"  id="for_referralselected" style="display: none;">
          <div class="panel-heading">
          <strong><a class="text-danger">Selected Employees</i>
          <a class="btn btn-danger btn-xs pull-right" onclick="collapse('for_referralselected')"><i class="fa fa-times"></i></a>
          </a></strong>
          </div>

          <div class="panel-body">
            <span class="dl-horizontal col-sm-12">
              <div class="col-md-12" style="padding-bottom: 30px;" id="referralpoints_selected">
                  <table class="table table-hover" id="referral_points_selected">
                      <thead>
                        <tr class="danger">
                          <th></th>
                          <th>Company</th>
                          <th>Employee ID</th>
                          <th>Employee Name</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>
            </span>
          </div>
          </div>

        </div>


        
          <div class="modal-footer" <?php echo $dd;?> id="forUPdate">
            <button type="button" class="btn btn-success" onclick="view_update_form()">Update Selected Employee</button>
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
          </div>
      
          <div class="modal-footer" <?php echo $d;?> id="forADDed">
            <button type="submit" class="btn btn-success">Submit</button>
            <a type="button" class="btn btn-danger" onclick="collapse('for_referralselected')">View Selected Employee</a>
            <?php if($count_em > 0){?> 
            <a type="button" class="btn btn-info" onclick="view_added_emp()">Back</a>
            <?php } ?>
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
          </div>
     

      </form>
  </div>
  
<script type="text/javascript">
   
      $(function () {
        $('#referral_points').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
      $(function () {
        $('#referral_points_selected').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

       $(function () {
        $('#selectedemp').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
           lengthMenu: [[-1], ["All"]],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

      function get_all_employees(company,string)
      {
        if(window.XMLHttpRequest)
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
                    document.getElementById("for_referral").innerHTML=xmlhttp.responseText;
                     $(function () {
                      $('#referral_points').DataTable({
                         lengthMenu: [[10,20,30,40,50,-1], [10,20,30,40,50,"All"]]
                      });
                    });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/get_all_employees/"+company,true);
            xmlhttp.send();
      }

      function selected_employees(emp_id)
      {
        if(document.getElementById('employee_id'+emp_id).checked==true)
        {
            var selected = document.getElementById('selected_employee').value;
            var res = selected +=emp_id + "-";
            document.getElementById('selected_employee').value=res; 
        }
        else
        {
            var selected = document.getElementById('selected_employee').value;
            var res = selected.replace(emp_id+"-", "");
            document.getElementById('selected_employee').value=res;  
        }

        var x = document.getElementById('for_referralselected');
        if (x.style.display === "none") {
          } 
          else 
          {
            get_all_selected_employees('block');
          } 

        

      }

      function collapse(id)
      {
          var x = document.getElementById(id);
          if (x.style.display === "none") {
              x.style.display = "block";
              var a = 'block';
          } else {
              x.style.display = "none";
              var a = 'none';
          } 

          get_all_selected_employees(a);
      }

      function get_all_selected_employees(a)
      {
        if(a=='none'){} else{ 
        var selected = document.getElementById('selected_employee').value;
        if(selected==''){ var selected_emp='none'; }
        else
        {
          var selected_emp=selected;
        }
        if(window.XMLHttpRequest)
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
                    document.getElementById("referralpoints_selected").innerHTML=xmlhttp.responseText;
                     $(function () {
                      $('#referral_points_selected').DataTable({
                         lengthMenu: [[10,20,30,40,50,-1], [10,20,30,40,50,"All"]]
                      });
                    });
                    }
                  }
        xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/get_all_selected_employees/"+selected_emp,true);
        xmlhttp.send();
      }
      }

      function remove_selected_emp(emp_id)
      {
        var result = confirm("Are you sure you want to remove selected employee?");
        if(result == true)
        {

            document.getElementById('employee_id'+emp_id).checked=false;
            var selected = document.getElementById('selected_employee').value;
            var res = selected.replace(emp_id+"-", "");
            document.getElementById('selected_employee').value=res;  
         
            var x = document.getElementById('for_referralselected');
            if (x.style.display === "none") {} 
            else { get_all_selected_employees('block');  } 
        }
      }

      function view_added_emp()
      {
        var upd = document.getElementById('forUPdate');
        var add = document.getElementById('forADDed');
        var comp = document.getElementById('companyyy');
        var aDup = document.getElementById('addedEmployee');
        var emp = document.getElementById('savedemployee');
        var selec = document.getElementById('for_referralselected');
        

        add.style.display = "none";
        upd.style.display = "block";
        comp.style.display = "none";
        aDup.style.display = "none";
        emp.style.display = "block";
        selec.style.display = "none";
      }

      function view_update_form()
      {
        var upd = document.getElementById('forUPdate');
        var add = document.getElementById('forADDed');
        var comp = document.getElementById('companyyy');
        var aDup = document.getElementById('addedEmployee');
        var emp = document.getElementById('savedemployee');
        

        add.style.display = "block";
        upd.style.display = "none";
        comp.style.display = "block";
        aDup.style.display = "block";
        emp.style.display = "none";
      }
</script>