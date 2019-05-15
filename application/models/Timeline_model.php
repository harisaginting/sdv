<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Timeline_model extends CI_Model
{
    public function __construct() {
        parent::__construct();        
    }

    function get_feed(){ 
    	$query = $this->db
    			->select("A.*,B.*,TO_CHAR(A.DATE_EVENT, 'DD MONTH YYYY, HH24:MI') DATE_EVENT2 ")
    			->from('PRIME_POST A')
    			->join('PRIME_USERS B','B.NIK = A.PIC');

    	$regional1 =	$this->session->userdata('regional');
			if($regional1 != '0' && !empty($regional1)){
				$query = $query->where('B.REGIONAL', $regional1);
			}

    	return $query->distinct()->order_by('DATE_EVENT','DESC')->get()->result_array();
    }

    function save_post($data){
    	foreach($data as $key => $value){

                if($key=='DATE_EVENT'){
                    $this->db->set("DATE_EVENT","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else{
                    $this->db->set($key , $value);
                    
                }       
            } 
        $this->db->set('DATE_MODIFIED',"TO_DATE('".date('m/d/Y H:i')."','MM/DD/YYYY HH24:MI')",FALSE);          
        return $this->db->insert('PRIME_POST');

    }

	#DATATABLE LIST_Post
	    var $column_orderPost = array('ID','ID','ID','ID','ID','ID','ID','ID'); //set column field database for datatable orderable
	    var $column_searchPost = array('TITLE','PIC','CONTENT'); //set column field database for datatable searchable
	    var $orderPost = array('DATE_CREATED' => 'desc'); // default order
		
		public function _get_all_queryPost($source){	
				$query = $this->db
						->select('*')
						->from('PRIME_POST A')
						->join("PRIME_USERS B", "A.PIC = B.NIK")
						->where("A.CATEGORY","EVENT");

			$regional1 =    $this->session->userdata('regional');
            if($regional1 != '0' && !empty($regional1)){
                $query = $query->where('B.REGIONAL', $regional1);
            }

				return $query;
	    }

	    private function _get_datatables_queryPost($searchValue, $orderColumn, $orderDir, $getOrder,$source){

	        $this->_get_all_queryPost($source);

	        $i = 0;

	        foreach ($this->column_searchPost as $item) // loop column
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

	                if (count($this->column_searchPost) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderPost[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderPost))
	        {
	            $order = $this->orderPost;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }

	    function get_datatablesPost($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$source){
	        $this->_get_datatables_queryPost($searchValue, $orderColumn, $orderDir, $getOrder,$source);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredPost($searchValue, $orderColumn, $orderDir, $getOrder,$source){
	        $this->_get_datatables_queryPost($searchValue, $orderColumn, $orderDir, $getOrder,$source);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allPost($source){
	        $this->_get_all_queryPost($source);
	        return $this->db->count_all_results();
	    } 
	#END LIST Post

 
	#DATATABLE LIST_POINT
	    var $column_orderPoint = array('NIK','TO_NUMBER(TPOINT)'); //set column field database for datatable orderable
	    var $column_searchPoint = array('NIK','NAMA'); //set column field database for datatable searchable
	    var $orderPoint = array('TPOINT' => 'desc NULL LAST'); // default order
		
		public function _get_all_queryPoint($source){	
				$query = $this->db
						->select('*')
						->from('PRIME_USERS A')
						->join("(SELECT PIC, SUM(CASE WHEN POINT IS NULL THEN 0 ELSE POINT END) TPOINT FROM PRIME_POST GROUP BY PIC ORDER BY TPOINT DESC) B",'A.NIK = B.PIC')
						->where('A.TIPE','PROJECT_MANAGER');

				$regional1 =	$this->session->userdata('regional');
				if($regional1 != '0' && !empty($regional1)){
					$query = $query->where('A.REGIONAL', $regional1);
				}

				return $query;
	    }

	    private function _get_datatables_queryPoint($searchValue, $orderColumn, $orderDir, $getOrder,$source){

	        $this->_get_all_queryPoint($source);

	        $i = 0;

	        foreach ($this->column_searchPoint as $item) // loop column
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

	                if (count($this->column_searchPoint) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)) // here order processing
	        {	
	            $this->db->order_by($this->column_orderPoint[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderPoint))
	        {
	            $order = $this->orderPoint;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }

	    function get_datatablesPoint($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$source){
	        $this->_get_datatables_queryPoint($searchValue, $orderColumn, $orderDir, $getOrder,$source);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredPoint($searchValue, $orderColumn, $orderDir, $getOrder,$source){
	        $this->_get_datatables_queryPost($searchValue, $orderColumn, $orderDir, $getOrder,$source);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allPoint($source){ 
	        $this->_get_all_queryPoint($source);
	        return $this->db->count_all_results();
	    } 
	#END LIST Post


	// DATA POINT
	    function getDataPoint($start,$end){
	    	$query = $this->db
						->select('*')
						->from('PRIME_USERS A')
						->join("(SELECT PIC, SUM(CASE WHEN POINT IS NULL THEN 0 ELSE POINT END) TPOINT 
							FROM PRIME_POST 
							WHERE DATE_EVENT >= TO_DATE('".$start."','MM/DD/YYYY')
							AND
							DATE_EVENT <= TO_DATE('".$end."','MM/DD/YYYY')
							GROUP BY PIC ORDER BY TPOINT DESC) B",
							'A.NIK = B.PIC','LEFT')
						->where('A.TIPE','PROJECT_MANAGER')
						->where('A.DIVISI','DES')
						->order_by('TO_NUMBER(TPOINT) desc nulls last')
						->order_by('NAMA asc');
			return $query->get()->result_array();
	    }

	    function getDataPointSUM($nik,$start,$end){
	    	$query = $this->db
	    				->select('CONTENT, COUNT(1) TOTAL')
	    				->from('PRIME_POST A')
	    				->where('PIC',$nik)
	    				->where("A.DATE_EVENT >="," TO_DATE('".$start."','MM/DD/YYYY')",false)
						->where("A.DATE_EVENT <="," TO_DATE('".$end."','MM/DD/YYYY')",false)
	    				->group_by('CONTENT')
	    				->order_by('CONTENT');
	    	return $query->get()->result_array();
	    }

	    function getDataPointDetail($nik,$start,$end){
	    	$query = $this->db
	    				->select("TO_CHAR(A.DATE_EVENT, 'DD MONTH YYYY, HH24:MI') DATES, A.*")
	    				->from('PRIME_POST A')
	    				->where('PIC',$nik)
	    				->where("A.DATE_EVENT >="," TO_DATE('".$start."','MM/DD/YYYY')",false)
						->where("A.DATE_EVENT <="," TO_DATE('".$end."','MM/DD/YYYY')",false)
	    				->order_by('DATE_CREATED','desc');
	    	return $query->get()->result_array();
	    }


}

   