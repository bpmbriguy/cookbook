<?php echo $subject; ?>

<?php foreach($recipes as $recipe): ?>
<?php echo $recipe->name; ?>

Ingredients:
<?php echo $recipe->ingredients; ?>

Directions:
<?php echo $recipe->directions; ?>
<?php endforeach; ?>
