<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Master extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Master_model');
        if(!$this->isLoggedIn()){
            redirect(base_url());
        };  
    } 
    
   
    public function index()
    {
        echo 'forbidden';die;
    }

    function am(){
        $data['list_customer']  = $this->rzkt->get_list_cc()->result_array();
        $data['list_am']        = $this->Master_model->get_list_am();
        $this->myView('master/index_am',$data);
    }

    function history(){
        $this->myView('master/index_history',null);
    }

    function add_am_cc(){
        $result['data']     = "error";
        $am     = @explode('||',$this->input->get('am'));
        $cc     = @explode('||',$this->input->get('cc'));
        $data   = array(
                    'NIK'     => $am[0], 
                    'NAMA_AM' => $am[1], 
                    'NIPNAS'  => $cc[0], 
                    'NAMA_CC' => $cc[1], 
                    );

        if($this->Master_model->add_am_cc($data)){
            $result['data']     = "success";
        }

        echo json_encode($result);

    }

    function delete_am_cc(){
        $result['data']     = "error";
        $nik        = $this->input->get('nik');
        $nipnas     = $this->input->get('nipnas');
        
        if($this->Master_model->delete_am_cc($nik,$nipnas)){
            $result['data']     = "success";
        }

        echo json_encode($result);
    }

    function subsidiary(){
        $this->myView('master/index_subsidiary',null);
    }

    function update_email_subsidiary(){
        $id     = $this->input->get('id');
        $email  = $this->input->get('email');

        if($this->Master_model->update_email_subsidiary($id,$email)){
            echo 'success';
        }else{
            echo 'error';
        };

    }

    function api(){
        $this->myView('master/index_api',null);
    }

    function config(){
        $email = $this->Master_model->getEmailConfig();

        foreach ($email as $key => $value) {
             $data['email'][$email[$key]['NAME']] = $email[$key]['VALUE']; 
        }

        $data['notification'] = $this->Master_model->getNotification();
        //echo json_encode($notification);die;
        $this->myView('master/set_config',$data);
    }

    function set_config_email(){
        $result['data']         = 'failed';
        $data = $this->input->post();
        $email['protocol']      = $data['email_protocol'];
        $email['smtp_host']    = $data['email_host'];
        $email['smtp_user']    = $data['email_user'];
        $email['smtp_pass']    = $data['email_password'];
        $email['mailtype']      = $data['email_type'];
        if($this->Master_model->set_config_email($email)){
            $result['data']     = 'success';
        }
        echo json_encode($result);
    }


    function set_config_notification(){
        $result['data']         = 'failed';
        $data = $this->input->post();

        $n['NAME']      = $data['content_notification'];
        $n['VALUE']     = $data['title_notification'];
        $n['ACTIVE']    = !empty($this->input->post('status_notification')) ? 1 : 0;
        if($this->Master_model->set_config_notification($n)){
            $result['data']     = 'success';
        }
        //echo $this->db->last_query();die;
        echo json_encode($result);
    }

    //DATATABLE
    function get_datatables_am(){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
       
        $model = $this->Master_model->get_datatables_am($length, $start, $searchValue, $orderColumn, $orderDir, $order);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Master_model->count_all_am(),
            "recordsFiltered" => $this->Master_model->count_filtered_am($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function get_datatables_history(){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
       
        $model = $this->Master_model->get_datatables_dataHistory($length, $start, $searchValue, $orderColumn, $orderDir, $order);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Master_model->count_all_dataHistory(),
            "recordsFiltered" => $this->Master_model->count_filtered_dataHistory($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function get_datatables_subsidiary(){
        $length         = $this->input->post('length');
        $start          = $this->input->post('start');
        $searchValue    = strtoupper($_POST['search']['value']);
        $orderColumn    = $_POST['order']['0']['column'];
        $orderDir       = $_POST['order']['0']['dir'];
        $order          = $this->input->post('order');
       
        $model = $this->Master_model->get_datatables_subsidiary($length, $start, $searchValue, $orderColumn, $orderDir, $order);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Master_model->count_all_subsidiary(),
            "recordsFiltered" => $this->Master_model->count_filtered_subsidiary($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }


}

?>