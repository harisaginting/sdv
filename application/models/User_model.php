<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct() {
    }


    function save_add($data){
        foreach($data as $key => $value){
                if(!empty($value)){
                        $this->db->set($key , $value);
                    }     
            }         
        return $this->db->insert('PRIME_USERS');
    }

    function getNameUser($nik){
        $q = $this->db->select('NAMA')->from('PRIME_USERS')->where('NIK',$nik)->get()->row();
        return $q->NAMA;
    }

    function save_update($data){ 
        foreach($data as $key => $value){
                if(!empty($value)){
                        $this->db->set($key , $value);
                    }     
            }         
        if(empty($data['REGIONAL'])){
            $this->db->set('REGIONAL' , 0);
        }    
        $this->db->where('NIK', $data['NIK']);
        return $this->db->update('PRIME_USERS');
    }

    function getSumProject($nik,$type,$status){
        $query  = $this->db
                    ->select('COUNT(1) TOTAL')
                    ->from('PRIME_PROJECT')
                    ->where('PM_NIK',$nik)
                    ->where('TYPE',$type)
                    ->where('STATUS',$status)
                    ->get()
                    ->row()
                    ->TOTAL;
        return $query;
    }

    function getDataUser($id){
       $q = $this->db->select('*')
            ->from('PRIME_USERS A')
            ->join("(SELECT PIC, SUM(POINT) TPOINT FROM PRIME_POST WHERE DATE_EVENT >= next_day(trunc(sysdate), 'MONDAY') - 7 AND DATE_EVENT < next_day(trunc(sysdate), 'MONDAY') GROUP BY PIC) B","A.NIK = B.PIC","LEFT")
            ->join("(SELECT PIC, SUM(POINT) ALLTPOINT FROM PRIME_POST GROUP BY PIC) C","A.NIK = C.PIC","LEFT")
            ->where('A.NIK',$id);
       return $q->get()->row_array(); 
    }

    function getUserHistory($id){
        $q = $this->db
             ->select("ID_USER, NAME_USER, STATUS, TO_CHAR(DATE_CREATED, 'MM/DD/YYYY') DATE_CREATED2")
             ->from('PRIME_HISTORY')
             ->where('ID_USER',$id)
             ->where('DATE_CREATED <=','sysdate - 3 ', FALSE)
             ->distinct()
             ->get();

        return $q->result_array();
    }


    function getPMProject($id,$type){
        $this->db->set_dbprefix(''); 
        if($type=='active'){
            $query = $this->db->select('count(*) TOTAL')
                            ->from('PRIME_PROJECT')
                            ->where("PM_NIK",$id)
                            ->where_in('STATUS', array('LEAD','LAG','DELAY' ))
                            ->order_by('TYPE')
                            ->get()
                            ->row();
            return $query;    
        }else{
            $this->db->set_dbprefix('');  
            $query = $this->db->select('count(*) TOTAL')
                                ->from('PRIME_PROJECT')
                                ->where("PM_NIK",$id)
                                ->where('STATUS', 'CLOSED')
                                ->order_by('TYPE')
                                ->get()
                                ->row();
            return $query; 
        } 
                        
    }

    function getPMProjectTypeStatus($id,$type,$status){
        $this->db->set_dbprefix('');  
        $query = $this->db->select('count(*) TOTAL')
                            ->from('PRIME_PROJECT')
                            ->where("PM_NIK",$id)
                            ->where("TYPE",$type)
                            ->where("STATUS",$status)
                            ->order_by('STATUS')
                            ->get()
                            ->row();
        return $query;                    
    }


