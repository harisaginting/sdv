<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utility_model');
        $this->load->model('Bast_model');
        $this->load->model('Master_model');
        if(!$this->isLoggedIn()){
            redirect(base_url().'login');  
            die;
        };  
    }

     public function index(){ 
        echo "500";
    }

    function tools(){
        $data['title'] = 'Tools';
        $this->myView('utility/tools',$data);
    }

    function cron_email_bastParter(){
        $data['title'] = 'Cron Email BAST Partner';
        $this->myView('utility/cron_email_bastParter',$data);
    }
 
    function testApi(){
        $id='LOP101554';
        $data = $this->Utility_model->testApi($id);

        echo $this->db->last_query().'<br><br><br><br>'.json_encode($data);
    }

    public function domes_bast(){
        $data['title'] = 'BAST Edit';
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('utility/domes_bast',$data);           
    } 
 
    public function domes_bast_view($id_bast){
        $data['title'] = 'BAST Edit';
        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();
        $data['list_partner']  = $this->get_list_mitra();

        $data['history']       = $this->Bast_model->getDataHistory($id_bast);

        $data['id_bast']       = $id_bast;
        $data['bast']          = $this->Bast_model->getDataBast($id_bast);
        $data['evidence'] = @explode(',',$data['bast']['KELENGKAPAN_DELIVERY']);
        $this->myView('utility/domes_bast_view',$data);           
    } 

    function get_datatables_bast_domes(){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $status     = $this->input->post('status');
        $mitra      = $this->input->post('mitra');
        $segmen     = $this->input->post('segmen');
        $customer   = $this->input->post('customer');
        $spk        = $this->input->post('spk');
       
        $model = $this->Utility_model->get_datatables_bast_domes($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$mitra,$segmen,$customer,$spk);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Utility_model->count_all_bast_domes($status,$mitra,$segmen,$customer,$spk),
            "recordsFiltered" => $this->Utility_model->count_filtered_bast_domes($searchValue, $orderColumn, $orderDir, $order,$status,$mitra,$segmen,$customer,$spk),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function edit_bast_domes(){
        $id_bast                = $this->input->post('id_bast');
        $data['NIPNAS']         = $this->input->post('customer_id');
        $data['NAMACC']         = $this->input->post('customer_name');
        $data['SEGMENT']        = $this->input->post('segmen');
        $data['ID_MITRA']       = $this->input->post('partner_id');
        $data['NAMA_MITRA']     = $this->input->post('partner_name');
        $data['NO_SPK']         = $this->input->post('spk');
        $data['TGL_SPK']        = $this->input->post('spk_date');
        $data['PROJECT_NAME']   = $this->input->post('project_name');
        $data['NILAI_PEKERJAAN']= $this->input->post('value');
        $data['NO_KL']          = $this->input->post('kl');
        $data['TGL_KL']         = $this->input->post('kl_date');
        $data['TYPE_BAST']      = $this->input->post('type_bast');
        $data['TGL_BAST']       = $this->input->post('bast_date');
        $data['NILAI_RP_BAST']  = $this->input->post('bast_value');
        $data['RECC_START_DATE']= $this->input->post('recc_start_date');
        $data['RECC_END_DATE']  = $this->input->post('recc_end_date');
        $data['PENANDA_TANGAN'] = $this->input->post('signer');
        $data['NIK_PM']         = $this->input->post('pm');
        $data['NAMA_PM']        = $this->input->post('pm_name');
        $data['PIC_MITRA']      = $this->input->post('pic_partner');
        $data['EMAIL_MITRA']    = $this->input->post('email_pic_partner2');
        $data['KELENGKAPAN_DELIVERY']   = $this->input->post('evidence');   
        $data['PROGRESS_LAPANGAN']  = $this->input->post('progress_actual');
        $data['NAMA_TERMIN']        = $this->input->post('termin');
        $data['ID_PROJECT']         = $this->input->post('id_project');
        $data['LAST_EDITED_BY']     =   $data_history['BY_USER']    =  $this->session->userdata('nik_sess')."|||".$this->session->userdata('nama_sess');
        if($data['TYPE_BAST']=='OTC'){$data['PROGRESS_LAPANGAN'] = '100';}

        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }

        if($this->Bast_model->edit_bast($data,$id_bast)){
            $this->addLog($this->session->userdata('nik_sess'),"EDIT BAST",'BAST',json_encode($data));
            $result['data']     = "success";
        }
         $result['id_bast']  = $id_bast;
        echo json_encode($result);
    }


