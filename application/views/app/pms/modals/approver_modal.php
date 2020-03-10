     <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
   
  
      <div class="modal-body">
        <table class="table table-bordered">
  <tr>
    <th>Department</th>
    <th>Section</th>
    <th>Classification</th>
     <th>Location</th>
     <th>Approver Level</th>
  </tr>
   <?php foreach($out->result() as $out){  ?>
  <tr>
    
              <td><?php if(!empty($out->dept_name)){echo $out->dept_name.'<br>'; }else{ echo 'all';  }?></td>
            
            <td><?php   if(!empty($out->section_name)){ echo $out->section_name.'<br>';         }else{ echo 'all';  }?></td>
       
              <td><?php  if((!is_numeric($out->classification))){echo $out->classification.'<br>';   }else{ echo 'all'; } ?> </td>
            
            <td><?php  if(!empty($out->location_name)){ echo $out->location_name.'<br>';       }else{ echo 'all';  }?></td>
            <td><?php  if(!empty($out->approval_level)){ echo $out->approval_level.'<br>';       }else{ echo 'all';  }?></td>
        
             
        
  </tr>
 <?php  } ?> 
</table>
     <br>
     Note: <small>Viewing of Multiple dept,section,classification,location only</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
   
      </div>
    </div>