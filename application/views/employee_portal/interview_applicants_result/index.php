<script>
        window.onload = function() { <?php echo $onload ?>; };
</script>

<div class="col-md-12" style="margin-top: 20px;">
  <?php echo $message;?>
</div>

<div style="margin-top: 40px">
  <div class="col-md-3">
	    <div class="box box-solid box-success">
	        <div class="box-header">
	        <h4 class="box-title">Employee Rewards Points</h4></div>
	        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
	          <ul class="nav nav-pills nav-stacked">
	          	<?php foreach($process as $p){
                  $count = $this->interview_applicants_result_model->get_with_no_interview_status($p->interview_id);
              ?>
	                <li class="my_hover">
	                    <a style="cursor: pointer;" onclick="get_interview_status('<?php echo $p->interview_id;?>');"><span class="badge badge-warning"><?php echo $count;?></span>&nbsp;&nbsp;&nbsp;<?php echo $p->title;?></a>
	                </li>
	            <?php } ?>
	          </ul>
	        </div>
	      </div>
	</div>

  <div class="col-md-9" id="main_res">
    <div class="panel box box-success" >

    </div>
  </div>
</div>

<style type="text/css">
          .badge-warning {
           background-color: #f89406;
          }
          .badge-warning:hover {
          background-color: #c67605;
          }
</style>

<script type="text/javascript">
	function get_interview_status(id)
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
              document.getElementById("main_res").innerHTML=xmlhttp2.responseText;
               $("#status").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result/get_interview_status/"+id,false);
        xmlhttp2.send();
	}

  function update_status(id)
  {

    $('#orig_status'+id).hide();
    $('#orig_comment'+id).hide();
    $('#orig_action'+id).hide();
    $('#orig_mess'+id).hide();

    $('#upd_action'+id).show();
    $('#upd_status'+id).show();
    $('#upd_comment'+id).show();
    $('#upd_mess'+id).show();
    
  }
  
  function cancel(id)
  {
      $('#orig_status'+id).show();
      $('#orig_comment'+id).show();
      $('#orig_action'+id).show();
      $('#orig_mess'+id).show();

      $('#upd_action'+id).hide();
      $('#upd_status'+id).hide();
      $('#upd_comment'+id).hide();
      $('#upd_mess'+id).hide();
  }

  function save_status(id,idd)
  {
    alert(idd);
    var status = document.getElementById('status'+id).value;
    var comment = document.getElementById('comment'+id).value;
    var message = document.getElementById('mess'+id).value;

    function_escape('comment_final'+id,message);
    var cc =  document.getElementById('comment_final'+id).value;


    function_escape('mess_final'+id,comment);
    var mm =  document.getElementById('mess_final'+id).value;
    
    if(cc=='')
    {
      ccc ='no_comment';
    } else { ccc = cc; }

    if(mm=='') { mmm = 'no_message'; } else{ mmm=mm; }

   

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
              location.reload();
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result/save_status/"+id+"/"+ccc+"/"+status+"/"+mmm+"/"+idd,false);
        xmlhttp2.send();
    
  }



  function filtering()
  {
    var x = document.getElementById('filtering');
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
  }


  function daterange()
  {
    var val = document.getElementById('daterange_value').value;

    if(val==0)
    {
      document.getElementById('date_from').disabled=true;
      document.getElementById('date_to').disabled=true;
      document.getElementById('daterange_value').value=1;
    }
    else
    {
      document.getElementById('date_from').disabled=false;
      document.getElementById('date_to').disabled=false;
      document.getElementById('daterange_value').value=0;
    }
  }

  function filter_result(id)
  {
     var date = document.getElementById('daterange_value').value;
     if(date==0)
     {
        var from = document.getElementById('date_from').value;
        var to =  document.getElementById('date_to').value;
     }
     else
     {
        var from = 'all';
        var to =  'all';
     }

     var result = document.getElementById('res').value;

     if(from=='' || to=='' || result=='')
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
              document.getElementById("filtering_results").innerHTML=xmlhttp2.responseText;
              $("#status").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/applicant_interview_result/filter_result/"+id+"/"+from+"/"+to+"/"+result,false);
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