<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
    
    function index() {
        $data['main_content'] = 'home';
        $data['pageid'] = 'page1';
        $this->load->view('includes/template', $data);
    }
}