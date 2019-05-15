<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Report extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
        $this->load->model('Project_model');
        if(!$this->isLoggedIn()){
            redirect(base_url());
        };  
    }
    
    public function index()
    {
        echo '404';    
    }

    function project_detail($id_project){
        $data['title']      = 'Edit Project';
        $data['id_project'] = $id_project;
        $data['project']    = $this->Project_model->get_detail_project($id_project);
        $data['progress']   = $this->Project_model->get_sum_weight_realization($id_project);
        $data['deliverables']= $this->Report_model->get_list_deliverables($id_project);
        $data['issue']       = $this->Report_model->get_list_issue($id_project);
        $data['action_plan'] = $this->Report_model->get_list_actionPlan($id_project);

        $data['issue_history']  = $this->Report_model->get_list_issueHistory($id_project);
        $data['action_history'] = $this->Report_model->get_list_actionPlanHistory($id_project); 
        //ini_set('user_agent', 'Mozilla/5.0');
        $data['chart']       = '../_files/report/'.url_title($this->session->userdata('nama_sess'),'_',TRUE).'.png';
        //echo $data['chart'];die;
        $html = $this->load->view('report/project',$data,true);

        
        $this->load->library('M_pdf');
        $this->m_pdf->debug = true;
        $this->m_pdf->pdf->WriteHTML($html);
        if (file_exists('../_files/report/'.$id_project.'_'.date('dmY').'.pdf')) {
            unlink('../_files/report/'.$id_project.'_'.date('dmY').'.pdf');
            } 
       
       $this->m_pdf->pdf->Output('../_files/report/'.$id_project.'_'.date('dmY').'.pdf', 'F'); 
       ob_clean();
       $this->m_pdf->pdf->Output(); 
    }

    /*TCPDF*/
    function project_detail_2($id_project){
        $data['title']      = 'Edit Project';
        $data['id_project'] = $id_project;
        $data['project']    = $this->Project_model->get_detail_project($id_project);
        $data['progress']   = $this->Project_model->get_sum_weight_realization($id_project);
        $data['deliverables']= $this->Report_model->get_list_deliverables($id_project);
        $data['issue']       = $this->Report_model->get_list_issue($id_project);
        //echo json_encode($data['progress']);die;         
        $html = $this->load->view('report/project',$data); 
        //echo $html;die;
        $pdf->showImageErrors = true;  
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PRIME APPLICATION');
        $pdf->SetTitle('REPORT PROJECT '.$id_project);
        $pdf->SetSubject('REPORT PROJECT '.$id_project);
        $pdf->SetKeywords('REPORT PROJECT '.$id_project);

     
        $pdf->AddPage();
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
     
        // set margins
        $pdf->SetPrintHeader(false);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setCellPaddings(0,0,0,0);    
     
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
     
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
     
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }   
     
        // ---------------------------------------------------------    
     
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);   
     
        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 11, '', true);   
     
        $pdf->writeHTML($html, true, 0, true, true);
        
        if (file_exists(base_url().'/_files/report/'.$id_project.'_'.date('dmY').'.pdf')) {
            //echo base_url().'/_files/report/'.$id_project.'_'.date('dmY').'.pdf');
            unlink(base_url().'../_files/report/'.$id_project.'_'.date('dmY').'.pdf');
        }
        ob_clean();
        $pdf->Output('../_files/report/'.$id_project.'_'.date('dmY').'.pdf', 'F');
        //redirect(base_url().'../_files/report/'.$id_project.'_'.date('dmY').'.pdf', 'F');
    }

    function upload_chart(){
        $dirName = url_title($this->session->userdata('nama_sess'),'_',TRUE);
        if (file_exists('../_files/report/'.$dirName.'.png')) {
            unlink('../_files/report/'.$dirName.'.png');
        }
        $img = $_POST['data'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = '../_files/report/'.$dirName.'.png';
        $success = file_put_contents($file, $data);
        print $success ? $file : 'Unable to save the file.';
    }

}
?>