#USERS DATATABLES
    var $column_order_users = array('NIK','NAMA','TIPE','EMAIL','NO_HP',NULL,NULL,NULL); 
    var $column_search_users = array("UPPER(A.NAMA)","UPPER(A.NIK)","UPPER(A.EMAIL)","UPPER(B.NAMA_PARTNER)");
    var $order_users = array( "A.NIK" => 'asc');
    
    public function _get_all_query_users($type=null,$regional=null){
            $query = $this->db
            ->select("A.*, B.NAMA_PARTNER")
            ->from("PRIME_USERS A")
            ->join("PRIME_PARTNER_TATA B","A.MITRA = B.KODE_PARTNER","LEFT");


            if(!empty($type)){
            $query = $query->where('TIPE',$type);    
            }

            if(!empty($regional)){
                if($regional=='x'){
                   $query = $query->where('REGIONAL',0);  
                }else{
                    $query = $query->where('REGIONAL',$regional);
                } 
            }

            $regional1 =    $this->session->userdata('regional');
                    if($regional1 != '0' && !empty($regional1)){
                        $query = $query->where('REGIONAL', $regional1);
                    }

            return $query;
    }

    private function _get_datatables_query_users($searchValue, $orderColumn, $orderDir, $getOrder,$type,$regional){

        $this->_get_all_query_users($type,$regional);

        $i = 0;

        foreach ($this->column_search_users as $item) // loop column
        {
            if ($searchValue) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $searchValue);
                } else {
                    $this->db->or_like($item, $searchValue);
                }

                if (count($this->column_search_users) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_users[$orderColumn], $orderDir);
        }
        else if(isset($this->order_users))
        {
            $order = $this->order_users;
            $this->db->order_by(key($order), $orderDir);
        }
    }

    function get_datatables_users($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$type,$regional){
        $this->_get_datatables_query_users($searchValue, $orderColumn, $orderDir, $getOrder,$type,$regional);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_users($searchValue, $orderColumn, $orderDir, $getOrder,$type,$regional){
        $this->_get_datatables_query_users($searchValue, $orderColumn, $orderDir, $getOrder,$type,$regional);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_users($type){
        $this->_get_all_query_users($type);
        return $this->db->count_all_results();
    }
#END DATATABLES USERS

#DATATABLES CREDIT WEEK
    var $column_order_credit_week = array('DATE_EVENT','CATEGORY','POINT',NULL,NULL,NULL,NULL,NULL); 
    var $column_search_credit_week = array("UPPER(NAMA)","NIK");
    var $order_credit_week = array( "DATE_EVENT" => 'DESC');
    
    public function _get_all_query_credit_week($nik=null){
            $query = $this->db
            ->select("A.*, TO_CHAR(A.DATE_EVENT, 'DD MONTH YYYY') DATE_EVENT2")
            ->from("PRIME_POST A")
            ->where("DATE_EVENT >=","next_day(trunc(sysdate), 'MONDAY') - 7",FALSE)
            ->where("DATE_EVENT <","next_day(trunc(sysdate), 'MONDAY')",FALSE)
            ->where("A.PIC",$nik);

            return $query;
    }

    private function _get_datatables_query_credit_week($searchValue, $orderColumn, $orderDir, $getOrder,$type){

        $this->_get_all_query_credit_week($type);

        $i = 0;

        foreach ($this->column_search_credit_week as $item) // loop column
        {
            if ($searchValue) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $searchValue);
                } else {
                    $this->db->or_like($item, $searchValue);
                }

                if (count($this->column_search_credit_week) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_credit_week[$orderColumn], $orderDir);
        }
        else if(isset($this->order_credit_week))
        {
            $order = $this->order_credit_week;
            $this->db->order_by(key($order), $orderDir);
        }
    }

    function get_datatables_credit_week($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$type){
        $this->_get_datatables_query_credit_week($searchValue, $orderColumn, $orderDir, $getOrder,$type);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_credit_week($searchValue, $orderColumn, $orderDir, $getOrder,$type){
        $this->_get_datatables_query_credit_week($searchValue, $orderColumn, $orderDir, $getOrder,$type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_credit_week($type){
        $this->_get_all_query_credit_week($type);
        return $this->db->count_all_results();
    }
#END DATATABLES CREDIT WEEK

#DATATABLES CREDIT
    var $column_order_credit = array('NIK','NAMA','TYPE',NULL,NULL,NULL,NULL,NULL); 
    var $column_search_credit = array("UPPER(NAMA)","NIK");
    var $order_credit = array( "DATE_EVENT" => 'DESC');
    
    public function _get_all_query_credit($nik=null){
            $query = $this->db
            ->select("A.*, TO_CHAR(A.DATE_EVENT, 'DD MONTH YYYY') DATE_EVENT2")
            ->from("PRIME_POST A")
            ->where("A.PIC",$nik);

            return $query;
    }

    private function _get_datatables_query_credit($searchValue, $orderColumn, $orderDir, $getOrder,$type){

        $this->_get_all_query_credit($type);

        $i = 0;

        foreach ($this->column_search_credit as $item) // loop column
        {
            if ($searchValue) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $searchValue);
                } else {
                    $this->db->or_like($item, $searchValue);
                }

                if (count($this->column_search_credit) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_credit[$orderColumn], $orderDir);
        }
        else if(isset($this->order_credit))
        {
            $order = $this->order_credit;
            $this->db->order_by(key($order), $orderDir);
        }
    }

    function get_datatables_credit($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$type){
        $this->_get_datatables_query_credit($searchValue, $orderColumn, $orderDir, $getOrder,$type);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_credit($searchValue, $orderColumn, $orderDir, $getOrder,$type){
        $this->_get_datatables_query_credit($searchValue, $orderColumn, $orderDir, $getOrder,$type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_credit($type){
        $this->_get_all_query_credit($type);
        return $this->db->count_all_results();
    }
#END DATATABLES CREDIT

#DATATABLES LATEST ACTIVITY
    var $column_order_latest_activity = array('NIK','NAMA','TYPE',NULL,NULL,NULL,NULL,NULL); 
    var $column_search_latest_activity = array("UPPER(NAMA)","NIK");
    var $order_latest_activity = array( "DATE_CREATED" => 'DESC');
    
    public function _get_all_query_latest_activity($nik=null){
            $q = $this->db
             ->select("DATE_CREATED, TYPE,ID_USER, NAME_USER, STATUS, TO_CHAR(DATE_CREATED, 'DD MONTH YYYY HH24:MI') DATE_CREATED2,META")
             ->from('PRIME_HISTORY')
             ->where('ID_USER',$nik) 
             ->where('DATE_CREATED <=','sysdate - 3 ', FALSE)
             ->distinct();

            return $q;
    }

    private function _get_datatables_query_latest_activity($searchValue, $orderColumn, $orderDir, $getOrder,$type){

        $this->_get_all_query_latest_activity($type);

        $i = 0;

        foreach ($this->column_search_latest_activity as $item) // loop column
        {
            if ($searchValue) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $searchValue);
                } else {
                    $this->db->or_like($item, $searchValue);
                }

                if (count($this->column_search_latest_activity) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_latest_activity[$orderColumn], $orderDir);
        }
        else if(isset($this->order_latest_activity))
        {
            $order = $this->order_latest_activity;
            $this->db->order_by(key($order), 'DESC');
        }
    }

    function get_datatables_latest_activity($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$type){
        $this->_get_datatables_query_latest_activity($searchValue, $orderColumn, $orderDir, $getOrder,$type);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_latest_activity($searchValue, $orderColumn, $orderDir, $getOrder,$type){
        $this->_get_datatables_query_latest_activity($searchValue, $orderColumn, $orderDir, $getOrder,$type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_latest_activity($type){
        $this->_get_all_query_latest_activity($type);
        return $this->db->count_all_results();
    }
#END DATATABLES LATEST ACTIVITY


    public function get_by_field($field_array)
    {
        $query = $this->db->get_where('PRIME_ROLE', $field_array)->row_array();
        //echo $this->db->last_query();
        return $query;
    }


    function checkPassword($nik,$pass){
        $query = $this->db
                ->select('COUNT(1) TOTAL')
                ->from('PRIME_USERS')
                ->where('NIK',$nik)
                ->where('PASSWORD',$pass)
                ->get()
                ->row_array();


        return $query['TOTAL'];

    }

    function checkId($nik){
        $nik2 = strtoupper($nik);
        $query = $this->db
                ->select('COUNT(1) TOTAL')
                ->from('PRIME_USERS')
                ->where('UPPER(NIK)',$nik2)
                ->get()
                ->row_array();


        return $query['TOTAL'];

    }

    function save_change_password($nik,$pass){
        $this->db->set('PASSWORD',$pass);
        $this->db->where('NIK',$nik);
        return $this->db->update('PRIME_USERS');
    }

    function getNotification($nik){
       $data = $this->db->query("SELECT * FROM (
                        SELECT EXIST, ID_PROJECT ID, ID_PROJECT TITLE, PM_NIK PIC, 'SYMTOMP' TYPE FROM PRIME_PROJECT WHERE REASON_OF_DELAY IS NULL
                        AND STATUS IN ('LAG','DELAY')
                        UNION
                        SELECT EXIST, ID_BAST ID,NAMA_MITRA TITLE, CASE PENANDA_TANGAN WHEN 'Senior Expert Project Management Office 1' THEN '820020'
                        WHEN 'Senior Expert Project Management Office 2' THEN '660190'
                        WHEN 'Senior Expert Delivery and Integration' THEN '790109'
                        ELSE '730494' END PIC, 'BAST' TYPE
                        FROM PRIME_BAST_HGN WHERE STATUS IN ('CHECK BY SE PMO','CHECK BY SE PMO','CHECK BY SE COORD')
                        ) WHERE PIC = '$nik' AND EXIST = 1");
       return $data->result();
    }



 

}     