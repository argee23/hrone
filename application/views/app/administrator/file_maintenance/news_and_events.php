
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_news_and_events=$this->session->userdata('add_news_and_events');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="well">

	<div class="panel panel-danger">
		<div class="panel-heading">
			
		  <div class="form-group">
		    <label>News / Events</label><a onclick="addNewsAndEvents()" type="button"  class="<?php echo $add_news_and_events;?> btn btn-default btn-xs pull-right" title="Add">
      <?php
      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
      ?>    
      </a>
		  </div>
		  
		</div> <!-- panel heading close -->
    <div class="panel-body">
      <div class="row">
        <div class="col-md-3">
          <label>Filter by Company:</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="getNewsAndEvents(this.value)">
          <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
          <?php 
            foreach($companyList as $company){
            if($_POST['company'] == $company->company_id){
                $selected = "selected='selected'";
            }else{
                $selected = "";
            }
            ?>
            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
        </div>
        <div class="col-md-3">
          <label>Filter by Event Status:</label>
          <select class="form-control select2" name="status" id="status" style="width: 100%;" onchange="filterNewsAndEvents(this.value)">
            <option selected="selected" disabled="disabled" value="">- Select Status -</option>
            <option value="1"> All </option>
            <option value="2"> Completed </option>
            <option value="3"> Ongoing </option>
            <option value="4"> Upcoming </option>
          </select>
        </div>
        <div class="col-md-3">
          <label>Filter by Date Range:</label>
          <input type="text" name="daterange" class="form-control" id="daterange" />
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <hr>
       </div>
      </div>
      <table id="event" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Company Name</th>
                        <th>Event Title</th>
                        <th>Event Start </th>
                        <th>Event End</th>
                        <th>Status</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($nae as $nae){ ?>

                      <tr>
                        <td><?php echo $nae->company_name?></td>
                   
                        <td>
                          <a role="button" data-html="true" data-toggle="collapse" data-target="#info_<?php echo $nae->id?>"><?php echo $nae->event_title?></a>
                          <div id="info_<?php echo $nae->id?>" class="collapse">
                          <p class="text-success">
                          <?php echo nl2br($nae->event_description) ?>
                          </p>
                          </div>
                        </td>
                        <td><?php echo $nae->event_start?></td>
                        <td><?php echo $nae->event_end?></td>
               
                        
                        <td>
                        <?php 
                        if($nae->event_start && $nae->event_end < date('Y-m-d H:i:s')) { 
                          echo "<strong class='text-danger'>Completed</strong>";
                        } 
                        else if ($nae->event_start < date('Y-m-d H:i:s') && $nae->event_end > date('Y-m-d H:i:s')){
                          echo "<strong class='text-success'>Ongoing</strong>";
                        }
                        else{
                          echo "<strong class='text-info'>Upcoming</strong>";
                        } 
                        ?>
                        </td>

                        <td>

                        <?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $edit_news_and_events=$this->session->userdata('edit_news_and_events');
    $delete_news_and_events=$this->session->userdata('delete_news_and_events');
    $system_defined_icons = $this->general_model->system_defined_icons();
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
    
echo $edit = '<i class="'.$edit_news_and_events.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editNewsAndEvents('.$nae->id.')"></i>';

echo  $delete = anchor('app/file_maintenance/delete_news_and_events/'.$nae->id,'<i class="'.$delete_news_and_events.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$nae->event_title."?')"));

                        ?>

                        </td>
                      </tr>
                      <?php }?>
                     
                    </tbody>
    </table>
  </div> <!-- panel body close -->
	<div id="section"></div>
		
	</div>
</div>


<!-- Modal -->
<div id="myModal" class="modal-primary modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Event</h4>
      </div>
      <div class="modal-body">
      	<span id="content"> 
      		
      	</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="addModal" class="modal-warning modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Event</h4>
      </div>
      <div class="modal-body">
      	<span id="content2"> 
      		
      	</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

