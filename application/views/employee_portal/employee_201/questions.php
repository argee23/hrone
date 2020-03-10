<div class="col-md-7">
 <h2 class="page-header">Interview Questions</h2>

  <div class="box-body fixed-panel">
    <ol>

  <?php foreach ($info as $q)
  { ?>

	  <div class="form-group">
	  
	  <li><label><?php echo $q->question; ?></label></li>
	  	<?php if ($q->question_type == 'multiple_choice')
	  	{ 
	  	   foreach ($q->choices as $aChoice) { 

	  	   	if ($aChoice->selected == 1)
	  	   	{ ?>
	  	   			  			  <div class="checkbox">
	                <label>
	                  <input type="checkbox" checked disabled><?php echo $aChoice->mc_choice; ?>
	                </label>
	              </div>
	              <?php
	  	   	} else { ?>
	  	   		  			  <div class="checkbox">
	                <label>
	                  <input type="checkbox" disabled><?php echo $aChoice->mc_choice; ?>
	                </label>
	              </div>
	              <?php
	  	   	}
	  	   	?>
	  	<?php
	  	} ?>
		<?php }

		if ($q->question_type == 'hypothetical') { echo $q->answer; ?>

     
        <?php
		} ?>
	 
	
	  </div>


  <?php
  }?>
    </ol>
    </div>
</div>