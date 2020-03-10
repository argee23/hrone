<?php include('header.php');?>
        
        <div id="col_2">
                
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>INVENTORY</strong>

     <?php if($checker_inactive==0){?>
        <a onclick="inventory_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
     <?php } ?></div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>

       <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">

       <?php foreach($employee_inventory as $inventory){?>


       <div class="box-body">

        
       <div><label><?php echo $inventory->inventory_name; ?></label>
         <?php if($checker_inactive==0){?>
          <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/inventory_delete/'. $inventory->inventory_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>
<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

?>
          <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="inventory_edit('<?php echo $inventory->inventory_id; ?>')"></i>
<?php
}
?>

        </div>
        <?php } ?>
       <div class="col-md-12"><div class="box box-success"></div></div>

          <div class="row">

             <div class="col-md-12">
              <div class="form-group">
                  <label><?php echo $inventory->file; ?></label>
              </div>
              </div>
            
            <div class="col-md-12">            
            <div class="form-group">
              <a href="<?php echo base_url(); ?>app/employee_201_profile/download_inventory/<?php echo $inventory->inventory_id;?>"
              type="button" class="btn btn-info btn-xs" title="Download File" ><i class="fa fa-download"></i> Download File</a>     
              
            </div>
            </div>
            
            <?php if($inventory->comment!=null){ ?>
            <div class="col-md-12">
            <div class="form-group">
              <label for="comment">Description(s)</label>
              <div class="well">
              <p><?php echo $inventory->comment; ?></p>
              
              </div>
            </div>
            </div>
            <?php } ?>

            </div>
     
       </div><!-- /.box-body -->   
    
     <?php } ?>
            
      <?php if(count($employee_inventory)<=0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No Inventory uploaded yet.</strong></p>
        </td>
      </tr>
      <?php } ?>

             </div>
             </div>
     <br>
     </div>
     </div> 
     </div>

</div>
</div>

</div>  
</div>




        </div>  
</div>

<script>
    function inventory_add(val)
    {          
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/inventory_add/"+val,true);
            xmlhttp.send();
    }

    function inventory_edit(val)
    {          
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/inventory_edit/"+val,true);
            xmlhttp.send();
    }
</script>

        </div>

        </div>
 <?php include('footer.php');?>


