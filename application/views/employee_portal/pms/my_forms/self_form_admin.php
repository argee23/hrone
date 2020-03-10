<link href="<?php echo base_url()?>public/plugins/tost/toastr.css" rel="stylesheet"/>
<script src="<?php echo base_url()?>public/plugins/tost/toastr.js"></script>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
    .menu .accordion-heading {  position: relative; }
.menu .accordion-heading .edit {
    position: absolute;
    top: 8px;
    right: 30px; 
}
.container{
    border-bottom:none;
}



.menu .collapse.in { overflow: visible; }


.accordion{margin-bottom:20px;}
.accordion-group{margin-bottom:2px;border:1px solid #e5e5e5;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.accordion-heading{border-bottom:0;}
.accordion-heading .accordion-toggle{display:block;padding:15px 15px;}
.accordion-toggle{cursor:pointer;}
.accordion-inner{padding:9px 15px;border-top:1px solid #e5e5e5;}


a:hover, a:focus{
    text-decoration: none;
    outline: none;
}
#accordion .panel{
    border: none;
    box-shadow: none;
    border-radius: 0;
    margin-bottom: 15px;
}
#accordion .panel-heading{
    padding: 0;
    border-radius:0;
    border: none;
}
#accordion .panel-title a{
    display: block;
    padding: 14px 30px 14px 70px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background: #ef6145;
    position: relative;
    overflow: hidden;
    transition: all 0.5s ease 0s;
}
#accordion .panel-title a.collapsed{
    background: #f8f8f8;
    color: #1e4276;
}

#accordion .panel-title a.collapsed:hover{
    color: #ef6145;
}
#accordion .panel-title a:before{
    content: "";
    width: 55px;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.1);
    position: absolute;
    top: 0;
    left: -13px;
    transform: skewX(-25deg);
    transition: all 0.5s ease 0s;
}
#accordion .panel-title a.collapsed:hover:before{
    background: #d7573e;
}
#accordion .panel-title a:after{
    content: "\f047";
    font-family: FontAwesome;
    position: absolute;
    left: 10px;
    top: 50%;
    color: #fff;
    transform: translateY(-50%);
}
#accordion .panel-title a.collapsed:after{
    color: #9f9f9f;
}
#accordion .panel-title a.collapsed:hover:after{
    color: #fff;
}
#accordion .panel-body{
    font-size: 14px;
    color: #5a3245;
    line-height: 25px;
    padding: 20px 15px 20px 40px;
    position: relative;
    border: none;
    transition: all 0.5s ease 0s;
}
#accordion .panel-body:before{
    content: "";
    width: 5px;
    height: 40px;
    background: #ef6145;
    position: absolute;
    top: 30px;
    left: 0;
}
#accordion .panel-body p{
    margin-bottom: 0;
}.classWithShadow{
   -moz-box-shadow: 3px 3px 4px #000; 
   -webkit-box-shadow: 3px 3px 4px #000; 
 box-shadow: 0 0 15px rgba(33,33,33,.2); 

}
label {
  display: block;
  padding-left: 15px;
  text-indent: -15px;
}
input {
  width: 13px;
  height: 13px;
  padding: 0;
  margin:0;
  vertical-align: bottom;
  position: relative;
  top: -3px;
  *overflow: hidden;
}

</style>


       <p id="message"></p>
            <div class="panel panel-default">   
              <div style="background-color:#00a65a; height: 4px;"  >
      
   </div>
    


              <div class="panel-body">
                 <h4>2019 PERFORMANCE REVIEW  <span class="glyphicon glyphicon-question-sign fa-lg" data-toggle="popover" title="Instruction" data-content="<?php echo $instruction->form_instruction; ?>"></span></h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <Strong>DUE</Strong>:<?php echo date_format(date_create($get_date->appraisal_period_type_dates),'d-M-Y') ?> | EVALUATION PERIOD: <?php echo $get_date->coverage ?> | EVALUATED BY: John Smith
                  <hr>
                  <h5>RATING DEFINITIONS</h5>
                 <div class="star-rating" >

  </div>
                  <table>
                    <?php foreach($grading_order as $w){ ?>
                      <tr>
                      <td> 
                   
                         <span id="wqe"></span>
                         <input type="hidden" name="e" class="rating-value1" value="<?php echo $w->score ?>" >
                       </td>
                       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php  echo $w->score_equivalent; ?>   </b> <i>   &nbsp;&nbsp;<?php echo $w->scoring_guide ?></i><br><br></td>
                     </tr>
                        
                   <?php } ?>
                   </table>
                   </div></div>


<div class="col-md-12" style="background-color: white; padding: 40px;">