##IMPORT FUNCTION
    function import_bast_fail(){
        $file = fopen('bast_salah.csv', "r");

        $count = 0;       
       ini_set('auto_detect_line_endings',TRUE);
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
           if($this->Utility_model->bast_fail($emapData[0])){
            echo $emapData[0].' success';
           };            
        }
        ini_set('auto_detect_line_endings',FALSE);
    }

    function import_fix_nipnas(){
        $file = fopen('nipnas.csv', "r");

        $count = 0;       
        ini_set('auto_detect_line_endings',TRUE);

        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
          if($this->Utility_model->update_nipnas_bast($emapData)){
            echo $emapData[0].' success<br><br>';
           };      
        }
        ini_set('auto_detect_line_endings',FALSE);
    }


    function import_fix_spk(){
        $file = fopen('spk_fix.csv', "r");

        $count = 0;       
        ini_set('auto_detect_line_endings',TRUE);

        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {

            //echo json_encode($emapData)."<br><br>";
          if($this->Utility_model->update_spk_bast($emapData)){
            echo $emapData[1].' success<br><br>';
           };      
        }
        ini_set('auto_detect_line_endings',FALSE);
    }

// CHECK STATUS BAST IN DOMES
    /*function get_json_spk_bast(){
            $q = $this->input->post('q');
            
            $nipnas = $this->input->post('customer');
            $partner = $this->input->post('partner');
            $bast_date = explode('/', $this->input->post('bast_date'));

            if($this->input->post('partner')){
                $partner = $this->input->get('id');
            }

            $spkPrime   = $this->Master_model->get_list_spk_bast($q,$nipnas,$partner);

            if(!empty($bast_date[2])){
            $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?NIPNAS=".$nipnas."&IDMITRA=".$partner."&TAHUN=".$bast_date[2];
            }else{
            $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?NIPNAS=".$nipnas."&IDMITRA=".$partner."&TAHUN=2017";    
            }
             $spkNumero  = json_decode($this->getCurl($url), TRUE); 
    }*/



    ##VALIDATE WFM
    function validate_wfm($id_lop = null){
        $data['title']  = 'Validation WFM';
        $data['no_p8'] = $id_lop;
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('utility/validate_wfm',$data);

    }


    // EXECUTE PROCEDURE
    function execute_procedure_updateStatus(){
        if($this->Utility_model->execute_procedure_updateStatus()){
            $this->session->set_flashdata('notif', $this->alert('alert-success','procedure PRIME_UPDATE_STATUS_PROC has been updated'));
            redirect(base_url().'utility/tools');
        }
    }


    function execute_procedure_updateMonitoring(){
        if($this->Utility_model->execute_procedure_updateMonitoring()){
            $this->session->set_flashdata('notif', $this->alert('alert-success','procedure PRIME_MONITORING_PROJECT_PROC has been updated'));
            redirect(base_url().'utility/tools');
        }
    }


    function execute_procedure_updateSCurve(){
        if($this->Utility_model->execute_procedure_updateSCurve()){
            $this->session->set_flashdata('notif', $this->alert('alert-success','procedure PRIME_UPDATE_S_CURVE_DAILY_PROC has been updated'));
            redirect(base_url().'utility/tools');
        }
    }


    function get_list_history_cron_partner(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;

        $dateHappen     = $this->input->post('dateHappen');

        $model = $this->Utility_model->get_datatablesCronPartner($length, $start, $searchValue, $orderColumn, $orderDir, $order,$dateHappen);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Utility_model->count_allCronPartner($dateHappen),
            "recordsFiltered" => $this->Utility_model->count_filteredCronPartner($searchValue, $orderColumn, $orderDir, $order,$dateHappen),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function download_validation_wfm(){ 
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Utility_model->download_validation_wfm();
        //echo $this->db->last_query();die;
        //echo count($data);die;
        //echo json_encode($data);die;
        $name = 'Validation WFM'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name 
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'VALID', 'id'              => 'VALID', 'width' => 10)
            ,array('name' => 'ID PROJECT', 'id'         => 'ID_PRO', 'width' => 10)
            ,array('name' => 'ID LOP', 'id'             => 'ID_LOP_EPIC', 'width' => 10)
            ,array('name' => 'NO_P8', 'id'              => 'NO_P8', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id'       => 'NAME', 'width' => 120)
            ,array('name' => 'SEGMEN', 'id'             => 'SEGMEN', 'width' => 10)
            ,array('name' => 'NOMOR QUOTE', 'id'        => 'NO_QUOTE', 'width' => 10)
            ,array('name' => 'NOMOR SO', 'id'           => 'NO_SO', 'width' => 10)
            ,array('name' => 'UPDATED BY ID', 'id'      => 'UPDATED_BY_ID', 'width' => 10)
            ,array('name' => 'UPDATED BY NAME', 'id'    => 'UPDATED_BY_NAME', 'width' => 10)
            
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL); 

    } 

    
    function get_all_spk_numero(){
        $string =  'get all spk from numero '.date(' d-m-Y').'<br>';
        $partner = $this->Master_model->get_all_partner();
        foreach ($partner as $key => $value) {
            // $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?&IDMITRA=".$partner[$key]['KODE_PARTNER'];  
            $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?&IDMITRA=".$partner[$key]['KODE_PARTNER'];  
            $data       = json_decode($this->getCurl($url));

            if(!empty($data)){
              foreach ($data as $key => $value) {
                $check = $this->Master_model->check_spk_numero_exist($data[$key]->NoSPKSPWO);
                    if(empty($check)){
                        if(empty($data[$key]->TanggalP8->date)){
                            $d = "2017-01-01"; 
                        }else{
                            $d = $data[$key]->TanggalP8->date;
                        }
                        $date = explode(' ', $d);
                        if($this->Master_model->save_spk_numero($data[$key],$date[0])){
                            $string = $string.' '.$data[$key]->NoSPKSPWO."<br>";
                        };
                    }
                }
            }  
            
        }
        $this->session->set_flashdata('notif', $this->alert('alert-success',$string.'GET ALL SPK FROM NUMERO HAS BEEN GATHERED'));
            redirect(base_url().'utility/tools');
    }

    //ADD ID_LOP
    function get_all_spk_numero1(){
        $string =  'get all spk from numero '.date(' d-m-Y').'<br>';
        $partner = $this->Master_model->get_all_partner();
        foreach ($partner as $key => $value) {
            // $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?&IDMITRA=".$partner[$key]['KODE_PARTNER'];  
            $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?&IDMITRA=".$partner[$key]['KODE_PARTNER'];  
            $data       = json_decode($this->getCurl($url));

            if(!empty($data)){
              foreach ($data as $key => $value) {
                 if(empty($data[$key]->TanggalP8->date)){
                            $d = "2017-01-01"; 
                        }else{
                            $d = $data[$key]->TanggalP8->date;
                        }
                        $date = explode(' ', $d);
                        if($this->Master_model->save_spk_numero_lop($data[$key],$date[0])){
                            $string = $string.' '.$data[$key]->NoSPKSPWO."<br>";
                        };
                }
            }  
            
        }
        $this->session->set_flashdata('notif', $this->alert('alert-success',$string.'GET ALL SPK FROM NUMERO HAS BEEN GATHERED'));
            redirect(base_url().'utility/tools');
    }


    function get_all_p71_numero(){
        $string =  'get all p7 from numero '.date(' d-m-Y').'<br>';
        $partner = $this->Master_model->get_all_partner();
        foreach ($partner as $key => $value) {
            // $url        = "http://numero.telkom.co.id/jsonapi/SPKPRIME.php?&IDMITRA=".$partner[$key]['KODE_PARTNER'];  
            $url        = "http://numero.telkom.co.id/JSONAPI/P71.php?IDMITRA=".$partner[$key]['KODE_PARTNER'];  
            $data       = json_decode($this->getCurl($url));

            if(!empty($data)){
              foreach ($data as $key => $value) {
                $check = $this->Master_model->check_p71_numero_exist($data[$key]->NomorOBL);
                    if(empty($check)){
                        if(empty($data[$key]->TanggalP8->date)){
                            $d = "2017-01-01";
                        }else{
                            $d = $data[$key]->TanggalP8->date;
                        }
                        $date = explode(' ', $d);
                        if($this->Master_model->save_p71_numero($data[$key],$date[0])){
                            $string = $string.' '.$data[$key]->NomorOBL."<br>";
                        };
                    }
                }
            }  
            
        }

        $this->session->set_flashdata('notif', $this->alert('alert-success',$string.'GET ALL P71 FROM NUMERO HAS BEEN GATHERED'));
            redirect(base_url().'utility/tools');
    }


    function sendEmailPartner($id_mitra){
        $tdata['nama_mitra']   = $this->Utility_model->getDataNotifMitra($id_mitra);
        if(empty($tdata['nama_mitra'])){
            echo "notif : No Data BAST Found to be notice for this Partnner!";
        }
        foreach($tdata['nama_mitra'] as $key => $value){
            $data['id_mitra']    = $value['ID_MITRA'];
            $data['nama_mitra']  = $value['NAMA_MITRA'];
            $data['email_mitra'] = $this->Utility_model->getDataEmailMitra($data['id_mitra']);
            $data['email_mitra_def'] = $this->Utility_model->getDataEmailMitraDef($data['id_mitra']);
            $data['email_mitra_done'] = $this->Utility_model->getDataEmailMitraDone($data['id_mitra']);
            $data['bast']        = $this->Utility_model->getDataBastMitra($data['id_mitra']);
            $data['bast_done']   = $this->Utility_model->getDataBastMitraDone($data['id_mitra']);
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

                    $this->load->library('email', $config);

                    $this->email->initialize($config);
                    $this->email->from('prime@telkom.co.id','Admin Prime Apps');
                    
                    /*$this->email->to('haginmail@gmail.com');  
                    $this->email->bcc('haginmail@gmail.com');*/
                    $this->email->to($recepient);   
                    $this->email->bcc('rfauzi@telkom.co.id, lailynurmalasari@gmail.com, haginmail@gmail.com, fiandipta.apsari@gmail.com, nantania18@gmail.com');
                    $this->email->set_newline("\r\n");

                    $this->email->subject('Daily Notification BAST '.$data['nama_mitra']);
                    $this->email->message($this->load->view('utility/email-notif', $data, true));           
                    
                    if(!$this->email->send()){
                        echo 'email gagal terkirim';
                        echo $data['nama_mitra'].'  '.json_encode($recepient).'<br>';   
                        $this->Utility_model->addLog_emailBAST($data['id_mitra'],$data['nama_mitra'],'FAILED',substr($this->email->print_debugger(), 1, 2500));;
                    }else{
                        $this->Utility_model->addLog_emailBAST($data['id_mitra'],$data['nama_mitra'],'SUCCESS');
                    }
                    
                    $this->load->view('utility/email-notif', $data /*, true*/);  
            }       
        }
    }






    // CRON EMAIL
    //BAST MITRA NOTIFICATION 
    function send_email_daily_bast() {
    
        $tdata['nama_mitra']   = $this->Utility_model->getDataNotifMitra();

        foreach($tdata['nama_mitra'] as $key => $value){
            $data['id_mitra']    = $value['ID_MITRA'];
            $data['nama_mitra']  = $value['NAMA_MITRA'];
            $data['email_mitra'] = $this->Utility_model->getDataEmailMitra($data['id_mitra']);
            $data['email_mitra_def'] = $this->Utility_model->getDataEmailMitraDef($data['id_mitra']);
            $data['email_mitra_done'] = $this->Utility_model->getDataEmailMitraDone($data['id_mitra']);
            $data['bast']        = $this->Utility_model->getDataBastMitra($data['id_mitra']);
            $data['bast_done']   = $this->Utility_model->getDataBastMitraDone($data['id_mitra']);
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

                    $this->load->library('email', $config);

                    $this->email->initialize($config);
                    $this->email->from('prime@telkom.co.id','Admin Prime Apps');
                    
                    /*$this->email->to('haginmail@gmail.com');  
                    $this->email->bcc('haginmail@gmail.com');*/
                    $this->email->to($recepient);   
                    $this->email->bcc('rfauzi@telkom.co.id, lailynurmalasari@gmail.com, haginmail@gmail.com, fiandipta.apsari@gmail.com, nantania18@gmail.com');
                    $this->email->set_newline("\r\n");

                    $this->email->subject('Daily Notification BAST '.$data['nama_mitra']);
                    $this->email->message($this->load->view('email-notif', $data, true));           
                    
                    if(!$this->email->send()){
                        echo 'email gagal terkirim';
                        echo $data['nama_mitra'].'  '.json_encode($recepient).'<br>';   
                        $this->Utility_model->addLog_emailBAST($data['id_mitra'],$data['nama_mitra'],'FAILED',substr($this->email->print_debugger(), 1, 2500));
                    //die();
                    }else{
                        $this->Utility_model->addLog_emailBAST($data['id_mitra'],$data['nama_mitra'],'SUCCESS');
                    }
                    
                    $this->email->message($this->load->view('email-notif', $data /*, true*/));  
            }       
        }
    }

    function send_email_daily_bast_pnd() {
    
        $tdata['nama_mitra']   = $this->Utility_model->getDataNotifMitra();
        $data['bast']        = $this->Utility_model->getDataBastMitraPnd();
        $data['bast_done']       = $this->Utility_model->getDataBastMitraDonePnd();

            $config['protocol']  = "smtp";
            $config['smtp_host'] = "smtp.telkom.co.id";
            $config['smtp_user'] = "401820"; 
            $config['smtp_pass'] = "Unstoppable1212";

            $this->load->library('email', $config);

            $this->email->initialize($config);
            $this->email->from('prime@telkom.co.id','Admin Prime Apps');
            $this->email->to('rfauzi@telkom.co.id');    
            $this->email->bcc('sosrohk@gmail.com, haginmail@gmail.com, nandang@telkom.co.id, hid@telkom.co.id, sosro@telkom.co.id,retnoku@telkom.co.id');
            $this->email->set_newline("\r\n");

            $this->email->subject('Rekapitulasi BAST dalam proses');
            $this->email->message($this->load->view('email-notif_pnd', $data, true));           

            if(!$this->email->send()){
                echo 'email gagal terkirim';
            }   

            //$this->email->message($this->load->view('email-notif_pnd', $data /*, true*/));    

    }

    function send_email_weekly_project_by_pm() {
    
            //$data['PM']                = $this->Utility_model->getDataPM();
            //echo json_encode($data['PM']);die();
            $data['project']         = $this->Utility_model->getDataProjectPM();
            //echo count($data['project']);die();

            $config['protocol']  = "smtp";
            $config['smtp_host'] = "smtp.telkom.co.id";
            $config['smtp_user'] = "401820"; 
            $config['smtp_pass'] = "Unstoppable1212";

            $this->load->library('email', $config);

            $this->email->initialize($config);
            $this->email->from('prime@telkom.co.id','Admin Prime Apps');
            $this->email->to('rfauzi@telkom.co.id');    
            $this->email->bcc('haginmail@gmail.com, nandang@telkom.co.id, hid@telkom.co.id, sosro@telkom.co.id' ,'retnoku@telkom.co.id');
            $this->email->set_newline("\r\n");

            $this->email->subject('Laporan Project Mingguan');
            $this->email->message($this->load->view('email-notif_pm', $data, true));            

            if(!$this->email->send()){
                echo 'email gagal terkirim';
            }   
            $this->email->message($this->load->view('email-notif_pm', $data, false));
            //echo "XXX";
    }   


    function send_email_weekly_project_progress() {
    
        
        $data['progress'] = $this->Utility_model->getProjectProgress();
        //echo json_encode($data['project']);die();

            $config['protocol']  = "smtp";
            $config['smtp_host'] = "smtp.telkom.co.id";
            $config['smtp_user'] = "401820"; 
            $config['smtp_pass'] = "Unstoppable1212";

            $this->load->library('email', $config);

            $this->email->initialize($config);
            $this->email->from('prime@telkom.co.id','Admin Prime Apps');
            $this->email->to('rfauzi@telkom.co.id');    
            $this->email->bcc('haginmail@gmail.com');
            $this->email->set_newline("\r\n");

            $this->email->subject('Weekly Progress Project Report');
            $this->email->message($this->load->view('email-notif-progress', $data, true));          

            if(!$this->email->send()){
                echo 'email gagal terkirim';die();
            }   

            $this->email->message($this->load->view('email-notif-progress', $data /*, true*/)); 

    }


}

?>