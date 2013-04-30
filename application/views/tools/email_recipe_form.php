<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Email this recipe</title>
    </head>
    <style>
        form {
            font-family:"Times New Roman", Times, serif;
            width: 380px;
        }
        legend {
            color: #ca4b00;
            font-size:20px;
        }
        label {
            display: inline-block;
            width: 100px;
            margin: 5px 0;
            padding-right: 10px;
        }
        #button {
            margin-left: 115px;
        }
    </style>
    <body>
<?php echo form_open('tools/email_recipe/'.$this->uri->segment(3)); ?>
<?php echo form_fieldset('Email This Recipe', array('id' => 'emailRecipe')); ?>
<?php echo form_label('Email Address', 'email'); ?>
<?php echo form_input('email', set_value('email')); ?>
        <br />
<?php echo form_submit('submit', 'Send Recipe'); ?>
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
    </body>
</html>