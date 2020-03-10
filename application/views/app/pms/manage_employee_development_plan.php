
<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Development plan

          
                  <!-- Trigger the modal with a button -->

</h4>

<!-- Modal -->

        
</h4></ol>


                  </div><!-- /.btn-toolbar/M11 -->
              </div>
<div class="panel panel-danger">
  <div class="panel-body">
  <div class="col-md-12">
    <br>
    <br> 
<form  role="form" id="creator_options">
  
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="form-group">
   
     <select class="form-control" id="select" name="id" onchange="get_selected_plan(this.value)" >
   <?php if($get_selected_plan->criteria_type =='1'){
   	?>
 <option value="1" selected="">1) per position</option>
 	  <option value="2">2) per position / department
	</option>
	 	 <option value="3"> 3) per position / department / section
</option>
 	<?php }elseif($get_selected_plan->criteria_type =='2'){?>
 		 <option value="1" >1) per position</option>
 		  <option value="2" selected="">2) per position / department</option>
 		  		 <option value="3"> 3) per position / department / section
	</option>
				<?php }elseif($get_selected_plan->criteria_type =='3'){?>
					 		  <option value="2">2) per position / department</option>
					 		 <option value="1" >1) per position</option>
 	 <option value="3" selected=""> 3) per position / department / section
</option>
	<?php } ?>


   </select>
 


    </div>
</div>
<div class="col-md-2"></div>

  </form>   
<br>
<br>


<hr style="border:2px solid #dd4b39;">
  
<div class="col-md-12" id="show">

 </div>
      </div>
  </div>
      </div>
      <?php  $w =  $this->pms_model->lock($this->uri->segment('4'));?> <input type="hidden" id="w" value="<?php echo $w->lock; ?>"> 


<script type="text/javascript">
if($('#w').val() == '1'){
  $(document).find("input,button,textarea,select").attr("disabled", "disabled");
  }
  get_selected_plan('<?php echo $get_selected_plan->criteria_type ?>','<?php  echo $this->uri->segment('4');  ?>');
</script>




