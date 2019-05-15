<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Json extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Master_model');
        $this->load->model('Project_model');
        /*if(!$this->isLoggedIn()){
            redirect(base_url());
        };*/  
    } 
    
   
    public function index() 
    {
        echo 'forbidden';die;
    }

    function get_json_customer(){
            $q      = $this->input->post('q');
            $segmen = $this->input->get('segmen');
            $data   = $this->Master_model->get_list_customer($segmen,$q);
            echo json_encode($data);
    }

    function get_json_pm(){
            $q      = $this->input->post('q');
            $data       = $this->Master_model->get_list_pm($q);
            //echo $this->db->last_query();die;
            echo json_encode($data);
    }

    function get_json_users(){
            $data       = $this->Master_model->get_list_users($this->input->post('q')); 
            echo json_encode($data);
    }

    function get_json_am(){
            $customer   = $this->input->get('nipnas');
            $data       = $this->Master_model->get_list_am($customer);
            echo json_encode($data);
    }

    function get_json_pic(){
            $q = $this->input->get('q');
            $data = $this->Master_model->get_list_pic($q);
            echo json_encode($data);
    } 

    function get_json_pic_partner(){
            $q = $this->input->post('q');
            $data = $this->Master_model->get_list_pic_partner($q);
            echo json_encode($data);
    }

    function get_json_pic_email(){
            $q = $this->input->get('q');
            $data = $this->Master_model->get_list_pic_email($q);
            echo $data['EMAIL']; 
    }


    function get_json_spk_bast_local(){
        $q          = $this->input->post('q');
        $partner    = $this->input->post('partner');
        $spkPrime   = $this->Master_model->get_list_spk_bast2($q,$partner);
        echo json_encode($spkPrime);
    }

    function get_json_p71_bast_local(){
        $q          = $this->input->post('q');
        $partner    = $this->input->post('partner');
        $spkPrime   = $this->Master_model->get_list_p71_bast($q,$partner);
        echo json_encode($spkPrime);
    }

    function get_json_spk_bast(){
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
            
            //echo $url;die;
           
            if($this->getCurl($url)){
           
                $spkNumero  = json_decode($this->getCurl($url), TRUE);    
                /*$t_spkPrime  = count($spkPrime);
                $t_spkNumero = count($spkNumero);

                for ($i=0; $i < $t_spkNumero; $i++) { 
                    $spkPrime[$t_spkPrime] = new stdClass;
                    $spkPrime[$t_spkPrime]->NO_SPK = $spkNumero[$i]['NoSPKSPWO'];
                    $spkPrime[$t_spkPrime]->PROJECT_NAME = $spkNumero[$i]['Judul'];
                    $t_spkPrime = $t_spkPrime+1;
                }*/
                if(!empty($spkNumero)){
                    if(empty($q)){
                          foreach ($spkNumero as $key => $value) {
                            $spk[$key] = new stdClass;
                            $spk[$key]->NO_SPK           = $spkNumero[$key]['NoSPKSPWO'];
                            $spk[$key]->PROJECT_NAME     = $spkNumero[$key]['Judul'];
                            $spk[$key]->NIPNAS           = $spkNumero[$key]['NIPNAS'];
                            $spk[$key]->CC               = $spkNumero[$key]['NamaCC'];
                            $spk[$key]->SEGMEN           = $spkNumero[$key]['Segmen'];
                            $spk[$key]->DATE             = $spkNumero[$key]['TanggalP8'];
                            }  
                    }else{
                          foreach ($spkNumero as $key => $value) {
                            if( strpos( $spkNumero[$key]['NoSPKSPWO'], $q ) !== false ) {
                                $spk[$key] = new stdClass;
                                $spk[$key]->NO_SPK           = $spkNumero[$key]['NoSPKSPWO'];
                                $spk[$key]->PROJECT_NAME     = $spkNumero[$key]['Judul'];
                                $spk[$key]->NIPNAS           = $spkNumero[$key]['NIPNAS'];
                                $spk[$key]->CC               = $spkNumero[$key]['NamaCC'];
                                $spk[$key]->SEGMEN           = $spkNumero[$key]['Segmen'];
                                $spk[$key]->DATE             = $spkNumero[$key]['TanggalP8'];

                            }                         
                          } 
                          if(empty($spk)){
                            echo '[]';die;
                          }
                    }
                    echo json_encode($spk);
                }else{
                    echo '[]';
                }
                
            }else{
                echo json_encode($spkPrime);
            }
    } 


    function get_all_spk_numero(){
        echo 'get all spk from numero '.date(' d-m-Y').'<br>';
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
                            echo 'success add'.json_encode($data[$key]).' <br>';
                        };
                    }
                }
            }  
            
        }
    }

    function get_all_p71_numero(){
        echo 'get all p7 from numero '.date(' d-m-Y').'<br>';
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
                            echo 'success add'.json_encode($data[$key]).' <br>';
                        };
                    }
                }
            }  
            
        }
    }


    function get_all_mitra_numero(){
        echo 'get all mitra from numero '.date(' d-m-Y').'<br>';
        $url        = "http://numero.telkom.co.id/jsonapi/mitra.php";  
        $data       = json_decode($this->getCurl($url));
        $data_prime = $this->Master_model->get_all_partner();
        
        foreach ($data as $key => $value) {
            $q = $this->Master_model->get_partner($value->IDMitra);

            if(empty($q)){
                $this->Master_model->add_partner($data[$key]);
                echo "UPDATE PARTNER WITH ID ".$data[$key];
                $this->addLog($this->session->userdata('nik_sess'),'ADD PARTNER','API',json_encode($data[$key]));
            }else{
                if($value->NamaMitra != $q->NAMA_PARTNER){
                    $this->Master_model->update_partner($value->IDMitra,$value->NamaMitra);
                    echo "UPDATE PARTNER WITH ID ".$value->IDMitra." TO".$value->NamaMitra;
                    $meta = $value->IDMitra.";".$value->NamaMitra;
                    $this->addLog($this->session->userdata('nik_sess'),'UPDATE PARTNER','API',$meta);
                }
            }


        }
        
        
    }

    // BAST TO EPIC
    function send_batch_to_epic(){
        $this->load->model('Bast_model');
        echo 'send BAST to epic '.date(' d-m-Y').'<br>';
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


    // Get Project who have ID LOP
    function projects_lop(){
        $q          = $this->input->post('q');
        $data       = $this->Master_model->get_list_project_lop($q);
        echo json_encode($data);
    }

    // Get Project who have ID LOP
    function projects_so(){
        $q          = $this->input->post('q');
        $data       = $this->Master_model->get_list_project_so($q);
        echo json_encode($data);
    }

    function get_detail_project_view(){
        $no_p8  = $this->input->post('no_p8');
        $data   = $this->Master_model->get_detail_project_wfm($no_p8);
        // echo json_encode($data);die;
        //echo json_encode($data['ID_PROJECT']);die;
        if(empty($no_p8)){
            die;
        }
        $this->load->view('utility/validation_project_detail',$data);
    }

    function get_detail_qo_so(){
        $no_p8              = $this->input->post('no_p8');
        $id_row             = !empty($this->Master_model->get_id_row_p8($no_p8)) ? $this->Master_model->get_id_row_p8($no_p8)->ID_ROW : '';

        $data['data']       = $this->Master_model->get_detail_project_qo_so($no_p8);
        //echo $this->db->last_query();die;
        $data['no_spk']     = $no_p8;
        $data['id_row']     = $id_row;
        /*echo json_encode($data['data']);die;*/
        $this->load->view('utility/validation_project_detail_no',$data);
    }

    function addNoQoSo(){
        
        $data = array();
        $data['ID_LOP']                 = $id_lop = $this->input->post('id_lop');
        $data['NO_QUOTE']               = trim($this->input->post('no_quote'));
        $data['NO_SO']                  = trim($this->input->post('no_so'));
        $data['ID_ROW']                 = trim($this->input->post('id_row'));
        $data['NO_P8']                  = trim($this->input->post('no_spk'));
        $data['VALID']                  = 0;
        $data['UPDATED_BY_ID']          = $this->session->userdata('nik_sess');
        $data['UPDATED_BY_NAME']        = $this->session->userdata('nama_sess');

        $cek  = $this->Project_model->checkNoQuoteSO($data['NO_QUOTE'],$data['NO_SO']);
        if($cek == 0){
           if(!empty($data['NO_P8'])){
            $this->Project_model->addNomorWfm($data); 
            } 
           
        }

        $data['data']       = $this->Master_model->get_detail_project_qo_so($data['NO_P8']);
        $data['id_lop']     =  $id_lop;
        $this->load->view('utility/validation_project_detail_no',$data);
    }


    function validNoQoSo(){
        $no_quote   = $this->input->post('no_quote'); 
        $no_so      = $this->input->post('no_so');
        $id_lop     = $this->input->post('id_lop');
        
        $this->Project_model->validNoWfm($id_lop,$no_quote,$no_so,1);
        
        //echo $this->db->last_query();die;

        //$data['data']       = $this->Project_model->get_detail_project_qo_so($id_lop);
        $data['data']       = $this->Master_model->get_detail_project_qo_so($this->input->post('no_spk'));
        $data['id_lop']     =  $id_lop;

        $this->load->view('utility/validation_project_detail_no',$data);
    }

    function unvalidNoQoSo(){
        $no_quote   = $this->input->post('no_quote');
        $no_so      = $this->input->post('no_so');
        $id_lop     = $this->input->post('id_lop');
        $this->Project_model->validNoWfm($id_lop,$no_quote,$no_so,0);


        //$data['data']       = $this->Project_model->get_detail_project_qo_so($id_lop);
        $data['data']       = $this->Master_model->get_detail_project_qo_so($this->input->post('no_spk'));
        $data['id_lop']     =  $id_lop;
        $this->load->view('utility/validation_project_detail_no',$data);
    }

    function deleteNoQoSo(){
        $no_quote   = $this->input->post('no_quote');
        $no_so      = $this->input->post('no_so');
        $id_lop     = $this->input->post('id_lop');
        $this->Project_model->deleteNoWfm($id_lop,$no_quote,$no_so,0);

        //echo $this->db->last_query();die;
        /*$data['data']       = $this->Project_model->get_detail_project_qo_so($id_lop);*/
        $data['data']       = $this->Master_model->get_detail_project_qo_so($this->input->post('no_spk'));
        $data['id_lop']     =  $id_lop;
        $this->load->view('utility/validation_project_detail_no',$data);
    }

    function cekUpdateSPK(){
        $spk_link_null = $this->Master_model->getNullLinkSPK();
        //echo json_encode($spk_link_null);die;
        foreach ($spk_link_null as $key => $value) {
        $url           = "http://numero.telkom.co.id/jsonapi/P8FROMIDROW.php?idrow=".$value['ID_ROW'];
        $result        = $this->getCurl($url);    
        echo $url.' => '.$result.'<br>';
        
        }
        
    }

}

?>