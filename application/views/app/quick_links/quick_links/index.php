  <?php 
          if(!empty($this->session->userdata('is_applicant')))
          { $role = 'applicant'; }
          else if($this->session->userdata('is_logged_in')){
                if(empty($this->session->userdata('user_role')))
                { $role = "employee"; }
                else
                { $role = "admin"; }
          }
          else{ $role = "employer"; } 

if($role=='admin' || $role=='employer'){ require_once(APPPATH.'views/app/quick_links/quick_links/admin_employer_portal.php'); } 
else if($role=='employee'){ require_once(APPPATH.'views/app/quick_links/quick_links/employee_portal.php'); } 
else { require_once(APPPATH.'views/app/quick_links/quick_links/applicant_portal.php'); } ?>
   <!--//==========End Js/bootstrap==============================//-->
    <script type="text/javascript">
      
      function quick_links_action(portal_id,module_id)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                $("#results").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/quick_links/quick_links_action/"+portal_id+"/"+module_id,false);
          xmlhttp2.send();
      }

      function show_hide_system_help(show)
      {
        var x = document.getElementById(show);
          if (x.style.display === "none") {
              x.style.display = "block";
          } else {
              x.style.display = "none";
          }
      }
    </script>