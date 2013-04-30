<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recipe_model extends CI_Model {
    
    function getRecipeByID($id) {
        $this->db->select('recipe.*, image.path')
                ->from('recipe')
                ->where('recipe.recipe_id', $id);
        $this->db->join('image', 'image.recipe_id = recipe.recipe_id', 'left outer');
        
        $q = $this->db->get();

        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    function getNewest() {
        $this->db->select('recipe.recipe_id, recipe.name,recipe.prep_time, category.name as category_name, image.path as image_path')
                ->from('recipe')->order_by('date_added', 'desc')->limit(15);
        
        $this->db->join('category', 'category.category_id = recipe.category_category_id');
        $this->db->join('image', 'image.recipe_id = recipe.recipe_id', 'left outer');
        
        
        $q = $this->db->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    function search($name, $categories = null) {
        /*
        $query = $this->db->select('recipe.recipe_id, name, ingredients, prep_time, path as image_path')
                ->join('image', 'image.recipe_id = recipe.recipe_id', 'left outer')
                ->from('recipe')
                ->like('name', $name)->order_by('name');
        if(!empty($categories))
                $query->where_in('category_category_id', $categories);
        if($this->input->get('recipe_user_id') == true)
                $query->where('user_user_id', $this->input->get('recipe_user_id'));
         * 
         */
        $sql = "SELECT recipe.recipe_id, name, ingredients, prep_time, path as image_path "
                . "FROM recipe LEFT OUTER JOIN image ON image.recipe_id = recipe.recipe_id "
                . "WHERE MATCH (name) AGAINST (".$this->db->escape($name).") ";
        
        if(!empty($categories))
        {
            $sql .= "AND category_category_id IN (".implode("','", $categories).") ";
        }
        if($this->input->get('recipe_user_id') == true)
        {
            $sql .= "AND user_user_id = " . $this->db->escape($this->input->get('recipe_user_id'));
        }
        
        
        $q = $this->db->query($sql);

        //$q = $query->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    function add() {
        
        $recipe = array(
            'name'  => mb_convert_case($this->input->post('name'), MB_CASE_TITLE, "UTF-8"),
            'ingredients'  => $this->input->post('ingredients'),
            'directions'  => $this->input->post('directions'),
            'prep_time'  => $this->input->post('prep_time'),
            'category_category_id'  => $this->input->post('category'),
            
        );
        
        if($this->tank_auth->get_user_role() > 1){
            $recipe['user_user_id']  = $this->input->post('recipe_user_id');
        } else {
            $recipe['user_user_id']  = $this->tank_auth->get_user_id();
        }
        
        $this->db->insert('recipe', $recipe);
        
        return $this->db->insert_id();
        
    }
    
    function update($recipe = null) {
        $recipe = array(
            'name'  => $this->input->post('name'),
            'ingredients'  => $this->input->post('ingredients'),
            'directions'  => $this->input->post('directions'),
            'prep_time'  => $this->input->post('prep_time'),
            'category_category_id'  => $this->input->post('category')
        );
        
        if($this->tank_auth->get_user_role() > 1){
            $recipe['user_user_id']  = $this->input->post('recipe_user_id');
        } else {
            $recipe['user_user_id']  = $this->tank_auth->get_user_id();
        }
        
        $this->db->where('recipe_id', $this->input->post('recipe_id'));
        $result = $this->db->update('recipe', $recipe);
        
        return $result;
    }
    
    function delete($recipe)
    {
        $this->db->delete('recipe', array('recipe_id' => $recipe));
    }
    
    function getUserRecipes($user_id = null)
    {
        if(is_null($user_id)){
            $user_id = $this->tank_auth->get_user_id();
        }
        
        $this->db->select('recipe.recipe_id, recipe.name, category.category_id, category.name AS category_name')
                ->from('recipe')->order_by('category.name')
                ->order_by('recipe.name')
                ->where('user_user_id',$user_id);
        
        $this->db->join('category', 'category.category_id = recipe.category_category_id', 'left outer');
        
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