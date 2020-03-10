<style type="text/css">.breadcrumbs {
    padding: 0px;
    background: transparent;
    list-style: none;
    overflow: hidden;
    margin-top: 20px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.breadcrumbs>li {
    display: table-cell;
    vertical-align: top;
    width: 1%;
}

.breadcrumbs>li+li:before {
    padding: 0;
}

.breadcrumbs li a {
    color: white;
    text-decoration: none;
  	height: 70px;
  	padding-left:15px;
    position: relative;
    display: inline-block;
    width: calc( 100% - 10px );
    background-color: hsla(0, 0%, 83%, 1);
    text-align: top;
    text-transform: capitalize;
}

.breadcrumbs li.completed a {
    background: brown;
    background: hsla(153, 57%, 51%, 1);
}

.breadcrumbs li.completed a:after {
    border-left: 30px solid hsla(153, 57%, 51%, 1);
}

.breadcrumbs li.active a {
    background: #ffc107;
}

.breadcrumbs li.active a:after {
    border-left: 30px solid #ffc107;
}

.breadcrumbs li:first-child a {
    padding-left: 15px;
}

.breadcrumbs li:last-of-type a {
    width: calc( 100% - 38px );
}

.breadcrumbs li a:before {
    content: " ";
    display: block;
    width: 0;
    height: 0;
    border-top: 50px solid transparent;
    border-bottom: 50px solid transparent;
    border-left: 30px solid white;
    position: absolute;
    top: 50%;
    margin-top: -50px;
    margin-left: 1px;
    left: 100%;
    z-index: 1;
}

.breadcrumbs li a:after {
    content: " ";
    display: block;
    width: 0;
    height: 0;
    border-top: 50px solid transparent;
    border-bottom: 50px solid transparent;
    border-left: 30px solid hsla(0, 0%, 83%, 1);
    position: absolute;
    top: 50%;
    margin-top: -50px;
    left: 100%;
    z-index: 2;
}
</style>

<!------ Include the above in your HEAD tag ---------->
    
            
		<ul class="breadcrumbs" >
    		<li class="completed"  ><a href="javascript:void(0);" >Creation <br>Creator: Argee bantang</a></li>
			<li class="active"><a href="javascript:void(0);">Evaluation <br><span style="padding-left:13px;">Creator: Argee bantang (done)</span><br><span style="padding-left:13px;">Creator: Argee bantang</span></a></a></li>
			<li><a href="javascript:void(0);">Approval <br><p style="padding-left:13px;">Creator: Argee bantang</p></a></a></li>

		</ul>

 <button id='update_form' class="btn btn-primary btn-block pull-right" onclick="delete_all(<?php if(!empty($employeeid)){echo $employeeid;}?>,'<?php if(!empty($doc_no->doc_no)){ echo $doc_no->doc_no; } ?>','<?php if(!empty($ref_eval->ref)){ echo $ref_eval->ref; } ?>')" >Ready for Evaluation</button>

 <script type="text/javascript">

        alert(ref);

        function delete_all(id,doc_no,ref) {



     $.ajax({
       url: "<?php echo base_url();?>employee_portal/pms/evaluation_for/",
       method:"POST",
       data:{'id':id,'doc_no':doc_no,'ref':ref},
         beforeSend: function(){
           toastr.info('Please wait ');
           toastr.clear();
        },
   
       success:function()
       {
         toastr.success('insertion is completed');
       }
     })
   


  }

 </script>