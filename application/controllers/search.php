<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
    
    function index() {
        


        
        $data['cat_chooser'] = $this->cat_chooser();
        $data['form_attributes'] = array('class' => 'p1', 'id' => 'search_form', 'method' => 'get');
        
        
        $data['user_select'] = $this->tank_auth->get_user_select_fullname();
        $data['main_content'] = 'search/search_view';
        $data['pageid'] = 'page5';
        $this->load->view('includes/template', $data);
        
    }
    
    function results() {
        
        $this->load->model('recipe_model');
        
        $selected_categories = array();
        $selected_categories = $selected_categories + (array) $this->input->get('cat');
        
        $data['recipes'] = $this->recipe_model->search($this->input->get('query'), $this->input->get('cat'));
        
        $data['form_attributes'] = array('class' => 'p1', 'id' => 'search_form', 'method' => 'get');
        $data['search_term'] = $this->input->get('query');
        
        $data['cat_chooser'] = $this->cat_chooser((array) $this->input->get('cat'));
        $data['user_select'] = $this->tank_auth->get_user_select_fullname();
        
        $data['main_content'] = 'search/results_view';
        $data['pageid'] = 'page5';
        $this->load->view('includes/template', $data);
    }
    
    function cat_chooser($selected = array()) {
        
        $this->load->model('category_model');
        
        $categories = $this->category_model->getAll();
        
        // Build the table for search categories
        $i = 1;
        $cat_chooser = "<table>\n<tr>\n<td>\n";
        $cat_count = $this->category_model->countCategories();
        $z = 0;
        foreach( $categories as $category ){
                $z++;
                $active = FALSE;
                $active = in_array($category->category_id, $selected) ? TRUE : FALSE;
                $cat_chooser .= form_checkbox('cat[]', $category->category_id, $active);
                $cat_chooser .= form_label($category->name);
                $cat_chooser .= "<br />\n";
                if($i > 3 && $cat_count != $z)
                {
                        $cat_chooser .= "</td>\n<td>\n";
                        $i = 0;
                }
                $i++;
        }
        $cat_chooser .= "</td>\n</tr>\n</table>\n";
        
        return $cat_chooser;
    }
    
}