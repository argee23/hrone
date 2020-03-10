<table class="table table-hover" id="downloadable">
    <thead>
      <tr class="danger">
          <th><center>ID</center></th>
          <th><center>Numbering</center></th>
          <th><center>Title</center></th>
          <th><center>Description</center></th>
          <th><center>Filename</center></th>
          <th><center>Action</center></th>
          
      </tr>
    </thead>
    <tbody>
      <?php foreach($policy as $p){?>
      <tr>
          <td><center><?php echo $p->id;?></center></td>
          <td><center><?php echo $p->numbering;?></center></td>
          <td><center><?php echo $p->file_name;?></center></td>
          <td><center><?php echo $p->file_description;?></center></td>
          <td><center><?php echo $p->filename;?></center></td>
          <td><center><a href="<?php echo base_url(); ?>app/downloadable_company_policy/download_forms/<?php echo $p->filename; ?>" title="Download File" ><i class="fa fa-download"></i> </a></center></td>
      </tr> 
      <?php } ?>                      
    </tbody>
</table>