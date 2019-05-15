<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring extends MY_Controller
{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Monitoring_model');
        if(!$this->isLoggedIn()){
            redirect(base_url().'login');  
            die;
        };   
    }
    
    public function pm(){
        $data['title'] = 'Monitoring Project Manager';
        $data['pm']    = $this->Monitoring_model->getListPM();
        $this->myView('monitoring/project_manager',$data);           
    }
 
    public function pm_activity(){
        $data['title'] = 'Monitoring PM Activity';
        $data['list_pm']     = $this->get_list_pm();        
        $this->myView('monitoring/pm_activity',$data);           
    }

    public function planAch(){
        $data['title'] = 'Monitoring';
        $this->myView('monitoring/plan_achievment',$data);           
    } 

    public function deliverable(){
        $data['title'] = 'Monitoring';  
        $this->myView('monitoring/deliverable',$data);            
    }

    public function subsidiary(){
        $data['title'] = 'Subsidiary';
        $data['subsidiary']  = $this->get_list_mitra();
        $this->myView('monitoring/subsidiary',$data);           
    }

    public function issueAp(){
        $data['title'] = 'Monitoring';

        /*$data['issue']['active_action']     = $this->Monitoring_model->getSumIssue(1);
        $data['issue']['active_nto_action'] = $this->Monitoring_model->getSumIssue(2);
        $data['issue']['active_action']     = $this->Monitoring_model->getSumIssue(3);*/


        $this->myView('monitoring/issue_ap',$data);           
    }
 
    public function bast(){
        $data['title'] = 'Project BAST';
        $this->myView('monitoring/bast',$data);           
    }

    public function segmen(){
        $data['title'] = 'Segmen';
        $this->myView('monitoring/segmen',$data);           
    }

    function getProjectPM(){
        $data['title']  = 'Monitoring';

        $nik            = $this->input->post('nik');
        $data['nik']    = $nik;
        
        $projects       = $this->Monitoring_model->getListProjectsPM($nik);

        foreach ($projects as $key => $value) {
            $plan_ach               = $this->Monitoring_model->getPlanAchievment($projects[$key]['ID_PROJECT']);
            $projects[$key]['PLAN'] = $plan_ach['PLAN']; 
            $projects[$key]['ACH']  = $plan_ach['REAL']; 
            $projects[$key]['kurva'] = $this->Monitoring_model->get_curva_s($projects[$key]['ID_PROJECT']); 
        }

        $data['projects'] = $projects;

        $this->load->view('monitoring/project_manager_projects',$data);   
    }

    function get_list_planAch(){
        /*if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');*/
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty($_POST['search']['value'])? strtoupper($_POST['search']['value']) : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;

        $model = $this->Monitoring_model->get_datatables_planAch($length, $start, $searchValue, $orderColumn, $orderDir, $order);
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_planAch(),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_planAch($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function get_list_issueAp(){
        /*if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');*/
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty($_POST['search']['value'])? strtoupper($_POST['search']['value']) : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;

        $model = $this->Monitoring_model->get_datatables_issueAp($length, $start, $searchValue, $orderColumn, $orderDir, $order);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_issueAp(),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_issueAp($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function get_list_subsidiary(){
        /*if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');*/
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty($_POST['search']['value'])? strtoupper($_POST['search']['value']) : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;

        $model = $this->Monitoring_model->get_datatables_subsidiary($length, $start, $searchValue, $orderColumn, $orderDir, $order);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_subsidiary(),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_subsidiary($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function get_list_bast(){
        /*if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');*/
        $length         = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start          = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue    = !empty($_POST['search']['value'])? strtoupper($_POST['search']['value']) : null;
        $orderColumn    = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir       = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order          = !empty($_POST['order'])? $_POST['order']: null;
        $status          = !empty($_POST['status'])? $_POST['status']: null;

        $model = $this->Monitoring_model->get_datatables_bast($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_bast($status),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_bast($searchValue, $orderColumn, $orderDir, $order,$status),
            "data" => $model,
        );
        echo json_encode($output);
    }
 
    function download_list_monitoring_planAch(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Monitoring_model->download_list_monitoring_planAch();

        $name = 'M. Plan Achievment'.date('Y-m-d');

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
            ,array('name' => 'ID LOP', 'id' => 'ID_LOP', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id' => 'NAME', 'width' => 120)
            ,array('name' => 'CLIENT', 'id' => 'STANDARD_NAME', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMEN', 'width' => 15)
            ,array('name' => 'PARTNERS', 'id' => 'PARTNERS', 'width' => 120)
            ,array('name' => 'PROJECT VALUE', 'id' => 'VALUE', 'width' => 30)
            ,array('name' => 'PLAN', 'id' => 'PLAN', 'width' => 10)
            ,array('name' => 'ACHIEVMENT', 'id' => 'ACH', 'width' => 10)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }


    function download_list_monitoring_bast(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Monitoring_model->download_list_monitoring_bast();

        $name = 'M. Project - BAST'.date('Y-m-d');

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
            ,array('name' => 'PROJECT NAME', 'id' => 'NAME', 'width' => 120)
            ,array('name' => 'VALUE', 'id' => 'VALUE', 'width' => 35)
            ,array('name' => 'NO. BAST', 'id' => 'NO_BAST', 'width' => 35)
            ,array('name' => 'BAST VALUE', 'id' => 'VALUE2', 'width' => 20)
            ,array('name' => 'BAST DATE', 'id' => 'BAST_DATE', 'width' => 20)
            ,array('name' => 'BAST PAYMENT SCHEME', 'id' => 'TYPE_BAST', 'width' => 20)
            ,array('name' => 'PLAN PROJECT', 'id' => 'PLAN', 'width' => 10)
            ,array('name' => 'PROGRESS PROJECT', 'id' => 'ACH', 'width' => 10)
            ,array('name' => 'BAST PROGRESS', 'id' => 'PROGRESS_LAPANGAN', 'width' => 10)
            ,array('name' => 'TERMIN', 'id' => 'NAMA_TERMIN', 'width' => 15)
            ,array('name' => 'RECCURING START DATE', 'id' => 'RECC_START_DATE', 'width' => 15)
            ,array('name' => 'RECCURING END DATE', 'id' => 'RECC_END_DATE', 'width' => 15)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }

    function download_monitoring_project_manager(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Monitoring_model->download_monitoring_pm();
        //echo json_encode($data);die;
        $name = 'Monitoring PM'.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );

        $data_title = array(
             array('name' => 'NIK', 'id'                  => 'NIK', 'width' => 10)
            ,array('name' => 'NAME', 'id'                 => 'NAMA', 'width' => 120)
            ,array('name' => 'CATEGORY', 'id'             => 'KATEGORI', 'width' => 35)
            ,array('name' => 'EMAIL', 'id'                => 'EMAIL', 'width' => 35)
            ,array('name' => 'PHONE', 'id'                => 'NO_HP', 'width' => 20)
            ,array('name' => 'BAND', 'id'                 => 'BAND', 'width' => 20)
            ,array('name' => 'BAND POINT', 'id'           => 'BP', 'width' => 20)
            ,array('name' => 'TOTAL PROJECT ACTIVE', 'id' => 'TPROJECT', 'width' => 20)
            ,array('name' => 'LEAD', 'id'                 => 'TPROJECT1', 'width' => 10)
            ,array('name' => 'LAG', 'id'                  => 'TPROJECT2', 'width' => 10)
            ,array('name' => 'DELAY', 'id'                => 'TPROJECT3', 'width' => 10)
            ,array('name' => 'APPLICATION  > 95%', 'id'   => 'TAPP1', 'width' => 15)
            ,array('name' => 'APPLICATION  <= 95%', 'id'  => 'TAPP2', 'width' => 15)
            ,array('name' => 'CPE & OTHERS  > 95%', 'id'  => 'TCPE1', 'width' => 15)
            ,array('name' => 'CPE & OTHERS  <= 95%', 'id' => 'TCPE2', 'width' => 15)
            ,array('name' => 'SMART BUILDING  > 95%','id' => 'TSB1', 'width' => 15)
            ,array('name' => 'SMART BUILDING  <= 95%','id'=> 'TSB2', 'width' => 15)
            ,array('name' => 'CONNECTIVITY  > 95%','id'   => 'TCONN1', 'width' => 15)
            ,array('name' => 'CONNECTIVITY  <= 95%','id'  => 'TCONN2', 'width' => 15)
            ,array('name' => 'TOTAL LOAD','id'            => 'LOAD', 'width' => 15)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }


    function download_list_monitoring_issueAp(){
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Monitoring_model->download_list_monitoring_issueAp();

        $name = 'Issue - Action Plan '.date('Y-m-d');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        );
        //echo json_encode($data);die;
        $data_title = array(
             array('name' => 'ID PROJECT', 'id' => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'ID LOP', 'id' => 'ID_LOP', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id' => 'NAME', 'width' => 120)
            ,array('name' => 'CLIENT', 'id' => 'STANDARD_NAME', 'width' => 35)
            ,array('name' => 'SEGMEN', 'id' => 'SEGMEN', 'width' => 15)
            ,array('name' => 'PARTNERS', 'id' => 'PARTNERS', 'width' => 120)
            ,array('name' => 'PROJECT VALUE', 'id' => 'VALUE', 'width' => 30)
            ,array('name' => 'PLAN', 'id' => 'PLAN', 'width' => 10)
            ,array('name' => 'ACHIEVMENT', 'id' => 'ACH', 'width' => 10)
            ,array('name' => 'ISSUE', 'id' => 'ISSUE_NAME', 'width' => 50)
            ,array('name' => 'ACTION PLAN', 'id' => 'ACTION_NAME', 'width' => 50)
            ,array('name' => 'LAST UPDATED', 'id' => 'ACH', 'LAST_UPDATED' => 50)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }

    function download_pm_activity(){
            $this->load->library('Hgn_spreadsheet');
            $data = $this->Monitoring_model->download_list_pm_activity();
            $name = 'Detail PM Activity'.date('Y-m-d');

            $this->hgn_spreadsheet->setHeader(
                array(
                    'title' => $name
                    ,'subject' => $name
                    ,'description' => $name
                    ,'sheet_name' => $name
                )
            );
            //echo json_encode($data);die;
            $data_title = array(
                 array('name' => 'ID PM', 'id'  => 'PM_NIK', 'width' => 10)
                ,array('name' => 'PM NAME', 'id' => 'PM_NAME', 'width' => 10)
                ,array('name' => 'DATE UPDATE', 'id' => 'DATE_UPDATED', 'width' => 120)
                ,array('name' => 'ACTION', 'id' => 'STATUS', 'width' => 35)
                ,array('name' => 'PROJECT', 'id' => 'NAME', 'width' => 15)
                );
            $this->hgn_spreadsheet->setDataTitle($data_title);
            $file = $this->hgn_spreadsheet->create($name, $data);

            $this->load->helper('download');
            force_download($file, NULL);
        }

    function getProjectSubsidiary(){
        $data['title']  = 'Monitoring';

        $id            = $this->input->post('id');
        $data['id']    = $id;
        
        $projects       = $this->Monitoring_model->getListProjectsSubsidiary($nik);

        foreach ($projects as $key => $value) {
            $plan_ach               = $this->Monitoring_model->getPlanAchievment($projects[$key]['ID_PROJECT']);
            $projects[$key]['PLAN'] = $plan_ach['PLAN']; 
            $projects[$key]['ACH']  = $plan_ach['REAL']; 
            $projects[$key]['kurva'] = $this->Monitoring_model->get_curva_s($projects[$key]['ID_PROJECT']); 
        }

        $data['projects'] = $projects;

        $this->myView('monitoring/project_manager_projects',$data);   
    }


    // MONITORING LOP
    public function lop()
    {
        $data['sidebarhidden'] = 1;
        $data['title']       = 'Monitoring LOP';
        $data['list_pm']     = $this->get_list_pm();
        $data['list_mitra']  = $this->get_list_mitra();
        $data['list_cc']     = $this->rzkt->get_list_cc()->result_array();
        $data['list_segmen'] = $this->rzkt->get_list_segmen()->result_array();
        $this->myView('monitoring/lop',$data);
            
    }

     // Get Datatables
    function get_list_lop(){
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

        $model = $this->Monitoring_model->get_datatablesLop($length, $start, $searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_allLop($status,$pm,$customer,$partner,$type,$regional,$segmen),
            "recordsFiltered" => $this->Monitoring_model->count_filteredLop
            ($searchValue, $orderColumn, $orderDir, $order,$status,$pm,$customer,$partner,$type,$regional,$segmen),
            "data" => $model,
        );
        echo json_encode($output);
    }


    function get_list_acq(){
        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $searchValue = strtoupper($_POST['search']['value']);
        $orderColumn = $_POST['order']['0']['column'];
        $orderDir   = $_POST['order']['0']['dir'];
        $order      = $this->input->post('order');
        $month      = $this->input->post('month');

        $model = $this->Monitoring_model->get_datatables_dataAcq($length, $start, $searchValue, $orderColumn, $orderDir, $order,$month);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_dataAcq($month),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_dataAcq($searchValue, $orderColumn, $orderDir, $order,$month),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function acquisition(){
        $data['sidebarhidden'] = 1;
        $data['title'] = 'Monitoring Acquistion';
        $data['pm']    = $this->Monitoring_model->getListPM();
        $this->myView('monitoring/acquistion',$data);    
    }

    function download_list_acquisiton(){ 
        $this->load->library('Hgn_spreadsheet');
        $data = $this->Monitoring_model->download_list_monitoring_acq();

        $name = 'Acquistion '.date('F');

        $this->hgn_spreadsheet->setHeader(
            array(
                'title' => $name
                ,'subject' => $name
                ,'description' => $name
                ,'sheet_name' => $name
            )
        ); 

        $data_title = array(
             array('name' => 'MONTH', 'id'                  => 'MONTH', 'width' => 10)
            ,array('name' => 'ID PROJECT', 'id'             => 'ID_PROJECT', 'width' => 10)
            ,array('name' => 'NAME', 'id'                   => 'NAME', 'width' => 10)
            ,array('name' => 'TYPE', 'id'                   => 'TYPE', 'width' => 10)
            ,array('name' => 'PROJECT NAME', 'id'           => 'NAME', 'width' => 120)
            ,array('name' => 'PROJECT MANAGER', 'id'        => 'PM_NAME', 'width' => 30)
            ,array('name' => 'ACCOUNT MANAGER', 'id'        => 'AM_NAME', 'width' => 15)
            ,array('name' => 'SEGMEN', 'id'                 => 'SEGMEN', 'width' => 15)
            ,array('name' => 'ACQUISTION', 'id'             => 'ACQ', 'width' => 120)
            ,array('name' => 'COMULATIVE ACQUISITION', 'id' => 'C_ACQ', 'width' => 30)
            ,array('name' => 'PROGRESS', 'id'               => 'PROGRESS', 'width' => 10)
            ,array('name' => 'COMULATIVE_PROGRESS', 'id'    => 'C_PROGRESS', 'width' => 10)
            ,array('name' => 'TOP', 'id'                    => 'TOP', 'width' => 10)
            ,array('name' => 'RECCURING START', 'id'        => 'RECCURING_START', 'width' => 10)
            ,array('name' => 'RECCURING END', 'id'          => 'RECCURING_END', 'width' => 10)
            ,array('name' => 'TERMIN', 'id'                 => 'TERMIN', 'width' => 10)
            ,array('name' => 'NOTE', 'id'                   => 'NOTE', 'width' => 30)
            ,array('name' => 'VALID', 'id'                  => 'VALID', 'width' => 30)
            );
        $this->hgn_spreadsheet->setDataTitle($data_title);
        $file = $this->hgn_spreadsheet->create($name, $data);

        $this->load->helper('download');
        force_download($file, NULL);
    }


    // DATATABLE PM ACTIVITY 
    function get_list_pm_activity(){
        /*if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');*/
        $length = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty($_POST['search']['value'])? strtoupper($_POST['search']['value']) : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order = !empty($_POST['order'])? $_POST['order']: null;
        $pm = !empty($_POST['pm'])? $_POST['pm']: null;
        $start_date = !empty($_POST['start_date'])? $_POST['start_date']: null;

        $model = $this->Monitoring_model->get_datatables_pmactivity($length, $start, $searchValue, $orderColumn, $orderDir, $order,$pm,$start_date);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_pmactivity($pm,$start_date),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_pmactivity($searchValue, $orderColumn, $orderDir, $order,$pm,$start_date),
            "data" => $model,
        );
        echo json_encode($output);
    }

    function progress(){
        $data['title'] = 'Monitoring';
        $this->myView('monitoring/progress',$data);   
    }

    function get_list_progress(){
        $length     = !empty($this->input->post('length'))? $this->input->post('length') : null;
        $start      = !empty($this->input->post('start'))?$this->input->post('start'): null;
        $searchValue = !empty($_POST['search']['value'])? strtoupper($_POST['search']['value']) : null;
        $orderColumn = !empty($_POST['order']['0']['column'])?$_POST['order']['0']['column']:null;
        $orderDir    = !empty($_POST['order']['0']['dir'])? $_POST['order']['0']['dir']:null;
        $order       = !empty($_POST['order'])? $_POST['order']: null;

        $model = $this->Monitoring_model->get_datatables_progress($length, $start, $searchValue, $orderColumn, $orderDir, $order);
        $output = array( 
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Monitoring_model->count_all_progress(),
            "recordsFiltered" => $this->Monitoring_model->count_filtered_progress($searchValue, $orderColumn, $orderDir, $order),
            "data" => $model,
        );
        echo json_encode($output);
    }

}

?>