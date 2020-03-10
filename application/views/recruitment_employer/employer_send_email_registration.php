
<div class="col-md-12">
<div class="col-md-2"></div>
<div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;">
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th colspan="4"></th>
  </tr>
  <tr>
    <th colspan="4" style="text-align: center"><h2>Employer Registration</h2></th>
  </tr>
  <tr>
    <th colspan="4"></th>
  </tr>
  
  </thead>

  <tbody style="font-size: 10px;">
  <tr>
    <td width="20%"><p style="color: #1e90ff;">Date Registered:</p></td>
    <td width="40%"><?php echo date('Y-m-d');?></td>    
    <td width="20%"><p style="color: #1e90ff;">Company Name:</p></td> 
    <td width="40%"><?php if(!empty($result->company_name)){  echo $result->company_name; } ?></td>    
  </tr>
  <tr>
    <td width="20%"><p style="color: #1e90ff;">Industry:</p></td>
    <td width="40%">
        <?php  if(!empty($result->cValue)){ echo $result->cValue; } ?>
    </td>    
    <td width="20%"><p style="color: #1e90ff;">Company Website:</p></td> 
    <td width="40%"><?php if(!empty($result->company_website)){ echo $result->company_website; } ?></td>    
  </tr>

  <tr>
    <td width="20%"><p style="color: #1e90ff;">Identification Number:</p></td>
    <td width="40%"><?php if(!empty($result->company_tin)){ echo $result->company_tin; } ?></td>    
    <td width="20%"><p style="color: #1e90ff;">Number of Employees:</p></td> 
    <td width="40%"><?php if(!empty($result->employee_counts)){ echo $result->employee_counts; } ?></td>    
  </tr>
  <tr>
    <td width="20%"><p style="color: #1e90ff;">Contact Person:</p></td>
    <td width="40%"><?php if(!empty($result->contact_person)){ echo $result->contact_person; } ?></td>    
    <td width="20%"><p style="color: #1e90ff;">Designation:</p></td> 
    <td width="40%"><?php if(!empty($result->designation)){ echo $result->designation;} ?></td>    
  </tr>
  <tr>
    <td width="20%"><p style="color: #1e90ff;">Telephone Number:</p></td>
    <td width="40%"><?php if(!empty($result->tel_no)){ echo $result->tel_no; } ?></td>    
    <td width="20%"><p style="color: #1e90ff;">Mobile Number:</p></td> 
    <td width="40%"><?php if(!empty($result->mobile_no)){ echo $result->mobile_no; } ?></td>    
  </tr>
  <tr>
    <td width="20%"><p style="color: #1e90ff;">Country:</p></td>
    <td width="40%">
      <?php 
       if(!empty($result->country)){  
            $country = $this->recruitment_employer_model->get_email_data('system_parameters','param_id','country',$result->country,'cValue'); 
            if(!empty($country)){ echo $country; } else{ echo "no data found"; }
        }
       else { echo "no_data"; }
      ?>
    
    </td>    
    <td width="20%"><p style="color: #1e90ff;">Address:</p></td> 
    <td width="40%">
        <?php 
              if(!empty($result->brgy_street)){ 
                    echo $result->brgy_street."<br>";
              }
              if(!empty($result->province)){ 
                $province = $this->recruitment_employer_model->get_email_data('provinces','id','province',$result->province,'name');  
                if(!empty($province)){ echo $province."<br>"; }
              } 

              if(!empty($result->prov_city)){ 
                 $city = $this->recruitment_employer_model->get_email_data('cities','id','cities',$result->prov_city,'city_name'); 
                  if(!empty($city)){ echo $city; }
              }

         ?>
          
    </td>    
  </tr>
 
  </tbody>
</table>
</div>
  <div  class="col-md-2" ></div>
</div>
<div class="col-md-2"></div>
</div>
