<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
    
    function index() {
        
        $data['main_content'] = 'category/category_view';
        $data['pageid'] = 'page5';
        
        $this->load->model('category_model');
        
        $categories = $this->category_model->getAll();
        
        if($categories)
        {
            $data['categories'] = $categories;
        }
        
        $this->load->view('includes/template', $data);
        
    }
    
    function browse($name) {
        
        $data['main_content'] = 'category/category_browse';

        $name = urldecode($name);
        
        $this->load->model('category_model');
        
        
        
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = base_url() . "category/".$name;
        $config['total_rows'] = $this->category_model->countRecipesByCategoryName($name);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['recipes'] = $this->category_model->getRecipesByCategoryName($name, $config["per_page"], $page);
        $data['links'] = $this->pagination->create_links();

        $data['name'] = $name;

        
        $this->load->view('includes/template', $data);
        
        
        
    }
    
}