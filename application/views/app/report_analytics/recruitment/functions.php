<script type="text/javascript">
  
  function get_filtering(code)
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
              document.getElementById("result_here").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_analytics_filtering/"+code,false);
        xmlhttp2.send();
  }

  function get_company_code1(company)
  {
    if(company=='Multiple')
    {
      $('#multiplecompany').show();
    }
    else
    {
      $('#multiplecompany').hide();
    }
  }

  function multiple_company_checker()
  {
      var checks = document.getElementsByClassName("multiple_company");
      var fields='';

      var count = document.getElementById('companymultiple_count').value;
     
              for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                {
                  fields +=checks[i].value + "-";
                  
                }
              }
     if(fields=='')
     {
      document.getElementById('sbmt').disabled=true;
      alert("Select alteast one company to continue");
     }
     else
     {
       document.getElementById('sbmt').disabled=false;
     }

     document.getElementById('companymultiple_list').value=fields;
  }



  function get_company_job_positions(company)
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
              document.getElementById("position").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_company_job_positions/"+company,false);
        xmlhttp2.send();
  }

  function get_company_job_positions_a11(company)
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
              document.getElementById("position").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_company_job_positions_a11/"+company,false);
        xmlhttp2.send();
  }


  function get_multiple_positions(position)
  {
      if(position=='Multiple')
      {
        $('#for_multiple_positions').show();
        var to = document.getElementById('date_to').value;
        var from  = document.getElementById('date_from').value;
        var company = document.getElementById('company').value;
        var option = document.getElementById('date_range_option').value;

        if(to=='' || from=='' || company=='' || option==''){}
        else{ 
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
                  document.getElementById("for_multiple_positions").innerHTML=xmlhttp2.responseText;
                }
              }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_multiplepositions/"+to+"/"+from+"/"+company+"/"+option,false);
        xmlhttp2.send(); }
      }
      else { $('#for_multiple_positions').hide(); }
  }


  function multiple_position_checker()
  {
      var checks = document.getElementsByClassName("multiple_position");
      var fields='';

      var count = document.getElementById('positionmultiple_count').value;
     
              for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                {
                  fields +=checks[i].value + "-";
                  
                }
              }
     if(fields=='')
     {
      document.getElementById('sbmt').disabled=true;
      alert("Select alteast one company to continue");
     }
     else
     {
       document.getElementById('sbmt').disabled=false;
     }

     document.getElementById('positionmultiple_list').value=fields;
  }
  
  function get_company_employee_id(company)
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
              document.getElementById("employee_id").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_company_employee_id/"+company,false);
        xmlhttp2.send();
  }















  //new added function for getting the job titles based on date range and company

  function get_job_position_by_date()
  {

    var to = document.getElementById('date_to').value;
    var from  = document.getElementById('date_from').value;
    var company = document.getElementById('company').value;
    var option = document.getElementById('date_range_option').value;

    if(to=='' || from=='' || company=='' || option==''){}
    else{
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
              document.getElementById("position").innerHTML=xmlhttp2.responseText;
            }
          }
    xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_company_position_by_date/"+to+"/"+from+"/"+company+"/"+option,false);
    xmlhttp2.send(); }
  }
</script>