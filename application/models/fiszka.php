<?php
class Fiszka extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function make_fiszki($id = NULL){
            $question = $this->input->post('question');
            $answer = $this->input->post('answer');
            $array = array('id' => $id, 
                                   'users_id' => $this->session->userdata('userId'),
                                   'question' => $question,
                                   'answer' => $answer
                              );
            
            if($id == NULL){
                   return $this->db->insert('fiszki', $array);
            } 
    }
    
    public function get_fiszka($id){
        $query = $this->db->get_where('fiszki', array('id' => $id));
        if($query->num_rows() > 0){
            return $query->custom_row_object(0, 'fiszka'); 
        } else {
            return false;
        }
    }

    public function get_user_fiszki(){
        $query = $this->db->query("SELECT * from fiszki where users_id = ".$this->session->userdata('userId'));
        return $query->custom_result_object('fiszka');
     }
     
     public function delete_fiszka($id){
         $this->db->where('id', $id);
         return $this->db->delete('fiszki'); 
     }
     
     public function edit_fiszka($id = NULL){
         $array = array(
             'question' => $this->input->post('question'),
             'answer' => $this->input->post('answer')
         );
         
         $this->db->set($array);
         $this->db->where('id', $id);
         $this->db->update('fiszki');
     }
     
     
}
