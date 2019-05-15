<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Email_model');
        $this->load->model('Utility_model');
        $this->load->model('Bast_model');
    }

     public function index(){
        echo "500";
    }
 
    //BAST MITRA NOTIFICATION 
    function send_email_daily_bast() {
    
        $tdata['nama_mitra']   = $this->Email_model->getDataNotifMitra();
        foreach($tdata['nama_mitra'] as $key => $value){
            $data['id_mitra']    = $value['ID_MITRA'];
            $data['nama_mitra']  = $value['NAMA_MITRA'];
            $data['email_mitra'] = $this->Email_model->getDataEmailMitra($data['id_mitra']);
            $data['email_mitra_def'] = $this->Email_model->getDataEmailMitraDef($data['id_mitra']);
            $data['email_mitra_done'] = $this->Email_model->getDataEmailMitraDone($data['id_mitra']);
            $data['bast']        = $this->Email_model->getDataBastMitra($data['id_mitra']);
            $data['bast_done']   = $this->Email_model->getDataBastMitraDone($data['id_mitra']);
            $recepient = array();
            $rec = array();

            if(count($data['email_mitra'])!='0' && count($data['email_mitra_done'])!='0' ){
                $exist = true;
                for($a = 0;$a<count($data['email_mitra']);$a++){
                    for($b = 0;$b<count($data['email_mitra_done']);$b++){
                        $rec[$b] =  $data['email_mitra_done'][$b]['EMAIL_MITRA'];
                        if($data['email_mitra'][$a]['EMAIL_MITRA']==$data['email_mitra_done'][$b]['EMAIL_MITRA']){
                            $exist = true;
                        }else{
                            $exist = false;
                        }
                    }
                    if($exist==false){array_push($recepient, $data['email_mitra'][$a]['EMAIL_MITRA']);}
                }
                $recepient = array_merge($recepient, $rec);
            }
            else if(count($data['email_mitra_done'])!='0'){
                for($z = 0;$z<count($data['email_mitra_done']);$z++){
                $recepient[$z] = $data['email_mitra_done'][$z]['EMAIL_MITRA'];  
                }
            }   
            else{
                if(count($data['email_mitra'])!='0'){
                    for($z = 0;$z<count($data['email_mitra']);$z++){
                    $recepient[$z] = $data['email_mitra'][$z]['EMAIL_MITRA'];   
                    }
                }
            }
            

            if(!empty($data['email_mitra_def'])){
                $data['email_mitra_def'] = explode(';', $data['email_mitra_def'][0]['EMAIL_PARTNER']);
                if($data['email_mitra_def'][0]!=''){
                    
                    $recepient = array_merge($recepient,$data['email_mitra_def']);
                }
            }       

            if((count($recepient)!= '0') && (count($data['bast']) + count($data['bast_done'])!= '0')){

                    $config['protocol']  = "smtp";
                    $config['smtp_host'] = "smtp.telkom.co.id";
                    $config['smtp_user'] = "401820"; 
                    $config['smtp_pass'] = "Unstoppable1212";
                    $config['smtp_port'] = 25;
                    $config['smtp_timeout'] = 30;
                    $config['mailtype'] = 'html';

                    $this->load->library('email', $config);

                    $this->email->initialize($config);
                    $this->email->from('prime@telkom.co.id','Admin Prime Apps');
                    
                    /*$this->email->to('haginmail@gmail.com');  
                    $this->email->bcc('haginmail@gmail.com');*/
                    $this->email->to($recepient);   
                    $this->email->bcc('rfauzi@telkom.co.id, lailynurmalasari@gmail.com, haginmail@gmail.com, uusahmad33@gmail.com, fiandipta.apsari@gmail.com');
                    $this->email->set_newline("\r\n");

                    $this->email->subject('Daily Notification BAST '.$data['nama_mitra']);
                    $this->email->message($this->load->view('email/email_notif_bast', $data, true));           
                    
                    if(!$this->email->send()){
                        echo 'email gagal terkirim';
                        echo $data['nama_mitra'].'  '.json_encode($recepient).'<br>';   
                        $this->Email_model->addLog_emailBAST($data['id_mitra'],$data['nama_mitra'],'FAILED',substr($this->email->print_debugger(), 1, 2500));
                    }else{
                        $this->Email_model->addLog_emailBAST($data['id_mitra'],$data['nama_mitra'],'SUCCESS');
                    }
                    $this->load->view('email/email_notif_bast', $data);  
            }       
        }
    }


}

?>