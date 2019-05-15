<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        if(!$this->isLoggedIn()){
            redirect(base_url().'login');  
            die;
        };  
    }

     public function index(){
        $this->myView('user/index');
    }

    function add(){
        $data['list_partner']  = $this->get_list_mitra();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('user/add',$data);
    }

    function save_add(){
        $data['NIK']        = $this->input->post('user_nik');
        $data['NAMA']       = $this->input->post('user_name');
        $data['TIPE']       = $this->input->post('user_type');
        $data['KATEGORI']   = $this->input->post('user_category');
        $data['EMAIL']      = $this->input->post('user_email');
        $data['NO_HP']      = $this->input->post('user_phone');
        $data['DIVISI']     = $this->input->post('user_organization');
        $data['PASSWORD']   = $this->input->post('user_password');
        $data['SEGMEN']     = $this->input->post('user_segmen');
        $data['MITRA']      = $this->input->post('user_subsidiary');
        $data['BAND']       = $this->input->post('user_band');
        $data['REGIONAL']   = $this->input->post('user_regional');

        $result['data']     = 'error';

        if($data['DIVISI']=="SUBSIDIARY"){
            $data['TIPE'] = "SUBSIDIARY";
        }

        if($this->User_model->save_add($data)){
            $result['data'] = 'success';
        }
        echo json_encode($result);
    }

    function save_update(){
        $data['NIK']        = $this->input->post('user_nik');
        $data['NAMA']       = $this->input->post('user_name');
        $data['TIPE']       = $this->input->post('user_type');
        $data['KATEGORI']   = $this->input->post('user_category');
        $data['EMAIL']      = $this->input->post('user_email');
        $data['NO_HP']      = $this->input->post('user_phone');
        $data['DIVISI']     = $this->input->post('user_organization');
        $data['SEGMEN']     = $this->input->post('user_segmen');
        $data['MITRA']      = $this->input->post('user_subsidiary');
        $data['BAND']       = $this->input->post('user_band');
        $data['REGIONAL']   = $this->input->post('user_regional');

        $result['data']     = 'error'; 

        if($data['DIVISI']=="SUBSIDIARY"){
            $data['TIPE'] = "SUBSIDIARY";
        }

        if($this->User_model->save_update($data)){
            $result['data'] = 'success';
        }
        //echo $this->db->last_query();die;
        echo json_encode($result);
    }

    function profile($id=null){

        $type   = array('APPLICATION','CONNECTIVITY','CPE & OTHERS','SMART BUILDING');
        $status = array('LEAD','LAG','DELAY','CLOSED');



        $data['user'] = $this->User_model->getDataUser($id);
        $data['type_project']['ACTIVE']     = $this->User_model->getPMProject($id,'active');
        $data['type_project']['NOT_ACTIVE'] = $this->User_model->getPMProject($id,'non active');
        foreach($type as $value){
            foreach($status as $value2){
                $data['type_project'][$value][$value2] = $this->User_model->getPMProjectTypeStatus($id,$value,$value2);
            }
        } 
        $data['history']             = $this->User_model->getUserHistory($id);

        foreach ($type as $value1) {
            foreach ($status as $value2) {
                $data['db'][$value1][$value2] = $this->User_model->getSumProject($id,$value1,$value2);
            }
        }

        //echo json_encode($data['db']['APPLICATION']['LEAD']);die;

        $this->myView('user/profile',$data);
    }

    function profile_edit($id=null){
        $data['list_partner']  = $this->get_list_mitra();
        $data['user'] = $this->User_model->getDataUser($id);
        $this->myView('user/edit',$data);
    }


    function profile_change_password($id){
        $data['nik']    = $id;
        $this->myView('user/change_password',$data);
    }

    //DATATABLE
    function get_datatables(){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $type       = $this->input->post('type');
        $regional   = $this->input->post('regional');
       
        $model = $this->User_model->get_datatables_users($length, $start, $searchValue, $orderColumn, $orderDir, $order,$type,$regional);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->User_model->count_all_users($type,$regional),
            "recordsFiltered" => $this->User_model->count_filtered_users($searchValue, $orderColumn, $orderDir, $order,$type,$regional),
            "data" => $model,
        );
        echo json_encode($output);
    }



    //DATATABLE
    function get_datatables_credit_week($nik=null){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $type       = $nik;
       
        $model = $this->User_model->get_datatables_credit_week($length, $start, $searchValue, $orderColumn, $orderDir, $order,$type);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->User_model->count_all_credit_week($type),
            "recordsFiltered" => $this->User_model->count_filtered_credit_week($searchValue, $orderColumn, $orderDir, $order,$type),
            "data" => $model,
        );
        echo json_encode($output);
    }


    //DATATABLE
    function get_datatables_credit($nik=null){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $type       = $nik;
       
        $model = $this->User_model->get_datatables_credit($length, $start, $searchValue, $orderColumn, $orderDir, $order,$type);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->User_model->count_all_credit($type),
            "recordsFiltered" => $this->User_model->count_filtered_credit($searchValue, $orderColumn, $orderDir, $order,$type),
            "data" => $model,
        );
        echo json_encode($output);
    }


    //DATATABLE
    function get_datatables_latest_activity($nik=null){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $type       = $nik;
       
        $model = $this->User_model->get_datatables_latest_activity($length, $start, $searchValue, $orderColumn, $orderDir, $order,$type);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->User_model->count_all_latest_activity($type),
            "recordsFiltered" => $this->User_model->count_filtered_latest_activity($searchValue, $orderColumn, $orderDir, $order,$type),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function checkPassword(){
       $pass    = $this->input->post('value');
       $nik     = $this->session->userdata('nik_sess');
       $check   = $this->User_model->checkPassword($nik,$pass);

       if($check > 0){
        echo true;
       } else{
        echo false;
       }
    }

    function checkId(){
       $val     = $this->input->post('value');
       $nik     = $this->session->userdata('nik_sess');
       $check   = $this->User_model->checkId($val);

       if($check > 0){
        echo false;
       } else{
        echo true;
       }
    }

    function save_change_password(){
        $result['data'] = 'error';
        $pass   = $this->input->post('user_new_password');
        $nik    = $this->session->userdata('nik_sess');
        
        if($this->User_model->save_change_password($nik,$pass)){
            $result['data'] = 'success';
        }

        echo json_encode($result);
    }

    function update_photo(){
        $result['data'] = 'error';
        $nik            = $this->session->userdata('nik_sess');

        if (!empty($this->input->post('profile_picture'))) {
                $targetDir      = "../user_picture/".$nik;
                $newName = 'profile-picture-'.$nik;

                if(!is_dir($targetDir)){
                    mkdir($targetDir,0777);
                }

                $img = $this->input->post('profile_picture');
                $img = explode(',', $img);
                $pic = base64_decode($img[1]);
                $file = $targetDir . $newName . '.png';
                $success = file_put_contents($file, $pic);
                //print $success ? $file : 'Unable to save the file.';
                
                    $data['NIK']     = $nik;
                    $data['PHOTO']     = $nik.$newName . '.png';
                    $data['PHOTO_URL'] = $targetDir . $newName . '.png';
                    $ubahData = $this->User_model->save_update($data);

                    if ($ubahData) {
                        $this->session->set_userdata(array('foto' => $data['PHOTO_URL']));
                        $result['data'] = 'success';
                    }
        echo json_encode($result);
        }
    }


}

?>