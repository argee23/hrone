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


#accordion{
     border-left: 4px solid #f38787;
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

</style>

<div class="col-md-12" style="background-color: white; padding: 40px;">
<div  style=" height: 55px;" id="e">    </div>
<hr>
 <form role="form" method="POST" id="form4" action="javascript:void(0)" onsubmit="save_evaluation();">
     <div class=" well" style="padding: 30px;" >
                <?php foreach($res1 as $res1){?>
            <div class="row" >
        <div class="span12">
            <div class="menu"  >
                <div class="accordion" id="accordion">
                    <!-- Áreas -->
                    <div class="accordion-group">
                        <!-- Área -->
                        <div class="accordion-heading area">

                            <a class="accordion-toggle" data-toggle="collapse" href=
                            "#admin<?php echo $res1->criteria_id ?>" style="font-size: 2.0rem;
            font-weight: 600; color:    #606060"><?php echo $res1->area ?>
                        
    </a>
            
                     
                        </div><!-- /Área -->
            
                        <div class="accordion-body collapse" id="admin<?php echo $res1->criteria_id; ?>">
                            <div class="accordion-inner">
                                <div class="accordion" id="equipamento1" style="color:#686868"> 
              <table class="table table-bordered" >
                <tbody>
                                                       <?php $res2= $this->pms_model->get_weight_and_description_portal($res1->criteria_id);
              foreach($res2 as $res2){?>
                <tr>
                                <td style="text-align: left; vertical-align: left; width:60%;"><?php echo $res2->description.'<br>';?></td>



           

     <td style="text-align: left; vertical-align: left;">
     <div class="col-lg-12 abc">

  <div class="star-rating" >

 <?php foreach($grading as $scale){?>
    <?php $q = $this->pms_model->get_score_creator_evaluation($doc_no,$res2->id,'employeeportal'); if($q){       

       
                           $c =  $q->score;
                           $e =  $q->score_equivalent;
                           
                    

    }else{
        $c = '';
        $e ='';
    }?>
    <span class="fa fa-star-o"  data-rating="<?php echo $scale->score ?>" style="color:#FF9529; padding: 10px;" data-id="<?php echo $scale->gid ?>" data-value="<?php  echo $scale->score_equivalent; ?>" > </span>



     <?php  }?> 
        <input type="hidden" name="qweqwe" class="rating-value" value="<?php  echo $c; ?>" >
          <input type="hidden" name="score[]" class="rating"  >
           <input type="hidden" name="refe" value="<?php echo $doc_no ?>"  >
           <input type="hidden" name="criteria_id[]" value="<?php echo $res2->id ?>"  >
              <input type="hidden" name="l" value="<?php echo $ref->eval_level ?>"  >

                     <input type="hidden" id="w" name="weight[]" value="<?php echo $res2->weight; ?>"  >
                <input type="hidden" name="f" value="<?php echo $id ?>"  >

                    <input type="hidden" name="employid" value="<?php  echo $employee ?>"  >
                            <input type="hidden" id="max" name="c" value="creator"  >
                     <input type="hidden" id="max" name="max" value="<?php echo $max; ?>"  >
      
         <span id="wqe"><?php echo $e; ?></span>
  </div>
 </div>

</td>
</tr>


                 <?php }?>
             </tbody>
                 </table>

                    
           </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /accordion -->
            </div> 
        </div>
    </div>
        <?php } ?>
    <button id='update_form' class="btn btn-primary btn-block pull-right">Save</button>

</div>   </form> 

           
            
          </div>

       
            <script type="text/javascript">
    $(document).ready(function(){
                $('.menu').hover(function(){
                $(this).toggleClass('classWithShadow');

            });
                      

        });
        function next_eval(){
        
            $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/next_eval') ?>",
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

   
   function ready_for_approval() {



     $.ajax({
       url: "<?php echo base_url();?>employee_portal/pms/approver_for/",
       method:"POST",
       data:$('#form4').serialize(),
       
   
       success:function()
       {
        
      window.location.replace("<?php echo base_url(); ?>employee_portal/pms/evaluation");       }
     })
   


  }
      function save_evaluation(){
        
            $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/save_evaluation') ?>",
                type: 'POST',
                 data: $('#form4').serialize(),
                
                success: function(data) {
                 //  if(e == 'true'){
            window.location = window.location;
               alert('Data is successfully saved');
                     
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
        
            $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/next_appro') ?>",
                type: 'POST',
                 data: $('#form4').serialize(),
                
                success: function(data) {
                 //  if(e == 'true'){
                            window.location.replace("<?php echo base_url(); ?>employee_portal/pms/approver");
                     
                           //  }else{ 
                //   $('#message').show();
                //   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                //   $('#myModal').modal('hide');
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
            
            }   

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

  // Clear all filled classes and add open class to all stars.
  $(this).children().not('#wqe').removeClass('fa-star').addClass('fa-star-o');
  // While the i var is less than the total rating value, use eq(i) to add 
  // the filled class to the star
  for(var i = 0; i < ratingVal; i ++)
   $(this).children().eq(i).removeClass('fa-star-o').addClass('fa-star');  
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
 e = $('#max').val();
 if(e < 1){
 $('#e').html('<button onclick="next_eval()" class="btn btn-danger pull-right">Recommend for the next evaluation</button>');
}else{
 $('#e').html('<button onclick="ready_for_approval()" class="btn btn-danger pull-right">Ready for approval</button>');
 }

$(document).ready(function() {
SetRatingStar();
});
       
        //initial setup
 
        
    </script>
</script>


