<?php

class Registration extends CI_Model{
    public function __construct() {
        $this->load->database();
    }
    
    public function register(){
          $date = (new DateTime())->format('Y-m-d\TH:i:s');
          $RegistrationData = array(
          'id' => NULL,
          'login' => $this->input->post('login'),
          'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
          'email' => $this->input->post('email'),
          'data' => $date
        );
        return $this->db->insert('users', $RegistrationData);
    }
}

