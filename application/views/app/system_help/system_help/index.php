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

if($role=='admin' || $role=='employer'){ require_once(APPPATH.'views/app/system_help/system_help/admin_employer_portal.php'); } 
else if($role=='employee'){ require_once(APPPATH.'views/app/system_help/system_help/employee_portal.php'); } 
else { require_once(APPPATH.'views/app/system_help/system_help/applicant_portal.php'); } ?>


    <script type="text/javascript">
       function collapse(id)
      {
        var x = document.getElementById(id);
          if (x.style.display === "none") {
              x.style.display = "block";
          } else {
              x.style.display = "none";
          } 
      }
  
      function system_help_action(portal_id,module_id)
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
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/system_help_action/"+portal_id+"/"+module_id,false);
          xmlhttp2.send();
      }

      //search now

      function search_now(option)
      {
          if(option=='word_by_word'){ var sd ='search'; } else { var sd = 'searchh'; }
          var search = document.getElementById(sd).value;
          function_escape(sd+"_final",search);
          var final_search = document.getElementById(sd+'_final').value;

          if(final_search=='')
          {
            alert('Fill up search criteria to continue');
          }
          else
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
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/search_now/"+final_search+"/"+option,false);
          xmlhttp2.send();

        }
      }

      function get_module_list(portal,idd)
      {
        if(portal=='')
        {
          alert('Fill up portal field to continue');
        }
        else
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
                document.getElementById(idd).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/get_module_list/"+portal,false);
          xmlhttp2.send();
        }
      }

      function get_topic_list(module,idd,typ)
      {
        var portal = document.getElementById('portal'+typ).value;
        if(portal=='' || module=='')
        {
          alert('Fill up module and portal field to continue');
        }
        else
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
                document.getElementById(idd).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/get_topic_list/"+portal+"/"+module,false);
          xmlhttp2.send();
        }
      }

      function get_subtopic_list(topic,idd,typ)
      {
        var portal = document.getElementById('portal'+typ).value;
        var module = document.getElementById('module'+typ).value;

        if(subtopic=='')
        {
          alert('Fill up topic field to continue');
        }
        else
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
                document.getElementById(idd).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/get_subtopic_list/"+portal+"/"+module+"/"+topic,false);
          xmlhttp2.send();
        }
      }


      function filter_results(portal,module,topic,subtopic,idd)
      {
        var portalval = document.getElementById(portal).value;
        var moduleval = document.getElementById(module).value;
        var topicval = document.getElementById(topic).value;
        var subtopicval = document.getElementById(subtopic).value;

        if(portalval=='' || moduleval=='' || topicval=='' || subtopicval=='')
        {
            alert('Fill up all fields to continue');
        }
        else
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
                  document.getElementById(idd).innerHTML=xmlhttp2.responseText;
                   $("#results").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]    
                        });
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/filter_results/"+portalval+"/"+moduleval+"/"+topicval+"/"+subtopicval,false);
            xmlhttp2.send();
        }
      }

      function search_filter_results(portal,module,topic,subtopic,idd)
      {
        var portalval = document.getElementById(portal).value;
        var moduleval = document.getElementById(module).value;
        var topicval = document.getElementById(topic).value;
        var subtopicval = document.getElementById(subtopic).value;
        var search = document.getElementById('search_').value;
        function_escape("search_final",search);
        var final_search = document.getElementById('search_final').value;



        if(portalval=='' || moduleval=='' || topicval=='' || subtopicval=='')
        {
            alert('Fill up all fields to continue');
        }
        else
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
                  document.getElementById(idd).innerHTML=xmlhttp2.responseText;
                   $("#results").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]       
                        });
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/search_filter_results/"+portalval+"/"+moduleval+"/"+topicval+"/"+subtopicval+"/"+final_search,false);
            xmlhttp2.send();
        }
      }


      function keyword_search(portal,module,topic,subtopic)
      {

          var search = document.getElementById('search2').value;
          function_escape("search2_final",search);
          var final_search = document.getElementById('search2_final').value;
          
          
          if(final_search=='')
          {
            alert('Fill up search criteria to continue');
          }
          else
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
                    document.getElementById('keyword_searchh').innerHTML=xmlhttp2.responseText;
                    $("#results").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]       
                        });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/system_help/keyword_search/"+final_search+"/"+portal+"/"+module+"/"+topic+"/"+subtopic,false);
              xmlhttp2.send();

          }
      }

      function function_escape(ids,titles)
      {
         var a = titles.replace(/\?/g, '-a-');
         var b = a.replace(/\!/g, "-b-");
         var c = b.replace(/\//g, "-c-");
         var d = c.replace(/\|/g, "-d-");
         var e = d.replace(/\[/g, "-e-");
         var f = e.replace(/\]/g, "-f-");
         var g = f.replace(/\(/g, "-g-");
         var h = g.replace(/\)/g, "-h-");
         var i = h.replace(/\{/g, "-i-");
         var j = i.replace(/\}/g, "-j-");
         var k = j.replace(/\'/g, "-k-");
         var l = k.replace(/\,/g, "-l-");
         var m = l.replace(/\'/g, "-m-");
         var n = m.replace(/\_/g, "-n-");
         var o = n.replace(/\@/g, "-o-");
         var p = o.replace(/\#/g, "-p-");
         var q = p.replace(/\%/g, "-q-");
         var r = q.replace(/\$/g, "-r-");
         var s = r.replace(/\^/g, "-s-");
         var t = s.replace(/\&/g, "-t-");
         var u = t.replace(/\*/g, "-u-");
         var v = u.replace(/\+/g, "-v-");
         var w = v.replace(/\=/g, "-w-");
         var x = w.replace(/\:/g, "-x-");
         var y = x.replace(/\;/g, "-y-");
         var z = y.replace(/\%20/g, "-z-");
         var aa = y.replace(/\./g, "-zz-");
         var bb = aa.replace(/\</g, "-aa-");
         var cc = bb.replace(/\>/g, "-bb-");
         document.getElementById(ids).value=cc;
      }


    </script>