<div class="datagrid">
    <table  cellpadding="1" cellspacing="3">
        <thead>
            <tr>      
            <th><img src="<?php echo base_url();?>/public/company_logo/<?php echo $company_logo;?>" class="img-rounded" id="company_logo" width="50" height="50"><?php echo $company_name;?>
            <span style="float: right;"><?php echo $pay_period_from." to ".$pay_period_to;?> <br><br> <?php echo $employee_id." ".$name;?></span>
            </th>
                
            </tr>
        </thead>
    </table>
</div>

<div class="datagrid">
<?php
//=========== PRINT PAYSLIP HEADER
$get_customized_headers=$this->Payroll_generate_13th_month_model->payslip_customized_headers($company_id);

if(!empty($get_customized_headers)){

        echo 
        '<table  cellpadding="1" cellspacing="3">
        <thead>
        <tr><th><span style="float: right;">';

    foreach($get_customized_headers as $my_payslip_header){
        $head_id=$my_payslip_header->id;
        if($head_id==13){
            $head_title="Classification";
            $head_value=$classification;
        }elseif($head_id==14){
            $head_title="Employment";
            $head_value=$employment;
        }elseif($head_id==15){
            $head_title="Department";
            $head_value=$dept;
        }elseif($head_id==16){
            $head_title="Section";
            $head_value=$section;
        }elseif($head_id==18){
            $head_title="Location";
            $head_value=$location;
        }elseif($head_id==19){
            $head_title="Position";
            $head_value=$position;
        }else{
            $head_title="Others";
            $head_value="Others";
        }
        echo ''.$head_title.' : '.$head_value.'<br><br>';
    }

        echo 
        '</span>    </th></tr>
        </thead>
        </table>';
}else{

}

?>
</div>
<div class="datagrid">
<table  cellpadding="1" cellspacing="3" >
    <thead>
            <th width="15%">Released Payroll Period</th>
            <th width="15%"><?php echo $pay_period_from." to ".$pay_period_to;?></th>
            <?php echo $division_status;?>
            <th width="15%">Employment</th>
            <th ><?php echo $employment;?></th>
        </tr>
        <tr>
            <th>Employee ID</th>
            <th><?php echo $employee_id;?></th>
            <th>Department</th>
            <th><?php echo $dept;?></th>
            <th>Classification</th>
            <th><?php echo $classification;?></th>

        </tr>
        <tr>
            <th>Name</th>
            <th><?php echo $name;?></th>
            <th>Section</th>
            <th><?php echo $section;?></th>
            <th>Pay Type</th>
            <th><?php echo $pay_type_name;?></th>
        </tr>
        <tr>
            <th>Position</th>
            <th><?php echo $position;?></th>
            <?php echo $subsection_status;?>
            <th>Location</th>
            <th><?php echo $location;?></th>
        </tr>
    </thead>
</table>
</div>