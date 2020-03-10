     <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php foreach($out as $out){
              if(!empty($out->dept_name)){echo $out->dept_name.'<br>';
            }
              elseif(!empty($out->section_name)){ echo $out->section_name.'<br>';
              }
               elseif(!empty($out->classification)){echo $out->classification.'<br>';
              } 
              elseif(!empty($out->location_name)){echo $out->location_name.'<br>';
              }
             
        } ?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
   
      </div>
    </div>