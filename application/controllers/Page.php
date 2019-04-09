<?php

class Page extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->database();
        $this->load->library('session');
    }

    

    public function home($page = 'home'){
         if($this->session->userdata('userId') != NULL){
            redirect(site_url('usercontrol/userHome'));
        }
        
        $data['title'] = 'Strona główna';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu',$data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data); 
    }
    
    public function register(){
         if($this->session->userdata('userId') != NULL){
            redirect(site_url('usercontrol/userHome'));
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('registration');
        $data['title'] = 'Rejestracja';
        
        $this->form_validation->set_rules('login', 'Login', 'required|is_unique[users.login]|max_length[25]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Hasło', array('required','min_length[5]','alpha_numeric' ));
        $this->form_validation->set_rules('email', 'E-mail', array('required', 'valid_email', 'is_unique[users.email]' ));
        
        $this->form_validation->set_message('required', 'Pole {field} jest wymagane');
        $this->form_validation->set_message('is_unique', '{field} jest już zajęty.');
        $this->form_validation->set_message('max_length', 'Login musi być krótszy niż 20 znaków.');
        $this->form_validation->set_message('min_length', 'Hasło musi składać się przynajmniej z 6 znaków.');
        $this->form_validation->set_message('alpha_numeric', '{field}: Użyto nieprawidłowych znaków!');
        
        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('pages/register', $data);
            $this->load->view('templates/footer', $data);
        
        } else {
            $this->registration->register();
            $this->load->view('templates/header',$data);
            $this->load->view('templates/menu', $data);
            $this->load->view('pages/registerOK', $data);
            $this->load->view('templates/footer', $data);
        }
    }
    
    public function login(){
        if($this->session->userdata('userId') != NULL){
            redirect(site_url('usercontrol/userHome'));
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Logowanie';
        
        $this->form_validation->set_rules('login','Login','required|callback_verify_user');
        $this->form_validation->set_rules('password','Hasło','required');
        
        $this->form_validation->set_message('verify_user','Login lub hasło nieprawidłowe, spróbuj ponownie.');
        
        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('pages/login', $data);
            $this->load->view('templates/footer', $data);
            
        } else {
            $login = $this->input->post('login');
            $sessId = session_id();
            $this->session->set_userdata('login', $login);
            
            $query = $this->db->query("SELECT id from users where login='".$login."'");
            $row=$query->row();
            $userId=$row->id;
            $this->session->set_userdata('userId', $userId);
            
            $this->db->set('sessionId', $sessId);
            $this->db->set('login', $login);
            $this->db->insert('logged_in_users');
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menuUser', $data);
            $this->load->view('pages/userHome', $data);
            $this->load->view('templates/footer', $data);  
        }
    }
    
    public function verify_user($login){
        $query=$this->db->query("SELECT login, password from users where login='".$login."'");
        $row=$query->row();
        if(EMPTY($row)){
            return FALSE;
        }
        else{
            if(password_verify($this->input->post('password'), $row->password)){
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
    
    public function logout(){
        $this->db->query("DELETE from logged_in_users where sessionId ='".session_id()."'");
        $this->session->sess_destroy();
        
        $data['title'] = 'Wylogowano';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('pages/loggedOut', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
}