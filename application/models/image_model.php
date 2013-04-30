<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function add($recipe_id, $path)
    {
        return $this->db->insert('image', array('recipe_id' => $recipe_id, 'path' => $path));
    }
}