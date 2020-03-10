<?php include('header.php');?>
<div id="col_2">
<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>  EMPLOYMENT INFORMATION</strong> 
       <?php if($checker_inactive==0){

if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

        ?>
        <a onclick="employment_info_edit('<?php echo $employee_id;?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a>
        <?php } }?>
        </div>

    <div class="box-body">
      <div class="panel panel-success">
    	 <br>
        
          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Company</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->company_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Location</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->location_name; ?></label>
            </div>
            </div>
            </div>

            <?php if($employment_info_view->wDivision==1){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Division</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->division_name; ?></label>
            </div>
            </div>
            </div>
            <?php } ?>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Department</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->dept_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Section</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->section_name; ?></label>
            </div>
            </div>
            </div>

            <?php if($employment_info_view->wSubsection==1){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Subsection</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->subsection_name; ?></label>
            </div>
            </div>
            </div>
            <?php } ?>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Employment type</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->employment_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Position</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->position_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Taxcode</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->taxcode_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Classification</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->classification_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Date employed</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($employment_info_view->date_employed)); ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Pay type</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->pay_type_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Report to</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $employment_info_view->report_to_name; ?></label>
            </div>
            </div>

            </div>
            </div>

     <br>
     </div>
    </div><!-- /.box-body -->
</div>
</div>

</div>  
</div>



        </div>  
</div>

<script>
       function employment_info_edit(val)
    {     
      var today = new Date();
      var dd    = today.getDate();
      var mm    = today.getMonth()+1;
      var yyyy  = today.getFullYear();

      if(dd<10) {
          dd = '0'+dd
      } 

      if(mm<10) {
          mm = '0'+mm
      } 

      currentdate = yyyy + '-' + mm + '-' + dd;

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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            $('#date_employed').Zebra_DatePicker({
                direction: ['1952-01-01', currentdate] 
            });
          }
        }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/employment_info_edit/"+val,true);
        xmlhttp.send();

    }

    //editing
    function getDivisionEdit(val)
    {          
        geteditlocation(val);
        geteditclassification(val);
          $("#department").load(location.href + " #department");
          $("#section").load(location.href + " #section");
          $("#subsection").load(location.href + " #subsection");
          document.getElementById('report_id').value='';
          document.getElementById('report_name').value='';
          
          document.getElementById('division').disabled=false;
         var xmlhttp;
            if (window.XMLHttpRequest)
              {
              xmlhttpDiv=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttpDiv=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttpDiv.onreadystatechange=function()
              {
              if (xmlhttpDiv.readyState==4 && xmlhttpDiv.status==200)
                {
                 document.getElementById("division").innerHTML=xmlhttpDiv.responseText;
                }
              }
            xmlhttpDiv.open("GET","<?php echo base_url();?>app/employee_201_profile/view_divisionEdit/"+val,true);
            xmlhttpDiv.send();
    }


    function geteditclassification(val)
      {          
        var xmlhttp;
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/view_classificationEdit/"+val,false);
        xmlhttp2.send();
    }

     function geteditlocation(val)
    {          
        var xmlhttp;
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/view_location/"+val,false);
        xmlhttp2.send();
    }
    function getDepartmentEdit(val)
    {
      var company=document.getElementById('company').value;
      $("#section").load(location.href + " #section");
      $("#subsection").load(location.href + " #subsection");

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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/view_departmentEdit/"+company+"/"+val,false);
        xmlhttp2.send();

    }
     function getSectiontEdit(val)
    {
      var company=document.getElementById('company').value;
      $("#subsection").load(location.href + " #subsection");
     

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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/view_sectionEdit/"+company+"/"+val,false);
        xmlhttp2.send();

    }
     function getsubSectiontEdit(val)
    {
      var company=document.getElementById('company').value;
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/view_subsectionEdit/"+company+"/"+val,false);
        xmlhttp2.send();
    }
     function report_to(val)
    {
      var company=document.getElementById('company').value;
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
             document.getElementById("add_showSearchResultss").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/employee_list/"+company+"/"+val,false);
        xmlhttp2.send();
    }
    function select_emp_addapprover(employee_id,name)
    {
      document.getElementById('report_id').value=employee_id;
      document.getElementById('report_name').value=name;
    }
</script>
        </div>

        </div>
 <?php include('footer.php');?>




