<?php $user_regional = !empty($this->session->userdata('regional')) ? $this->session->userdata('regional') : 0; ?> 
  <div class="app-body">
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <?php if(($this->auth->get_access_value('MONITORING')>1)||($this->session->userdata('tipe_sess')=='SUBSIDIARY')) : ?>
          <li class="nav-item"> 
            <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="dashboard")||($this->uri->segment(1)=="") ? 'active' : ''; ?>" id="menu-dashboard" href="<?= base_url(); ?>"><i class="icon-speedometer"></i> <span class="nav-name">Dashboard </span> </a>
          </li>
          <?php endif; ?> 
          </li>
          <?php if($this->auth->get_access_value('PROJECT')>0) : ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="project")&&(($this->uri->segment(2)=="") || ($this->uri->segment(2)=="view")) ? 'active' : ''; ?>" id="menu-project-active" href="<?= base_url(); ?>project"><i class="icon-rocket"></i> 
              <span class="nav-name">Projects Active </span>
              <span class="badge badge-info"><?= $countProjectActive ?></span>
            </a>
          </li>

          <li class="nav-item">
              <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="schedule") ? 'active' : ''; ?>"  href="<?= base_url(); ?>schedule"><i class="fa fa-calendar"></i> 
                <span class="nav-name">Schedule</span>
              </a>
            </li>

          <?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="projects")&&($this->uri->segment(2)=="nonPM") ? 'active' : ''; ?>" id="project-non-pm" href="<?= base_url(); ?>projects/nonPM" ><i class="icon-cursor"></i> 
              <span class="nav-name"> Projects Non PM </span><span class="badge badge-info"><?= $countProjectNonPM ?></span> 
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="projects")&&($this->uri->segment(2)=="candidate") ? 'active' : ''; ?>" id="menu-project-candidate" href="<?= base_url(); ?>projects/candidate"><i class="icon-vector"></i> 
              <span class="nav-name">Projects Candidate </span>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="projects")&&($this->uri->segment(2)=="closed") ? 'active' : ''; ?>" id="menu-project-closed" href="<?= base_url(); ?>projects/closed"><i class="icon-badge"></i> 
            <span class="nav-name">Projects Close</span><span class="badge badge-info"><?= $countProjectClosed ?></span>
            </a>
          </li>
          <?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
            <li class="nav-item">
              <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="project")&&($this->uri->segment(2)=="technical_close") ? 'active' : ''; ?>" id="menu-project-closed" href="<?= base_url(); ?>project/technical_close"><i class="fa fa-asl-interpreting"></i>  
                <span class="nav-name">Projects Tech. Close</span><span class="badge badge-info"><?= $countProjectTClose ?></span>
              </a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
              <a class="nav-link nav-link-hgn <?= $this->uri->segment(2)=="validate_wfm"? 'active' : ''; ?>" id="menu-project-candidate" href="<?= base_url(); ?>utility/validate_wfm"><i class="fa fa-check-square"></i> 
                <span class="nav-name">Validation WFM </span>
              </a>
            </li>
          <?php endif; ?>
          
          <?php if(!empty($this->session->userdata('regional')==0)) :  ?>
            <li class="nav-item">
              <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="bast") ? 'active' : ''; ?>" id="menu-bast" href="<?= base_url(); ?>bast"><i class="fa fa-handshake-o"></i> 
                <span class="nav-name">BAST</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-hgn <?= ($this->uri->segment(1)=="sticky_note") ? 'active' : ''; ?>" id="menu-bast" href="<?= base_url(); ?>timeline/sticky_note"><i class="fa fa-sticky-note"></i> 
                <span class="nav-name">Draft </span> 
              </a>
            </li>
          <?php endif; ?>

          <?php if($this->auth->get_access_value('MONITORING')>1) : ?>
          <li class="nav-item nav-dropdown <?= (($this->uri->segment(1)=="monitoring")||($this->uri->segment(2)=="credit_point")) ? 'open' : ''; ?>">
            <a class="nav-link nav-dropdown-toggle <?= ($this->uri->segment(1)=="monitoring") ? 'active' : ''; ?>" id="menu-monitoring" href="#"><i class="icon-screen-desktop"></i> 
              <span class="nav-name">Monitoring </span>
            </a> 
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="credit_point") ? 'active' : ''; ?>" href="<?= base_url(); ?>timeline/credit_point"><i class="fa fa-trophy"></i> Credit Point <!-- <span class="badge badge-success">New!</span> --></a> 
              </li>


              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="progress") ? 'active' : ''; ?>" href="<?= base_url(); ?>monitoring/progress"><i class="fa fa-chart-line"></i> Progress <span class="badge badge-success">New!</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="acquisition") ? 'active' : ''; ?>" href="<?= base_url(); ?>monitoring/acquisition"><i class="icon-star"></i> Acquisition</a> 
              </li>

              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="pm") ? 'active' : ''; ?>" href="<?= base_url(); ?>monitoring/pm" ><i class="icon-star"></i> Project Manager </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="issueAp") ? 'active' : ''; ?>" href="<?= base_url(); ?>monitoring/issueAp"><i class="icon-star"></i> 
                Issue - Action Plan </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="bast") ? 'active' : ''; ?>" href="<?= base_url(); ?>monitoring/bast"><i class="icon-star"></i> 
                BAST Project</a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn <?= ($this->uri->segment(2)=="lop") ? 'active' : ''; ?>" id="menu-project-active" href="<?= base_url(); ?>monitoring/lop"><i class="icon-star"></i> LOP WIN </a>
              </li>

            </ul>
          </li> 
          <?php endif; ?>
          <?php if(!empty($this->session->userdata('regional')==0)&&$this->auth->get_access_value('BAST')>2) :  ?>
              <li class="nav-item">
                    <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>utility/tools"><i class="icon-puzzle"></i> 
                    <span class="nav-name">Tools </span>
                    </a>
              </li>
          <?php endif; ?>

          <?php if($this->auth->get_access_value('MASTER')>0) : ?>
          <li class="nav-title">
            Admin Menu 
          </li>
          
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>user"><i class="icon-puzzle"></i> Users </a>
          </li>
          <?php 
          if($user_regional == 0) : ?>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/am"><i class="icon-puzzle"></i> Acc. Manager </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/subsidiary"><i class="icon-puzzle"></i> Subsidiary</a>
              </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>timeline/post"><i class="fa fa-thumbtack"></i> Post <span class="badge badge-warning">DEV</span></a> 
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/history"><i class="icon-puzzle"></i> History</a>
          </li>

          <?php if($user_regional == 0) : ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/api"><i class="icon-puzzle"></i> API <span class="badge badge-warning">DEV</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/config"><i class="icon-puzzle"></i> Config <span class="badge badge-warning">DEV</span></a>
          </li>
          <?php endif; ?>

          <?php endif; ?>

        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>




    <!-- Main content -->
    <main class="main">

      <div class="container-fluid">
        <div id="pre-load-background">
        </div>
        <div id="ui-view">
