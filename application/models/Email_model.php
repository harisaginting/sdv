<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model
{
    public function __construct() {
    } 

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

    public function getDataNotifMitra(){
      $arr = array('TAKE OUT','DONE','TAKE OUT (REV)');
      $q = $this->db
      ->select("ID_MITRA,NAMA_MITRA")
      ->from('PRIME_BAST_HGN')
      ->group_by('ID_MITRA, NAMA_MITRA')
      ->where('EXIST', '1')
      ->where_not_in('ID_MITRA','(SELECT ID_MITRA FROM PRIME_EMAIL_BAST_LOG WHERE DATE_LOG = = (SYSDATE - 1))')
      //->where('ID_MITRA','99')
      ->order_by('ID_MITRA','asc')
      //->where_not_in('STATUS', $arr)
      ->get()->result_array();
      //echo json_encode($q) ;exit;
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


    function addLog_emailBAST($id_partner,$name_partner,$status,$reason = null){
      $this->db->set('ID_PARTNER',$id_partner);
      $this->db->set('PARTNER_NAME',$name_partner);
      $this->db->set('META',$reason);
      $this->db->set('STATUS',$status);
      return $this->db->insert('PRIME_EMAIL_BAST_LOG');
    }





}     