<div class="indent">
    <div class="wrapper">
            <article class="col-1">
            <div class="bg">
                <div class="padding">
                    <h3 class="p2">New Recipes</h3>
<?php if($recipes) :

foreach($recipes as $recipe) : ?>
<div class="wrapper p3">
        <?php if(!empty($recipe->image_path) && file_exists(realpath(APPPATH . '../images/thumbs')."/$recipe->image_path")) { ?>
        <figure class="img-indent"><a href="<?php echo base_url();?>recipe/view/<?php echo $recipe->recipe_id; ?>"><img src="<?php echo base_url(); ?>images/thumbs/<?php echo $recipe->image_path; ?>" alt="" /></a></figure>
        <?php } else { ?>
        <figure class="img-indent"><a href="<?php echo base_url();?>recipe/view/<?php echo $recipe->recipe_id; ?>"><img src="http://placehold.it/150x150" alt="" /></a></figure>
        <?php } ?>
    <div class="extra-wrap">
        <a class="button-2" href="<?php echo base_url();?>recipe/view/<?php echo $recipe->recipe_id; ?>"><?php echo $recipe->name; ?></a>
        <p class="p1">
        <ul>
            <li><?php echo $recipe->category_name; ?></li>
            <?php if($recipe->prep_time > 0 ): ?>
            <li><em>Prep Time: <?php echo $recipe->prep_time; ?> Minutes</em></li>
            <?php endif; ?>
        </ul>
        </p>
    </div>
</div>
<?php endforeach;
endif; ?>
                </div>
            </div>
        </article>
    </div>
</div>