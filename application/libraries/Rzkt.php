<?php

class Rzkt {
	
	private $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();	
	}

	public function get_detail_segment_lname($segmen=null)
	{
		// $CI =& get_instance();
		if (!empty($segmen)) {
			$this->CI->db->where('SEGMEN',$segmen);
		}
		$this->CI->db->select('SEGMENT_6_LNAME');
        $query  =   $this->CI->db->get('CBASE_DIVES')->row_array();
        return $query['SEGMENT_6_LNAME'];
	}


	public function get_nama_cc($nipnas)
	{
		$this->CI->db->where('NIP_NAS', $nipnas);
		$data = $this->CI->db->get('CBASE_DIVES')->row_array();
		return $data;
	}
 
	public function get_list_cc($segmen=null)
	{
		if (!empty($segmen)) {
			$segmen = "AND SEGMEN='$segmen'";
		}
		$data = $this->CI->db->query("	SELECT NIP_NAS, STANDARD_NAME
							  			FROM CBASE_DIVES
							  			WHERE 1=1
							  			$segmen
							  			ORDER BY STANDARD_NAME ASC");
		return $data;
	}

	public function get_list_segmen()
	{
		$data = $this->CI->db->query("	SELECT DISTINCT SEGMEN, SEGMENT_6_LNAME
							  			FROM CBASE_DIVES
							  			ORDER BY SEGMENT_6_LNAME ASC");
		return $data;
	}

	public function get_list_segmen2()
	{
		$data = $this->CI->db->query("	SELECT DISTINCT SEGMEN
							  			FROM CBASE_DIVES
							  			ORDER BY SEGMEN ASC");
		return $data;
	}

	function get_name_employee($nik) {
		$det = $this->CI->db->query("	SELECT V_NAMA_KARYAWAN
										FROM AMDES_DEV.T_EMPLOYEE
										WHERE N_NIK='$nik'")->row_array();
		return $det['V_NAMA_KARYAWAN'];
	}

	function get_list_partner() {
		$data = $this->CI->db->query("	SELECT DISTINCT KODE_PARTNER, NAMA_PARTNER
							  			FROM PRIME_PARTNER_TATA
							  			ORDER BY NAMA_PARTNER ASC");
		return $data;
	}

	function get_list_am($nipnas=null) {
		if (!empty($nipnas)) {
			$nipnas = "AND NIPNAS='$nipnas'";
		}
		$data = $this->CI->db->query("	SELECT DISTINCT NIK, NAMA_AM
							  			FROM PRIME_AM_CC
							  			WHERE 1=1
							  			$nipnas
							  			ORDER BY NAMA_AM ASC");
		return $data;
	}

	function get_sequence($table) {
		$query = $this->CI->db->query("	SELECT $table.nextVal AS ID
										FROM DUAL")->row_array();
		return $query;
	}

	function checkStartWeek($nextMonday) {
		$now = date('Y-m-d');
		if (strtotime($nextMonday) <= strtotime($now)) {
			return true;
		}
	}

	function get_week($from, $to) {
	    $day   = 24 * 3600;
	    $from  = strtotime($from);
	    $to    = strtotime($to) + $day;
	    $diff  = abs($to - $from);
	    $weeks = round($diff / $day / 7);
	    $checkMonday = date('D', $from);
	    if ($checkMonday=="Mon") {
			$weeks = $weeks+1;
		}
	    return $weeks;
	}

	function makeList($array) {
		$output = '<ul>';
	    foreach($array as $key => $item) {
	        if (is_array($item)) {
	            $output .= '<li>'.$key;
	            $this->makeList($item);
	            $output .= '</li>';
	        } else {
	            $output .= '<li>'.$item.'</li>'; // Or use $key here as well
	        }
	    }
	    $output .= '</ul>';
	    return $output;
	}

	function picList($array){
		$output ="";
		foreach($array as $key => $item) {
	        if (is_array($item)) {
	            $output .= '- '.$key.'<br>';
	            $this->makeList($item);
	        } else {
	            $output .= '- '.$item.'<br>'; // Or use $key here as well
	        }
	    }
	    return $output;
	}

	function picListNew($array){
		$output ="";
		foreach($array as $key => $item) {
	        if (is_array($item)) {
	            $output .= '- '.$key.'';
	            $this->makeList($item);
	        } else {
	            $output .= '- '.$item.''; // Or use $key here as well
	        }
	    }
	    return $output;
	}

	function get_current_week($date) {
		$firstOfMonth = date("Y-m-01", strtotime($date));
    	return intval(date("W", strtotime($date))) - intval(date("W", strtotime($firstOfMonth)));
	}

	function remove_specific_key($arrData,$keyArr) {
		echo $keyArr;
		$cleanArr = array_map(function (array $elem) {unset($elem[$keyArr]);return $elem;},$arrData);
		return $cleanArr;
	}

	function get_count_of_week_db($id_project,$table)
	{
		$this->CI->db->select('COUNT_OF_WEEK');
		$this->CI->db->where('ID_PROJECT',$id_project);
		$query = $this->CI->db->get($table)->row_array();
		return $query['COUNT_OF_WEEK'];
	}

}

/* End of file Rzkt.php */
/* Location: ./application/libraries/Rzkt.php */