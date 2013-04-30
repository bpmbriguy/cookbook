<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    function file_image_url($str)
    {
        if(filter_var($str, FILTER_VALIDATE_URL) === FALSE)
        {
            return false;
        } else {
            $ext = strtolower(pathinfo(parse_url($str,PHP_URL_PATH),PATHINFO_EXTENSION));
            return in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'jpe'));
        }
    }
}