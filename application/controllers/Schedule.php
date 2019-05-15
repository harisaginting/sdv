 <?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model('Schedule_model');
         
        if(!$this->isLoggedIn()){
            redirect(base_url().'login');  
            die; 
        };   
    }
    
    function index() {
        $data['title']      = 'Timeline';     
        // $this->myViewHeader('schedule/index', $data);
        $this->myView('schedule/index', $data);
    }
    

    function projects_schedule(){
        // RETURN JSON DATA DELIVERYNYA
        $gantt              = $this->Schedule_model->getDataGanttTask();
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
            $c_gantt['segmen']  = $value['SEGMEN'];
            $c_gantt['description']  = $value['DESCRIPTION'];
            $c_gantt['pm']  = $value['PM'];
            $c_gantt['category']  = $value['CATEGORY'];
            array_push($data['gantt'], $c_gantt);
        }

        $result['data'] = $data['gantt'];
        echo json_encode($result);

    }

}

?>