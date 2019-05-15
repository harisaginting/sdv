<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_model extends CI_Model {

	protected $tblCbase;

	public function __construct()
	{ 
		parent::__construct();
		$this->tblCbase = 'CBASE_DIVES';
	}

    function getListPM(){
        $q = $this->db
            ->select("A.*, TO_CHAR(LATEST, 'DD-MON-YYYY HH24:MI:SS') LATEST,C.*,D.*,E.*,F.*,G.*")
            ->from('PRIME_USERS A') 
            ->join('(SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY GROUP BY ID) B','B.ID = A.NIK','LEFT')
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT FROM PRIME_PROJECT WHERE STATUS IN ('LEAD','LAG','DELAY') AND EXIST = '1' GROUP BY PM_NIK) C",'C.PM_NIK = A.NIK')
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT1 FROM PRIME_PROJECT WHERE STATUS = 'LEAD' AND EXIST = '1' GROUP BY PM_NIK) D",'D.PM_NIK = A.NIK',"LEFT")
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT2 FROM PRIME_PROJECT WHERE STATUS = 'LAG' AND EXIST = '1' GROUP BY PM_NIK) E",'E.PM_NIK = A.NIK',"LEFT")
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT3 FROM PRIME_PROJECT WHERE STATUS = 'DELAY' AND EXIST = '1' GROUP BY PM_NIK) F",'F.PM_NIK = A.NIK',"LEFT")
            ->join("(
                    SELECT M.*, 
                        ( ((TAPP1*0.5)+(TAPP2*1) + (TCONN1*0.5)+(TCONN2*1) + (TCPE1*0.5)+(TCPE2*1) + (TSB1*0.75)+(TSB2*1) + (BP*TOTAL) )  - (D*0.9) ) LOAD
                    FROM
                        (
                        SELECT
                        PM_NIK, PM_NAME, BAND,
                        SUM(CASE WHEN ((TYPE = 'APPLICATION') OR (TYPE = 'BIG DATA')) AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TAPP1, 
                        SUM(CASE WHEN ((TYPE = 'APPLICATION') OR (TYPE = 'BIG DATA'))  AND TO_NUMBER(ACH) <= 95 then 1 else 0  end) TAPP2, 
                        SUM(CASE WHEN TYPE = 'CPE DEVICES' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TCPE1, 
                        SUM(CASE WHEN TYPE = 'CPE DEVICES' AND TO_NUMBER(ACH) <= 95 then 1 else 0 end) TCPE2, 
                        SUM(CASE WHEN TYPE = 'SMART BUILDING' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TSB1, 
                        SUM(CASE WHEN TYPE = 'SMART BUILDING' AND TO_NUMBER(ACH) <= 95 then 1 else 0 end) TSB2, 
                        SUM(CASE WHEN TYPE = 'CONNECTIVITY' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TCONN1,
                        SUM(CASE WHEN TYPE = 'CONNECTIVITY' AND TO_NUMBER(ACH) <= 95 then 1 else 0 end) TCONN2,
                        SUM(CASE WHEN DATE_UPDATED <= Last_Day(ADD_MONTHS(trunc(sysdate),-2)) then 1 else 0 end) D,
                        SUM(CASE WHEN TYPE = '' THEN 0 ELSE 1 END) TOTAL,
                        CASE 
                                    WHEN BAND ='III' THEN 1
                                    WHEN BAND ='IV' THEN 2
                                    WHEN BAND ='SE PM EXT' THEN 3   
                                    WHEN BAND ='PM EXT' THEN 4  
                                    WHEN BAND ='J PM EXT' THEN 4   
                                    WHEN BAND ='SEPMO' THEN 10   
                                    ELSE 1 END BP
                        FROM 
                        (
                        SELECT DISTINCT A.PM_NIK PM_NIK, A.TYPE TYPE, A.ID_PROJECT ID_PROJECT, A.SEGMEN, A.NAME, A.PM_NAME, TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED,HIS.DATE_CREATED DATE_UPDATED, HIS.NAME_USER UPDATED_BY, A.UPDATED_BY_ID, TO_NUMBER(C.PLAN) PLAN, TO_NUMBER(C.REAL) ACH, A.STATUS, US.BAND BAND
                        FROM 
                            PRIME_PROJECT A JOIN (SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS FROM PRIME_PROJECT_PARTNERS A GROUP BY ID_PROJECT ) B ON B.ID_PROJECT = A.ID_PROJECT 
                        JOIN ( SELECT B.ID_PROJECT ID_PROJECT, PLAN, REAL FROM ( SELECT ID_PROJECT, SUM(REALIZATION) REAL FROM PRIME_PROJECT_S_CURVE_REAL_01 A WHERE WEEK <= CEIL ((SYSDATE - ( SELECT START_WEEK_1 FROM PRIME_PROJECT B WHERE A.ID_PROJECT = B.ID_PROJECT ) + 1) / 7) GROUP BY ID_PROJECT ) A, 
                             ( SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN FROM PRIME_PROJECT_S_CURVE_PLAN_01 A WHERE WEEK <= CEIL ((SYSDATE - ( SELECT START_WEEK_1 FROM PRIME_PROJECT B WHERE A.ID_PROJECT = B.ID_PROJECT ) + 1) / 7) GROUP BY ID_PROJECT ) B WHERE 1=1 AND A.ID_PROJECT=B.ID_PROJECT ) 
                            C ON C.ID_PROJECT = A.ID_PROJECT     
                        JOIN PRIME_USERS US ON A.PM_NIK = US.NIK    
                        LEFT JOIN ( SELECT H1.* FROM PRIME_HISTORY H1 JOIN ( SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY WHERE ID_USER != 'SYSTEM' GROUP BY ID ) H2 ON H1.DATE_CREATED = H2.LATEST AND H1.ID = H2.ID ) HIS ON HIS.ID = A.ID_PROJECT WHERE A.STATUS IN('LEAD', 'LAG', 'DELAY') AND A.EXIST = 1
                        ) P
                        GROUP BY PM_NAME, PM_NIK, BAND
                        ) M
                    ) G","G.PM_NIK=A.NIK","LEFT")
            ->where("(TIPE = 'PROJECT_MANAGER' OR TIPE = 'ADMIN_WEB')");

            $regional1 =    $this->session->userdata('regional');
                    if($regional1 != '0' && !empty($regional1)){
                        $q = $q->where('REGIONAL', $regional1);
                    }


            $q = $q->order_by('A.NAMA')
            ->get()->result_array();
            return $q;
    }   

    function getListProjectsPM($id){
        $array = array('LEAD','LAG','DELAY','CLOSED');
        $this->db->select("PRIME_PROJECT.*, TO_CHAR(START_DATE, 'MM/DD/YYYY') START_DATE2, TO_CHAR(END_DATE, 'MM/DD/YYYY') END_DATE2");
        $this->db->where('PM_NIK', $id);
        $this->db->where('EXIST', 1);
        $this->db->where_in('STATUS', $array);

        $data = $this->db->get('PRIME_PROJECT')->result_array();
        return $data;
    }   

    function getPlanAchievment($id){
        $this->db->select("TO_NUMBER(SUBSTR(PLAN,1,5)) PLAN, TO_NUMBER(SUBSTR(REAL,1,5)) REAL");
        $this->db->from('(
                                    SELECT ID_PROJECT, SUM(REALIZATION) REAL
                                    FROM PRIME_PROJECT_S_CURVE_REAL_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) A');
        $this->db->join('(
                                    SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN
                                    FROM PRIME_PROJECT_S_CURVE_PLAN_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) B','A.ID_PROJECT = B.ID_PROJECT');
        $this->db->where('A.ID_PROJECT',$id);
        return $this->db->get()->row_array();
    }

    function get_curva_s($id_project) {
            $query = $this->db->query(" SELECT WEEK WEEKS, NVL(PLAN,0) PLAN,REAL, PERIODE
                                        FROM PRIME_PROJECT_S_CURVE_WEEK
                                        WHERE ID_PROJECT = '$id_project'
                                        ORDER BY WEEK ASC");
            
            $arrData = array(
                    'WEEK' => array_column($query->result_array(), "WEEKS"),
                    'PLAN' => array_column($query->result_array(), "PLAN"),
                    'REAL' => array_column($query->result_array(), "REAL"),
                    'PERIOD' => array_column($query->result_array(), "PERIODE"),
                );
            return $arrData;
        }



##DATATABLES PLAN ACHIEVMENT   
    var $column_order_planAch = array('PM_NAME','NAME','PLAN','ACH',null); 

    var $column_search_planAch = array('A.ID_PROJECT','A.PM_NAME','A.NAME','A.UPDATED_BY_NAME','A.SEGMEN','C.PLAN','C.REAL');
    var $order_planAch = array('PM_NAME', 'desc');
    
    public function _get_all_query_planAch(){
        $arr = array('LEAD','LAG','DELAY');
        $nik = $this->session->userdata("nik_sess");
            $query = $this->db
                        ->select("A.ID_PROJECT ID_PROJECT, A.SEGMEN, A.NAME, A.PM_NAME , A.UPDATED_BY_ID ,SUBSTR(C.PLAN,1,6) ||'%' PLAN, SUBSTR(C.REAL,1,6) ||'%' ACH, A.STATUS, DEV_MERAH,DEV_KUNING, DEV_HIJAU,AP_MERAH, AP_KUNING, AP_HIJAU")
                        ->from('PRIME_PROJECT A')
                        ->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
                                  FROM PRIME_PROJECT_PARTNERS A
                                  GROUP BY ID_PROJECT
                                  ) B",
                                  "B.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT B.ID_PROJECT ID_PROJECT, PLAN, REAL
                                FROM
                                (
                                    SELECT ID_PROJECT, SUM(REALIZATION) REAL
                                    FROM PRIME_PROJECT_S_CURVE_REAL_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) A,
                                (
                                    SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN
                                    FROM PRIME_PROJECT_S_CURVE_PLAN_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) B
                                WHERE 1=1
                                AND A.ID_PROJECT=B.ID_PROJECT
                            ) C","C.ID_PROJECT = A.ID_PROJECT")
                        ->join("PRIME_MONITORING_PROJECT D","D.ID_PROJECT = A.ID_PROJECT","LEFT")
                        ->where_in('A.STATUS', $arr);

            if($this->session->userdata("tipe_sess") == 'PROJECT_MANAGER'){
                $query->where('PM_NIK',$nik);
            }
            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }
            $query->where(1,1)->distinct();
            return $query;
    }

    private function _get_datatables_query_planAch($searchValue, $orderColumn, $orderDir, $getOrder){

        $this->_get_all_query_planAch();

        $i = 0;

        foreach ($this->column_search_planAch as $item) // loop column
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

                if (count($this->column_search_planAch) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&$orderColumn!=null) // here order processing
        {   
            $this->db->order_by($this->column_order_planAch[$orderColumn], $orderDir);
        }
        else if(isset($this->order_planAch))
        {   
            
            $order = $this->order_planAch;
            $this->db->order_by($order[0], $orderDir);
        }


    }

    function get_datatables_planAch($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_planAch($searchValue, $orderColumn, $orderDir, $getOrder);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_planAch($searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_planAch($searchValue, $orderColumn, $orderDir, $getOrder);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_planAch(){
        $this->_get_all_query_planAch();
        return $this->db->count_all_results();
    }
#END DATATABLES PLAN ACHIEVMENT 


##DATATABLES SUBSIDIARY 
    var $column_order_subsidiary = array('A.PARTNER_NAME','B.ID_PROJECT','B.STANDARD_NAME','B.STATUS','C.PLAN','C.REAL','B.END_DATE'); 

    var $column_search_subsidiary = array('A.PARTNER_NAME');
    var $order_subsidiary = array('B.ID_PROJECT', 'desc');
    
    public function _get_all_query_subsidiary(){
        $arr = array('LEAD','LAG','DELAY','CLOSED');
        $nik = $this->session->userdata("nik_sess");

            $query = $this->db
                        ->select("A.PARTNER_NAME, B.*, C.PLAN, C.REAL, TO_CHAR(B.END_DATE , 'DD/MM/YYYY') END_DATE2")
                        ->from('PRIME_PROJECT_PARTNERS A')
                        ->join('PRIME_PROJECT B','A.ID_PROJECT = B.ID_PROJECT')
                        ->join("(
                                SELECT B.ID_PROJECT ID_PROJECT, PLAN, REAL
                                FROM
                                (
                                    SELECT ID_PROJECT, SUM(REALIZATION) REAL
                                    FROM PRIME_PROJECT_S_CURVE_REAL_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) A,
                                (
                                    SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN
                                    FROM PRIME_PROJECT_S_CURVE_PLAN_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) B
                                WHERE 1=1
                                AND A.ID_PROJECT=B.ID_PROJECT
                            ) C","C.ID_PROJECT = A.ID_PROJECT")
                        ->join("PRIME_MONITORING_PROJECT D","D.ID_PROJECT = A.ID_PROJECT")
                        ->where("A.PARTNER_NAME IS NOT NULL")
                        ->where_in('B.STATUS', $arr);

            if($this->session->userdata("tipe_sess") == 'PROJECT_MANAGER'){
                $query->where('PM_NIK',$nik);
            }
            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }
            $query->where(1,1)->distinct();
            return $query;
    }

    private function _get_datatables_query_subsidiary($searchValue, $orderColumn, $orderDir, $getOrder){

        $this->_get_all_query_subsidiary();

        $i = 0;

        foreach ($this->column_search_subsidiary as $item) // loop column
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

                if (count($this->column_search_subsidiary) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&$orderColumn!=null) // here order processing
        {   
            $this->db->order_by($this->column_order_subsidiary[$orderColumn], $orderDir);
        }
        else if(isset($this->order_subsidiary))
        {   
            
            $order = $this->order_subsidiary;
            $this->db->order_by($order[0], $orderDir);
        }


    }

    function get_datatables_subsidiary($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_subsidiary($searchValue, $orderColumn, $orderDir, $getOrder);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_subsidiary($searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_subsidiary($searchValue, $orderColumn, $orderDir, $getOrder);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_subsidiary(){
        $this->_get_all_query_subsidiary();
        return $this->db->count_all_results();
    }
#END DATATABLES SUBSIDIARY

##DATATABLES BAST
    var $column_order_bast = array('A.NAME','A.VALUE','C.NO_BAST','C.NILAI_RP_BAST','C.TGL_BAST','C.TYPE_BAST','C.PROGRESS_LAPANGAN','A.STATUS'); 

    var $column_search_bast = array('A.NAME','A.VALUE','C.NO_BAST','C.NILAI_RP_BAST','C.TGL_BAST','C.TYPE_BAST','A.STATUS');
    var $order_bast = array('A.ID_PROJECT', 'desc');
    
    public function _get_all_query_bast($status){
        $arr = array('APPROVED','TAKE OUT','DONE');
        $query = $this->db
                        ->select("A.ID_PROJECT, A.NAME, A.VALUE,C.NO_BAST,C.NILAI_RP_BAST VALUE2, C.TGL_BAST BAST_DATE, A.STATUS, C.TYPE_BAST, D.PLAN, D.ACH, C.NAMA_TERMIN, C.PROGRESS_LAPANGAN, C.RECC_START_DATE, C.RECC_END_DATE, C.ID_BAST")
                        ->from('PRIME_PROJECT A')
                        ->join("PRIME_PROJECT_PARTNERS B","B.ID_PROJECT = A.ID_PROJECT")
                        ->join("PRIME_BAST_HGN C","C.NO_SPK = B.NO_P8")
                        ->join("PRIME_MONITORING_PROJECT D","D.ID_PROJECT = A.ID_PROJECT","LEFT")
                        ->where("C.EXIST","1")
                        ->where_in("C.STATUS",$arr);

            if(!empty($status)){
                $query = $query->where('A.STATUS',$status);
            }            

            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }

            return $query->distinct(); 
    }

    private function _get_datatables_query_bast($searchValue, $orderColumn, $orderDir, $getOrder,$status){

        $this->_get_all_query_bast($status);

        $i = 0;

        foreach ($this->column_search_bast as $item) // loop column
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

                if (count($this->column_search_bast) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&$orderColumn!=null) // here order processing
        {   
            $this->db->order_by($this->column_order_bast[$orderColumn], $orderDir);
            //echo $this->column_order_bast[$orderColumn];
        }
        else if(isset($this->column_order_bast ))
        {   
            
            $order = $this->column_order_bast ;
            $this->db->order_by($order[0], $orderDir);
        }


    }

    function get_datatables_bast($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$status){
        $this->_get_datatables_query_bast($searchValue, $orderColumn, $orderDir, $getOrder,$status);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            //= echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_bast($searchValue, $orderColumn, $orderDir, $getOrder,$status){
        $this->_get_datatables_query_bast($searchValue, $orderColumn, $orderDir, $getOrder,$status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bast($status){
        $this->_get_all_query_bast($status);
        return $this->db->count_all_results();
    }
#END DATATABLES BAST

##DATATABLES ISSUE ACTION PLAN
    var $column_order_issueAp = array('NAME','ISSUE_NAME','ACTION_NAME','PLAN','ACH','HIS.DATE_CREATED ','A.UPDATED_BY_NAME',null); 

    var $column_search_issueAp = array('A.ID_PROJECT','A.PM_NAME','A.NAME','A.UPDATED_BY_NAME','A.SEGMEN','C.PLAN','C.ACH');
    var $order_issueAp = array('PM_NAME', 'desc');
    
    public function _get_all_query_issueAp(){
        $query = $this->db
                        ->select("ISSUE.ISSUE_NAME, A.ID_PROJECT ID_PROJECT, A.SEGMEN, A.NAME, A.PM_NAME , TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED, HIS.NAME_USER UPDATED_BY, HIS.DATE_CREATED LASTEST_DATE, A.UPDATED_BY_ID ,SUBSTR(NVL(C.PLAN,0),1,6) ||'%' PLAN, SUBSTR(NVL(C.ACH,0),1,6) ||'%' ACH, A.STATUS, HIS.ID_HISTORY, ACTION_NAME, ACTION_STATUS, ACTION_DUE_DATE")
                        ->from('PRIME_PROJECT A')
                        ->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
                                  FROM PRIME_PROJECT_PARTNERS A
                                  GROUP BY ID_PROJECT
                                  ) B",
                                  "B.ID_PROJECT = A.ID_PROJECT")
                        ->join("PRIME_MONITORING_PROJECT C","C.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT H1.* FROM PRIME_HISTORY H1 
                                JOIN (
                                            SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY 
                                            WHERE ID_USER != 'SYSTEM'
                                            GROUP BY ID 
                                           ) H2 
                                ON H1.DATE_CREATED = H2.LATEST AND H1.ID = H2.ID
                                ) HIS","HIS.ID = A.ID_PROJECT","LEFT")
                        ->join("(
                                SELECT ID_ISSUE,ID_PROJECT,ISSUE_NAME,RISK_IMPACT,STATUS_ISSUE,
                                MITIGATION_PLAN,IMPACT,TO_CHAR(ISSUE_CLOSED_DATE,'DD/MM/YYYY')ISSUE_CLOSED_DATE                                               
                                    FROM PRIME_PROJECT_ISSUE WHERE STATUS_ISSUE = 'OPEN'
                                ) ISSUE","ISSUE.ID_PROJECT = A.ID_PROJECT","LEFT")
                        ->join ("(
                                SELECT ID_PROJECT, ACTION_NAME, ID_ISSUE, ACTION_STATUS, DUE_DATE ACTION_DUE_DATE
                                FROM PRIME_PROJECT_ACTION_PLAN
                                ) PLAN","PLAN.ID_PROJECT = A.ID_PROJECT AND PLAN.ID_ISSUE = ISSUE.ID_ISSUE")
                        ->where_in('A.STATUS', array('LEAD','LAG','DELAY'))
                        ->where(1,1);

            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }

            return $query; 
    }

    private function _get_datatables_query_issueAp($searchValue, $orderColumn, $orderDir, $getOrder){

        $this->_get_all_query_issueAp();

        $i = 0;

        foreach ($this->column_search_issueAp as $item) // loop column
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

                if (count($this->column_search_issueAp) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&$orderColumn!=null) // here order processing
        {   
            $this->db->order_by($this->column_order_issueAp[$orderColumn], $orderDir);
            //echo $this->column_order_issueAp[$orderColumn];
        }
        else if(isset($this->column_order_issueAp ))
        {   
            
            $order = $this->column_order_issueAp ;
            $this->db->order_by($order[0], $orderDir);
        }


    }

    function get_datatables_issueAp($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_issueAp($searchValue, $orderColumn, $orderDir, $getOrder);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            //= echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_issueAp($searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_issueAp($searchValue, $orderColumn, $orderDir, $getOrder);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_issueAp(){
        $this->_get_all_query_issueAp();
        return $this->db->count_all_results();
    }
#END DATATABLES ISSUE ACTION PLAN

    /*DOWNLOAD*/
    function download_list_monitoring_planAch(){
        $arr = array('LEAD','LAG','DELAY');
        $query = $this->db
                        ->select("A.ID_PROJECT ID_PROJECT, A.ID_LOP_EPIC ID_LOP, A.SEGMEN, A.NAME, A.PM_NAME , TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED, HIS.NAME_USER UPDATED_BY, A.SEGMEN, A.UPDATED_BY_ID ,SUBSTR(C.PLAN,1,6) ||'%' PLAN, SUBSTR(C.REAL,1,6) ||'%' ACH, A.STATUS, A.STANDARD_NAME, A.VALUE, B.PARTNERS")
                        ->from('PRIME_PROJECT A')
                        ->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
                                  FROM PRIME_PROJECT_PARTNERS A
                                  GROUP BY ID_PROJECT
                                  ) B",
                                  "B.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT B.ID_PROJECT ID_PROJECT, PLAN, REAL
                                FROM
                                (
                                    SELECT ID_PROJECT, SUM(REALIZATION) REAL
                                    FROM PRIME_PROJECT_S_CURVE_REAL_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) A,
                                (
                                    SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN
                                    FROM PRIME_PROJECT_S_CURVE_PLAN_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) B
                                WHERE 1=1
                                AND A.ID_PROJECT=B.ID_PROJECT
                            ) C","C.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT H1.* FROM PRIME_HISTORY H1 
                                JOIN (
                                            SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY 
                                            WHERE ID_USER != 'SYSTEM'
                                            GROUP BY ID 
                                           ) H2 
                                ON H1.DATE_CREATED = H2.LATEST AND H1.ID = H2.ID
                                ) HIS","HIS.ID = A.ID_PROJECT","LEFT")
                        ->where_in('A.STATUS', $arr);

        $result = $query->get()->result_array(); 
        //echo json_encode($result);die;      
        return $result;
    }

    function download_list_monitoring_issueAp(){
        $query = $this->db
                        ->select("ISSUE.ISSUE_NAME, A.ID_PROJECT ID_PROJECT, A.SEGMEN, A.NAME, A.PM_NAME , TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED, HIS.NAME_USER UPDATED_BY, HIS.DATE_CREATED LASTEST_DATE, A.UPDATED_BY_ID ,SUBSTR(C.PLAN,1,6) ||'%' PLAN, SUBSTR(C.REAL,1,6) ||'%' ACH, A.STATUS, HIS.ID_HISTORY, ACTION_NAME, ACTION_STATUS, ACTION_DUE_DATE, A.ID_LOP_EPIC ID_LOP, A.STANDARD_NAME,PARTNER.PARTNERS, VALUE")
                        ->from('PRIME_PROJECT A')
                        ->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
                                  FROM PRIME_PROJECT_PARTNERS A
                                  GROUP BY ID_PROJECT
                                  ) B",
                                  "B.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT B.ID_PROJECT ID_PROJECT, PLAN, REAL
                                FROM
                                (
                                    SELECT ID_PROJECT, SUM(REALIZATION) REAL
                                    FROM PRIME_PROJECT_S_CURVE_REAL_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) A,
                                (
                                    SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN
                                    FROM PRIME_PROJECT_S_CURVE_PLAN_01 A
                                    WHERE WEEK <= CEIL ((SYSDATE -
                                    (
                                        SELECT START_WEEK_1
                                        FROM PRIME_PROJECT B
                                        WHERE A.ID_PROJECT = B.ID_PROJECT
                                    ) + 1) / 7)
                                    GROUP BY ID_PROJECT
                                ) B
                                WHERE 1=1
                                AND A.ID_PROJECT=B.ID_PROJECT
                            ) C","C.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT H1.* FROM PRIME_HISTORY H1 
                                JOIN (
                                            SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY 
                                            WHERE ID_USER != 'SYSTEM'
                                            GROUP BY ID 
                                           ) H2 
                                ON H1.DATE_CREATED = H2.LATEST AND H1.ID = H2.ID
                                ) HIS","HIS.ID = A.ID_PROJECT","LEFT")
                        ->join("(
                                SELECT ID_ISSUE,ID_PROJECT,ISSUE_NAME,RISK_IMPACT,STATUS_ISSUE,
                                MITIGATION_PLAN,IMPACT,TO_CHAR(ISSUE_CLOSED_DATE,'DD/MM/YYYY')ISSUE_CLOSED_DATE                                               
                                    FROM PRIME_PROJECT_ISSUE WHERE STATUS_ISSUE = 'OPEN'
                                ) ISSUE","ISSUE.ID_PROJECT = A.ID_PROJECT","LEFT")
                        ->join ("(
                                SELECT ID_PROJECT, ACTION_NAME, ID_ISSUE, ACTION_STATUS, DUE_DATE ACTION_DUE_DATE
                                FROM PRIME_PROJECT_ACTION_PLAN
                                ) PLAN","PLAN.ID_PROJECT = A.ID_PROJECT AND PLAN.ID_ISSUE = ISSUE.ID_ISSUE","LEFT")
                        ->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
                                  FROM PRIME_PROJECT_PARTNERS A
                                  GROUP BY ID_PROJECT
                                  ) PARTNER",
                                  "PARTNER.ID_PROJECT = A.ID_PROJECT")
                        ->where_in('A.STATUS', array('LEAD','LAG','DELAY'))
                        ->where(1,1)
                        ->order_by("A.ID_PROJECT");

            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }

            return $query->get()->result_array();
    }

    function download_list_monitoring_bast(){
        $arr = array('APPROVED','TAKE OUT','DONE');
        $query = $this->db
                        ->select("A.ID_PROJECT, A.NAME, A.VALUE,C.NO_BAST,C.NILAI_RP_BAST VALUE2, C.TGL_BAST BAST_DATE, A.STATUS, C.TYPE_BAST, D.PLAN, D.ACH, C.NAMA_TERMIN, C.PROGRESS_LAPANGAN, C.RECC_START_DATE, C.RECC_END_DATE")
                        ->from('PRIME_PROJECT A')
                        ->join("PRIME_PROJECT_PARTNERS B","B.ID_PROJECT = A.ID_PROJECT")
                        ->join("PRIME_BAST_HGN C","C.NO_SPK = B.NO_P8")
                        ->join("PRIME_MONITORING_PROJECT D","D.ID_PROJECT = A.ID_PROJECT")
                        ->where("C.EXIST","1")
                        ->where_in("C.STATUS",$arr);          

            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }

            return $query->distinct()->get()->result_array(); 
    }



    function download_list_pm_activity($start_date=null){
       if(empty($start_date)){
            $query = $this->db
                    ->select("A.PM_NIK, A.PM_NAME, TO_CHAR(H.DATE_CREATED,'DD/MM/YYYY') DATE_UPDATED, H.STATUS, A.NAME")
                    ->from('PRIME_PROJECT A ')
                    ->join("PRIME_HISTORY H","H.ID = A.ID_PROJECT","left")
                    ->where_in("A.STATUS",array('LEAD','LAG','DELAY'))
                    ->where('A.EXIST',1);
                }else{
                    $query = $this->db
                    ->select("A.PM_NIK, A.PM_NAME,TO_CHAR(H.DATE_CREATED,'DD/MM/YYYY') DATE_UPDATED, H.STATUS, A.NAME")
                    ->from('PRIME_PROJECT A ')
                    ->join("PRIME_HISTORY H","H.ID = A.ID_PROJECT","left")
                    ->where_in("A.STATUS",array('LEAD','LAG','DELAY'))
                    ->where('A.EXIST',1);
                }


        if(!empty($pm)){
            $query = $query->where('A.PM_NIK',$pm);
        }
 

        return $query->distinct()->get()->result_array(); 
    }

    function download_monitoring_pm(){
        $q = $this->db
            ->select("A.*, TO_CHAR(LATEST, 'DD-MON-YYYY HH24:MI:SS') LATEST,C.*,D.*,E.*,F.*,G.*")
            ->from('PRIME_USERS A') 
            ->join('(SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY GROUP BY ID) B','B.ID = A.NIK','LEFT')
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT FROM PRIME_PROJECT WHERE STATUS IN ('LEAD','LAG','DELAY') AND EXIST = '1' GROUP BY PM_NIK) C",'C.PM_NIK = A.NIK')
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT1 FROM PRIME_PROJECT WHERE STATUS = 'LEAD' AND EXIST = '1' GROUP BY PM_NIK) D",'D.PM_NIK = A.NIK',"LEFT")
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT2 FROM PRIME_PROJECT WHERE STATUS = 'LAG' AND EXIST = '1' GROUP BY PM_NIK) E",'E.PM_NIK = A.NIK',"LEFT")
            ->join("(SELECT PM_NIK, lpad(COUNT(PM_NIK), 2, '0') TPROJECT3 FROM PRIME_PROJECT WHERE STATUS = 'DELAY' AND EXIST = '1' GROUP BY PM_NIK) F",'F.PM_NIK = A.NIK',"LEFT")
            ->join("(
                    SELECT M.*, 
                        ( ((TAPP1*0.5)+(TAPP2*1) + (TCONN1*0.5)+(TCONN2*1) + (TCPE1*0.5)+(TCPE2*1) + (TSB1*0.75)+(TSB2*1) + (BP*TOTAL) )  - (D*0.9) ) LOAD
                    FROM
                        (
                        SELECT
                        PM_NIK, PM_NAME, BAND,
                        SUM(CASE WHEN TYPE = 'APPLICATION' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TAPP1, 
                        SUM(CASE WHEN TYPE = 'APPLICATION' AND TO_NUMBER(ACH) <= 95 then 1 else 0  end) TAPP2, 
                        SUM(CASE WHEN TYPE = 'CPE & OTHERS' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TCPE1, 
                        SUM(CASE WHEN TYPE = 'CPE & OTHERS' AND TO_NUMBER(ACH) <= 95 then 1 else 0 end) TCPE2, 
                        SUM(CASE WHEN TYPE = 'SMART BUILDING' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TSB1, 
                        SUM(CASE WHEN TYPE = 'SMART BUILDING' AND TO_NUMBER(ACH) <= 95 then 1 else 0 end) TSB2, 
                        SUM(CASE WHEN TYPE = 'CONNECTIVITY' AND TO_NUMBER(ACH) > 95 then 1 else 0 end) TCONN1,
                        SUM(CASE WHEN TYPE = 'CONNECTIVITY' AND TO_NUMBER(ACH) <= 95 then 1 else 0 end) TCONN2,
                        SUM(CASE WHEN DATE_UPDATED <= Last_Day(ADD_MONTHS(trunc(sysdate),-2)) then 1 else 0 end) D,
                        SUM(CASE WHEN TYPE = '' THEN 0 ELSE 1 END) TOTAL,
                        CASE 
                                    WHEN BAND ='III' THEN 1
                                    WHEN BAND ='IV' THEN 2
                                    WHEN BAND ='SE PM EXT' THEN 3   
                                    WHEN BAND ='PM EXT' THEN 4  
                                    WHEN BAND ='J PM EXT' THEN 4   
                                    WHEN BAND ='SEPMO' THEN 10   
                                    ELSE 1 END BP
                        FROM 
                        (
                        SELECT DISTINCT A.PM_NIK PM_NIK, A.TYPE TYPE, A.ID_PROJECT ID_PROJECT, A.SEGMEN, A.NAME, A.PM_NAME, TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED,HIS.DATE_CREATED DATE_UPDATED, HIS.NAME_USER UPDATED_BY, A.UPDATED_BY_ID, TO_NUMBER(NVL(C.PLAN,0)) PLAN, TO_NUMBER(NVL(C.REAL,0)) ACH, A.STATUS, US.BAND BAND
                        FROM 
                            PRIME_PROJECT A JOIN (SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS FROM PRIME_PROJECT_PARTNERS A GROUP BY ID_PROJECT ) B ON B.ID_PROJECT = A.ID_PROJECT 
                        LEFT JOIN ( SELECT B.ID_PROJECT ID_PROJECT, PLAN, REAL FROM ( SELECT ID_PROJECT, SUM(REALIZATION) REAL FROM PRIME_PROJECT_S_CURVE_REAL_01 A WHERE WEEK <= CEIL ((SYSDATE - ( SELECT START_WEEK_1 FROM PRIME_PROJECT B WHERE A.ID_PROJECT = B.ID_PROJECT ) + 1) / 7) GROUP BY ID_PROJECT ) A, 
                             ( SELECT ID_PROJECT, SUM(WEIGHT_IN_WEEK) PLAN FROM PRIME_PROJECT_S_CURVE_PLAN_01 A WHERE WEEK <= CEIL ((SYSDATE - ( SELECT START_WEEK_1 FROM PRIME_PROJECT B WHERE A.ID_PROJECT = B.ID_PROJECT ) + 1) / 7) GROUP BY ID_PROJECT ) B WHERE 1=1 AND A.ID_PROJECT=B.ID_PROJECT ) 
                            C ON C.ID_PROJECT = A.ID_PROJECT     
                        JOIN PRIME_USERS US ON A.PM_NIK = US.NIK    
                        LEFT JOIN ( SELECT H1.* FROM PRIME_HISTORY H1 JOIN ( SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY WHERE ID_USER != 'SYSTEM' GROUP BY ID ) H2 ON H1.DATE_CREATED = H2.LATEST AND H1.ID = H2.ID ) HIS ON HIS.ID = A.ID_PROJECT WHERE A.STATUS IN('LEAD', 'LAG', 'DELAY') AND A.EXIST = 1
                        ) P
                        GROUP BY PM_NAME, PM_NIK, BAND
                        ) M
                    ) G","G.PM_NIK=A.NIK","LEFT")
            ->where('TIPE','PROJECT_MANAGER')
            ->or_where('TIPE','ADMIN_WEB')
            ->order_by('A.NAMA')
            ->get();

            return $q->result_array();
    }


    function download_list_monitoring_acq(){ 
        $month          = date('n');
        $month_lm       = $month - 1;
        if($month_lm==0){
            $month_lm       = 12;
        }
        $data = $this->db->select("A.*, B.NAME, B.TYPE, B.PM_NAME, B.AM_NAME, B.SEGMEN")
                         ->from("PRIME_PROJECT_TARGET A ")
                         ->join("PRIME_PROJECT B","A.ID_PROJECT = B.ID_PROJECT","LEFT")
                         ->Where("MONTH",$month)
                         ->or_where("MONTH",$month_lm)
                         ->get()
                         ->result_array();

        return $data;
    }



    ##DATATABLE LIST_Lop
        var $column_orderLop = array('A.ID_PROJECT','A.NAME','A.SEGMEN','A.VALUE','ACH','A.END_DATE','UPDATED_DATE',null); //set column field database for datatable orderable
        var $column_searchLop = array('A.ID_PROJECT','UPPER(A.PROJECT)','UPPER(A.NAMA_AM)','A.NIK_AM','A.NOMOR_QUOTE','A.NOMOR_SO'); //set column field database for datatable searchable
        var $orderLop = array('A.ID_PROJECT', 'desc'); // default order
        
        public function _get_all_queryLop($status,$pm,$customer,$partner,$type,$regional,$segmen){
            //$regional =   $this->session->userdata('regional');
            $arr = array('LAG','LEAD','DELAY','CANCEL');
            $query = $this->db
                            /*->select('A.ID_PROJECT')*/
                            ->select("*")
                            ->from("(SELECT * FROM AMDES.V_APPS_LOP_PROJECT_SDV) A");

                    $regional1 =    $this->session->userdata('regional');
                    if($regional1 != '0' && !empty($regional1)){
                        $query = $query->where('A.REGIONAL', $regional1);
                    }
                    if($customer != null){
                        $query = $query->where('A.NIPNAS',$customer);
                    }
                    if($regional != null){
                        $query = $query->where('A.REGIONAL',$regional);
                    }
                    if($segmen != null){
                        $query = $query->where('A.SEGMENT',$segmen);
                    }

                    return $query;

        }

        private function _get_datatables_queryLop($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){

            $this->_get_all_queryLop($status,$pm,$customer,$partner,$type,$regional,$segmen);

            $i = 0;

            foreach ($this->column_searchLop as $item) // loop column
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

                    if (count($this->column_searchLop) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($getOrder)&&$orderColumn!=null) // here order processing
            {   
                $this->db->order_by($this->column_orderLop[$orderColumn], $orderDir);
            }
            else if(isset($this->orderLop))
            {   
                $order = $this->orderLop;
                $this->db->order_by($order[0], $orderDir);
            }
        }

        function get_datatablesLop($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder, $status,$pm,$customer,$partner,$type,$regional,$segmen){
            $this->_get_datatables_queryLop($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
            if ($length != -1)
                $this->db->limit($length, $start);
                $query = $this->db->get();
            
            return $query->result();
        }

        function count_filteredLop($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){
            $this->_get_datatables_queryLop($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_allLop($status,$pm,$customer,$partner,$type,$regional,$segmen){
            $this->_get_all_queryLop($status,$pm,$customer,$partner,$type,$regional,$segmen);
            return $this->db->count_all_results();
        }
    #END LIST Lop



            #DATATABLES Acq
    var $column_order_dataAcq     = array("TO_NUMBER(MONTH)","C.NAME","SEGMEN","B.PM_NAME","C.VALUE","C.END_DATE",'TERMIN','TO_NUMBER(A.ACQ)',"TO_NUMBER(A.C_ACQ)",'A.ID_PROJECT',null);
    var $column_search_dataAcq    = array('MONTH','B.PM_NAME','B.NAME','A.ID_PROJECT');
    var $order_dataAcq            = array('DATE_UPDATED' => 'desc');
    
    public function _get_all_query_dataAcq($month){
            $c_month = date('n');
            $query = $this->db
            ->select("TO_CHAR(C.END_DATE,'DD/MM/YYYY') END_DATE2,C.VALUE PROJECT_VALUE, A.*,B.NAME, NVL(A.ACQ,0) ACQ2, NVL(A.C_ACQ,0) C_ACQ2, NVL(A.COMULATIVE,0) COMULATIVE2, B.PM_NIK, B.PM_NAME, NVL(B.PLAN,0) PLAN2, NVL(B.ACH,0) ACH2, B.SEGMEN, NVL(A.PROGRESS,0) PROGRESS2, C.VALUE VALUE2, (CASE WHEN MONTH = ".$c_month." THEN 'bg-info-es' ELSE '' END) AS ".'"CURRENT"')
            ->from("PRIME_PROJECT_TARGET A") 
            ->join("PRIME_MONITORING_PROJECT B", "A.ID_PROJECT = B.ID_PROJECT")
            ->join("PRIME_PROJECT C", "A.ID_PROJECT = C.ID_PROJECT");

            if(!empty($month)){
             $query = $query->where('MONTH',$month);
            }

           /* $regional1 =    $this->session->userdata('regional');
            if($regional1 != '0' && !empty($regional1)){
                $query = $query->where('A.REGIONAL', $regional1);
            }*/

            return $query;
    }

    private function _get_datatables_query_dataAcq($searchValue, $orderColumn, $orderDir, $getOrder,$month){

        $this->_get_all_query_dataAcq($month);

        $i = 0;

        foreach ($this->column_search_dataAcq as $item) // loop column
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

                if (count($this->column_search_dataAcq) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_dataAcq[$orderColumn], $orderDir);
        }
        else if(isset($this->order_dataAcq))
        {
            $order = $this->order_dataAcq;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_dataAcq($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$month){
        $this->_get_datatables_query_dataAcq($searchValue, $orderColumn, $orderDir, $getOrder,$month);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
             //echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_dataAcq($searchValue, $orderColumn, $orderDir, $getOrder,$month){
        $this->_get_datatables_query_dataAcq($searchValue, $orderColumn, $orderDir, $getOrder,$month);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dataAcq($month){
        $this->_get_all_query_dataAcq($month);
        return $this->db->count_all_results();
    }
#END DATATABLES Acq


        #DATATABLE LIST__pmactivity
        var $column_order_pmactivity = array("PM_NAME","TOTAL","UPDATED","NOT_UPDATED",null);
        var $column_search_pmactivity = array("PM_NAME");
        var $order_pmactivity = array('A.PM_NAME' => 'asc'); // default order
        
        public function _get_all_query_pmactivity($pm,$start_date= null){ 
                if(empty($start_date)){
                    $query = $this->db
                            ->select("A.PM_NIK, PM_NAME, COUNT(ID_PROJECT) TOTAL, COUNT(H.DATEHIS) UPDATED, COUNT(ID_PROJECT)- COUNT(H.DATEHIS) NOT_UPDATED")
                            ->from('PRIME_PROJECT A ')
                            ->join("(SELECT MAX(DATE_CREATED) DATEHIS, ID FROM PRIME_HISTORY WHERE DATE_CREATED >= (SYSDATE - 14) GROUP BY ID ) H","H.ID = A.ID_PROJECT","left")
                            ->where_in("A.STATUS",array('LEAD','LAG','DELAY'))
                            ->where('A.EXIST',1)
                            ->group_by("PM_NIK , PM_NAME");
                        }else{
                            $query = $this->db
                            ->select("A.PM_NIK, PM_NAME, COUNT(ID_PROJECT) TOTAL, COUNT(H.DATEHIS) UPDATED, COUNT(ID_PROJECT)- COUNT(H.DATEHIS) NOT_UPDATED")
                            ->from('PRIME_PROJECT A ')
                            ->join("(SELECT MAX(DATE_CREATED) DATEHIS, ID FROM PRIME_HISTORY WHERE DATE_CREATED >= TO_DATE('".$start_date."','MM/DD/YYYY') GROUP BY ID ) H","H.ID = A.ID_PROJECT","left")
                            ->where_in("A.STATUS",array('LEAD','LAG','DELAY'))
                            ->where('A.EXIST',1)
                            ->group_by("PM_NIK , PM_NAME");
                        }


                if(!empty($pm)){
                    $query = $query->where('A.PM_NIK',$pm);
                }
 
                return $query;
        }

        private function _get_datatables_query_pmactivity($searchValue, $orderColumn, $orderDir, $getOrder,$source,$start_date= null){

            $this->_get_all_query_pmactivity($source,$start_date);

            $i = 0;

            foreach ($this->column_search_pmactivity as $item) // loop column
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

                    if (count($this->column_search_pmactivity) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($getOrder) && isset($orderColumn)) // here order processing
            {         
                $this->db->order_by($this->column_order_pmactivity[$orderColumn], $orderDir);
            }
            else if(isset($this->order_pmactivity))
            {
                $order = $this->order_pmactivity;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        function get_datatables_pmactivity($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$source,$start_date= null){
            $this->_get_datatables_query_pmactivity($searchValue, $orderColumn, $orderDir, $getOrder,$source,$start_date);
            if ($length != -1)
                $this->db->limit($length, $start);
                $query = $this->db->get();
                //echo $this->db->last_query();exit;
            return $query->result();
        }

        function count_filtered_pmactivity($searchValue, $orderColumn, $orderDir, $getOrder,$source,$start_date= null){
            $this->_get_datatables_query_pmactivity($searchValue, $orderColumn, $orderDir, $getOrder,$source,$start_date);
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_pmactivity($source,$start_date= null){
            $this->_get_all_query_pmactivity($source,$start_date);
            return $this->db->count_all_results();
        } 
    #END LIST _pmactivity

##DATATABLES PROGRESS  
    var $column_order_progress = array('A.NAME','PM_NAME','T_DELIV','T_ISSUE_OPEN','L_PLAN','L_ACH','PLAN','ACH','LM_ACQ','M_ACQ','UPDATED_DATE'); 

    var $column_search_progress = array('NAME','PM_NAME','A.ID_PROJECT');
    var $order_progress = array('NAME', 'desc');
    
    public function _get_all_query_progress(){
        $arr = array('LEAD','LAG','DELAY');
        $nik = $this->session->userdata("nik_sess");
        $month          = date('n');
        $month_lm       = $month - 1;
        if($month_lm == 0 ){
            $month_lm  = 12;
        }


            $query = $this->db
                        ->select("A.*, M.ACQ M_ACQ, N.ACQ LM_ACQ")
                        ->from("(
                                SELECT DISTINCT A.*, (TO_NUMBER(NVL(D.T_ISSUE,0)) + TO_NUMBER(NVL(E.T_ISSUE,0))) TOTAL_ISSUE, NVL(T_DELIV,0) T_DELIV, NVL(D.T_ISSUE,0) T_ISSUE_OPEN, NVL(E.T_ISSUE,0) T_ISSUE_CLOSED, NVL(B.PLAN,0)L_PLAN, NVL(B.ACH,0) L_ACH, NVL(C.PLAN,0) PLAN, NVL(C.ACH,0) ACH,
                                    CASE A.STATUS WHEN 'LEAD' THEN 'success' WHEN 'LAG' THEN 'warning' ELSE 'danger' END INDICATOR
                                    FROM PRIME_PROJECT A 
                                    LEFT JOIN (SELECT * FROM PRIME_PROJECT_PROGRESS_HISTORY  WHERE TO_CHAR(DATE_UPDATED,'DDMMYYYY') = TO_CHAR(SYSDATE-7,'DDMMYYYY')) B ON A.ID_PROJECT = B.ID_PROJECT
                                    JOIN PRIME_MONITORING_PROJECT C ON A.ID_PROJECT = C.ID_PROJECT
                                    LEFT JOIN (SELECT COUNT(ID_ISSUE) T_ISSUE, ID_PROJECT FROM PRIME_PROJECT_ISSUE WHERE STATUS_ISSUE = 'OPEN' GROUP BY ID_PROJECT ) D ON A.ID_PROJECT = D.ID_PROJECT
                                    LEFT JOIN (SELECT COUNT(ID_ISSUE) T_ISSUE, ID_PROJECT FROM PRIME_PROJECT_ISSUE WHERE STATUS_ISSUE = 'CLOSED' GROUP BY ID_PROJECT ) E ON A.ID_PROJECT = E.ID_PROJECT
                                    LEFT JOIN (SELECT COUNT(ID_DELIVERABLE) T_DELIV, ID_PROJECT FROM PRIME_PROJECT_DELIVERABLES GROUP BY ID_PROJECT) F ON F.ID_PROJECT =A.ID_PROJECT 
                                    
                                ) A",FALSE)
                        ->join("PRIME_PROJECT_TARGET M","A.ID_PROJECT = M.ID_PROJECT AND M.MONTH = ".$month,"LEFT")
                        ->join("PRIME_PROJECT_TARGET N","A.ID_PROJECT = N.ID_PROJECT AND N.MONTH = ".$month_lm,"LEFT");

            if($this->session->userdata("tipe_sess") == 'PROJECT_MANAGER'){
                $query->where('PM_NIK',$nik);
            }
            if($this->session->userdata('regional')!=0){
                $query->where('A.REGIONAL',$this->session->userdata('regional'));
            }
            $query->where(1,1)->distinct();
            return $query;
    }

    private function _get_datatables_query_progress($searchValue, $orderColumn, $orderDir, $getOrder){

        $this->_get_all_query_progress();

        $i = 0;

        foreach ($this->column_search_progress as $item) // loop column
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

                if (count($this->column_search_progress) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&$orderColumn!=null) // here order processing
        {   
            $this->db->order_by($this->column_order_progress[$orderColumn], $orderDir);
        }
        else if(isset($this->order_progress))
        {   
            
            $order = $this->order_progress;
            $this->db->order_by($order[0], $orderDir);
        }


    }

    function get_datatables_progress($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_progress($searchValue, $orderColumn, $orderDir, $getOrder);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_progress($searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_progress($searchValue, $orderColumn, $orderDir, $getOrder);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_progress(){
        $this->_get_all_query_progress();
        return $this->db->count_all_results();
    }
#END DATATABLES PROGRESS 


}
