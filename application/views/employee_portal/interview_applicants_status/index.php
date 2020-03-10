<div style="margin-top: 40px">
  <div class="col-md-3">
	    <div class="box box-solid box-success">
	        <div class="box-header">
	        <h4 class="box-title">Employee Rewards Points</h4></div>
	        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
	          <ul class="nav nav-pills nav-stacked">
	          	<?php foreach($process as $p){?>
	                <li class="my_hover">
	                    <a style="cursor: pointer;" onclick="get_interview_status('<?php echo $p->interview_id;?>');"><?php echo $p->title;?></a>
	                </li>
	            <?php } ?>
	          </ul>
	        </div>
	      </div>
	</div>

  <div class="col-md-9" style="height:500px;" id="main_res">
    <div class="panel box box-success" >

    </div>
  </div>
</div>


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
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/interview_applicants_status/get_interview_status/"+id,false);
        xmlhttp2.send();
	}

  function update_status(id)
  {

    $('#orig_status'+id).hide();
    $('#orig_comment'+id).hide();
    $('#orig_action'+id).hide();

    $('#upd_action'+id).show();
    $('#upd_status'+id).show();
    $('#upd_comment'+id).show();

  }
  
  function cancel(id)
  {
      $('#orig_status'+id).show();
      $('#orig_comment'+id).show();
      $('#orig_action'+id).show();

      $('#upd_action'+id).hide();
      $('#upd_status'+id).hide();
      $('#upd_comment'+id).hide();
  }

  function save_status(id)
  {
    var status = document.getElementById('status'+id).value;
    var comment = document.getElementById('comment'+id).value;

    function_escape('comment_final'+id,comment);
    var cc =  document.getElementById('comment_final'+id).value;

    if(cc=='')
    {
      ccc ='no_comment';
    } else { ccc = cc; }
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
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/interview_applicants_status/save_status/"+id+"/"+ccc+"/"+status,false);
        xmlhttp2.send();
    
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