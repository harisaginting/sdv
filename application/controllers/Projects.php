<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Projects extends MY_Controller
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); 
        $this->load->model('Project_model');
        if(!$this->isLoggedIn()){ 
            redirect(base_url());
        };   
          
    } 
      
    public function index()  
    {
        $this->load->model('Dashboard_model');
        $data['sidebarhidden'] = 1;
        $data['title']       = 'Projects'; 
        $data['list_pm']     = $this->get_list_pm();
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->get_list_customer();
        $data['list_segmen'] = $this->get_list_segmen();
        $data['list_type']   = $this->get_list_project_type();
        $this->myView('projects/index',$data);
             
    }

    public function candidate()
    {
        $data['title'] = 'Candidate Projects';
        
        $this->myView('projects/index_candidate',$data);
            
    }

    public function closed()
    {
        $data['title'] = 'Closed Projects';
        $data['list_pm']     = $this->get_list_pm();
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('projects/index_closed',$data);
            
    }

    public function nonPM() 
    {
        $data['title'] = 'Non Project Manager Projects';
        $data['list_pm']     = $this->get_list_pm();
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('projects/index_nonPM',$data);
            
    }

    public function add()
    {
        $data['title']       = 'Add Project';
        $data['list_pm']     = $this->get_list_pm();
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('projects/add_project',$data);
    }

    public function view_candidate($id_project)
    {
        $data['title']       = 'Assign Project';
        $data['id_project']  = $id_project;
        $data['list_pm']     = $this->get_list_pm(); 
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $data['data']        = $this->Project_model->get_detail_project($id_project);
        $data['partners']    = $data['data']['partners']; 
        if(!empty($data['data']['ID_LOP_EPIC'])){
        $data['quote_so']    = $this->Project_model->get_all_no_quote($data['data']['ID_LOP_EPIC']);    
        }         
                  
        //echo json_encode($data['quote_so']);die;

        $this->myView('projects/assign_project',$data);
    }

    function saveCloseProject($id_project){
        $result['data'] = 'error';

        $this->load->library('upload');
        //untuk upload dokumen proyek
        $targetDir = '../_files/'.$id_project;
        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        $config['upload_path'] = $targetDir;
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
                
        $this->upload->initialize($config);

        if(!empty($_FILES['documentProjectClose'])){
                if ($this->upload->do_upload('documentProjectClose')) {
                    $dataUpload = $this->upload->data();
                    $dataInsert['CLOSED_EVIDENCE']  = $id_project.'/'.$dataUpload['file_name'];  
                    $dataInsert['CLOSED_DATE']      = $this->input->post('closed_date'); 
                    $dataInsert['LESSON_LEARNED']   = $this->input->post('lesson_learned'); 
                    $dataInsert['CLOSED_BY_ID']     = $this->session->userdata('nik_sess');
                    $dataInsert['CLOSED_BY_NAME']   = $this->session->userdata('nama_sess'); 
                    $dataInsert['STATUS']           = 'CLOSED';  

                    $this->Project_model->closeProject($dataInsert,$id_project); 
                    $result['data'] = 'success';
                    //echo json_encode($dataUpload);
                } 
            }
        $this->addLog($id_project,'CLOSE_PROJECT','PROJECT',json_encode($dataInsert));  

        echo json_encode($result);

    }

    public function saveProject(){
        $result['data'] = "failed";
        $this->load->library('upload');
        $seq = $this->rzkt->get_sequence("PRIME_PROJECT_SEQ");
        $id_project = 'PROJ'.$seq['ID'];

        if(empty($this->input->post('name'))){
            echo 'error';
            die;
        }

        $data['ID_PROJECT']         = $id_project;
        $data['NAME']               = $this->input->post('name');
        $data['NIP_NAS']            = $this->input->post('customer');
        $data['STANDARD_NAME']      = $this->input->post('customer_name');
        $data['SEGMEN']             = $this->input->post('segmen');
        $data['AM_NIK']             = $this->input->post('am');
        $data['AM_NAME']            = $this->input->post('am_name');
        $data['VALUE']              = $this->input->post('value_real');
        $data['START_DATE']         = $this->input->post('start_date');
        $data['FIRST_END_DATE']     = $this->input->post('end_date');
        $data['END_DATE']           = $this->input->post('end_date');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['STATUS']             = 'PROJECT CANDIDATE';
        $data['SOURCE_PROJECT']     = 'NON-LOP';
        $data['PM_NAME']            = $this->input->post('pm_name');
        $data['PM_NIK']             = $this->input->post('pm');
        $data['DESCRIPTION']        = $this->input->post('description');
        $data['REGIONAL']           = $this->input->post('regional');
        $data['EXIST']              = '1';
        $data['REQUEST_BY_ID']      = $this->session->userdata('nik_sess');
        $data['REQUEST_BY_NAME']    = $this->session->userdata('nama_sess');
        $data['REQUEST_DATE']       = date('m/d/Y');

        if(!empty($this->input->post('spk'))){
            $data['MENGGUNAKAN_MITRA'] = 'YES';
        }

        //untuk upload dokumen proyek
        $targetDir = '../_files/'.$id_project;
        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        $config['upload_path'] = $targetDir;
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
                
        $this->upload->initialize($config);

        $data['DOC_AANWIZING']  = !empty($_FILES['doc_aanwizing']['name'])? $id_project.'/'.$_FILES['doc_aanwizing']['name'] : null;
        $data['DOC_BAKN_PB']    = !empty($_FILES['doc_bakn']['name'])? $id_project.'/'.$_FILES['doc_bakn']['name'] : null;
        $data['DOC_RFP']        = !empty($_FILES['doc_rfp']['name'])? $id_project.'/'.$_FILES['doc_rfp']['name'] : null;
        $data['DOC_PROPOSAL']   = !empty($_FILES['doc_proposal']['name'])? $id_project.'/'.$_FILES['doc_proposal']['name'] : null;       
        $data['DOC_SPK']        = !empty($_FILES['doc_spk']['name'])? $id_project.'/'.$_FILES['doc_spk']['name'] : null;
        $data['DOC_KB']         = !empty($_FILES['doc_kb']['name'])? $id_project.'/'.$_FILES['doc_kb']['name'] : null;
        $data['DOC_KL']         = !empty($_FILES['doc_kl']['name'])? $id_project.'/'.$_FILES['doc_kl']['name'] : null;   

        if (!empty($data['DOC_AANWIZING'])) {
                if (!$this->upload->do_upload('doc_aanwizing'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        if (!empty($data['DOC_PROPOSAL'])) {
                if (!$this->upload->do_upload('doc_proposal'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        if (!empty($data['DOC_RFP'])) {
                if (!$this->upload->do_upload('doc_rfp'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        if (!empty($data['DOC_BAKN_PB'])) {
                if (!$this->upload->do_upload('doc_bakn'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        if (!empty($data['DOC_SPK'])) {
                if (!$this->upload->do_upload('doc_spk'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        if (!empty($data['DOC_KB'])) {
                if (!$this->upload->do_upload('doc_kb'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        if (!empty($data['DOC_KL'])) {
                if (!$this->upload->do_upload('doc_kl'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
                
        }

        //insert data project ke tabel prime_project
        if($this->Project_model->addRequestProject($data)){
                //insert data partner
                if(!empty($this->input->post('spk'))){
                    $partner_id     = $this->input->post('id_partner');
                    $partner_name   = $this->input->post('partner');
                    $v_spk          = $this->input->post('v_spk');
                    $spk            = $this->input->post('spk');           
                    $payment        = $this->input->post('payment');           
                    $spk_note       = $this->input->post('spk_note');           

                        $files = $_FILES['document_spk'];
                        foreach ($files['name'] as $key => $image) {
                            $_FILES['images[]']['name']     = $files['name'][$key];
                            $_FILES['images[]']['type']     = $files['type'][$key];
                            $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
                            $_FILES['images[]']['error']    = $files['error'][$key];
                            $_FILES['images[]']['size']     = $files['size'][$key];

                            if(!empty($_FILES['images[]']['name'])){
                                if ($this->upload->do_upload('images[]')) {
                                    $this->upload->data();
                                } else {
                                    return false;
                                }
                            }
                        }

                        foreach ($spk as $key => $value) {
                            $dataPartners['ID_ROW']         = $this->rzkt->get_sequence("PRIME_PROJECT_PARTNERS_SEQ")['ID'];
                            $dataPartners['ID_PROJECT']     = $id_project;
                            $dataPartners['PARTNER_NAME']   = $partner_name[$key];
                            $dataPartners['ID_PARTNER']     = $partner_id[$key];
                            $dataPartners['NILAI_KONTRAK']  = $v_spk[$key];
                            $dataPartners['NO_P8']          = $spk[$key];
                            $dataPartners['PROGRESS_P8']    = 'FINISHED';
                            $dataPartners['SKEMA_PEMBAYARAN']= $payment[$key];
                            $dataPartners['CATATAN_SKEMA_PEMBAYARAN']= $spk_note[$key];
                            $dataPartners['LINK_P8']        = !empty($_FILES['document_spk']['name'][$key]) ? '../_files/'.$id_project.'/'.str_replace(' ', '_', $_FILES['document_spk']['name'][$key]) : null;
                            
                            $partners = $this->Project_model->addPartnersProjects($dataPartners);
                        }
                }
        $result['data'] = "success";
        }
        echo json_encode($result);
    }

    public function assignProjectPM($pm_nik=null){
        $error = false;
        $result['data']             = "failed";
        $this->load->library('upload');

        $pm_name                    = $this->User_model->getNameUser($pm_nik);

        $id_project                 = $this->input->post('id_project');
        $data['NAME']               = $this->input->post('name');
        $data['NIP_NAS']            = $this->input->post('customer');
        $data['STANDARD_NAME']      = $this->input->post('customer_name');
        $data['SEGMEN']             = $this->input->post('segmen');
        $data['AM_NIK']             = $this->input->post('am');
        $data['AM_NAME']            = $this->input->post('am_name');
        $data['VALUE']              = $this->input->post('value_real');
        $data['START_DATE']         = $this->input->post('start_date');
        $data['END_DATE']           = $this->input->post('end_date');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['DESCRIPTION']        = $this->input->post('description');
        $data['REGIONAL']           = $this->input->post('regional');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['STATUS']             = 'LEAD';
        $data['PM_EXIST']           = '1';
        $data['PM_NAME']            = urldecode($pm_name);
        $data['PM_NIK']             = $pm_nik;


        $data['ASSIGNED_BY_ID']     = $this->session->userdata('nik_sess');
        $data['ASSIGNED_BY_NAME']   = $this->session->userdata('nama_sess');
        $data['ASSIGNED_DATE']      = date('m/d/Y');

        //untuk upload dokumen proyek
        $targetDir = '../_files/'.$id_project;
        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        $config['upload_path'] = $targetDir;
                $config['allowed_types'] = '*';
                $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                
        $this->upload->initialize($config);

        $data['DOC_AANWIZING']  = !empty($_FILES['doc_aanwizing']['name'])? $_FILES['doc_aanwizing']['name'] : null;
        $data['DOC_BAKN_PB']    = !empty($_FILES['doc_bakn']['name'])? $_FILES['doc_bakn']['name'] : null;
        $data['DOC_RFP']        = !empty($_FILES['doc_rfp']['name'])? $_FILES['doc_rfp']['name'] : null;
        $data['DOC_PROPOSAL']   = !empty($_FILES['doc_proposal']['name'])? $_FILES['doc_proposal']['name'] : null;       
        $data['DOC_SPK']        = !empty($_FILES['doc_spk']['name'])? $_FILES['doc_spk']['name'] : null;
        $data['DOC_KB']         = !empty($_FILES['doc_kb']['name'])? $_FILES['doc_kb']['name'] : null;
        $data['DOC_KL']         = !empty($_FILES['doc_kl']['name'])? $_FILES['doc_kl']['name'] : null;   
        if (!empty($data['DOC_AANWIZING'])) {
                if (!$this->upload->do_upload('doc_aanwizing'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_AANWIZING'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_PROPOSAL'])) {
                if (!$this->upload->do_upload('doc_proposal'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_PROPOSAL'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_RFP'])) {
                if (!$this->upload->do_upload('doc_rfp'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_RFP'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_BAKN_PB'])) {
                if (!$this->upload->do_upload('doc_bakn'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_BAKN_PB'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_SPK'])) {
                if (!$this->upload->do_upload('doc_spk'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_SPK'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_KB'])) {
                if (!$this->upload->do_upload('doc_kb'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_KB'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_KL'])) {
                if (!$this->upload->do_upload('doc_kl'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_KL'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        //update data project ke tabel prime_project
        $project = $this->Project_model->updateProject($id_project,$data);
        $this->addLog($this->session->userdata('nik_sess'),'ASSIGN PM','PROJECT',json_encode($data));
        if(!$error){
            $result['data']             = "success";
        }
        //insert data partner
        if(!empty($this->input->post('spk'))){
            $partner_id     = $this->input->post('id_partner');
            $partner_name   = $this->input->post('partner');
            $v_spk          = $this->input->post('v_spk');
            $spk            = $this->input->post('spk');  
            $payment        = $this->input->post('payment');           
            $spk_note       = $this->input->post('spk_note');         

                $files = $_FILES['document_spk'];
                foreach ($files['name'] as $key => $image) {
                    $_FILES['images[]']['name']     = $files['name'][$key];
                    $_FILES['images[]']['type']     = $files['type'][$key];
                    $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
                    $_FILES['images[]']['error']    = $files['error'][$key];
                    $_FILES['images[]']['size']     = $files['size'][$key];

                    if(!empty($_FILES['images[]']['name'])){
                        if ($this->upload->do_upload('images[]')) {
                            $this->upload->data();
                        } else {
                            return false;
                        }
                    }
                }

                foreach ($spk as $key => $value) {
                    $dataPartners['ID_PROJECT']     = $id_project;
                    $dataPartners['PARTNER_NAME']   = $partner_name[$key];
                    $dataPartners['ID_PARTNER']     = $partner_id[$key];
                    $dataPartners['NILAI_KONTRAK']  = $v_spk[$key];
                    $dataPartners['NO_P8']          = $spk[$key];
                    $dataPartners['PROGRESS_P8']    = 'FINISHED';
                    if(!empty($_FILES['document_spk']['name'][$key])){
                       $re_doc_spk = str_replace(' ', '_', $_FILES['document_spk']['name'][$key]); 
                       $dataPartners['LINK_P8']     =  '../_files/'.$id_project.'/'.$re_doc_spk ;
                    }

                    $id_row = $this->input->post('id_row');

                    if(!empty($id_row[$key])){
                        $id_row_key = $id_row[$key];
                        $partners   = $this->Project_model->updatePartnersProjects($id_row_key,$dataPartners);
                    }else{
                        $dataPartners['ID_ROW']         = $this->rzkt->get_sequence("PRIME_PROJECT_PARTNERS_SEQ")['ID'];
                        $partners = $this->Project_model->addPartnersProjects($dataPartners);
                    }
                }
        }
        echo json_encode($result);
    }

    public function assignProjectNonPM(){
        $result['data']             = "failed";
        $this->load->library('upload');
        $id_project                 = $this->input->post('id_project');
        $data['NAME']               = $this->input->post('name');
        $data['NIP_NAS']            = $this->input->post('customer');
        $data['STANDARD_NAME']      = $this->input->post('customer_name');
        $data['SEGMEN']             = $this->input->post('segmen');
        $data['AM_NIK']             = $this->input->post('am');
        $data['AM_NAME']            = $this->input->post('am_name');
        $data['VALUE']              = $this->input->post('value_real');
        $data['START_DATE']         = $this->input->post('start_date');
        $data['END_DATE']           = $this->input->post('end_date');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['DESCRIPTION']        = $this->input->post('description');
        $data['REGIONAL']           = $this->input->post('regional');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['STATUS']             = 'NON PM';
        $data['PM_EXIST']           = '0';
        $data['PM_NAME']            = '';
        $data['PM_NIK']             = '';

        $data['ASSIGNED_BY_ID']     = $this->session->userdata('nik_sess');
        $data['ASSIGNED_BY_NAME']   = $this->session->userdata('nama_sess');
        $data['ASSIGNED_DATE']      = date('m/d/Y');


        //untuk upload dokumen proyek
        $targetDir = '../_files/'.$id_project;
        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        $config['upload_path'] = $targetDir;
                $config['allowed_types'] = '*';
                $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                
        $this->upload->initialize($config);

        $data['DOC_AANWIZING']  = !empty($_FILES['doc_aanwizing']['name'])? $_FILES['doc_aanwizing']['name'] : null;
        $data['DOC_BAKN_PB']    = !empty($_FILES['doc_bakn']['name'])? $_FILES['doc_bakn']['name'] : null;
        $data['DOC_RFP']        = !empty($_FILES['doc_rfp']['name'])? $_FILES['doc_rfp']['name'] : null;
        $data['DOC_PROPOSAL']   = !empty($_FILES['doc_proposal']['name'])? $_FILES['doc_proposal']['name'] : null;       
        $data['DOC_SPK']        = !empty($_FILES['doc_spk']['name'])? $_FILES['doc_spk']['name'] : null;
        $data['DOC_KB']         = !empty($_FILES['doc_kb']['name'])? $_FILES['doc_kb']['name'] : null;
        $data['DOC_KL']         = !empty($_FILES['doc_kl']['name'])? $_FILES['doc_kl']['name'] : null;   
        if (!empty($data['DOC_AANWIZING'])) {
                if (!$this->upload->do_upload('doc_aanwizing'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_AANWIZING'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_PROPOSAL'])) {
                if (!$this->upload->do_upload('doc_proposal'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_PROPOSAL'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_RFP'])) {
                if (!$this->upload->do_upload('doc_rfp'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_RFP'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_BAKN_PB'])) {
                if (!$this->upload->do_upload('doc_bakn'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_BAKN_PB'] = $id_project.'/'.$upload_data['file_name'];
                    $data['DOC_BAKN_PB'] = str_replace('var/www/html/webadmin/_files/', '', $data['DOC_BAKN_PB']);
                    echo $data['DOC_BAKN_PB'];
                }
                
        }

        if (!empty($data['DOC_SPK'])) {
                if (!$this->upload->do_upload('doc_spk'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_SPK'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_KB'])) {
                if (!$this->upload->do_upload('doc_kb'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_KB'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_KL'])) {
                if (!$this->upload->do_upload('doc_kl'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_KL'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        //update data project ke tabel prime_project
        $project = $this->Project_model->updateProject($id_project,$data);
        $result['data']             = "success";
        //insert data partner
        if(!empty($this->input->post('spk'))){
            $partner_id     = $this->input->post('id_partner');
            $partner_name   = $this->input->post('partner');
            $v_spk          = $this->input->post('v_spk');
            $spk            = $this->input->post('spk');  
            $payment        = $this->input->post('payment');           
            $spk_note       = $this->input->post('spk_note');         

                $files = $_FILES['document_spk'];
                foreach ($files['name'] as $key => $image) {
                    $_FILES['images[]']['name']     = $files['name'][$key];
                    $_FILES['images[]']['type']     = $files['type'][$key];
                    $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
                    $_FILES['images[]']['error']    = $files['error'][$key];
                    $_FILES['images[]']['size']     = $files['size'][$key];

                    if(!empty($_FILES['images[]']['name'])){
                        if ($this->upload->do_upload('images[]')) {
                            $this->upload->data();
                        } else {
                            return false;
                        }
                    }
                }

                foreach ($spk as $key => $value) {
                    $dataPartners['ID_PROJECT']     = $id_project;
                    $dataPartners['PARTNER_NAME']   = $partner_name[$key];
                    $dataPartners['ID_PARTNER']     = $partner_id[$key];
                    $dataPartners['NILAI_KONTRAK']  = $v_spk[$key];
                    $dataPartners['NO_P8']          = $spk[$key];
                    $dataPartners['PROGRESS_P8']    = 'FINISHED';
                    if(!empty($_FILES['document_spk']['name'][$key])){
                       $re_doc_spk = str_replace(' ', '_', $_FILES['document_spk']['name'][$key]); 
                       $dataPartners['LINK_P8']     =  '../_files/'.$id_project.'/'.$re_doc_spk ;
                    }

                    $id_row = $this->input->post('id_row');

                    if(!empty($id_row[$key])){
                        $id_row_key = $id_row[$key];
                        $partners   = $this->Project_model->updatePartnersProjects($id_row_key,$dataPartners);
                    }else{
                        $dataPartners['ID_ROW']         = $this->rzkt->get_sequence("PRIME_PROJECT_PARTNERS_SEQ")['ID'];
                        $partners = $this->Project_model->addPartnersProjects($dataPartners);
                    }
                }
        }
        echo json_encode($result);
    }

    public function edit($id_project){
        $data['title']       = 'Edit Project';
        $data['id_project']  = $id_project;
        $data['list_pm']     = $this->get_list_pm();
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $data['data']        = $this->Project_model->get_detail_project($id_project);
        $data['partners']    = $data['data']['partners']; 
        $this->myView('projects/edit_project',$data);
            
    } 

    public function save_editProject($pm_nik=null,$pm_name=null){
        $result['data']             = "failed";
        $this->load->library('upload');
        $id_project                 = $this->input->post('id_project');
        $data['NAME']               = $this->input->post('name');
        $data['NIP_NAS']            = $this->input->post('customer');
        $data['STANDARD_NAME']      = $this->input->post('customer_name');
        $data['SEGMEN']             = $this->input->post('segmen');
        $data['AM_NIK']             = $this->input->post('am');
        $data['AM_NAME']            = $this->input->post('am_name');
        $data['VALUE']              = $this->input->post('value_real');
        $data['START_DATE']         = $this->input->post('start_date');
        $data['END_DATE']           = $this->input->post('end_date');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['DESCRIPTION']        = $this->input->post('description');
        $data['REGIONAL']           = $this->input->post('regional');
        $data['CATEGORY']           = $this->input->post('category');
        $data['TYPE']               = $this->input->post('type');
        $data['PM_NAME']            = $this->input->post('pm_name');
        $data['PM_NIK']             = $this->input->post('pm');
        $data['NO_KB']              = $this->input->post('no_kb');
        $data['NO_KL']              = !empty($this->input->post('no_kl')) ? json_encode($this->input->post('no_kl')) : 'null';
        $data['MANAGE_SERVICE']     = !empty($this->input->post('manage_service')) ? 1 : null;


        //untuk upload dokumen proyek
        $targetDir = '../_files/'.$id_project;
        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        $config['upload_path'] = $targetDir;
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
                
        $this->upload->initialize($config);
        $data['DOC_AANWIZING']  = !empty($_FILES['doc_aanwizing']['name'])? $id_project.'/'.$_FILES['doc_aanwizing']['name'] : null;
        $data['DOC_BAKN_PB']    = !empty($_FILES['doc_bakn']['name'])? $id_project.'/'.$_FILES['doc_bakn']['name'] : null;
        $data['DOC_RFP']        = !empty($_FILES['doc_rfp']['name'])? $id_project.'/'.$_FILES['doc_rfp']['name'] : null;
        $data['DOC_PROPOSAL']   = !empty($_FILES['doc_proposal']['name'])? $id_project.'/'.$_FILES['doc_proposal']['name'] : null;       
        $data['DOC_SPK']        = !empty($_FILES['doc_spk']['name'])? $id_project.'/'.$_FILES['doc_spk']['name'] : null;
        $data['DOC_KB']         = !empty($_FILES['doc_kb']['name'])? $id_project.'/'.$_FILES['doc_kb']['name'] : null;
        $data['DOC_KL']         = !empty($_FILES['doc_kl']['name'])? $id_project.'/'.$_FILES['doc_kl']['name'] : null;   
        if (!empty($data['DOC_AANWIZING'])) {
                if (!$this->upload->do_upload('doc_aanwizing'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_AANWIZING'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_PROPOSAL'])) {
                if (!$this->upload->do_upload('doc_proposal'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_PROPOSAL'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_RFP'])) {
                if (!$this->upload->do_upload('doc_rfp'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_RFP'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }


        if (!empty($data['DOC_BAKN_PB'])) {
                if (!$this->upload->do_upload('doc_bakn'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_BAKN_PB'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_SPK'])) {
                if (!$this->upload->do_upload('doc_spk'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_SPK'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_KB'])) {
                if (!$this->upload->do_upload('doc_kb'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_KB'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        if (!empty($data['DOC_KL'])) {
                if (!$this->upload->do_upload('doc_kl'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    //echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['DOC_KL'] = $id_project.'/'.$upload_data['file_name'];
                }
                
        }

        //update data project ke tabel prime_project
        $project = $this->Project_model->updateProject($id_project,$data);
        $result['data']             = "success";

        //insert data partner
        //echo json_encode($this->input->post());die;
        $this->Project_model->deletePartnersProjects($id_project,$this->input->post('id_row'));
        if(!empty($this->input->post('spk'))){
            $partner_id     = $this->input->post('id_partner');
            $partner_name   = $this->input->post('partner');
            $v_spk          = $this->input->post('v_spk');
            $spk            = $this->input->post('spk');  
            $payment        = $this->input->post('payment');           
            $spk_note       = $this->input->post('spk_note');         

                $files = $_FILES['document_spk'];
                foreach ($files['name'] as $key => $image) {
                    $_FILES['images[]']['name']     = $files['name'][$key];
                    $_FILES['images[]']['type']     = $files['type'][$key];
                    $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
                    $_FILES['images[]']['error']    = $files['error'][$key];
                    $_FILES['images[]']['size']     = $files['size'][$key];

                    if(!empty($_FILES['images[]']['name'])){
                        if ($this->upload->do_upload('images[]')) {
                            $this->upload->data();
                        } else {
                            return false;
                        }
                    }
                }

                foreach ($spk as $key => $value) {
                    $dataPartners['ID_PROJECT']     = $id_project;
                    $dataPartners['PARTNER_NAME']   = $partner_name[$key];
                    $dataPartners['ID_PARTNER']     = $partner_id[$key];
                    $dataPartners['NILAI_KONTRAK']  = $v_spk[$key];
                    $dataPartners['NO_P8']          = $spk[$key];
                    $dataPartners['PROGRESS_P8']    = 'FINISHED';
                    if(!empty($_FILES['document_spk']['name'][$key])){
                       $re_doc_spk = str_replace(' ', '_', $_FILES['document_spk']['name'][$key]); 
                       $dataPartners['LINK_P8']     =  '../_files/'.$id_project.'/'.$re_doc_spk ;
                    }

                    $id_row = $this->input->post('id_row');

                    if(!empty($id_row[$key])){
                        $id_row_key = $id_row[$key];
                        $partners   = $this->Project_model->updatePartnersProjects($id_row_key,$dataPartners);
                    }else{
                        $dataPartners['ID_ROW']         = $this->rzkt->get_sequence("PRIME_PROJECT_PARTNERS_SEQ")['ID'];
                        $partners = $this->Project_model->addPartnersProjects($dataPartners);
                    }
                }
        }
        echo json_encode($result);
    }

    // Get Datatables
    function get_list_project_active(){
        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir = $_POST['order']['0']['dir'];
        $order = $_POST['order'];

        $status     = $this->input->post('status');
        $pm         = $this->input->post('pm');
        $customer   = $this->input->post('customer');
        $partner    = $this->input->post('mitra');
        $type       = $this->input->post('type');
        $regional   = $this->input->post('regional');
        $segmen     = $this->input->post('segmen');

        $model = $this->Project_model->get_datatablesActive($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen);

        foreach ($model as $key => $value) {
            //echo json_encode($model[$key]->POTENTIAL );die;
            $model[$key]->POTENTIAL         = floor($model[$key]->POTENTIAL);  
            $model[$key]->POTENTIAL_WEEK    = floor($model[$key]->POTENTIAL_WEEK);  
        }

        //echo $this->db->last_query();die;

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allActive($status,$pm,$customer,$partner,$type,$regional,$segmen),
            "recordsFiltered" => $this->Project_model->count_filteredActive($searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function get_list_project_candidate(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:0;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $source = $this->input->post('source');


        $model = $this->Project_model->get_datatablesCandidate($length, $start, $searchValue, $orderColumn, $orderDir, $order,$source);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allCandidate($source),
            "recordsFiltered" => $this->Project_model->count_filteredCandidate($searchValue, $orderColumn, $orderDir, $order,$source),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function get_list_project_closed(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;

        $status     = $this->input->post('status');
        $pm         = $this->input->post('pm');
        $customer   = $this->input->post('customer');
        $partner    = $this->input->post('mitra');
        $type       = $this->input->post('type');
        $regional   = $this->input->post('regional');
        $segmen     = $this->input->post('segmen');
        $escorded   = $this->input->post('escorded');

        $model = $this->Project_model->get_datatablesClosed($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allClosed($status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded),
            "recordsFiltered" => $this->Project_model->count_filteredClosed($searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function get_list_project_nonPM(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;

        $status     = $this->input->post('status');
        $pm         = $this->input->post('pm');
        $customer   = $this->input->post('customer');
        $partner    = $this->input->post('mitra');
        $type       = $this->input->post('type');
        $regional   = $this->input->post('regional');
        $segmen     = $this->input->post('segmen');

        $model = $this->Project_model->get_datatablesNonPM($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allNonPM($status,$pm,$customer,$partner,$type,$regional,$segmen),
            "recordsFiltered" => $this->Project_model->count_filteredNonPM($searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen),
            "data" => $model,
        );
        //echo $this->db->last_query();die;
        echo json_encode($output);
    }

    function view($id_project,$dd='old') {
            $data['param']          = $dd;
            $data['list_partner']   = $this->get_list_mitra();
            $data['list_segmen']    = $this->rzkt->get_list_segmen()->result_array();
            $data['id_project']     = $id_project;
            $data['title']          = 'Project '.$id_project;
            $data['breadcrumb']     = "Projects / List Of Project / <strong>Detail Project</strong>";
            $data['listDetail']     = $this->Project_model->get_detail_project($id_project);
            $data['pm']             = $this->User_model->getDataUser($data['listDetail']['PM_NIK']);//echo json_encode($data['pm']);die;
            $data['arrAssignTo']    = array('SDV','MITRA','SEGMEN','BDM','DSS','TREG');
            $data['get_list_issue'] = $this->Project_model->get_list_issue($id_project);
            $data['deliv_weight']   = $this->Project_model->sum_deliverable_weight_ach($id_project);
            $data['sum_weight_real']= $this->Project_model->get_sum_weight_realization($id_project); 
            $data['kurva']          = $this->Project_model->get_curva_s($id_project);
            $data['listDocs']       = $this->Project_model->get_list_document($id_project);
            $data['partners']       = $this->Project_model->get_partners($id_project);
            $data['last_updated']   = $this->Project_model->get_last_updated_by($id_project);
 
            $data['document']       = $this->Project_model->get_project_document($id_project);
            $data['bast']           = $this->Project_model->get_project_bast($id_project);

            $data['current_week']   = $current_week = $this->Project_model->get_current_week($id_project);
            $deliverable            = $plan = $this->Project_model->get_distinct_deliverable($id_project,$data['listDetail']['START_DATE'],$data['current_week']);


            //echo $data['current_week'];die;
            //echo $this->db->last_query();die;
            //echo json_encode($deliverable);die;

            $t_deliverable          = $t_plan = count($deliverable);
            
            $name_deliverable       = array();
            $desc_deliverable       = array();
            $color_deliverable       = array();
            $ws_we = array();
            foreach ($deliverable as $key => $value) {
                array_push($name_deliverable, $value['ID_DELIVERABLE']);
                array_push($color_deliverable, $value['COLOR']);
                array_push($desc_deliverable, $value['DESCRIPTION']);
                $c_ws_we    = array();
                array_push($c_ws_we, intval($value['WEEK_START']));
                array_push($c_ws_we, intval($value['WEEK_END']));
                array_push($ws_we,   $c_ws_we);    
            }


            $data['name_deliverable'] = $name_deliverable;
            $data['color_deliverable'] = $color_deliverable;
            $data['desc_deliverable'] = $desc_deliverable;
            $data['d_ws_we']          = $ws_we;

            $list_deliverable       = $this->Project_model->get_deliverable_progress($id_project);
            $list_plan              = $this->Project_model->get_deliverable_plan($id_project);
            
            $sumdeliverable['NAME'] = 'TOTAL';
            $sumplan['NAME']        = 'TOTAL';
            
            $data['week_project']       = $this->Project_model->get_current_week($id_project);
            $data['week']               = $this->Project_model->get_week($id_project);
                
            $data['history']            = $this->Project_model->getProjectHistory($id_project);
            $data['acquisition']        = $this->Project_model->getProjectAcquisition($id_project);

            $data['id_project']         = $id_project;
            $data['acquistion']         = $this->Project_model->getAllDataAcquisition($id_project);
            $data['value_project']      = $data['listDetail']['VALUE'];
            $month          = date('n');
            $month_lm       = $month - 1;
            $year           = date('Y');
            if($month_lm==0){
                $month_lm       = 12;
                $year           = $year - 1;
            }
            //echo $year;die;
            $top                = array('OTC','RECCURING','PROGRESS','TERMIN','DP');
            $acq                = array();
            $acq_lm             = array();

            foreach ($top as $key => $value) {
                 $acq[$value]       = $this->Project_model->getAcquisition($id_project,$month,$value);
                 $acq_lm[$value]    = $this->Project_model->getAcquisition($id_project,$month_lm,$value,$year);
            }

            $data['acq']        = $acq;
            $data['acq_lm']     = $acq_lm;
            //echo json_encode($data['acq_lm']);die;
            //echo json_encode($data['acquisition']);die;
            // ACHIEVMENT
            foreach ($deliverable as $key => $value) {
                $last_value = 0;
                $deliverable[$key]['PROGRESS_VALUE'] = number_format($plan[$key]['PROGRESS_VALUE'],2); 
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_deliverable as $key2 => $value2) { 
                            if(($deliverable[$key]['ID_DELIVERABLE'] == $list_deliverable[$key2]['ID_DELIVERABLE'])&&($list_deliverable[$key2]['WEEK']==$key1+1)){
                                $deliverable[$key][$key1+1] = number_format(($list_deliverable[$key2]['REALIZATION'] + $last_value),2);
                                $last_value = $deliverable[$key][$key1+1];
                            }

                            if(($deliverable[$key]['ID_DELIVERABLE'] == $list_deliverable[$key2]['ID_DELIVERABLE'])&&($list_deliverable[$key2]['WEEK']!=$key1+1)){
                                $deliverable[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }

            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($deliverable as $key1 => $value1) {
                    if(!empty($deliverable[$key1][$key+1])){
                        $weekval = $weekval + $deliverable[$key1][$key+1];
                    }
                }
                $sumdeliverable[$key+1] = $weekval;
            }
            $sumdeliverable['PROGRESS_VALUE'] = $weekval;

            $deliverable[$t_deliverable] = $sumdeliverable;
            $data['deliverable'] = $deliverable;
            $data['t_deliverable'] = $t_deliverable; 

            //echo json_encode($list_plan);die;
            // PLAN
            foreach ($plan as $key => $value) {
                $last_value = 0;
                $plan[$key]['WEIGHT'] = number_format($plan[$key]['WEIGHT'],2);  
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_plan as $key2 => $value2) { 
                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']==$key1+1)){
                                $plan[$key][$key1+1] = number_format(($list_plan[$key2]['WEIGHT_IN_WEEK'] + $last_value),2);
                                $last_value = $plan[$key][$key1+1];
                            }

                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']!=$key1+1)){
                                $plan[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }
            
            //echo count($plan);
            //echo json_encode($plan);die;
            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($plan as $key1 => $value1) {
                    if(!empty($plan[$key1][$key+1])){
                        $weekval = $weekval + $plan[$key1][$key+1];
                    }
                }
                $sumplan[$key+1] = $weekval;
            }
            $sumplan['PROGRESS_VALUE'] = $weekval;

            $plan[$t_deliverable] = $sumplan;
            $data['plan']           = $plan;
            $data['t_plan']         = $t_plan;

            //echo json_encode($data['kurva']);die;
           // die;
            //echo json_encode($plan);die;

            foreach ($data['kurva']['REAL'] as $key => $value) {
                if((empty($data['kurva']['REAL'][$key]))&&(!empty($data['kurva']['REAL'][$key-1]))&&($key <= $data['week_project'])){
                    $data['kurva']['REAL'][$key] = $data['kurva']['REAL'][$key-1];
                }
                if($key > $data['week_project']){
                    unset($data['kurva']['REAL'][$key]);
                }
            }

            $target              = $this->Project_model->getTargetProject($id_project);
            //echo json_encode($data['kurva']['REAL']);die;
            $data['target']    = $target['T'];   
            if(empty($data['listDetail']['ID_PROJECT'])){echo 'no data found.';die();}
            $this->myView('projects/view', $data); 
        }

        function view_closed($id_project,$dd='old') {
            $data['param']          = $dd;
            $data['list_partner']   = $this->get_list_mitra();
            $data['list_segmen']    = $this->rzkt->get_list_segmen()->result_array();
            $data['id_project']     = $id_project;
            $data['title']          = 'Project '.$id_project;
            $data['breadcrumb']     = "Projects / List Of Project / <strong>Detail Project</strong>";
            $data['listDetail']     = $this->Project_model->get_detail_project($id_project);
            $data['arrAssignTo']    = array('SDV','MITRA','SEGMEN','BDM','DSS','TREG');
            $data['get_list_issue'] = $this->Project_model->get_list_issue($id_project);
            $data['deliv_weight']   = $this->Project_model->sum_deliverable_weight_ach($id_project);
            $data['sum_weight_real']= $this->Project_model->get_sum_weight_realization($id_project); 
            $data['kurva']          = $this->Project_model->get_curva_s($id_project);
            $data['listDocs']       = $this->Project_model->get_list_document($id_project);
            $data['partners']       = $this->Project_model->get_partners($id_project);
            $data['last_updated']   = $this->Project_model->get_last_updated_by($id_project);

            $data['document']       = $this->Project_model->get_project_document($id_project);
            $data['bast']           = $this->Project_model->get_project_bast($id_project);

            $data['current_week']   = $current_week = $this->Project_model->get_current_week($id_project);
            $deliverable            = $plan = $this->Project_model->get_distinct_deliverable($id_project,null,null);

            $t_deliverable          = $t_plan = count($deliverable);
            
            $list_deliverable       = $this->Project_model->get_deliverable_progress($id_project);
            $list_plan              = $this->Project_model->get_deliverable_plan($id_project);
            
            $sumdeliverable['NAME'] = 'TOTAL';
            $sumplan['NAME'] = 'TOTAL';
            
            if($data['listDetail']['STATUS'] != 'CLOSED'){
                echo "this project isn't closed.";die;
            }

            // ACHIEVMENT
            foreach ($deliverable as $key => $value) {
                $last_value = 0;
                $deliverable[$key]['PROGRESS_VALUE'] = number_format($plan[$key]['PROGRESS_VALUE'],2); 
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_deliverable as $key2 => $value2) { 
                            if(($deliverable[$key]['ID_DELIVERABLE'] == $list_deliverable[$key2]['ID_DELIVERABLE'])&&($list_deliverable[$key2]['WEEK']==$key1+1)){
                                $deliverable[$key][$key1+1] = number_format(($list_deliverable[$key2]['REALIZATION'] + $last_value),2);
                                $last_value = $deliverable[$key][$key1+1];
                            }

                            if(($deliverable[$key]['ID_DELIVERABLE'] == $list_deliverable[$key2]['ID_DELIVERABLE'])&&($list_deliverable[$key2]['WEEK']!=$key1+1)){
                                $deliverable[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }

            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($deliverable as $key1 => $value1) {
                    if(!empty($deliverable[$key1][$key+1])){
                        $weekval = $weekval + $deliverable[$key1][$key+1];
                    }
                }
                $sumdeliverable[$key+1] = $weekval;
            }
            $sumdeliverable['PROGRESS_VALUE'] = $weekval;

            $deliverable[$t_deliverable] = $sumdeliverable;
            $data['deliverable'] = $deliverable;
            $data['t_deliverable'] = $t_deliverable;

            //echo json_encode($list_plan);die;
            // PLAN
            foreach ($plan as $key => $value) {
                $last_value = 0;
                $plan[$key]['WEIGHT'] = number_format($plan[$key]['WEIGHT'],2);  
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_plan as $key2 => $value2) { 
                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']==$key1+1)){
                                $plan[$key][$key1+1] = number_format(($list_plan[$key2]['WEIGHT_IN_WEEK'] + $last_value),2);
                                $last_value = $plan[$key][$key1+1];
                            }

                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']!=$key1+1)){
                                $plan[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }
            
            //echo count($plan);
            //echo json_encode($plan);die;
            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($plan as $key1 => $value1) {
                    if(!empty($plan[$key1][$key+1])){
                        $weekval = $weekval + $plan[$key1][$key+1];
                    }
                }
                $sumplan[$key+1] = $weekval;
            }
            $sumplan['PROGRESS_VALUE'] = $weekval;

            $plan[$t_deliverable] = $sumplan;
            $data['plan']           = $plan;
            $data['t_plan']         = $t_plan;

            //echo json_encode($data['kurva']);die;
           // die;
            //echo json_encode($plan);die;
            if(empty($data['listDetail']['ID_PROJECT'])){echo 'no data found.';die();}
            $this->myView('projects/view_closed', $data); 
        }

    function listDeliverable($id_project){
            $data['id_project']     = $id_project;
            $data['title']          = 'Project '.$id_project;
            $data['breadcrumb']     = "Projects / List Of Project / <strong>Detail Project</strong>";
            $data['listDetail']     = $this->Project_model->get_detail_project($id_project);
            $data['arrAssignTo']    = array('PJM','MITRA','SEGMEN','BDM','DSS','TREG');
            $data['get_list_issue'] = $this->Project_model->get_list_issue($id_project);
            $data['deliv_weight']   = $this->Project_model->sum_deliverable_weight_ach($id_project);
            $data['sum_weight_real']= $this->Project_model->get_sum_weight_realization($id_project); 
            $data['kurva']          = $this->Project_model->get_curva_s($id_project);
            $data['listDocs']       = $this->Project_model->get_list_document($id_project);
            $data['partners']       = $this->Project_model->get_partners($id_project);
            $data['last_updated']   = $this->Project_model->get_last_updated_by($id_project);
            $data['current_week']   = $current_week = $this->Project_model->get_current_week($id_project);


            $deliverable            = $plan = $this->Project_model->get_distinct_deliverable($id_project,null,null); 
            $t_deliverable          = $t_plan = count($deliverable);
            $list_deliverable       = $this->Project_model->get_deliverable_progress($id_project);
            $sumdeliverable['NAME'] = 'TOTAL';

            $list_plan              = $this->Project_model->get_deliverable_plan($id_project);
            $sumplan['NAME']       = 'TOTAL';
            
            
            foreach ($deliverable as $key => $value) {
                $last_value = 0;
                $deliverable[$key]['PROGRESS_VALUE'] = number_format($deliverable[$key]['PROGRESS_VALUE'],2); 
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_deliverable as $key2 => $value2) { 
                            if(($deliverable[$key]['ID_DELIVERABLE'] == $list_deliverable[$key2]['ID_DELIVERABLE'])&&($list_deliverable[$key2]['WEEK']==$key1+1)){
                                $deliverable[$key][$key1+1] = number_format(($list_deliverable[$key2]['REALIZATION'] + $last_value),2);
                                $last_value = $deliverable[$key][$key1+1];
                            }

                            if(($deliverable[$key]['ID_DELIVERABLE'] == $list_deliverable[$key2]['ID_DELIVERABLE'])&&($list_deliverable[$key2]['WEEK']!=$key1+1)){
                                $deliverable[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }

            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($deliverable as $key1 => $value1) {
                    if(!empty($deliverable[$key1][$key+1])){
                        $weekval = $weekval + $deliverable[$key1][$key+1];
                    }
                }
                $sumdeliverable[$key+1] = $weekval;
            }

            $data['week_project']       = $this->Project_model->get_current_week($id_project);
             foreach ($data['kurva']['REAL'] as $key => $value) {
                if((empty($data['kurva']['REAL'][$key]))&&(!empty($data['kurva']['REAL'][$key-1]))&&($key <= $data['week_project'])){
                    $data['kurva']['REAL'][$key] = $data['kurva']['REAL'][$key-1];
                }
                if($key > $data['week_project']){
                    unset($data['kurva']['REAL'][$key]);
                }
            }

            $sumdeliverable['PROGRESS_VALUE'] = $weekval;
           
            $deliverable[$t_deliverable] = $sumdeliverable;
            $data['deliverable'] = $deliverable;
            $data['t_deliverable'] = $t_deliverable;


            foreach ($plan as $key => $value) {
                $last_value = 0;
                $plan[$key]['WEIGHT'] = number_format($plan[$key]['WEIGHT'],2);  
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_plan as $key2 => $value2) { 
                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']==$key1+1)){
                                $plan[$key][$key1+1] = number_format(($list_plan[$key2]['WEIGHT_IN_WEEK'] + $last_value),2);
                                $last_value = $plan[$key][$key1+1];
                            }

                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']!=$key1+1)){
                                $plan[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }

            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($plan as $key1 => $value1) {
                    if(!empty($plan[$key1][$key+1])){
                        $weekval = $weekval + $plan[$key1][$key+1];
                    }
                }
                $sumplan[$key+1] = $weekval;
            }
            $sumplan['PROGRESS_VALUE'] = $weekval;

            $plan[$t_deliverable] = $sumplan;
            $data['plan']           = $plan;
            $data['t_plan']         = $t_plan;
            //echo json_encode($deliverable);die;
            if(empty($data['listDetail']['ID_PROJECT'])){echo 'no data found.';die();}
            $this->myViewHeader('projects/list_deliverable', $data); 
    }


    function listPlan($id_project){
            $data['id_project']     = $id_project;
            $data['title']          = 'Project '.$id_project;
            $data['breadcrumb']     = "Projects / List Of Project / <strong>Detail Project</strong>";
            $data['listDetail']     = $this->Project_model->get_detail_project($id_project);
            $data['arrAssignTo']    = array('PJM','MITRA','SEGMEN','BDM','DSS','TREG');
            $data['get_list_issue'] = $this->Project_model->get_list_issue($id_project);
            $data['deliv_weight']   = $this->Project_model->sum_deliverable_weight_ach($id_project);
            $data['sum_weight_real']= $this->Project_model->get_sum_weight_realization($id_project); 
            $data['kurva']          = $this->Project_model->get_curva_s($id_project);
            $data['listDocs']       = $this->Project_model->get_list_document($id_project);
            $data['partners']       = $this->Project_model->get_partners($id_project);
            $data['last_updated']   = $this->Project_model->get_last_updated_by($id_project);

            $data['document']       = $this->Project_model->get_project_document($id_project);
            $data['bast']           = $this->Project_model->get_project_bast($id_project);

            $data['current_week']   = $current_week = $this->Project_model->get_current_week($id_project);
            $deliverable            = $plan = $this->Project_model->get_distinct_deliverable($id_project);

            $t_deliverable          = $t_plan = count($deliverable);
            
            $list_deliverable       = $this->Project_model->get_deliverable_progress($id_project);
            $list_plan              = $this->Project_model->get_deliverable_plan($id_project);
            
            $sumdeliverable['NAME'] = 'TOTAL';
            $sumplan['NAME'] = 'TOTAL';
            
            
           // PLAN
            foreach ($plan as $key => $value) {
                $last_value = 0;
                $plan[$key]['WEIGHT'] = number_format($plan[$key]['WEIGHT'],2);  
                foreach ( $data['kurva']['WEEK'] as $key1 => $value1) {
                        foreach ($list_plan as $key2 => $value2) { 
                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']==$key1+1)){
                                $plan[$key][$key1+1] = number_format(($list_plan[$key2]['WEIGHT_IN_WEEK'] + $last_value),2);
                                $last_value = $plan[$key][$key1+1];
                            }

                            if(($plan[$key]['ID_DELIVERABLE'] == $list_plan[$key2]['ID_DELIVERABLE'])&&($list_plan[$key2]['WEEK']!=$key1+1)){
                                $plan[$key][$key1+1] = $last_value;
                            }
                        }
                }  
            }
            
            //echo count($plan);
            //echo json_encode($plan);die;
            foreach ( $data['kurva']['WEEK'] as $key => $value) {
                $weekval=0;
                foreach ($plan as $key1 => $value1) {
                    if(!empty($plan[$key1][$key+1])){
                        $weekval = $weekval + $plan[$key1][$key+1];
                    }
                }
                $sumplan[$key+1] = $weekval;
            }
            $sumplan['PROGRESS_VALUE'] = $weekval;

            $plan[$t_deliverable] = $sumplan;
            $data['plan']           = $plan;
            $data['t_plan']         = $t_plan;
            //echo json_encode($deliverable);die;
            if(empty($data['listDetail']['ID_PROJECT'])){echo 'no data found.';die();}
            $this->myViewHeader('projects/list_plan', $data); 
    }

##DATATABLE DELIVERABLE
    public function get_list_deliverable(){
            $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
            $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
            $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
            $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
            $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
            $order = !empty($_POST['order'])? $_POST['order']: null;
            $id_project = !empty($_POST['id_project'])? $_POST['id_project']: null;

            $model = $this->Project_model->get_datatablesDeliverable($length, $start, $searchValue, $orderColumn, $orderDir, $order,$id_project);

            $output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->Project_model->count_allDeliverable($id_project),
                "recordsFiltered" => $this->Project_model->count_filteredDeliverable($searchValue, $orderColumn, $orderDir, $order,$id_project),
                "data" => $model,
            );
            //output to json format
            //echo $this->db->last_query();exit;
            echo json_encode($output);
        }
##END DATATABLE DELIVERABLE

##DATATABLE ISSUE
    public function get_list_issue(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $id_project = !empty($_POST['id_project'])? $_POST['id_project']: null;

        $model = $this->Project_model->get_datatablesIssue($length, $start, $searchValue, $orderColumn, $orderDir, $order,$id_project);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allIssue($id_project),
            "recordsFiltered" => $this->Project_model->count_filteredIssue($searchValue, $orderColumn, $orderDir, $order,$id_project),
            "data" => $model,
        );
        echo json_encode($output);
    }
##END DATATABLE ISSUE


##DATATABLE ACTION PLAN
        public function get_list_ActionPlan(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $id_project = !empty($_POST['id_project'])? $_POST['id_project']: null;

        $model = $this->Project_model->get_datatablesActionPlan($length, $start, $searchValue, $orderColumn, $orderDir, $order,$id_project);

        $output = array( 
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allActionPlan($id_project),
            "recordsFiltered" => $this->Project_model->count_filteredActionPlan($searchValue, $orderColumn, $orderDir, $order,$id_project),
            "data" => $model,
        );
        echo json_encode($output);
    }    
##END OF DATATABLE ACTION PLAN


//HISTORY ACTION PLAN
    function get_list_HisActionPlan(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $id_project = !empty($_POST['id_project'])? $_POST['id_project']: null;

        $model = $this->Project_model->get_datatablesHisActionPlan($length, $start, $searchValue, $orderColumn, $orderDir, $order,$id_project);

        $output = array( 
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Project_model->count_allHisActionPlan($id_project),
            "recordsFiltered" => $this->Project_model->count_filteredHisActionPlan($searchValue, $orderColumn, $orderDir, $order,$id_project),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function addDeliverable($id_project){
        $sequence                = $this->rzkt->get_sequence("PRIME_PROJECT_DELIVERABLE_SEQ");
        
        $data['ID_DELIVERABLE']  = 'DL'.$sequence['ID'];
        $data['ID_PROJECT']      = $id_project;
        $data['NAME']            = $this->input->post('name');
        $data['START_DATE']      = $this->input->post('start_date');
        $data['END_DATE']        = $this->input->post('end_date'); 
        $data['DESCRIPTION']     = $this->input->post('description');
        $data['WEIGHT']          = $this->input->post('weight');
        $data['ATTACHMENT']      = $this->input->post('attachment_deliverable_value');
        $data['INSERTED_BY_ID']  = $this->session->userdata('nik_sess');
        $data['INSERTED_BY_NAME']= $this->session->userdata('nama_sess');
        $this->add_credit_point('DELIVERABLE '.$data['ID_DELIVERABLE'],$id_project,"ADD DELIVERABLE",1,json_encode($data));
        if ($this->Project_model->insert_deliverable($data)) { 
            $this->addLog($id_project,'ADD DELIVERY','PROJECT',json_encode($data));
            $this->Project_model->updateLogProject($id_project); 
            //$this->Project_model->refreshProject();
            echo 'success';
        }
        //echo $this->db->last_query();

    }

    function deleteDeliverable() {
            if ($this->Project_model->deleteDeliverable($this->input->get('id_project'),$this->input->get('id_deliverable'))) {
                //$this->Project_model->refreshProject();
                echo 'success';die;
            }
            $this->addLog($this->input->get('id_project'),'DELETE DELIVERY','PROJECT',json_encode($this->input->get()));
            echo 'false';
            
        }

    function get_detail_issueAction(){
        //echo json_encode($this->input->post());die;

        $id_issue   = $this->input->post('id_issue');
        $id_action  = $this->input->post('id_action');

        $data           = array();
        $data['issue']  = array();
        $data['action'] = array();

        if(!empty($id_issue)){
            $data['issue']  = $this->Project_model->getIssue($id_issue);
        }

        if(!empty($id_action)){
            $data['action'] = $this->Project_model->getAction($id_action);
            $data['action']['pic'] = $this->Project_model->getActionPic($id_action);
        }


        echo json_encode($data);

    }

    function get_detail_issue() {
                $id = $this->input->post('id_issue');
                $data = $this->Project_model->get_detail_issue($id);
                echo json_encode($data);
        }

    function addIssue($id_project) {
            $issue_name         = $this->input->post('issue_name');
            $risk_impact        = $this->input->post('risk_impact');
            $mitigation_plan    = $this->input->post('mitigation_plan');
            $impact             = $this->input->post('impact');
            $pic_name           = $this->input->post('pic_name');
            $pic_email          = $this->input->post('pic_email');
            $attachment          = $this->input->post('attachment_issue_value');
            $arrPic             = array();
            
            $seqIssue = $this->rzkt->get_sequence("PRIME_PROJECT_ISSUE_SEQ");
            $data = array(
                    'ID_ISSUE'          => 'IS'.$seqIssue['ID'],
                    'ID_PROJECT'        => $id_project,
                    'ISSUE_NAME'        => $issue_name,
                    'RISK_IMPACT'       => $risk_impact,
                    'MITIGATION_PLAN'   => $mitigation_plan,
                    'IMPACT'            => $impact,
                    'ISSUE_ATTACHMENT'  => $attachment,
            );

            if (!empty($pic_name)) {
                for($i=0;$i<count($pic_name);$i++){
                    $seqPic = $this->rzkt->get_sequence("PRIME_ISSUE_PIC_SEQ");
                    if (!empty($pic_name[$i])) {
                        $picArr = array(
                                'ID_PIC'        => $seqPic['ID'],
                                'ID_ISSUE'      => 'IS'.$seqIssue['ID'],
                                'PIC_NAME'      => $pic_name[$i],
                                'PIC_EMAIL'     => $pic_email[$i],
                            );
                        array_push($arrPic, $picArr);
                    }
                }
            } 
            
            $this->add_credit_point('ISSUE '.'IS'.$seqIssue['ID'],$id_project,"ADD ISSUE",1,$issue_name);
            if ($this->Project_model->addIssue($data)) {
                $this->addLog($id_project,'ADD ISSUE','PROJECT',json_encode($data));
                $data = $data['ID_ISSUE'];
                $this->Project_model->addPicIssue($arrPic);
                $this->Project_model->updateLogProject($id_project);
                echo 'success';
            }
        }

    function updateIssue($id_issue){
            $id_project         = $this->input->post('idPro');
            $issue_name         = $this->input->post('issue_name');
            $risk_impact        = $this->input->post('risk_impact'); 
            $mitigation_plan    = $this->input->post('mitigation_plan');
            $impact             = $this->input->post('impact');
            $status             = $this->input->post('status');
            $closed_date        = $this->input->post('closed_date');
            $pic_name           = $this->input->post('pic_name');
            $pic_email          = $this->input->post('pic_email');
            $attachment          = $this->input->post('attachment_issue_value');
            $arrPic             = array();
            
            // get sequences
            //$seqIssue = $this->rzkt->get_sequence("{PRE}_PROJECT_ISSUE_SEQ");
            
            $data = array(
                    'ID_ISSUE'          => $id_issue,
                    'ID_PROJECT'        => $id_project,
                    'ISSUE_NAME'        => $issue_name,
                    'RISK_IMPACT'       => $risk_impact,
                    'MITIGATION_PLAN'   => $mitigation_plan,
                    'IMPACT'            => $impact,
                    'STATUS_ISSUE'      => $status,
                    'ISSUE_CLOSED_DATE' => $closed_date,
                    'ISSUE_ATTACHMENT'  => $attachment
            );

            if (!empty($pic_name)) {
                $del = $this->Project_model->deletePicIssue($id_issue);
                for($i=0;$i<count($pic_name);$i++){
                    $seqPic = $this->rzkt->get_sequence("PRIME_ISSUE_PIC_SEQ");
                    if (!empty($pic_name[$i])) {
                        $picArr = array(
                                'ID_PIC'        => $seqPic['ID'],
                                'ID_ISSUE'      => $id_issue,
                                'PIC_NAME'      => $pic_name[$i],
                                'PIC_EMAIL'     => $pic_email[$i],
                            );
                        array_push($arrPic, $picArr);
                    }
                }
            } 
            
            $this->add_credit_point('ISSUE '.$id_issue,$id_project,"UPDATE ISSUE",1,json_encode($data));

            if ($this->Project_model->updateIssue($data)) {
                $this->addLog($id_project,'UPDATE ISSUE','PROJECT',json_encode($data));
                $this->Project_model->addPicIssue($arrPic);
                $this->Project_model->updateLogProject($id_project);
                
                echo 'success';
            }

    }    

    function deleteIssue(){
        if ($this->Project_model->deleteIssue($this->input->get('id_project'),$this->input->get('id_issue'))) {
                echo 'success';die;
            }
            $this->addLog($this->input->get('id_project'),'DELETE ISSUE','PROJECT',json_encode($this->input->get()));
            echo 'false';
    }

    function updateDeliverable($id_deliverable){
            $id_project     = $this->input->post('id_project');
            $name           = $this->input->post('name');
            $weight         = $this->input->post('weight');
            $attachment     = $this->input->post('attachment_deliverable_value');

            $status_proj    = $this->input->post('status_proj')?$this->input->post('status_proj'):null;
            $symptom        = $this->input->post('symptom')?$this->input->post('symptom'):null;

            $start_date     = explode('/', $this->input->post('start_date'));
            $newSD          = $start_date[1].'/'.$start_date[0].'/'.$start_date[2];
            $end_date       = explode('/', $this->input->post('end_date'));
            $newED          = $end_date[1].'/'.$end_date[0].'/'.$end_date[2];
            $tamp_SD        = $this->input->post('tamp_SD');
            $tamp_ED        = $this->input->post('tamp_ED');
            
            $description    = $this->input->post('description');
            $progress_value = $this->input->post('progress_value'); 
            $data = array(
                    'ID_DELIVERABLE'    => $id_deliverable,
                    'ID_PROJECT'        => $id_project,
                    'NAME'              => $name,
                    'WEIGHT'            => $weight,
                    'START_DATE'        => $this->input->post('start_date'),
                    'END_DATE'          => $this->input->post('end_date'),
                    'DESCRIPTION'       => $description,
                    'PROGRESS_VALUE'    => $progress_value,
                    'ATTACHMENT'        => $attachment 
            );
            if ($this->Project_model->updateDeliverable($data)) {
                $this->Project_model->updateLogProject($id_project);
                $this->add_credit_point('DELIVERABLE '.$id_deliverable,$id_project,"UPDATE DELIVERABLE",1,json_encode($data));
                $this->addLog($id_project,'UPDATE DELIVERY','PROJECT',json_encode($data));            
                //echo $this->db->last_query();die;
                //$this->Project_model->refreshProject();
                echo 'success';
            }

    }

    function get_detail_deliverable() {
            $id = $this->input->post('id_deliverable');
            $data = $this->Project_model->get_detail_deliverable($id);
            echo json_encode($data);
        }
    

##Upload File
    function upload_file_deliverable($id_project){
        $this->load->library('upload');

        $targetD    = '../_files/'.$id_project;
        $targetDir  = '../_files/'.$id_project.'/deliverable';

        if(!is_dir($targetD)){
            mkdir($targetD,0777);
        }

        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        if (!empty($_FILES['attachment_deliverable']['name'])) {
                $config['upload_path'] = $targetDir;
                $config['allowed_types'] = '*';
                $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name']     = 'deliverable_'.date('dmY').'_'.$_FILES['attachment_deliverable']['name'];
                
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment_deliverable'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    echo json_encode($upload_data);
                }
                
        }
    }  

    function upload_file_issue($id_project){
        $this->load->library('upload');

        $targetD    = '../_files/'.$id_project;
        $targetDir  = '../_files/'.$id_project.'/issue';

        if(!is_dir($targetD)){
            mkdir($targetD,0777);
        }

        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        if (!empty($_FILES['attachment_issue']['name'])) {
                $config['upload_path'] = $targetDir;
                $config['allowed_types'] = '*';
                $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name']     = 'issue_'.date('dmY').'_'.$_FILES['attachment_issue']['name'];
                
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment_issue'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    echo json_encode($upload_data);
                }
                
        }
    }  

    function upload_file_action($id_project){
        $this->load->library('upload');

        $targetD    = '../_files/'.$id_project;
        $targetDir  = '../_files/'.$id_project.'/action';

        if(!is_dir($targetD)){
            mkdir($targetD,0777);
        }

        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        if (!empty($_FILES['attachment_action']['name'])) {
                $config['upload_path'] = $targetDir;
                $config['allowed_types'] = '*';
                $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name']     = 'action_'.date('dmY').'_'.$_FILES['attachment_action']['name'];
                
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment_action'))
                {
                    $upload_error = array('error' => $this->upload->display_errors());
                    echo json_encode($upload_error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    echo json_encode($upload_data);
                }
                
        }
    }  
##End Upload File

function addAction($id_project,$key_action_plan=null) {
            $task_name      = $this->input->post('task_name');
            $issued         = $this->input->post('issued');
            $assign_to      = $this->input->post('assignto');
            $assign_to_detail = $this->input->post('assignto_detail');
            $due_date       = $this->input->post('due_date');
            $remarks_action = $this->input->post('remarks_action');
            $pic_name       = $this->input->post('pic_name');
            $pic_email      = $this->input->post('pic_email');
            $attachment     = $this->input->post('attachment_action_value');
            $arrPic         = array();

            // get sequences
            $seqAction = $this->rzkt->get_sequence("PRIME_PROJECT_ACTION_SEQ");
            
            $data = array(
                    'ID_ACTION_PLAN'    => 'AP'.$seqAction['ID'],
                    'ID_PROJECT'        => $id_project,
                    'ID_ISSUE'          => $issued,
                    'ACTION_NAME'       => $task_name,
                    'ACTION_REMARKS'    => $remarks_action,
                    'ASSIGN_TO'         => $assign_to,
                    'ASSIGN_TO_DETAIL'  => $assign_to_detail,
                    'DUE_DATE'          => $due_date,
                    'ATTACHMENT'        => $attachment,
                    'ACTION_STATUS'     => 'OPEN',
            );

            if (!empty($pic_name)) {
                for($i=0;$i<count($pic_name);$i++){
                    $seqPic = $this->rzkt->get_sequence("PRIME_ACTION_PIC_SEQ");
                    if (!empty($pic_name[$i])) {
                        $picArr = array(
                                'ID_PIC'         => $seqPic['ID'],
                                'ID_ACTION_PLAN' => 'AP'.$seqAction['ID'],
                                'PIC_NAME'       => $pic_name[$i],
                                'PIC_EMAIL'      => $pic_email[$i],
                            );
                        array_push($arrPic, $picArr);
                    }
                }
            } 

            $this->add_credit_point('ACTION PLAN '.$data['ID_ACTION_PLAN'],$id_project,"ADD ACTION PLAN",1,json_encode($data));
            $this->addLog($id_project,'ADD ACTION PLAN','PROJECT',json_encode($data));
            $this->Project_model->addAction($data,$arrPic);
            
        }

    function get_detail_action_plan() {
        $id = $this->input->post('id_action_plan');
        $data = $this->Project_model->get_detail_action_plan($id);
        echo json_encode($data);
    }

    function editTableDeliverableOLD(){
        $data = $this->input->post('data');
        $deliverable_index = array();
        $deliverable = array();
        //echo json_encode($data);
        
        for ($i=0; $i < count($data) ; $i++) { 
            if (!empty($data[$i][0])) {
                $deliverable_index[$i] = $data[$i][0];
            
                foreach ($data as $key => $value) {
                    $index = 1;
                    foreach ($value as $key1 => $value1) {
                        if($key1>2){
                        //echo $key1.' = '.$value1.'<br>';
                        $deliverable[$deliverable_index[$i]][$index] = $value1;           
                        $index++;
                        }
                    }
                }
            }
        }

        echo json_encode($deliverable);die;
    }

    function editTableDeliverable($id_project){
        $data = $this->input->post('data');
        //echo json_encode($data);die;
        $deliverable = array();
        $p_ach  = 0;
        if(!empty($data[0])){
            $id_deliverable = $data[0];
            //echo $id_project;
            //echo $id_deliverable;
            $index = 1;
            foreach($data as $key => $value) {
                if($key>2){
                     
                    if($key != 3){
                    $p_ach               = !empty($data[$key-1]) ?  str_replace(",","",$data[$key-1]) : 0;    
                    }else{
                    $p_ach               = 0;
                    }
                    
                     
                    if(($data[$key]==0)&&($key != 3)&&($data[$key-1]!=0)){
                        $ach                 = str_replace(",","",$value);  
                    }else{
                        $ach                 = str_replace(",","",$value);  
                        $deliverable[$index] = $ach - $p_ach; 
                    }
                    //echo $index.' = '.$deliverable[$index].'<br>';         
                    $index++;
                }

            }

            if(!empty($deliverable)){
                $this->Project_model->delete_manual_s_curve($id_project,$id_deliverable);
                $this->Project_model->update_manual_s_curve($id_project,$id_deliverable,$deliverable);
            }
        }
    }


    function editTablePlan($id_project){
        $data = $this->input->post('data');
        //echo json_encode($data);die;
        $deliverable = array();
        $p_ach  = 0;
        if(!empty($data[0])){
            $id_deliverable = $data[0];
            //echo $id_project;
            //echo $id_deliverable;
            $index = 1;
            foreach($data as $key => $value) {
                if($key>2){
                     
                    if($key != 3){
                    $p_ach               = !empty($data[$key-1]) ?  str_replace(",","",$data[$key-1]) : 0;    
                    }else{
                    $p_ach               = 0;
                    } 
                    
                     
                    if(($data[$key]==0)&&($key != 3)&&($data[$key-1]!=0)){
                        $ach                 = str_replace(",","",$value);  
                    }else{
                        $ach                 = str_replace(",","",$value);  
                        $deliverable[$index] = $ach - $p_ach; 
                    }
                    //echo $index.' = '.$deliverable[$index].'<br>';         
                    $index++;
                }

            }

            $kurva = $this->Project_model->getKurva_s($id_project);

            foreach ($kurva as $key => $value) { 
                $plan = $kurva[$key]['WEIGHT'];
                if($key != 0){
                    $plan = 0;
                    for ($i=0; $i < $key ; $i++) { 
                        $plan = $plan + $kurva[$i]['WEIGHT'];
                    }
                    
                }
                echo $kurva[$key]['WEEK'].' = '.$plan."<br>";
                $this->Project_model->update_curve_plan($id_project, $kurva[$key]['WEEK'],$plan);
                echo $this->db->last_query()."<br><br><br>";
            }
            /*die;
            echo json_encode($kurva);die*/;
            //echo json_encode($deliverable);die;

            if(!empty($deliverable)){
                $this->Project_model->delete_manual_s_curve_plan($id_project,$id_deliverable);
                $this->Project_model->update_manual_s_curve_plan($id_project,$id_deliverable,$deliverable);
            }
        }
    }

    function delete_action_plan($id,$id_proj){
        if($this->Project_model->delete_action_plan($id,$id_proj)){
            $this->addLog($id_proj,'DELETE ACTION','PROJECT',$id);
            echo 'success';
        }else{
            return 'error';
        };

    }

    function addDocumentProject($id_project){
        $this->load->library('upload');
        //untuk upload dokumen proyek
        $targetDir = '../_files/'.$id_project;
        if(!is_dir($targetDir)){
            mkdir($targetDir,0777);
        }

        $config['upload_path'] = $targetDir;
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
                
        $this->upload->initialize($config);


        $files = $_FILES['documentProject'];
        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']     = $files['name'][$key];
            $_FILES['images[]']['type']     = $files['type'][$key];
            $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['images[]']['error']    = $files['error'][$key];
            $_FILES['images[]']['size']     = $files['size'][$key];

            if(!empty($_FILES['images[]']['name'])){
                if ($this->upload->do_upload('images[]')) {
                    $dataUpload = $this->upload->data();
                    $dataInsert['ID_PROJECT'] = $id_project; 
                    $dataInsert['CATEGORY'] = $this->input->post('document_category'); 
                    $dataInsert['ATTACHMENT'] = $id_project.'/'.$dataUpload['file_name'];  
                    $dataInsert['NAME'] = $dataUpload['file_name']; 

                    $this->Project_model->addDocumentProject($dataInsert); 
                    $result['result'] = 'success';
                    $this->Project_model->updateLogProject($id_project);
                    $this->add_credit_point('DOCUMENT',$id_project,"ADD DOCUMENT ".$dataInsert['CATEGORY'],1,json_encode($dataInsert));
                    $this->addLog($id_project,'ADD DOCUMENT','PROJECT',json_encode($dataInsert));
                    echo json_encode($result);
                } else {
                    echo 'error';
                }
            }
        }
    }

// DOWNLOAD
    function download_list_active_projects(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Project_model->download_list_active_projects();

        $name = 'List Active Projects-'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array( 
             array('name' => 'ID PROJECT', 'id' => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'ID LOP', 'id' => 'ID_LOP_EPIC', 'width' => 10)
            ,array('name' => 'CATEGORY', 'id' => 'SCALE', 'width' => 10)
            ,array('name' => 'NAME', 'id' => 'PROJECT_NAME', 'width' => 60)
            ,array('name' => 'TYPE', 'id' => 'TYPE', 'width' => 20)
            ,array('name' => 'START DATE', 'id' => 'START_DATE', 'width' => 15)
            ,array('name' => 'END DATE', 'id' => 'END_DATE', 'width' => 15)
            ,array('name' => 'CUSTOMER', 'id' => 'NAMACC', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMEN', 'width' => 10)
            ,array('name' => 'PARTNER', 'id' => 'PARTNERS', 'width' => 30)
            ,array('name' => 'STATUS', 'id' => 'STATUS', 'width' => 20)
            ,array('name' => 'PLAN (This Week)', 'id' => 'PLAN', 'width' => 20)
            ,array('name' => 'ACHIEVEMENT', 'id' => 'ACH', 'width' => 10)
            ,array('name' => 'DEVIASI', 'id' => 'DEVIASI', 'width' => 10)
            ,array('name' => 'VALUE', 'id' => 'VALUE', 'width' => 20 ,'type' => 'number')
            ,array('name' => 'POTENTIAL SCALING THIS WEEK', 'id' => 'POTENTIAL_WEEK', 'width' => 30)
            ,array('name' => 'POTENTIAL SCALING', 'id' => 'POTENTIAL', 'width' => 20)
            ,array('name' => 'PM NAME', 'id' => 'PM_NAME', 'width' => 30)
            ,array('name' => 'AM NAME', 'id' => 'AM_NAME', 'width' => 30)
            ,array('name' => 'NOMOR KB', 'id' => 'NO_KB', 'width' => 10)
            ,array('name' => 'NOMOR KL', 'id' => 'NO_KL', 'width' => 10)
            ,array('name' => 'REASON OF DELAY', 'id' => 'REASON', 'width' => 50)
            ,array('name' => 'LAST UPDATE', 'id' => 'LAST_UPDATED', 'width' => 30)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }


    function download_list_active_projects_detail(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Project_model->download_list_active_projects_detail();
        //echo json_encode($data);die;
        $name = 'List Active Projects-'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name 
                ,'description' => $name 
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'ID PROJECT', 'id'         => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'ID LOP', 'id'             => 'ID_LOP_EPIC', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id'       => 'PROJECT_NAME', 'width' => 120)
            ,array('name' => 'TYPE PROJECT', 'id'       => 'TYPE', 'width' => 20)
            ,array('name' => 'CLIENT', 'id'             => 'STANDARD_NAME', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id'             => 'SEGMEN', 'width' => 10)
            ,array('name' => 'PM NAME', 'id'            => 'PM_NAME', 'width' => 30)
            ,array('name' => 'AM NAME', 'id'            => 'AM_NAME', 'width' => 30)
            ,array('name' => 'PARTNERS', 'id'           => 'PARTNERS', 'width' => 120)
            ,array('name' => 'START DATE', 'id'         => 'START_DATE', 'width' => 40)
            ,array('name' => 'END DATE (PLAN)', 'id'    => 'TARGET_AWAL', 'width' => 40)
            ,array('name' => 'END DATE', 'id'           => 'TARGET', 'width' => 10)
            ,array('name' => 'DURATION', 'id'           => 'DURATION', 'width' => 10)
            ,array('name' => 'PLAN', 'id'               => 'PLAN', 'width' => 10)
            ,array('name' => 'ACHIEVEMENT', 'id'        => 'ACH', 'width' => 20)
            ,array('name' => 'DEVIATION', 'id'          => 'DEVIATION', 'width' => 50)
            ,array('name' => 'STATUS CATEGORY', 'id'    => 'KATEGORI_STATUS_PROJECT', 'width' => 30)
            ,array('name' => 'REASON OF DELAYY (SYMTOM)', 'id'   => 'REASON_OF_DELAY', 'width' => 30)
            ,array('name' => 'ISSUES', 'id'             => 'ISSUES', 'width' => 30)
            ,array('name' => 'IMPACT', 'id'             => 'IMPACT', 'width' => 30)
            ,array('name' => 'RISK IMPACT', 'id'        => 'RISK_IMPACT', 'width' => 30)
            ,array('name' => 'ACTION PLAN', 'id'        => 'ACTION_PLAN', 'width' => 30)
            ,array('name' => 'ACTION REMARKS', 'id'     => 'ACTION_REMARKS', 'width' => 30)
            ,array('name' => 'ASSIGN TO', 'id'          => 'ASSIGN_TO', 'width' => 30)
            ,array('name' => 'DUE DATE', 'id'           => 'DUE_DATE', 'width' => 30)
            ,array('name' => 'ACTION INDICATOR', 'id'   => 'ACTION_INDOCATOR', 'width' => 30)
            ,array('name' => 'PROJECT VALUE', 'id'      => 'PROJECT_VALUES', 'width' => 30)
            ,array('name' => 'GROUPS', 'id'             => 'SCALE', 'width' => 30)
            ,array('name' => 'LAST_UPDATE', 'id'        => 'LAST_UPDATED', 'width' => 30)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }

    function download_list_active_projects_detail_deliverable(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Project_model->download_list_active_projects_detail_deliverable();
        //echo json_encode($data);die;
        $name = 'List Deliverable -'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name 
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'ID PROJECT', 'id'             => 'ID_PROJECT', 'width' => 10),
             array('name' => 'ID DELIVERABLE', 'id'         => 'ID_DELIVERABLE', 'width' => 10),
             array('name' => 'NAME', 'id'                   => 'PROJECT_NAME', 'width' => 10),
             array('name' => 'DELIVERABLE NAME', 'id'       => 'DELIVERABLE_NAME', 'width' => 10),
             array('name' => 'DESCRIPTION', 'id'            => 'DESCRIPTION', 'width' => 10),
             array('name' => 'WEIGHT', 'id'                 => 'PLAN', 'width' => 10),
             array('name' => 'ACHIEVEMENT', 'id'            => 'ACHIEVEMENT', 'width' => 10),
             array('name' => 'START DATE', 'id'             => 'START_DATE', 'width' => 10),
             array('name' => 'END DATE', 'id'               => 'END_DATE', 'width' => 10),
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }

    function download_list_candidate_projects(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Project_model->download_list_candidate_projects();

        $name = 'Candidate Projects-'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'ID PROJECT', 'id' => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'ID LOP', 'id' => 'ID_LOP_EPIC', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id' => 'NAME', 'width' => 120)
            ,array('name' => 'CLIENT', 'id' => 'STANDARD_NAME', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMEN', 'width' => 10)
            ,array('name' => 'PARTNERS', 'id' => 'PARTNERS', 'width' => 120)
            ,array('name' => 'PROJECT VALUE', 'id' => 'VALUE', 'width' => 30)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }

    function download_list_closed_projects(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Project_model->download_list_closed_projects();
        //echo $this->db->last_query();die;
        //echo json_encode($data);die;
        $name = 'Closed Projects-'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name 
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'ID PROJECT', 'id' => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'ID LOP', 'id' => 'ID_LOP_EPIC', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id' => 'NAME', 'width' => 120)
            ,array('name' => 'CUSTOMER', 'id' => 'STANDARD_NAME', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMEN', 'width' => 10)
            ,array('name' => 'PROJECT MANAGER', 'id' => 'PM_NAME', 'width' => 10)
            ,array('name' => 'ACCOUNT MANAGER', 'id' => 'AM_NAME', 'width' => 10)
            ,array('name' => 'PARTNERS', 'id' => 'MITRA', 'width' => 120)
            ,array('name' => 'PROJECT VALUE', 'id' => 'VALUE', 'width' => 30)
            ,array('name' => 'START DATE', 'id' => 'START_DATE', 'width' => 20)
            ,array('name' => 'END DATE', 'id' => 'END_DATE', 'width' => 20)
            ,array('name' => 'CLOSED DATE', 'id' => 'CLOSED_DATE', 'width' => 20)
            ,array('name' => 'CLOSED BY', 'id' => 'CLOSED_BY_NAME', 'width' => 20) 
            ,array('name' => 'TYPE', 'id' => 'TYPE', 'width' => 20)      
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }

    function download_projects_non_pm(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Project_model->download_list_non_pm_projects();
        //echo $this->db->last_query();die;
        //echo json_encode($data);die;
        $name = 'Projects NON PM-'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name 
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'ID PROJECT', 'id' => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'ID LOP', 'id' => 'ID_LOP_EPIC', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id' => 'NAME', 'width' => 120)
            ,array('name' => 'CUSTOMER', 'id' => 'STANDARD_NAME', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMEN', 'width' => 10)
            ,array('name' => 'PROJECT MANAGER', 'id' => 'PM_NAME', 'width' => 10)
            ,array('name' => 'ACCOUNT MANAGER', 'id' => 'AM_NAME', 'width' => 10)
            ,array('name' => 'PROJECT VALUE', 'id' => 'VALUE', 'width' => 30)
            ,array('name' => 'START DATE', 'id' => 'START_DATE', 'width' => 20)
            ,array('name' => 'END DATE', 'id' => 'END_DATE', 'width' => 20)
            ,array('name' => 'CLOSED DATE', 'id' => 'CLOSED_DATE', 'width' => 20)
            ,array('name' => 'CLOSED BY', 'id' => 'CLOSED_BY_NAME', 'width' => 20) 
            
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }


    function update_symtom($id_project){
        $result['data'] = 'error';
        $data['REASON_OF_DELAY']      = trim($this->input->post('symptom'));
        $data['ID_PROJECT']           = $id_project;

        $dataSymptom = array(
            'ID' => $this->getGUID(), 
            'ID_PROJECT' => $id_project, 
            'SYMPTOM' => $data['REASON_OF_DELAY'], 
            );

        $this->Project_model->addSymptom($dataSymptom);

        $this->add_credit_point('SYMTOM',$id_project,"UPDATE SYMTOM ". $data['REASON_OF_DELAY'] ,1,json_encode($data));

        if($this->Project_model->update_symtom($data)){
        $result['data'] = 'success';    
        };
        //echo $this->db->last_query();die;
        echo json_encode($result);
    }


    function update_action_plan_proccess($id_action_plan) {
            $task_name      = $this->input->post('task_name');
            $issued         = $this->input->post('issued');
            $assign_to      = $this->input->post('assignto');
            $assign_to_detail = $this->input->post('assignto_detail');
            $due_date       = $this->input->post('due_date');
            $remarks_action = $this->input->post('remarks_action');
            $pic_name       = $this->input->post('pic_name');
            $pic_email      = $this->input->post('pic_email');
            $attachment     = $this->input->post('attachment_action_value');
            $status         = $this->input->post('status_action');
            $idPro          = $id_project = $this->input->post('idPro');
            $closed_date    = $this->input->post('action_closed_date');
            $arrPic         = array();

            // get sequences
            $seqAction = $this->rzkt->get_sequence("PRIME_PROJECT_ACTION_SEQ");
            
            $data = array(
                    'ID_ACTION_PLAN'    => $id_action_plan,
                    'ID_PROJECT'        => $id_project,
                    'ID_ISSUE'          => $issued,
                    'ACTION_NAME'       => $task_name,
                    'ACTION_REMARKS'    => $remarks_action,
                    'ASSIGN_TO'         => $assign_to,
                    'ASSIGN_TO_DETAIL'  => $assign_to_detail,
                    'DUE_DATE'          => $due_date,
                    'ATTACHMENT'        => $attachment,
                    'ACTION_STATUS'     => $status,
                    'ACTION_CLOSED_DATE'=> $closed_date
            );

            if (!empty($pic_name)) {
                for($i=0;$i<count($pic_name);$i++){
                    $seqPic = $this->rzkt->get_sequence("PRIME_ACTION_PIC_SEQ");
                    if (!empty($pic_name[$i])) {
                        $picArr = array(
                                'ID_PIC'         => $seqPic['ID'],
                                'ID_ACTION_PLAN' => 'AP'.$seqAction['ID'],
                                'PIC_NAME'       => $pic_name[$i],
                                'PIC_EMAIL'      => $pic_email[$i],
                            );
                        array_push($arrPic, $picArr);
                    }
                }
            } 

            $this->add_credit_point('ACTION PLAN '.$id_action_plan,$id_project,"UPDATE ACTION PLAN",1,json_encode($data));
            $this->Project_model->updateAction($data,$arrPic);
            $this->addLog($id_project,'UPDATE ACTION PLAN','PROJECT',json_encode($data));
            
        }


    function refreshProject(){
        return $this->Project_model->refreshProject();
    }

    


    function send_batch_project_to_epic(){
        $data   =     $this->Project_model->getDataProjectEpic();
        /*http://des.telkom.co.id/epic/index.php/api/project/status?id=LOP222&status=testStatus&status_project=testProject&ach=1000&symptons=testSymtons&nama_pm=Harisa&assign=YA*/
    }

    function test(){
        $data = json_decode('{"1-2630202394":"1-2634286298","1-2630265854":"1-2632100230","1-2630202146":"1-2632057180","1-2630070764":"1-2632018560","1-2630070524":"1-2631976050","1-2630139064":"1-2632546245","1-2629984434":"1-2631912396","1-2629130494":"1-2631648462","1-2629123414":"1-2631808197, 1-2631808512, 1-2631808826","1-2629130044":"1-2631610084","1-2626609914":"1-2632141577"}');
        $no_qo = array();
        foreach ($data as $key => $value) {
            $no_qo[$key] = explode(',', $value);
            foreach ($no_qo[$key] as $key1 => $value1) {
                echo $key.' = '.$value1.'<br>';
            }
        }
    }


    // Delete Project

    function delete_project(){
        $id = $this->input->post('id');
        $result['data'] = 'false';
        if($this->Project_model->deleteProject($id)){
            $this->addLog($this->session->userdata('nik_sess'),'DELETE PROJECT','PROJECT',$id);
            $result['data'] = 'success';
        }
        echo json_encode($result);
    }



    // Update Acquisition
    function update_acquisition($id_project){
        $data['id_project']         = $id_project;
        $data['acquistion']         = $this->Project_model->getAllDataAcquisition($id_project);
        $data['value_project']      = $this->Project_model->get_detail_project($id_project)['VALUE'];
        $month          = date('n');
        $month_lm       = $month - 1;
        $year           = date('Y');
            if($month_lm==0){
                $month_lm       = 12;
                $year           = $year - 1;
            }


        $top                = array('OTC','RECCURING','PROGRESS','TERMIN','DP');
        $acq                = array();
        $acq_lm             = array();

        foreach ($top as $key => $value) {
             $acq[$value]       = $this->Project_model->getAcquisition($id_project,$month,$value);
             $acq_lm[$value]    = $this->Project_model->getAcquisition($id_project,$month_lm,$value,$year);
        }

        $data['acq']        = $acq;
        $data['acq_lm']     = $acq_lm;
        //echo json_encode($acq);die;
        //echo json_encode($data['acquistion']);die;
        $this->myView('projects/update_acquisition2',$data);

    }

    // Update Acquisition
    function saveAcquisition($id_project){
        $data['MONTH']                      = $data_c['MONTH']      = $month = date('n');
        $month_l                            = $data_l['MONTH']      = $month - 1;
        $id_project                         = $data_c['ID_PROJECT'] = $data_l['ID_PROJECT'] =  $this->input->post('idPro');
        $year = date('Y');
        if($month_l == 0){
            $month_l = 12;
            $year  = $year -1;
        }

        $data_l['ACQ']                   = $this->input->post('total_acquisition_lm');
        $data_l['ACQ_RECCURING']         = $this->input->post('total_acquisition_re_lm');
        $data_l['ACQ_RECCURING_START']   = $this->input->post('total_acquisition_re_lm_start');
        $data_l['ACQ_RECCURING_END']     = $this->input->post('total_acquisition_re_lm_end');

        $data_c['TARGET_ACQ']                 = $this->input->post('estimated_acquisition');
        $data_c['TARGET_ACQ_RECCURING']       = $this->input->post('estimated_acquisition_re');
        $data_c['TARGET_ACQ_RECCURING_START'] = $this->input->post('estimated_acquisition_re_start');
        $data_c['TARGET_ACQ_RECCURING_END']   = $this->input->post('estimated_acquisitio_re_end');

        $data_c['NOTE']                       = $this->input->post('note_acquisition');
        $data_c['UPDATED_BY']                 = $data_l['UPDATED_BY'] = $this->session->userdata('nik_sess');

        $checkAcquisition_l  = $this->Project_model->checkAcquisition($year,$id_project,$month_l);
        $checkAcquisition_c  = $this->Project_model->checkAcquisition($year,$id_project,$month);

        if($checkAcquisition_l == 0){
            $data_l['ID']     = $this->getGUID();
            //add acquistion
            $this->Project_model->saveAcquisition($data_l); 
        }else{
            $this->Project_model->updateAcquisition($id_project,$data_l['MONTH'],$data_l);
        }

        if($checkAcquisition_c == 0){
            $data_c['ID']     = $this->getGUID();
            $this->Project_model->saveAcquisitionT($data_c); 
        }else{
            $this->Project_model->updateAcquisitionT($id_project,$data_c['MONTH'],$data_c);
        }

        $result['data'] = 'success';
        echo json_encode($result);  

    }

    function saveAcq(){
        $data           = $this->input->post();
        $result['data'] = 'success';
        $month          = date('n');
        $month_lm       = $month - 1;
        $id_project     = $this->input->post('id_project');
        $model          = array();
        $model1         = array();
        $model2         = array();
        $model3         = array();
        $model4         = array();
        $model5         = array();
        $model6         = array();
        $model7         = array();
        $sum            = 0;
        $sum_lm         = 0;

        $year = date('Y');
        if($month_lm == 0){
            $month_lm = 12;
            $year  = $year -1;
        }

        $this->Project_model->deleteAcq($id_project,$month);
        $this->Project_model->deleteAcq($id_project,$month_lm,$year);

        if(!empty($data['otc_lm'])){
            $model1['ID']        = $this->getGUID();
            $model1['TOP']               = 'OTC';
            $model1['ACQ']        = $this->input->post('otc_value_lm');
            $model1['PROGRESS']          = $this->input->post('otc_percent_lm');
            $model1['NOTE']          = $this->input->post('otc_note_lm');

            $model1['ID_PROJECT'] = $id_project;
            $model1['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model1['MONTH']      = $month_lm;
$model1['YEAR']      = $year;
            $c_acq               = $this->Project_model->getSumAcq($id_project,$model1['TOP'],$model1['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model1['C_ACQ']  = $c_acq + $model1['ACQ']; 
            }else{
                $model1['C_ACQ']  = $model1['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model1['TOP'],$model1['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model1['C_PROGRESS']  = $c_progress  + $model1['PROGRESS'];
            }else{
                $model1['C_PROGRESS']  = $model1['PROGRESS'];
            }



            $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'OTC');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model1); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model1,'OTC');
            }

            if(!empty($model1['ACQ'])){
                $sum_lm = $sum_lm + $model1['ACQ'];
            }
        }

        if(!empty($data['otc'])){
            $model['ID']        = $this->getGUID();
            $model['TOP']               = 'OTC';
            $model['ACQ']        = $this->input->post('otc_value');
            $model['PROGRESS']          = $this->input->post('otc_percent');
            $model['NOTE']          = $this->input->post('otc_note');

            $model['ID_PROJECT'] = $id_project;
            $model['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model['MONTH']      = $month;
            $c_acq               = $this->Project_model->getSumAcq($id_project,$model['TOP'],$model['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model['C_ACQ']  = $c_acq + $model['ACQ']; 
            }else{
                $model['C_ACQ']  = $model['ACQ'];
            }


            $c_progress               = $this->Project_model->getSumProgress($id_project,$model['TOP'],$model['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model['C_PROGRESS']  = $c_progress  + $model['PROGRESS'];
            }else{
                $model['C_PROGRESS']  = $model['PROGRESS'];
            }

            $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'OTC');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month,$model,'OTC');
            }


            if(!empty($model['ACQ'])){ 
            }
        }

        if(!empty($data['reccuring_lm'])){
            $model3['ID']        = $this->getGUID();
            $model3['TOP']               = 'RECCURING';
            $model3['ACQ']        = $this->input->post('recc_value_lm');
            $model3['PROGRESS']          = $this->input->post('recc_percent_lm');
            $model3['RECCURING_START']   = $this->input->post('recc_start_lm');
            $model3['RECCURING_END']   = $this->input->post('recc_end_lm');
            $model3['NOTE']   = $this->input->post('recc_note_lm');

            $model3['ID_PROJECT'] = $id_project;
            $model3['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model3['MONTH']      = $month_lm;
$model3['YEAR']      = $year;

            $c_acq               = $this->Project_model->getSumAcq($id_project,$model3['TOP'],$model3['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model3['C_ACQ']  = $c_acq + $model3['ACQ']; 
            }else{
                $model3['C_ACQ']  = $model3['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model3['TOP'],$model3['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model3['C_PROGRESS']  = $c_progress  + $model3['PROGRESS'];
            }else{
                $model3['C_PROGRESS']  = $model3['PROGRESS'];
            }


            $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'RECCURING');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model3); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model3,'RECCURING');
            }

            if(!empty($model3['ACQ'])){
                $sum_lm = $sum_lm + $model3['ACQ'];
            }
        }

        if(!empty($data['reccuring'])){
            $model2['ID']        = $this->getGUID();
            $model2['TOP']               = 'RECCURING';
            $model2['ACQ']        = $this->input->post('recc_value');
            $model2['PROGRESS']          = $this->input->post('recc_percent');
            $model2['RECCURING_START']   = $this->input->post('recc_start');
            $model2['RECCURING_END']   = $this->input->post('recc_end');
            $model2['NOTE']   = $this->input->post('recc_note');

            $model2['ID_PROJECT'] = $id_project;
            $model2['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model2['MONTH']      = $month;
            $c_acq               = $this->Project_model->getSumAcq($id_project,$model2['TOP'],$model2['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model2['C_ACQ']  = $c_acq + $model2['ACQ']; 
            }else{
                $model2['C_ACQ']  = $model2['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model2['TOP'],$model2['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model2['C_PROGRESS']  = $c_progress  + $model2['PROGRESS'];
            }else{
                $model2['C_PROGRESS']  = $model2['PROGRESS'];
            }


            $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'RECCURING');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model2); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month,$model2,'RECCURING');
            }

            if(!empty($model2['ACQ'])){
                $sum = $sum + $model2['ACQ'];
            }
        }

        
        if(!empty($data['termin_lm'])){
            $model5['ID']        = $this->getGUID();
            $model5['TOP']               = 'TERMIN';
            $model5['ACQ']        = $this->input->post('termin_value_lm');
            $model5['PROGRESS']          = $this->input->post('termin_percent_lm');
            $model5['TERMIN']            = $this->input->post('termin_ke_lm');
            $model5['NOTE']            = $this->input->post('termin_note_lm');

            $model5['ID_PROJECT'] = $id_project;
            $model5['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model5['MONTH']      = $month_lm;
            $model5['YEAR']      = $year;

            $c_acq               = $this->Project_model->getSumAcq($id_project,$model5['TOP'],$model5['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model5['C_ACQ']  = $c_acq + $model5['ACQ']; 
            }else{
                $model5['C_ACQ']  = $model5['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model5['TOP'],$model5['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model5['C_PROGRESS']  = $c_progress  + $model5['PROGRESS'];
            }else{
                $model5['C_PROGRESS']  = $model5['PROGRESS'];
            }

            $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'TERMIN');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model5); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model5,'TERMIN');
            }

            if(!empty($model5['ACQ'])){
                $sum_lm = $sum_lm + $model5['ACQ'];
            }
        }

        if(!empty($data['termin'])){
            $model4['ID']        = $this->getGUID();
            $model4['TOP']               = 'TERMIN';
            $model4['ACQ']        = $this->input->post('termin_value');
            $model4['PROGRESS']          = $this->input->post('termin_percent');
            $model4['TERMIN']            = $this->input->post('termin_ke');
            $model4['NOTE']              = $this->input->post('termin_note');

            $model4['ID_PROJECT'] = $id_project;
            $model4['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model4['MONTH']      = $month;
            $c_acq               = $this->Project_model->getSumAcq($id_project,$model4['TOP'],$model4['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model4['C_ACQ']  = $c_acq + $model4['ACQ']; 
            }else{
                $model4['C_ACQ']  = $model4['ACQ'];
            }


            $c_progress               = $this->Project_model->getSumProgress($id_project,$model4['TOP'],$model4['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model4['C_PROGRESS']  = $c_progress  + $model4['PROGRESS'];
            }else{
                $model4['C_PROGRESS']  = $model4['PROGRESS'];
            }


            $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'TERMIN');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model4); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month,$model4,'TERMIN');
            }

            if(!empty($model4['ACQ'])){
                $sum = $sum + $model4['ACQ'];
            }
        }      

        if(!empty($data['progress_lm'])){
            $model7['ID']                = $this->getGUID();
            $model7['TOP']               = 'PROGRESS';
            $model7['ACQ']        = $this->input->post('progress_value_lm');
            $model7['PROGRESS']          = $this->input->post('progress_percent_lm');
            $model7['NOTE']          = $this->input->post('progress_note_lm');

            $model7['ID_PROJECT'] = $id_project;
            $model7['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model7['MONTH']      = $month_lm;
$model7['YEAR']      = $year;

            $c_acq               = $this->Project_model->getSumAcq($id_project,$model7['TOP'],$model7['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model7['C_ACQ']  = $c_acq + $model7['ACQ']; 	
            }else{
                $model7['C_ACQ']  = $model7['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model7['TOP'],$model7['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model7['C_PROGRESS']  = $c_progress  + $model7['PROGRESS'];
            }else{
                $model7['C_PROGRESS']  = $model7['PROGRESS'];
            }

            $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'PROGRESS');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model7); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model7,'PROGRESS');
            }

            if(!empty($model7['ACQ'])){
                $sum_lm = $sum_lm + $model7['ACQ'];
            }
        }


        if(!empty($data['progress'])){
            $model6['ID']        = $this->getGUID();
            $model6['TOP']               = 'PROGRESS';
            $model6['ACQ']        = $this->input->post('progress_value');
            $model6['PROGRESS']    = $this->input->post('progress_percent');
            $model6['NOTE']          = $this->input->post('progress_note');

            $model6['ID_PROJECT'] = $id_project;
            $model6['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model6['MONTH']      = $month;

            $c_acq               = $this->Project_model->getSumAcq($id_project,$model6['TOP'],$model6['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model6['C_ACQ']  = $c_acq + $model6['ACQ']; 
            }else{
                $model6['C_ACQ']  = $model6['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model6['TOP'],$model6['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model6['C_PROGRESS']  = $c_progress  + $model6['PROGRESS'];
            }else{
                $model6['C_PROGRESS']  = $model6['PROGRESS'];
            }

            $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'PROGRESS');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model6); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month,$model6,'PROGRESS');
            }

            if(!empty($model6['ACQ'])){
                $sum = $sum + $model6['ACQ'];
            }
        }

       
        if(!empty($data['dp_lm'])){
            $model9['ID']                = $this->getGUID();
            $model9['TOP']               = 'DP';
            $model9['ACQ']               = $this->input->post('dp_value_lm');
            $model9['PROGRESS']          = $this->input->post('dp_percent_lm');
            $model9['NOTE']              = $this->input->post('dp_note_lm');

            $model9['ID_PROJECT']        = $id_project;
            $model9['UPDATED_BY']        = $this->session->userdata('nik_sess');
            $model9['MONTH']      = $month_lm;
            $model9['YEAR']      = $year;

            $c_acq               = $this->Project_model->getSumAcq($id_project,$model9['TOP'],$model9['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model9['C_ACQ']  = $c_acq;
            }else{
                $model9['C_ACQ']  = $model9['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model9['TOP'],$model9['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model9['C_PROGRESS']  = $c_progress  + $model9['PROGRESS'];
            }else{
                $model9['C_PROGRESS']  = $model9['PROGRESS'];
            }

            $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'DP');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model9); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model9,'DP');
            }

            if(!empty($model9['ACQ'])){
                $sum_lm = $sum_lm + $model9['ACQ'];
            }
        }

         if(!empty($data['dp'])){
            $model8['ID']        = $this->getGUID();
            $model8['TOP']               = 'DP';
            $model8['ACQ']        = $this->input->post('dp_value');
            $model8['PROGRESS']          = $this->input->post('dp_percent');
            $model8['NOTE']          = $this->input->post('dp_note');

            $model8['ID_PROJECT'] = $id_project;
            $model8['UPDATED_BY'] = $this->session->userdata('nik_sess');
            $model8['MONTH']      = $month;

            $c_acq               = $this->Project_model->getSumAcq($id_project,$model8['TOP'],$model8['MONTH']); 
            if(!empty($c_acq)||$c_acq != 0 ){
                $model8['C_ACQ']  = $c_acq + $model8['ACQ'];    
            }else{
                $model8['C_ACQ']  = $model8['ACQ'];
            }

            $c_progress               = $this->Project_model->getSumProgress($id_project,$model8['TOP'],$model8['MONTH']); 
            if(!empty($c_progress)||$c_progress != 0 ){
                $model8['C_PROGRESS']  = $c_progress  + $model8['PROGRESS'];
            }else{
                $model8['C_PROGRESS']  = $model8['PROGRESS'];
            }

            $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'DP');

            if($c==0){
                $this->Project_model->saveAcquisitionT($model8); 
            }else{
                $this->Project_model->updateAcquisitionT($id_project,$month,$model8,'DP');
            }

            if(!empty($model8['ACQ'])){
                $sum = $sum + $model8['ACQ'];
            }
        }

        $this->Project_model->update_comulative_acq($id_project,$sum,$month);
        $this->Project_model->update_comulative_acq($id_project,$sum_lm,$month_lm);


        $idAcqFirst = $this->Project_model->acqFirst($id_project);

        if($idAcqFirst==1){
            $data           = $this->input->post();
            $result['data'] = 'success';
            $month          = date('n');
            $month_lm       = $month - 1;
            $id_project     = $this->input->post('id_project');
            $model          = array();
            $model1         = array();
            $model2         = array();
            $model3         = array();
            $model4         = array();
            $model5         = array();
            $model6         = array();
            $model7         = array();
            $sum            = 0;
            $sum_lm         = 0;

            if($month_lm  = 0 ){
                $month_lm   = 12;
            }

            if(!empty($data['otc'])){
                $model['ID']        = $this->getGUID();
                $model['TOP']               = 'OTC';
                $model['ACQ']        = $this->input->post('otc_value');
                $model['PROGRESS']          = $this->input->post('otc_percent');
                $model['NOTE']          = $this->input->post('otc_note');

                $model['ID_PROJECT'] = $id_project;
                $model['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model['MONTH']      = $month;
                $c_acq               = $this->Project_model->getSumAcq($id_project,$model['TOP'],$model['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model['C_ACQ']  = $c_acq + $model['ACQ']; 
                }else{
                    $model['C_ACQ']  = $model['ACQ'];
                }


                $c_progress               = $this->Project_model->getSumProgress($id_project,$model['TOP'],$model['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model['C_PROGRESS']  = $c_progress  + $model['PROGRESS'];
                }else{
                    $model['C_PROGRESS']  = $model['PROGRESS'];
                }

                $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'OTC');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model);  
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month,$model,'OTC');
                }


                if(!empty($model['ACQ'])){ 
                }
            }

            if(!empty($data['otc_lm'])){
                $model1['ID']        = $this->getGUID();
                $model1['TOP']               = 'OTC';
                $model1['ACQ']        = $this->input->post('otc_value_lm');
                $model1['PROGRESS']          = $this->input->post('otc_percent_lm');
                $model1['NOTE']          = $this->input->post('otc_note_lm');

                $model1['VALID'] = '1';

                $model1['ID_PROJECT'] = $id_project;
                $model1['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model1['MONTH']      = $month_lm;
$model1['YEAR']      = $year;
                $c_acq               = $this->Project_model->getSumAcq($id_project,$model1['TOP'],$model1['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model1['C_ACQ']  = $c_acq + $model1['ACQ']; 
                }else{
                    $model1['C_ACQ']  = $model1['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model1['TOP'],$model1['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model1['C_PROGRESS']  = $c_progress  + $model1['PROGRESS'];
                }else{
                    $model1['C_PROGRESS']  = $model1['PROGRESS'];
                }



                $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'OTC');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model1); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model1,'OTC');
                }

                if(!empty($model1['ACQ'])){
                    $sum_lm = $sum_lm + $model['ACQ'];
                }
            }


            if(!empty($data['reccuring'])){
                $model2['ID']        = $this->getGUID();
                $model2['TOP']               = 'RECCURING';
                $model2['ACQ']        = $this->input->post('recc_value');
                $model2['PROGRESS']          = $this->input->post('recc_percent');
                $model2['RECCURING_START']   = $this->input->post('recc_start');
                $model2['RECCURING_END']   = $this->input->post('recc_end');
                $model2['NOTE']   = $this->input->post('recc_note');

                $model2['ID_PROJECT'] = $id_project;
                $model2['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model2['MONTH']      = $month;
                $c_acq               = $this->Project_model->getSumAcq($id_project,$model2['TOP'],$model2['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model2['C_ACQ']  = $c_acq + $model2['ACQ']; 
                }else{
                    $model2['C_ACQ']  = $model2['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model2['TOP'],$model2['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model2['C_PROGRESS']  = $c_progress  + $model2['PROGRESS'];
                }else{
                    $model2['C_PROGRESS']  = $model2['PROGRESS'];
                }


                $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'RECCURING');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model2); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month,$model2,'RECCURING');
                }

                if(!empty($model2['ACQ'])){
                    $sum = $sum + $model2['ACQ'];
                }
            }


            if(!empty($data['reccuring_lm'])){
                $model3['ID']        = $this->getGUID();
                $model3['TOP']               = 'RECCURING';
                $model3['ACQ']        = $this->input->post('recc_value_lm');
                $model3['PROGRESS']          = $this->input->post('recc_percent_lm');
                $model3['RECCURING_START']   = $this->input->post('recc_start_lm');
                $model3['RECCURING_END']   = $this->input->post('recc_end_lm');
                $model3['NOTE']   = $this->input->post('recc_note_lm');
                $model3['VALID'] = '1';
                $model3['ID_PROJECT'] = $id_project;
                $model3['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model3['MONTH']      = $month_lm;
$model3['YEAR']      = $year;

                $c_acq               = $this->Project_model->getSumAcq($id_project,$model3['TOP'],$model3['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model3['C_ACQ']  = $c_acq + $model3['ACQ']; 
                }else{
                    $model3['C_ACQ']  = $model3['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model3['TOP'],$model3['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model3['C_PROGRESS']  = $c_progress  + $model3['PROGRESS'];
                }else{
                    $model3['C_PROGRESS']  = $model3['PROGRESS'];
                }


                $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'RECCURING');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model3); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model3,'RECCURING');
                }

                if(!empty($model3['ACQ'])){
                    $sum_lm = $sum_lm + $model3['ACQ'];
                }
            }

            if(!empty($data['termin'])){
                $model4['ID']        = $this->getGUID();
                $model4['TOP']               = 'TERMIN';
                $model4['ACQ']        = $this->input->post('termin_value');
                $model4['PROGRESS']          = $this->input->post('termin_percent');
                $model4['TERMIN']            = $this->input->post('termin_ke');
                $model4['NOTE']              = $this->input->post('termin_note');

                $model4['ID_PROJECT'] = $id_project;
                $model4['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model4['MONTH']      = $month;
                $c_acq               = $this->Project_model->getSumAcq($id_project,$model4['TOP'],$model4['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model4['C_ACQ']  = $c_acq + $model4['ACQ']; 
                }else{
                    $model4['C_ACQ']  = $model4['ACQ'];
                }


                $c_progress               = $this->Project_model->getSumProgress($id_project,$model4['TOP'],$model4['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model4['C_PROGRESS']  = $c_progress  + $model4['PROGRESS'];
                }else{
                    $model4['C_PROGRESS']  = $model4['PROGRESS'];
                }


                $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'TERMIN');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model4); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month,$model4,'TERMIN');
                }

                if(!empty($model4['ACQ'])){
                    $sum = $sum + $model4['ACQ'];
                }
            }


            if(!empty($data['termin_lm'])){
                $model5['ID']        = $this->getGUID();
                $model5['TOP']               = 'TERMIN';
                $model5['ACQ']        = $this->input->post('termin_value_lm');
                $model5['PROGRESS']          = $this->input->post('termin_percent_lm');
                $model5['TERMIN']            = $this->input->post('termin_ke_lm');
                $model5['NOTE']            = $this->input->post('termin_note_lm');
                $model5['VALID'] = '1';
                $model5['ID_PROJECT'] = $id_project;
                $model5['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model5['MONTH']      = $month_lm;
$model5['YEAR']      = $year;

                $c_acq               = $this->Project_model->getSumAcq($id_project,$model5['TOP'],$model5['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model5['C_ACQ']  = $c_acq + $model5['ACQ']; 
                }else{
                    $model5['C_ACQ']  = $model5['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model5['TOP'],$model5['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model5['C_PROGRESS']  = $c_progress  + $model5['PROGRESS'];
                }else{
                    $model5['C_PROGRESS']  = $model5['PROGRESS'];
                }

                $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'TERMIN');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model5); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model5,'TERMIN');
                }

                if(!empty($model5['ACQ'])){
                    $sum_lm = $sum_lm + $model5['ACQ'];
                }
            }

            if(!empty($data['progress'])){
                $model6['ID']        = $this->getGUID();
                $model6['TOP']               = 'PROGRESS';
                $model6['ACQ']        = $this->input->post('progress_value');
                $model6['PROGRESS']    = $this->input->post('progress_percent');
                $model6['NOTE']          = $this->input->post('progress_note');

                $model6['ID_PROJECT'] = $id_project;
                $model6['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model6['MONTH']      = $month;

                $c_acq               = $this->Project_model->getSumAcq($id_project,$model6['TOP'],$model6['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model6['C_ACQ']  = $c_acq + $model6['ACQ']; 
                }else{
                    $model6['C_ACQ']  = $model6['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model6['TOP'],$model6['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model6['C_PROGRESS']  = $c_progress  + $model6['PROGRESS'];
                }else{
                    $model6['C_PROGRESS']  = $model6['PROGRESS'];
                }

                $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'PROGRESS');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model6); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month,$model6,'PROGRESS');
                }

                if(!empty($model6['ACQ'])){
                    $sum = $sum + $model6['ACQ'];
                }
            }

            if(!empty($data['progress_lm'])){
                $model7['ID']                = $this->getGUID();
                $model7['TOP']               = 'PROGRESS';
                $model7['ACQ']        = $this->input->post('progress_value_lm');
                $model7['PROGRESS']          = $this->input->post('progress_percent_lm');
                $model7['NOTE']          = $this->input->post('progress_note_lm');
                $model7['VALID'] = '1';
                $model7['ID_PROJECT'] = $id_project;
                $model7['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model7['MONTH']      = $month_lm;
$model7['YEAR']      = $year;

                $c_acq               = $this->Project_model->getSumAcq($id_project,$model7['TOP'],$model7['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model7['C_ACQ']  = $c_acq + $model7['ACQ']; 	
                }else{
                    $model7['C_ACQ']  = $model7['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model7['TOP'],$model7['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model7['C_PROGRESS']  = $c_progress  + $model7['PROGRESS'];
                }else{
                    $model7['C_PROGRESS']  = $model7['PROGRESS'];
                }

                $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'PROGRESS');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model7); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model7,'PROGRESS');
                }

                if(!empty($model7['ACQ'])){
                    $sum_lm = $sum_lm + $model7['ACQ'];
                }
            }

            if(!empty($data['dp'])){
                $model8['ID']        = $this->getGUID();
                $model8['TOP']               = 'DP';
                $model8['ACQ']        = $this->input->post('dp_value');
                $model8['PROGRESS']          = $this->input->post('dp_percent');
                $model8['NOTE']          = $this->input->post('dp_note');

                $model8['ID_PROJECT'] = $id_project;
                $model8['UPDATED_BY'] = $this->session->userdata('nik_sess');
                $model8['MONTH']      = $month;

                $c_acq               = $this->Project_model->getSumAcq($id_project,$model8['TOP'],$model8['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model8['C_ACQ']  = $c_acq + $model8['ACQ']; 	
                }else{
                    $model8['C_ACQ']  = $model8['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model8['TOP'],$model8['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model8['C_PROGRESS']  = $c_progress  + $model8['PROGRESS'];
                }else{
                    $model8['C_PROGRESS']  = $model8['PROGRESS'];
                }

                $c = $this->Project_model->checkAcquisition($year,$id_project,$month,'DP');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model8); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month,$model8,'DP');
                }

                if(!empty($model8['ACQ'])){
                    $sum = $sum + $model8['ACQ'];
                }
            }

            if(!empty($data['dp_lm'])){
                $model9['ID']                = $this->getGUID();
                $model9['TOP']               = 'DP';
                $model9['ACQ']               = $this->input->post('dp_value_lm');
                $model9['PROGRESS']          = $this->input->post('dp_percent_lm');
                $model9['NOTE']              = $this->input->post('dp_note_lm');
                $model9['VALID'] = '1';
                $model9['ID_PROJECT']        = $id_project;
                $model9['UPDATED_BY']        = $this->session->userdata('nik_sess');
                $model9['MONTH']      = $month_lm;
$model9['YEAR']      = $year;

                $c_acq               = $this->Project_model->getSumAcq($id_project,$model9['TOP'],$model9['MONTH']); 
                if(!empty($c_acq)||$c_acq != 0 ){
                    $model9['C_ACQ']  = $c_acq;
                }else{
                    $model9['C_ACQ']  = $model9['ACQ'];
                }

                $c_progress               = $this->Project_model->getSumProgress($id_project,$model9['TOP'],$model9['MONTH']); 
                if(!empty($c_progress)||$c_progress != 0 ){
                    $model9['C_PROGRESS']  = $c_progress  + $model9['PROGRESS'];
                }else{
                    $model9['C_PROGRESS']  = $model9['PROGRESS'];
                }

                $c = $this->Project_model->checkAcquisition($year,$id_project,$month_lm,'DP');

                if($c==0){
                    $this->Project_model->saveAcquisitionT($model9); 
                }else{
                    $this->Project_model->updateAcquisitionT($id_project,$month_lm,$model9,'DP');
                }

                if(!empty($model9['ACQ'])){
                    $sum_lm = $sum_lm + $model9['ACQ'];
                }
            }

            $this->Project_model->update_comulative_acq($id_project,$sum,$month);
            $this->Project_model->update_comulative_acq($id_project,$sum_lm,$month_lm);
        }

        $this->add_credit_point('ACQUISTION '.$month.' '.date('Y'),$id_project,"UPDATE ACQUISTION",1,"'".$sum."'");
        $this->addLog($id_project,'UPDATE ACQUISTION','PROJECT',date('F Y'));
        echo json_encode($result);
    }


    /*function monitoring($id_project){
        $data['id_project'] = $id_project;
        //echo date('d/m/Y H:i:s');die;
        $project            = $data['project']  =   $this->Project_model->get_detail_project($id_project);
        $data['title']      = $project['NAME'];
        $gantt["tasks"]              = array();
        $gantt["resource"]           = array();
        $gantt["deletedTaskIds"]     = array();
        $gantt["selectedRow"]        = intval(0);
        $gantt["canWrite"]           = true;
        $gantt["canDelete"]          = true;
        $gantt["canWriteOnParent"]   = true;
        $gantt["canAdd"]             = true;

        $task                        = $this->Project_model->getDataTask($id_project);
        $o_task                      = array();
        foreach ($task as $key => $value) {
            $container          = array();
            $container['id']        = $value['IDS']; 
            $container['name']      = $value['NAME']; 
            $container['code']      = $value['CODE']; 
            $container['start']      = floatval($value['START2']); 
            $container['end']        = floatval($value['END2']); 
            $container['level']     = intval(0); 
            $container['status']    = "STATUS_ACTIVE"; 
            $container['duration']  = intval($value['DURATION']); 
            $container['assigs']            = array(); 
            array_push($o_task, $container);
        }
        $gantt['tasks']                = $o_task; 
        $data['gantt']               = $gantt;
        $this->myViewClean('projects/monitoring', $data); 
    }*/

    function monitoring($id_project){
        $data['id_project'] = $id_project;
        //echo date('d/m/Y H:i:s');die;
        $project            = $data['project']  =   $this->Project_model->get_detail_project($id_project);
        $data['title']      = $project['NAME'];
        $gantt              = $this->Project_model->getDataGanttTask($id_project);
        $c_gantt            = array();
        $data['gantt']      = array();

        foreach ($gantt as $key => $value) {
            $c_gantt['id']  = $value['ID'];
            $c_gantt['text']  = $value['TEXT'];
            $c_gantt['start_date']  = $value['START_DATE2'];
            $c_gantt['end_date']  = $value['END_DATE2'];
            $c_gantt['progress']  = intval($value['PROGRESS']);
            array_push($data['gantt'], $c_gantt); 

        }

        //echo json_encode($data['gantt']);die;
        $this->myViewClean('projects/monitoring', $data); 
    }

    function overview($id_project){
        $data['id_project']         = $id_project;
        $data['current_week']       = $current_week = $this->Project_model->get_current_week($id_project); 
        $data['kurva']              = $this->Project_model->get_curva_s($id_project);
        $project                    = $data['project']  =   $this->Project_model->get_detail_project($id_project);
        $data['title']              = $project['NAME'];
        $data['arrAssignTo']        = array('SDV','MITRA','SEGMEN','BDM','DSS','TREG');
        $data['gantt']              = array();
        $data['week_project']       = $this->Project_model->get_current_week($id_project);
        $data['issueAp']            = $this->Project_model->get_list_project_issue_action_plan($id_project);
        $data['action_only']        = $this->Project_model->get_list_project_action_plan_only($id_project);

        $data['bast']               = $this->Project_model->get_project_bast($id_project);
        $data['history']            = $this->Project_model->getProjectHistory($id_project);
        $data['project']            = $this->Project_model->get_detail_project($id_project);
        $data['acq']                = $this->Project_model->get_project_acquisition_s_curve($id_project);
        $data['partners']           = $this->Project_model->get_partners($id_project);
        
        //echo $this->db->last_query();die;

        foreach ($data['kurva']['REAL'] as $key => $value) {
                if((empty($data['kurva']['REAL'][$key]))&&(!empty($data['kurva']['REAL'][$key-1]))&&($key <= $data['week_project'])){
                    $data['kurva']['REAL'][$key] = $data['kurva']['REAL'][$key-1];
                }
                if($key > $data['week_project']){
                    unset($data['kurva']['REAL'][$key]);
                }
            }


        $data['acq']['REAL2']       = array();
        $data['acq']['PLAN2']       = array();
        $data['acq']['PROG_C']       = array();
        $data['acq']['REAL2'][0]    = 0;
        $data['acq']['PLAN2'][0]    = 0;
        foreach ($data['acq']['REAL'] as $key => $value) {
                if(empty($data['acq']['REAL'][$key])){
                    $data['acq']['REAL'][$key] = 0;
                }

                if($key == 0){
                    $data['acq']['REAL2'][$key] = $data['acq']['REAL'][$key];
                }else{
                   $data['acq']['REAL2'][$key] = $data['acq']['REAL2'][$key-1] + $data['acq']['REAL'][$key]; 
                }
            }
        foreach ($data['acq']['PLAN'] as $key => $value) {
                if(empty($data['acq']['PLAN'][$key])){
                    $data['acq']['PLAN'][$key] = 0;
                }

                if($key == 0){
                    $data['acq']['PLAN2'][$key] =  $data['acq']['PLAN'][$key];
                }else{
                    $data['acq']['PLAN2'][$key] = $data['acq']['PLAN2'][$key-1] + $data['acq']['PLAN'][$key];
                }

                
            }

        foreach ($data['acq']['PROG2'] as $key => $value) {
                if(empty($data['acq']['PROG2'][$key])){
                    $data['acq']['PROG2'][$key] = 0;
                }

                if($key == 0){
                    $data['acq']['PROG_C'][$key] =  $data['acq']['PROG2'][$key];
                }else{
                    $data['acq']['PROG_C'][$key] = $data['acq']['PROG_C'][$key-1] + $data['acq']['PROG2'][$key];
                }

                
            }

        $data['acq2'] = array();

        foreach ($data['acq'] as $key => $value) {
            $data['acq2'][$key] = array_reverse($value); 
        }
        //echo json_encode($data['acq2']);die;

        $gantt              = $this->Project_model->getDataGanttTask($id_project);
        $c_gantt            = array();
        foreach ($gantt as $key => $value) {
            $c_gantt['id']  = $value['ID'];
            $c_gantt['text']  = $value['TEXT'];
            $c_gantt['start_date']  = $value['START_DATE2'];
            $c_gantt['end_date']  = $value['END_DATE2'];
            $c_gantt['progress']  = intval($value['PROGRESS']);
            array_push($data['gantt'], $c_gantt);

        }

        //echo json_encode($data['gantt']);die;
        $this->myView('projects/overview', $data); 
    }


    function saveIssueAction($id_project){
        $result['data'] = 'failed';

        if(!empty($this->input->post('use_issue'))){
            $issue = array();
            $seqIssue = $this->rzkt->get_sequence("PRIME_PROJECT_ISSUE_SEQ");
            $idIssue  = 'IS'.$seqIssue['ID'];
            $issue = array(
                    'ID_ISSUE'          => $idIssue,
                    'ID_PROJECT'        => $id_project,
                    'ISSUE_NAME'        => $this->input->post('issue_name'),
                    'RISK_IMPACT'       => $this->input->post('risk_impact'),
                    'IMPACT'            => $this->input->post('impact'),
                    'STATUS_ISSUE'      => 'OPEN'
            );

            $this->add_credit_point('ISSUE '.'IS'.$seqIssue['ID'],$id_project,"ADD ISSUE",1,json_encode($issue));
            if ($this->Project_model->addIssue($issue)) {
                $this->addLog($id_project,'ADD ISSUE','PROJECT',json_encode($issue));
                $this->Project_model->updateLogProject($id_project);
                
            }

        }

        if(!empty($this->input->post('use_actionplan'))){
            $seqAction  = $this->rzkt->get_sequence("PRIME_PROJECT_ACTION_SEQ");    
            $action = array(
                    'ID_ACTION_PLAN'    => 'AP'.$seqAction['ID'],
                    'ID_PROJECT'        => $id_project,
                    'ID_ISSUE'          => !empty($idIssue) ? $idIssue : null,
                    'ACTION_NAME'       => $this->input->post('task_name'),
                    'ACTION_REMARKS'    => $this->input->post('remarks_action'),
                    'ASSIGN_TO'         => $this->input->post('assignto'),
                    'ASSIGN_TO_DETAIL'  => $this->input->post('assignto_detail'),
                    'DUE_DATE'          => $this->input->post('due_date'),
                    'ACTION_STATUS'     => 'OPEN',
            );
            $pic_name       = $this->input->post('pic_name');
            $pic_email      = $this->input->post('pic_email');
            $arrPic         = array();


            if (!empty($pic_name)) {
                for($i=0;$i<count($pic_name);$i++){
                    $seqPic = $this->rzkt->get_sequence("PRIME_ACTION_PIC_SEQ");
                    if (!empty($pic_name[$i])) {
                        $picArr = array(
                                'ID_PIC'         => $seqPic['ID'],
                                'ID_ACTION_PLAN' => 'AP'.$seqAction['ID'],
                                'PIC_NAME'       => $pic_name[$i],
                                'PIC_EMAIL'      => $pic_email[$i],
                            );
                        array_push($arrPic, $picArr);
                    }
                }
            } 
            $this->Project_model->addAction($action,$arrPic);
            $this->add_credit_point('ACTION PLAN '.$action['ID_ACTION_PLAN'],$id_project,"ADD ACTION PLAN",1,json_encode($action));
            $this->addLog($id_project,'ADD ACTION PLAN','PROJECT',json_encode($action));
        }
        $this->session->set_flashdata('notif', $this->alert('alert-success','Issue or Action Plan has been Updated'));
        $result['data'] = 'success';
        echo json_encode($result);

    }

    function updateIssueAction($id_project){
        $result['data'] = 'failed';

        $action_id      = $this->input->post('action_id');
        $issue_id       = $this->input->post('issue_id');

        if(!empty($issue_id)){
            $issue = array();
            $issue = array(
                    'ID_ISSUE'          => $issue_id,
                    'ID_PROJECT'        => $id_project,
                    'ISSUE_NAME'        => $this->input->post('issue_name'),
                    'RISK_IMPACT'       => $this->input->post('risk_impact'),
                    'IMPACT'            => $this->input->post('impact'),
                    'STATUS_ISSUE'      => $this->input->post('statusIssueAction'),
            );

            if($issue['STATUS_ISSUE'] == 'CLOSED'){
                $issue['ISSUE_CLOSED_DATE'] = $this->input->post('issueAction_closed_dat');
            }

            $this->add_credit_point('ISSUE '.'IS'.$issue_id,$id_project,"UPDATE ISSUE",1,json_encode($issue));
            if ($this->Project_model->updateIssue($issue)) {
                $this->addLog($id_project,'ADD ISSUE','PROJECT',json_encode($issue));
                $this->Project_model->updateLogProject($id_project);
            }

        }

        if(!empty($this->input->post('use_actionplan'))){
            $seqAction  = $this->rzkt->get_sequence("PRIME_PROJECT_ACTION_SEQ");    
            $action = array(
                    'ID_ACTION_PLAN'    => 'AP'.$seqAction['ID'],
                    'ID_PROJECT'        => $id_project,
                    'ID_ISSUE'          => !empty($idIssue) ? $idIssue : null,
                    'ACTION_NAME'       => $this->input->post('task_name'),
                    'ACTION_REMARKS'    => $this->input->post('remarks_action'),
                    'ASSIGN_TO'         => $this->input->post('assignto'),
                    'ASSIGN_TO_DETAIL'  => $this->input->post('assignto_detail'),
                    'DUE_DATE'          => $this->input->post('due_date'),
                    'ACTION_STATUS'     => $this->input->post('statusIssueAction'),
            );

            if($action['ACTION_STATUS'] == 'CLOSED'){
                $action['ACTION_CLOSED_DATE'] = $this->input->post('issueAction_closed_dat');
            }

            $pic_name       = $this->input->post('pic_name');
            $pic_email      = $this->input->post('pic_email');
            $arrPic         = array();


            if (!empty($pic_name)) {
                for($i=0;$i<count($pic_name);$i++){
                    $seqPic = $this->rzkt->get_sequence("PRIME_ACTION_PIC_SEQ");
                    if (!empty($pic_name[$i])) {
                        $picArr = array(
                                'ID_PIC'         => $seqPic['ID'],
                                'ID_ACTION_PLAN' => 'AP'.$seqAction['ID'],
                                'PIC_NAME'       => $pic_name[$i],
                                'PIC_EMAIL'      => $pic_email[$i],
                            );
                        array_push($arrPic, $picArr);
                    }
                }
            } 
            $this->Project_model->updateAction($action,$arrPic);
            $this->add_credit_point('ACTION PLAN '.$action['ID_ACTION_PLAN'],$id_project,"ADD ACTION PLAN",1,json_encode($action));
            $this->addLog($id_project,'ADD ACTION PLAN','PROJECT',json_encode($action));
        }
        $this->session->set_flashdata('notif', $this->alert('alert-success','Issue or Action Plan has been Updated'));
        $result['data'] = 'success';
        echo json_encode($result);

    }


    function deleteIssueAction($id_project){
        $result['data'] = 'failed';

        $action_id      = $this->input->post('action_id');
        $issue_id       = $this->input->post('issue_id');

        if(!empty($issue_id)){
            if ($this->Project_model->updateIssue($issue)) {
                $this->addLog($id_project,'ADD ISSUE','PROJECT',json_encode($issue));
                $this->Project_model->updateLogProject($id_project);
            }

        }

        if(!empty($action_id)){
            $this->Project_model->updateAction($action,$arrPic);
            $this->add_credit_point('ACTION PLAN '.$action['ID_ACTION_PLAN'],$id_project,"ADD ACTION PLAN",1,json_encode($action));
            $this->addLog($id_project,'ADD ACTION PLAN','PROJECT',json_encode($action));

        }
    }

    function fixScurve(){
        foreach ($data['kurva']['REAL'] as $key => $value) {
                if((empty($data['kurva']['REAL'][$key]))&&(!empty($data['kurva']['REAL'][$key-1]))&&($key <= $data['week_project'])){
                    $data['kurva']['REAL'][$key] = $data['kurva']['REAL'][$key-1];
                }
                if($key > $data['week_project']){
                    unset($data['kurva']['REAL'][$key]);
                }
            }

        return $data['kurva'];
    }


    function apiTask($id_project,$type=null,$id_deliverable = null){
        $request_type       = $_SERVER['REQUEST_METHOD'];
        $input              = array();

        if($request_type == 'POST'){
            $input['ID_DELIVERABLE']  = 'DL'.$this->rzkt->get_sequence("PRIME_PROJECT_DELIVERABLE_SEQ")['ID'];
            $input['ID_PROJECT']         = $id_project;
            $input['NAME']               =   $this->input->post('text');
            $input['PARENT']             =  $this->input->post('parent');
            $input['WEIGHT']             =  $this->input->post('weight');
            // $input['PROGRESS_VALUE']     =  $this->input->post('progress');
            $input['DESCRIPTION']        =  $this->input->post('description');
            $input['START_DATE']         =  substr($this->input->post('start_date'), 0,10);
            $input['END_DATE']           =  substr($this->input->post('end_date'), 0,10);

            $input['INSERTED_BY_ID']     = $this->session->userdata('nik_sess');
            $input['INSERTED_BY_NAME']   = $this->session->userdata('nama_sess');
            $this->add_credit_point('DELIVERABLE '.$input['ID_DELIVERABLE'],$id_project,"ADD DELIVERABLE",1,json_encode($input));
            if ($this->Project_model->add_task($input)) { 
                $this->addLog($id_project,'ADD DELIVERY','PROJECT',json_encode($input));
                $this->Project_model->updateLogProject($id_project); 
            }
         }

         if($request_type == 'PUT'){
            $input['ID_DELIVERABLE']     = $id_deliverable;
            $input['ID_PROJECT']         = $id_project;
            $input['NAME']               =  $this->input->input_stream('text');
            $input['PARENT']             =  $this->input->input_stream('parent');
            $input['WEIGHT']             =  $this->input->input_stream('weight');
            $input['PROGRESS_VALUE']     =  floatval($this->input->input_stream('progress'))*100;
            $input['DESCRIPTION']        =  $this->input->input_stream('description');
            $input['START_DATE']         =  substr($this->input->input_stream('start_date'), 0,10);
            $input['END_DATE']           =  substr($this->input->input_stream('end_date'), 0,10);

            $input['INSERTED_BY_ID']     = $this->session->userdata('nik_sess');
            $input['INSERTED_BY_NAME']   = $this->session->userdata('nama_sess');   
            if ($this->Project_model->update_task($input)) {
                $this->Project_model->updateLogProject($id_project);
                $this->add_credit_point('DELIVERABLE '.$id_deliverable,$id_project,"UPDATE DELIVERABLE",1,json_encode($input));
                $this->addLog($id_project,'UPDATE DELIVERY','PROJECT',json_encode($input));          
            }

         }

         if($request_type == 'DELETE'){
            $this->Project_model->deleteDeliverable($id_project,$id_deliverable);
            $this->addLog($id_project,'DELETE DELIVERY','PROJECT',json_encode($this->input->post()));
            echo 'false';
         }


        // RETURN JSON DATA DELIVERYNYA
        $gantt              = $this->Project_model->getDataGanttTask($id_project);
        $c_gantt            = array();
        $data['gantt']      = array();
        $result             = array();
        foreach ($gantt as $key => $value) {
            $c_gantt['duration']  = $value['DURATION'];
            $c_gantt['id']  = $value['ID'];
            $c_gantt['open']  = "true";
            $c_gantt['parent']  = $value['PARENT'];
            $c_gantt['priority']  = "2";
            $c_gantt['progress']  = $value['PROGRESS'];
            $c_gantt['text']  = $value['TEXT'];
            $c_gantt['start_date']  = $value['START_DATE2'];
            $c_gantt['end_date']  = $value['END_DATE2'];
            $c_gantt['weight']  = $value['WEIGHT'];
            $c_gantt['description']  = $value['DESCRIPTION'];
            
           

            array_push($data['gantt'], $c_gantt);

        }

        $result['data'] = $data['gantt'];
        echo json_encode($result);

    }

    function jsonDeliverable(){
        $result                     = array();
        $id_project = $this->input->get('post');
        //$task       = $this->Project_model->getDataTask($id_project);


        $data["task"]               = array();
        $data["resource"]           = array();
        $data["canWrite"]           = true;
        $data["canDelete"]          = true;
        $data["canWriteOnParent"]   = true;
        $data["canAdd"]             = true;
        $result['data']             = $data;

        echo json_encode($result['data']);
    }


    function updateAcqusition($id_project){
        //echo json_encode($this->input->post());

        $month          = date('n');
        $month_lm       = $month - 1;
        $year           = date('Y');
        $year_lm        = date('Y');
        if($month_lm == 0){
            $month_lm = 12;
            $year_lm  = $year_lm - 1;
        }

        $data_c     = array();
        $data_lm    = array();

        $data_c['ID']              = $this->getGUID();
        $data_c['ID_PROJECT']      = $id_project;
        $data_c['TOP']             = $this->input->post('target_top');
        $data_c['T_VALUE']         = $this->input->post('target_value');
        $data_c['TOP_EXPLANATION'] = $this->input->post('target_to_exp');
        $data_c['UPDATED_BY']       = $this->session->userdata('nik_sess');
        $data_c['MONTH']           = $month;
        $data_c['YEAR']            = $year;
        $data_c['T_NOTE']          = $this->input->post('target_note');

        $data_lm['ID']              = $this->getGUID();
        $data_lm['ID_PROJECT']      = $id_project;
        $data_lm['TOP']             = $this->input->post('actual_top');
        $data_lm['A_VALUE']         = $this->input->post('actual_value');
        $data_lm['TOP_EXPLANATION'] = $this->input->post('actual_to_exp');
        $data_lm['UPDATED_BY']      = $this->session->userdata('nik_sess');
        $data_lm['MONTH']           = $month_lm;
        $data_lm['YEAR']            = $year_lm;
        $data_lm['A_NOTE']          = $this->input->post('actual_note');

        
        $this->Project_model->updateTargetActualAcq($id_project,$month_lm,$year_lm,$data_lm);
        $this->Project_model->updateTargetActualAcq($id_project,$month,$year,$data_c);

        

        echo $this->db->last_query();


    }
}

?> 