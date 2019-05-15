<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Utility_model extends CI_Model
{
    public function __construct() {
    } 


    function bast_fail($no_bast){
        $q = $this->db->set('NO_BAST',$no_bast);

        return $q->insert('PRIME_BAST_F');
    }

    function update_nipnas_bast($param){
        $q = $this->db->set('NIPNAS',$param[1]);
        $q = $this->db->set('NAMACC',$param[2]);
        $q = $this->db->where('NAMACC',$param[0]); 
        return $q->update('PRIME_BAST_HGN');
    } 

    function update_spk_bast($param){
        $q = $this->db->set('OLD_NO_SPK',$param[0]);
        $q = $this->db->set('NO_SPK',$param[1]);
        $q = $this->db->where('NO_SPK',$param[0]);
        return $q->update('PRIME_BAST_HGN');
    }

    function testApi($id){
        $query = $this->db->select("PROJECT.ID_LOP ID_LOP,
                                    BAST.NO_BAST NO_BAST, 
                                    PROJECT.PARTNER_NAME,
                                    CASE WHEN BAST.TYPE_BAST = 'OTC' THEN '100%' 
                                         WHEN BAST.TYPE_BAST = 'PROGRESS' THEN BAST.PROGRESS_LAPANGAN||'%'
                                         WHEN BAST.TYPE_BAST = 'TERMIN' THEN BAST.NAMA_TERMIN
                                         WHEN BAST.TYPE_BAST = 'RECURING' THEN TO_CHAR(BAST.RECC_START_DATE, 'MM/YYYY') ||' - '|| TO_CHAR(BAST.RECC_END_DATE, 'MM/YYYY')
                                         ELSE '0' END PROGRESS,
                                    CASE WHEN BAST.FILENAME_URI IS NULL then '#' else 'prime.telkom.co.id/'||BAST.FILENAME_URI end 
                                         FILE_BAST   
                                    ")
                          ->from('PRIME_BAST_HGN BAST')
                          ->join("(SELECT A.ID_PROJECT ID_PROJECT, A.ID_LOP_EPIC ID_LOP, B.NO_P8 NO_P8, B.PARTNER_NAME 
                                    FROM PRIME_PROJECT A 
                                    JOIN PRIME_PROJECT_PARTNERS B 
                                    ON A.ID_PROJECT = B.ID_PROJECT 
                                  ) PROJECT",
                                  "PROJECT.NO_P8 = BAST.NO_SPK")
                          ->where("PROJECT.ID_LOP", $id)
                          ->where("BAST.EXIST",'1')
                          ->get()
                          ->result();
                          
        return $query;
    }
##DOMES BAST

    var $table_bast_domes = 'PRIME_BAST_HGN';
    var $column_order_bast_domes = array('H1.NO_SPK',"TO_NUMBER(H1.NAMA_MITRA)",'H1.NAMACC','H1.TYPE_BAST','H1.TGL_BAST','TO_NUMBER(H1.NILAI_RP_BAST)','H1.STATUS',null); //set column field database for datatable orderable
    var $column_search_bast_domes = array('UPPER(H1.PROJECT_NAME)','H1.NO_SPK','UPPER(H1.NAMACC)','UPPER(H1.NAMA_MITRA)','UPPER(H1.NAMA_PM)','H1.PENANDA_TANGAN','H1.NO_KL','H1.SEGMENT','H1.STATUS','H1.SEGMENT','H1.ID_BAST','H1.NO_BAST'); //set column field database for datatable searchable
    var $order_bast_domes = array('DATE_CREATED' => 'desc'); // default order
  
  public function _get_all_query_bast_domes($status,$mitra2,$segmen,$customer,$spk){
      $mitra = $this->session->userdata('mitra');
      $nik = $this->session->userdata('nik_sess');


       $this->db
            ->distinct()
            ->select("H1.*, H3.DATE_UPDATED, H3.COMMEND")
            ->from('(
                  SELECT distinct
                      ID_PROJECT, MAX(DATE_UPDATED) LATEST
                      FROM PRIME_BAST_HISTORY
                      GROUP BY ID_PROJECT 
                  ) H2')
            ->join('PRIME_BAST_HGN H1','H1.ID_BAST = H2.ID_PROJECT')
            ->join('PRIME_BAST_HISTORY H3','H3.ID_PROJECT = H2.ID_PROJECT AND H2.LATEST = H3.DATE_UPDATED ')
            ->where('H1.EXIST','1')
            ->where_in('H1.STATUS',array("TAKE OUT","DONE"));

            if($mitra2   != null){$this->db->where('H1.ID_MITRA',$mitra2);}
            if($segmen   != null){$this->db->where('H1.SEGMENT',$segmen);}
            if($spk      != null){$this->db->where('H1.NO_SPK',$spk);}
            if($customer != null){$this->db->where('H1.NIPNAS',$customer);}

            if($status != null){
              if($status == 'X'){
                $this->db->where('H1.DOMES','0');
              }else{
                $this->db->where('H1.DOMES',$status);
              }

            }

      if($this->session->userdata('tipe_sess') == 'PROJECT_MANAGER' ){
              $nama_pm = $this->session->userdata('nama_sess');
              $this->db->where('NAMA_PM',$nama_pm);
            }

      if(!empty($mitra) && $nik != 'admin_mitra'){
        $query = $this->db->where('ID_MITRA',$mitra);
      }

      $query = $this->db->where('H1.EXIST','1');

      return $query;
    }

    private function _get_datatables_query_bast_domes($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk){

        $this->_get_all_query_bast_domes($status,$mitra,$segmen,$customer,$spk);

        $i = 0;

        foreach ($this->column_search_bast_domes as $item) // loop column
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

                if (count($this->column_search_bast_domes) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($getOrder)) // here order processing
        { 
            
            $this->db->order_by($this->column_order_bast_domes[$orderColumn], $orderDir);
        }
        else if(isset($this->order_bast_domes))
        {
            $order = $this->order_bast_domes;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_bast_domes($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder, $status,$mitra,$segmen,$customer,$spk){
        $this->_get_datatables_query_bast_domes($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk);
        if ($length != -1)
            $this->db->limit($length, $start);
          $query = $this->db->get();
          // echo $this->db->last_query();exit;
        return $query->result();
    }

    function count_filtered_bast_domes($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk){
        $this->_get_datatables_query_bast_domes($searchValue, $orderColumn, $orderDir, $getOrder,$status,$mitra,$segmen,$customer,$spk);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bast_domes($status,$mitra,$segmen,$customer,$spk){
        $this->_get_all_query_bast_domes($status,$mitra,$segmen,$customer,$spk);
        return $this->db->count_all_results();
    }

##END DOMES BAST




    function execute_procedure_updateStatus(){
      return $this->db->query("BEGIN PRIME_UPDATE_STATUS_PROC; END;");
    }


    function execute_procedure_updateMonitoring(){
      return $this->db->query("BEGIN PRIME_MONITORING_PROJECT_PROC; END;");
    }


    function execute_procedure_updateSCurve(){
      return $this->db->query("BEGIN PRIME_S_CURVE_DAILY_PROC; END;");
    }


    #DATATABLE CRON PARTNER
      var $column_orderCronPartner = array('KODE_PARTNER','NAMA_PARTNER','STATUS',null); //set column field database for datatable orderable
      var $column_searchCronPartner = array("UPPER(NAMA_PARTNER)"); //set column field database for datatable searchable
      var $orderCronPartner = array('KODE_PARTNER' => 'asc'); // default order
    
    public function _get_all_queryCronPartner($dateHappen){
         $query = $this->db
            ->select("A.*, B.STATUS,B.DATE_LOG")
            ->from("PRIME_PARTNER_TATA A")
            ->join("(
                    SELECT * FROM PRIME_EMAIL_BAST_LOG WHERE TO_CHAR(DATE_LOG,'MM/DD/YYYY') = '".$dateHappen."' ) B",
                    "A.KODE_PARTNER = B.ID_PARTNER",
                    "LEFT");

        /*if(!empty($dateHappen)){
          $query = $query->Where("TO_CHAR(B.DATE_LOG,'MM/DD/YYYY')","'".$dateHappen."'",FALSE);
        }else{
          $query = $query->Where('B.DATE_LOG',"TRUNC(SYSDATE - 1)");
        }*/
          
        return $query;
        
      }

      private function _get_datatables_queryCronPartner($searchValue, $orderColumn, $orderDir, $getOrder,$dateHappen){

          $this->_get_all_queryCronPartner($dateHappen);

          $i = 0;

          foreach ($this->column_searchCronPartner as $item) // loop column
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

                  if (count($this->column_searchCronPartner) - 1 == $i) //last loop
                      $this->db->group_end(); //close bracket
              }
              $i++;
          }

          if(isset($getOrder)&&$orderColumn!=null) // here order processing
          { 
              
              $this->db->order_by($this->column_orderCronPartner[$orderColumn], $orderDir);
          }
          else if(isset($this->orderCronPartner))
          {
              $order = $this->orderCronPartner;
              $this->db->order_by(key($order), $orderDir);
          }
      }

      function get_datatablesCronPartner($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$dateHappen){
          $this->_get_datatables_queryCronPartner($searchValue, $orderColumn, $orderDir, $getOrder,$dateHappen);
          if ($length != -1)
              $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query();exit;
          return $query->result();
      }

      function count_filteredCronPartner($searchValue, $orderColumn, $orderDir, $getOrder,$dateHappen){
          $this->_get_datatables_queryCronPartner($searchValue, $orderColumn, $orderDir, $getOrder,$dateHappen);
          $query = $this->db->get(); 
          return $query->num_rows();
      }

      public function count_allCronPartner($dateHappen){
          $this->_get_all_queryCronPartner($dateHappen);
          return $this->db->count_all_results();
      }
  #END LIST CronPartner


  #DOWNLOAD LIS VALIDATION WFM
      function download_validation_wfm(){
        $query = $this->db
                  ->select('A.NO_P8, A.NO_QUOTE, A.NO_SO, A.VALID,A.DATE_UPDATED, A.UPDATED_BY_NAME, A.UPDATED_BY_ID, B.NAME, B.TYPE, B.ID_PRO, B.SEGMEN,B.ID_LOP_EPIC')
                  ->from('PRIME_NO_QUOTE_SO A')
                  ->distinct()
                  ->join("(
                          SELECT DISTINCT X.*, Y.NO_P8, X.ID_PROJECT ID_PRO FROM PRIME_PROJECT X LEFT JOIN PRIME_PROJECT_PARTNERS Y ON X.ID_PROJECT = Y.ID_PROJECT
                          ) B","B.ID_LOP_EPIC = A.ID_LOP OR A.NO_P8 = B.NO_P8","LEFT")
                  ->where("A.EXIST",1)
                  ->order_by("A.VALID","DESC");
        return $query->get()->result_array();   
      }

  #UTILITY MODEL
      //BAST
  public function getDataEmailMitra($id=0){
      $arr = array('TAKE OUT');
      $q = $this->db
      ->select("ID_MITRA,EMAIL_MITRA,NAMA_MITRA")
      ->from('PRIME_BAST_HGN')
      ->group_by('ID_MITRA,EMAIL_MITRA,NAMA_MITRA')
      ->where_not_in('STATUS', $arr)
      ->where('ID_MITRA', $id)
      ->where('EXIST', '1')
      ->get()->result_array();
      //echo $this->db->last_query();exit;
      return $q;
    }

    public function getDataEmailMitraDone($id=0){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');
      $q = $this->db
      ->select("ID_MITRA,EMAIL_MITRA,NAMA_MITRA")
      ->from('PRIME_BAST_HGN')
      //->where("DATE_MODIFIED","TRUNC(SYSDATE)",false)
      //->group_by('ID_MITRA,EMAIL_MITRA,NAMA_MITRA')
      ->where("DATE_MODIFIED >=","TRUNC(SYSDATE)",false)
      ->where("DATE_MODIFIED <","TRUNC(SYSDATE)+1",false)
      ->where_in('STATUS', $arr)
      ->where('ID_MITRA', $id)
      ->where('EXIST', '1')
      ->group_by('ID_MITRA,EMAIL_MITRA,NAMA_MITRA')
      ->get()->result_array();
      //echo $this->db->last_query();exit;
      //echo json_encode($q);exit;
      return $q;    

    }

    public function getDataEmailMitraDef($id=0){
      //$arr = array('TAKE OUT','DONE');
      $q = $this->db
      ->select("EMAIL_PARTNER")
      ->from('PRIME_PARTNER_TATA')
      ->where('KODE_PARTNER',$id)
      ->get()->result_array();
      return $q;    

    }

    public function getDataNotifMitra($id_mitra = null){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');
      $q = $this->db
      ->select("ID_MITRA,NAMA_MITRA")
      ->from('PRIME_BAST_HGN')
      ->group_by('ID_MITRA, NAMA_MITRA')
      ->where('EXIST', '1');
      //->where('ID_MITRA','99')
      //->where_not_in('STATUS', $arr)
      //echo json_encode($q) ;exit;

      if(!empty($id_mitra)){
        $q = $q->where('ID_MITRA',$id_mitra);
      }

      return $q->order_by('ID_MITRA')->get()->result_array();
    }

    public function getDataBastMitra($id=0){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');

    $query = $this->db
      ->select("H1.*, TO_CHAR(H3.DATE_UPDATED, 'DD/MM/YYYY HH24:MI:SS') TIME, H3.COMMEND NOTE")
      ->from('(
            SELECT 
                ID_PROJECT, MAX(DATE_UPDATED) LATEST
                FROM PRIME_BAST_HISTORY
                GROUP BY ID_PROJECT 
            ) H2')
      ->join('PRIME_BAST_HGN H1','H1.ID_BAST = H2.ID_PROJECT','INNER')
      ->join('PRIME_BAST_HISTORY H3','H3.ID_PROJECT = H2.ID_PROJECT AND H2.LATEST = H3.DATE_UPDATED ','INNER')
      ->where_not_in('H1.STATUS', $arr)
      ->where('H1.ID_MITRA', $id)
      ->where("H1.EXIST","1")
      ->order_by('H1.STATUS','DESC')
      ->order_by('H3.DATE_UPDATED','ASC')
      ->get()->result_array();
      return $query;  
    

    }


    public function getDataBastMitraPnd(){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');

    $query = $this->db
      ->select("H1.*, TO_CHAR(H3.DATE_UPDATED, 'DD/MM/YYYY HH24:MI:SS') TIME, H3.COMMEND NOTE")
      ->from('(
            SELECT 
                ID_PROJECT, MAX(DATE_UPDATED) LATEST
                FROM PRIME_BAST_HISTORY
                GROUP BY ID_PROJECT 
            ) H2')
      ->join('PRIME_BAST_HGN H1','H1.ID_BAST = H2.ID_PROJECT','INNER')
      ->join('PRIME_BAST_HISTORY H3','H3.ID_PROJECT = H2.ID_PROJECT AND H2.LATEST = H3.DATE_UPDATED ','INNER')
      ->where_not_in('H1.STATUS', $arr)
      ->where("H1.EXIST","1")
      ->order_by('H1.STATUS','DESC')
      ->order_by('H3.DATE_UPDATED','ASC')
      ->get()->result_array();
      return $query;    
    } 


    public function getDataBastMitraDone($id=0){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');
    
    $query = $this->db
      ->select("H1.*, TO_CHAR(H3.DATE_UPDATED, 'DD/MM/YYYY HH24:MI:SS') TIME, H3.COMMEND NOTE")
      ->from('(
            SELECT 
                ID_PROJECT, MAX(DATE_UPDATED) LATEST
                FROM PRIME_BAST_HISTORY
                GROUP BY ID_PROJECT 
            ) H2')
      ->join('PRIME_BAST_HGN H1','H1.ID_BAST = H2.ID_PROJECT','INNER')
      ->join('PRIME_BAST_HISTORY H3','H3.ID_PROJECT = H2.ID_PROJECT AND H2.LATEST = H3.DATE_UPDATED ','INNER')
      ->where_in('H1.STATUS', $arr)
      ->where("H1.DATE_MODIFIED >=","TRUNC(SYSDATE)",false)
      ->where("H1.DATE_MODIFIED <","TRUNC(SYSDATE)+1",false)
      ->where('H1.ID_MITRA', $id)
      ->where("H1.EXIST","1")
      ->get()->result_array();
      //echo $this->db->last_query();exit;
      //echo json_encode($query);exit;
      return $query;  
    }

     public function getDataBastMitraDonePnd(){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');
      /*$q = $this->db
      ->select("*")
      ->from('PRIME_BAST_HGN')
      //->group_by('NAMA_MITRA')
      ->where_in('STATUS', $arr)
      ->where('ID_MITRA', $id)
      ->get()->result_array();
      //echo $this->db->last_query();exit;
      return $q;*/
    
    $query = $this->db
      ->select("H1.*, TO_CHAR(H3.DATE_UPDATED, 'DD/MM/YYYY HH24:MI:SS') TIME, H3.COMMEND NOTE")
      ->from('(
            SELECT 
                ID_PROJECT, MAX(DATE_UPDATED) LATEST
                FROM PRIME_BAST_HISTORY
                GROUP BY ID_PROJECT 
            ) H2')
      ->join('PRIME_BAST_HGN H1','H1.ID_BAST = H2.ID_PROJECT','INNER')
      ->join('PRIME_BAST_HISTORY H3','H3.ID_PROJECT = H2.ID_PROJECT AND H2.LATEST = H3.DATE_UPDATED ','INNER')
      ->where_in('H1.STATUS', $arr)
      ->where("H1.DATE_MODIFIED >=","TRUNC(SYSDATE)",false)
      ->where("H1.DATE_MODIFIED <","TRUNC(SYSDATE)+1",false)
      ->where("H1.EXIST","1")
      //->where('H1.ID_MITRA', $id)
      ->get()->result_array();
      //echo $this->db->last_query();exit;
      //echo json_encode($query);exit;
      return $query;  
    } 


    public function getDataPM($id=0){;
      $q = $this->db
      ->select("NIK PM_NIK, NAMA PM_NAME")
      ->from('PRIME_USERS')
      ->where('TIPE','PROJECT_MANAGER')
      //->group_by('PM_NIK,PM_NAME')
      ->get()->result_array();
      return $q;    


    }

     public function getDataProjectPM($id=0){;
        $arr = array('LEAD','LAG','DELAY');

      $query = $this->db
            ->select("TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED,   A.NAME, A.PM_NAME , HIS.NAME_USER UPDATED_BY ,SUBSTR(C.PLAN,1,6) ||'%' PLAN, SUBSTR(C.REAL,1,6) ||'%' ACH, A.STATUS")
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
                                ) HIS","HIS.ID = A.ID_PROJECT")
            ->where_in('A.STATUS', $arr)
            ->order_by('A.PM_NAME, LAST_UPDATED')
            ->get()->result_array();

        return $query;
    }

    function getProjectProgress(){
      $query = $this->db
                        ->select("
                            A.ID_PROJECT ID_PROJECT, 
                            A.STANDARD_NAME NAMACC, 
                            A.NAME NAME, 
                            A.PM_NAME PM_NAME,  
                            A.VALUE VALUE,
                            PARTNERS.NO_P8,
                            HIS.DATE_CREATED LASTEST_DATE, 
                            TO_CHAR(HIS.DATE_CREATED, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED, 
                            HIS.NAME_USER UPDATED_BY, 
                            HIS.ID_USER UPDATED_BY_ID, 
                            SUBSTR(ACT.REAL,1,6) ACH,
                            SUBSTR(LAST_MONTH.REAL,1,6) LAST_ACH,
                            
                            BAST.TGL_BAST TGL_BAST,
                            BAST.NO_SPK BAST,
                            BAST.PROGRESS_LAPANGAN PROGRESS_LAPANGAN,
                            BAST.NAMA_TERMIN NAMA_TERMIN,
                            BAST.NILAI_RP_BAST BAST_VALUE,
                            BAST.TYPE_BAST TYPE_BAST,
                            TO_CHAR(BAST.RECC_START_DATE, 'MM/YYYY') RECC_START_DATE,
                            TO_CHAR(BAST.RECC_END_DATE, 'MM/YYYY') RECC_END_DATE,

                            BAST_DONE.TGL_BAST BD_TGL_BAST,
                            BAST_DONE.NO_SPK BAST_DONE,
                            BAST_DONE.TYPE_BAST BD_TYPE_BAST,
                            BAST_DONE.PROGRESS_LAPANGAN BD_PROGRESS_LAPANGAN,
                            BAST_DONE.NAMA_TERMIN BD_NAMA_TERMIN,
                            BAST_DONE.NILAI_RP_BAST BD_BAST_VALUE,
                            TO_CHAR(BAST_DONE.RECC_START_DATE, 'MM/YYYY') BD_RECC_START_DATE,
                            TO_CHAR(BAST_DONE.RECC_END_DATE, 'MM/YYYY') BD_RECC_END_DATE,
                            PARTNERS.PARTNERS PARTNERS,
                            ")
                        ->from('PRIME_PROJECT A')
                        ->join("(SELECT ID_PROJECT, NO_P8, LISTAGG(A.PARTNER_NAME, ', ') 
                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
                                  FROM PRIME_PROJECT_PARTNERS A
                                  GROUP BY ID_PROJECT, NO_P8
                                  ) PARTNERS",
                                  "PARTNERS.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT ID_PROJECT ID_PROJECT, REAL
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
                                ) A
                            ) ACT","ACT.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT ID_PROJECT ID_PROJECT, REAL
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
                                    AND UPDATE_DATE <= Last_Day(ADD_MONTHS(trunc(sysdate),-1)) 
                                    GROUP BY ID_PROJECT
                                ) A
                            ) LAST_MONTH","LAST_MONTH.ID_PROJECT = A.ID_PROJECT")
                        ->join("(
                                SELECT H1.* FROM PRIME_HISTORY H1 
                                JOIN (
                                            SELECT ID, MAX(DATE_CREATED) LATEST FROM PRIME_HISTORY 
                                            WHERE ID_USER != 'SYSTEM'
                                            GROUP BY ID 
                                           ) H2 
                                ON H1.DATE_CREATED = H2.LATEST AND H1.ID = H2.ID
                                ) HIS","HIS.ID = A.ID_PROJECT","LEFT")
                        ->join("PRIME_BAST_HGN BAST_DONE", "BAST_DONE.NO_SPK = PARTNERS.NO_P8 AND BAST_DONE.STATUS IN ('TAKE OUT','DONE','TAKE OUT (REV)')","LEFT")
                        ->join("PRIME_BAST_HGN BAST", "BAST.NO_SPK = PARTNERS.NO_P8 AND BAST.STATUS NOT IN ('TAKE OUT','DONE','TAKE OUT (REV)')","LEFT")
                        ->where_in('A.STATUS', array('LEAD','LAG','DELAY'))
                        ->where(1,1)
                        ->distinct()
                        ->get()
                        ->result_array();

      return $query;
    }

    function addLog_emailBAST($id_partner,$name_partner,$status,$reason = null){
      $this->db->set('ID_PARTNER',$id_partner);
      $this->db->set('PARTNER_NAME',$name_partner);
      $this->db->set('META',$reason);
      $this->db->set('STATUS',$status);
      return $this->db->insert('PRIME_EMAIL_BAST_LOG');
    }

}     