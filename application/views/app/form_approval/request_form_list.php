  
 
    <div class="col-md-12"><br>
        <div style="height:50px;" id='add_edit'>
          <div class="col-md-12">
                <div class='col-md-8'>
                         <div class="col-md-3"><label><u>Form Name:</u></label></div>
                          <div class="col-md-9"  id='r_option'> <input type='text' class='form-control'  id='request_form_list'>
                          <input type="hidden" id="form_title">
                          </div>
                </div>
          <div class='col-md-2'><button class='btn btn-success' onclick="save_request_form_list();">SAVE</button></div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
  <div style="padding-top: 20px;">
          <table id="request_list" class="col-md-1 table table-hover table-striped">
                <thead class=''>
                  <tr  class="success">
                    <th>ID</th>
                    <th>Request Form</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($request_form as $re) { ?>
                 <tr>
                    <td><?php echo $re->id?></td>
                    <td><?php echo $re->title?></td>
                   <?php if($re->InActive==0){  echo " <td class='text-success'> Active </td>"; } else{ echo "<td  class='text-danger'>InActive</td>"; }?>
                    <td>
                    <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='deleterform(<?php echo $re->id?>)'></a>
                    <a class='fa fa-pencil' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='editrform(<?php echo $re->id?>)'></a>
                    <a class='fa fa-power-off' <?php if($re->InActive==0){ echo "stye='color:green';"; } else{  echo "style='color:red';";}?>aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='statusrform(<?php echo $re->id?>,<?php echo $re->InActive?>)'></a>
                    </td>
                 </tr>
                <?php } ?>
                </tbody>
       </table>
 </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
    

          

