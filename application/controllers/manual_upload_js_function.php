<script>
    
    function manual_ws_get_group(paytype)
    { 

         var company = document.getElementById('company').value;
         
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
              document.getElementById("group").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/upload_working_schedules/get_group/"+paytype+"/"+company,true);
          xmlhttp.send();
    }


    function get_payroll_period(group)
    {
          var company = document.getElementById('company').value;
          var paytype = document.getElementById('paytype').value;
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
              document.getElementById("payroll_period").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/upload_working_schedules/get_payroll_period/"+paytype+"/"+company+"/"+group,true);
          xmlhttp.send();
    }

    function option_status(option)
    {
      if(option=='reset_add')
      {
        $('#action').hide();
        $('#upload').hide();
        document.getElementById('action').value='Save';

      }
      else
      {
        $('#upload').show();
        $('#action').show();
      }
    }
    </script>
    