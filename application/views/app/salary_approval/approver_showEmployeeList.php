
<div class="alt2" dir="ltr" style=" margin: 0px; padding: 0px;border: 0px solid #919b9c;width: 100%; height: 390px;text-align: left;overflow: auto">
        <table class="table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($addnew_showSearchResult as $showEmployeeList){?>
            <tr>
                <td><?php echo $showEmployeeList->employee_id?></td>
                <td><?php echo $showEmployeeList->name?></td>
                <td><?php echo $showEmployeeList->company_name?></td>
                <td>   
                <a onclick="select_emp_addapprover('<?php echo $showEmployeeList->employee_id ?>','<?php echo $showEmployeeList->name?>','<?php echo $showEmployeeList->position ?>')"  title="Select this user" ><font color="#ffffff"><i class="fa fa-external-link fa-lg" aria-hidden="true" data-dismiss="modal"></i></font>
                    </a>
                </td>
            </tr>
            <?php }?>
        </tbody>
        </table>
</div>