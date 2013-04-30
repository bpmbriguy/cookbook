<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bookmark_model extends CI_Model {
    
    function addBookmark()
    {
        $data = array(
            'user_id' => $this->tank_auth->get_user_id(),
            'recipe_id' => $this->input->post('recipe_id')
        );
        $this->db->insert('user_bookmarks', $data); 
    }
    
    function deleteBookmark()
    {
        $this->db->where('recipe_id', $this->input->post('recipe_id'));
        $this->db->where('user_id', $this->tank_auth->get_user_id());
        $this->db->delete('user_bookmarks'); 
    }
    
    function checkBookmark()
    {
        $this->db->where('recipe_id', $this->uri->segment(3));
        $this->db->where('user_id', $this->tank_auth->get_user_id());
        $this->db->from('user_bookmarks');
        return $this->db->count_all_results();
        
    }
    
    function getUserBookmarks($user_id = null)
    {
        if(is_null($user_id)){
            $user_id = $this->tank_auth->get_user_id();
        }
        
        $this->db->select('recipe.recipe_id, recipe.name, category.category_id, category.name AS category_name')
                ->from('recipe')->order_by('category.name')
                ->order_by('recipe.name')
                ->where('ub.user_id',$user_id);
        
        $this->db->join('category', 'category.category_id = recipe.category_category_id', 'left outer');
        $this->db->join('user_bookmarks AS ub', 'ub.recipe_id = recipe.recipe_id');
        
        $q = $this->db->get();
        
        $data = array();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                if(!isset($data[$row->category_name])){
                 $data[$row->category_name] = array();   
                }
                
                $data[$row->category_name][$row->recipe_id] = $row->name;
                
            }
            return $data;
        }
    }
}