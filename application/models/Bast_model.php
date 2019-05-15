<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bast_model extends CI_Model {

    protected $tblCbase;

    public function __construct() 
    { 
        parent::__construct();
        $this->tblCbase = 'CBASE_DIVES';
    }


    function getPartnerById($id){ 
        $q = $this->db 
                ->select('*')
                ->from("PRIME_PARTNER_TATA")
                ->where("KODE_PARTNER",$id);

        return $q->get()->row()->NAMA_PARTNER; 
    }
 
    function count_bast($type,$date = null){
            $this->db->select('count(*) JUMLAH');
            $this->db->from('PRIME_BAST_HGN');

            if($date == 'month'){
                $this->db->where("to_char(DATE_MODIFIED, 'MM-YYYY') = to_char(sysdate, 'MM-YYYY')");
            }else if($date == 'today'){
                $this->db->where("to_char(DATE_MODIFIED, 'DD-MM-YYYY') = to_char(sysdate, 'DD-MM-YYYY')");
            }

            $this->db->where('EXIST',1);
            if($type=='RECEIVED'){
                $this->db->where('STATUS',$type);
                return $this->db->get()->row_array();
            }   

            if($type=='DONE'){
                $this->db->where('STATUS',$type);   
                return $this->db->get()->row_array();   
            }
            if($type=='CHECKED'){
                $this->db->where_in('STATUS',array('CHECK BY SE DI','CHECK BY SE PMO', 'CHECK BY COORD', 'APPROVED','CHECK BY ADM', 'REVISION', 'REVISIONED'));
                return $this->db->get()->row_array();
            }
            if($type=='TAKE OUT'){
                $this->db->where_in('STATUS',array('TAKE OUT','TAKE OUT (REV)'));
                return $this->db->get()->row_array();
            }else{
                $this->db->where('STATUS',$type);
                return $this->db->get()->row_array();
            }

    }

    function saveBAST($data){
        foreach($data as $key => $value){

                if($key=='TGL_SPK'){
                    $this->db->set("TGL_SPK","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if($key=='TGL_KL'){
                    $this->db->set("TGL_KL","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if($key=='TGL_BAST'){
                    $this->db->set("TGL_BAST","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if(($key=='RECC_START_DATE')&&(!empty($key=='RECC_START_DATE'))){
                    $this->db->set("RECC_START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if(($key=='RECC_END_DATE')&&(!empty($key=='RECC_END_DATE'))){
                    $this->db->set("RECC_START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else{
                    if(!empty($value)){
                        $this->db->set($key , trim($value));
                    }
                    
                }       
            } 
        if(empty($data['BAPP'])){
            $this->db->set('BAPP','');
        }
        $this->db->set('DATE_CREATED',"TO_DATE('".date('m/d/Y')."','MM/DD/YYYY')",FALSE);
        $this->db->set('DATE_MODIFIED',"TO_DATE('".date('m/d/Y H:i')."','MM/DD/YYYY HH24:MI')",FALSE);          
        return $this->db->insert('PRIME_BAST_HGN');
    }

    function updateBAST($data,$id){
        foreach($data as $key => $value){
            
                if($key=='TGL_SPK'){
                    $this->db->set("TGL_SPK","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if($key=='TGL_KL'){
                    $this->db->set("TGL_KL","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if($key=='TGL_BAST'){
                    $this->db->set("TGL_BAST","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if(($key=='RECC_START_DATE')&&(!empty($key=='RECC_START_DATE'))){
                    $this->db->set("RECC_START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if(($key=='RECC_END_DATE')&&(!empty($key=='RECC_END_DATE'))){
                    $this->db->set("RECC_START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else{
                    if(!empty($value)){
                        $this->db->set($key , trim($value));
                    }
                    
                }       
            } 

        if(empty($data['BAPP'])){
            $this->db->set('BAPP','');
        }
        $this->db->set('DATE_MODIFIED',"TO_DATE('".date('m/d/Y H:i')."','MM/DD/YYYY HH24:MI')",FALSE);    
        $this->db->where('ID_BAST',$id); 
        $q = $this->db->update('PRIME_BAST_HGN');
        //echo $this->db->last_query();die;
        return $q;
    }

    function edit_bast($data,$id){
        foreach($data as $key => $value){
            
                if($key=='TGL_SPK'){
                    $this->db->set("TGL_SPK","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if($key=='TGL_KL'){
                    $this->db->set("TGL_KL","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if($key=='TGL_BAST'){
                    $this->db->set("TGL_BAST","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if(($key=='RECC_START_DATE')&&(!empty($key=='RECC_START_DATE'))){
                    $this->db->set("RECC_START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else if(($key=='RECC_END_DATE')&&(!empty($key=='RECC_END_DATE'))){
                    $this->db->set("RECC_START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else{
                    if(!empty($value)){
                        $this->db->set($key , $value);
                    }
                    
                }       
            } 
        $this->db->set('DATE_MODIFIED',"TO_DATE('".date('m/d/Y H:i')."','MM/DD/YYYY HH24:MI')",FALSE);    
        $this->db->where('ID_BAST',$id); 
        $q = $this->db->update('PRIME_BAST_HGN');
        //echo $this->db->last_query();die;
        return $q;
    }

    function addBASTHistory($data) {
        foreach($data as $key => $value){
            $this->db->set($key , $value);        
        }
        $this->db->set('DATE_UPDATED',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
        $query = $this->db->insert('PRIME_BAST_HISTORY');
        return $query;
    }


    function addBASTSymptoms($data) {
        foreach($data as $key => $value){
            $this->db->set($key , $value);        
        }
        $query = $this->db->insert('PRIME_BAST_REVISION_HISTORY');
        return $query;
    }


    function getDataBast($id){
        $q = $this->db->select("A.*,TO_CHAR(A.TGL_BAST, 'MM/DD/YYYY') TGL_BAST2, TO_CHAR(A.TGL_KL, 'MM/DD/YYYY') TGL_KL2, TO_CHAR(A.TGL_SPK, 'MM/DD/YYYY') TGL_SPK2, TO_CHAR(A.RECC_START_DATE, 'MM/DD/YYYY') RECC_START_DATE2, TO_CHAR(A.RECC_END_DATE, 'MM/DD/YYYY') RECC_END_DATE2, C.ID_PROJECT, A.ID_LOP ID_LOP")
                      ->distinct()
                      ->from('PRIME_BAST_HGN A')
                      ->join('PRIME_PROJECT_PARTNERS B','A.NO_SPK = B.NO_P8','LEFT')
                      ->join('PRIME_PROJECT C','C.ID_PROJECT = B.ID_PROJECT','LEFT')
                      ->where('A.ID_BAST',$id);

        return $q->get()->row_array();
    }

    function getDataOldBast($no_spk,$id){
        $q = $this->db->select("A.*,TO_CHAR(A.TGL_BAST, 'MM/DD/YYYY') TGL_BAST2, TO_CHAR(A.TGL_KL, 'MM/DD/YYYY') TGL_KL2, TO_CHAR(A.TGL_SPK, 'MM/DD/YYYY') TGL_SPK2, TO_CHAR(A.RECC_START_DATE, 'MM/DD/YYYY') RECC_START_DATE2, TO_CHAR(A.RECC_END_DATE, 'MM/DD/YYYY') RECC_END_DATE2 ")
                      ->from('PRIME_BAST_HGN A')
                      ->where('NO_SPK',$no_spk)
                      ->where('EXIST','1')
                      ->where('ID_BAST !=',$id)
                      ->order_by('TGL_BAST','DESC');

        return $q->get()->result_array();
    }

    function getDataAllBast($epic=null){
        $q = $this->db->select("A.*,TO_CHAR(A.TGL_BAST, 'MM/DD/YYYY') TGL_BAST2, TO_CHAR(A.TGL_KL, 'MM/DD/YYYY') TGL_KL2, TO_CHAR(A.TGL_SPK, 'MM/DD/YYYY') TGL_SPK2, TO_CHAR(A.RECC_START_DATE, 'MM/DD/YYYY') RECC_START_DATE2, TO_CHAR(A.RECC_END_DATE, 'MM/DD/YYYY') RECC_END_DATE2, C.ID_LOP_EPIC ID_LOP")
                      ->from('PRIME_BAST_HGN A')
                      ->join('PRIME_PROJECT_PARTNERS B','A.NO_SPK = B.NO_P8')
                      ->join('PRIME_PROJECT C','C.ID_PROJECT = B.ID_PROJECT')
                      ->distinct()
                      ->where('C.ID_LOP_EPIC IS NOT NULL');

            if(!empty($epic)){
                $q = $q->where_in('A.STATUS',array('TAKE OUT','DONE'));
            }

        return $q->get()->result_array();
    }

    function getDataBastToEpic($id){
        $q = $this->db->select("A.*,TO_CHAR(A.TGL_BAST, 'MM/DD/YYYY') TGL_BAST2, TO_CHAR(A.TGL_KL, 'MM/DD/YYYY') TGL_KL2, TO_CHAR(A.TGL_SPK, 'MM/DD/YYYY') TGL_SPK2, TO_CHAR(A.RECC_START_DATE, 'MM/DD/YYYY') RECC_START_DATE2, TO_CHAR(A.RECC_END_DATE, 'MM/DD/YYYY') RECC_END_DATE2, C.ID_LOP_EPIC ID_LOP")
                      ->from('PRIME_BAST_HGN A')
                      ->join('PRIME_PROJECT_PARTNERS B','A.NO_SPK = B.NO_P8')
                      ->join('PRIME_PROJECT C','C.ID_PROJECT = B.ID_PROJECT')
                      ->where('A.ID_BAST',$id)
                      ->where('C.ID_LOP_EPIC IS NOT NULL');

        return $q->get()->row_array();
    }

    var $table = 'PRIME_BAST_HGN';
    var $column_order = array('H1.NO_SPK',"H1.NAMA_MITRA",'H1.NAMACC','H1.TYPE_BAST','H1.TGL_BAST','TO_NUMBER(H1.NILAI_RP_BAST)','H1.STATUS',null); //set column field database for datatable orderable
    var $column_search = array('UPPER(H1.PROJECT_NAME)','UPPER(H1.NO_SPK)','UPPER(H1.NAMACC)','UPPER(H1.NAMA_MITRA)','UPPER(H1.NAMA_PM)','H1.PENANDA_TANGAN','H1.NO_KL','H1.SEGMENT','H1.STATUS','H1.SEGMENT','H1.ID_BAST','H1.NO_BAST'); //set column field database for datatable searchable
    var $order = array('DATE_CREATED' => 'desc'); // default order
    
    public function _get_all_query($status,$mitra2,$segmen,$customer,$spk){
          $mitra = $this->session->userdata('mitra');
          $nik = $this->session->userdata('nik_sess');

          if(!empty($this->session->userdata('segmen_sess'))){
            $segmen = $this->session->userdata('segmen_sess');
          }


             $this->db
            ->distinct()
            ->select("H1.*,  to_char(TGL_BAST, 'DD MONTH YYYY') TGL_BAST2") 
            ->from('PRIME_BAST_HGN H1','H1.ID_BAST = H2.ID_PROJECT');
            if($status   != null){$this->db->where('H1.STATUS',$status);}
            if($mitra2   != 'x' && $mitra2 != 0){$this->db->where('H1.ID_MITRA',$mitra2);}
            if($mitra2   != 'x' && $mitra2 == 0){$this->db->where('H1.ID_MITRA IS NULL');}
            if($segmen   != null){$this->db->where('H1.SEGMENT',$segmen);}
            if($spk      != null){$this->db->where('H1.NO_SPK',$spk);}
            if($customer != null){$this->db->where('H1.NIPNAS',$customer);}

            if($this->session->userdata('tipe_sess') == 'PROJECT_MANAGER' ){
            $nama_pm = $this->session->userdata('nama_sess');
            $this->db->where('NAMA_PM',$nama_pm);
            }

            if(!empty($mitra) && $nik != 'admin_mitra'){$query = $this->db->where('ID_MITRA',$mitra);}
                else{$query = $this->db->where('H1.EXIST','1');}

            return $query;
    }

    private function _get_datatables_query($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk){

        $this->_get_all_query($status,$mitra,$segmen,$customer,$spk);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)) // here order processing
        {   
                
            $this->db->order_by($this->column_order[$orderColumn], $orderDir);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder, $status,$mitra,$segmen,$customer,$spk){
        $this->_get_datatables_query($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk){
        $this->_get_datatables_query($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($status,$mitra,$segmen,$customer,$spk){
        $this->_get_all_query($status,$mitra,$segmen,$customer,$spk);
        return $this->db->count_all_results();
    }
    /* END Data Tables*/


    ##DATATABLE LIST_ACTIVE PROJECT
    var $column_orderActive = array('UPPER(A.NAME)','UPPER(A.SEGMEN)','UPPER(B.NO_P8)','UPPER(A.STANDARD_NAME)','UPPER(B.PARTNER_NAME)',null);
    var $column_searchActive = array('UPPER(A.NAME)','UPPER(A.SEGMEN)','UPPER(B.NO_P8)','UPPER(A.STANDARD_NAME)','UPPER(B.PARTNER_NAME)');
    var $orderActive = array('SEQ', 'desc'); 
    
    public function _get_all_queryActive($status,$pm,$customer,$partner,$type,$regional,$segmen,$searchValue=null){
        $arr    = array('PROJECT CANDIDATE','REUQEST');

        $query  = $this->db
                    ->select()
                    ->from('PRIME_PROJECT A')
                    ->join('PRIME_PROJECT_PARTNERS B','A.ID_PROJECT = B.ID_PROJECT','LEFT')
                    ->where_not_in('A.STATUS',$arr)
                    ->where('B.NO_P8 IS NOT NULL')
                    ->where('B.NO_P8 !=','-');
        
        /*if(empty($searchValue)){
            $query = $query->where(1,0);
        }*/
                return $query;

    }

    private function _get_datatables_queryActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){

        $this->_get_all_queryActive($status,$pm,$customer,$partner,$type,$regional,$segmen,$searchValue);

        $i = 0;

        foreach ($this->column_searchActive as $item) // loop column
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

                if (count($this->column_searchActive) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)&&$orderColumn!=null) // here order processing
        {   
            $this->db->order_by($this->column_orderActive[$orderColumn], $orderDir);
        }
        else if(isset($this->orderActive))
        {   
            $order = $this->orderActive;
            $this->db->order_by($order[0], $orderDir);
        }
    }

    function get_datatablesActive($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder, $status,$pm,$customer,$partner,$type,$regional,$segmen){
        $this->_get_datatables_queryActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
        if ($length != -1)
            $this->db->limit($length, $start);
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filteredActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){
        $this->_get_datatables_queryActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen,$searchValue);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_allActive($status,$pm,$customer,$partner,$type,$regional,$segmen,$searchValue){
        $this->_get_all_queryActive($status,$pm,$customer,$partner,$type,$regional,$segmen,$searchValue);
        return $this->db->count_all_results();
    }
#END LIST ACTIVE PROJECT


    function getSquenSpk($no_spk){
        $arr = array('APPROVED','TAKE OUT','DONE');
        $this->db->select("COUNT(1) TOTAL");
        $this->db->from("PRIME_BAST_HGN");
        $this->db->where("NO_SPK",$no_spk);
        $this->db->where_in('STATUS', $arr);
        $total = $this->db->get()->row()->TOTAL;
        $total = $total+1;
        return $total;
    }


    function getProjectBySpk($id){
        $q = $this->db
            ->select("C.*,B.ID_ROW")
            ->from('PRIME_BAST_HGN A')
            ->join('PRIME_PROJECT_PARTNERS B','B.NO_P8 = A.NO_SPK')
            ->join('PRIME_PROJECT C','B.ID_PROJECT = C.ID_PROJECT')
            ->where('A.NO_SPK',$id)
            ->get()->row();
            return $q;
    }   

    function getDataHistory($id){
        $q = $this->db
            ->select("ROW_NUMBER() OVER(ORDER BY DATE_UPDATED ASC) AS NO ,PRIME_BAST_HISTORY.*, TO_CHAR(DATE_UPDATED, 'DD MONTH YYYY [HH24:MI]') TIME")
            ->from('PRIME_BAST_HISTORY')
            ->where('ID_PROJECT',$id)
            ->order_by('DATE_UPDATED','DESC')
            ->get()->result_array();

        foreach ($q as $key => $value) { 
                $x = @explode('|||',$q[$key]['BY_USER']);
                $q[$key]['ID_USER']     = $x[0];
                $q[$key]['NAME_USER']   = $x[1];
                $q[$key]['PHOTO_USER']  = $this->getUserPhoto($q[$key]['ID_USER']);
            }    
            return $q;
    }


    function getUserPhoto($id){
        
    }


    function download_list_bast(){
            $q      =   $this->db
                            ->select("A.*, 'https://prime.telkom.co.id/sdv/'||A.FILENAME_URI FILENAME_URI2,  H3.COMMEND, TO_CHAR(LATEST,'MM/DD/YYYY') LATEST2")
                            ->from("PRIME_BAST_HGN A")
                            ->join('(
                                SELECT distinct
                                    ID_PROJECT, MAX(DATE_UPDATED) LATEST
                                    FROM PRIME_BAST_HISTORY
                                    GROUP BY ID_PROJECT 
                                ) H2','H2.ID_PROJECT = A.ID_BAST')
                            ->join('PRIME_BAST_HISTORY H3','H3.DATE_UPDATED = H2.LATEST AND H2.ID_PROJECT = H3.ID_PROJECT')
                            //->join('PRIME_PROJECT C','A.ID_PROJECT = C.ID_PROJECT','LEFT')
                            ->where('A.EXIST','1')  
                            ->where("DATE_CREATED >=  TO_DATE('01/01/2019','DD/MM/YYYY')")  
                            //->where("A.STATUS != 'TAKE OUT'")  
                            ->distinct()
                            ->get();
            $result = $q->result_array();       


            return $result;
    }


    function download_list_bast_revision(){
            $q      =   $this->db
                            ->select("A.*, 'https://prime.telkom.co.id/sdv/'||A.FILENAME_URI FILENAME_URI2,  H3.COMMEND, TO_CHAR(LATEST,'MM/DD/YYYY') LATEST2")
                            ->from("PRIME_BAST_HGN A")
                            ->join("(
                                SELECT distinct
                                    ID_PROJECT, MAX(DATE_UPDATED) LATEST
                                    FROM PRIME_BAST_HISTORY
                                    WHERE STATUS  = 'REVISION'
                                    GROUP BY ID_PROJECT 
                                ) H2",'H2.ID_PROJECT = A.ID_BAST')
                            ->join('PRIME_BAST_HISTORY H3','H3.DATE_UPDATED = H2.LATEST AND H2.ID_PROJECT = H3.ID_PROJECT')
                            //->join('PRIME_PROJECT C','A.ID_PROJECT = C.ID_PROJECT','LEFT')
                            ->where('A.EXIST','1')  
                            ->where_in('A.STATUS', array('REVISION','TAKE OUT (REV)'))  
                            //->where("DATE_CREATED >=  TO_DATE('01/01/2019','DD/MM/YYYY')")  
                            //->where("A.STATUS != 'TAKE OUT'")  
                            ->distinct()
                            ->get();
            $result = $q->result_array();      
            return $result;
    }

    function download_list_bast2(){
            $q      =   $this->db
                            ->select("A.*, B.STATUS STATUS_HISTORY, B.COMMEND")
                            ->from("PRIME_BAST_HGN A")
                            ->join('PRIME_BAST_HISTORY B','B.ID_PROJECT = A.ID_BAST')
                            ->where('A.ID_MITRA','34')
                            ->where('A.EXIST','1')
                            ->distinct()
                            ->get();
            $result = $q->result_array();       


            return $result;
    }

    function get_bast_received_this_month(){
        $query = $this->db
                ->select("TO_CHAR(DATE_CREATED,'DD') DATE_RECEIVED, COUNT(1) TOTAL")
                ->from("PRIME_BAST_HGN")
                ->where("DATE_CREATED BETWEEN trunc (sysdate, 'MM') AND SYSDATE")
                ->group_by("DATE_CREATED")
                ->order_by("DATE_CREATED","ASC")
                ->get()
                ->result_array();
        return $query;
    }


    // delete BAST
    function deleteBast($id){
        $this->db->set('EXIST',0);
        $this->db->where('ID_BAST',$id);
        return $this->db->update('PRIME_BAST_HGN');
    }


}
