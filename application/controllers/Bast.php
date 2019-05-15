<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Bast extends MY_Controller
{
    
    public function __construct(){ 
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Bast_model');
        $this->load->model('Project_model'); 
        if(!$this->isLoggedIn()){  
            redirect(base_url());
        };    
    }   
     
    public function index(){
        if($this->session->userdata('tipe_sess')=='SUBSIDIARY'){
            redirect(base_url()."bast/index_mitra");
        }
        // $tdays  = date('t');
        $tdays  = date('d');
        $days   = array();
        for ($i=1; $i <=$tdays ; $i++) { 
            $days[$i-1] = $i;
        }
        $data['days']       = $days;
        $bast_received      = $this->Bast_model->get_bast_received_this_month();
        $bast_r             = array();
        foreach ($days as $key => $value) { 
            $bast_r[$key] = 0;
            foreach ($bast_received as $key1 => $value1) { 
                if(intval($value1['DATE_RECEIVED']) == $days[$key]){
                    $bast_r[$key] = intval($value1['TOTAL']);
                }
            }
        }
        $data['bast_received']      = $bast_r;

        $data['title'] = 'BAST';
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();

        $data['countReAll']     = $this->Bast_model->count_bast('RECEIVED')['JUMLAH'];  
        $data['countRe2All']     = $this->Bast_model->count_bast('SUBMIT BY PARTNER')['JUMLAH'];  
        $data['countReToday']   = $this->Bast_model->count_bast('RECEIVED','today')['JUMLAH'];  
        $data['countDoToday']   = $this->Bast_model->count_bast('DONE','today')['JUMLAH'];  
        $data['countOutToday']  = $this->Bast_model->count_bast('TAKE OUT','today')['JUMLAH'];  
        $data['countCheAll']    = $this->Bast_model->count_bast('CHECKED')['JUMLAH'];
        $data['countCheADMAll'] = $this->Bast_model->count_bast('CHECK BY ADM')['JUMLAH'];
        $data['countChePMOAll'] = $this->Bast_model->count_bast('CHECK BY SE PMO')['JUMLAH'];
        $data['countCheCORAll'] = $this->Bast_model->count_bast('CHECK BY COORD')['JUMLAH'];
        $data['countCheAPPAll'] = $this->Bast_model->count_bast('APPROVED')['JUMLAH'];
        $data['countCheREVAll'] = $this->Bast_model->count_bast('REVISION')['JUMLAH'];
        $data['countDoAll']     = $this->Bast_model->count_bast('DONE')['JUMLAH'];  
        $data['countOutAll']    = $this->Bast_model->count_bast('TAKE OUT')['JUMLAH'];
        
        $this->myView('bast/index',$data);           
    }

    public function index_mitra(){
        $data['title'] = 'BAST';
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $data['countReAll']     = $this->Bast_model->count_bast('RECEIVED')['JUMLAH'];  
        $data['countReToday']   = $this->Bast_model->count_bast('RECEIVED','today')['JUMLAH'];  
        $data['countDoToday']   = $this->Bast_model->count_bast('DONE','today')['JUMLAH'];  
        $data['countOutToday']  = $this->Bast_model->count_bast('TAKE OUT','today')['JUMLAH'];  
        $data['countCheAll']    = $this->Bast_model->count_bast('CHECKED')['JUMLAH'];
        $data['countCheADMAll'] = $this->Bast_model->count_bast('CHECK BY ADM')['JUMLAH'];
        $data['countChePMOAll'] = $this->Bast_model->count_bast('CHECK BY SE PMO')['JUMLAH'];
        $data['countCheCORAll'] = $this->Bast_model->count_bast('CHECK BY COORD')['JUMLAH'];
        $data['countCheAPPAll'] = $this->Bast_model->count_bast('APPROVED')['JUMLAH'];
        $data['countCheREVAll'] = $this->Bast_model->count_bast('REVISION')['JUMLAH'];
        $data['countDoAll']     = $this->Bast_model->count_bast('DONE')['JUMLAH'];  
        $data['countOutAll']    = $this->Bast_model->count_bast('TAKE OUT')['JUMLAH'];
        
        $this->myView('bast/index',$data);           
    }
    
    //DATATABLE 
    function get_datatables(){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = trim(strtoupper($_POST['search']['value']));
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $status     = $this->input->post('status');
        $mitra      = $this->input->post('mitra');
        $segmen     = $this->input->post('segmen');
        $customer   = $this->input->post('customer');
        $spk        = $this->input->post('spk');
       
        $model = $this->Bast_model->get_datatables($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$mitra,$segmen,$customer,$spk);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Bast_model->count_all($status,$mitra,$segmen,$customer,$spk),
            "recordsFiltered" => $this->Bast_model->count_filtered($searchValue, $orderColumn, $orderDir, $order,$status,$mitra,$segmen,$customer,$spk),
            "data" => $model,
        );
        echo json_encode($output);  
    }

    function add(){  
        $data['title'] = 'BAST';
        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();

        $data['partner_id']    = $this->input->post('partner_id');
        $data['partner_name']  = $this->input->post('partner_name');
        //echo json_encode($input);die;

        $this->myView('bast/add',$data);
            
    }

    function add_2(){
        $data['title'] = 'BAST';
        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();

        $data['partner_id']    = $this->session->userdata('mitra');
        $data['partner_name']  = $this->Bast_model->getPartnerById($data['partner_id']);
        //echo json_encode($input);die;

        $this->myView('bast/add',$data);
            
    }

    function add_1(){
        $data['title'] = 'BAST';
        $data['list_partner']   = $this->get_list_mitra();
        $this->myView('bast/add_1',$data);
            
    }

    function submitBAST(){
        //echo json_encode($this->input->post());die;
        $result['data'] = "failed";
        $data['ID_BAST']        = $data_history['ID_PROJECT']  = $this->getGUID();
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
        $data['NILAI_RECCURING']  = $this->input->post('reccuring_val');
        $data['RECC_START_DATE']= $this->input->post('recc_start_date');
        $data['RECC_END_DATE']  = $this->input->post('recc_end_date');
        $data['PENANDA_TANGAN'] = $this->input->post('signer');
        $data['NIK_PM']         = $this->input->post('pm');
        $data['ID_LOP']         = $this->input->post('id_lop');
        $data['NAMA_PM']        = $this->input->post('pm_name');
        $data['PIC_MITRA']      = $this->input->post('pic_partner');
        $data['EMAIL_MITRA']    = $this->input->post('email_pic_partner2');
        $data['KELENGKAPAN_DELIVERY']   = $this->input->post('evidence');
        $data['STATUS']             =   $data_history['STATUS']     = "RECEIVED";
        $data['PROGRESS_LAPANGAN']  = $this->input->post('progress_actual');
        $data['NAMA_TERMIN']        = $this->input->post('termin');
        $data['BAPP']               = !empty($this->input->post('bapp')) ? 1 : null;
        $data['P71']               = !empty($this->input->post('p71')) ? 1 : null;
        $data['ID_PROJECT']         = $this->input->post('id_project');
        $data['LAST_EDITED_BY']     =   $data_history['BY_USER']    =  $this->session->userdata('nik_sess')."|||".$this->session->userdata('nama_sess');

        if($this->session->userdata('tipe_sess')=='SUBSIDIARY'){
            $data['STATUS']             =   $data_history['STATUS']     = "SUBMIT BY PARTNER";
        }

        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        //echo json_encode($data);die;

        if($data['TYPE_BAST']=='OTC'){$data['PROGRESS_LAPANGAN'] = '100';}
        // echo json_encode($data);die;
        if($this->Bast_model->saveBAST($data)){
            $this->addLog($this->session->userdata('nik_sess'),'SUBMIT BAST','BAST',json_encode($data));
            $data_history['ID_HISTORY'] = $this->getGUID();
            $data_history['COMMEND'] = $this->input->post('commend');
            if($this->Bast_model->addBASTHistory($data_history)){
                $result['data']     = "success";
                $result['id_bast']  = $data['ID_BAST'];
            }
        }

        echo json_encode($result);
        
    }
 
    function updateBAST(){
        $result['data']     = "error";
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
        $data['NILAI_RECCURING']  = $this->input->post('reccuring_val');
        $data['RECC_START_DATE']= $this->input->post('recc_start_date');
        $data['RECC_END_DATE']  = $this->input->post('recc_end_date');
        $data['PENANDA_TANGAN'] = $this->input->post('signer');
        $data['NIK_PM']         = $this->input->post('pm');
        $data['NAMA_PM']        = $this->input->post('pm_name');
        $data['PIC_MITRA']      = $this->input->post('pic_partner');
        $data['EMAIL_MITRA']    = $this->input->post('email_pic_partner2');
        $data['KELENGKAPAN_DELIVERY']   = $this->input->post('evidence');
        $data['STATUS']             =   $data_history['STATUS']     = $this->input->post('status');
        $data['PROGRESS_LAPANGAN']  = $this->input->post('progress_actual');
        $data['NAMA_TERMIN']        = $this->input->post('termin');
        $data['ID_LOP']             = $this->input->post('id_lop');
        $data['BAPP']               = !empty($this->input->post('bapp')) ? 1 : null;
        $data['P71']               = !empty($this->input->post('p71')) ? 1 : null;
        $data['ID_PROJECT']         = $this->input->post('id_project');
        $data['LAST_EDITED_BY']     =   $data_history['BY_USER']    =  $this->session->userdata('nik_sess')."|||".$this->session->userdata('nama_sess');
        if($data['TYPE_BAST']=='OTC'){$data['PROGRESS_LAPANGAN'] = '100';}

        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        if($data['STATUS'] == 'APPROVED'){
            $dateBast   = explode("/", $data['TGL_BAST']);
            $yearBast   = $dateBast[2];
            $monthBast  = $dateBast[0];
            $monthBast  = $this->getMonthRomawi($monthBast);
            $spk        = explode(".", $data['NO_SPK']);
            $spk        = explode("/", $spk[1]);
            $spk        = $spk[0];
            $spk_squen  = $this->Bast_model->getSquenSpk($data['NO_SPK']);
            
            switch ($data['TYPE_BAST']) {
                case 'OTC':
                    $type = 'O';
                    break;
                case 'TERMIN':
                    $type = 'T';
                    break;
                case 'PROGRESS': 
                    $type = 'P';
                    break;
                case 'RECURRING':
                    $type = 'R';
                    break;
                case 'OTC & RECURRING':
                    $type = 'OR';
                    break;
                default:
                    $type = "#ERROR";
            }
            switch ($data['PENANDA_TANGAN'] ) {
                case 'Coordinator Project Management':
                    $signer = 'C';
                    break;
                    case 'Senior Expert Project Management Office 1':
                    $signer = '1';
                    break;
                    case 'Senior Expert Project Management Office 2':
                    $signer = '2';
                    break;
                default:
                    $signer = '3';
                    break;
            } 
            
            $c_no_bast  = $this->Bast_model->getDataBast($id_bast);

            if(empty($c_no_bast['NO_BAST'])){
            $bappbast = 'BAST';
                if(!empty($data['BAPP'])){
                    $bappbast = 'BAPP';
                }

                $no_bast    = $spk.'.'.$spk_squen.'/'.$bappbast.'/'.$type.$signer."/DES/".$data['ID_MITRA'].'/'.$monthBast.'/'.$yearBast;
            }else{
            $no_bast    = $c_no_bast['NO_BAST'];
            }


            $data['NO_BAST'] = $no_bast;
            }else if($data['STATUS'] == 'DONE'){

                    $no_bast                = $this->input->post('no_bast');
                    $kode_bast              = explode('/',$no_bast)[0];
                    $project_name           = strtoupper($this->makeurl($data['PROJECT_NAME']));
                    $nama_mitra             = strtoupper($this->makeurl($data['NAMA_MITRA']));
                    
                    $targetDir = "../bast/".substr($no_bast, strlen($no_bast)-4)."/".$this->makefoldername($data['NAMA_MITRA']);
                    if(!is_dir($targetDir)){
                        mkdir($targetDir,0777,true);
                    }
                    
                    $newName              = 'BAST_'.date('Ymd',strtotime($data['TGL_BAST'])).'_'.$kode_bast.'_DES_'.$nama_mitra.'_'.substr($project_name, 0,150).'_.'.pathinfo($_FILES['file_bast']['name'], PATHINFO_EXTENSION);
                    $uploaded_file = $this->upload_file('file_bast',$targetDir,$newName);
                    
                    $data['FILENAME']     = $uploaded_file['file_name'];
                    $data['FILENAME_URI'] = $targetDir.'/'.$uploaded_file['file_name'];

                    $progress     = "";
                    if(!empty($data['PROGRESS_LAPANGAN'])){
                        $progress = $data['PROGRESS_LAPANGAN'];
                    }else if($data['TYPE_BAST']=='OTC'){ 
                        $progress = '100%';
                    }else if($data['TYPE_BAST']=='RECURRING'){
                        $progress = $data['RECC_START_DATE'].' - '.$data['RECC_END_DATE'];              
                    }else if($data['TYPE_BAST']=='TERMIN'){
                        $progress = $data['NAMA_TERMIN'];}          

                    if(!empty($this->input->post('id_project'))){
                        $data_project = null;
                        if($this->Project_model->get_detail_project2($data['ID_PROJECT'])){
                            $data_project = $this->Bast_model->getProjectBySPK($data['ID_PROJECT']);    
                        }

                        if(!empty($data_project)){
                            $urlEpic        = "http://des.telkom.co.id/epic/index.php/api/project/mitra?id=".$data_project->ID_ROW."&id_lop=".$data_project->ID_LOP_EPIC."&prog_lapangan=".$progress;
                        } 

                         
                    }
                    
                    $sign           = $this->makeurl($data['PENANDA_TANGAN']);
                    $evidence       = $this->makeurl($data['KELENGKAPAN_DELIVERY']);
                    $urlNumero   = "http://numero.telkom.co.id/JSONAPITERIMABAST.aspx?NomorBAST=".$no_bast."&FILEBAST=".base_url().$data['FILENAME_URI']."&NomorSPK=".$data['NO_SPK']."&TanggalBAST=".date('m/d/Y', strtotime($data['TGL_BAST']))."&IDPenandaTangan=".$sign."&IDPM=".$data['NIK_PM']."&ProgressLapangan=".$progress."&KelengkapanDelivery=".$evidence;    
            }

        if($this->Bast_model->updateBAST($data,$id_bast)){
                $bast_epic = $this->Bast_model->getDataBastToEpic($id_bast);
                
                /*if(!empty($bast_epic)){
                    $url_epic  = "http://des.telkom.co.id/epic/index.php/api/project/bast?id=".$bast_epic['ID_BAST']."&tanggal_bast=".$bast_epic['TGL_BAST2']."&nomor_spk=".$bast_epic['NO_SPK']."&tanggal_spk=".$bast_epic['TGL_SPK2']."&nomor_kl=".$bast_epic['NO_KL']."&tanggal_kl=".$bast_epic['TGL_KL2']."&project=".$bast_epic['PROJECT_NAME']."&nomor_bast=".$bast_epic['NO_BAST']."&nilai_bast=".$bast_epic['NILAI_RP_BAST']."&skema_bayar=".$bast_epic['TYPE_BAST']."&id_lop=".$bast_epic['ID_LOP'];
                    $url_epic = $this->makeurl2($url_epic);
                    $result_epic = $this->getCurlEpic($url_epic);
                }*/


                $this->addLog($this->session->userdata('nik_sess'),"UPDATE BAST",'BAST',json_encode($data));
                /*if(!empty($urlEpic)){
                    $this->getCurlEpic($urlEpic);
                }
                if(!empty($urlNumero)){ 
                    $this->getCurl($urlNumero);
                }*/
                
                $data_history['ID_HISTORY']     = $this->getGUID();
                $data_history['COMMEND']        = $this->input->post('commend');
                $data_history['ID_PROJECT']     = $id_bast;


                $revision_s = $this->input->post('revision_symptoms');
                $revision_v = "";
                if(!empty($revision_s)){
                    foreach ($revision_s as $key => $value) {
                        $revision_v = $revision_v.",".$value; 

                        $dataRev['ID'] = $this->getGUID();
                        $dataRev['ID_BAST'] = $id_bast;
                        $dataRev['REASON'] = $value;
                        $this->Bast_model->addBASTSymptoms($dataRev);

                    }
                    $revision_v = ltrim($revision_v, ",");
                    $data_history['REASON'] = $revision_v;
                }


                if($this->Bast_model->addBASTHistory($data_history)){
                    $result['data']     = "success";
                    $result['id_bast']  = $id_bast;
                    }
            }

        echo json_encode($result);
        
    }


    // Get Datatables Projects Active
    function get_list_project_active(){
        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $searchValue = strtoupper($this->input->post('search_bast'));
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

        $model = $this->Bast_model->get_datatablesActive($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Bast_model->count_allActive($status,$pm,$customer,$partner,$type,$regional,$segmen,$searchValue),
            "recordsFiltered" => $this->Bast_model->count_filteredActive($searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen),
            "data" => $model,
        );
        echo json_encode($output);
    } 

    function view($id_bast){
        if($this->auth->get_access_value('BAST')<3){
            redirect(base_url().'bast/hview/'.$id_bast);
        }
        $data['title'] = 'BAST';
 
        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();
        $data['list_partner']  = $this->get_list_mitra();

        $data['history']       = $this->Bast_model->getDataHistory($id_bast);

        $data['id_bast']       = $id_bast;
        $data['bast']          = $this->Bast_model->getDataBast($id_bast);
        $data['oldBast']       = $this->Bast_model->getDataOldBast($data['bast']['NO_SPK'],$id_bast);
        $data['evidence']      = @explode(',',$data['bast']['KELENGKAPAN_DELIVERY']);
        if(empty($data['bast'])){
            redirect(base_url().'pageNotFound');
        }

        if($data['bast']['EXIST']!=1){
            redirect(base_url().'pageNotFound');
        }

        //echo json_encode($data['evidence']);die; 
        $this->myView('bast/view',$data);
    }

    function hview($id_bast){
        /*if($this->auth->get_access_value('BAST')>=3){
            redirect(base_url().'bast/view/'.$id_bast);
        }*/
        $data['title'] = 'BAST';

        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();
        $data['list_partner']  = $this->get_list_mitra();

        $data['history']       = $this->Bast_model->getDataHistory($id_bast);

        $data['id_bast']       = $id_bast;
        $data['bast']          = $this->Bast_model->getDataBast($id_bast);
        $data['oldBast']       = $this->Bast_model->getDataOldBast($data['bast']['NO_SPK'],$id_bast);
        $data['evidence']      = @explode(',',$data['bast']['KELENGKAPAN_DELIVERY']);
        if(empty($data['bast'])){
            redirect(base_url().'pageNotFound');
        }

        //echo json_encode($data['evidence']);die;
        $this->myView('bast/hview',$data);
    }

    function uview($id_bast){
        $data['title'] = 'BAST';

        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();
        $data['list_partner']  = $this->get_list_mitra();

        $data['history']       = $this->Bast_model->getDataHistory($id_bast);

        $data['id_bast']       = $id_bast;
        $data['bast']          = $this->Bast_model->getDataBast($id_bast);
        $data['oldBast']       = $this->Bast_model->getDataOldBast($data['bast']['NO_SPK'],$id_bast);
        $data['evidence']      = @explode(',',$data['bast']['KELENGKAPAN_DELIVERY']);
        if(empty($data['bast'])){
            redirect(base_url().'pageNotFound');
        }

        //echo json_encode($data['evidence']);die;
        $this->myView('bast/uview',$data);
    }



    /*DOWNLOAD*/
    function download_list_bast(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Bast_model->download_list_bast();

        $name = 'BAST-'.date('Y-m-d'); 
 
        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
            array('name' => 'NAMA MITRA', 'id' => 'NAMA_MITRA', 'width' => 40)
            ,array('name' => 'ID MITRA', 'id' => 'ID_MITRA', 'width' => 10)
            ,array('name' => 'NO. SPK', 'id' => 'NO_SPK', 'width' => 30)
            ,array('name' => 'TGL SPK', 'id' => 'TGL_SPK', 'width' => 20)
            ,array('name' => 'NO. KL', 'id' => 'NO_KL', 'width' => 30)
            ,array('name' => 'TANGGAL KL', 'id' => 'TGL_KL', 'width' => 20)
            ,array('name' => 'CUSTOMER', 'id' => 'NAMACC', 'width' => 40)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMENT', 'width' => 40)
            ,array('name' => 'NIK PM', 'id' => 'NIK_PM', 'width' => 20)
            ,array('name' => 'NAMA PM', 'id' => 'NAMA_PM', 'width' => 20)
            ,array('name' => 'NILAI BAST', 'id' => 'NILAI_RP_BAST', 'width' => 20)
            ,array('name' => 'NILAI PROJECT', 'id' => 'NILAI_PEKERJAAN', 'width' => 20)
            ,array('name' => 'KELENGKAPAN DELIVERY', 'id' => 'KELENGKAPAN_DELIVERY', 'width' => 30)
            ,array('name' => 'PERSTUJUAN OLEH', 'id' => 'PENANDA_TANGAN', 'width' => 20)
            ,array('name' => 'STATUS', 'id' => 'STATUS', 'width' => 20)
            ,array('name' => 'TANGGAL BAST', 'id' => 'TGL_BAST', 'width' => 20)
            ,array('name' => 'NO. BAST', 'id' => 'NO_BAST', 'width' => 30)
            ,array('name' => 'TIPE BAST', 'id' => 'TYPE_BAST', 'width' => 20)
            ,array('name' => 'NAMA PEKERJAAN', 'id' => 'PROJECT_NAME', 'width' => 100)
            ,array('name' => 'LOKASI FILE', 'id' => 'FILENAME_URI2', 'width' => 100)
            ,array('name' => 'TANGGAL MULAI (RECCURING)', 'id' => 'RECC_START_DATE', 'width' => 30)
            ,array('name' => 'TANGGAL AKHIR (RECCURING)', 'id' => 'RECC_END_DATE', 'width' => 30)
            ,array('name' => 'PROGRESS PEKERJAAN', 'id' => 'PROGRESS_LAPANGAN', 'width' => 30)
            ,array('name' => 'NAMA TERMIN', 'id' => 'NAMA_TERMIN', 'width' => 30)
            ,array('name' => 'TANGGAL PENGAJUAN', 'id' => 'DATE_CREATED', 'width' => 30)
            ,array('name' => 'EMAIL PIC', 'id' => 'EMAIL_MITRA', 'width' => 30)
            ,array('name' => 'TANGGAL UPDATE', 'id' => 'LATEST2', 'width' => 30)
            ,array('name' => 'NOTE', 'id' => 'COMMEND', 'width' => 70)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }


    function download_list_bast_revision(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Bast_model->download_list_bast_revision();

        $name = 'BAST REVISION-'.date('Y-m-d'); 
 
        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
            array('name' => 'NAMA MITRA', 'id' => 'NAMA_MITRA', 'width' => 40)
            ,array('name' => 'ID MITRA', 'id' => 'ID_MITRA', 'width' => 10)
            ,array('name' => 'NO. SPK', 'id' => 'NO_SPK', 'width' => 30)
            ,array('name' => 'TGL SPK', 'id' => 'TGL_SPK', 'width' => 20)
            ,array('name' => 'NO. KL', 'id' => 'NO_KL', 'width' => 30)
            ,array('name' => 'TANGGAL KL', 'id' => 'TGL_KL', 'width' => 20)
            ,array('name' => 'CUSTOMER', 'id' => 'NAMACC', 'width' => 40)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMENT', 'width' => 40)
            ,array('name' => 'NIK PM', 'id' => 'NIK_PM', 'width' => 20)
            ,array('name' => 'NAMA PM', 'id' => 'NAMA_PM', 'width' => 20)
            ,array('name' => 'NILAI BAST', 'id' => 'NILAI_RP_BAST', 'width' => 20)
            ,array('name' => 'NILAI PROJECT', 'id' => 'NILAI_PEKERJAAN', 'width' => 20)
            ,array('name' => 'KELENGKAPAN DELIVERY', 'id' => 'KELENGKAPAN_DELIVERY', 'width' => 30)
            ,array('name' => 'PERSTUJUAN OLEH', 'id' => 'PENANDA_TANGAN', 'width' => 20)
            ,array('name' => 'STATUS', 'id' => 'STATUS', 'width' => 20)
            ,array('name' => 'TANGGAL BAST', 'id' => 'TGL_BAST', 'width' => 20)
            ,array('name' => 'NO. BAST', 'id' => 'NO_BAST', 'width' => 30)
            ,array('name' => 'TIPE BAST', 'id' => 'TYPE_BAST', 'width' => 20)
            ,array('name' => 'NAMA PEKERJAAN', 'id' => 'PROJECT_NAME', 'width' => 100)
            ,array('name' => 'LOKASI FILE', 'id' => 'FILENAME_URI2', 'width' => 100)
            ,array('name' => 'TANGGAL MULAI (RECCURING)', 'id' => 'RECC_START_DATE', 'width' => 30)
            ,array('name' => 'TANGGAL AKHIR (RECCURING)', 'id' => 'RECC_END_DATE', 'width' => 30)
            ,array('name' => 'PROGRESS PEKERJAAN', 'id' => 'PROGRESS_LAPANGAN', 'width' => 30)
            ,array('name' => 'NAMA TERMIN', 'id' => 'NAMA_TERMIN', 'width' => 30)
            ,array('name' => 'TANGGAL PENGAJUAN', 'id' => 'DATE_CREATED', 'width' => 30)
            ,array('name' => 'EMAIL PIC', 'id' => 'EMAIL_MITRA', 'width' => 30)
            ,array('name' => 'TANGGAL UPDATE', 'id' => 'LATEST2', 'width' => 30)
            ,array('name' => 'NOTE', 'id' => 'COMMEND', 'width' => 70)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }

    function download_list_bast2(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Bast_model->download_list_bast2();

        $name = 'BAST-'.date('Y-m-d');
 
        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'NAMA MITRA', 'id' => 'NAMA_MITRA', 'width' => 40)
            ,array('name' => 'ID MITRA', 'id' => 'ID_MITRA', 'width' => 10)
            ,array('name' => 'NO. SPK', 'id' => 'NO_SPK', 'width' => 30)
            ,array('name' => 'TGL SPK', 'id' => 'TGL_SPK', 'width' => 20)
            ,array('name' => 'NO. KL', 'id' => 'NO_KL', 'width' => 30)
            ,array('name' => 'TANGGAL KL', 'id' => 'TGL_KL', 'width' => 20)
            ,array('name' => 'CUSTOMER', 'id' => 'NAMACC', 'width' => 40)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMENT', 'width' => 40)
            ,array('name' => 'NIK PM', 'id' => 'NIK_PM', 'width' => 20)
            ,array('name' => 'NAMA PM', 'id' => 'NAMA_PM', 'width' => 20)
            ,array('name' => 'NILAI BAST', 'id' => 'NILAI_RP_BAST', 'width' => 20)
            ,array('name' => 'NILAI PROJECT', 'id' => 'NILAI_PEKERJAAN', 'width' => 20)
            ,array('name' => 'KELENGKAPAN DELIVERY', 'id' => 'KELENGKAPAN_DELIVERY', 'width' => 30)
            ,array('name' => 'PERSTUJUAN OLEH', 'id' => 'PENANDA_TANGAN', 'width' => 20)
            ,array('name' => 'TANGGAL BAST', 'id' => 'TGL_BAST', 'width' => 20)
            ,array('name' => 'NO. BAST', 'id' => 'NO_BAST', 'width' => 30)
            ,array('name' => 'TIPE BAST', 'id' => 'TYPE_BAST', 'width' => 20)
            ,array('name' => 'LOKASI FILE', 'id' => 'FILENAME_URI', 'width' => 30)
            ,array('name' => 'TANGGAL MULAI (RECCURING)', 'id' => 'RECC_START_DATE', 'width' => 30)
            ,array('name' => 'TANGGAL AKHIR (RECCURING)', 'id' => 'RECC_END_DATE', 'width' => 30)
            ,array('name' => 'PROGRESS PEKERJAAN', 'id' => 'PROGRESS_LAPANGAN', 'width' => 30)
            ,array('name' => 'NAMA TERMIN', 'id' => 'NAMA_TERMIN', 'width' => 30)
            ,array('name' => 'TANGGAL PENGAJUAN', 'id' => 'DATE_CREATED', 'width' => 30)
            ,array('name' => 'EMAIL PIC', 'id' => 'EMAIL_MITRA', 'width' => 30)
            ,array('name' => 'CURRENT STATUS', 'id' => 'STATUS', 'width' => 20)
            ,array('name' => 'STATUS', 'id' => 'STATUS_HISTORY', 'width' => 20)
            ,array('name' => 'NOTE', 'id' => 'COMMEND', 'width' => 70)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);

    }




    function send_batch_to_epic(){
        $bast = $this->Bast_model->getDataAllBast('epic');
        echo count($bast).'<br>';
        foreach ($bast as $key => $value) {
            $url  = "http://des.telkom.co.id/epic/index.php/api/project/bast?id=".$bast[$key]['ID_BAST']."&tanggal_bast=".$bast[$key]['TGL_BAST2']."&nomor_spk=".$bast[$key]['NO_SPK']."&tanggal_spk=".$bast[$key]['TGL_SPK2']."&nomor_kl=".$bast[$key]['NO_KL']."&tanggal_kl=".$bast[$key]['TGL_KL2']."&project=".$bast[$key]['PROJECT_NAME']."&nomor_bast=".$bast[$key]['NO_BAST']."&nilai_bast=".$bast[$key]['NILAI_RP_BAST']."&skema_bayar=".$bast[$key]['TYPE_BAST']."&id_lop=".$bast[$key]['ID_LOP'];
            $url = $this->makeurl2($url);
            $result = $this->getCurl($url);
            if($result == '{"status":"error!!! id is null"}'){
                echo $url."<br><br>";
            }
        }
    }



    // delete BAST
    function delete_bast(){
        $id = $this->input->post('id');
        $result['data'] = 'false';
        if($this->Bast_model->deleteBast($id)){
            $this->addLog($this->session->userdata('nik_sess'),'DELETE BAST','BAST',$id);
            $result['data'] = 'success';
        }
        echo json_encode($result);
    }


    function pretemplate(){
        $data['title']         = 'Template BAST';
        $data['list_customer'] = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen']   = $this->rzkt->get_list_segmen()->result_array();

        $data['partner_id']    = $this->input->post('partner_id');
        $data['partner_name']  = $this->input->post('partner_name');
        //echo json_encode($input);die;

        $this->myView('bast/pretemplate',$data);
    }

    function template(){
        $bast          = $this->Bast_model->getDataBast($id_bast);
        //echo json_encode($this->input->post());die;
        $result['data']         = "failed";
        $data['ID_BAST']        = $data_history['ID_PROJECT']  = $this->getGUID();
        $data['NIPNAS']         = $this->input->post('customer_id');
        $data['NAMACC']         = $this->input->post('customer_name');
        $data['SEGMENT']        = $this->input->post('segmen');
        $data['ID_MITRA']       = $this->input->post('partner_id'); 
        $data['NAMA_MITRA']     = !empty($this->input->post('partner_name')) ? $this->input->post('partner_name') : 'Contoh Nama Mitra';
        $data['NO_SPK']         = $this->input->post('spk');
        $data['TGL_SPK']        = $this->input->post('spk_date');
        $data['PROJECT_NAME']   = $this->input->post('project_name');
        $data['NILAI_PEKERJAAN']= $this->input->post('value');
        $data['NO_KL']          = $this->input->post('kl');
        $data['TGL_KL']         = $this->input->post('kl_date');
        $data['TYPE_BAST']      = $this->input->post('type_bast');
        $data['TGL_BAST']       = !empty($this->input->post('bast_date')) ? $this->input->post('bast_date') : '01/01/2018';
        $data['NILAI_RP_BAST']  = $this->input->post('bast_value');
        $data['NILAI_RECCURING']= $this->input->post('reccuring_val');
        $data['RECC_START_DATE']= $this->input->post('recc_start_date');
        $data['RECC_END_DATE']  = $this->input->post('recc_end_date');
        $data['PENANDA_TANGAN'] = $this->input->post('signer');
        $data['NIK_PM']         = $this->input->post('pm');
        $data['NAMA_PM']        = $this->input->post('pm_name');
        $data['PIC_MITRA']      = $this->input->post('pic_partner');
        $data['EMAIL_MITRA']    = $this->input->post('email_pic_partner2');
        $data['KELENGKAPAN_DELIVERY']   = $this->input->post('evidence');
        $data['STATUS']             =   $data_history['STATUS']     = "RECEIVED";
        $data['PROGRESS_LAPANGAN']  = $this->input->post('progress_actual');
        $data['NAMA_TERMIN']        = $this->input->post('termin');
        $data['BAPP']               = !empty($this->input->post('bapp')) ? 1 : null;
        $data['P71']               = !empty($this->input->post('p71')) ? 1 : null;
        $data['ID_PROJECT']         = $this->input->post('id_project');
        $data['LAST_EDITED_BY']     =   $data_history['BY_USER']    =  $this->session->userdata('nik_sess')."|||".$this->session->userdata('nama_sess');

        $bast_date = explode('/', $data['TGL_BAST']);
        $data['BAST_DATE2']= $bast_date[1].'/'.$bast_date[0].'/'.$bast_date[2];
        $day_name  = date('l',strtotime($bast_date[2].'/'.$bast_date[0].'/'.$bast_date[1]));
        
        
        $data['HARI']               = $this->hari(date('l'));
        $data['EJA_HARI']           = $this->ejaHari($bast_date[1]);
        $data['BULAN']              = $this->bulan($bast_date[0]);
        $data['TAHUN']              = $this->tahun($bast_date[2]);
        //echo  $data['TAHUN'];die;
        //echo json_encode($data);die;
        if($this->session->userdata('tipe_sess')=='SUBSIDIARY'){
            $data['STATUS']             =   $data_history['STATUS']     = "SUBMIT BY PARTNER";
        }
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }

        if($data['TYPE_BAST']=='OTC'){$data['PROGRESS_LAPANGAN'] = '100';}
        
        $html = $this->load->view('bast/document',$data,true);
        //$this->load->view('bast/document',$data);

        //$this->load->view('bast/document',$data,true);
        
        $this->load->library('M_pdf');
        $this->m_pdf->debug = true;
        $this->m_pdf->pdf->WriteHTML($html);
        if (file_exists('../_files/report/'.$id_bast.'_'.date('dmY').'.pdf')) {
            unlink('../_files/report/'.$id_project.'_'.date('dmY').'.pdf');
            } 
       
       $this->m_pdf->pdf->Output('../_files/report/'.$id_project.'_'.date('dmY').'.pdf', 'F'); 
       ob_clean();
       $this->m_pdf->pdf->Output(); 


        //SAVE
        /*if($this->Bast_model->saveBAST($data)){
            $this->addLog($this->session->userdata('nik_sess'),'SUBMIT BAST','BAST',json_encode($data));
            $data_history['ID_HISTORY'] = $this->getGUID();
            $data_history['COMMEND'] = $this->input->post('commend');
            if($this->Bast_model->addBASTHistory($data_history)){
                $result['data']     = "success";
                $result['id_bast']  = $data['ID_BAST'];
            }
        }*/

        //echo json_encode($result);
        
    }

}

?>