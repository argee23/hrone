 <?php 
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $del_sect_mngr=$this->session->userdata('del_sect_mngr');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
 <table id="delete_list" class="col-md-12 table table-hover table-striped">
                 <thead>
                  <tr>
                    <th>Company ID</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Subsection</th>
                    <th>Location</th>
                    <th>Manager</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($sectionmgrsDel as $row) {?>
                  <tr>
                      <td><a aria-hidden='true' data-toggle='tooltip' title='<?php echo $row->company_name?>' style='color:black;'><?php echo $row->company_id?></a></td>
                      <td><?php echo $row->division_name?></td>
                      <td><?php echo $row->dept_name?></td>
                      <td><?php echo $row->section_name?></td>
                      <td><?php echo $row->subsection_name?></td>
                      <td><?php echo $row->location_name?></td>
                      <td><?php echo $row->first_name." ".$row->last_name?></td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>
       <div class="col-md-12" style="padding-top: 30px;">
<?php
   if($del_sect_mngr=="hidden "){
?>
<button class='col-md-2 btn btn-success pull-right' disabled title='Not Allowed. Check your Access Rights.' onclick='delete_selected_company("<?php echo $id?>");'>Delete All</button>
<?php
   }else{
?>
<button class='col-md-2 btn btn-success pull-right' onclick='delete_selected_company("<?php echo $id?>");'>Delete All</button>
<?php
   }
?>
        


      </div>