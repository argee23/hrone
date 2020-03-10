<h2 class="page-header">Employee's Child/Children</h2>

<?php foreach ($info as $child) { ?> 
		<div class="box box-solid" >
            <div class="box-header bg-olive with-border">
              <i class="fa fa-users fa-border"></i>


              <h4 class="box-title"><?php echo $child->child_name; ?></h4>
               <div class="pull-right">
                 <button type="button" class="btn btn-primary btn-xs" ng-click="editEducation(ed)" data-toggle="modal" data-target="#edit-education"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn btn-danger btn-xs"  ng-click="editEducation(ed)" data-toggle="modal" data-target="#delete-education"><i class="fa fa-trash"></i> Delete</button>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <dl class="dl-horizontal">
                <dt>Occupation</dt>
                <dd><?php echo $child->occupation; ?></dd>
                <dt>Gender</dt>
                <dd><?php echo $child->gender_name; ?></dd>
                <dt>Birthday</dt>
                <dd><?php echo date("F d, Y", strtotime($child->birthday)); ?></dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>

          <?php } ?>