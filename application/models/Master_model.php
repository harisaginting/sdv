<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function __construct() {
        parent::__construct();       
    }


    function set_config_email($email){
        foreach ($email as $key => $value) {
            $this->db->set('VALUE',$value);
            $this->db->where('NAME',$key);
            $this->db->where('TYPE','EMAIL'); 
            $this->db->update('PRIME_CONFIG');
        }

        return true;
    } 

    function set_config_notification($n){
            $this->db->set('VALUE',$n['VALUE']);
            $this->db->set('NAME',$n['NAME']);
            $this->db->set('ACTIVE',$n['ACTIVE']);
            $this->db->where('TYPE','NOTIFICATION');
            $this->db->update('PRIME_CONFIG');
        return true; 
    }

    function getNotification(){
        $q = $this->db
            ->select("*")
            ->from("_CONFIG") 
            ->where("TYPE","NOTIFICATION");

        return  $q->get()->row_array(); 
    }

    function getEmailConfig(){
        $q = $this->db
            ->select("*")
            ->from("_CONFIG")
            ->where("TYPE","EMAIL");

        return  $q->get()->result_array();    
    }

    function get_list_pic($q) 
    {
        if (!empty($q)) {
            $q = "AND UPPER(NAMA) LIKE UPPER('%$q%') OR UPPER(EMAIL) LIKE UPPER('%$q%')";
        }

        $query = $this->db->query(" SELECT *
                                    FROM
                                    (
                                        SELECT NAMA, EMAIL
                                        FROM PRIME_USERS
                                        UNION
                                        SELECT NAME NAMA, EMAIL
                                        FROM PRIME_MASTER_PIC
                                    )
                                    WHERE 1=1
                                    $q")->result_array();
        return $query;
    }

    function get_list_pic_partner($q=null)
    {
        $q = $this->db
                    ->select('PIC_MITRA NAMA,EMAIL_MITRA EMAIL')
                    ->from('PRIME_BAST_HGN')
                    ->like('PIC_MITRA',strtoupper($q))
                    ->or_like('PIC_MITRA',$q)
                    ->or_like('EMAIL_MITRA',$q)
                    ->distinct()
                    ->get()->result();
            return $q;
    }

    function get_list_pic_email($q)
    {
        if (!empty($q)) {
            $q = "AND UPPER(NAMA) = UPPER('$q')";
        }

        $query = $this->db->query(" SELECT *
                                    FROM
                                    (
                                        SELECT NAMA, EMAIL
                                        FROM PRIME_USERS
                                        UNION
                                        SELECT NAME NAMA, EMAIL
                                        FROM PRIME_MASTER_PIC
                                    )
                                    WHERE 1=1
                                    $q")->row_array();
        return $query;
    }

    function get_list_spk_bast($q=null,$nipnas=null,$partner=null)
    {
    
        $this->db->select('NO_SPK, PROJECT_NAME');
        $this->db->from('PRIME_BAST_HGN');
        if (!empty($q)) {
            $this->db->like('NO_SPK',strtoupper($q));
        }
        $this->db->distinct();

        $query = $this->db->get()->result();
        /*$query = $this->db->query(" SELECT distinct NO_SPK, PROJECT_NAME
                                    FROM PRIME_BAST_HGN
                                    WHERE 1=1
                                    $q")->result();*/
                                    //echo $this->db->last_query();die;
        return $query;
    }


    function get_list_spk_bast2($q=null,$partner=null)
    {
    
        $this->db->select("NO_SPK, PROJECT_NAME, NIPNAS, NAMA_CC CC, SEGMEN, TO_CHAR(TANGGAL_BAST, 'MM/DD/YYYY') DATES, ID_LOP");
        $this->db->from('PRIME_SPK_NUMERO');
        $this->db->where('ID_MITRA',$partner);
        if (!empty($q)) {
            $this->db->like('NO_SPK',strtoupper($q));
        }
        $this->db->distinct();

        $query = $this->db->get()->result();
        return $query;
    }

    function get_list_p71_bast($q=null,$partner=null)
    {
    
        $this->db->select("NO_P71, PROJECT_NAME, NIPNAS, NAMA_CC CC, SEGMEN, TO_CHAR(TANGGAL_BAST, 'MM/DD/YYYY') DATES");
        $this->db->from('PRIME_P71_NUMERO');
        $this->db->where('ID_MITRA',$partner);
        if (!empty($q)) {
            $this->db->like('NO_P71',strtoupper($q));
        }
        $this->db->distinct();

        $query = $this->db->get()->result();
        return $query;
    }

    function get_list_customer($segmen=null,$q=null){
        /*$epic = $this->load->database('epicdb', TRUE);
        if (!empty($segmen)) {
            $segmen = "AND SEGMEN='$segmen'"; 
        }
        if(!empty($q)){
            $q = strtoupper($q);
            $q = "AND UPPER(STANDARD_NAME) LIKE '%$q%'"; 
        }*/
        
        //$data   = $epic->query($query);
        // return $data->result_array();
        $query  = "SELECT NIP_NAS, STANDARD_NAME FROM CBASE_DIVES WHERE 1=1 ".$segmen." ".$q." "."ORDER BY STANDARD_NAME ASC";
        $query  = $this->db->query("SELECT DISTINCT NIP_NAS, STANDARD_NAME FROM PRIME_PROJECT WHERE 1=1 AND SEGMEN ='".$segmen."' AND UPPER(STANDARD_NAME) LIKE '%".$q."%' ORDER BY STANDARD_NAME ASC")->result_array();
        return $query;
    }

    function get_list_am($q=null)
    {
        if (!empty($q)) {
            $q = "AND NIPNAS = $q";
        }

        $query = $this->db->query(" SELECT NIK, NAMA_AM NAME  FROM
                                    PRIME_AM_CC 
                                    WHERE 1=1
                                    $q
                                    union
                                    SELECT NIK, NAMA NAMA_AM FROM
                                    PRIME_USERS 
                                    WHERE (TIPE = 'SEGMEN' OR TIPE = 'AM')
                                    AND 1=1
                                    ")->result_array();
        return $query;
    }

    function add_am_cc($data){
        return $this->db->insert('PRIME_AM_CC',$data); 
    }

    function delete_am_cc($nik,$nipnas){
        $this->db->where('NIK', $nik);
        $this->db->where('NIPNAS', $nipnas);
        return $this->db->delete('PRIME_AM_CC');
    }


    function get_list_pm($q=null)
    {
        
        $query = $this->db
                    ->select('NIK,NAMA')
                    ->from('PRIME_USERS')
                    ->where("(TIPE = 'PROJECT_MANAGER' OR TIPE = 'ADMIN_WEB')");
         if(!empty($q)){
            $query = $query->like('NAMA',strtoupper($q));
         }  
        return $query->get()->result();
     
    }

    function get_list_project_lop($q = null){
        $query = $this->db
                    ->select("M.ID_LOP_EPIC ID_LOP, M.ID_LOP_EPIC||'['||A.NO_P8||']'||' - '||M.NAME PROJECT_NAME")
                    ->distinct()
                    ->from('PRIME_PROJECT M')
                    ->join('PRIME_PROJECT_PARTNERS A','A.ID_PROJECT = M.ID_PROJECT','LEFT')
                    ->join('PRIME_BAST_HGN B','B.NO_SPK = A.NO_P8','LEFT')
                    ->where("M.ID_LOP_EPIC IS NOT NULL")
                    //->where("M.NO_QUOTE IS NOT NULL")
                    ->where("M.EXIST = 1");
         if(!empty($q)){
            $query = $query->like('UPPER(M.NAME)',strtoupper($q));
            $query = $query->or_like('UPPER(M.ID_LOP_EPIC)',strtoupper($q));
            $query = $query->or_like('UPPER(M.ID_PROJECT)',strtoupper($q));
            $query = $query->or_like('UPPER(A.NO_p8)',strtoupper($q));
         }  
        return $query->get()->result();   
    }

    function get_list_project_so($q = null){
        $query = $this->db
                    ->select("M.NO_SPK NO_P8,  '['||M.NO_SPK||']'||' - '||M.PROJECT_NAME PROJECT_NAME")
                    ->distinct()
                    ->from('PRIME_BAST_HGN M')
                    ->where("M.EXIST = 1");
         if(!empty($q)){
            $query = $query->like('UPPER(M.PROJECT_NAME)',strtoupper($q));
            $query = $query->or_like('UPPER(M.NO_SPK)',strtoupper($q));
            $query = $query->get()->result(); 

            if(empty($query)){
                $query = $this->db
                    ->select("M.NO_SPK NO_P8,  '['||M.NO_SPK||']'||' - '||M.PROJECT_NAME PROJECT_NAME")
                    ->distinct()
                    ->from('PRIME_SPK_NUMERO M')
                    ->like('UPPER(M.PROJECT_NAME)',strtoupper($q))
                    ->or_like('UPPER(M.NO_SPK)',strtoupper($q))
                    ->get()->result(); 
            }

         }else{
            $query = $query->get()->result(); 
         }  
        return $query;  
    }


    function get_list_users($q=null)
    {
        $query = $this->db
                    ->select('NIK,NAMA')
                    ->distinct()
                    ->from('PRIME_USERS');

        if(!empty($q)){
           $query =  $query->like('UPPER(NAMA)',strtoupper($q));
        }
                    
                    
            return $query->get()->result();
    }


    function get_all_partner(){
         $data = $this->db->select('*')->from('PRIME_PARTNER_TATA')->get();
         return $data->result_array();
    }

    function get_partner($id){
         $data = $this->db
                ->select('*')
                ->from('PRIME_PARTNER_TATA')
                ->where("KODE_PARTNER",$id)
                ->get();
         return $data->row();
    }

    function add_partner($data){
        $this->db->set('KODE_PARTNER',$data->IDMitra);
        $this->db->set('NAMA_PARTNER',$data->NamaMitra);
        $this->db->set('STATUS_ANPER',$data->StatusAnper);
        return $this->db->insert('PRIME_PARTNER_TATA'); 
    }

    function update_partner($id,$nama){
        $this->db->set('NAMA_PARTNER',$nama);
        $this->db->where('KODE_PARTNER',$id);
        return $this->db->update('PRIME_PARTNER_TATA'); 
    }

    function save_spk_numero_lop($data,$date){
        $this->db->where('NO_SPK',$data->NoSPKSPWO);
        $this->db->set('ID_LOP',$data->IDLOP);
        return $this->db->update('PRIME_SPK_NUMERO'); 
    }

    function save_spk_numero($data,$date){
        $this->db->set('NO_SPK',$data->NoSPKSPWO);
        $this->db->set('ID_MITRA',$data->IDMitra);
        $this->db->set('NAMA_MITRA',$data->NamaMitra);
        $this->db->set('NIPNAS',$data->NIPNAS);
        $this->db->set('NAMA_CC',$data->NamaCC);
        $this->db->set('PROJECT_NAME',$data->Judul);
        $this->db->set('SEGMEN',$data->Segmen);
        $this->db->set('VALUE',$data->NilaiKontrak);
        $this->db->set("TANGGAL_BAST","TO_DATE('".$date."','YYYY-MM-DD')",FALSE);
        return $this->db->insert('PRIME_SPK_NUMERO'); 
    }

    function save_p71_numero($data,$date){
        $this->db->set('NO_P71',$data->NomorOBL);
        $this->db->set('ID_MITRA',$data->IDMitra);
        $this->db->set('NAMA_MITRA',$data->NamaMitra);
        $this->db->set('NAMA_CC',$data->NamaCC);
        $this->db->set('NIPNAS',$data->IDCC);
        $this->db->set('PROJECT_NAME',$data->JudulProyek);
        $this->db->set('SEGMEN',$data->IDSegmen);
        $this->db->set('VALUE',$data->NilaiKontrak);
        $this->db->set("TANGGAL_BAST","TO_DATE('".$date."','YYYY-MM-DD')",FALSE);
        return $this->db->insert('PRIME_P71_NUMERO'); 
    }

    function check_spk_numero_exist($spk){
        $query = $this->db
                ->select('NO_SPK')
                ->from("PRIME_SPK_NUMERO")
                ->where('NO_SPK',$spk)
                ->get()
                ->row();
        //echo json_encode($query);die;
        return $query;
    }

    function check_p71_numero_exist($spk){
        $query = $this->db
                ->select('NO_P71')
                ->from("PRIME_P71_NUMERO")
                ->where('NO_P71',$spk)
                ->get()
                ->row();
        //echo json_encode($query);die;
        return $query;
    }


    function update_email_subsidiary($id,$email){
        $this->db->set('EMAIL_PARTNER',$email);
        $this->db->where('KODE_PARTNER',$id);

        return $this->db->update('PRIME_PARTNER_TATA');
    }


#DATATABLES AM CC 
    var $column_order_am     = array('NAMA_AM','NIK','NAMA_CC','NIPNAS',null);
    var $column_search_am    = array('UPPER(NAMA_AM)','NIK','UPPER(NAMA_CC)','NIPNAS');
    var $order_am            = array('NAMA_AM' => 'asc');
    
    public function _get_all_query_am(){
            $query = $this->db
            ->select("*")
            ->from("PRIME_AM_CC");
            return $query;
    }

    private function _get_datatables_query_am($searchValue, $orderColumn, $orderDir, $getOrder){

        $this->_get_all_query_am();

        $i = 0;

        foreach ($this->column_search_am as $item) // loop column
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

                if (count($this->column_search_am) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_am[$orderColumn], $orderDir);
        }
        else if(isset($this->order_am))
        {
            $order = $this->order_am;
            $this->db->order_by(key($order), $orderDir);
        }
    }

    function get_datatables_am($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_am($searchValue, $orderColumn, $orderDir, $getOrder);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_am($searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_am($searchValue, $orderColumn, $orderDir, $getOrder);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_am(){
        $this->_get_all_query_am();
        return $this->db->count_all_results();
    }
#END DATATABLES AM CC

#DATATABLES HISTORY
    var $column_order_dataHistory     = array("TIME","IP",'NAME_USER','NAME_USER','ID','STATUS','TYPE','META');
    var $column_search_dataHistory    = array('ID','DATE_CREATED','ID_USER','NAME_USER','TYPE','STATUS');
    var $order_dataHistory            = array('DATE_CREATED' => 'desc');
    
    public function _get_all_query_dataHistory(){
            $query = $this->db
            ->select("TO_CHAR(DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') TIME, HISTORY.*")
            ->from("PRIME_HISTORY HISTORY")
            ->join("PRIME_USERS A","A.NIK  = HISTORY.ID_USER");


            $regional1 =    $this->session->userdata('regional');
            if($regional1 != '0' && !empty($regional1)){
                $query = $query->where('A.REGIONAL', $regional1);
            }

            return $query;
    }

    private function _get_datatables_query_dataHistory($searchValue, $orderColumn, $orderDir, $getOrder){

        $this->_get_all_query_dataHistory();

        $i = 0;

        foreach ($this->column_search_dataHistory as $item) // loop column
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

                if (count($this->column_search_dataHistory) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_dataHistory[$orderColumn], $orderDir);
        }
        else if(isset($this->order_dataHistory))
        {
            $order = $this->order_dataHistory;
            $this->db->order_by(key($order), $orderDir);
        }
    }

    function get_datatables_dataHistory($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_dataHistory($searchValue, $orderColumn, $orderDir, $getOrder);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_dataHistory($searchValue, $orderColumn, $orderDir, $getOrder){
        $this->_get_datatables_query_dataHistory($searchValue, $orderColumn, $orderDir, $getOrder);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dataHistory(){
        $this->_get_all_query_dataHistory();
        return $this->db->count_all_results();
    }
#END DATATABLES HISTORY

#DATATABLES SUBSIDIARY
    var $column_order_subsidiary     = array('TO_NUMBER(KODE_PARTNER)','NAMA_PARTNER','EMAIL_PARTNER',null,null);
    var $column_search_subsidiary    = array('KODE_PARTNER','UPPER(NAMA_PARTNER)','EMAIL_PARTNER');
    var $order_subsidiary            = array('TO_NUMBER(KODE_PARTNER)' => 'desc');
    
    public function _get_all_query_subsidiary(){
            $query = $this->db
            ->select("*")
            ->from("PRIME_PARTNER_TATA");
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

        if(isset($getOrder)&&!empty($orderColumn)) // here order processing
        {   
                
            $this->db->order_by($this->column_order_subsidiary[$orderColumn], $orderDir);
        }
        else if(isset($this->order_subsidiary))
        {
            $order = $this->order_subsidiary;
            $this->db->order_by(key($order), $orderDir);
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


    function addCreditPoint($data){
        $this->db->set('DATE_CREATED',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
        $this->db->set('DATE_EVENT',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
        $this->db->set('DATE_MODIFIED',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
        return $this->db->insert('PRIME_POST',$data);
    }

    function checkCreditPoint($title,$content,$meta){
        $q = $this->db->select("COUNT(1) TOTAL")
                ->from("PRIME_POST")
                ->where("TITLE",$title)
                ->where("CONTENT",$content)
                ->where("META_DATA",$meta)
                ->get()
                ->row();
        $result = $q->TOTAL;
        return $result;
    }

    function addLog($data){
        $this->db->set('DATE_CREATED',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
        $this->db->insert('PRIME_HISTORY',$data); 
       return true;
    }

    function updateProjectHistory($data){
        $this->db->set('UPDATED_DATE',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
        $this->db->set('UPDATED_BY_ID',$data['ID_USER']);
        $this->db->set('UPDATED_BY_NAME',$data['NAME_USER']);
        $this->db->set('UPDATE_ACTION',$data['STATUS']);
        $this->db->where('ID_PROJECT',$data['ID']);
        $this->db->update('PRIME_PROJECT'); 
       //echo json_encode($data);die;
       return true;   
    }

    function get_detail_project_wfm($spk){
        $q  = $this->db
                ->select('M.PROJECT_NAME NAME, B.ID_LOP_EPIC ID_LOP, B.ID_PROJECT, M.SEGMENT SEGMEN, NAMA_MITRA, M.NAMACC, M.DATE_CREATED, NILAI_PEKERJAAN VALUE, M.NAMA_MITRA, M.NO_SPK, A.ID_ROW')
                ->from('PRIME_BAST_HGN M')
                ->distinct()
                ->join('PRIME_PROJECT_PARTNERS A','A.NO_P8 = M.NO_SPK','LEFT')
                ->join('PRIME_PROJECT B','A.ID_PROJECT = B.ID_PROJECT','LEFT')
                ->where('M.NO_SPK',$spk)
                ->order_by('DATE_CREATED','desc')
                ->get()->row_array();


                if(empty($q)){
                $q  = $this->db
                                ->select("M.PROJECT_NAME NAME, B.ID_LOP_EPIC ID_LOP, B.ID_PROJECT, M.SEGMEN SEGMEN, M.NAMA_MITRA, M.NAMA_CC NAMACC, M.TANGGAL_BAST DATE_CREATED,M.VALUE VALUE, M.NO_SPK, '' ID_ROW")
                                ->from('PRIME_SPK_NUMERO M')
                                ->distinct()
                                ->join('PRIME_PROJECT_PARTNERS A','A.NO_P8 = M.NO_SPK','LEFT')
                                ->join('PRIME_PROJECT B','A.ID_PROJECT = B.ID_PROJECT','LEFT')
                                ->where('M.NO_SPK',$spk)
                                ->order_by('DATE_CREATED','desc')
                                ->get()->row_array();
                }

        return $q;
    }

    function get_detail_project_qo_so($id){
        /*$query = $this->db
                     ->select('ID_LOP, NO_QUOTE, NO_SO, VALID,EXIST, ID_ROW, NO_P8')
                     ->distinct()
                     ->from('PRIME_NO_QUOTE_SO')
                     ->where('NO_P8',$id)
                     ->where('EXIST',1)
                     ->order_by('NO_QUOTE','asc')
                     ->get()->result_array();*/
        $query   = $this->db->query("SELECT DISTINCT ID_LOP, NO_QUOTE, NO_SO, VALID, EXIST, ID_ROW, NO_P8 FROM PRIME_NO_QUOTE_SO WHERE NO_P8 = '".$id."' AND EXIST = 1 ORDER BY NO_QUOTE ASC")->result_array();

        return $query;

    }

    function get_id_row_p8($no_p8){
        $q = $this->db
                ->select('ID_ROW')
                ->from('PRIME_PROJECT_PARTNERS')
                ->where('NO_P8',$no_p8);

        return $q->get()->row();
    }

    function getNullLinkSPK(){
        $query = $this->db
                    ->select('*')
                    ->from('PRIME_PROJECT_PARTNERS')
                    ->where('LINK_P8 IS NULL')
                    ->get()
                    ->result_array();

        return $query;
    }

}

  