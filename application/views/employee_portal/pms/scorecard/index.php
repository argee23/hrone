<link href="<?php echo base_url()?>public/plugins/tost/toastr.css" rel="stylesheet"/>
<script src="<?php echo base_url()?>public/plugins/tost/toastr.js"></script>


<style type="text/css">


.nav>li>a:hover, .nav>li>a:focus, .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
    background:#fff;
}
.dropdown {
    background:#fff;
    border:1px solid #cccccc;
    border-radius:4px;
    width:300px;    
}
.dropdown-menu>li>a {
    color:#428bca;
}
.dropdown ul.dropdown-menu {
    border-radius:4px;
    box-shadow:none;
    margin-top:20px;
    width:300px;
}
.dropdown ul.dropdown-menu:before {
    content: "";
    border-bottom: 10px solid #fff;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    top: -10px;
    right: 16px;
    z-index: 10;
}
.dropdown ul.dropdown-menu:after {  
    content: "";
    border-bottom: 12px solid #ccc;
    border-right: 12px solid transparent;
    border-left: 12px solid transparent;
    position: absolute;
    top: -12px;
    right: 14px;
    z-index: 9;
}
.dropdown ul.dropdown-menu li:hover .mega {
  display: block;
}

.mega {
  width: 600px;
  display: none;
  position: absolute;
  left: 300px;
  top: 0px;
  background: #FFF;
  border: 1px solid #cccccc;
  border-radius: 4px;
  -webkit-box-shadow: 2px 3px 5px 0px rgba(204,204,204,1);
-moz-box-shadow: 2px 3px 5px 0px rgba(204,204,204,1);
box-shadow: 2px 3px 5px 0px rgba(204,204,204,1);
}
.mega aside {
  float: left;
  width: 150px;
}
.mega .featured {
  float: right;
  width: 440px;
}
.mega .featured img {
  max-width: 400px;
}

.dataTable > thead > tr > th[id*="no"]:after{
    content: "" !important;
}


</style>

<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Creators Page </h2>
   


     
 

      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i>Company List</h4>
        </div>
        <div class="panel-body">

            <div class="col-md-12">
        <?php $form_location   = base_url()."employee_portal/pms/home/";?>
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



 
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">



</script>

</div>
</div>  
