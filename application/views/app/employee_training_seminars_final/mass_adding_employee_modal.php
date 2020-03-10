 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Select Employees</center></h4>
      </div>
     

      <div class="modal-body">
       
         <div class="panel panel-default">
        
        <div class="panel-body">
          <span class="dl-horizontal col-sm-6">
            <dt style="margin-top: 5px;">Company</dt>
            <dd  style="margin-top: 5px;">
                <select class="form-control" onchange="get_location_department_classification(this.value);" id="companyy">
                <option value="not_included" selected disabled>Select</option>
                    <?php foreach($companyList as $comp){ if($company_id==$comp->company_id){?>
                            <option value="<?php echo $comp->company_id;?>" ><?php echo $comp->company_name;?></option>
                    <?php } else{} }?>
                </select>
            </dd>

            <dt  style="margin-top: 5px;">Classification</dt>
            <dd  style="margin-top: 5px;">
               <select class="form-control" id="classification" onchange="get_filtered_employees();">
                    <option value="not_included" selected disabled>Select</option>
               </select>
            </dd>
           
            <dt  style="margin-top: 5px;">Section</dt>
            <dd  style="margin-top: 5px;">
               <select class="form-control" id="section" onchange="getemp_subsection(this.value);">
                    <option value="not_included" selected disabled>Select</option>
               </select>
            </dd>
          </span>
          <span class="dl-horizontal col-sm-6">
            <dt  style="margin-top: 5px;">Location</dt>
            <dd  style="margin-top: 5px;">
               <select class="form-control" id="location" onchange="get_filtered_employees();">
                    <option value="not_included" selected disabled>Select</option>
               </select>
            </dd>
            <dt  style="margin-top: 5px;">Department</dt>
            <dd  style="margin-top: 5px;">
               <select class="form-control" id="department" onchange="getemp_section(this.value);">
                    <option value="not_included" selected disabled>Select</option>
               </select>
            </dd>
             <dt  style="margin-top: 5px;">Sub Section</dt>
            <dd  style="margin-top: 5px;"> 
               <select class="form-control" id="subsection" onchange="get_filtered_employees();">
                    <option value="not_included" selected disabled>Select</option>
               </select>
            </dd>
          </span>
        </div>
        </div>
 <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><center>Filtered Employees Results</center></i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-12" id="selected_employees_here">
            <table class="col-md-12 table table-bordered" id="emp_list">
                <thead>
                    <tr class="danger">
                        <th>ID</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
          </span>
        </div>
        </div>

        <input type="hidden" id="selectedemployees_filtered" class="form-control">
        <input type="hidden" id="check_uncheck" class="form-control" value="0">

        <div class="modal-footer">
            <button type="submit" class="btn btn-success" onclick="mass_add_emp();" class="close" data-dismiss="modal">Add</button>
            <button type="submit" class="btn btn-info" onclick="check_uncheck();">CHECK|UNCHECK</button>
            <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Close</button>
      </div>
      </div>


     

</div>
  
<script type="text/javascript">
     $(function () {
        $('#emp_list').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

     function get_location_department_classification(company)
     {
        getemp_location(company);
        getemp_classification(company);
        getemp_department(company);
        get_filtered_employees();

     }

     function getemp_location(company)
     {
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("location").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/getemp_location/"+company,false);
        xmlhttp2.send();
     }

     function getemp_classification(company)
     {
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("classification").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/getemp_classification/"+company,false);
        xmlhttp2.send();
     }
     function getemp_department(company)
     {
          get_filtered_employees();
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("department").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/getemp_department/"+company,false);
        xmlhttp2.send();
     }

     function getemp_section(department)
     {
        var company = document.getElementById('company').value;
          get_filtered_employees();
        
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("section").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/getemp_section/"+department+"/"+company,false);
        xmlhttp2.send();
     }

     function getemp_subsection(section)
     {
        var company = document.getElementById('company').value;
        var department = document.getElementById('department').value;
          get_filtered_employees();
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("subsection").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/getemp_subsection/"+section+"/"+department+"/"+company,false);
        xmlhttp2.send();
     }

     function get_filtered_employees()
     {
        
        var xmlhttp; 
        var company = document.getElementById('companyy').value;
        var department = document.getElementById('department').value;
        var section = document.getElementById('section').value; 
        var location = document.getElementById('location').value;
        var classification = document.getElementById('classification').value;
        var subsection = document.getElementById('subsection').value;


         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("selected_employees_here").innerHTML=xmlhttp2.responseText;
               $("#filtered_emp").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_filtered_employees/"+company+"/"+location+"/"+classification+"/"+department+"/"+section+"/"+subsection,false);
        xmlhttp2.send();
     }

    function check_uncheck()
    {
   
        var count_class = document.getElementById('all_emp_count').value;
        var cinput =   document.getElementsByClassName('empselected');
        var option = document.getElementById('check_uncheck').value;
   
            if(option==0)
            {
              document.getElementById('check_uncheck').value=1;
              document.getElementById('selectedemployees_filtered').value="";
              for (i=0;i < count_class; i++)
                {
                 
                    cinput[i].checked = true;
                    emp = cinput[i].value;
                    document.getElementById('selectval'+emp).value='1';  
                    var selected = document.getElementById('selectedemployees_filtered').value;
                    var res = selected +=emp + "-";
                    document.getElementById('selectedemployees_filtered').value=res;  
                   
                }
                
            }
            else
            {  
              document.getElementById('check_uncheck').value=0;
              document.getElementById('selectedemployees_filtered').value="";
              for (i=0;i < count_class; i++)
                {
                    cinput[i].checked = false;
                    emp = cinput[i].value;
                     document.getElementById('selectval'+emp).value='0'; 
                }
              document.getElementById('check_uncheck').value='0';
            }

  }
  function selectval_emp(employee_id)
  {
    var d = document.getElementById('selectval'+employee_id).value;
    if(d=='1')
    {
        document.getElementById('selectval'+employee_id).value='0';
        var selected = document.getElementById('selectedemployees_filtered').value;
        var res = selected.replace(employee_id+"-", "");
        document.getElementById('selectedemployees_filtered').value=res;

    }
    else
    {
        document.getElementById('selectval'+employee_id).value='1';

        var selected = document.getElementById('selectedemployees_filtered').value;
        var res = selected +=employee_id + "-";
        document.getElementById('selectedemployees_filtered').value=res;
            
    }
  }

  function mass_add_emp()
  {
    var selected =   document.getElementById('selectedemployees_filtered').value;
    var company = document.getElementById('company').value;

    if(selected=='')
    {
     
        alert("Please select atleast one employee to continue");   
         $('#smbt_ind').hide();   
         var selected_='-';  
    }
    else
    {
      var selected_=selected;  
      $('#smbt_ind').show();
    }
       
        if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("selected_employee_ts").innerHTML=xmlhttp2.responseText;
              $("#selected_emp").DataTable({
                         "pageLength": -1,
                        "pagingType" : "simple",
                        "paging": true,
                        "lengthChange": true,
                        lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                        "searching": false,
                        "ordering": true,
                        "info": false,
                        "autoWidth": false
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/mass_add_emp/"+selected_+"/"+company,false);
        xmlhttp2.send();
    
  }
</script> 