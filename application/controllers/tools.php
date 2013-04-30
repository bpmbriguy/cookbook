<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if(!$this->tank_auth->is_logged_in())
        {
            redirect('auth/login');
        }
    }
    
    function index()
    {
        redirect('auth/login');
    }
    
    function email_recipe($recipe_id = null)
    {
        if($this->input->post('submit') && !is_null($recipe_id))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
            
            if($this->form_validation->run() == FALSE)
            {
                // the validation didn't pass, redirect back to the form
                $this->load->view('tools/email_recipe_form');
            }
            else
            {
                // load the recipe
                $this->load->model('recipe_model');
                
                $data['recipes'] = $this->recipe_model->getRecipeByID($recipe_id);
                
                
                // email the recipe
                $this->load->library('email');

                $this->email->from('noreply@mccormickcookbook.com', 'McCormick Cookbook');
                $this->email->to($this->input->post('email'));
                
                $subject = $this->tank_auth->get_fullname() .
                        " sent you a recipe!";
                $this->email->subject($subject);
                
                $data['subject'] = $subject;
                
                $this->email->message($this->load->view('email/send-recipe-html', $data, TRUE));
                $this->email->set_alt_message($this->load->view('email/send-recipe-txt', $data, TRUE));

                if ($this->email->send() )
                {
                    echo "Message successfully sent!";
                }
                else
                {
                    echo "Oops, there was a problem sending your message. Please try again later";
                }
                
                
            }
        }
        else
        {
            $this->load->view('tools/email_recipe_form');
        }
    }
    
    function bookmark_recipe()
    {
        $this->load->model('bookmark_model');
        $this->bookmark_model->addBookmark();
        
        $data['message'] = "Recipe added to My Cookbook";
        $this->load->view('tools/tinybox_message', $data);
    }
    
    function unbookmark_recipe()
    {
        $this->load->model('bookmark_model');
        $this->bookmark_model->deleteBookmark();
        
        $data['message'] = "Recipe removed from My Cookbook";
        $this->load->view('tools/tinybox_message', $data);
    }
}