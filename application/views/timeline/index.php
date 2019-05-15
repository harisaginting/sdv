<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }

    #billboard-bast > .col-md-2{
      padding-left: 5px;
      padding-right: 5px;
    }

    #billboard-bast > .col-md-1{
      padding-left: 5px;
      padding-right: 5px;
    }

    #billboard-bast{
      padding-left: 20px !important;
      padding-right: 20px !important;
    }

    .card-footer{
      background-color: #f0f0f0;
    }

    .card-footer-last{
      border-bottom-left-radius: 9px;
      border-bottom-right-radius: 9px;
    }

    .card-header{
      background-color: #ffffff;
    }

    .p-comment{
      border : 0.5px #c2cfd6 solid;
      padding : 5px;
    }

    .card, .card-header{
      border-radius: 0px;
    }

    .card-footer-last{
      border-radius: 0px;
    }
</style>

 
 


<div class="container-fluid container-content">
  <div class="row" style="margin-top: 20px;">
    <div class="col-md-10 offset-md-1">
      <div class="col-md-12">


      <?php foreach ($feed as $key => $value) : ?>
          <div class="card">
              <div class="card-header <?= $value['CATEGORY'] == 'EVENT'? 'bg-success' : '' ?>">
                <img src="<?= !empty($value['PHOTO_URL']) ? $value['PHOTO_URL'] : base_url().'assets/img/avatars/default.png';?>" class="img-avatar" alt="<?= $this->session->userdata('nama_sess')?>
                class="img-avatar" alt="<?= $value['CREATED_BY']; ?>" height="30">&nbsp;&nbsp;&nbsp;
                <?= $value['CREATED_BY'] == '401820' ? 'Administrator' : $value['NAMA'] ; ?>
                <span class="float-right h6"> <?= $value['DATE_EVENT2'] ?> </span>
              </div>
              <div class="card-body">
               <?php if(!empty($value['IMAGE'])) : ?>
               <div class="row">
                  <div class="col-md-4 offset-md-4">
                    <img style="width: 100%;" src="<?= base_url().'../post_picture/'.$value['IMAGE'] ?>" class="circle2">  
                  </div> 
               </div> 
             <?php endif; ?>

               <div class="row">
                <div class="col-md-12">
                   <?php if($value['CATEGORY']=='DELIVERABLE'): ?>
                      <?= $value['CONTENT'] ?> <a href="<?=base_url();?>projects/view/<?= $value['TITLE'] ?>"><?= $value['TITLE'] ?></a>  
                   <?php elseif($value['CATEGORY']=='ISSUE'): ?>
                      <?= $value['CONTENT'] ?> <a href="<?=base_url();?>projects/view/<?= $value['TITLE'] ?>"><?= $value['TITLE'] ?></a>
                   <?php elseif($value['CATEGORY']=='ACTION PLAN'): ?>
                      <?= $value['CONTENT'] ?> <a href="<?=base_url();?>projects/view/<?= $value['TITLE'] ?>"><?= $value['TITLE'] ?></a>
                    <?php elseif($value['CATEGORY']=='SYMTOM'): ?>
                      <?= $value['CONTENT'] ?> <a href="<?=base_url();?>projects/view/<?= $value['TITLE'] ?>"><?= $value['TITLE'] ?></a>
                   <?php else : ?>
                      <?= $value['CONTENT'] ?>
                   <?php endif; ?>
                </div>            
               </div> 
              
              </div>
              
              <div class="card-footer">
                <div class="col-md-12">
                  <span class="pull-right" > Credit : <?= $value['PIC'] ?></span>
                </div>
                <div class="col-md-12">
                  <span class="cursor-pointer btnCommendTimeline" data-id = "<?= $value['ID'] ?>"><i class="fa fa-thumbs-up"></i> Like</span>&nbsp;&nbsp;&nbsp;&nbsp;
                  <span class="cursor-pointer btnLikeTimeline" data-id = "<?= $value['ID'] ?>"><i class="fa fa-comment"></i> Comment</span>
                </div>
              </div>

              <div class="card-footer card-footer-last">
                
                <div class="col-md-12">
                  <span class="h5">User</span>            
                  <p class="p-comment"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.   </p>
                </div>
                <form class="col-md-12">
                  <textarea id="textarea-input" name="textarea-input" rows="2" class="form-control" placeholder="Write something"></textarea>
                </form>
              </div>

            </div>
      <?php endforeach; ?>


      <!-- <div class="card">
        <div class="card-header">
          <img src="../user_picture/401820profile-picture-401820.png" class="img-avatar" alt="admin@bootstrapmaster.com" height="30">&nbsp;&nbsp;&nbsp;
          User
          <span class="float-right"> <?= date('d F Y') ?> </span>
        </div>

        <div class="card-body">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex
        ea commodo consequat.
        </div>
        
        <div class="card-footer">
          <div class="col-md-12">
            <span><i class="fa fa-thumbs-up"></i> Like</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><i class="fa fa-comment"></i> Comment</span>
          </div>
        </div>

        <div class="card-footer card-footer-last">
          
          <div class="col-md-12">
            <span class="h5">User</span>            
            <p class="p-comment"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.   </p>
          </div>
          <form class="col-md-12">
            <textarea id="textarea-input" name="textarea-input" rows="2" class="form-control" placeholder="Write something"></textarea>
          </form>
        </div>

      </div> -->


    </div>
    </div>
  </div>
</div>

<script type="text/javascript">    
  var Page = function () {
    var tableInit = function(){    
        
    };    
      return {
          init: function() { 
            tableInit();
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>