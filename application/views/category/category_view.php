<div class="indent">
    <div class="wrapper">
            <article class="col-1">
            <div class="bg">
                <div class="padding">
                    <h3 class="p2">Find Recipes by Category</h3>
<div class="wrapper p3">
<?php if ($categories) : ?>
    <div id="categoryTable">
<?php foreach($categories as $category) : ?>
        <div id="category">
        <a href="category/<?php echo $category->name; ?>">
        <?php if(!empty($category->image_path) && file_exists(realpath(APPPATH . '../images/category/thumbs')."/$category->image_path")) { ?>
        <figure><img src="<?php echo base_url(); ?>images/category/thumbs/<?php echo urlencode($category->image_path); ?>" alt="" /></figure>
        <?php } else { ?>
	<figure><img src="http://placehold.it/200x150" alt="<?php echo urlencode($category->name);?>" /></figure>
        <?php } ?>
        </a>
        <a class="button-2" href="category/<?php echo urlencode($category->name); ?>"><?php echo $category->name; ?></a>
        </div>
<?php endforeach; ?>
    </div>
<?php endif; ?>
                </div>
                </div>
            </div>
        </article>
    </div>
</div>