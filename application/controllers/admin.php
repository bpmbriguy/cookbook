<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    var $image_path;
    
    function __construct() {
        parent::__construct();
        if(!$this->tank_auth->is_logged_in())
        {
            redirect('auth/login');
        }
        $this->load->library('form_validation');
        $this->image_path = realpath(APPPATH . '../images');
    }
    
    function index() {
        
        $this->load->model('recipe_model');
        $data['recipes'] = $this->recipe_model->getUserRecipes();
        
        $this->load->model('bookmark_model');
        $data['bookmarks'] = $this->bookmark_model->getUserBookmarks();

        
        $data['main_content'] = 'admin/dashboard';
        
        $this->load->view('includes/template', $data);
    }
    
    function recipeForm()
    {
        $this->load->model('category_model');
        $data['categories'] = $this->category_model->categoryDropdown();
        $data['main_content'] = 'admin/add_recipe';
        $data['user_select'] = $this->tank_auth->get_user_select_fullname();
        $this->load->view('includes/template', $data);
    }
    
    function add() {

        // The form was submitted
        if($this->input->post('submit'))
        {
            //set validation requirements
            $this->form_validation->set_rules('name', 'Recipe Name', 'required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('ingredients', 'Ingredients', 'required');
            $this->form_validation->set_rules('directions', 'Directions', 'required');
            $this->form_validation->set_rules('prep_time', 'Prep Time', 'numeric');
            $this->form_validation->set_rules('image_url', 'Image URL', 'file_image_url');
            
            if($this->form_validation->run() == FALSE)
            {
                // the validation didn't pass, redirect back to the form
                $this->recipeForm();
            }
            else
            {
                // validation passed - lets save it to the database
                
                $this->load->model('recipe_model');
                $recipe = $this->recipe_model->add();
                
                if($recipe)
                {
                    //Success!
                    // do we have an image to save?
                    if(!empty($_FILES) && (file_exists($_FILES['userfile']['tmp_name']) || is_uploaded_file($_FILES['userfile']['tmp_name'])))
                    {
                        $config = array(
                            'upload_path'   => $this->image_path,
                            'allowed_types' => 'gif|png|jpg|jpeg',
                            'max_size'      => 2000
                        );

                        $this->load->library('upload', $config);

                        if( !$this->upload->do_upload())
                        {
                            $data = array('error' => $this->upload->display_errors());
                            $data['main_content'] = 'admin/add_recipe';
                            $this->load->view('includes/template', $data);
                        }
                        else
                        {
                            //image was saved, insert to database
                            $image = $this->upload->data();

                            $this->load->model('image_model');
                            $this->image_model->add($recipe, $image['file_name']);
                            
                            // Create a thumbnail
                            
                            $config = array(
                                'source_image'  => $image['full_path'],
                                'new_image'     => $this->image_path . "/thumbs",
                                'maintain_ratio'    => true,
                                'width'         => 150,
                                'height'        => 150,
                                'master_dim'    => 'width',
                            );
                            
                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();
                        }
                    }
                    // End IF $_FILES
                    if($this->input->post('image_url'))
                    {

                        $ext = strtolower(pathinfo(parse_url($this->input->post('image_url'),PHP_URL_PATH),PATHINFO_EXTENSION));
                        if (in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'jpe'))){
                            // Download and save the file
                            $imagecontent = file_get_contents($this->input->post('image_url'));
                            $filename = time() . '.' . $ext;
                            file_put_contents($this->image_path."/$filename", $imagecontent);
                            
                            if(file_exists($this->image_path."$filename"))
                            {
                                //image was saved, insert to database
                                $this->load->model('image_model');
                                $this->image_model->add($recipe, $filename);

                                // Create a thumbnail

                                $config = array(
                                    'source_image'  => $this->image_path."/$filename",
                                    'new_image'     => $this->image_path . "/thumbs",
                                    'maintain_ratio'    => true,
                                    'width'         => 150,
                                    'height'        => 150,
                                    'master_dim'    => 'width',
                                );

                                $this->load->library('image_lib', $config);
                                $this->image_lib->resize();
                            }
                            
                            
                        } else {
                            // NOT A file type we want to save!
                        }
                       
                    }
                    
                    $data['main_content'] = 'admin/add_recipe_success';
                    $data['new_recipe_id'] = $recipe;

                    $this->load->view('includes/template', $data);
                } else {
                    // Something went wrong :-(
                    
                }
            }
            
            
        } else
        {
            $this->recipeForm();
        }
        
        
        
    }
    
    function edit($recipe_id = null) {
        
        if(!is_numeric($recipe_id))
        {

            redirect('admin/mybook');
            
        }
        else
        {
            if($this->input->post('submit'))
            {
                //set validation requirements
                $this->form_validation->set_rules('name', 'Recipe Name', 'required|min_length[3]|max_length[45]');
                $this->form_validation->set_rules('ingredients', 'Ingredients', 'required');
                $this->form_validation->set_rules('directions', 'Directions', 'required');
                $this->form_validation->set_rules('prep_time', 'Prep Time', 'numeric');
                $this->form_validation->set_rules('image_url', 'Image URL', 'file_image_url');

                if($this->form_validation->run() == FALSE)
                {
                    // the validation didn't pass, redirect to back to the form
                    $data['recipe'] = (object) array(
                        'name'  => $this->input->post('name'),
                        'ingredients'   => $this->input->post('ingredients'),
                        'directions'    => $this->input->post('directions'),
                        'prep_time'     => $this->input->post('prep_time'),
                        'recipe_id'      => $this->input->post('recipe_id'),
                        'category_category_id'  => $this->input->post('category')
                    );
                            
                    $this->load->model('category_model');
                    $data['categories'] = $this->category_model->categoryDropdown();

                    $data['main_content'] = 'admin/edit_recipe';
                    $this->load->view('includes/template', $data);
                }
                else
                {
                    // validation passed - lets update the database

                    $this->load->model('recipe_model');
                    $recipe = $this->recipe_model->update();
                    if($recipe)
                    {
                        //Success!
                        // do we have an image to save?
                        if(!empty($_FILES) && (file_exists($_FILES['userfile']['tmp_name']) || is_uploaded_file($_FILES['userfile']['tmp_name'])))
                        {
                            $config = array(
                                'upload_path'   => $this->image_path,
                                'allowed_types' => 'gif|png|jpg|jpeg',
                                'max_size'      => 2000
                            );

                            $this->load->library('upload', $config);

                            if( !$this->upload->do_upload())
                            {
                                $data = array('error' => $this->upload->display_errors());
                                $data['main_content'] = 'admin/add_recipe';
                                $this->load->view('includes/template', $data);
                            }
                            else
                            {
                                //image was saved, insert to database
                                $image = $this->upload->data();

                                $this->load->model('image_model');
                                $this->image_model->add($recipe_id, $image['file_name']);

                                // Create a thumbnail

                                $config = array(
                                    'source_image'  => $image['full_path'],
                                    'new_image'     => $this->image_path . "/thumbs",
                                    'maintain_ratio'    => true,
                                    'width'         => 150,
                                    'height'        => 150,
                                    'master_dim'    => 'width',
                                );

                                $this->load->library('image_lib', $config);
                                $this->image_lib->resize();
                            }
                        }
                        // End IF $_FILES
                        if($this->input->post('image_url'))
                        {

                            $ext = strtolower(pathinfo(parse_url($this->input->post('image_url'),PHP_URL_PATH),PATHINFO_EXTENSION));
                            if (in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'jpe'))){
                                // Download and save the file
                                $imagecontent = file_get_contents($this->input->post('image_url'));
                                $filename = time() . '.' . $ext;
                                file_put_contents($this->image_path."/$filename", $imagecontent);

                                if(file_exists($this->image_path."/$filename"))
                                {
                                    //image was saved, insert to database
                                    $this->load->model('image_model');
                                    $this->image_model->add($recipe_id, $filename);

                                    // Create a thumbnail

                                    $config = array(
                                        'source_image'  => $this->image_path."/$filename",
                                        'new_image'     => $this->image_path . "/thumbs",
                                        'maintain_ratio'    => true,
                                        'width'         => 150,
                                        'height'        => 150,
                                        'master_dim'    => 'width',
                                    );

                                    $this->load->library('image_lib', $config);
                                    $this->image_lib->resize();
                                }


                            } else {
                                // NOT A file type we want to save!
                            }

                        }

                        $data['main_content'] = 'admin/edit_recipe_success';
                        $data['new_recipe_id'] = $recipe_id;

                        $this->load->view('includes/template', $data);
                    } else {
                        // Something went wrong :-(

                    }
                
                }
  
            }
            else 
            {
                $this->load->model('recipe_model');

                $recipe = $this->recipe_model->getRecipeByID($recipe_id);
                $data['recipe'] = $recipe[0];
                
                $this->load->model('category_model');
                $data['categories'] = $this->category_model->categoryDropdown();
                $data['user_select'] = $this->tank_auth->get_user_select_fullname();

                $data['main_content'] = 'admin/edit_recipe';
                $this->load->view('includes/template', $data);
            }
        }
        
        
    }
    
    function delete() {
        
    }
    
    function mybook()
    {
        $this->load->model('recipe_model');
        
        $data['recipes'] = $this->recipe_model->getUserRecipes();
        
        $this->load->model('bookmark_model');
        
        $data['bookmarks'] = $this->bookmark_model->getUserBookmarks();
        
        $data['main_content'] = 'admin/mybook';
        
        $this->load->view('includes/template', $data);
    }
    
    function categories()
    {
        $this->load->model('category_model');
        
        $data['categories'] = $this->category_model->getAll();
        $data['main_content'] = 'admin/categories';
        
        $this->load->view('includes/template', $data);
    }
    
    function update_category()
    {
        $this->load->model('category_model');
            if(isset($_FILES))
            {
                $config = array(
                    'upload_path'   => $this->image_path ."/category",
                    'allowed_types' => 'gif|png|jpg|jpeg',
                    'max_size'      => 5000,
                    'overwrite'     => true,
                );

                $this->load->library('upload', $config);

                if( !$this->upload->do_upload())
                {
                    echo $this->upload->display_errors();
                }
                else
                {
                    //image was saved, insert to database
                    $image = $this->upload->data();


                    // Create a thumbnail

                    $config = array(
                        'source_image'  => $image['full_path'],
                        'new_image'     => $this->image_path . "/category/thumbs",
                        'maintain_ratio'    => false,
                        'width'         => 200,
                        'height'        => 150,
                    );

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    
                    /*
                    $this->image_lib->clear();
                    
                    $config = array(
                        'source_image'     => $this->image_path . "/category/thumbs/". $image['file_name'],
                        'wm_type'          => 'wm_text',
                        'wm_text'           => $this->input->post('cat_name'),
                        'wm_hor_alignment'  => 'left',
                        'wm_vet_alignment'  => 'bottom',
                        'wm_shadow_color'   => 'B8B8B8',
                        'wm_font_color'     => '000000',
                    );
                    
                    $this->image_lib->initialize($config);
                    $this->image_lib->watermark();
                    */
                    
                    $this->category_model->update($image['file_name']);
                    
                    redirect('admin/categories');
                }
            }
            else
            {
                $this->category_model->update();
            }

    }
    

}