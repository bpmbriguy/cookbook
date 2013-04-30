<div class="indent">
    <div class="wrapper">
            <article class="col-1">
            <div class="bg">
                <div class="padding">
                    <h3 class="p2">Search Recipes</h3>
                    <div class="wrapper p3">
<?php echo form_open('search/results', $form_attributes)
. form_label('Recipe Name: ', 'query')
. form_input('query');
echo form_submit('submit', 'Search'). "<br /><br />";
if($this->tank_auth->get_user_role() > 0) {
    $user_select = array(0 => "Any") + $user_select;
    echo form_label('Filter by User', 'user_filter');
    echo form_dropdown('recipe_user_id', $user_select);
}
echo $cat_chooser;

echo form_close(); ?>
                    </div>
                </div>
            </div>
            </article>
    </div>
</div>