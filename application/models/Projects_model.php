	<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 

	class Projects_model extends CI_Model {


		private $epicdb; 
		public function __construct()  
		{ 
			parent::__construct();
			//$this->epicdb = $this->load->database('epicdb', TRUE);
		}


		##DETAIL PROJECT 
	    function get_detail_project($id = null ,$id_lop = null) {
	    		$this->db->select("A.*, TO_CHAR(A.START_DATE, 'DD MONTH YYYY') START_DATE2, TO_CHAR(A.END_DATE, 'DD MONTH YYYY') END_DATE2, TO_CHAR(A.UPDATED_DATE, 'DD MONTH YYYY') UPDATED_DATE2, A.START_DATE START_DATEX, B.ACH, B.PLAN, (A.END_DATE - A.START_DATE) DAY_DURATION, ROUND(SYSDATE - A.START_DATE) CURRENT_DAY, A.COUNT_OF_WEEK TOTAL_WEEK");
				if(!empty($id)){
					$this->db->where('A.ID_PROJECT', $id);
				}

				if(!empty($id_lop)){
					$this->db->where('ID_LOP_EPIC', $id_lop);
				}

				$data = $this->db
						->from("PRIME_PROJECT A")
						->join("PRIME_MONITORING_PROJECT B","A.ID_PROJECT = B.ID_PROJECT","LEFT")
						->get()
						->row_array();

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
				if(!empty($data['PM_NIK'])){
					$data['pm'] 	= 	$this->db
						->select("*")
						->from('PRIME_USERS A')
						->where('NIK',$data['PM_NIK'])
						->get()
						->row_array();
				}
				
				return $data;
		}

		function get_end_date_project($id_project){
			$q = $this->db
				 ->select("TO_CHAR(END_DATE,'MM/DD/YYYY') END_DATE2")
				 ->from("PRIME_PROJECT")
				 ->where("ID_PROJECT",$id_project)
				 ->get()
				 ->row_array();

			if(!empty($q['END_DATE2'])){
				return $q['END_DATE2'];
			}
			return null;

		}

		// UPDATE END DATE PROJECT LOG
		function update_end_project($id_project,$data){
			foreach($data as $key => $value){

				if($key=='END_DATE'){
					$this->db->set("END_DATE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else if($key=='END_DATE_BEFORE'){
					$this->db->set("END_DATE_BEFORE","TO_DATE('".$value."','MM/DD/YYYY')",FALSE);
					}
				else{
					if(!empty($value)){  
						$this->db->set($key , $value);
					}
					
				}		 
			}

			$query =  $this->db->insert('PRIME_PROJECT_ADENDUM_END');
		}

		function update_field_project($id_project,$keys,$value){
			foreach ($keys as $key => $isi) {
				if($keys[$key]	==	'START_DATE'){
					$this->db->set("START_DATE","TO_DATE('".$value[$key]."','MM/DD/YYYY')",FALSE);
					}
				else if($keys[$key]	 ==	'END_DATE'){
					$this->db->set("END_DATE","TO_DATE('".$value[$key]."','MM/DD/YYYY')",FALSE);
					}
				else{
						if(!empty($isi)){  
							$this->db->set($keys[$key] , $value[$key] );
						}
					}
				}

			$this->db->where('ID_PROJECT',$id_project);
			return $this->db->update('PRIME_PROJECT');
		}

		// Add Symptom
			function addSymptom($data){
				return $this->db->insert('PRIME_PROJECT_SYMPTOM',$data);
			}


		## get project partner
		function get_project_partners($id_project){
				return $this->db->query("	SELECT LISTAGG(PARTNER_NAME||' <br>['||NO_P8||']', '<br><br>') WITHIN GROUP (ORDER BY ID_PROJECT) AS PARTNERS
											FROM PRIME_PROJECT_PARTNERS
											WHERE ID_PROJECT='$id_project'
											GROUP BY ID_PROJECT")->result_array();
		}

		#get project document
		function get_project_document($id_project){
			$query  = $this->db
					  ->select('*')
					  ->from('PRIME_PROJECT_DOCUMENT')
					  ->where('ID_PROJECT',$id_project)
					  ->order_by('CATEGORY','ASC')
					  ->get()->result_array();

			return $query;

		}

		##GET CURRENT WEEK PROJECT 
		function get_project_current_week($id){
			$q = $this->db->select("ceil((SYSDATE-A.START_WEEK_1+1)/7) VAL")->from("PRIME_PROJECT A")->where("A.ID_PROJECT",$id)->get()->row()->VAL;
			return $q;
		}

		function get_project_current_plan($id,$current_week){
			$q = $this->db->query("SELECT PLAN FROM PRIME_PROJECT_S_CURVE_WEEK A
                                            WHERE ID_PROJECT = '".$id."'
                                            AND ROWNUM <= 1
                                            AND WEEK = ".$current_week)->row_array();
			$v = 0;
			if(!empty($q['PLAN'])){
				$v= $q['PLAN'];
			}
			//echo $this->db->last_query();die;
			return $v;

		} 


		function get_project_symptoms($id_project){
			$query = $this->db
					->select("A.*, TO_CHAR(DATE_CREATED,'DD MONTH YYYY') DATES")
					->from("PRIME_PROJECT_SYMPTOM A")
					->where('ID_PROJECT' , $id_project)
					->order_by('DATE_CREATED','DESC')
					->get()
					->result_array();
			return $query;
		}

		##get curva S
		function get_project_curva_s($id_project) {
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

		## get curva S Acquisition
		function get_project_acquisition_s_curve($id_project){
			$query = $this->db->query("	SELECT MONTH, YEAR, A_VALUE REAL, T_VALUE PLAN, MONTH||'/'||YEAR PERIOD, A_NOTE NOTE
										,NVL(T_PROGRESS,0) PROG1, NVL(A_PROGRESS,0) PROG2, TOP_EXPLANATION EXP
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
						'EXP' => array_column($query->result_array(), "EXP"),
					);
				return $arrData;
		}

		## get deliverables
		function get_project_deliverables($id_project){
			$data = $this->db
					->select("A.*, TO_CHAR(END_DATE,'DD/MM/YYYY') END_DATE2, TO_CHAR(START_DATE, 'DD/MM/YYYY') START_DATE2")
					->from("PRIME_PROJECT_DELIVERABLES A")
					->where("ID_PROJECT",$id_project)
					->get()
					->result_array();
			return $data;

		}

		function get_project_deliverables_for_assign($id_project){
			$data = $this->db
					->select("A.*, TO_CHAR(END_DATE,'DD/MM/YYYY') END_DATE2, TO_CHAR(START_DATE, 'DD/MM/YYYY') START_DATE2")
					->from("PRIME_PROJECT_DELIVERABLES A")
					->where("ID_PROJECT",$id_project)
					->get()
					->result_array();
			return $data;

		}


		## get issue
		function get_project_issue($id_project){
			$data = $this->db
					->select("*")
					->from("PRIME_PROJECT_ISSUE")
					->where("ID_PROJECT",$id_project)
					->order_by("STATUS_ISSUE","DESC")
					->order_by("ISSUE_NAME","ASC")
					->get()
					->result_array();
			return $data;

		}

		function get_deliverable_issue($id_deliverable){
			$data = $this->db
					->select("*")
					->from("PRIME_PROJECT_ISSUE")
					->where("ID_DELIVERABLE",$id_deliverable)
					->order_by("STATUS_ISSUE","DESC")
					->order_by("ISSUE_NAME","ASC")
					->get()
					->result_array();
			return $data;

		}

		## get action plan
		function get_project_actionPlan	($id_issue){
			$data = $this->db
					->select("*")
					->from("PRIME_PROJECT_ACTION_PLAN")
					->where("ID_ISSUE",$id_issue)
					->order_by("ACTION_STATUS","DESC")
					->order_by("ACTION_NAME","ASC")
					->get()
					->result_array();
			return $data;
		}

		## get project BAST
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

		function get_project_sum_bast($id){
			$q = $this->db->select("SUM(A.TOTAL) TOTAL2")
			     ->from("(SELECT SUM(A.NILAI_RP_BAST) TOTAL FROM PRIME_BAST_HGN A JOIN PRIME_PROJECT_PARTNERS B ON B.NO_P8 = A.NO_SPK WHERE B.ID_PROJECT = '".$id."' GROUP BY B.ID_PROJECT, A.NILAI_RP_BAST) A");
			return $q->get()->row_array();
		}


		## get project history 
		function get_project_history($id){
			$query 	= $this->db
						->select('*')
						->from('PRIME_HISTORY')
						->where('ID',$id)
						->order_by('DATE_CREATED','desc');
			return $query->get()->result_array();
		}	

		## GET deliverable gantt task
		function getDataGanttTask($id_project){
			$query = $this->db
					 ->select("NAME TEXT, 'gantt.config.types.project' TYPE, ID_DELIVERABLE ID, NVL((PROGRESS_VALUE/100),0) PROGRESS, TO_CHAR(START_DATE,'YYYY-MM-DD hh24:mi:ss') START_DATE2, TO_CHAR(END_DATE, 'YYYY-MM-DD hh24:mi:ss') END_DATE2, TO_NUMBER(END_DATE-START_DATE) DURATION,  NVL(WEIGHT,0) WEIGHT, DESCRIPTION")
					 ->from("PRIME_PROJECT_DELIVERABLES")
					 ->where("ID_PROJECT",$id_project)
					 ->get()
					 ->result_array();

			return $query;

		}



		// Update Log Project
		function updateLogProject($id_project){
	    	$this->db->set('UPDATED_DATE',"TO_DATE('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",FALSE);
	    	$this->db->set('UPDATED_BY_ID',$this->session->userdata('nik_sess'));
	    	$this->db->set('UPDATED_BY_NAME',$this->session->userdata('nama_sess'));
	    	$this->db->where('ID_PROJECT', $id_project);       
        	return $this->db->update('PRIME_PROJECT');
	    }


	    // Add Deliverable
	    function add_deliverable($data) {

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
					$query =  $this->db->insert('PRIME_PROJECT_DELIVERABLES');
					$id_project = $data['ID_PROJECT'];

					//echo $this->db->last_query();
					$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");
					return $query;
		}

		// UPDATE DELIVERABLE
		function update_deliverable($data){
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

					$this->db->where('ID_DELIVERABLE', $data['ID_DELIVERABLE']);
					$query = $this->db->update('PRIME_PROJECT_DELIVERABLES');
					// call procedure
					$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$idPro')");
					$this->db->query("BEGIN PRIME_MONITORING_PROJECT_PROC; END;");
					return $query;
		}


		function delete_deliverable($id_project,$id_deliverable){
			$this->db->where('ID_DELIVERABLE',$id_deliverable);
			if($this->db->delete('PRIME_PROJECT_DELIVERABLES')){
				$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");
				return true;
			}
			return false;
		}

		// ADD ISSUE
		function add_issue($data) {
			$this->db->set('ID_ISSUE',  $data['ID_ISSUE']);
			$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
			$this->db->set('ID_DELIVERABLE',  $data['ID_DELIVERABLE']);
			$this->db->set('ISSUE_NAME',  $data['ISSUE_NAME']);
			$this->db->set('STATUS_ISSUE',  "OPEN");			
			$this->db->set('RISK_IMPACT',  $data['RISK_IMPACT']);			
			$this->db->set('IMPACT',  $data['IMPACT']);
			$this->db->set('IN_CHARGE',  $data['IN_CHARGE']);
			$this->db->set('CATEGORY',  $data['CATEGORY']);


			$this->db->set('INSERTED_DATE', "to_date('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS')",false);
			$this->db->set('INSERTED_BY_ID',  $this->session->userdata('nik_sess'));
			$this->db->set('INSERTED_BY_NAME',  $this->session->userdata('nama_sess'));
			$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
			$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			
			return $this->db->insert('PRIME_PROJECT_ISSUE');
		}

		// UPDATE ISSUE
		function update_issue($id_issue,$data){
					$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
					$this->db->set('ISSUE_NAME',  $data['ISSUE_NAME']);
					$this->db->set('RISK_IMPACT',  $data['RISK_IMPACT']);
					$this->db->set('IMPACT',  $data['IMPACT']);
					$this->db->set('STATUS_ISSUE',  $data['STATUS_ISSUE']);
					$this->db->set('IN_CHARGE',  $data['IN_CHARGE']);
					$this->db->set('CATEGORY',  $data['CATEGORY']);
					$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
					$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
					
					if($data['STATUS_ISSUE'] == 'CLOSED'){
						$this->db->set('ISSUE_CLOSED_DATE',  "to_date('".$data['ISSUE_CLOSED_DATE']."','MM/DD/YYYY')",false);
					}

					$this->db->where('ID_ISSUE', $id_issue);
					return $this->db->update('PRIME_PROJECT_ISSUE');
		}

		// DELETE ISSUE
		function delete_issue($id_project,$id_issue){
			$this->db->where('ID_ISSUE',$id_issue);
			if($this->db->delete('PRIME_PROJECT_ISSUE')){
				$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");
				return true;
			}
			return false;
		}

		function assign_issue($id_issue,$id_deliverable){
			$this->db->set('ID_DELIVERABLE',$id_deliverable);
			$this->db->where('ID_ISSUE',$id_issue);
			return $this->db->update('PRIME_PROJECT_ISSUE');
		}

		// GET PROJECT WEIGHT
		function get_project_progress($id_project) {
				return $this->db->query("	SELECT SUM(WEIGHT) WEIGHT, SUM(PROGRESS_VALUE) ACHIEVEMENT
											FROM PRIME_PROJECT_DELIVERABLES
											WHERE ID_PROJECT='$id_project'")->row();
		}

		// ADD ACTION
		function add_action($data,$dataPIC){
			$this->db->set('ID_ACTION_PLAN',  $data['ID_ACTION_PLAN']);
			$this->db->set('ID_PROJECT',  $data['ID_PROJECT']);
			$this->db->set('ID_ISSUE',  $data['ID_ISSUE']);			
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
			if(!empty($dataPIC)){
				$this->db->insert_batch('PRIME_ACTION_PLAN_PIC', $dataPIC);
			}
			return true;
		}

		// UPDATE ACTION
		function update_action($data,$pic){
			$this->db->set('ACTION_NAME',  $data['ACTION_NAME']);
			$this->db->set('ACTION_STATUS',  $data['ACTION_STATUS']);
			$this->db->set('ACTION_REMARKS',  $data['ACTION_REMARKS']);
			$this->db->set('LAST_UPDATED_BY',  $this->session->userdata('nik_sess'));
			$this->db->set('DUE_DATE', "to_date('".$data['DUE_DATE']."','MM/DD/YYYY')",false);
			if(!empty($data['ACTION_CLOSED_DATE'])){
				$this->db->set('ACTION_CLOSED_DATE', "to_date('".$data['ACTION_CLOSED_DATE']."','MM/DD/YYYY')",false);
			}	
			$this->db->set('LAST_UPDATE', "to_date('".date('m/d/Y H:i:s')."','MM/DD/YYYY HH24:MI:SS')",false);
			$this->db->where('ID_ACTION_PLAN',$data['ID_ACTION_PLAN']);
			$this->db->update('PRIME_PROJECT_ACTION_PLAN');
		
			$idPro = $data['ID_PROJECT'];
			//echo $this->db->last_query();die;
			// $this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$idPro')");
			if(!empty($pic)){
				$this->db->where('ID_ACTION_PLAN', $data['ID_ACTION_PLAN']);
				$this->db->delete('PRIME_ACTION_PLAN_PIC');			
				$this->db->insert_batch('PRIME_ACTION_PLAN_PIC', $pic);
			}
			return true;

		}

		// DELETE ACTION PLAN
		function delete_action($id_project,$id_action){
			$this->db->where('ID_ACTION_PLAN',$id_action);
			if($this->db->delete('PRIME_PROJECT_ACTION_PLAN')){
				$this->db->query("call PRIME_MONITORING_PROJ_SINGLE('$id_project')");
				return true;
			}
			return false;
		}

		function assign_action($id_action,$id_issue){
			$this->db->set('ID_ISSUE',$id_issue);
			$this->db->where('ID_ACTION_PLAN',$id_action);
			return $this->db->update('PRIME_PROJECT_ACTION_PLAN');
		}


		function get_action($id){
			// get project list
			$dataPro = $this->db->query("	SELECT A.*, B.*, TO_CHAR(A.DUE_DATE,'MM/DD/YYYY') DUE_DATE_N, TO_CHAR(A.LAST_UPDATE, 'DD MONTH YYYY, HH24:MI') LAST_UPDATE2
											FROM PRIME_PROJECT_ACTION_PLAN A, PRIME_PROJECT_ISSUE B
											WHERE A.ID_ISSUE = B.ID_ISSUE(+)
											AND A.ID_ACTION_PLAN='$id'")->row_array();

			// get partnert list
			$this->db->where('ID_ACTION_PLAN', $id);
			$dataPart = $this->db->get('PRIME_ACTION_PLAN_PIC')->result_array();
			$dataPro['pics'] = $dataPart;
			return $dataPro;
		}

		// GET DELIVERABLE 
		function get_deliverable($id_dev) {
					$query = $this->db->query("SELECT ID_DELIVERABLE,A.ID_PROJECT,A.NAME,TO_CHAR(WEIGHT,'900.00') WEIGHT,TO_CHAR(A.START_DATE,'MM/DD/YYYY') START_DATE,
												       TO_CHAR(A.END_DATE,'MM/DD/YYYY') END_DATE,A.DESCRIPTION, NVL(A.PROGRESS_VALUE,0) ACHIEVEMENT, B.ID_LOP_EPIC, STATUS, REASON_OF_DELAY, A.ATTACHMENT, TO_CHAR(A.LAST_UPDATE, 'DD MONTH YYYY, HH24:MI') LAST_UPDATE2
												FROM PRIME_PROJECT_DELIVERABLES A, PRIME_PROJECT B
												WHERE A.ID_PROJECT = B.ID_PROJECT
												AND ID_DELIVERABLE='{$id_dev}'")->row_array();
					return $query;
		}

		// GET ISSUE
		function get_issue($id){
			$q = $this->db
					->select("A.*, TO_CHAR(A.ISSUE_CLOSED_DATE, 'MM/DD/YYYY') CLOSED_DATE")
					->from('PRIME_PROJECT_ISSUE A')
					->where('ID_ISSUE',$id)
					->get()
					->row_array();
			return $q;
		}
		

		function get_project_acquisition($id_project,$month,$year){
			if(empty($year)){
			$year = date('Y');	
		}

		$q = $this->db->select('A.*')
				->from('PRIME_PROJECT_ACQ A')
				->where('ID_PROJECT',$id_project)
				->where('MONTH', $month)
				->where('YEAR', $year);

		return $q->get()->row_array();

		}

	// SAVE UPDATE ACQUISITION
	function update_acquisition($id_project,$month,$year,$data){
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
			if(!empty($data['T_VALUE'])){
				$this->db->set('A_VALUE' , $data['T_VALUE']);
			}
			
			if(!empty($data['T_NOTE'])){
				$this->db->set('A_NOTE'  , $data['T_NOTE']);
			}
			
			$this->db->set('CREATED_DATE', "to_date('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS')",false);
			$this->db->set('CREATED_BY', $this->session->userdata('nik_sess'));
			return $this->db->insert("PRIME_PROJECT_ACQ");
		}
	}


	// GET CUSTOMER NAME
	function get_customer_name($nipnas){
        $epic = $this->load->database('epicdb', TRUE);
        $query  = "SELECT STANDARD_NAME NAME FROM CBASE_DIVES WHERE NIP_NAS = '".$nipnas."'";
        $data   = $epic->query($query);
        $result = $data->row_array();
        
        if(!empty($result['NAME'])){
        	return $result['NAME'];
        }
        return "";
	}

	// GET AM NAME
	function get_am_name($nik)
    {
        $result 	= $this->db->query(" SELECT NAMA_AM NAME
                                    FROM
                                    PRIME_AM_CC
                                    WHERE 1=1
                                    AND 
                                    NIK = '".$nik."'")
        						->row_array();

        if(!empty($result['NAME'])){
        	return $result['NAME'];
        }
        return "";
    }

	function add_document($data){
		$this->db->insert('PRIME_PROJECT_DOCUMENT', $data);
	}



// DATATABLES
	##DATATABLE TECHNICAL CLOSE
	    var $column_order_TechClose = array('SEQ','A.NAME','A.SEGMEN','A.VALUE','ACH','A.END_DATE','UPDATED_DATE',null); //set column field database for datatable orderable
	    var $column_search_TechClose = array('A.ID_PROJECT','UPPER(A.NAME)','UPPER(A.STANDARD_NAME)','UPPER(A.TYPE)','UPPER(A.SEGMEN)','UPPER(A.NIP_NAS)','UPPER(A.PM_NAME)','A.STATUS',' A.ID_LOP_EPIC','A.NO_QUOTE'); //set column field database for datatable searchable
	    var $order_TechClose = array('SEQ', 'desc'); // default order
		
		public function _get_all_query_TechClose($status,$pm,$customer,$partner,$type,$regional,$segmen){
			//$regional =	$this->session->userdata('regional');
			$query = $this->db
							/*->select('A.ID_PROJECT')*/
							->select("TO_NUMBER(SUBSTR(A.ID_PROJECT, 5,7)) SEQ, A.UPDATED_DATE, A.ID_PROJECT ,A.NAME, A.TYPE ,A.PM_NAME ,A.DESCRIPTION , A.NIP_NAS NIP_NAS, A.STANDARD_NAME , A.SEGMEN , A.AM_NIK , A.AM_NAME , NVL(C.PLAN,0) WEIGHT, NVL(C.ACH,0) ACH, A.VALUE VALUE,A.STATUS STATUS, A.END_DATE, A.REASON_OF_DELAY, A.NO_QUOTE, A.ID_LOP_EPIC, TO_CHAR(A.END_DATE,'DD-MM-YYYY') END_DATE2, TO_CHAR(A.START_DATE,'DD-MM-YYYY') START_DATE2")
							->from('PRIME_PROJECT A')
							->join("PRIME_MONITORING_PROJECT C","A.ID_PROJECT = C.ID_PROJECT","LEFT")
							->where('A.STATUS','TECHNICAL_CLOSE')
							->where('A.PM_EXIST','1')
							->where("A.EXIST","1");

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

	    private function _get_datatables_query_TechClose($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){

	        $this->_get_all_query_TechClose($status,$pm,$customer,$partner,$type,$regional,$segmen);

	        $i = 0;

	        foreach ($this->column_search_TechClose as $item) // loop column
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

	                if (count($this->column_search_TechClose) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }

	        if(isset($getOrder)&&$orderColumn!=null) // here order processing
	        {	
	            $this->db->order_by($this->column_order_TechClose[$orderColumn], $orderDir);
	        }
	        else if(isset($this->order_TechClose))
	        {	
	            $order = $this->order_TechClose;
	            $this->db->order_by($order[0], $orderDir);
	        }
	    }

	    function get_datatables_TechClose($length, $start, $searchValue, $orderColumn, $orderDir, $getOrder, $status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_datatables_query_TechClose($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
	        if ($length != -1)
	            $this->db->limit($length, $start);
	        	$query = $this->db->get();
	        
	        return $query->result();
	    }

	    function count_filtered_TechClose($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_datatables_query_TechClose($searchValue, $orderColumn, $orderDir, $getOrder,$status,$pm,$customer,$partner,$type,$regional,$segmen);
	        $query = $this->db->get();
	        return $query->num_rows();
	    }

	    public function count_all_TechClose($status,$pm,$customer,$partner,$type,$regional,$segmen){
	        $this->_get_all_query_TechClose($status,$pm,$customer,$partner,$type,$regional,$segmen);
	        return $this->db->count_all_results();
	    }
	#END TECHNICAL CLOSE




} 