<hr>  
<h4>COMPETENCIES</h4>
 <form role="form" method="POST" id="form4" action="javascript:void(0)" onsubmit="save_evaluation();">
      <input type="hidden" name="eid" value="<?php echo $employee; ?>">
             <div class=" well" style="padding: 30px;" >
 <?php foreach($res1->result() as $res1){?>
      <div class="row"  >
          <div class="span12" >
            <div class="menu">
                <div class="accordion" id="<?php echo $res1->criteria_id ?>" style="background-color: white;">
                    <!-- Áreas -->
                    <div class="accordion-group">
                        <!-- Área -->
                        <div class="accordion-heading area">

                            <a class="accordion-toggle" data-toggle="collapse" href=
                                 "#admin<?php echo $res1->criteria_id ?>" style="      font-size: 2.0rem;
                                  font-weight: 600; color:    #606060"><?php echo $res1->area; ?>
                                 <small style="font-size:14px;"><i id="icon<?php echo $res1->criteria_id ?>" class="pull-right"></i></small>
                            </a>

  
                        </div>
            
                        <div class="accordion-body collapse in" id="admin<?php echo $res1->criteria_id; ?>">
                            <div class="accordion-inner">
                               <div id="equipamento1" style="color:#686868" > 
 
                                  <table class="table table-bordered" >
                                          <tbody> 
                                                <?php $res2= $this->pms_model->get_weight_and_description_admin($res1->cid,$res1->doc_no);
                                                foreach($res2 as $res2){?>
                                                  <tr><td style="text-align: left; vertical-align: left; width:60%;"><?php echo $res2->description.'<br>';?></td>
                                               <td><b>measurement:</b> <?php echo $res1->measurement.'%<br>';?></td>
                                                    <td><b>Weight:</b> <?php echo $res2->weight.'%<br>';?></td>

                                                               <td><b>target:</b> <?php echo $res1->target.'%<br>';?></td>
                                                      <td style="text-align: left; vertical-align: left;">
                                          <div class="col-lg-12 abc">
                                   
                                              <div class="star-rating" >

                                                  <?php $q = $this->pms_model->get_score_admin_evaluation($doc_no,$res2->id,'admin',$grading_type); if($q){       
                                                  foreach($q as $q){
                                                       
                                                       
                                                                       $c =  $q->score;
                                                                       $e =  $q->score_equivalent;
                                                                       
                                                       }

                                                   }else{
                                                    $c ='';
                                                    $e ='';
                                                    }?>
                                                
                                                <select class="form-control" name="score[]">
                                                  <?php if($grading_type == 2){ ?>
                                                                         
                                                                   <option selected="" value="<?php echo $c; ?>"> <?php if(!empty($q->score)){echo 'Level '.$q->ranking.'-'; echo $q->score_equivalent;echo ' ('.$q->score.')';  } ?></option>
     <?php foreach($grading as $scale){ 
                                                    if($scale->score != $c){?>
                                                   <option value="<?php echo $scale->ranking ?>"><?php echo  'Level '.$scale->ranking  ?> - <?php echo  $scale->score_equivalent ; echo '('.$scale->score.')'; ?>  </option>
             <?php } }
                                                }else{?>

                                                          <option selected="" value="<?php echo $c; ?>"> <?php if(!empty($q->score)){echo $q->score.' '; echo $q->score_equivalent; } ?></option>
                                                  <?php foreach($grading as $scale){ 
                                                    if($scale->score != $c){?>
                                                   <option value="<?php echo $scale->score ?>"><?php echo  $scale->score  ?> - <?php echo  $scale->score_equivalent  ?>  </option>
                                                  <?php } }}?> 
                                                   
                                          
                                              </select>


                                                 <input type="hidden" name="eval"  value="<?php if(!empty($eval->eval_level)){echo $eval->eval_level; }?>" >
                                                 <input type="hidden" name="qweqwe" data-id="<?php echo $res1->criteria_id ?>" class="rating-value" value="<?php  echo $c; ?>" >
                                            <!--     <input type="text" name="score[]" class="rating" value="<?php echo $c; ?>" > -->
                                            <input type="hidden" name="max_id" class="form-control" id="max_id" value="<?php echo $max_id->eval_level ?>"  >
                                               <input type="hidden" name="refe" id="idko" value="<?php echo $doc_no ?>"  >
                                                   <input type="hidden" id="w" name="weight[]" value="<?php echo $res2->weight; ?>"  >
                                                    <input type="hidden" name="criteria_id[]" value="<?php echo $res2->id ?>"  >
                                                          
                                                <input type="hidden" name="max_id" class="form-control" id="max_id" value="<?php echo $max_id->eval_level ?>"  >
                                                            <input type="hidden" name="f" value="<?php echo $fid ?>"  >
                                                            <input type="hidden" name="c" value="admin"  >
                                                              <input type="hidden" name="employid" class="form-control" value="<?php  echo $employee ?>"  >
                                                              <input type="hidden" id="max" name="max" value="<?php echo $max; ?>"  >
                                                              <input class="form-control" type="text" name="appraisal_date" value="<?php echo $get_date->appraisal_period_type_dates ?>" ?>

                   
                                              </div>
                                   </div>

                                  </td>
                                  </tr>


                                                   <?php }?>
                                                          <?php $e = $this->pms_model->qweqwewqe($doc_no,$res2->id,'admin'); if($e){     ?>
                                                <?php foreach($e as $e) {?>
         <tr>               

                                                 
                                              <?php
                                                  if($e->employee_id==$this->session->userdata('employee_id')){?>
                                                                
                                                                
                                                  <?php }else{?>
                                           
                                            
                                                <td><?php        echo '<strong>Evaluator level :</strong>'.$e->eval_level.'<br>'; ?></td><td> <?php echo '<strong>Name :</strong>'.$e->fullname.'<br>';?></td><td><?php   echo '<strong>score :</strong>'.$e->score; ?></td>
                                      
                                                <?php  }?></tr><?php }} ?>

                                               </tbody>
                                                   </table>
                  Comments
                  <textarea class="form-control" style="height: 90px;"></textarea>
           </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /accordion -->
            </div> 
        </div>
    </div>
        <?php } ?>



           
        
            </div>

         <button id='update_form' class="btn btn-primary btn-block pull-right">Save</button>  
      
      </form>  
