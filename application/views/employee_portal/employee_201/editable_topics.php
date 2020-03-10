<div class="col-md-9">
 	<div class="panel panel-success">
 		<div class="panel-heading">
 			<h4><i class="glyphicon glyphicon-edit"></i>Editable Topics</h4>
 		</div>
 		<div class="panel-body">
 			<?php if($info=='no_setting'){ echo "<h3 class='text-danger'>You're not allowed to add , update and delete 201 Details</h3>"; } else{?>
 			<h4>List of topics you may edit</h4>
	 		<ul>
	 			<?php foreach ($info as $topic)
	 			{
	 				echo '<li>' . $topic->topic_title . '</li>';
	 			} ?>
	 		</ul>
 		</div>
 			<?php }?>
 	</div>
 </div>