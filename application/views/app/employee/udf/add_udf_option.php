
<?php for($num = 1; $num <= $this->uri->segment("4");$num++){
$label = 'option_'.$num;
?>
<div class="form-group">        
<label>Option <?php echo $num; ?></label>
  <input type="text" class="form-control" name="<?php echo $label; ?>" id="<?php echo $label; ?>" placeholder="Option <?php echo $num; ?>" value="" required>
</div>
<?php } ?>