</div>


          </div>

       
            <script type="text/javascript">
  

    function save_evaluation(){
                     
            $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/save_evaluation') ?>",
                type: 'POST',
                 data: $('#form4').serialize(),
                
                success: function(data) {
                 //  if(e == 'true'){
                  
                     
                           //  }else{ 
               window.location = window.location;
               alert('Data is successfully saved');
               
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
            
            }

    function reject($doc_no){
var person = prompt("Comments for Reason/Suggestion");

if (person == null || person == "") {
  txt = "User cancelled the prompt.";
} else {
  txt = "Hello " + person + "! How are you today?";
}


          // $.ajax({ 
          //       url: "<?php echo base_url('employee_portal/pms/reject_eval') ?>/"+$doc_no,
          //       type: 'POST',
          //        data: $('#form4').serialize(),
                
          //       success: function(data) {
          //        //  if(e == 'true'){
                  
                     
          //                  //  }else{ 
               
          //         $('#message').show();
          //         $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Data is successfully rejected</div>").fadeOut(10000);
               
                  
          //       //   manage_general_form();                
          //       // }
                
                
                
          //     }

          //   });

    }
    


    function next_appro(){
        
            $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/next_appro') ?>",
                type: 'POST',
                 data: $('#form4').serialize(),
                
                success: function(data) {
                 //  if(e == 'true'){
                   window.location.replace("<?php echo base_url(); ?>employee_portal/pms/evaluation");
                     
                           //  }else{ 
                //   $('#message').show();
                //   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                //   $('#myModal').modal('hide');
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
            
            }   

    $(document).ready(function(){
                $('.menu').hover(function(){
                $(this).toggleClass('classWithShadow');

            });
                      

        });

    // Set the variable to the star container.
// Set the variable to the star container.
var $star_rating = $('.star-rating');

// This runs the setStars function below for each and every rating instance.
var SetRatingStar = function() {  
  $star_rating.each(setStars);
};




function setStars() {
  // We use $(this) to only run the code for the calling instance of 
  // $('.star-rating') rather than all

  // Use a var to store the current rating value.
  var ratingVal = parseInt( $(this).find('input.rating-value').val());
    var ratingVal1 = parseInt( $(this).find('input.rating-value1').val());

  // Clear all filled classes and add open class to all stars.
  $(this).children().not('#wqe').removeClass('fa-star').addClass('fa-star-o');
  // While the i var is less than the total rating value, use eq(i) to add 
  // the filled class to the star
  for(var i = 0; i < ratingVal; i ++){

   $(this).children().eq(i).removeClass('fa-star-o').addClass('fa-star');  
  }
  for(var i = 0; i < ratingVal1; i ++){
      alert(ratingVal1)
   $(this).children().eq(i).removeClass('fa-star-o').addClass('fa-star'); 
  }
}


$star_rating.on('click', '.fa', function() {  
        $(this).siblings('input.rating-value').val($(this).index() + 1);
               s = $(this).attr('data-value');
                q = $(this).attr('data-rating');
        $(this).siblings('#wqe').html(s);
        $(this).siblings('.rating').val(q);
 
    


        // Calls setStars function with $(this) value set to the parent container.
        setStars.call($(this).parent());
    });


$(document).ready(function() {
  $('.rating-value').each(function(i, obj) {
          if($(this).val() != ""){
              id = $(this).attr('data-id');
              $('#'+id).css('border-left','10px solid #3cb371')
              $('#icon'+id).text('saved');
          }else if($(this).val() ==''){
              id = $(this).attr('data-id');
              $('#'+id).css('border-left','10px solid #f38787')
      $('#icon'+id).text('pending');
          }
});
SetRatingStar();
});
       



$(function () {
  $('[data-toggle="popover"]').popover();
  $('body').on('click', function (e) {
    //only buttons
 $('html').on('click', function(e) {
  if (typeof $(e.target).data('original-title') == 'undefined') {
    $('[data-original-title]').popover('hide');
  }
});
});
});
</script>


