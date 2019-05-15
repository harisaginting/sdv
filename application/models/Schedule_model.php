 <?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
    public function __construct() {
    } 


    /*function getDataGanttTask(){
			$query = $this->db
					 ->select("NAME TEXT, 'gantt.config.types.project' TYPE, ID_DELIVERABLE ID, NVL((PROGRESS_VALUE/100),0) PROGRESS, TO_CHAR(START_DATE,'YYYY-MM-DD hh24:mi:ss') START_DATE2, TO_CHAR(END_DATE, 'YYYY-MM-DD hh24:mi:ss') END_DATE2, TO_NUMBER(END_DATE-START_DATE) DURATION,  NVL(WEIGHT,0) WEIGHT, DESCRIPTION")
					 ->from("PRIME_PROJECT_DELIVERABLES")
					 ->get()
					 ->result_array();

			return $query;

		}*/

	function getDataGanttTask(){
				$project = $this->db
						 ->select("NAME TEXT, 'gantt.config.types.project' TYPE, A.ID_PROJECT ID, NVL((ACH/100),0) PROGRESS, TO_CHAR(START_DATE,'YYYY-MM-DD hh24:mi:ss') START_DATE2, TO_CHAR(END_DATE, 'YYYY-MM-DD hh24:mi:ss') END_DATE2, TO_NUMBER(END_DATE-START_DATE) DURATION,  SEGMEN, '' AS DESCRIPTION , '0'  PARENT, 'P' CATEGORY, PM_NAME PM")
						 ->from("PRIME_PROJECT A")
						 ->join("(SELECT ID_PROJECT, PLAN, ACH FROM PRIME_MONITORING_PROJECT) B","A.ID_PROJECT = B.ID_PROJECT","LEFT")
						 ->where_in("A.STATUS", array('LEAD','LAG','DELAY'))
						 ->order_by('A.VALUE','DESC')
						 ->get()
						 ->result_array();

				$id_projects = array();
				foreach ($project as $key => $value) {
					
					if($key <= 24){
					array_push($id_projects, $value['ID']);
					}
				}


				$deliverable = $this->db
					 ->select("NAME TEXT, 'gantt.config.types.project' TYPE, ID_DELIVERABLE ID, NVL((PROGRESS_VALUE/WEIGHT),0) PROGRESS, TO_CHAR(START_DATE,'YYYY-MM-DD hh24:mi:ss') START_DATE2, TO_CHAR(END_DATE, 'YYYY-MM-DD hh24:mi:ss') END_DATE2, TO_NUMBER(END_DATE-START_DATE) DURATION,  NVL(WEIGHT,0) WEIGHT, DESCRIPTION, ID_PROJECT PARENT, 'D' CATEGORY, '*' PM,  '*' SEGMEN")
					 ->from("PRIME_PROJECT_DELIVERABLES A")
					 ->where_in("ID_PROJECT",$id_projects)
					 ->where("PROGRESS_VALUE < WEIGHT")
					 ->where("PARENT IS NULL")
					 ->get()
					 ->result_array();

				$deliverable_sub = $this->db
					 ->select("NAME TEXT, 'gantt.config.types.project' TYPE, ID_DELIVERABLE ID, NVL((PROGRESS_VALUE/WEIGHT),0)  PROGRESS, TO_CHAR(START_DATE,'YYYY-MM-DD hh24:mi:ss') START_DATE2, TO_CHAR(END_DATE, 'YYYY-MM-DD hh24:mi:ss') END_DATE2, TO_NUMBER(END_DATE-START_DATE) DURATION,  NVL(WEIGHT,0) WEIGHT, DESCRIPTION, PARENT, 'D' CATEGORY, , '*' PM,  '*' SEGMEN ")
					 ->from("PRIME_PROJECT_DELIVERABLES A")
					 ->where("PARENT IS NOT NULL")
					 ->where("PROGRESS_VALUE < WEIGHT")
					  ->where_in("ID_PROJECT",$id_projects)
					 ->get()
					 ->result_array();

				$data = array_merge($project, $deliverable, $deliverable_sub);
				return $data;

			}


}     