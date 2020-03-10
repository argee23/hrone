
<br><br>

    



<div class="container">
    
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i>Company List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <?php $form_location   = base_url()."employee_portal/pms/approvers/";?>
    <form id="form5" method="post" action="<?php echo $form_location;?>">
             <select name="company">
              <?php 
              foreach($c as $c){?>
      
               <option value="<?php echo $c->company_id ?>"><?php   echo $c->company_name; ?></option>
      

              <?php }

               ?>
                      </select>   
          <input type="submit" name="submit" value="submit">
        </form>
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
function dependents_modal(doc_no,name,classification,position,dept,l,ref,employee_id,appro_level){

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
              data: {doc_no:doc_no,name:name,position:position,classification:classification,employee_id,employee_id,department:dept},
                
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

     function next_appro(){
                
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
                 data: {appro_level:appro_level,doc_no:doc_no,form_title_array:form_title_array,score_array:score_array,weight_array:weight_array,total_array:total_array,c_score_array:c_score_array,rate_array:rate_array,c_cid_array:c_cid_array,c_employee_id:c_employee_id,c_form_part:c_form_part,score_equivalent:score_equivalent,score_total:score_total},
                
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
