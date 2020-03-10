 
        <!-- end of employee profile -->



<style>

      .scrollbar {

        height: 50vh;
        overflow-x: hidden;
        overflow-y: scroll;
      }

      .scrollbar_all {

        height: 50vh;
        overflow-x: hidden;
        overflow-y: scroll;
      }


      .force-overflow {
          min-height: 250px;
      }

      #style-1::-webkit-scrollbar {
          width: 5px;
          background-color: #d9edf7;
      } 

      #style-1::-webkit-scrollbar-thumb {
          background-color: #3c8dbc;
      }

      #style-1::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
          background-color: #d9edf7;
      }
</style>

        </section><!-- /.content -->
      </div><!-- <div class="container-fluid"> -->

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             

 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>

    <script>
       function profile_change(val)
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
                
                document.getElementById("change_picture").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/profile_change/"+val,true);
            xmlhttp.send();
    }
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();

      });



    </script>

  </body>
</html>