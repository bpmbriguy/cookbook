<div class="indent">
    <div class="wrapper">
            <article class="col-1">
            <div class="bg">
                <div class="padding">
                    <h3 class="p2">Search Results</h3>
                    <div class="wrapper p3">
<?php echo form_open('search/results', $form_attributes)
. form_label('Recipe Name: ', 'query')
. form_input('query', $search_term);
echo form_submit('submit', 'Search'). "<br /><br />";
if($this->tank_auth->get_user_role() > 0) {
    $user_select = array(0 => "Any") + $user_select;
    echo form_label('Filter by User', 'user_filter');
    echo form_dropdown('recipe_user_id', $user_select, $this->input->get('recipe_user_id'));
}
echo $cat_chooser;

echo form_close(); ?>
                    </div>
<?php if($recipes) : ?>
<?php foreach($recipes as $recipe) :  ?>
    <div class="wrapper p3">
        <?php if(!empty($recipe->image_path) && file_exists(realpath(APPPATH . '../images/thumbs')."/$recipe->image_path")) { ?>
        <figure class="img-indent"><a href="<?php echo base_url();?>recipe/view/<?php echo $recipe->recipe_id; ?>"><img src="<?php echo base_url(); ?>images/thumbs/<?php echo $recipe->image_path; ?>" alt="" /></a></figure>
        <?php } else { ?>
        <figure class="img-indent"><a href="<?php echo base_url();?>recipe/view/<?php echo $recipe->recipe_id; ?>"><img src="http://placehold.it/150x150" alt="" /></a></figure>
        <?php } ?>
        <div class="extra-wrap">
            <p class="p1"><?php echo $recipe->name; ?></p>
            <p><?php echo nl2br($recipe->ingredients); ?></p>
            <a class="button-2" href="<?php echo base_url();?>recipe/view/<?php echo $recipe->recipe_id; ?>">View Full Recipe</a>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
                </div>
            </div>
            </article>
    </div>
</div>