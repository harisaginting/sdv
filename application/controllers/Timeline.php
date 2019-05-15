<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Timeline extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); 
        $this->load->model('Timeline_model');
         
        if(!$this->isLoggedIn()){
            redirect(base_url().'login');  
            die; 
        };   
    }
    
    function index() {
        $data['title']      = 'Timeline';     
        $data['feed']       = $feed     =   $this->Timeline_model->get_feed();

        foreach ($feed as $key => $value) {
            
        }

        $this->myView('timeline/index', $data);
    }

    function sticky_note(){
        $data['title']      = 'Notes';     

        $this->myView('timeline/sticky_note', $data);   
    }

    function post(){
        $data['title']      = 'Post';     
        $this->myView('timeline/post', $data);
    }

    function credit_point(){
        $data['title']      = 'Post';     
        
        $this->myView('timeline/point', $data);
    }

    function detailPoint(){
        $start              = $this->input->post('d_start');
        $end                = $this->input->post('d_end');
        $data['data']       = $pm   = $this->Timeline_model->getDataPoint($start,$end);
        $pmDetail           = array();
        $pmSUM              = array();

        //echo $this->db->last_query();die;
        //echo json_encode($pm);
        foreach ($pm as $key => $value) {
            $pmSUM[$value['NIK']] = $this->Timeline_model->getDataPointSUM($value['NIK'],$start,$end);
            $pmDetail[$value['NIK']] = $this->Timeline_model->getDataPointDetail($value['NIK'],$start,$end);
            //echo json_encode($pmDetail[$value['NIK']]);die;
        }
        $data['detail']         = $pmDetail; 
        $data['sum']            = $pmSUM; 
        $this->load->view('timeline/listPoint', $data);
    }

    /*function credit_point(){
        $data['title']      = 'Post';     
        $this->myView('timeline/credit_point', $data);
    }*/

    function add_post(){
        $data['title']      = 'Add Post';      
        $this->myView('timeline/add_post', $data);   
    }

    function savePost(){
        $result['data'] = "error";
        
        $post_data = $this->input->post('data');
        $data           = array();
        $data_insert    = array();
        $pic            = "";
        foreach ($post_data as $key => $value) {
            
            if($value['name']=='post_people[]'){
                $pic = $pic.",".$value['value']; 
            }else{
                $data[$value['name']] = $value['value'];
            }
        }
        $data['post_people']    = ltrim($pic, ",");


        if (!empty($this->input->post('profile_picture'))) {
                $targetDir      = "../post_picture/";
                $newName        = $this->makeurl($data['post_title']);

                if(!is_dir($targetDir)){
                    mkdir($targetDir,0777);
                }

                $img = $this->input->post('profile_picture');
                $img = explode(',', $img);
                $pic = base64_decode($img[1]);
                $file = $targetDir . $newName . '.png';
                $success = file_put_contents($file, $pic);
                //print $success ? $pic : 'Unable to save the file.';
                
                $data_insert['IMAGE']     = $newName . '.png';
        }
        $data_insert['ID']          = $this->getGUID();
        $data_insert['TITLE']       = $data['post_title'];
        $data_insert['DATE_EVENT']  = $data['post_date'];
        $data_insert['PIC']         = $data['post_people'];
        $data_insert['CONTENT']     = $data['post_content'];
        $data_insert['POINT']       = $data['post_point'];
        $data_insert['CATEGORY']    = 'EVENT';
        $data_insert['CREATED_BY']  = $this->session->userdata('nik_sess');
        if($this->Timeline_model->save_post($data_insert)){
            $result['data'] = "success";
        }

        echo json_encode($result);

    }

    function savePoint(){
        $people = $this->input->post('people_point');
        $result['data'] = 'success';

        $data['TITLE'] = $this->input->post('title_point');
        $data['CONTENT'] = $this->input->post('title_point');
        $data['POINT'] = $this->input->post('credit_point');
        $data['DATE_EVENT'] = $this->input->post('date_point');
        $data['CATEGORY'] = "EVENT";
        $data['CREATED_BY']  = $this->session->userdata('nik_sess');

        foreach ($people as $key => $value) {
            $data['ID']  = $this->getGUID();
            $data['PIC'] =  $value;

            if(!$this->Timeline_model->save_post($data)){
                $result['data'] = 'error';
            }
        }
        echo json_encode($result);
    }

    function get_list_post(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:0;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $source = $this->input->post('source');


        $model = $this->Timeline_model->get_datatablesPost($length, $start, $searchValue, $orderColumn, $orderDir, $order,$source);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Timeline_model->count_allPost($source),
            "recordsFiltered" => $this->Timeline_model->count_filteredPost($searchValue, $orderColumn, $orderDir, $order,$source),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function get_list_point(){
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty(strtoupper($_POST['search']['value']) )? strtoupper($_POST['search']['value'])  : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:0;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $source = $this->input->post('source');


        $model = $this->Timeline_model->get_datatablesPoint($length, $start, $searchValue, $orderColumn, $orderDir, $order,$source);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Timeline_model->count_allPoint($source),
            "recordsFiltered" => $this->Timeline_model->count_filteredPoint($searchValue, $orderColumn, $orderDir, $order,$source),
            "data" => $model,
        );
        echo json_encode($output);
    }
    
}

?>