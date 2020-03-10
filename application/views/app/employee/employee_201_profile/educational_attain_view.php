<?php include('header.php');?>
        
        <div id="col_2">
                
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>EDUCATIONAL ATTAINMENT</strong></strong>

     <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

      ?>
      <a onclick="educational_attain_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
      <?php } }?>
      </div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>


       <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">

       <?php foreach($education_attain_view as $education){ ?>

       <div class="box-body">

      <div><label><?php echo $education->education_name; ?></label>
       <?php if($checker_inactive==0){?>
        <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/educational_attain_delete/'. $education->id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

        <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="educational_attain_edit('<?php echo $education->id; ?>')"></i>
      <?php } ?>
      </div>

       <div class="col-md-12"><div class="box box-success"></div></div>

          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>School name</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $education->school_name; ?></label>
            </div>
            </div>
            </div>


            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>School address</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $education->school_address; ?></label>
            </div>
            </div>
            </div>
          
          <?php if($education->course!=null){ ?>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Course</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $education->course; ?></label>
            </div>
            </div>
            </div>

          <?php } ?>

          <?php if($education->honors!=null){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Honors</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $education->honors; ?></label>
            </div>
            </div>
            </div>
          <?php } ?>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Date started</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($education->date_start)); ?></label>
            </div>
            </div>
            </div>

          <?php if($education->date_end!=null AND $education->date_end!='0000-00-00'){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Date graduated</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($education->date_end)); ?></label>
            </div>
            </div>
            </div>
          <?php } 
          else {?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Date graduated</p>
            </div>
            <div class="col-sm-7">
              <label>Unfinished</label>
            </div>
            </div>
            </div>
          <?php } ?>

            </div>
            </div><!-- /.box-body -->   
    
     <?php } ?>
            
      <?php if(count($education_attain_view)==0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No Educational Attainment(s) yet.</strong></p>
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


 

        </div>  
</div>

<script>
    

    function educational_attain_add(val)
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
          $('#date_start').Zebra_DatePicker({
              direction: ['1852-01-01', currentdate],
              pair: $('#date_end')
          });
          $('#date_end').Zebra_DatePicker({
                direction: [true,currentdate]
          });

        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/educational_attain_add/"+val,true);
      xmlhttp.send();

    }
    function educational_attain_edit(val)
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
          $('#date_start').Zebra_DatePicker({
              direction: ['1852-01-01', currentdate],
              pair: $('#date_end')
          });
          $('#date_end').Zebra_DatePicker({
                direction: [true,currentdate]
          });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/educational_attain_edit/"+val,true);
      xmlhttp.send();
    }
    
    function allowCourse(val)
    {          
        if(val==1 || val==2)
        { document.getElementById('course').disabled=true; }
        else{ document.getElementById('course').disabled=false; }
    }

    function date_graduated(val)
    {
      if(document.getElementById('isGraduated_').checked)
        { 
            document.getElementById('isGraduated').value='no';
            document.getElementById('date_end').disabled=true;
            document.getElementById('date_end').value='';
        } 
        else
        { 
            document.getElementById('isGraduated').value='yes';
            document.getElementById('date_end').disabled=false;
        }
    }

</script>

        </div>

        </div>
 <?php include('footer.php');?>


