	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Project_model extends CI_Model {


		private $epicdb; 
		public function __construct()   
		{ 
			parent::__construct();
			//$this->epicdb = $this->load->database('epicdb', TRUE);
		}

		function addRequestProject($data){
			foreach($data as $key => $value){  
 
				if($key=='START_DATE'){
					$this->db->set("START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='END_DATE'){
					$this->db->set("END_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='FIRST_END_DATE'){
					$this->db->set("END_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='REQUEST_DATE'){
					$this->db->set("REQUEST_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}		 
			}

			$start_week 	= strtotime($data['START_DATE']);
			$get_start_week =  date('m/d/Y',strtotime("next monday".date('Y-m-d', $start_week), $start_week));
			$checkMonday 	= date('D', $start_week);
			if ($checkMonday=="Mon") {
				$get_start_week =  date('m/d/Y',$start_week);
			}

			$this->db->set('COUNT_OF_WEEK', $this->rzkt->get_week(date('Y-m-d', strtotime($get_start_week)), date('Y-m-d', strtotime($data['END_DATE']))));
			$this->db->set('START_WEEK_1', "to_date('".$get_start_week."','MM/DD/YYYY')",false);
			
			return $this->db->insert('PRIME_PROJECT');
		}

		function closeProject($data,$id_project){
			foreach($data as $key => $value){

                if($key=='CLOSED_DATE'){
                    $this->db->set("CLOSED_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
                    }
                else{
                    if(!empty($value)){
                        $this->db->set($key , $value);
                    } 
                }       
            }  
        $this->db->where('ID_PROJECT', $id_project);       
        return $this->db->update('PRIME_PROJECT');
		}

		function updateProject($id_project,$data){
			foreach($data as $key => $value){

				if($key=='START_DATE'){
					if(strlen($value) < 12){
						$this->db->set("START_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
						}
					}
				else if($key=='END_DATE'){
					if(strlen($value) < 12){
						$this->db->set("END_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
						}
					}
				else if($key=='ASSIGNED_DATE'){
					$this->db->set('ASSIGNED_DATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
					}
				else if($key=='PM_EXIST'){
						if(!empty($value)){
							$this->db->set('PM_EXIST' , '1');	
						}else{
							$this->db->set('PM_EXIST' , '0');	
						}
					}
				else if($key == 'MANAGE_SERVICE'){
						if(!empty($value)){
							$this->db->set('MANAGE_SERVICE' , '1');	
						}else{
							$this->db->set('MANAGE_SERVICE' , '0');	
						}
					}
				else{
					if(!empty($value)){
					$this->db->set($key , $value);	
					}				
				}		
			}



			$start_week 	= strtotime($data['START_DATE']);
			$get_start_week =  date('m/d/Y',strtotime("next monday".date('Y-m-d', $start_week), $start_week));
			$checkMonday 	= date('D', $start_week);
			if ($checkMonday=="Mon") {
				$get_start_week =  date('m/d/Y',$start_week);
			}
			$this->db->set('UPDATED_DATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$this->db->set('UPDATED_BY_ID', $this->session->userdata('nik_sess'));
			$this->db->set('UPDATED_BY_NAME', $this->session->userdata('nama_sess'));
			$this->db->set('COUNT_OF_WEEK', $this->rzkt->get_week(date('Y-m-d', strtotime($get_start_week)), date('Y-m-d', strtotime($data['END_DATE']))));
			$this->db->set('START_WEEK_1', "to_date('".$get_start_week."','MM/DD/YYYY')",false);
			$this->db->where('ID_PROJECT',$id_project);
			return $this->db->update('PRIME_PROJECT');
		}

		function addPartnersProjects($data){
			$this->db->insert('PRIME_PROJECT_PARTNERS', $data);
		}

		function deletePartnersProjects($id,$data){
			if(!empty($id)){
				$this->db->where('ID_PROJECT',$id);
				if(!empty($data)){
				$this->db->where_not_in('ID_ROW',$data);
				}
				return $this->db->delete('PRIME_PROJECT_PARTNERS');
			}else{
				return true;
			}
		}


		function updatePartnersProjects($id, $data){
			$this->db->where('ID_ROW', $id);
			$this->db->update('PRIME_PROJECT_PARTNERS', $data);
		}


		function insert_deliverable($data) {

					$this->db->set('ID_DELIVERABLE',  $data['ID_DELIVERABLE']);
					$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
					$this->db->set('NAME',  $data['NAME']);
					$this->db->set('WEIGHT',  $data['WEIGHT']);
					$this->db->set('DESCRIPTION',  $data['DESCRIPTION']);
					$this->db->set('START_DATE', "to_date('".$data['START_DATE']."','MM/DD/YYYY')",false);
					$this->db->set('END_DATE', "to_date('".$data['END_DATE']."','MM/DD/YYYY')",false);
					$this->db->set('INSERTED_BY_ID',  $data['INSERTED_BY_ID']);
					$this->db->set('INSERTED_BY_NAME',  $data['INSERTED_BY_NAME']);
					$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
					$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
					
					if (!empty($data['ATTACHMENT'])) {
						$this->db->set('ATTACHMENT',  $data['ATTACHMENT']); 
					}

					$query =  $this->db->insert('PRIME_PROJECT_DELIVERABLES');
					$id_project = $data['ID_PROJECT'];

					//echo $this->db->last_query();
					$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");

					return $query;
		}

		function deleteDeliverable($id_project,$id_deliverable){
			$this->db->where('ID_DELIVERABLE',$id_deliverable);
			if($this->db->delete('PRIME_PROJECT_DELIVERABLES')){
				$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");
				return true;
			}
			return false;
		}

		function updateDeliverable($data) {
					$idPro = $data['ID_PROJECT'];

					$idDev = $data['ID_DELIVERABLE'];
					$this->db->set('NAME',  $data['NAME']);
					$this->db->set('WEIGHT',  $data['WEIGHT']);
					$this->db->set('DESCRIPTION',  $data['DESCRIPTION']);
					$this->db->set('PROGRESS_VALUE',$data['PROGRESS_VALUE']);
					$this->db->set('START_DATE', "to_date('".$data['START_DATE']."','MM/DD/YYYY')",false);
					$this->db->set('END_DATE', "to_date('".$data['END_DATE']."','MM/DD/YYYY')",false);
					$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
					$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
					if (!empty($data['ATTACHMENT'])) {
						$this->db->set('ATTACHMENT',  $data['ATTACHMENT']); 
					}

					$this->db->where('ID_DELIVERABLE', $data['ID_DELIVERABLE']);
					$query = $this->db->update('PRIME_PROJECT_DELIVERABLES');

					// call procedure
					$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$idPro')");
					$this->db->query("BEGIN PRIME_MONITORING_PROJECT_PROC; END;");
					return $query;
				}


	##DETAIL PROJECT 
	    function get_detail_project($id = null ,$id_lop = null) {
	    		/*if(empty($id)&&empty($id_lop)){
	    			$data = array();
	    			return $data;
	    		}*/

				// get project list
	    		$this->db->select("PRIME_PROJECT.*, TO_CHAR(START_DATE, 'DD MONTH YYYY') START_DATE2, TO_CHAR(END_DATE, 'DD MONTH YYYY') END_DATE2, TO_CHAR(UPDATED_DATE, 'DD MONTH YYYY') UPDATED_DATE2, START_DATE START_DATEX");
				if(!empty($id)){
					$this->db->where('ID_PROJECT', $id);
				}

				if(!empty($id_lop)){
					$this->db->where('ID_LOP_EPIC', $id_lop);
				}

				$data = $this->db->get('PRIME_PROJECT')->row_array();

				// get partnert list
				$data['partners'] 	= 	$this->db
						->select("A.*, CASE WHEN LINK_P8 LIKE '%../%' THEN 'https://prime.telkom.co.id/'||LINK_P8  ELSE LINK_p8 END LINK_P82")
						->from('PRIME_PROJECT_PARTNERS A')
						->where('ID_PROJECT',$id)
						->get()
						->result_array();
				$data['quote_so'] 	= 	$this->db
						->select("A.*")
						->from('PRIME_NO_QUOTE_SO A')
						->join('PRIME_PROJECT B','A.ID_LOP = B.ID_LOP_EPIC')
						->where('B.ID_PROJECT',$id)
						->where('A.VALID',1)
						->get()
						->result_array();
				return $data;
		}

		function get_all_no_quote($id){
			$q 	= 	$this->db
						->select("A.*")
						->from('PRIME_NO_QUOTE_SO A')
						->where('A.ID_LOP',$id)
						//->where('A.VALID',1)
						->get()
						->result_array();

			return $q;
		}

		public function get_detail_project2($id){
	    	$q = $this->db
				->select("PROJ.*, PART.ID_ROW, CURV.ACH ACH")
				->from('PRIME_PROJECT PROJ')
				->where('PROJ.ID_PROJECT',$id)
				->join('PRIME_PROJECT_PARTNERS_TATA PART','PROJ.ID_PROJECT = PART.ID_PROJECT',"LEFT")
				->join('(SELECT DISTINCT ID_PROJECT, MAX(REAL) ACH FROM PRIME_PROJECT_S_CURVE_WEEK GROUP BY ID_PROJECT) CURV', 
					'PART.ID_PROJECT = CURV.ID_PROJECT',"LEFT")
				->get()->row();

				//echo $this->db->last_query().' - '.json_encode($q);die;
				return $q;
	   	}

		function get_list_issue($id_project) {
				$this->db->where('ID_PROJECT', $id_project);
				$this->db->where('STATUS_ISSUE <> ', 'CLOSED');
				return $this->db->get('_PROJECT_ISSUE');
		}

		function sum_deliverable_weight_ach($id_project) {
					$query = $this->db->query("	SELECT  100-NVL(SUM(WEIGHT),0) WEIGHT, 100-NVL(SUM(PROGRESS_VALUE),0) ACH,NVL(SUM(WEIGHT),0) WEIGHT_ALL
												FROM {PRE}_PROJECT_DELIVERABLES
												WHERE ID_PROJECT='$id_project'")->row_array();
					return $query;
		}


		function get_sum_weight_realization($id_project) {
				return $this->db->query("	SELECT SUM(WEIGHT) TOTAL_WEIGHT, SUM(PROGRESS_VALUE) REAL
											FROM PRIME_PROJECT_DELIVERABLES
											WHERE ID_PROJECT='$id_project'")->row_array();
		}

		function get_curva_s($id_project) {
			$query = $this->db->query("	SELECT 'WEEK #'||NVL(WEEK,0) WEEKS, NVL(PLAN,0) PLAN,REAL, PERIODE
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

		function get_list_document($id_project) {
			$data = $this->db->query("	SELECT A.DOC_SPK,A.DOC_RFP,A.DOC_PROPOSAL,A.DOC_AANWIZING, A.DOC_BAKN_PB,
										       A.CLOSED_EVIDENCE, A.DOC_KB, A.DOC_KL, B.ACTION_EVIDENCE, 
										       C.DELIVERABLES_DOC
										FROM
										(
										    SELECT ID_PROJECT,DOC_SPK,DOC_RFP,DOC_PROPOSAL,DOC_AANWIZING,DOC_BAKN_PB,
										           CLOSED_EVIDENCE,DOC_KB,DOC_KL
										    FROM PRIME_PROJECT
										    WHERE ID_PROJECT='$id_project'
										) A,
										(
										    SELECT ID_PROJECT,ACTION_EVIDENCE
										    FROM PRIME_PROJECT_ACTION_PLAN
										    WHERE ID_PROJECT='$id_project'
										    AND TRIM(ACTION_EVIDENCE) IS NOT NULL
										) B,
										(
										    SELECT ID_PROJECT,ATTACHMENT DELIVERABLES_DOC
										    FROM PRIME_PROJECT_DELIVERABLES
										    WHERE ID_PROJECT='$id_project'
										    AND TRIM(ATTACHMENT) IS NOT NULL
										) C
										WHERE A.ID_PROJECT=B.ID_PROJECT(+)
										AND A.ID_PROJECT = C.ID_PROJECT(+)");
			return $data;
		}

		function get_partners($id_project){
				return $this->db->query("	SELECT LISTAGG(PARTNER_NAME||' <br>['||NO_P8||']', '<br><br>') WITHIN GROUP (ORDER BY ID_PROJECT) AS PARTNERS
											FROM PRIME_PROJECT_PARTNERS
											WHERE ID_PROJECT='$id_project'
											GROUP BY ID_PROJECT")->result_array();
		}

		function get_last_updated_by($id) {
				$query =$this->db
						->select("A.*, TO_CHAR(A.DATE_CREATED, 'HH24:MI:SS') TIME")
						->from('PRIME_HISTORY A')
						->join('(
						            SELECT ID, MAX(DATE_CREATED) L FROM PRIME_HISTORY GROUP BY ID
						        ) B','B.ID = A.ID AND A.DATE_CREATED = B.L')
						->where('A.ID',$id)
						->get()
						->row_array();

				return $query;
		}


		function get_detail_deliverable($id_dev) {
					$query = $this->db->query("SELECT ID_DELIVERABLE,A.ID_PROJECT,A.NAME,TO_CHAR(WEIGHT,'900.00') WEIGHT,TO_CHAR(A.START_DATE,'MM/DD/YYYY') START_DATE,
												       TO_CHAR(A.END_DATE,'MM/DD/YYYY') END_DATE,A.DESCRIPTION, A.PROGRESS_VALUE, B.ID_LOP_EPIC, STATUS, REASON_OF_DELAY, A.ATTACHMENT, TO_CHAR(A.LAST_UPDATE, 'DD MONTH YYYY, HH24:MI') LAST_UPDATE2
												FROM PRIME_PROJECT_DELIVERABLES A, PRIME_PROJECT B
												WHERE A.ID_PROJECT = B.ID_PROJECT
												AND ID_DELIVERABLE='{$id_dev}'")->row_array();
					return $query;
				}

	##END DETAIL PROJECT 
 
	##DATATABLE LIST_ACTIVE
	    var $column_orderActive = array('SEQ','A.NAME','A.VALUE','ACH','A.END_DATE','UPDATED_DATE',null); //set column field database for datatable orderable
	    var $column_searchActive = array('A.ID_PROJECT','UPPER(A.NAME)','UPPER(A.STANDARD_NAME)','UPPER(PARTNERS)','UPPER(A.TYPE)','UPPER(A.SEGMEN)','UPPER(A.NIP_NAS)','UPPER(A.PM_NAME)','A.STATUS',' A.ID_LOP_EPIC','A.NO_QUOTE'); //set column field database for datatable searchable
	    var $orderActive = array('SEQ', 'desc'); // default order
		
		public function _get_all_queryActive($status,$pm,$customer,$partner,$type,$regional,$segmen){
			//$regional =	$this->session->userdata('regional');
			$arr = array('LAG','LEAD','DELAY','CANCEL');
			$query = $this->db
							/*->select('A.ID_PROJECT')*/
							->select("CASE A.STATUS WHEN 'LEAD' THEN 'success' WHEN 'LAG' THEN 'warning' ELSE 'danger' END INDICATOR, TO_NUMBER(SUBSTR(A.ID_PROJECT, 5,7)) SEQ, A.UPDATED_DATE,B.PARTNERS, A.ID_PROJECT ,A.NAME, A.TYPE ,A.PM_NAME ,A.DESCRIPTION , A.NIP_NAS NIP_NAS, A.STANDARD_NAME , A.SEGMEN , A.AM_NIK , A.AM_NAME , NVL(C.PLAN,0) WEIGHT, NVL(C.ACH,0) ACH, A.VALUE VALUE,A.STATUS STATUS, A.END_DATE, A.REASON_OF_DELAY, A.NO_QUOTE, A.ID_LOP_EPIC, TO_CHAR(A.END_DATE,'DD-MM-YYYY') END_DATE2, TO_CHAR(A.START_DATE,'DD-MM-YYYY') START_DATE2
								, CASE WHEN A.STATUS = 'DELAY' THEN (((100 - TO_NUMBER(C.ACH)) / 100) * A.VALUE) WHEN C.ACH > C.PLAN THEN ((100 - TO_NUMBER(C.ACH))/100) * A.VALUE ELSE (((TO_NUMBER(NVL(C.PLAN,0)) - TO_NUMBER(C.ACH)) /100) * A.VALUE) END POTENTIAL_WEEK, (((100 - TO_NUMBER(C.ACH)) / 100) * A.VALUE) POTENTIAL ")
							->from('PRIME_PROJECT A')
							->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
									  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
									  FROM PRIME_PROJECT_PARTNERS A
									  GROUP BY ID_PROJECT
									  ) B",
									  "B.ID_PROJECT = A.ID_PROJECT","LEFT")
							->join("PRIME_MONITORING_PROJECT C","A.ID_PROJECT = C.ID_PROJECT","LEFT")
							->where('PM_EXIST','1')
							->where("A.EXIST","1")
							->where_in('A.STATUS',$arr);

					if(!empty($this->session->userdata("mitra_name"))){
						$query = $query->like('PARTNERS',$this->session->userdata("mitra_name"));
					}
 
					if($this->session->userdata('tipe_sess') == 'PROJECT_MANAGER' ){
						$nik_pm = $this->session->userdata('nik_sess');
						$query = $query->where('A.PM_NIK', $nik_pm);
					}

					$regional1 =	$this->session->userdata('regional');
					if($regional1 != '0' && !empty($regional1)){
						$query = $query->where('A.REGIONAL', $regional1);
					}

					if($status != null){
						$query = $query->where('A.STATUS',$status);
					}
					if($pm != null){
						$query = $query->where('A.PM_NIK',$pm);
					}
					if($type != null){
						$query = $query->where('A.TYPE',$type);
					}
					if($customer != null){
						$query = $query->where('A.NIP_NAS',$customer);
					}
					if($regional != null){
						$query = $query->where('A.REGIONAL',$regional);
					}
					if($segmen != null){
						$query = $query->where('A.SEGMEN',$segmen);
					}

					return $query;

	    }

	    private function _get_datatables_queryActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){

	        $this->_get_all_queryActive($status,$pm,$customer,$partner,$type,$regional,$segmen);

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
	        
	        return $query->result();
	    }

	    function count_filteredActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_datatables_queryActive($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allActive($status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_all_queryActive($status,$pm,$customer,$partner,$type,$regional,$segmen);
	        return $this->db->count_all_results();
	    }
	#END LIST ACTIVE
		

	##DELIVERABLE DATATABLE
		#DATATABLE LIST
	    var $column_orderDeliverable= array('Z.ID_DELIVERABLE','Z.NAME','Z.DESCRIPTION','Z.START_DATE','Z.END_DATE','Z.WEIGHT','Z.PROGRESS_VALUE','Z.LAST_UPDATE'); //set column field database for datatable orderable
	    var $column_searchDeliverable = array('Z.NAME','Z.DESCRIPTION','Z.ID_DELIVERABLE'); //set column field database for datatable searchable
	    var $orderDeliverable = array('Z.ID_DELIVERABLE' => 'asc'); // default order
		
		public function _get_all_queryDeliverable($id_project){	
				$query = $this->db->select("Z.*, TO_CHAR(Z.WEIGHT,'900.00') WEIGHT2, TO_CHAR(TO_NUMBER(Z.PROGRESS_VALUE),'900.00') PROGRESS, TO_CHAR(Z.START_DATE,'DD MON YYYY') START1, TO_CHAR(Z.END_DATE,'DD MON YYYY') END1")
									->from('PRIME_PROJECT_DELIVERABLES PROJECT')	
									->join("				
													(
													    SELECT ID_DELIVERABLE, ID_PROJECT, NAME, WEIGHT,  START_DATE, DESCRIPTION, END_DATE,PROGRESS_VALUE, 'info' INDIKATOR, ATTACHMENT,LAST_UPDATE
													    FROM PRIME_PROJECT_DELIVERABLES
													    WHERE WEIGHT<=PROGRESS_VALUE
													    UNION
													    SELECT ID_DELIVERABLE, ID_PROJECT, NAME, WEIGHT,  START_DATE, DESCRIPTION, END_DATE,PROGRESS_VALUE, 'warning' INDIKATOR, ATTACHMENT,LAST_UPDATE
													    FROM PRIME_PROJECT_DELIVERABLES
													    WHERE NVL(WEIGHT,0) > NVL(PROGRESS_VALUE,0)
													    AND (TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (END_DATE, 'YYYYMMDD'))
													    AND (TO_CHAR (END_DATE, 'YYYYMMDD')-TO_CHAR (SYSDATE, 'YYYYMMDD')) <= 
													    (
													        SELECT MAX_DUE_DATE
													        FROM PRIME_SETTING
													    )
													    UNION
													    SELECT ID_DELIVERABLE, ID_PROJECT, NAME, WEIGHT,  START_DATE, DESCRIPTION, END_DATE,PROGRESS_VALUE, 'danger' INDIKATOR, ATTACHMENT,LAST_UPDATE
													    FROM PRIME_PROJECT_DELIVERABLES
													    WHERE NVL(WEIGHT,0) > NVL(PROGRESS_VALUE,0)
													    AND (TO_CHAR (END_DATE, 'YYYYMMDD') < TO_CHAR (SYSDATE, 'YYYYMMDD'))
													    UNION
													    SELECT ID_DELIVERABLE, ID_PROJECT, NAME, WEIGHT,  START_DATE, DESCRIPTION, END_DATE,PROGRESS_VALUE, 'success' INDIKATOR, ATTACHMENT,LAST_UPDATE
													    FROM PRIME_PROJECT_DELIVERABLES
													    WHERE NVL(WEIGHT,0) > NVL(PROGRESS_VALUE,0)
													    AND (TO_CHAR (END_DATE, 'YYYYMMDD') - TO_CHAR (SYSDATE, 'YYYYMMDD')) > 
													    (
													        SELECT MAX_DUE_DATE
													        FROM PRIME_SETTING
													    )
													    UNION
												        SELECT ID_DELIVERABLE, ID_PROJECT, NAME, WEIGHT,  START_DATE, DESCRIPTION, END_DATE,PROGRESS_VALUE, '' INDIKATOR, ATTACHMENT,LAST_UPDATE
												        FROM PRIME_PROJECT_DELIVERABLES
												        WHERE PROGRESS_VALUE < WEIGHT
												        AND (START_DATE IS NULL OR END_DATE IS NULL)
													) Z",
													"Z.ID_DELIVERABLE = PROJECT.ID_DELIVERABLE")
									->where('Z.ID_PROJECT',$id_project);
				return $query;
	    }

	    private function _get_datatables_queryDeliverable($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){

	        $this->_get_all_queryDeliverable($id_project);

	        $i = 0;

	        foreach ($this->column_searchDeliverable as $item) // loop column
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

	                if (count($this->column_searchDeliverable) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderDeliverable[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderDeliverable))
	        {
	            $order = $this->orderDeliverable;
	            $this->db->order_by(key($order), $orderDir);
	        }
	    }

	    function get_datatablesDeliverable($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryDeliverable($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	//] echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredDeliverable($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryDeliverable($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allDeliverable($id_project){
	        $this->_get_all_queryDeliverable($id_project);
	        return $this->db->count_all_results();
	    }
	    #END LIST DELIVERABLE	
		
	##END DELIVERABLE DATATABLE


	##DATATABLES ISSSUE
	    var $column_orderIssue= array('ISSUE_NAME','IMPACT','RISK_IMPACT','STATUS_ISSUE','MITIGATION_PLAN',null); //set column field database for datatable orderable
	    var $column_searchIssue = array('ISSUE_NAME','IMPACT','RISK_IMPACT','STATUS_ISSUE','MITIGATION_PLAN'); //set column field database for datatable searchable
	    var $orderIssue = array('ISSUE_CLOSED_DATE' => 'desc'); // default order
		
		public function _get_all_queryIssue($id_project){
				$query = $this->db->select("A.ID_ISSUE, A.ID_PROJECT, A.ISSUE_NAME, A.RISK_IMPACT, A.STATUS_ISSUE,
												    	   A.MITIGATION_PLAN, A.IMPACT, TO_CHAR(A.ISSUE_CLOSED_DATE,'DD/MM/YYYY') ISSUE_CLOSED_DATE, A.ID_DELIVERABLE")
									->from("PRIME_PROJECT_ISSUE A")										
									->join("PRIME_PROJECT_ACTION_PLAN B","A.ID_ISSUE = B.ID_ISSUE","LEFT")
									->where('A.ID_PROJECT',$id_project)
									->distinct();
				return $query;
	    }

	    private function _get_datatables_queryIssue($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){

	        $this->_get_all_queryIssue($id_project);

	        $i = 0;

	        foreach ($this->column_searchIssue as $item) // loop column
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

	                if (count($this->column_searchIssue) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderIssue[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderIssue))
	        {
	            $order = $this->orderIssue;
	            $this->db->order_by(key($order), $orderDir);
	        }
	    }

	    function get_datatablesIssue($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryIssue($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredIssue($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryIssue($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allIssue($id_project){
	        $this->_get_all_queryIssue($id_project);
	        return $this->db->count_all_results();
	    }

	##END DATATABLES ISSUE

	#DATATABLE LIST ACTION PLAN
	    var $column_orderActionPlan= array('A.ACTION_NAME','A.ISSUE_NAME','A.DUE_DATE','A.ACTION_REMARKS','A.RISK_IMPACT','A.LAST_UPDATE'); //set column field database for datatable orderable
	    var $column_searchActionPlan = array('A.ACTION_NAME','A.ISSUE_NAME','A.DUE_DATE','A.ACTION_REMARKS','A.RISK_IMPACT'); //set column field database for datatable searchable
	    var $orderActionPlan = array('A.DUE_DATE' => 'desc'); // default order
		
		public function _get_all_queryActionPlan($id_project){
				
				/*$query = $this->db->select('A.*')
									->from('PRIME_PROJECT_ACTION_PLAN ACTION')	
									->join("	(
													        SELECT A.ID_PROJECT, B.ID_ACTION_PLAN,A.ISSUE_NAME, A.RISK_IMPACT, 'warning' INDIKATOR, 
													               B.ACTION_NAME, B.ACTION_REMARKS, B.ACTION_STATUS, TO_CHAR(B.DUE_DATE,'DD/MM/YYYY') DUE_DATE
													        FROM PRIME_PROJECT_ISSUE A, PRIME_PROJECT_ACTION_PLAN B
													        WHERE A.ID_ISSUE = B.ID_ISSUE
													        AND B.ACTION_STATUS <> 'CLOSED'
													        AND (TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (B.DUE_DATE, 'YYYYMMDD'))
													        AND (TO_CHAR (B.DUE_DATE, 'YYYYMMDD')-TO_CHAR (SYSDATE, 'YYYYMMDD')) <= 
													        (
													            SELECT MAX_DUE_DATE
													            FROM PRIME_SETTING
													        )
													        UNION
													        SELECT A.ID_PROJECT, B.ID_ACTION_PLAN,A.ISSUE_NAME, A.RISK_IMPACT, 'danger' INDIKATOR, 
													               B.ACTION_NAME, B.ACTION_REMARKS, B.ACTION_STATUS, TO_CHAR(B.DUE_DATE,'DD/MM/YYYY') DUE_DATE
													        FROM PRIME_PROJECT_ISSUE A, PRIME_PROJECT_ACTION_PLAN B
													        WHERE A.ID_ISSUE = B.ID_ISSUE
													        AND B.ACTION_STATUS <> 'CLOSED'
													        AND (TO_CHAR (B.DUE_DATE, 'YYYYMMDD') < TO_CHAR (SYSDATE, 'YYYYMMDD'))
													        UNION
													        SELECT A.ID_PROJECT, B.ID_ACTION_PLAN,A.ISSUE_NAME, A.RISK_IMPACT, 'success' INDIKATOR, 
													               B.ACTION_NAME, B.ACTION_REMARKS, B.ACTION_STATUS, TO_CHAR(B.DUE_DATE,'DD/MM/YYYY') DUE_DATE
													        FROM PRIME_PROJECT_ISSUE A, PRIME_PROJECT_ACTION_PLAN B
													        WHERE A.ID_ISSUE = B.ID_ISSUE
													        AND B.ACTION_STATUS <> 'CLOSED'
													        AND (TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (B.DUE_DATE, 'YYYYMMDD'))
													        AND (TO_CHAR (B.DUE_DATE, 'YYYYMMDD')-TO_CHAR (SYSDATE, 'YYYYMMDD')) > 
													        (
													            SELECT MAX_DUE_DATE
													            FROM PRIME_SETTING
													        )
													    UNION
													    (
													        SELECT ID_PROJECT, ID_ACTION_PLAN, '' ISSUE_NAME, '' RISK_IMPACT, 'warning' INDIKATOR, 
													               ACTION_NAME, ACTION_REMARKS, ACTION_STATUS, TO_CHAR(DUE_DATE,'DD/MM/YYYY') DUE_DATE
													        FROM PRIME_PROJECT_ACTION_PLAN
													        WHERE TRIM(ID_ISSUE) IS NULL
													        AND ACTION_STATUS <> 'CLOSED'
													        AND (TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (DUE_DATE, 'YYYYMMDD'))
													        AND (TO_CHAR (DUE_DATE, 'YYYYMMDD')-TO_CHAR (SYSDATE, 'YYYYMMDD')) <= 
													        (
													            SELECT MAX_DUE_DATE
													            FROM PRIME_SETTING
													        )
													        UNION
													        SELECT ID_PROJECT, ID_ACTION_PLAN, '' ISSUE_NAME, '' RISK_IMPACT, 'danger' INDIKATOR, 
													               ACTION_NAME, ACTION_REMARKS, ACTION_STATUS, TO_CHAR(DUE_DATE,'DD/MM/YYYY') DUE_DATE
													        FROM PRIME_PROJECT_ACTION_PLAN
													        WHERE TRIM(ID_ISSUE) IS NULL
													        AND ACTION_STATUS <> 'CLOSED'
													        AND (TO_CHAR (DUE_DATE, 'YYYYMMDD') < TO_CHAR (SYSDATE, 'YYYYMMDD'))
													        UNION
													        SELECT ID_PROJECT, ID_ACTION_PLAN, '' ISSUE_NAME, '' RISK_IMPACT, 'success' INDIKATOR, 
													               ACTION_NAME, ACTION_REMARKS, ACTION_STATUS, TO_CHAR(DUE_DATE,'DD/MM/YYYY') DUE_DATE
													        FROM PRIME_PROJECT_ACTION_PLAN
													        WHERE TRIM(ID_ISSUE) IS NULL
													        AND ACTION_STATUS <> 'CLOSED'
													        AND (TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (DUE_DATE, 'YYYYMMDD'))
													        AND (TO_CHAR (DUE_DATE, 'YYYYMMDD')-TO_CHAR (SYSDATE, 'YYYYMMDD')) > 
													        (
													            SELECT MAX_DUE_DATE
													            FROM PRIME_SETTING
													        )
													    )
													) A",
													"A.ID_ACTION_PLAN = ACTION.ID_ACTION_PLAN")
									->where('ACTION.ID_PROJECT',$id_project);*/
				$query = $this->db
							->select('A.*,B.ISSUE_NAME, B.RISK_IMPACT')
							->from('PRIME_PROJECT_ACTION_PLAN A')
							->join('PRIME_PROJECT_ISSUE B', 'A.ID_ISSUE = B.ID_ISSUE','LEFT')
							->where('A.ACTION_STATUS !=', 'CLOSED')
							->where('A.ID_PROJECT',$id_project);


				return $query;
	    }

	    private function _get_datatables_queryActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){

	        $this->_get_all_queryActionPlan($id_project);

	        $i = 0;

	        foreach ($this->column_searchActionPlan as $item) // loop column
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

	                if (count($this->column_searchActionPlan) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderActionPlan[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderActionPlan))
	        {
	            $order = $this->orderActionPlan;
	            $this->db->order_by(key($order), $orderDir);
	        }
	    }

	     function get_datatablesActionPlan($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allActionPlan($id_project){
	        $this->_get_all_queryActionPlan($id_project);
	        return $this->db->count_all_results();
	    }  
	#END LIST ACTION PLAN


	#DATATABLE HISTORY ACTION PLAN
	    var $column_orderHisActionPlan= array('A.ACTION_NAME','A.ISSUE_NAME','A.DUE_DATE','A.ACTION_CLOSED_DATE','A.ACTION_REMARKS','A.ACTION_STATUS','A.RISK_IMPACT'); //set column field database for datatable orderable
	    var $column_searchHisActionPlan = array('A.ACTION_NAME','A.ISSUE_NAME','A.ACTION_REMARKS','A.ACTION_STATUS','A.RISK_IMPACT'); //set column field database for datatable searchable
	    var $orderHisActionPlan = array('A.ACTION_CLOSED_DATE' => 'desc'); // default order
		
		public function _get_all_queryHisActionPlan($id_project){
				
				$query = $this->db->select('A.*')
									->from('PRIME_PROJECT_ACTION_PLAN ACTION')	
									->join("(
														SELECT A.ID_PROJECT, B.ID_ACTION_PLAN,A.ISSUE_NAME, A.RISK_IMPACT, 
												        B.ACTION_NAME, B.ACTION_REMARKS, B.ACTION_STATUS, DUE_DATE,ACTION_CLOSED_DATE
												        FROM PRIME_PROJECT_ISSUE A, PRIME_PROJECT_ACTION_PLAN B 
												        WHERE A.ID_ISSUE = B.ID_ISSUE
												        AND B.ACTION_STATUS='CLOSED'
												        UNION
												        SELECT ID_PROJECT, ID_ACTION_PLAN,'' ISSUE_NAME, '' RISK_IMPACT, 
												               ACTION_NAME, ACTION_REMARKS, ACTION_STATUS, DUE_DATE,ACTION_CLOSED_DATE
												        FROM PRIME_PROJECT_ACTION_PLAN
												        WHERE TRIM(ID_ISSUE) IS NULL        
											) A
													","A.ID_ACTION_PLAN = ACTION.ID_ACTION_PLAN")
									->where('ACTION.ACTION_STATUS',"CLOSED")
									->where('ACTION.ID_PROJECT',$id_project);
				return $query;
	    }

	    private function _get_datatables_queryHisActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){

	        $this->_get_all_queryHisActionPlan($id_project);

	        $i = 0;

	        foreach ($this->column_searchHisActionPlan as $item) // loop column
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

	                if (count($this->column_searchHisActionPlan) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderHisActionPlan[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderHisActionPlan))
	        {
	            $order = $this->orderHisActionPlan;
	            $this->db->order_by(key($order), $orderDir);
	        }
	    }

	     function get_datatablesHisActionPlan($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryHisActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredHisActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project){
	        $this->_get_datatables_queryHisActionPlan($searchValue, $orderColumn, $orderDir, $getOrder,$id_project);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allHisActionPlan($id_project){
	        $this->_get_all_queryHisActionPlan($id_project);
	        return $this->db->count_all_results();
	    }
	#END LIST HISTORY ACTION PLAN


	#DATATABLE LIST_CANDIDATE
	    var $column_orderCandidate = array('A.REQUEST_DATE','NAME','STANDARD_NAME','NO_P8','TO_NUMBER(VALUE)','ID_LOP_EPIC',null); //set column field database for datatable orderable
	    var $column_searchCandidate = array('A.ID_PROJECT','UPPER(A.NAME)','UPPER(A.STANDARD_NAME)','UPPER(A.SEGMEN)','UPPER(A.NO_SPK_CC)','UPPER(ID_LOP_EPIC)','B.NO_P8','A.NO_QUOTE'); //set column field database for datatable searchable
	    var $orderCandidate = array('A.ID_LOP_EPIC' => 'desc'); // default order
		
		public function _get_all_queryCandidate($source){	
				if(!empty($source)){
					$query = $this->db
					->select("A.*, B.LINK_P8, B.NO_P8 NO_P8_2,B.PARTNER_NAME,
								ROW_NUMBER() OVER(ORDER BY A.ID_PROJECT DESC) XRNUM")
					->from("PRIME_PROJECT A")
					->join("PRIME_PROJECT_PARTNERS B","A.ID_PROJECT = B.ID_PROJECT","LEFT")
					->where_in("A.EXIST","1")
					->where_in('STATUS', array('PROJECT CANDIDATE','REQUEST'))
					->where('SOURCE_PROJECT',$source);
				}else{
					$query = $this->db
					->select("A.*, B.LINK_P8, B.NO_P8 NO_P8_2, B.PARTNER_NAME,
								ROW_NUMBER() OVER(ORDER BY A.ID_PROJECT DESC) XRNUM")
					->from("PRIME_PROJECT A")
					->join("PRIME_PROJECT_PARTNERS B","A.ID_PROJECT = B.ID_PROJECT","LEFT")
					->where_in("A.EXIST","1")
					->where_in('STATUS', array('PROJECT CANDIDATE','REQUEST'));
				}
 
				return $query;
	    }

	    private function _get_datatables_queryCandidate($searchValue, $orderColumn, $orderDir, $getOrder,$source){

	        $this->_get_all_queryCandidate($source);

	        $i = 0;

	        foreach ($this->column_searchCandidate as $item) // loop column
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

	                if (count($this->column_searchCandidate) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderCandidate[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderCandidate))
	        {
	            $order = $this->orderCandidate;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }

	    function get_datatablesCandidate($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$source){
	        $this->_get_datatables_queryCandidate($searchValue, $orderColumn, $orderDir, $getOrder,$source);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredCandidate($searchValue, $orderColumn, $orderDir, $getOrder,$source){
	        $this->_get_datatables_queryCandidate($searchValue, $orderColumn, $orderDir, $getOrder,$source);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allCandidate($source){
	        $this->_get_all_queryCandidate($source);
	        return $this->db->count_all_results();
	    } 
	#END LIST CANDIDATE

	#DATATABLE LIST_CLOSED
	    var $column_orderClosed = array('TO_NUMBER(SUBSTR(A.ID_PROJECT, 5,7)) SEQ','NAME','AM_NAME','PM_NAME','TYPE','VALUE',"CLOSED_DATE",'UPDATED_DATE'); //set column field database for datatable orderable
	    var $column_searchClosed = array('A.ID_PROJECT','NAME'); //set column field database for datatable searchable
	    var $orderClosed = array('SEQ' => 'desc'); // default order
		
		public function _get_all_queryClosed($status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded){
				if($this->session->userdata('tipe_sess') == 'PROJECT_MANAGER' ){
				$nama_pm = $this->session->userdata('nama_sess');
					$query = $this->db
						->select("TO_NUMBER(SUBSTR(ID_PROJECT, 5,7)) SEQ, A.*,
									ROW_NUMBER() OVER(ORDER BY ID_PROJECT DESC) XRNUM")
						->from("PRIME_PROJECT A")
						->where(1,1)
						->where('PM_NAME',$nama_pm)
						->where("EXIST",'1')
						->where('STATUS', 'CLOSED');

				}else if($this->session->userdata('tipe_sess')=='SUBSIDIARY'){
					$query = $this->db
						->select("TO_NUMBER(SUBSTR(A.ID_PROJECT, 5,7)) SEQ, A.*,
									ROW_NUMBER() OVER(ORDER BY A.ID_PROJECT DESC) XRNUM")
						->from("PRIME_PROJECT A")
						->join("PRIME_PROJECT_PARTNERS B","A.ID_PROJECT = B.ID_PROJECT")
						->where(1,1)
						->where("EXIST",'1')
						->where('STATUS', 'CLOSED');
				}else{
					$query = $this->db
						->select("TO_NUMBER(SUBSTR(ID_PROJECT, 5,7)) SEQ, A.*,
									ROW_NUMBER() OVER(ORDER BY ID_PROJECT DESC) XRNUM")
						->from("PRIME_PROJECT A")
						->where(1,1)
						->where("EXIST",'1')
						->where('STATUS', 'CLOSED');

				}

					$regional1 =	$this->session->userdata('regional');
					if($regional1 != '0' && !empty($regional1)){
						$query = $query->where('REGIONAL', $regional1);
					}
					
					if($status != null){
						$query = $query->where('STATUS',$status);
					}
					
					if($pm != null){
						if($pm=='x'){
							$query = $query->where("PM_NIK IS NULL");
						}else{
							$query = $query->where('PM_NIK',$pm);
						}
						
					}else{
						$query = $query->where("PM_NIK IS NOT NULL");
					}


					if($type != null){
						$query = $query->where('TYPE',$type);
					}
					if($customer != null){
						$query = $query->where('NIP_NAS',$customer);
					}
					if($regional != null){
						$query = $query->where('REGIONAL',$regional);
					}
					if($segmen != null){
						$query = $query->where('SEGMEN',$segmen);
					}

					if(!empty($escorded)&&$escorded=='1'){
						$query = $query->where("MANAGE_SERVICE",1);
					}

					if(!empty($escorded)&&$escorded=='x'){
						$query = $query->where("MANAGE_SERVICE",0);
					}	
				
				return $query;
	    }

	    private function _get_datatables_queryClosed($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded){

	        $this->_get_all_queryClosed($status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded);

	        $i = 0;

	        foreach ($this->column_searchClosed as $item) // loop column
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

	                if (count($this->column_searchClosed) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderClosed[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderClosed))
	        {
	            $order = $this->orderClosed;
	            $this->db->order_by(key($order), $orderDir);
	        }
	    }

	    function get_datatablesClosed($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded){
	        $this->_get_datatables_queryClosed($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredClosed($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded){
	        $this->_get_datatables_queryClosed($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allClosed($status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded){
	        $this->_get_all_queryClosed($status,$pm,$customer,$partner,$type,$regional,$segmen,$escorded);
	        return $this->db->count_all_results();
	    }
	#END LIST CLOSED

	#DATATABLE Non PM
	    var $column_orderNonPM = array('TO_NUMBER(SUBSTR(ID_PROJECT, 5,7)) SEQ','NAME','SEGMEN','NO_SPK_CC','VALUE',null); //set column field database for datatable orderable
	    var $column_searchNonPM = array('ID_PROJECT','NAME'); //set column field database for datatable searchable
	    var $orderNonPM = array('SEQ' => 'desc'); // default order
		
		public function _get_all_queryNonPM($status,$pm,$customer,$partner,$type,$regional,$segmen){
				if($this->session->userdata('tipe_sess') == 'PROJECT_MANAGER' ){
				$nama_pm = $this->session->userdata('nama_sess');
					$query = $this->db
						->select("TO_NUMBER(SUBSTR(ID_PROJECT, 5,7)) SEQ, PRIME_PROJECT.*,
									ROW_NUMBER() OVER(ORDER BY ID_PROJECT DESC) XRNUM")
						->from("PRIME_PROJECT")
						->where(1,1)
						->where('PM_NAME',$nama_pm)
						->where('PM_EXIST',0)
						->where('STATUS','NON PM')
						->where('EXIST',1);

				}else{
					$query = $this->db
						->select("TO_NUMBER(SUBSTR(ID_PROJECT, 5,7)) SEQ, PRIME_PROJECT.*,
									ROW_NUMBER() OVER(ORDER BY ID_PROJECT DESC) XRNUM")
						->from("PRIME_PROJECT")
						->where('PM_EXIST',0)
						->where('STATUS','NON PM')
						->where('EXIST',1);
					}

					$regional1 =	$this->session->userdata('regional');
					if($regional1 != '0' && !empty($regional1)){
						$query = $query->where('REGIONAL', $regional1);
					}

					if($status != null){
						$query = $query->where('STATUS',$status);
					}
					if($pm != null){
						$query = $query->where('PM_NIK',$pm);
					}
					if($type != null){
						$query = $query->where('TYPE',$type);
					}
					if($customer != null){
						$query = $query->where('NIP_NAS',$customer);
					}
					if($regional != null){
						$query = $query->where('REGIONAL',$regional);
					}
					if($segmen != null){
						$query = $query->where('SEGMEN',$segmen);
					}	
				
				return $query;
	    }

	    private function _get_datatables_queryNonPM($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){

	        $this->_get_all_queryNonPM($status,$pm,$customer,$partner,$type,$regional,$segmen);

	        $i = 0;

	        foreach ($this->column_searchNonPM as $item) // loop column
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

	                if (count($this->column_searchNonPM) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	        		
	            $this->db->order_by($this->column_orderNonPM[$orderColumn], $orderDir);
	        }
	        else if(isset($this->orderNonPM))
	        {
	            $order = $this->orderNonPM;
	            $this->db->order_by(key($order), $orderDir);
	        }
	    }

	    function get_datatablesNonPM($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_datatables_queryNonPM($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        	// echo $this->db->last_query();exit;
	        return $query->result();
	    }

	    function count_filteredNonPM($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_datatables_queryNonPM($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_allNonPM($status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_all_queryNonPM($status,$pm,$customer,$partner,$type,$regional,$segmen);
	        return $this->db->count_all_results();
	    }
	#END LIST NON PM

	##ISSUE
	    function get_detail_issue($id_issue) {
			$this->db->select("A.*, TO_CHAR(A.ISSUE_CLOSED_DATE,'MM/DD/YYYY') ISSUE_CLOSED_DATE2, TO_CHAR(A.LAST_UPDATE, 'DD MONTH YYYY, HH24:MI') LAST_UPDATE2");
			$this->db->where('ID_ISSUE', $id_issue);
			$dataPro = $this->db->get('PRIME_PROJECT_ISSUE A')->row_array();

			$this->db->where('ID_ISSUE', $id_issue);
			$dataPart = $this->db->get('PRIME_ISSUE_PIC')->result_array();
			$dataPro['pics'] = $dataPart;
			return $dataPro;
		}

	    function addIssue($data) {
			$this->db->set('ID_ISSUE',  $data['ID_ISSUE']);
			$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
			$this->db->set('ISSUE_NAME',  $data['ISSUE_NAME']);
			$this->db->set('STATUS_ISSUE',  "OPEN");
			if(!empty($data['ISSUE_ATTACHMENT'])){
				$this->db->set('ISSUE_ATTACHMENT',  $data['ISSUE_ATTACHMENT']);
			}
			
			$this->db->set('RISK_IMPACT',  $data['RISK_IMPACT']);
			if(!empty($data['MITIGATION_PLAN'])){
				$this->db->set('MITIGATION_PLAN',  $data['MITIGATION_PLAN']);
			}
			
			$this->db->set('IMPACT',  $data['IMPACT']);
			$this->db->set('INSERTED_DATE', "to_date('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS')",false);
			$this->db->set('INSERTED_BY_ID',  $this->session->userdata('nik_sess'));
			$this->db->set('INSERTED_BY_NAME',  $this->session->userdata('nama_sess'));
			$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
			$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			if (!empty($data['ISSUE_ATTACHMENT'])) {
				$this->db->set('ISSUE_ATTACHMENT',  $data['ISSUE_ATTACHMENT']); 
			}
			return $this->db->insert('PRIME_PROJECT_ISSUE');
		}

		function deleteIssue($id_project,$id_issue){
			$this->db->where('ID_ISSUE',$id_issue);
			if($this->db->delete('PRIME_PROJECT_ISSUE')){
				$this->db->where('ID_ISSUE',$id_issue);
				$this->db->delete('PRIME_ISSUE_PIC');
				// $this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");
				return true;
			}
			return false;
		}

		function updateIssue($data) {
					$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
					$this->db->set('ISSUE_NAME',  $data['ISSUE_NAME']);
					$this->db->set('RISK_IMPACT',  $data['RISK_IMPACT']);
					
					if (!empty($data['MITIGATION_PLAN'])) {
						$this->db->set('MITIGATION_PLAN',  $data['MITIGATION_PLAN']);
					}

					$this->db->set('IMPACT',  $data['IMPACT']);
					$this->db->set('STATUS_ISSUE',  $data['STATUS_ISSUE']);
					$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
					$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
					
					if(!empty($data['ISSUE_CLOSED_DATE'])){
						$this->db->set('ISSUE_CLOSED_DATE',  "to_date('".$data['ISSUE_CLOSED_DATE']."','MM/DD/YYYY')",false);
					}

					if (!empty($data['ISSUE_ATTACHMENT'])) {
						$this->db->set('ISSUE_ATTACHMENT',  $data['ISSUE_ATTACHMENT']); 
					}

					$this->db->where('ID_ISSUE', $data['ID_ISSUE']);
					return $this->db->update('_PROJECT_ISSUE');
				}

		function addPicIssue($data) {
			return $this->db->insert_batch('PRIME_ISSUE_PIC', $data);
		}

		function update_symtom($data){
			$this->db->set('REASON_OF_DELAY',  $data['REASON_OF_DELAY']);
			$this->db->where('ID_PROJECT', $data['ID_PROJECT']);
			return $this->db->update('PRIME_PROJECT');

		}

		function deletePicIssue($id_issue) {
					$this->db->where('ID_ISSUE', $id_issue);
					return $this->db->delete('PRIME_ISSUE_PIC');
		}

		function addAction($data,$dataPIC) {
			$this->db->set('ID_ACTION_PLAN',  $data['ID_ACTION_PLAN']);
			$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
			$this->db->set('ID_ISSUE',  $data['ID_ISSUE']);

			if(!empty($data['ATTACHMENT'])){
				$this->db->set('ATTACHMENT',  $data['ATTACHMENT']);
			}

			
			$this->db->set('ACTION_NAME',  $data['ACTION_NAME']);
			$this->db->set('ASSIGN_TO',  $data['ASSIGN_TO']);
			$this->db->set('ASSIGN_TO_DETAIL',  $data['ASSIGN_TO_DETAIL']);
			$this->db->set('ACTION_STATUS',  "OPEN");
			$this->db->set('ACTION_REMARKS',  $data['ACTION_REMARKS']);
			$this->db->set('DUE_DATE', "to_date('".$data['DUE_DATE']."','MM/DD/YYYY')",false);
			$this->db->set('INSERTED_DATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$this->db->set('INSERTED_BY_ID',  $this->session->userdata('nik_sess'));
			$this->db->set('INSERTED_BY_NAME',  $this->session->userdata('nama_sess'));
			$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
			$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$query = $this->db->insert('_PROJECT_ACTION_PLAN');

			$idPro = $data['ID_PROJECT'];

			//$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$idPro')");
			if(!empty($dataPIC)){
				$this->db->insert_batch('PRIME_ACTION_PLAN_PIC', $dataPIC);
			}
			return true;
			
		}


		function updateAction($data,$dataPIC) {
			$this->db->set('ID_ISSUE',  $data['ID_ISSUE']);
			

			if(!empty($data['ATTACHMENT'])){
				$this->db->set('ATTACHMENT',  $data['ATTACHMENT']);
			}

			$this->db->set('ACTION_NAME',  $data['ACTION_NAME']);
			$this->db->set('ASSIGN_TO',  $data['ASSIGN_TO']);
			$this->db->set('ASSIGN_TO_DETAIL',  $data['ASSIGN_TO_DETAIL']);
			$this->db->set('ACTION_STATUS',  $data['ACTION_STATUS']);

			$this->db->set('ACTION_REMARKS',  $data['ACTION_REMARKS']);
			$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
			$this->db->set('DUE_DATE', "to_date('".$data['DUE_DATE']."','MM/DD/YYYY')",false);

			if(!empty($data['ACTION_CLOSED_DATE'])){
				$this->db->set('ACTION_CLOSED_DATE', "to_date('".$data['ACTION_CLOSED_DATE']."','MM/DD/YYYY')",false);
			}
			

			$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$this->db->where('ID_PROJECT',$data['ID_PROJECT']);
			$this->db->where('ID_ACTION_PLAN',$data['ID_ACTION_PLAN']);
			$query = $this->db->update('PRIME_PROJECT_ACTION_PLAN');
			//echo $this->db->last_query();
			$idPro = $data['ID_PROJECT'];

			// $this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$idPro')");
			if(!empty($dataPIC)){
				$this->db->insert_batch('PRIME_ACTION_PLAN_PIC', $dataPIC);
			}
			return true;
			
		}

		function get_detail_action_plan($id_action_plan) {
			// get project list
			$dataPro = $this->db->query("	SELECT A.*, B.*, TO_CHAR(A.DUE_DATE,'MM/DD/YYYY') DUE_DATE_N, TO_CHAR(A.LAST_UPDATE, 'DD MONTH YYYY, HH24:MI') LAST_UPDATE2
											FROM PRIME_PROJECT_ACTION_PLAN A, PRIME_PROJECT_ISSUE B
											WHERE A.ID_ISSUE = B.ID_ISSUE(+)
											AND A.ID_ACTION_PLAN='$id_action_plan'")->row_array();

			// get partnert list
			$this->db->where('ID_ACTION_PLAN', $id_action_plan);
			$dataPart = $this->db->get('_ACTION_PLAN_PIC')->result_array();
			$dataPro['pics'] = $dataPart;
			return $dataPro;
		}

	##END ISSUE


	##ASSIGN NON PM
		function assignNonPM($id_project){
			$q = $this->db->set('PM_EXIST','0')->where('ID_PROJECT',$id_project);
			return $q->update('PRIME_PROJECT');
		}

		function get_matrix_deliverable($id_project){
			$q = $this->db->query("
					DECLARE var_out   VARCHAR2 (32767);
					BEGIN 
					var_out := null;
					USR_PJM.GET_S_CURVE_HGN ('$id_project',var_out);
					END;
					");

			$select = $this->db->select('TMP')->from('PRIME_TMP')->where('ID_PROJECT',$id_project)->get()->row()->TMP;
			$select = trim(preg_replace('/\s+/', ' ', $select));;

			$result = $this->db->query($select)->result_array();
			return $result;
		}

		function get_deliverable_progress($id){
			$q = $this->db->select('*')->from('PRIME_PROJECT_S_CURVE_REAL_01')->where('ID_PROJECT',$id)->get()->result_array();
			return $q;
		}

		function get_deliverable_plan($id){
			$q = $this->db->select('*')->from('PRIME_PROJECT_S_CURVE_PLAN_01')->where('ID_PROJECT',$id)->get()->result_array();
			return $q;
		}

		function get_distinct_deliverable($id,$start_date,$current_week){
			//echo $current_week;die;
			if(empty($current_week)){
				$q = $this->db->select('*')->from('PRIME_PROJECT_DELIVERABLES')->where('ID_PROJECT',$id)->get()->result_array();
			}else{
				$start_date = date('d/m/Y',strtotime($start_date));
				$q = $this->db->select("A.*, ROUND((START_DATE - TO_DATE('".$start_date."', 'DD/MM/YYYY'))/7) WEEK_START , ROUND((END_DATE - TO_DATE('".$start_date."', 'DD/MM/YYYY'))/7) WEEK_END, CASE WHEN ROUND((END_DATE - TO_DATE('".$start_date."', 'DD/MM/YYYY'))/7) < ".$current_week." AND PROGRESS_VALUE < WEIGHT THEN '#f5302e' ELSE '#4dbd74' END COLOR")
			                  ->from('PRIME_PROJECT_DELIVERABLES A')
			                  ->where('ID_PROJECT',$id)
			                  ->order_by('ID_DELIVERABLE')
			                  ->get()
			                  ->result_array();
				
			}
			return $q;

			
		}

		function get_current_week($id){
			$q = $this->db->select("ceil((SYSDATE-A.START_WEEK_1+1)/7) VAL")->from("PRIME_PROJECT A")->where("A.ID_PROJECT",$id)->get()->row()->VAL;

			return $q;
		}


		function get_week(){
			$q = $this->db->query("SELECT TO_CHAR(SYSDATE,'YYYY')||' Week '||TO_CHAR(SYSDATE,'WW') DAT FROM DUAL")->row()->DAT;
			return $q;
		}


	##Project Documents
		function get_project_document($id){
			$q = $this->db->query(" SELECT ATTACHMENT, 'DELIVERABLE' CATEGORY FROM PRIME_PROJECT_DELIVERABLES 
									WHERE ID_PROJECT = '$id'
									AND ATTACHMENT IS NOT NULL
									UNION
									SELECT ATTACHMENT, 'ACTION PLAN' CATEGORY FROM PRIME_PROJECT_ACTION_PLAN
									WHERE ID_PROJECT = '$id'
									AND ATTACHMENT IS NOT NULL
									UNION
									SELECT ATTACHMENT, CATEGORY FROM PRIME_PROJECT_DOCUMENT
									WHERE ID_PROJECT = '$id'
									AND EXIST = '1'
									UNION
									SELECT CASE WHEN LINK_P8 LIKE '%../%' THEN 'https://prime.telkom.co.id/'||LINK_P8  ELSE LINK_p8 END ATTACHMENT, 'P8' CATEGORY FROM PRIME_PROJECT_PARTNERS
									WHERE ID_PROJECT = '$id'
									AND LINK_P8 IS NOT NULL");
			
			return $q->result_array();;
		}

	#$Project BAST
		function get_project_bast($id){
			$q = $this->db->select('A.*')
			     ->from('PRIME_BAST_HGN A')
			     ->join('PRIME_PROJECT_PARTNERS B','B.NO_P8 = A.NO_SPK')
			     ->where('B.ID_PROJECT',$id)
			     ->where('A.EXIST','1')
			     ->order_by('TGL_BAST')
			     ->distinct();
			return $q->get()->result_array();
		}

		function addDocumentProject($data){
			$this->db->insert('PRIME_PROJECT_DOCUMENT', $data);
		}


		function download_list_active_projects(){
			//$this->db->query("BEGIN PRIME_MONITORING_PROJECT_PROC; END;");
	    	$arr 	= array('LEAD','LAG','DELAY');
			$q 		= 	$this->db
	                        ->select("A.*, A.NAME PROJECT_NAME,  PARTNER.MITRA PARTNERS, A.STANDARD_NAME NAMACC, TO_CHAR(A.UPDATED_DATE, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED,  A.UPDATED_BY_NAME UPDATED_BY, A.UPDATED_BY_ID ,CASE WHEN A.STATUS = 'DELAY' THEN '100' ELSE SUBSTR(C.PLAN,1,6) END PLAN,  SUBSTR(C.PLAN,1,6) PLAN_PM, SUBSTR(C.ACH,1,6) ACH, A.STATUS STATUS, TO_NUMBER(C.ACH) - TO_NUMBER(NVL(C.PLAN,0)) DEVIASI, A.REASON_OF_DELAY REASON, CASE WHEN A.STATUS = 'DELAY' THEN (((100 - TO_NUMBER(C.ACH)) / 100) * A.VALUE)  WHEN C.ACH > C.PLAN THEN ((100 - TO_NUMBER(C.ACH))/100) * A.VALUE ELSE (((TO_NUMBER(NVL(C.PLAN,0)) - TO_NUMBER(C.ACH)) /100) * A.VALUE) END POTENTIAL_WEEK, (((100 - TO_NUMBER(C.ACH)) / 100) * A.VALUE) POTENTIAL ")
	                        ->from('PRIME_PROJECT A')
	                        ->join("PRIME_MONITORING_PROJECT C","C.ID_PROJECT = A.ID_PROJECT","LEFT")
	                        ->join("(
	                        		SELECT ID_PROJECT,
	                                        LISTAGG(PARTNER_NAME, ', ') WITHIN GROUP (ORDER BY ID_PROJECT) AS MITRA
	                                        FROM PRIME_PROJECT_PARTNERS
	                                        GROUP BY ID_PROJECT
	                        		) PARTNER","PARTNER.ID_PROJECT = A.ID_PROJECT","LEFT")
	                        ->where_in('A.STATUS', $arr) 
	                        ->where(1,1)
	                        ->where("A.EXIST","1");
	        $regional1 =	$this->session->userdata('regional');
				if($regional1 != '0' && !empty($regional1)){
					$q = $q->where('A.REGIONAL', $regional1);
				}

			$result = $q->distinct()->get()->result_array();		
			return $result;
	    } 

	    function download_list_active_projects_detail(){
	    	$regional1 	=	$this->session->userdata('regional');
	    	$sWhere 	= null;
				if($regional1 != '0' && !empty($regional1)){
					$sWhere = "AND A.REGIONAL = '".$regional1."'";
				}
			$q 		= $this->db->query("SELECT DISTINCT TO_CHAR(A.UPDATED_DATE, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATED, A.ID_PROJECT, A.ID_LOP_EPIC, NAME PROJECT_NAME, TYPE, STANDARD_NAME, SEGMEN, PM_NAME, 
											AM_NAME, PARTNERS, A.START_DATE,A.TARGET_AWAL, A.TARGET, 
											NVL((((SYSDATE-A.START_DATE)/(A.TARGET-START_DATE))*100),0) DURATION, NVL(G.PLAN,0) PLAN,
											NVL(C.REAL,0) ACH, NVL(D.DEVIATION,0) DEVIATION, E.LAST_UPDATE, 
											A.STATUS KATEGORI_STATUS_PROJECT, A.STATUS, REASON_OF_DELAY, F.ISSUE_NAME ISSUES, 
											F.IMPACT,F.RISK_IMPACT, F.ACTION_NAME ACTION_PLAN, F.ACTION_REMARKS,F.ASSIGN_TO, F.DUE_DATE,
											F.ACTION_INDOCATOR, PROJECT_VALUES, GROUPS, DOC_RFP, DOC_PROPOSAL, DOC_AANWIZING, DOC_SPK, 
											DOC_BAKN_PB, A.SCALE, A.EXIST
									FROM
									(
									    SELECT EXIST, SCALE, ID_PROJECT,ID_LOP_EPIC, NAME, TYPE, STANDARD_NAME, SEGMEN, PM_NAME, AM_NAME, 
									           START_DATE,START_WEEK_1,FIRST_END_DATE TARGET_AWAL, END_DATE TARGET, STATUS, REASON_OF_DELAY, 
									           VALUE PROJECT_VALUES, CATEGORY GROUPS, DOC_RFP, DOC_PROPOSAL, DOC_AANWIZING,
									           DOC_SPK, DOC_BAKN_PB,REGIONAL, UPDATED_DATE
									    FROM PRIME_PROJECT
									) A,
									(
									    SELECT ID_PROJECT,
									           LISTAGG(PARTNER_NAME||' ['||NO_P8||']', ',') WITHIN GROUP (ORDER BY ID_PROJECT) AS PARTNERS
									    FROM PRIME_PROJECT_PARTNERS
									    GROUP BY ID_PROJECT
									) B,
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
									) C,
									PRIME_PROJECT_DEVIATION D,
									(
									    SELECT A.ID_PROJECT,MAX(B.LAST_UPDATE) LAST_UPDATE
									    FROM PRIME_PROJECT A,
									    (
									        SELECT ID_PROJECT,MAX(LAST_UPDATE) LAST_UPDATE
									        FROM PRIME_PROJECT_ACTION_PLAN
									        GROUP BY ID_PROJECT
									        UNION
									        SELECT ID_PROJECT, MAX(LAST_UPDATE) LAST_UPDATE
									        FROM PRIME_PROJECT_DELIVERABLES
									        GROUP BY ID_PROJECT
									        UNION
									        SELECT ID_PROJECT, MAX(LAST_UPDATE) LAST_UPDATE
									        FROM PRIME_PROJECT_ISSUE
									        GROUP BY ID_PROJECT
									    ) B
									    WHERE A.ID_PROJECT = B.ID_PROJECT
									    GROUP BY A.ID_PROJECT
									) E,
									(
									    SELECT *
									    FROM
									    (    
									        SELECT A.ID_PROJECT, A.ID_ISSUE,A.ISSUE_NAME,A.IMPACT, A.RISK_IMPACT,B.ACTION_NAME, B.ACTION_REMARKS,
									               B.ASSIGN_TO,B.DUE_DATE, B.ACTION_INDOCATOR
									        FROM PRIME_PROJECT_ISSUE A,
									        (
									            SELECT ID_PROJECT,ID_ISSUE,ACTION_NAME,ACTION_REMARKS,
									                   CASE
									                    WHEN ASSIGN_TO ='SEGMEN'
									                        THEN 'SEGMEN-'||ASSIGN_TO_DETAIL
									                    WHEN TRIM(ASSIGN_TO_DETAIL) IS NOT NULL
									                        THEN ASSIGN_TO_DETAIL
									                    ELSE ASSIGN_TO
									                   END ASSIGN_TO,
									                   DUE_DATE, ACTION_INDOCATOR
									            FROM
									            (
									                SELECT ID_PROJECT,ID_ISSUE,ACTION_NAME, ASSIGN_TO,ASSIGN_TO_DETAIL, DUE_DATE,ACTION_REMARKS,'OVERDUE' ACTION_INDOCATOR
									                FROM PRIME_PROJECT_ACTION_PLAN
									                WHERE TO_CHAR (SYSDATE, 'YYYYMMDD') > TO_CHAR (DUE_DATE, 'YYYYMMDD')
									                AND ACTION_STATUS <> 'CLOSED'
									                UNION
									                SELECT ID_PROJECT,ID_ISSUE,ACTION_NAME, ASSIGN_TO,ASSIGN_TO_DETAIL, DUE_DATE,ACTION_REMARKS, 'WARNING' ACTION_INDOCATOR
									                FROM PRIME_PROJECT_ACTION_PLAN
									                WHERE TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (DUE_DATE, 'YYYYMMDD')
									                AND (TO_DATE (TO_CHAR (DUE_DATE, 'MM/DD/YYYY'),'MM/DD/YYYY')- TRUNC (SYSDATE)) <= 
									                (
									                    SELECT MAX_DUE_DATE
									                    FROM PRIME_SETTING
									                )
									                AND ACTION_STATUS <> 'CLOSED'
									                UNION
									                SELECT ID_PROJECT,ID_ISSUE,ACTION_NAME, ASSIGN_TO,ASSIGN_TO_DETAIL, DUE_DATE,ACTION_REMARKS,'PLAN' ACTION_INDOCATOR
									                FROM PRIME_PROJECT_ACTION_PLAN
									                WHERE (TO_DATE (TO_CHAR (DUE_DATE, 'MM/DD/YYYY'),'MM/DD/YYYY') - TRUNC (SYSDATE)) > 
									                (
									                    SELECT MAX_DUE_DATE
									                    FROM PRIME_SETTING
									                )
									                AND ACTION_STATUS <> 'CLOSED'
									            )
									        ) B
									        WHERE A.ID_ISSUE= B.ID_ISSUE
									        UNION
									        SELECT ID_PROJECT,'' ID_ISSUE,'' ISSUE_NAME,'' IMPACT, '' RISK_IMPACT, ACTION_NAME, ACTION_REMARKS,
									               CASE
									                WHEN ASSIGN_TO ='SEGMEN'
									                    THEN 'SEGMEN-'||ASSIGN_TO_DETAIL
									                WHEN TRIM(ASSIGN_TO_DETAIL) IS NOT NULL
									                    THEN ASSIGN_TO_DETAIL
									                ELSE ASSIGN_TO
									               END ASSIGN_TO,DUE_DATE, 'OVERDUE' ACTION_INDOCATOR
									        FROM PRIME_PROJECT_ACTION_PLAN
									        WHERE TO_CHAR (SYSDATE, 'YYYYMMDD') > TO_CHAR (DUE_DATE, 'YYYYMMDD')
									        AND ACTION_STATUS <> 'CLOSED'
									        AND TRIM(ID_ISSUE) IS NULL
									        UNION
									        SELECT ID_PROJECT,'' ID_ISSUE,'' ISSUE_NAME,'' IMPACT, '' RISK_IMPACT, ACTION_NAME, ACTION_REMARKS,
									               CASE
									                WHEN ASSIGN_TO ='SEGMEN'
									                    THEN 'SEGMEN-'||ASSIGN_TO_DETAIL
									                WHEN TRIM(ASSIGN_TO_DETAIL) IS NOT NULL
									                    THEN ASSIGN_TO_DETAIL
									                ELSE ASSIGN_TO
									               END ASSIGN_TO,DUE_DATE, 'WARNING' ACTION_INDOCATOR
									        FROM PRIME_PROJECT_ACTION_PLAN
									        WHERE TO_CHAR (SYSDATE, 'YYYYMMDD') <= TO_CHAR (DUE_DATE, 'YYYYMMDD')
									        AND (TO_DATE (TO_CHAR (DUE_DATE, 'MM/DD/YYYY'),'MM/DD/YYYY')- TRUNC (SYSDATE)) <= 
									        (
									            SELECT MAX_DUE_DATE
									            FROM PRIME_SETTING
									        )
									        AND ACTION_STATUS <> 'CLOSED'
									        AND TRIM(ID_ISSUE) IS NULL
									        UNION
									        SELECT ID_PROJECT,'' ID_ISSUE,'' ISSUE_NAME,'' IMPACT, '' RISK_IMPACT, ACTION_NAME, ACTION_REMARKS,
									               CASE
									                WHEN ASSIGN_TO ='SEGMEN'
									                    THEN 'SEGMEN-'||ASSIGN_TO_DETAIL
									                WHEN TRIM(ASSIGN_TO_DETAIL) IS NOT NULL
									                    THEN ASSIGN_TO_DETAIL
									                ELSE ASSIGN_TO
									               END ASSIGN_TO,DUE_DATE,'PLAN' ACTION_INDOCATOR
									        FROM PRIME_PROJECT_ACTION_PLAN
									        WHERE (TO_DATE (TO_CHAR (DUE_DATE, 'MM/DD/YYYY'),'MM/DD/YYYY') - TRUNC (SYSDATE)) > 
									        (
									            SELECT MAX_DUE_DATE
									            FROM PRIME_SETTING
									        )
									        AND ACTION_STATUS <> 'CLOSED'
									        AND TRIM(ID_ISSUE) IS NULL
									    )
									) F,
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
									) G
									WHERE A.ID_PROJECT = B.ID_PROJECT(+)
									AND A.ID_PROJECT  = C.ID_PROJECT(+)
									AND A.ID_PROJECT  = D.ID_PROJECT(+)
									AND A.ID_PROJECT  = E.ID_PROJECT(+)
									AND A.ID_PROJECT  = G.ID_PROJECT(+)
									AND A.ID_PROJECT  = F.ID_PROJECT(+)
									AND A.STATUS IN ('LEAD','LAG','DELAY')
									AND A.EXIST = 1
									{$sWhere}
									ORDER BY SEGMEN, A.ID_PROJECT ASC
									");
			$result = $q->result_array();		
			return $result;
	    }

	    function download_list_candidate_projects(){
	    	$arr 	= array('PROJECT CANDIDATE');
			$q 		= 	$this->db
	                        ->select("A.*, B.PARTNERS")
	                        ->from("PRIME_PROJECT A")
	                        ->join("(SELECT ID_PROJECT, LISTAGG(A.PARTNER_NAME, ', ') 
	                                  WITHIN GROUP (ORDER BY A.ID_PROJECT) AS PARTNERS
	                                  FROM PRIME_PROJECT_PARTNERS A
	                                  GROUP BY ID_PROJECT
	                                  ) B",
	                                  "B.ID_PROJECT = A.ID_PROJECT","LEFT")
	                        ->where_in('A.STATUS', $arr)
	                        ->where(1,1);
	        if($this->session->userdata('regional')!=0){
				$q->where('A.REGIONAL',$this->session->userdata('regional'));
			}
			$result = $q->distinct()->get()->result_array();		


			return $result;
	    }

	    function download_list_active_projects_detail_deliverable(){
	    	$arr 	= array('LEAD','LAG','DELAY');
			$q 		= 	$this->db
	                        ->select("A.NAME PROJECT_NAME, A.ID_PROJECT, B.ID_DELIVERABLE, B.NAME DELIVERABLE_NAME, B.DESCRIPTION, B.WEIGHT PLAN, B.PROGRESS_VALUE ACHIEVEMENT, B.START_DATE, B.END_DATE")
	                        ->from("PRIME_PROJECT A")
	                        ->join("PRIME_PROJECT_DELIVERABLES B","A.ID_PROJECT = B.ID_PROJECT","LEFT")
	                        ->where_in('A.STATUS', $arr)
	                        ->where("((WEIGHT > PROGRESS_VALUE) OR (PROGRESS_VALUE IS NULL))")
	                        ->where(1,1);
	        if($this->session->userdata('regional')!=0){
				$q->where('A.REGIONAL',$this->session->userdata('regional'));
			}
			$result = $q->distinct()->get()->result_array();		


			return $result;
	    }


	    function download_list_non_pm_projects(){
	    	$arr 	= array('LEAD','LAG','DELAY');
			$q 		= 	$this->db
	                        ->select("*")
	                        ->from("PRIME_PROJECT A")
	                        ->where('A.STATUS', 'NON PM');
	        if($this->session->userdata('regional')!=0){
				$q->where('A.REGIONAL',$this->session->userdata('regional'));
			}
			$result = $q->distinct()->get()->result_array();		


			return $result;
	    }


	    function download_list_closed_projects(){
	    //echo json_encode($this->session->userdata());die;
	    $regional1 	=	$this->session->userdata('regional');
	    $segmen 	= 	$this->session->userdata('segmen');
	    $regional = null;
	    if (!empty($segmen && $segmen!="ALL")) {
			$segmen = "AND A.SEGMEN='$segmen'";
		}

		if($regional1 != '0' && !empty($regional1)){
			$regionalv = $this->session->userdata('regional');
			$regional = "AND A.REGIONAL = $regionalv";
		}

		$data = $this->db->query("	SELECT ROW_NUMBER() OVER(ORDER BY SEGMEN,STANDARD_NAME ASC) NO,
									       A.ID_PROJECT, NAME ,TYPE, STANDARD_NAME, SEGMEN, PM_NAME, AM_NAME, '' PM_MITRA,G.MITRA, 
									       FIRST_END_DATE TARGET_AWAL, A.END_DATE TARGET, B.PLAN, B.ACH, C.DEVIATION, F.LAST_UPDATE ,'ON PROGRESS' KATEGORI_STATUS_PROJECT, A.STATUS SUB_KATEGORI_ON_PROGRESS, REASON_OF_DELAY,
									       VALUE,CATEGORY AS GROUPS,  A.START_DATE,
									       A.CLOSED_BY_NAME CLOSED_BY, A.CLOSED_DATE CLOSED_DATE, ID_LOP_EPIC, A.END_DATE, A.CLOSED_BY_NAME
									FROM PRIME_PROJECT A, 
									(
									    SELECT ID_PROJECT,NVL(SUM(WEIGHT),0) PLAN, NVL(SUM(PROGRESS_VALUE),0) ACH
									    FROM PRIME_PROJECT_DELIVERABLES
									    GROUP BY ID_PROJECT
									) B, 
									PRIME_PROJECT_DEVIATION C,
									(
									    SELECT ID_PROJECT,
									        TO_STRING(CAST(COLLECT(ACTION_NAME) AS varchar2_ntt)) AS AP
									    FROM PRIME_PROJECT_ACTION_PLAN
									    GROUP BY ID_PROJECT
									) D,
									(
									    SELECT ID_PROJECT,
									           TO_STRING(CAST(COLLECT(ISSUE_NAME) AS varchar2_ntt)) AS ISSUES
									    FROM PRIME_PROJECT_ISSUE
									    GROUP BY ID_PROJECT
									) E,
									(
									    SELECT A.ID_PROJECT,MAX(B.LAST_UPDATE) LAST_UPDATE
									    FROM PRIME_PROJECT A,
									    (
									        SELECT ID_PROJECT,MAX(LAST_UPDATE) LAST_UPDATE
									        FROM PRIME_PROJECT_ACTION_PLAN
									        GROUP BY ID_PROJECT
									        UNION
									        SELECT ID_PROJECT, MAX(LAST_UPDATE) LAST_UPDATE
									        FROM PRIME_PROJECT_DELIVERABLES
									        GROUP BY ID_PROJECT
									        UNION
									        SELECT ID_PROJECT, MAX(LAST_UPDATE) LAST_UPDATE
									        FROM PRIME_PROJECT_ISSUE
									        GROUP BY ID_PROJECT
									    ) B
									    WHERE A.ID_PROJECT = B.ID_PROJECT
									    GROUP BY A.ID_PROJECT
									) F,
									(
									    SELECT ID_PROJECT,
									           LISTAGG(PARTNER_NAME, '||') WITHIN GROUP (ORDER BY ID_PROJECT) AS MITRA
									    FROM PRIME_PROJECT_PARTNERS
									    GROUP BY ID_PROJECT
									) G
									WHERE A.ID_PROJECT = B.ID_PROJECT(+)
									AND A.ID_PROJECT = C.ID_PROJECT(+)
									AND A.ID_PROJECT = D.ID_PROJECT(+)
									AND A.ID_PROJECT = E.ID_PROJECT(+)
									AND A.ID_PROJECT = F.ID_PROJECT(+)
									AND A.ID_PROJECT = G.ID_PROJECT(+)
									AND (UPPER(A.STATUS)='CLOSED')
									$segmen
									$regional
									ORDER BY SEGMEN ASC")->result_array();
		return $data;
	    }


	    function updateLogProject($id_project){
	    	$this->db->set('UPDATED_DATE',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
	    	$this->db->set('UPDATED_BY_ID',$this->session->userdata('nik_sess'));
	    	$this->db->set('UPDATED_BY_NAME',$this->session->userdata('nama_sess'));
	    	$this->db->where('ID_PROJECT', $id_project);       
        	return $this->db->update('PRIME_PROJECT');
	    }

	    function delete_manual_s_curve($id_project,$id_deliverable){
	    	$this->db->where('ID_PROJECT',$id_project);
	    	$this->db->where('ID_DELIVERABLE',$id_deliverable);
	    	return $this->db->delete('PRIME_PROJECT_S_CURVE_REAL_01');	    	
	    }

	    function delete_manual_s_curve_plan($id_project,$id_deliverable){
	    	$this->db->where('ID_PROJECT',$id_project);
	    	$this->db->where('ID_DELIVERABLE',$id_deliverable);
	    	return $this->db->delete('PRIME_PROJECT_S_CURVE_PLAN_01');	    	
	    }

	    function update_manual_s_curve($id_project,$id_deliverable,$data){
	    	$total = 0;
	    	foreach ($data as $key => $value) {
	    		$this->db->set('UPDATE_DATE',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
	    		$this->db->set('REALIZATION',$value);
	    		$this->db->set('WEEK',$key);
	    		$this->db->set('ID_PROJECT',$id_project);
	    		$this->db->set('ID_DELIVERABLE',$id_deliverable);
	    		$this->db->insert('PRIME_PROJECT_S_CURVE_REAL_01');
	    		$total = $total + $value;
	    	}

	    	$this->db->query("BEGIN PRIME_DLV_UPDATE_PROGRESS_P('$id_project','$id_deliverable','$total', SYSDATE); END;");

	    	return true;
	    }

	    function update_manual_s_curve_plan($id_project,$id_deliverable,$data){
	    	$total = 0;
	    	foreach ($data as $key => $value) {
	    		$this->db->set('UPDATE_DATE',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
	    		$this->db->set('WEIGHT_IN_WEEK',$value);
	    		$this->db->set('WEEK',$key);
	    		$this->db->set('ID_PROJECT',$id_project);
	    		$this->db->set('ID_DELIVERABLE',$id_deliverable);
	    		$this->db->insert('PRIME_PROJECT_S_CURVE_PLAN_01');
	    		$total = $total + $value;
	    	}


	    	return true;
	    }

	    function getKurva_s($id_project){
	    	$query = $this->db
	    			->select("WEEK, SUM(WEIGHT_IN_WEEK) WEIGHT FROM PRIME_PROJECT_S_CURVE_PLAN_01")
	    			->where("ID_PROJECT",$id_project)
	    			->group_by("WEEK")
	    			->order_by("WEEK","ASC");

	    	return $query->get()->result_array();
	    	 		 
	    }

	    function update_curve_plan($id_project,$week,$weight){
	    	$this->db->set('PLAN', 	 $weight);
	    	$this->db->where('ID_PROJECT',   	 $id_project);
	    	$this->db->where('WEEK',   			 $week);
	    	return $this->db->update("PRIME_PROJECT_S_CURVE_WEEK");
	    }


	    function delete_action_plan($id,$id_proj){
	    	$this->db->where('ID_ACTION_PLAN',$id);
			$this->db->where('ID_PROJECT',$id_proj);
			if($this->db->delete('PRIME_PROJECT_ACTION_PLAN')){
				// $this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_proj')");
				return true;
			}
			return false;
	    }

	    function refreshProject(){
	    	$this->db->query("BEGIN PRIME_S_CURVE_DAILY_PROC; END;");
	    	return $this->db->query("BEGIN PRIME_MONITORING_PROJECT_PROC; END;");
	    }

	    function checkAcquisition($year = null,$id,$month,$top){
	    	if(empty($year)){
	    		$year = date('Y');
	    	}
	    	$query 	= 	$this->db
	    				->select('COUNT(1) TOTAL')
	    				->from('PRIME_PROJECT_TARGET')
	    				->where('ID_PROJECT',$id)
	    				->where('TOP',$top)
	    				->where('YEAR',$year)
	    				->where('MONTH',$month);

	    	return $query->get()->row()->TOTAL;
	    }


	    function saveAcquisition($data){
	    	foreach($data as $key => $value){

				if($key=='ACQ_RECCURING_START'){
					$this->db->set("ACQ_RECCURING_START","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='ACQ_RECCURING_END'){
					$this->db->set("ACQ_RECCURING_END","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}		 
			}

			$this->db->set('DATE_CREATED', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$this->db->set('DATE_UPDATED', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			
			return $this->db->insert('PRIME_PROJECT_TARGET');
	    }


	    function updateAcquisition($id_project,$month,$data){
	    	foreach($data as $key => $value){

				if($key=='ACQ_RECCURING_START'){
					$this->db->set("ACQ_RECCURING_START","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='ACQ_RECCURING_END'){
					$this->db->set("ACQ_RECCURING_END","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}		 
			}

			$this->db->set('DATE_UPDATED', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			
			$this->db->where('ID_PROJECT',$id_project);
			$this->db->where('MONTH',$month);
			return $this->db->update('PRIME_PROJECT_TARGET');
	    }


	    function saveAcquisitionT($data){
	    	foreach($data as $key => $value){

				if($key=='RECCURING_START'){
					$this->db->set("RECCURING_START","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='RECCURING_END'){
					$this->db->set("RECCURING_END","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}		 
			}

			$this->db->set('DATE_CREATED', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$this->db->set('DATE_UPDATED', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			
			return $this->db->insert('PRIME_PROJECT_TARGET');
	    }


	    function updateAcquisitionT($id_project,$month,$data,$top){
	    	foreach($data as $key => $value){

				if($key=='RECCURING_START'){
					$this->db->set("RECCURING_START","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='RECCURING_END'){
					$this->db->set("RECCURING_END","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}		 
			}

			$this->db->set('DATE_UPDATED', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			
			$this->db->where('ID_PROJECT',$id_project);
			$this->db->where('MONTH',$month);
			$this->db->where('TOP',$top);
			return $this->db->update('PRIME_PROJECT_TARGET');
	    }



	    function getAllDataProject(){
	    	$query 	= $this->db
	    				->select('*')
	    				->from('PRIME_PROJECT A')
	    				->where('A.ID_LOP_EPIC IS NOT NULL');
	 		return $query->get()->result_array();	
	    }
	
	function getProjectHistory($id){
		$query 	= $this->db
					->select('*')
					->from('PRIME_HISTORY')
					->where('ID',$id)
					->order_by('DATE_CREATED','desc');
		return $query->get()->result_array();
	}	    

	function getProjectAcquisition($id){
		$query 	= $this->db
					->select('*')
					->from('PRIME_PROJECT_TARGET')
					->where('ID_PROJECT',$id)
					->order_by('MONTH','ASC');
		return $query->get()->result_array();
	}

	function get_detail_project_qo_so($id){
		$query = $this->db
					 ->select('ID_LOP, NO_QUOTE, NO_SO, VALID,EXIST')
					 ->distinct()
					 ->from('PRIME_NO_QUOTE_SO')
					 ->where('ID_LOP',$id)
					 ->where('EXIST',1)
					 ->order_by('NO_QUOTE','asc');

		return $query->get()->result_array();
	}

	function checkNoQuoteSO($no_quote,$no_so){
		$query = $this->db
					->select('count(1) T')
					->from('PRIME_NO_QUOTE_SO')
					->where('NO_SO',$no_so)
					->where('NO_QUOTE',$no_quote)
					->where('EXIST',1);
		//return $query->get()->row()->T;
		return 0;
	}

	function addNomorWfm($data){
		$this->db->insert('PRIME_NO_QUOTE_SO',$data);
		return $this->updateMainNoQoSo($data['ID_LOP']);
	}

	function validNoWfm($id_lop,$no_quote,$no_so=null,$valid){
		$this->db->set('VALID',$valid);
		//$this->db->where('ID_LOP',$id_lop);
		$this->db->where('NO_SO',$no_so);
		/*if(!empty($no_so)){
			$this->db->where('NO_SO',$no_so);
		}else{
			$this->db->where("NO_SO IS NULL");
		}*/

		//$this->db->where('NO_QUOTE',$no_quote);
		
		$this->db->update('PRIME_NO_QUOTE_SO');
		return $this->updateMainNoQoSo($id_lop);
	}

	function deleteNoWfm($id_lop,$no_quote,$no_so,$valid){
		//$this->db->where('ID_LOP',$id_lop);
		// $this->db->where('NO_QUOTE',$no_quote);
		$this->db->where('NO_SO',$no_so);
		$this->db->set('VALID',$valid);
		$this->db->set('EXIST',0);
		$this->db->update('PRIME_NO_QUOTE_SO');
		return $this->updateMainNoQoSo($id_lop);

	}

	function updateMainNoQoSo($id_lop){
		return true;
		/*$data = $this->db
		 		->select('*')
		 		->from('PRIME_NO_QUOTE_SO')
		 		->where('ID_LOP',$id_lop)
		 		->where('VALID',1)
		 		->get()->result_array();

		$dataj = array();
		foreach ($data as $key => $value) {
			$dataj[$value['NO_QUOTE']] = array();
		}
		foreach ($dataj as $key => $value) {
			$c = 0;
			foreach ($data as $key1 => $value1) {
				if($key==$value1['NO_QUOTE']){
					$dataj[$key][$c] = $value1['NO_SO'];
					$c++;
				}
					
			}
		}
		$n_data		= json_encode($dataj);
		$this->db->set('NO_QUOTE',$n_data);
		$this->db->set('NO_QUOTE_VALID','1');
		$this->db->where('ID_LOP_EPIC',$id_lop);
		return $this->db->update('PRIME_PROJECT');*/
		
	}
	

	// get Target
	function getTargetProject($id){
		$this->db->select("sum(C_ACQ) T");
		$this->db->from('PRIME_PROJECT_TARGET');
		$this->db->where('MONTH <',intval(date('j'))+1);
		$this->db->where('ID_PROJECT',$id);
		return $this->db->get()->row_array();
	}

	// Add Symptom
	function addSymptom($data){
		return $this->db->insert('PRIME_PROJECT_SYMPTOM',$data);
	}

	function deleteProject($id){
		$this->db->set('EXIST',0);
		$this->db->where('ID_PROJECT',$id);
		return $this->db->update('PRIME_PROJECT');
	}

	function getDataAcquisition($id_project){
		$q = $this->db->select('A.*, NVL(A.PROGRESS,0) PROGRESS1')
				->from('PRIME_PROJECT_TARGET A')
				->where('ID_PROJECT',$id_project);

		return $q->get()->row_array();
	}

	function getAcquisition($id_project,$month,$top,$year = null){
		if(empty($year)){
			$year = date('Y');	
		}
		$q = $this->db->select('A.*')
				->from('PRIME_PROJECT_TARGET A')
				->where('ID_PROJECT',$id_project)
				->where('MONTH', $month)
				->where('YEAR', $year)
				->where('TOP', $top);

		return $q->get()->row_array();
	}

	function getSumAcq($id_project,$top,$month){
		$query = $this->db
					->select("SUM(ACQ) TOTAL")
					->from('PRIME_PROJECT_TARGET')
					->where('ID_PROJECT', $id_project)
					->where('TOP',$top)
					->where('MONTH <',$month)
					->get()
					->row_array();

		return $query['TOTAL'];
	}

	function getSumProgress($id_project,$top,$month){
		$query = $this->db
					->select("SUM(PROGRESS) TOTAL")
					->from('PRIME_PROJECT_TARGET')
					->where('ID_PROJECT', $id_project)
					->where('TOP',$top)
					->where('MONTH <',$month)
					->get()
					->row_array();

		return $query['TOTAL'];
	}


	function getAllDataAcquisition($id_project){
		$q = $this->db->select('A.*, NVL(TO_NUMBER(A.PROGRESS),0) PROGRESS1')
				->from('PRIME_PROJECT_TARGET A')
				->where('ID_PROJECT',$id_project)
				->order_by('YEAR','DESC')
				->order_by('MONTH','DESC')
				->order_by('TOP','asc');

		return $q->get()->result_array();
	}

	function update_comulative_acq($id_project,$sum,$month){
		$this->db->set('COMULATIVE',$sum);
		$this->db->where('ID_PROJECT',$id_project);
		$this->db->where('MONTH',$month);
		return $this->db->update('PRIME_PROJECT_TARGET');
	} 

	function acqFirst($id_project){
		$data = $this->db
				->select("TO_CHAR(MIN(DATE_CREATED), 'HH24MI') A, TO_CHAR(MAX(DATE_UPDATED),'HH24MI') B ")
				->from('PRIME_PROJECT_TARGET')
				->where('ID_PROJECT',$id_project)
				->get()
				->row_array();

		if(!empty($data['A'])&&!empty($data['B'])){
			if($data['A']==$data['B']){
				return 1;
			}else{
				return 0;
			}
		}
		return 0;
	}

	function deleteAcq($id_project,$month,$year = null){
		if(empty($year)){
			$year = date('Y');
		}
		$this->db->Where('ID_PROJECT',$id_project);
		$this->db->Where('MONTH',$month);
		$this->db->Where('YEAR',$year);
		return $this->db->delete("PRIME_PROJECT_TARGET");
	}

	function get_Top25Project(){
		$query = $this->db
				 ->select('*')
				 ->from('PRIME_PROJECT A')
				 ->join('PRIME_PROJECT_PARTNERS B',"A.ID_PROJECT = B.ID_PROJECT")
				 ->where('ROWNUM <',' 25',false);

		return $query->get()->result_array();

	}


	function getDataTask($id_project){ 
		$query = $this->db
		         ->select("ID_DELIVERABLE IDS, NAME, ID_DELIVERABLE CODE, '0' levels, 'false' startIsMilestone, 'false' endIsMilestone, ((TO_NUMBER(START_DATE - TO_DATE('01/01/1970','MM/DD/YYYY')) *  86400000) - 1000000) start2, ((TO_NUMBER(END_DATE - TO_DATE('01/01/1970','MM/DD/YYYY')) *  86400000) - 1000000) end2, 
		         	 TRUNC(END_DATE) - TRUNC(START_DATE)  +1 - 
  ((((TRUNC(END_DATE,'D'))-(TRUNC(START_DATE,'D')))/7)*2) -
  (CASE WHEN TO_CHAR(START_DATE,'DY','nls_date_language=english')='SUN' THEN 1 ELSE 0 END) -
  (CASE WHEN TO_CHAR(END_DATE,'DY','nls_date_language=english')='SAT' THEN 1 ELSE 0 END) as duration")
		         ->from('PRIME_PROJECT_DELIVERABLES')
		         ->where('ID_PROJECT',$id_project)
		         //->where('ROWNUM <',' 2',false)
		         ->get()
		         ->result_array();
		return $query;

	}


	function getDataGanttTask($id_project){
		$query = $this->db
				 ->select("NAME TEXT, 'gantt.config.types.project' TYPE, ID_DELIVERABLE ID, NVL((PROGRESS_VALUE/100),0) PROGRESS, TO_CHAR(START_DATE,'YYYY-MM-DD hh24:mi:ss') START_DATE2, TO_CHAR(END_DATE, 'YYYY-MM-DD hh24:mi:ss') END_DATE2, TO_NUMBER(END_DATE-START_DATE) DURATION,  NVL(WEIGHT,0) WEIGHT, DESCRIPTION, PARENT")
				 ->from("PRIME_PROJECT_DELIVERABLES")
				 ->where("ID_PROJECT",$id_project)
				 ->get()
				 ->result_array();

		return $query;

	}


	// TASK
	function add_task($data) {

					$this->db->set('ID_DELIVERABLE',  $data['ID_DELIVERABLE']);
					$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
					$this->db->set('NAME',  $data['NAME']);
					$this->db->set('WEIGHT',  $data['WEIGHT']);
					$this->db->set('DESCRIPTION',  $data['DESCRIPTION']);
					$this->db->set('PARENT',  $data['PARENT']);
					// $this->db->set('PROGRESS_VALUE',  $data['PROGRESS_VALUE']);
					$this->db->set('START_DATE', "to_date('".$data['START_DATE']."','YYYY/MM/DD')",false);
					$this->db->set('END_DATE', "to_date('".$data['END_DATE']."','YYYY/MM/DD')",false);
					$this->db->set('INSERTED_BY_ID',  $data['INSERTED_BY_ID']);
					$this->db->set('INSERTED_BY_NAME',  $data['INSERTED_BY_NAME']);
					$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
					$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);

					$query =  $this->db->insert('PRIME_PROJECT_DELIVERABLES');
					$id_project = $data['ID_PROJECT'];

					
					$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");

					return $query;
		}


	function update_task($data) {
					$idPro = $data['ID_PROJECT'];

					$idDev = $data['ID_DELIVERABLE'];
					$this->db->set('NAME',  $data['NAME']);
					$this->db->set('WEIGHT',  $data['WEIGHT']);
					$this->db->set('PARENT',  $data['PARENT']);
					$this->db->set('DESCRIPTION',  $data['DESCRIPTION']);
					$this->db->set('PROGRESS_VALUE',$data['PROGRESS_VALUE']);
					$this->db->set('START_DATE', "to_date('".$data['START_DATE']."','YYYY/MM/DD')",false);
					$this->db->set('END_DATE', "to_date('".$data['END_DATE']."','YYYY/MM/DD')",false);
					$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
					$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
					$this->db->where('ID_DELIVERABLE', $data['ID_DELIVERABLE']);
					$query = $this->db->update('PRIME_PROJECT_DELIVERABLES');
					//echo $this->db->last_query();die;

					// call procedure
					$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$idPro')");
					//$this->db->last_query();
					return $query;
				}

	function get_list_project_issue_action_plan($id_project) {
				$query = $this->db->select("A.*, B.*, TO_CHAR(A.INSERTED_DATE,'DD-MM-YYYY') ISSUE_DATE, TO_CHAR(B.DUE_DATE,'DD-MM-YYYY') DUE_DATE1, TO_CHAR(B.ACTION_CLOSED_DATE,'DD-MM-YYYY') CLOSED_DATE, A.ID_ISSUE ID_ISSUE1")
						 ->from("PRIME_PROJECT_ISSUE A")
						 ->join('PRIME_PROJECT_ACTION_PLAN B','A.ID_ISSUE = B.ID_ISSUE','LEFT')
						 ->where('A.ID_PROJECT',$id_project)
						 ->or_where('B.ID_PROJECT',$id_project)
						 ->order_by('STATUS_ISSUE','DESC')
						 ->order_by('ISSUE_NAME','ASC')
						 ->get()
						 ->result_array();
				return $query;
		}


	function get_list_project_action_plan_only($id_project) {
				$query = $this->db->select("A.*, TO_CHAR(A.DUE_DATE,'DD-MM-YYYY') DUE_DATE1, TO_CHAR(A.ACTION_CLOSED_DATE,'DD-MM-YYYY') CLOSED_DATE")
						 ->from("PRIME_PROJECT_ACTION_PLAN A")
						 ->where("ID_ISSUE IS NULL")
						 ->where('A.ID_PROJECT',$id_project)
						 ->order_by('ACTION_NAME','ASC')
						 ->get()
						 ->result_array();
				return $query;
		}

	function get_project_acquisition_s_curve($id_project){
		$query = $this->db->query("	SELECT MONTH, YEAR, A_VALUE REAL, T_VALUE PLAN, MONTH||'/'||YEAR PERIOD, A_NOTE NOTE
									,NVL(T_PROGRESS,0) PROG1, NVL(A_PROGRESS,0) PROG2
										FROM PRIME_PROJECT_ACQ
										WHERE ID_PROJECT = '$id_project' 
										ORDER BY YEAR, MONTH ASC");
			
			$arrData = array(
					'MONTH' => array_column($query->result_array(), "MONTH"),
					'YEAR' => array_column($query->result_array(), "YEAR"),
					'PLAN' => array_column($query->result_array(), "PLAN"),
					'REAL' => array_column($query->result_array(), "REAL"),
					'PERIOD' => array_column($query->result_array(), "PERIOD"),
					'NOTE' => array_column($query->result_array(), "NOTE"),
					'PROG1' => array_column($query->result_array(), "PROG1"),
					'PROG2' => array_column($query->result_array(), "PROG2"),
				);
			return $arrData;
	}


	function getIssue($id){
		$q = $this->db
				->select("A.*, TO_CHAR(A.ISSUE_CLOSED_DATE, 'MM/DD/YYYY') CLOSED_DATE")
				->from('PRIME_PROJECT_ISSUE A')
				->where('ID_ISSUE',$id)
				->get()
				->row_array();
		return $q;
	}

	function getAction($id){
		$q = $this->db
				->select("A.*, TO_CHAR(A.DUE_DATE, 'MM/DD/YYYY') DUE_DATE1, TO_CHAR(A.ACTION_CLOSED_DATE, 'MM/DD/YYYY') CLOSED_DATE ")
				->from('PRIME_PROJECT_ACTION_PLAN A')
				->where('ID_ACTION_PLAN',$id)
				->get()
				->row_array();

		return $q;
	}

	function getActionPic($id){
		$q = $this->db
				->select("A.*")
				->from('PRIME_ACTION_PLAN_PIC A')
				->where('ID_ACTION_PLAN',$id)
				->get()
				->result_array();

		return $q;
	}

	function updateTargetActualAcq($id_project,$month,$year,$data){
		$method = "add";
		$id 	= $this->db->select("ID")->from("PRIME_PROJECT_ACQ")
				 ->where("ID_PROJECT",$id_project)
				 ->where("MONTH",$month)
				 ->where("YEAR",$year)
				 ->get()->row();
		if(!empty($id)){
			$method= "update";
		}

		foreach ($data as $key => $value) {
				if($key=='UPDATED_DATE'){
					$this->db->set('UPDATED_DATE', "to_date('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS')",false);
					}
				if(($method=="update")&&($key == "ID")){

				}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}
		}
		
		if($method == "update"){
			$this->db->where("ID",$id->ID);
			return $this->db->update("PRIME_PROJECT_ACQ");
		}else{
			$this->db->set('CREATED_DATE', "to_date('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS')",false);
			$this->db->set('CREATED_BY', $this->session->userdata('nik_sess'));
			return $this->db->insert("PRIME_PROJECT_ACQ");
		}

	}


	function getDeliverables($id_project){
		
	}


	function get_total_potential_scaling(){
		$arr 	= array('LEAD','LAG','DELAY');
		$q 		= 	$this->db
	                        ->select("
	                        	A.ID_PROJECT,  
	                        	CASE 
	                        		WHEN A.STATUS = 'DELAY' THEN (((100 - TO_NUMBER(C.ACH)) / 100) * A.VALUE) 
	                        		WHEN C.ACH > C.PLAN THEN ((100 - TO_NUMBER(C.ACH))/100) * A.VALUE 
	                        		ELSE (((TO_NUMBER(NVL(C.PLAN,0)) - TO_NUMBER(C.ACH)) /100) * A.VALUE) 
	                        		END POTENTIAL_WEEK, 
	                        	(((100 - TO_NUMBER(C.ACH)) / 100) * A.VALUE) POTENTIAL ")
	                        ->from('PRIME_PROJECT A')
	                        ->join("PRIME_MONITORING_PROJECT C","C.ID_PROJECT = A.ID_PROJECT","LEFT")
	                        ->join("(
	                        		SELECT ID_PROJECT,
	                                        LISTAGG(PARTNER_NAME, ', ') WITHIN GROUP (ORDER BY ID_PROJECT) AS MITRA
	                                        FROM PRIME_PROJECT_PARTNERS
	                                        GROUP BY ID_PROJECT
	                        		) PARTNER","PARTNER.ID_PROJECT = A.ID_PROJECT","LEFT")
	                        ->where_in('A.STATUS', $arr) 
	                        ->where(1,1)
	                        ->where("A.EXIST","1");
					if(!empty($this->session->userdata("mitra_name"))){
						$q = $q->like('PARTNER.MITRA',$this->session->userdata("mitra_name"));
					}

	    return $q->get()->result_array();
	}


	

	

} 