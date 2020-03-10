<div id="coll_2">
<div class="col-md-12" style="padding-top: 20px;">
  <div class="col-md-3" style="padding-bottom: 50px;">
      <div class="panel panel-info">
      <h4 class="text-danger" style="font-weight: bold;"><center>Filter Group/s List</center></h4><hr>
            <div class="col-md-12" style="height:300px;">
            <n>Select Company</n>   
            <select class="form-control" style="border-color:brown;" id="company_f">
                 <option value="">Select</option>
                      <?php foreach($companyList as $company){ ?>
                          <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                      <?php }?>
            </select><hr>
              <n>Select Policy Type</n>   
            <select class="form-control" style="border-color:brown;" onchange="getGroupList(this.value);" id="policy_t">
                  <option>Select</option>
                 <option value="All">All</option>
                      <?php foreach($policy_type as $policy){ ?>
                          <option value="<?php echo $policy->param_id?>"><?php echo $policy->cValue?></option>
                      <?php }?>
            </select><hr>
            <n>Group Name</n>   
            <select class="form-control" style="border-color:brown;" id="group_list_company" onchange="policy_group_details(this.value);"></select>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>


  <div class="col-md-9" style="padding-bottom: 50px;"  id="fetch_all_result"> 
      <div class="panel panel-info">
            <br>
              <a class='btn btn-info btn-xs pull-right'  style="margin-right: 5px;"  onclick="atro_home();">Home</a> 
              <a class='btn btn-success btn-xs pull-right' style="margin-right: 5px;" onclick="add_policy_group();">Add New Group</a>
                <br><hr><br> 
                 <div class="col-md-12" id="main_atro">
                 <div id="members">
                  <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="success">
                          <th style="width:5%;">No.</th>
                          <th style="width:20%;">Company </th>
                          <th style="width:40%;"> Group Name</th>
                          <th style="width:35%;">Policy Type</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $i=1; foreach ($companyList as $company) {?>
                        <tr>
                          <td><?php echo $i?></td>
                          <td><?php echo $company->company_name?></td>
                          <td>
                            <?php   
                                $group = $this->transaction_employees_model->company_atro_group($company->company_id);
                                if(empty($group)){ echo "<n class='text-danger'>No Group found.</n>"; }
                                else{
                                   $i=1; foreach ($group as $g) {?>
                                   <n class='text-success' style='font-weight: bold;'>(<?php echo $i?>).</n>  <a  style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to view details!'  onclick='policy_group_details(<?php echo $g->id?>)'> <?php echo $g->group_name."<br>";?> </a>
                            <?php $i++; } }?>
                          </td>
                          <td>
                               <?php 
                                $group = $this->transaction_employees_model->company_atro_group($company->company_id);
                                 if(empty($group)){ echo "<n class='text-danger'>No policy found.</n>"; }
                               else{  $i=1; foreach ($group as $g) {?>
                                   <n class='text-success' style='font-weight: bold;'>(<?php echo $i?>).</n> <?php echo $g->cValue."<br>";?>
                            <?php $i++; } } ?>
                          </td>
                        </tr>
                      <?php $i++; } ?>
                      </tbody>
                    </table>
                    </div>
                    <br><br>
                  </a>
                </div>
          <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>
</div>
