<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.png">
  <title>PRIME</title>

  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> 
  <link rel="stylesheet" href='<?= base_url(); ?>assets/css/login/login.css?v<?= date('dmyhi'); ?>'></link>
  <link href="<?= base_url(); ?>assets/plugin/bootstrap3/css/bootstrap.css" rel="stylesheet">

  <script type="text/javascript">
      var base_url = "<?= base_url(); ?>";
  </script>
  <script src="<?= base_url(); ?>assets/plugin/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src='https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/EasePack.min.js'></script>
  <script src='https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/TweenLite.min.js'></script>

   <script src="<?= base_url(); ?>assets/js/login.js"></script>

   <style type="text/css">
     .sdv-text{
      font-size: 14px;
      font-weight: 900;
      font-style: bold;
      color: #fff;
     }
   </style>
</head>

<body>
<div class="header" style="padding: 2px; z-index: 10;min-height: 50px;min-width:100%; float: top;/*background: #f00;*/ position: fixed;opacity: 0.9;">
    <img src="<?= base_url();?>/assets/img/telkomsolution.png" style="float: right !important;margin-top: 5px;margin-right: 10px;" ="" alt="" width="150" >
</div>
  <div id="large-header" class="large-header"> 
    <canvas id="demo-canvas"></canvas>
    <span class="main-title">
      <h1><span>PRIME</span></h1>
      <span class="thin"><h3>Project Reporting and Monitoring for Enterprise</h3></span>
    </span>
  </div>

  <div class="container row" style="margin: 0px !important;z-index: 10 !important;">
      <div class="container-forms col-md-1">
            <div class="container-info">
              <div class="info-item">
                <div class="table">
                  <div class="table-cell">
                    <p>
                      Have an account?
                    </p>
                    <div class="btn">
                      Log in
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="info-item">
                <div class="table">
                  <div class="table-cell">
                    <p>
                      Don't have an account? 
                    </p>
                    <div class="btn">
                      Sign up
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
            <div class="container-form">
              <div class="form-item log-in">
                <img src="<?= base_url();?>assets/img/53.png" style="height: 90px;"> <span class="sdv-text">&nbsp;&nbsp;&nbsp; Service Delivery DES</span>
                <div class="table">
                      <div class="table-cell" style="padding-top: 20px !important;vertical-align: inherit;">
                        <form action="<?= base_url(); ?>/login/login_proccess" method="post" accept-charset="utf-8" style="" autocomplete="off">
                            <input name="nik" placeholder="ID / NIK" type="text">
                            <input name="password" placeholder="Password" type="Password">
                            <button type="submit" class="btn" style="">Sign In</button>  
                        </form>
                        <br>
                        <!-- <span class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://prime.telkom.co.id/V2" style="color: #ffd200">Use Previous Version</a></span> -->
                         <?=$this->session->flashdata('alError')?> 
                      </div>
                  
                </div>
              </div>
              <div class="form-item sign-up">
                <div class="table">
                  <div class="table-cell">
                    <form action="<?= base_url(); ?>login/registration_mitra" method="POST" class="form-horizontal" id="form_registration" style="padding:10px;" novalidate="novalidate">
                    <input name="id" id="id" value="" class="input-group" placeholder="Gunakan ID LDAP" type="text" required="" aria-required="true">
                    <input name="nama" value="" placeholder="Full Name" id="nama" type="text" required="" aria-required="true">
                    <input type="number" name="telepon" value="" placeholder="Phone Number" required="" aria-required="true">
                    <input type="email" name="email" value="" placeholder="Email" id="emailUser" required="" aria-required="true">
                    <button type="submit" class="btn">Sign Up</button> 
                  </form>
                  </div>
                </div>
              </div>
            </div>
      </div>
  </div>
 

</body>

</html>
















<!-- SCRIPT -->

<script type="text/javascript">
  $(".info-item .btn").click(function(){
      $(".container").toggleClass("log-in");
      });

  (function() {

    var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

    // Main
    initHeader();
    initAnimation();
    addListeners();

    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: width/2, y: height/2};

        largeHeader = document.getElementById('large-header');
        largeHeader.style.height = height+'px';

        canvas = document.getElementById('demo-canvas');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        // create points
        points = [];
        for(var x = 0; x < width; x = x + width/20) {
            for(var y = 0; y < height; y = y + height/20) {
                var px = x + Math.random()*width/20;
                var py = y + Math.random()*height/20;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
            points[i].circle = c;
        }
    }

    // Event handling
    function addListeners() {
        if(!('ontouchstart' in window)) {
            window.addEventListener('mousemove', mouseMove);
        }
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function mouseMove(e) {
        var posx = posy = 0;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        target.x = posx;
        target.y = posy;
    }

    function scrollCheck() {
        if(document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
    }

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height+'px';
        canvas.width = width;
        canvas.height = height;
    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.7;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.draw();
            }
        }
        requestAnimationFrame(animate);
    }

    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba(255,255,255,'+ p.active+')';
            ctx.stroke();
        }
    }

    function Circle(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 10 * Math.PI, false);
            ctx.fillStyle = 'rgba(243,13,13,'+ _this.active+')';
            ctx.fill();
        };
    }

    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }
    
})();
</script>