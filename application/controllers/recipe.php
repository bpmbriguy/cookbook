<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller {
    
    function index() {
        
        $this->load->model('recipe_model');
        
        $data['recipes'] = $this->recipe_model->getNewest();
        
        $data['main_content'] = 'recipe/newest_view';
        $data['pageid'] = 'page5';
        $this->load->view('includes/template', $data);
        
    }
    
    function view($id) {
        
        $this->load->model('recipe_model');
        
        $data['recipes'] = $this->recipe_model->getRecipeByID($id);
        
        if($this->tank_auth->is_logged_in())
        {
            $this->load->model('bookmark_model');
            $data['bookmarked'] = $this->bookmark_model->checkBookmark();
        }

        $data['main_content'] = 'recipe/recipe_view';
        $data['pageid'] = 'page5';
        $this->load->view('includes/template', $data);
    }
    
}