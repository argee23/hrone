<style type="text/css">.radio {
    padding-left: 20px; }
.radio label {
    display: inline-block;
    position: relative;
    padding-left: 5px; }
.radio label::before {
    content: "";
    display: inline-block;
    position: absolute;
    width: 17px;
    height: 17px;
    left: 0;
    margin-left: -20px;
    border: 1px solid #cccccc;
    border-radius: 50%;
    background-color: #fff;
    -webkit-transition: border 0.15s ease-in-out;
    -o-transition: border 0.15s ease-in-out;
    transition: border 0.15s ease-in-out; }
.radio label::after {
    display: inline-block;
    position: absolute;
    content: " ";
    width: 11px;
    height: 11px;
    left: 3px;
    top: 3px;
    margin-left: -20px;
    border-radius: 50%;
    background-color: #555555;
    -webkit-transform: scale(0, 0);
    -ms-transform: scale(0, 0);
    -o-transform: scale(0, 0);
    transform: scale(0, 0);
    -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
    -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
    -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
    transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33); }
.radio input[type="radio"] {
    opacity: 0; }
.radio input[type="radio"]:focus + label::before {
    outline: thin dotted;
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px; }
.radio input[type="radio"]:checked + label::after {
    -webkit-transform: scale(1, 1);
    -ms-transform: scale(1, 1);
    -o-transform: scale(1, 1);
    transform: scale(1, 1); }
.radio input[type="radio"]:disabled + label {
    opacity: 0.65; }
.radio input[type="radio"]:disabled + label::before {
    cursor: not-allowed; }
.radio.radio-inline {
    margin-top: 0; }

.radio-primary input[type="radio"] + label::after {
    background-color: #004a91; }
.radio-primary input[type="radio"]:checked + label::before {
    border-color: #004a91; }
.radio-primary input[type="radio"]:checked + label::after {
    background-color: #004a91; }</style>


<div class="panel panel-success">
  <div class="panel-body">
	<div class="col-md-12">
		<br>
		<br>

    <br>
     <?php $form_location   = base_url()."app/pms/save_eval_appro_score/".$this->uri->segment('4')  ;?>
<form id="creator_optionsq" method="post" class="form-inline" action="<?php echo $form_location;?>">

 <div class="row">

<div class="col-md-12  ">
    <div class="form-group">
   <label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number of Evaluator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
   <input type="number" name="evaluator" class="form-control" min="0" value="<?php if(!empty($settings->evaluator)){ echo $settings->evaluator;  } ?>">
  



    </div>
</div>	




    
<br>
<br>
</div> 
<br>
 <div class="row">

<div class="col-md-12  ">
    <div class="form-group">

  


    <input type="hidden" name="creator" value="1" min="0" >
     <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number of Approver&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
   <input type="number" name="approver"  min="0" class="form-control" value="<?php if(!empty($settings->approver)){ echo $settings->approver;  } ?>">


    </div>
</div>




    
<br>
<br>
</div> 

<br>
 <div class="row">

<div class="col-md-12">
   <div class="radio radio-primary">
                <input type="radio" name="radio1" id="otp" value="1" data-value="otp" class="radio_val" <?php if(!empty($computations->computation_type) AND $computations->computation_type=='1'){ echo 'checked'; } ?>>
                Computation of Final score&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp; &nbsp;
                <label for="otp">
                <div class="panel-body">
                        <div class="label label-success">get average</div>
                    </div>
                </label>

    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;  &nbsp;
                   <input type="radio" name="radio1" id="otp5" value="2" data-value="otp5" class="radio_val5" <?php if(!empty($computations->computation_type) AND $computations->computation_type=='2'){ echo 'checked'; } ?>>
                <label for="otp5">
                <div class="panel-body">
                        <div class="label label-success">last evaluator</div>
                    </div>
                 
                </label>  



                <br><br><br>
            <input type="radio" name="radio_self" id="weqwe" value="1" data-value="234534" class="radio_val1" <?php if(!empty($self_eval) AND $self_eval->self_eval=='1'){ echo 'checked'; } ?>>
             Evaluation type:&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp; &nbsp; &nbsp;  &nbsp;   &nbsp;    &nbsp;    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <label for="weqwe">
                <div class="panel-body">
                        <div class="label label-success">self evaluation</div>
                    </div>
                </label>

    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;
                   <input type="radio" name="radio_self" id="wqe" value="0" data-value="2345" class="radio_val4" <?php if(!empty($self_eval) AND $self_eval->self_eval=='0'){ echo 'checked'; } ?>>
                <label for="wqe">
                <div class="panel-body">
                        <div class="label label-success">no self evaluation</div>
                    </div>
                 
                </label>
            </div>


<br>

<br>
<br>
<br>

    
  <center><input type="submit" name="submit" class="btn btn-primary"  onclick="save_eval_appro_score('<?php echo $this->uri->segment('4')  ?>')"  value="Save"></center>
</form>

</div>


</div>

 





<?php  $w =  $this->pms_model->lock($this->uri->segment('4'));?> <input type="hidden" id="w" value="<?php if(!empty($w->lock)){ echo $w->lock; } ?>"> 
</div>
  </form>  



  <script type="text/javascript">



         function unlck(id){
                  $.ajax({
              url: "<?php echo base_url();?>app/pms/save_lock_un/"+id+"",
              type: 'POST',
              data: $('#creator_options').serialize(),
              success: function(e) {
                
               $('#message').show();
               $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully!</div>").fadeOut(10000);
         

               
               
               
             }
           });
     }
             
                    if($('#w').val() == '1'){
  $(document).find("input,button,textarea,select").not('.noted').attr("disabled", "disabled");
  }

  </script> 




