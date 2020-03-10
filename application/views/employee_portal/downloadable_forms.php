<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12" style="padding-top: 20px;">

<div class="box box-solid" >
            <div class="box-header with-border bg-olive">
              <h3 class="box-title"><i class="fa fa-download"></i> <b>Downloadable Forms</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-12" style="margin-top: 20px;">
            <table class="table table-hover" id="Downloadable">
              <thead>
                <tr class="danger">
                    <th><center>No</center></th>
                    <th><center>Form Title</center></th>
                    <th><center>Description</center></th>
                    <th><center>File Name</center></th>
                    <th><center>Action</center></th>
                </tr>
              </thead>
              <tbody>
              <?php $i=1; foreach($downloadable as $d){?>

                <tr>
                    <td><center><?php echo $i.".";?></center></td>
                    <td><center><?php echo $d->file_name;?></center></td>
                    <td><center><?php echo $d->file_description;?></center></td>
                    <td><center><?php echo $d->filename;?></center></td>
                    <td><center> <a href="<?php echo base_url(); ?>app/downloadable_forms/download_forms/<?php echo $d->filename; ?>" title="Download File" ><i class="fa fa-download"></i> </a></center></td>
                </tr>

              <?php $i++; } ?>
              </tbody>
            </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
</div>
</div>
<script type="text/javascript">
   $(function () {
        $('#Downloadable').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    
</script>
 