	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Report_model extends CI_Model {

	function get_list_deliverables($id_project){
		$q = $this->db
			->select('*')
			->from('PRIME_PROJECT_DELIVERABLES A')
			->join("
					(SELECT A.ID_PROJECT, A.ID_DELIVERABLE, SUM(WEIGHT_IN_WEEK) PLAN
						FROM PRIME_PROJECT_S_CURVE_PLAN_01 A
						WHERE WEEK <= CEIL ((SYSDATE -
						(
						SELECT START_WEEK_1
						FROM PRIME_PROJECT B
						WHERE A.ID_PROJECT = B.ID_PROJECT
						) + 1) / 7)
						GROUP BY A.ID_PROJECT, A.ID_DELIVERABLE
				) B", "A.ID_PROJECT = B.ID_PROJECT AND A.ID_DELIVERABLE = B.ID_DELIVERABLE"
			)
			->where('A.ID_PROJECT',$id_project);
		return $q->get()->result_array();
	}

	function get_list_issue($id_project){
		$q = $this->db
			->select('*')
			->from('PRIME_PROJECT_ISSUE A')
			->where('STATUS_ISSUE !=','CLOSED')
			->join("(
					SELECT ID_ISSUE, LISTAGG(PIC_NAME, ', ') WITHIN GROUP (ORDER BY ID_ISSUE) AS PIC
											FROM PRIME_ISSUE_PIC
											GROUP BY ID_ISSUE
				) B", "A.ID_ISSUE = B.ID_ISSUE")
			->where("A.ID_PROJECT", $id_project);

		return $q->get()->result_array();

	}

	function get_list_issueHistory($id_project){
		$q = $this->db
			->select('*')
			->from('PRIME_PROJECT_ISSUE A')
			->where('STATUS_ISSUE','CLOSED')
			->join("(
					SELECT ID_ISSUE, LISTAGG(PIC_NAME, ', ') WITHIN GROUP (ORDER BY ID_ISSUE) AS PIC
											FROM PRIME_ISSUE_PIC
											GROUP BY ID_ISSUE
				) B", "A.ID_ISSUE = B.ID_ISSUE")
			->where("A.ID_PROJECT", $id_project);

		return $q->get()->result_array();

	}

	function get_list_actionPlan($id_project){
		$query		= $this->db
						->select('*')
						->from('PRIME_PROJECT_ACTION_PLAN A')
						->join("(
									SELECT ID_ISSUE, LISTAGG(PIC_NAME, ', ') WITHIN GROUP (ORDER BY ID_ISSUE) AS PIC
															FROM PRIME_ISSUE_PIC
															GROUP BY ID_ISSUE
								) B", "A.ID_ISSUE = B.ID_ISSUE")
						->join('PRIME_PROJECT_ISSUE C',' A.ID_ISSUE = C.ID_ISSUE')
						->where("A.ID_PROJECT", $id_project)
						->where("A.ACTION_STATUS", 'OPEN');

		return $query->get()->result_array();
	}

	function get_list_actionPlanHistory($id_project){
		$query		= $this->db
						->select('*')
						->from('PRIME_PROJECT_ACTION_PLAN A')
						->join("(
									SELECT ID_ISSUE, LISTAGG(PIC_NAME, ', ') WITHIN GROUP (ORDER BY ID_ISSUE) AS PIC
															FROM PRIME_ISSUE_PIC
															GROUP BY ID_ISSUE
								) B", "A.ID_ISSUE = B.ID_ISSUE")
						->join('PRIME_PROJECT_ISSUE C',' A.ID_ISSUE = C.ID_ISSUE')
						->where("A.ID_PROJECT", $id_project)
						->where("A.ACTION_STATUS", 'CLOSED');

		return $query->get()->result_array();
	}
	

}
