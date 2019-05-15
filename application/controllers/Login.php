<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');  
    }

     public function index()
    {
        if($this->isLoggedIn()){
            if($this->session->userdata("tipe_sess")=="SUBSIDIARY"){
                //echo json_encode($this->session->userdata());die;
                redirect(base_url().'bast');
            }
            redirect(base_url());
        };  
        // $this->load->view('page_login');
        $this->load->view('page_login2');
    }


    public function test()
    {
        if($this->isLoggedIn()){
            if($this->session->userdata("tipe_sess")=="SUBSIDIARY"){
                //echo json_encode($this->session->userdata());die;
                redirect(base_url().'bast');
            }
            redirect(base_url());
        };  
        $this->load->view('page_login2');
    }
    
    function login_proccess(){
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $nik        = $this->security->xss_clean($this->input->post('nik'));
            $password   = $this->security->xss_clean($this->input->post('password'));

                $check_login = $this->Login_model->validate_login($nik,$password); 
                if ($check_login) {
                    if($this->session->userdata('validated')==false){
                        $this->session->set_flashdata('alError', $this->alert('alert-danger','Maaf ID anda tidak valid'));
                    }else{
                        $this->addLog($this->session->userdata('nik_sess'),'Log In','AUTH');
                        if($this->session->userdata("tipe_sess")=="SUBSIDIARY"){
                            $this->Login_model->set_session_mitra($this->session->userdata("mitra"));
                        }
                       // echo $this->db->last_query();die;
                    }

                }else{
                    $this->session->set_flashdata('alError', $this->alert('alert-danger','Maaf NIK atau Password Salah'));
                }
        }else{
            $this->session->set_flashdata('alError', $this->alert('alert-danger','Mohon lengkapi inputan data'));  
        }

        //echo json_encode($this->session->userdata());die();
        redirect(base_url().'login');
    }


    function log_out(){
        $this->session->sess_destroy();
        $this->auth->doLogout();
        echo json_encode($this->session->userdata());
        $this->addLog($this->session->userdata('nik_sess'),'Log Out','AUTH');
        redirect(base_url());
    }


}

?>