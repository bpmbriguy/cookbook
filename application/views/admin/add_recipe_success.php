<div class="indent">
    <div class="wrapper">
        <div class="bg">
            <div id="actionMessage">New Recipe Saved</div>
            <div class="quickDialogue">
                What should we do next?
                <ol>
                    <li><a href="<?php echo base_url(); ?>recipe/view/<?php echo $new_recipe_id; ?>">View your new recipe</a></li>
                    <li><a href="<?php echo base_url(); ?>admin/add">Add another recipe</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>