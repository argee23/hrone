<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header ng-scope">Frequently Asked Questions (FAQs)</h2>
<?php foreach ($faqs as $faq) { ?>
        <div class="box box-solid">
            <div class="box-header with-border bg-olive">
              <h3 class="box-title "><?php echo $faq->question; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo nl2br($faq->answer); ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
<?php
} ?>
</div>
</div>