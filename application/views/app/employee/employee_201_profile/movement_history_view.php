
<?php include('header.php');?>
<div id="col_2">
<div class="row">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>MOVEMENT HISTORY</strong>
  <?php if($checker_inactive==0){?>

  <a onclick="movement_history_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Click to add movement history"><i class="fa fa-plus-square-o fa-2x text-success pull-right"></i></a>

    <a onclick="movement_type()" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Click to manage movement type"><i class="fa fa-gear fa-2x text-success pull-right"></i></a>
  <?php } ?>
  </div>
  <div class="box-body" style="height: 560px;">
    	 <div class="scrollbar_all" id="style-1" style="height: 470px;">
         <div class="force-overflow">
          <div class="row">
            <div class="col-md-12">
            <div class="form-group">

                <?php foreach($movement_history_view as $movement_history){
                
                 $get_movement  = $this->employee_201_profile_model->get_movement_b($movement_history->id,$movement_history->employee_id);
                 $movement = $this->employee_201_profile_model->get_movement($movement_history->movement_type_id);

                if(empty($get_movement)){ $dataa = 'Original employment data'; }
                  else{ $dataa = $this->employee_201_profile_model->get_movement($get_movement); }

                  ?>
                <div class="panel panel-danger">
                  <div class="panel-heading"><strong><?php echo $movement." | ".date('d M Y', strtotime($movement_history->date_time)); ?></strong>
                <?php if(empty($movement_history->attached_file)){} else{?>
                  <a href="<?php echo base_url(); ?>app/employee_201_profile/download_movement_history/<?php echo $movement_history->attached_file; ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Download attached file <?php echo $movement_history->attached_file?>"><i class="fa fa-download fa-2x text-success pull-right"></i></a> 
                  <?php } ?>
                  <a type="text" class="pull-right"><strong>
                      <a  class="fa fa-trash fa-2x text-danger delete pull-right" data-toggle="tooltip" data-placement="left" title="Delete" href="<?php echo site_url('app/employee_201_profile/movement_history_delete/'. $movement_history->id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>
<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

?>
                     <a onclick="movement_history_edit('<?php echo $movement_history->id;?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil fa-2x text-success pull-right"></i></a>
<?php
}
?>



                </strong></a></div>
                  <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>From (Original Details)</th>
                        <th>To (Updated Details)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Movement Type</td>
                        <td><?php echo $dataa; ?></td>
                        <td><?php echo $movement; ?></td>
                      </tr>
                      <tr>
                        <td>Company</td>
                        <td><?php echo $movement_history->company_name_from; ?></td>
                        <td><?php echo $movement_history->company_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td><?php echo $movement_history->location_name_from; ?></td>
                        <td><?php echo $movement_history->location_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Division</td>
                        <td><?php echo $movement_history->division_name_from; ?></td>
                        <td><?php echo $movement_history->division_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Department</td>
                        <td><?php echo $movement_history->department_name_from; ?></td>
                        <td><?php echo $movement_history->department_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Section</td>
                        <td><?php echo $movement_history->section_name_from; ?></td>
                        <td><?php echo $movement_history->section_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Subsection</td>
                        <td><?php echo $movement_history->subsection_name_from; ?></td>
                        <td><?php echo $movement_history->subsection_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Employment</td>
                        <td><?php echo $movement_history->employment_name_from; ?></td>
                        <td><?php echo $movement_history->employment_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Classification</td>
                        <td><?php echo $movement_history->classification_name_from; ?></td>
                        <td><?php echo $movement_history->classification_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Taxcode</td>
                        <td><?php echo $movement_history->taxcode_name_from; ?></td>
                        <td><?php echo $movement_history->taxcode_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Pay type</td>
                        <td><?php echo $movement_history->pay_type_name_from; ?></td>
                        <td><?php echo $movement_history->pay_type_name_to; ?></td>
                      </tr>
                      <tr>
                        <td>Report to</td>
                        <td><?php echo $name = $this->employee_201_profile_model->report_name($movement_history->report_to_from); ?></td>
                        <td><?php echo $movement_history->report_to_name; ?></td>
                      </tr>
                       <tr class='success'>
                        <td colspan="3">Comment : <n class='text-success'><?php echo $movement_history->comment; ?></n></td>
                       
                      </tr>
                      

                    </tbody>
                  </table>
                  </div>
                  </div>
                <?php } ?>

                <?php if(count($movement_history_view)<=0){?>
                <tr>
                  <td>
                  <p class='text-center'><strong>No Movement history(ies) yet.</strong></p>
                  </td>
                </tr>
                <?php } ?>

            </div>
            </div>

             </div>
             </div>
     </div> 
     </div>

</div>
</div>

</div>  
</div>

</div>  
</div>
  </div>
</div>
<script>
    function movement_type()
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
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                 $("#movement_type_").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/movement_type/",true);
            xmlhttp.send();
    }

    function movement_type_action(option,title,id)
    {
      if(option=='delete')
      {
          var result = confirm('Are you sure you want to delete id - '+id);
          if(result == true)
          { 
              movement_action(option,title,id);
          }
      }
      else if(option=='edit')
      { 
        $("#u_title"+id).show();
        $("#o"+id).hide();
        $("#u"+id).show();
        $("#o_title"+id).hide();
        

      } 
      else if(option=='cancel_update')
      {
        $("#u_title"+id).hide();
        $("#o"+id).show();
        $("#u"+id).hide();
        $("#o_title"+id).show();
      }

      else if(option=='save_update')
      {
        var title1 =  document.getElementById('updatetitle'+id).value;
        function_escape('updatetitle_final'+id,title1);
        var final =  document.getElementById('updatetitle_final'+id).value;
        movement_action(option,final,id); 
      }
      else if(option=='save')
      {
        var title = document.getElementById('title_add').value;
        function_escape('title_add_final',title);
        var final = document.getElementById('title_add_final').value;
        movement_action(option,final,id); 
      }
    }
  function movement_action(option,title,id)
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
                  document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                   $("#movement_type_").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
                }
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/movement_type_action/"+option+"/"+title+"/"+id,true);
                xmlhttp.send();
  }

  function movement_history_add(val)
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
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/movement_history_add/"+val,true);
            xmlhttp.send();
    }
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
     function report_to(val)
    {
      var company=document.getElementById('company').value;
      if(company==''){ alert("Please select company to continue."); }
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
             document.getElementById("add_showSearchResultss").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/employee_list/"+company+"/"+val,false);
        xmlhttp2.send();
      }
    }
    function select_emp_addapprover(employee_id,name)
    {
      document.getElementById('report_id').value=employee_id;
      document.getElementById('report_name').value=name;
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
     function movement_history_edit(val)
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
             document.getElementById("col_2").innerHTML=xmlhttp2.responseText;

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_201_profile/movement_history_edit/"+val,false);
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

     $(document).ready(function(){
      

      var a =  document.referrer;
      var url = a.split('/');
      var check_url = url[url.length-4];
      if(check_url=='dashboard')
      {
          movement_history_add(<?php echo $this->uri->segment("4"); ?>);
      }
      else
      {}
      
  });
</script>
 <?php include('footer.php');?>



