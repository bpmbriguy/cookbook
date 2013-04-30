<?php foreach($recipes as $recipe): ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $subject; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $subject; ?></h2>
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><?php echo $recipe->name; ?></b></big><br />
<br />
Ingredients:<br />
<?php echo nl2br($recipe->ingredients); ?> <br /><br />
Directions:<br />
<?php echo nl2br($recipe->directions); ?>
</td>
</tr>
</table>
</div>
</body>
</html>
<?php endforeach; ?>