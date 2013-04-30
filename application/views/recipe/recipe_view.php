<div class="indent">
	<div class="wrapper">
    	<article class="col-1">
<?php if($recipes) : ?>
<?php foreach($recipes as $recipe) : ?>
<h2 class="recipeTitle"><?php echo $recipe->name;?></h2>
<div id="recipeCardMenu">
<?php if($recipe->path): ?>
<div id="recipeCardImage"><img onclick="TINY.box.show({image:'../../images/<?php echo $recipe->path;?>',boxid:'frameless',animate:true})" src="<?php echo base_url();?>images/thumbs/<?php echo $recipe->path;?>" /></div>
<?php endif; ?>
<?php if($this->tank_auth->get_user_role() > 0) : ?>
<div id="recipeTools">
<ul>
    <?php if($recipe->user_user_id != $this->tank_auth->get_user_id()): ?>
    <?php if($bookmarked): ?>
    <li class="like"><a id="bookmark" onclick="TINY.box.show({url:'../../tools/unbookmark_recipe',post:'recipe_id=<?php echo $recipe->recipe_id; ?>',width:200,height:100,opacity:20,topsplit:3,close:0,hideafterpost:2,closejs:function(){closeUnbookmark()}})" href="#" >Remove from My Cookbook</a></li>
    <?php else: ?>
    <li class="like"><a id="bookmark" onclick="TINY.box.show({url:'../../tools/bookmark_recipe',post:'recipe_id=<?php echo $recipe->recipe_id; ?>',width:200,height:100,opacity:20,topsplit:3,close:0,hideafterpost:2,closejs:function(){closeBookmark()}})" href="#">Add to My Cookbook</a></li>
    <?php endif; ?>
    <?php endif; ?>
    <li class="email"><a onclick="TINY.box.show({iframe:'../../tools/email_recipe/<?php echo $recipe->recipe_id; ?>',width:400,height:200})" href="#email">Email this recipe</a></li>
<?php if($recipe->user_user_id == $this->tank_auth->get_user_id() || $this->tank_auth->get_user_role() > 1) : ?>
    <li class="edit"><a href="<?php echo base_url(); ?>admin/edit/<?php echo $recipe->recipe_id; ?>">Edit</a></li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>
</div>
<div class="recipeCard">
    Ingredients:<br />
    <?php echo nl2br($recipe->ingredients); ?> <br /><br />
    Directions:<br />
    <?php echo nl2br($recipe->directions); ?>
    <?php if($recipe->prep_time > 0) {
        echo "<br /><br /><em>Prep Time: ".$recipe->prep_time. " minutes </em><br /><br />";
    } ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
		</article>
	</div>
</div>
<script type="text/javascript">
function closeUnbookmark(){
    $('#bookmark').text('Add to My Cookbook');
    $("#bookmark").attr("onClick","TINY.box.show({url:'../../tools/bookmark_recipe',post:'recipe_id=<?php echo $recipe->recipe_id; ?>',width:200,height:100,opacity:20,topsplit:3,close:0,hideafterpost:2,closejs:function(){closeBookmark()}})");
    }
function closeBookmark(){
    $('#bookmark').text('Remove from My Cookbook');
    $("#bookmark").attr("onClick","TINY.box.show({url:'../../tools/unbookmark_recipe',post:'recipe_id=<?php echo $recipe->recipe_id; ?>',width:200,height:100,opacity:20,topsplit:3,close:0,hideafterpost:2,closejs:function(){closeUnbookmark()}})");
    }
</script>