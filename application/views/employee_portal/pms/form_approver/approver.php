
<br><br>

    
    <style type="text/css">

 .panel-group .panel {
        border-radius: 0;
        box-shadow: none;
        border-color: #EEEEEE;
    }

    .panel-default > .panel-heading {
        padding: 0;
        border-radius: 0;
        color: #212121;
        background-color: #FAFAFA;
        border-color: #EEEEEE;
    }

    .panel-title {
        font-size: 14px;
    }

    .panel-title > a {
        display: block;
        padding: 15px;
        text-decoration: none;
    }

    .more-less {
        float: right;
        color: #212121;
    }

    .panel-default > .panel-heading + .panel-collapse > .panel-body {
        border-top-color: #EEEEEE;
    }

/* ----- v CAN BE DELETED v ----- */


.demo {
    padding-top: 60px;
    padding-bottom: 60px;
}

      .prettyline {
      height: 5px;
      border-top: 0;
      background: #c4e17f;
      border-radius: 5px;
      background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    } .wrimagecard{ 
  margin-top: 0;
    margin-bottom: 1.5rem;
    text-align: left;
    position: relative;
    background: #fff;
    box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
    border-radius: 4px;
    transition: all 0.3s ease;
}
.wrimagecard .fa{
  position: relative;
    font-size: 70px;
}
.wrimagecard-topimage_header{
height:140px;
padding: 10px;
}
a.wrimagecard:hover, .wrimagecard-topimage:hover {
    box-shadow: 2px 4px 8px 0px rgba(46,61,73,0.2);
}
.wrimagecard-topimage a {
    width: 100%;
    height: 100%;
    display: block;
}
.wrimagecard-topimage_title {
    padding: 20px 24px;
    height: 80px;
    padding-bottom: 0.75rem;
    position: relative;
}
.wrimagecard-topimage a {
    border-bottom: none;
    text-decoration: none;
    color: #525c65;
    transition: color 0.3s ease;
}

</style>

<div ng-app="app" ng-controller="appCtrl">
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Form Approval </h2>
<div class="container">
  <p id="message"></p>
    <!-- Success Feedback -->
        <?php if ($this->session->flashdata('feedback')) { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('feedback'); ?>
            </div>
        <?php } ?>

        <!-- Failed Feedback -->
        <?php if ($this->session->flashdata('error')) { ?>
         <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>


  <div class="panel panel-body table-responsive">


       <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title"><?php echo ucwords('Employee list');?></h3>
              <div class="pull-right box-tools">
                <a href="<?php echo base_url();?>employee_portal/pms/mass_approval/" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                  Mass Approval</a>
              </div>
        </div>
        <div class="box-body">
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>Document No.</th>
                <th>Name</th>
              
                <th><center>Details</center></th>
              </tr>
            </thead>
           
            <tbody>   
             
             <?php foreach ($employee as $employee)
              { 
                
              ?>
              
              <tr class="my_hover">
           

                      <td><a onclick=" form_name='<?php echo $employee->doc_no ;?>'; table_name='<?php echo $employee->doc_no ?>'; identification='<?php echo $employee->doc_no ;?>'" href="<?php base_url('employee_portal/pms/get_form_details/'); ?>" ><strong><?php echo strtoupper($employee->doc_no) ?></strong></a></td>
                        
                  <td><?php echo strtoupper($employee->fullname) ?></td>
              
                <td><center><a data-toggle="modal" data-target="#myModal1" onclick="dependents_modal('<?php echo $employee->doc_no ?>','<?php echo $employee->fullname ?>','<?php echo $employee->classification ?>','<?php echo $employee->position_name ?>','<?php echo $employee->dept_name ?>','<?php echo $employee->location_name ?>','<?php echo $employee->doc_no ?>','<?php echo $employee->employee_id ?>','<?php echo $employee->appro_level; ?>',<?php echo $company; ?>);get('<?php echo $employee->appro_level ?>','<?php echo $employee->doc_no ?>','<?php echo $employee->employee_id ?>');"  href="" ><span class="badge bg-green">View Details</span></a></center></td>
              </tr>

              <?php  } ?>

              
          </tbody>

          </table>
          </div>
          </div>
      
        <input type="hidden" id="doc_no">
        <input type="hidden" id="appro_level">


  </div>


</div>
</div>
</div>
</div>


<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div id="tae"></div>
    <!-- Modal content-->

  </div>
</div>
<!-- Angular Js Script -->
<script type="text/javascript">
function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}


  //   function form(name,classification,position,dept,l,ref,employee_id,appro_level){

  //      $('#full').html(name);
  //       $('#classification').html(classification);
  //       $('#pos').html(position);
  //       $('#dept').html(dept);
  //       $('#l').html(l);
  //       $('#doc_no').html(ref);
  //       $('#appro_level').val(appro_level);


        
    
  //       $.ajax({
  //           dataType: "JSON",
  //           url: "<?php echo base_url();?>employee_portal/pms/get_form_details/"+ref+'/'+employee_id,
  //           type: 'POST',
  //           success: function(data){
  //                  for(var i=0;i<data.length;i++){
  //           $('#main').append(data[i].area)
  //       }
        
  //           }
  //       });
      
  // }
