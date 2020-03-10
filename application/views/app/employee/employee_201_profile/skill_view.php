<?php include('header.php');?>
        
        <div id="col_2">
                
                  <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>SKILL</strong>
   <?php if($checker_inactive==0){?>
      <a onclick="skill_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
    <?php } ?>

    </div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>

       <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">
         <div class="col-md-12">
           <table class="table table-responsive table-bordered table-striped table-hover " style="background-color: #fff" id="skills">
             <thead>
                <tr class="danger">
                  <th style="width:30%;">Skill Name</th>
                  <th style="width:50%;">Skill Description</th>
                  <th style="width:20%;text-align: center;">Action</th>
                </tr>
                <tbody>
                <?php foreach($employee_skill as $skill){ ?>
                 <tr>
                    <td><?php echo $skill->skill_name?></td>
                    <td><?php echo $skill->skill_description?></td>
                    <td>
                       <?php if($checker_inactive==0){?>
                       <a class="btn btn-danger btn-xs" data-toggle="tooltip" href="<?php echo site_url('app/employee_201_profile/skill_delete/'. $skill->skill_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')">DELETE</a>
<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

?>
                       <button class="btn btn-primary btn-xs" data-toggle='tooltip'  onclick="skill_edit('<?php echo $skill->skill_id; ?>')">EDIT</button>
<?php
}
?>


                       <?php } else{ echo "not allowed";} ?>
                    </td>
                 </tr>
                <?php }?>
           
            </tbody>
            </thead>
         </table>
          </div>
      <?php if(count($employee_skill)<=0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No Skill(s) yet.</strong></p>
        </td>
      </tr>
      <?php } ?>

             </div>
             </div>
     <br>
     </div>

      </div>
    </div>
    </div>  
  </div>
 </div>  
</div>

<script>
 $(function () {
        $('#skills').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
   function skill_add(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/skill_add/"+val,true);
      xmlhttp.send();
    }

    function skill_edit(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/skill_edit/"+val,true);
      xmlhttp.send();
    }

</script>

        </div>

        </div>
 <?php include('footer.php');?>


