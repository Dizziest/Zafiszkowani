<?php

class UserControl extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->database();
        $this->load->library('session');
    }
    
    public function userHome($page = 'userHome'){     
        $data['title'] = 'Zafiszkowani';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menuUser',$data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data); 
    }
    
    public function make_fiszka(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('fiszka');
        $data['title'] = 'Stwórz fiszkę';
        
        $this->form_validation->set_rules('question','Pytanie', array('required', 'alpha_numeric', 'max_length[100]'));
        $this->form_validation->set_rules('answer', 'Odpowiedź', array('required', 'alpha_numeric', 'max_length[100]'));
        
        $this->form_validation->set_message('alpha_numeric', '{field}: Użyto nieprawidłowych znaków!');
        $this->form_validation->set_message('required', 'Pole {field} jest wymagane');
        $this->form_validation->set_message('max_length', 'Pole {field} musi być krótsze niż 100 znaków.');
        
        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menuUser', $data);
            $this->load->view('pages/makefiszka', $data);
            $this->load->view('templates/footer', $data);
            
        } else {
            $this->fiszka->make_fiszki();
            $this->session->set_userdata('fiszka_flag', TRUE);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menuUser', $data);
            $this->load->view('pages/makefiszka', $data);
            $this->load->view('templates/footer', $data);
        } 
    }
    
    public function show_fiszki(){
        $this->load->model('fiszka');
        $data['title'] = 'Przegląd fiszek';
        $data['fiszka_item'] = $this->fiszka->get_user_fiszki();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menuUser', $data);
        $this->load->view('pages/showfiszki', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function delete_fiszka(){
        $this->load->model('fiszka');
        $id = $this->uri->segment(3);
        
        if(empty($id)){
            show_404();
        }
        
        if($this->fiszka->delete_fiszka($id)){
            $this->session->set_userdata('delete_flag', TRUE);
            redirect(site_url('usercontrol/show_fiszki'));
        }
    }
    
    public function edit_fiszka($id){     
        $id = $this->uri->segment(3);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('fiszka');
        $data['title'] = 'Edytuj fiszke';
        $data['id'] = $id;
        
        $fiszka_obj = $this->fiszka->get_fiszka($id);
        $this->session->set_userdata('question', $fiszka_obj->question);
        $this->session->set_userdata('answer', $fiszka_obj->answer);

        $this->form_validation->set_rules('question','Pytanie', array('required', 'max_length[100]'));
        $this->form_validation->set_rules('answer', 'Odpowiedź', array('required', 'max_length[100]'));
        
        $this->form_validation->set_message('required', 'Pole {field} jest wymagane');
        $this->form_validation->set_message('max_length', 'Pole {field} musi być krótsze niż 100 znaków.');
        
        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menuUser', $data);
            $this->load->view('pages/editfiszka', $data);
            $this->load->view('templates/footer', $data);
        } else {   
            $this->fiszka->edit_fiszka($id);
            redirect(site_url('usercontrol/show_fiszki'));
        }
    }
}