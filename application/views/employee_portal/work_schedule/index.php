<br><br><br>
<div>
    <!-- Start of Side View -->
   

  <div class="col-md-12" style="height:auto;" id="main_res">
    <div class="panel box box-success" >
    <div class="col-md-12" style="margin-top: 20px;">
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Working Schedule</h4></ol>
    </div>

      <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="col-md-6">
                <select class="form-control" onchange="get_subsection(this.value);" id="section">
                    <option value="not_included" selected disabled>Select Section</option>
                    <option value="all">All</option>
                    <?php foreach($section as $sec){?>
                      <option value="<?php echo $sec->section;?>"><?php echo $sec->section_name;?></option>
                    <?php } ?>  
                </select>
              </div>
               <div class="col-md-6">
                  <select class="form-control" id="subsection" onchange="get_filtered_result();">
                    <option value="not_included" selected disabled>Select Subsection</option>
                    <option value="all">All</option>
                  </select>
                </div>

                 <div class="col-md-6" style="margin-top: 10px;">
                   <select class="form-control" id="location" onchange="get_filtered_result();">
                      <option value="not_included" selected disabled>Select Location</option>
                    <option value="all">All</option>
                    <?php foreach($location as $loc){?>
                      <option value="<?php echo $loc->location_id;?>"><?php echo $loc->location_name;?></option>
                    <?php } ?>
                </select>
                </div>

                 <div class="col-md-6" style="margin-top: 10px;">
                  <select class="form-control" id="classification" onchange="get_filtered_result();">
                    <option value="not_included" selected disabled>Select Classification</option>
                    <option value="all">All</option>
                    <?php foreach($classification as $c){?>
                      <option value="<?php echo $c->classification_id;?>"><?php echo $c->classification;?></option>
                    <?php } ?>
                </select>
                </div>



            </div>
            <div class="col-md-2"></div><br><br><br><br><br>
             <div class="box box-default" class='col-md-12'></div>
        </div>

        <div class="box-body">
          <div class="col-md-12" id="filter_result" >
               <table class="col-md-12 table table-responsive" id="ws">
                <thead>
                    <tr class="danger">
                        <th>No.</th>
                        <th>Employee</th>
                        <th>Section</th>
                        <th>Subsection</th>
                        <th>Classification</th>
                        <th>Location</th>
                        <th>Work Schedule</th>
                    </tr>
                </thead>
                <tbody>   
                      
                </tbody>
              </table>
          </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function () {
        $('#ws').DataTable({
          "pageLength":10,
          "pagingType" : "simple",
          "paging": true,
          lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
  function get_subsection(section)
  {
    get_filtered_result();

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
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_work_schedule_sm/get_subsection/"+section,false);
        xmlhttp2.send();
  }

  function get_filtered_result()
  {
    var section = document.getElementById('section').value;
    var subsection = document.getElementById('subsection').value;
    var location = document.getElementById('location').value;
    var classification = document.getElementById('classification').value;

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
            document.getElementById("filter_result").innerHTML=xmlhttp2.responseText;
                $("#ws").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_work_schedule_sm/get_filtered_result/"+section+"/"+subsection+"/"+location+"/"+classification,false);
        xmlhttp2.send();

  }
</script>
