

<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Scorecard Creators

          
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
   
     <select class="form-control" id="select" name="id" onchange="get_selected_scorer(this.value)" >
        <?php if ($row->creators_type != ''){?>
        <option selected="" value="<?php echo $row->id; ?>"> <?php echo $row->creators_type; ?>  </option>
      <?php }else{ ?>
        <option selected=""> select creators </option>
      <?php  } ?>
        <?php foreach($sdefault as $e){?> 
        <?php if($row->id != $e->id){ ?>
        <option value="<?php echo $e->id ?>">                                 
          <?php  echo $e->creators_type ?>

      </option>

          <?php } ?>
        <?php  } ?>


   </select>
 


    </div>
</div>
<div class="col-md-2"></div>

  </form>   
<br>
<br>


<hr style="border:2px solid #dd4b39;">
  
<div class="col-md-12" id="show">
<center><div class="loader"></div></center>
 </div>
      </div>
  </div>
      </div>


<script type="text/javascript">

  get_selected_scorer('<?php echo $get_selected_scoree->creators_type ?>');

</script>



