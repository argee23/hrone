




<!------ Include the above in your HEAD tag ---------->
<br><br>





<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">

<h2 class="page-header">Section Management  </h2>
<div class="container">
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i>Company List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <?php $form_location   = base_url()."employee_portal/pms/evaluation_home/";?>
    <form id="form5" method="post" action="<?php echo $form_location;?>">
             <select name="company">
              <?php 
              foreach($c as $c){?>
      
               <option value="<?php echo $c->company_id ?>"><?php   echo $c->company_name; ?></option>
      

              <?php }

               ?>
                      </select>   
          <input type="submit" name="submit" value="submit">
        </form>
              </div>
           
            </div>
          </div>



