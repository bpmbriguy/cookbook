<div class="indent">
	<div class="wrapper">
    	<article class="col-1">
            <div class="bg">
                <div class="padding">
                    <h3 class="p2">Manage Categories</h3>
                    <? foreach ($categories as $category): ?>
                        <?php echo form_open_multipart('admin/update_category'); ?>
                        <?php echo form_label('New Image', 'cat_image'); ?>
                        <?php echo form_upload('userfile'); ?>
                        <?php echo form_label('Name', 'cat_name'); ?>
                        <?php echo form_input('cat_name', set_value('cat_name', $category->name)); ?>
                        <?php echo form_hidden('cat_id', $category->category_id); ?>
                        <?php echo form_submit('submit', 'Submit'); ?>
                        <?php echo form_close(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>
        </div>
</div>
