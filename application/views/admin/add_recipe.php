<div class="indent">
    <div class="wrapper">
        <div class="bg">
            <div id="recipeForm">
            <?php echo form_open_multipart('admin/add'); ?>
            <?php echo form_fieldset('Recipe Information', array('id' => 'addRecipe')); ?>
            <ol>
                <li>
            <?php echo form_label('Recipe Name', 'name'); ?>
            <?php echo form_input('name', set_value('name')); ?>
                </li>
                <li>
            <?php echo form_label('Ingredients', 'ingredients'); ?>
            <?php echo form_textarea(array(
                'name'  => 'ingredients',
                'id'    => 'ingredients',
                'value' => set_value('ingredients'),
                'rows'  => 10,
                'cols'  => 50
            )); ?>
                </li>
                <li>
            <?php echo form_label('Directions', 'directions'); ?>
            <?php echo form_textarea(array(
                'name'  => 'directions',
                'id'    => 'directions',
                'value' => set_value('directions'),
                'rows'  => 10,
                'cols'  => 50
            )); ?>
                </li>
                <li>
            <?php echo form_label('Prep Time (mins)', 'prep_time'); ?>
            <?php echo form_input('prep_time', set_value('prep_time')); ?>
                </li>
                <li>
            <?php echo form_label('Category', 'category'); ?>
            <?php echo form_dropdown('category', $categories); ?>
                </li>
                <li>
            <?php echo form_label('Recipe Image', 'userfile'); ?>
            <?php echo form_upload('userfile', set_value('userfile')); ?>
            <?php echo form_label('or paste the URL of a photo already online', 'image_url'); ?>
            <?php echo form_input('image_url', set_value('image_url')); ?>
                </li>
            <?php if($this->tank_auth->get_user_role() > 1): ?>
                <li>
            <?php echo form_label('Recipe Owner', 'recipe_user_id'); ?>
            <?php echo form_dropdown('recipe_user_id', $user_select, $this->tank_auth->get_user_id()); ?>
                </li>
            <?php endif; ?>
            </ol>
            <?php echo form_submit('submit', 'Submit'); ?>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
            <?php echo validation_errors(); ?>
            </div>
        </div>
    </div>
</div>