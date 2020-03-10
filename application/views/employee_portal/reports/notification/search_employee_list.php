    <div class="alt2" dir="ltr" style="
    margin: 0px;
    padding: 0px;
    border: 0px solid #919b9c;
    width: 100%;
    height: 390px;
    text-align: left;
    overflow: auto">
<!--//======================  Start Employee List Content of Modal Container //-->    
    <table class="table">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($query as $row) {
        $recheck = $this->notification_approver_reports_model->checker_under_manager($row->division_id,$row->department,$row->section,$row->subsection,$row->location);
        $fullname = $row->first_name." ".$row->last_name;
        $employee_id = $row->employee_id;   
        // if($recheck==0){}else{   
    ?>
        <tr>
            <td><?php echo $row->employee_id;?></td>
            <td><?php echo $fullname;?></td>
            <td><a onclick="select_emp('<?php echo $employee_id; ?>','<?php echo $fullname ?>')"  title="Select this user" ><font color="#ffffff"><i class="fa fa-external-link fa-lg" aria-hidden="true" data-dismiss="modal"></i></font>
            </a></td>
        </tr> 
           <?php 
        //}
            }?>
    </tbody>
    </table>
    <!--//======================  End Employee List Content of Modal Container //-->  
</div>