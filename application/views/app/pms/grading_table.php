

<ol class="breadcrumb">
<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Form Management

          
                  <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add New</button>
</h4>

<!-- Modal -->
<div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-small">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
     <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_grading_table/";?>     
<form onsubmit="save_grading_table()" role="form"  id="form" method="post"  action="<?php echo $form_location;?>">
      <div class="modal-body">
      

<div class="form-group">
            <label for="recipient-name">Grading Type:</label>
    
                <div class="input-group">
      <span class="input-group-addon">
        <input  type="radio" value="1" aria-label="..." name="grading_type">
      </span>
      <input type="text" class="form-control" aria-label="..." disabled="" value="numbers">
    </div><!-- /input-group -->
              <div class="input-group">
      <span class="input-group-addon">
        <input name="grading_type" type="radio" aria-label="..." value="2">
      </span>
      <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
    </div><!-- /input-group -->
          </div>
          <div class="form-group">
            <label for="message-text">Score:</label>
            <div class="input-group">
            <input required="" name="score_name" type="number" class="form-control" id="recipient-name">
            <span class="input-group-addon">%</span>
              </div>
          </div><input type="hidden" name="company_" value="<?php  echo $this->uri->segment('4');  ?>">
           <div class="form-group">
            <label for="message-text">Ranking:</label>
            <input required name="ranking" type="number" class="form-control" id="recipient-name">
          </div>
           <div class="form-group">
            <label for="message-text">Score equivalent:</label>
            <input required name="equivalent" type="text" class="form-control" id="recipient-name">
          </div> 
          <div class="form-group">
                <label for="message">Score guide</label>
            
                <textarea class="form-control" name="scoring_guide" id="scoring_guide" required></textarea>
      
            </div>

      
   

</div>
     
      <div class="modal-footer">
      	 <hr class="prettyline">

            <input type="submit" class=" btn btn-primary" value="submit" onclick="save_grading_table()" >
   	       <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
           
     </div>
 </form>
  </div>
</div>
               
</h4></ol>


                  </div><!-- /.btn-toolbar/M11 -->
              </div>
          

		

		 <div class="table-responsive">
        <table id="grading_table" class="table table-striped">
          <thead>
            <tr class="table-info">
         
              <th>grading type</th>
              <th>ranking </th>
              <th>score</th>
              <th>score equivalent</th>
              <th>scoring guide</th>
              <th>action </th>
            </tr>
          </thead>
          <tbody>
            <?php   $tableid = 1; foreach($grading_table as $grading_table){?>
              <tr class="table-success">
            
              <td onclick="EditMyText('grading_type', '<?php echo $grading_table->grading_type ?>', <?php echo $tableid?>);" id="grading_type_<?php echo $tableid ?>"><?php echo $grading_table->grading_information ?></td>
              <td onclick="EditMyText('ranking', '<?php echo $grading_table->ranking ?>', <?php echo  $tableid?>);" id="ranking_<?php echo $tableid ?>"><?php echo $grading_table->ranking ?></td>
              <td onclick="EditMyText('score', '<?php echo $grading_table->score ?>', <?php echo $tableid;?>);" id="score_<?php  echo $tableid ?>"><?php echo $grading_table->score ?>%</td>
              <td onclick="EditMyText('score_equivalent', '<?php echo $grading_table->score_equivalent ?>', <?php echo $tableid;?>);" id="score_equivalent_<?php echo $tableid ?>"><?php echo $grading_table->score_equivalent ?></td>
              <td  onclick="EditMyText('scoring_guide', '<?php echo $grading_table->scoring_guide ?>', <?php echo $tableid?>);" id="scoring_guide_<?php echo $tableid ?>"><?php echo $grading_table->scoring_guide ?></td>
              <td id="<?php echo $tableid; ?>"><a onclick="view_update_grading_table(<?php echo $grading_table->gid ?>);"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"  style="color: green;"></i></a>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="delete" data-id ="<?php echo $grading_table->gid; ?>"><i class="fa fa-trash fa-lg" aria-hidden="true"  style="color: red;"></i></a>
           
              </td>
            </tr>
              <?php $tableid++; } ?>
          </tbody>
        </table>
     </div>
