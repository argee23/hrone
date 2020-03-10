
<div class="alt2" dir="ltr" style="
                                            margin: 0px;
                                            padding: 0px;
                                            border: 0px solid #919b9c;
                                            width: 100%;
                                            height: 390px;
                                            text-align: left;
                                            overflow: auto">

<!--//======================  Employee List Content of Modal Container //-->    
<table class="table">
<thead>
    <tr>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>&nbsp;</th>
    </tr>
</thead>
<tbody>
    <?php foreach($showEmployeeList as $showEmployeeList){?>
    <tr>
        <td><?php echo $showEmployeeList->employee_id?></td>
        <td><?php echo $showEmployeeList->name?></td>
        <td><?php echo $showEmployeeList->dept_name?></td>
        <td>   
        <?php //echo $showEmployeeList->company_id.",".$showEmployeeList->pay_type.",".$showEmployeeList->payroll_period_group_id;?>
            <a onclick="select_emp(<?php echo $showEmployeeList->employee_id ?>);"  title="Select this user" ><font color="#ffffff"><i class="fa fa-external-link fa-lg" aria-hidden="true" data-dismiss="modal"></i></font>
            </a>
   <!--          <a onclick="select_emp(<?php //echo $showEmployeeList->employee_id ?>);fetch_payroll_period_individual( <?php //echo $showEmployeeList->company_id.",".$showEmployeeList->pay_type.",".$showEmployeeList->payroll_period_group_id;?>);"  title="Select this user" ><font color="#ffffff"><i class="fa fa-external-link fa-lg" aria-hidden="true" data-dismiss="modal"></i></font>
            </a> -->

        </td>
    </tr>
    <?php }?>
</tbody>
</table>

</div>