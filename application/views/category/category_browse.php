<div class="indent">
	<div class="wrapper">
    	<article class="col-1">
            <div class="bg">
                <div class="padding">
<h3 class="p2">All Recipes in <?php echo $name;?></h3>
<?php if($recipes) : ?>
<?php $i=1; ?>
<div id="section1">
<?php foreach($recipes as $recipe) : ?>
<?php if($i > 10)
{
echo "</div><div id=\"section2\">";
}
?>
    <div class="wrapper p3">
            <?php if(!empty($recipe->image_path) && file_exists(realpath(APPPATH . '../images/thumbs')."/$recipe->image_path")) { ?>
            <figure class="img-indent"><a href="<?php echo base_url(); ?>recipe/view/<?php echo $recipe->id;?>"><img src="<?php echo base_url(); ?>images/thumbs/<?php echo $recipe->image_path; ?>" alt="" /></a></figure>
            <?php } else { ?>
            <figure class="img-indent"><a href="<?php echo base_url(); ?>recipe/view/<?php echo $recipe->id;?>"><img src="http://placehold.it/150x150" alt="<?php echo $recipe->name;?>" /></a></figure>
            <?php } ?>
        <div class="extra-wrap">
            <p class="p1"><a href="<?php echo base_url();?>recipe/view/<?php echo $recipe->id;?>"><strong><?php echo $recipe->name;?></strong></a><br />
                    <?php if($recipe->prep_time > 0) : ?>
                    <em><?php echo "Prep Time: ". $recipe->prep_time; ?></em>
                    <?php endif; ?>
            </p>
        </div>
    </div>
<?php $i++; ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<div id="clear" />
<div class="local_pagination">
    <?php echo $links; ?>
</div>
                    </div>
                </div>
            </article>
    </div>
</div>