function get(appro_level,doc_no){

                doc_no = $('#doc_no').val(doc_no);
                appro_level = $('#appro_level').val(appro_level);

}
function dependents_modal(doc_no,name,classification,position,dept,l,ref,employee_id,appro_level,company){


       $('#full').html(name);
        $('#classification').html(classification);
        $('#pos').html(position);
        $('#dept').html(dept);
        $('#l').html(l);
        $('#doc_no').html(ref);
        $('#appro_level').val(appro_level);


            $.ajax({ 

              url: "<?php echo base_url();?>employee_portal/pms/dependents_modal/",
              type: 'POST',
              data: {doc_no:doc_no,name:name,position:position,classification:classification,employee_id,employee_id,department:dept,company:company},
                
                success: function(data) {
                 //  if(e == 'true'){
                            // window.location.replace("<?php echo base_url(); ?>employee_portal/pms/evaluation");
                          
                     $('#tae').html(data);
                           //  }else{ 
                //   $('#message').show();
                //   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                //   $('#myModal').modal('hide');
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
}

     function next_appro(company){
                
                name = $('#full').text();
                doc_no = $('#doc_no').val();
                appro_level = $('#appro_level').val();
                  c_employee_id = $('#c_employee_id').val();
                            score_equivalent = $('#score_equivalent').val();
                  score_total = $('#score_total').val();



        
                var form_title_array = [];
                    var c_form_part = [];
                 var weight_array = [];
                  var score_array = [];
                         var total_array = [];
                           var rate_array = [];
                             var c_score_array = [];
                             var c_cid_array = [];
                         
                $('.form_title').each(function(){
                    form_title_array.push($(this).text());
         

              })
                   $('.weight').each(function(){
        
                    weight_array.push($(this).text());

              })
                       $('.score').each(function(){
        
                    score_array.push($(this).text());

              })
             
                  $('.total').each(function(){
                    total_array.push($(this).text());
         

              })
                        $('.rate').each(function(){
                    rate_array.push($.trim($(this).text()));
         

              })
                                   $('.c_score').each(function(){
                    c_score_array.push($.trim($(this).text()));
         

              })
             $('.c_cid').each(function(){
                    c_cid_array.push($(this).val());
         

              })
                $('.form_part').each(function(){
                    c_form_part.push($(this).text());
         

              })
       
       
             
            $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/next_appro') ?>",
                type: 'POST',
                 data: {appro_level:appro_level,doc_no:doc_no,form_title_array:form_title_array,score_array:score_array,weight_array:weight_array,total_array:total_array,c_score_array:c_score_array,rate_array:rate_array,c_cid_array:c_cid_array,c_employee_id:c_employee_id,c_form_part:c_form_part,score_equivalent:score_equivalent,score_total:score_total,company:company},
                
                success: function(data) {
                 //  if(e == 'true'){
                            // window.location.replace("<?php echo base_url(); ?>employee_portal/pms/evaluation");
                           location.reload(true); 
                      
                           //  }else{ 
                $('#message').show();
               $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
               $('#myModal1').modal('hide');
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
            
            }   


$('.qwe').click(function(){
        alert('qwe');
});
</script>
