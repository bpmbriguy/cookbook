<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {
    
    function getAll() {
        $q = $this->db->get('category');
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    function categoryDropdown() {
        $categories = $this->getAll();
        
        $data = array();
        foreach ($categories as $category)
        {
            $data[$category->category_id] = $category->name;
        }
        
        return $data;
    }
    
    function countCategories() {
        return $this->db->count_all('category');
    }
    
    function countRecipesByCategoryName($name) {
        $this->db->select('r.recipe_id AS id, r.name, r.prep_time')
                ->from('recipe as r')
                ->join('category as c', 'c.category_id = r.category_category_id')
                ->where('c.name', $name);
        $q = $this->db->get();
        return $q->num_rows;
    }
    
    function getRecipesByCategoryName($name, $limit, $start) {
        
        $this->db->select('r.recipe_id AS id, r.name, r.prep_time, i.path as image_path')
                ->from('recipe as r')
                ->join('category as c', 'c.category_id = r.category_category_id')
                ->join('image as i', 'i.recipe_id = r.recipe_id', 'left outer')
                ->where('c.name', $name)
                ->order_by('r.name')
                ->limit($limit, $start);
        
        $q = $this->db->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
        
        
    }
    
    function update($filename = null)
    {
        if($this->tank_auth->get_user_role() > 2)
        {
            $category = array(
                'name'  => $this->input->post('cat_name'),
                'image_path'    => $filename,
            );

            $this->db->where('category_id', $this->input->post('cat_id'));
            $result = $this->db->update('category', $category);

            return $result;
        }
        else {
            die ("You don't have permission to do this");
        }
    }
    
    
    
}