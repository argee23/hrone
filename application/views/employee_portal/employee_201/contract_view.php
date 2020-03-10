<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>CONTRACT</strong></div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>
    	 <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">


    	 <?php foreach($contract_view as $contract){ ?>

       <?php if($contract->isActive==0){$active='active';} else{ $active='closed contract';} ?>

    	 <div class="box-body">

        
       <div><label><?php echo $contract->employment_name; ?> (<?php echo $active; ?>)</label></div>

    	 <div class="col-md-12"><div class="box box-success"></div></div>
          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Date start</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($contract->start_date)); ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Date end</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($contract->end_date)); ?></label>
            </div>
            </div>
            </div>

            <?php if($contract->remark!=null){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Remark(s)</p>
            </div>
            <div class="col-sm-7">
            <div class="well">
              <p><?php echo $contract->remark; ?></p>
            </div>
            </div>
            </div>
            </div>
            <?php } ?>

            <?php if($contract->file!=null){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <a href="<?php echo base_url(); ?>app/employee_201_profile/download_contract/<?php echo $contract->file; ?>"
              type="button" class="btn btn-info btn-xs" title="Download File" ><i class="fa fa-download"></i> Download File</a>  
            </div>
            </div>
            <?php } ?>

          </div>
     
       </div><!-- /.box-body -->   
    
     <?php } ?>
            
      <?php if(count($contract_view)<=0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No Contract created yet.</strong></p>
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


