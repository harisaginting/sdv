/*****
* CONFIGURATION 
*/

//Main navigation
$.navigation = $('nav > ul.nav');

$.panelIconOpened = 'icon-arrow-up';
$.panelIconClosed = 'icon-arrow-down';

//Default colours
$.brandPrimary =  '#20a8d8';
$.brandSuccess =  '#4dbd74';
$.brandInfo =     '#63c2de';
$.brandWarning =  '#f8cb00';
$.brandDanger =   '#f86c6b';

$.grayDark =      '#2a2c36';
$.gray =          '#55595c';
$.grayLight =     '#818a91';
$.grayLighter =   '#d1d4d7';
$.grayLightest =  '#f8f9fa';

'use strict';

/****
* MAIN NAVIGATION
*/

$(document).ready(function($){
 $('#pre-load-background').fadeOut();
  setFunction();
// bootbox.alert("Selamat Datang di versi development PRIME, modul yang sedang dikerjakan saat ini adalah, <br>1. Project Active <br>2. Project Candidate <br>3. Project Non PM, <br>4. Project Closed <br>5. BAST <br>6. Monitoring->Project Manager", function(){ 
    /*var hash = window.location.hash;
    hash_replace1 = hash.replace(/-/g, '/');
    hash_replace2 = hash_replace1.replace(/#/g, '');
    hash_replace2 = hash_replace2.replace(/%h/g,'-');

    if(hash_replace2!=null&&hash_replace2!=""){
      console.log(hash_replace2);
      setPage(base_url+hash_replace2);
      var sidebar_id  = hash_replace2.split('/');
      sidebar_id      = sidebar_id[0];
      console.log(sidebar_id);

    }else{
      setPage(base_url+'dashboard/main');
    }*/

  // Add class .active to current link
  /*$.navigation.find('a').each(function(){

    var cUrl = String(window.location).split('?')[0];

    if (cUrl.substr(cUrl.length - 1) == '#') {
      cUrl = cUrl.slice(0,-1);
    }

    if ($($(this))[0].href==cUrl) {
      $(this).addClass('active');

      $(this).parents('ul').add(this).each(function(){
        $(this).parent().addClass('open');
      });
    }
  });*/

  // Dropdown Menu
  $.navigation.on('click', 'a', function(e){

    if ($.ajaxLoad) {
      e.preventDefault();
    }

    if ($(this).hasClass('nav-dropdown-toggle')) {
      $(this).parent().toggleClass('open');
      resizeBroadcast();
    }

  });

  function resizeBroadcast() {

    var timesRun = 0;
    var interval = setInterval(function(){
      timesRun += 1;
      if(timesRun === 5){
        clearInterval(interval);
      }
      window.dispatchEvent(new Event('resize'));
    }, 62.5);
  }

  /* ---------- Main Menu Open/Close, Min/Full ---------- */
  $('.sidebar-toggler').click(function(){
    $('body').toggleClass('sidebar-hidden');
    resizeBroadcast();
  });

  $('.sidebar-minimizer').click(function(){
    $('body').toggleClass('sidebar-minimized');
    resizeBroadcast();
  });

  $('.brand-minimizer').click(function(){
    $('body').toggleClass('brand-minimized');
  });

  $('.aside-menu-toggler').click(function(){
    $('body').toggleClass('aside-menu-hidden');
    resizeBroadcast();
  });

  $('.mobile-sidebar-toggler').click(function(){
    $('body').toggleClass('sidebar-mobile-show');
    resizeBroadcast();
  });

  $('.sidebar-close').click(function(){
    $('body').toggleClass('sidebar-opened').parent().toggleClass('sidebar-opened');
  });

  /* ---------- Disable moving to top ---------- */
  $('a[href="#"][data-top!=true]').click(function(e){
    e.preventDefault();
  });

});

/****
* CARDS ACTIONS
*/

$('.card-actions').on('click', 'a, button', function(e){
  e.preventDefault();

  if ($(this).hasClass('btn-close')) {
    $(this).parent().parent().parent().fadeOut();
  } else if ($(this).hasClass('btn-minimize')) {
    // var $target = $(this).parent().parent().next('.card-body').collapse({toggle: true});
    if ($(this).hasClass('collapsed')) {
      $('i',$(this)).removeClass($.panelIconOpened).addClass($.panelIconClosed);
    } else {
      $('i',$(this)).removeClass($.panelIconClosed).addClass($.panelIconOpened);
    }
  } else if ($(this).hasClass('btn-setting')) {
    $('#myModal').modal('show');
  }

});

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function init(url) {

  /* ---------- Tooltip ---------- */
  $('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});

  /* ---------- Popover ---------- */
  $('[rel="popover"],[data-rel="popover"],[data-toggle="popover"]').popover();

}

  /*$(document).on('click', '.nav-link-hgn', function(e) {
    e.preventDefault();
    var url_menu = $(this).data('url');
    setPage(url_menu);
    url_menu = url_menu.split("/");
    if(url_menu[6]!=null){
      console.log(url_menu);
      url_menu[6] = url_menu[6].replace(/-/g,'%h');
      console.log(url_menu);
      var hashapp = url_menu[4] + '-' + url_menu[5]+'-'+ url_menu[6];
    }else if(url_menu[5]!=null){
      var hashapp = url_menu[4] + '-' + url_menu[5];
    }else{
       var hashapp = url_menu[4];
    }
    window.location.hash = hashapp;
    $('.nav-link').removeClass('active');
    $(this).addClass('active');
  });*/

function setPage(url) {
  setHash(url);
  $('#pre-load-background').fadeIn();
  $( "#ui-view" ).load( url, { author : 'harisa' }, function() {
    setFunction();
    $('#pre-load-background').fadeOut();
  });
}


function setHash(url_menu){
  url_menu = url_menu.split("/");
    if(url_menu[6]!=null){
      console.log(url_menu);
      url_menu[6] = url_menu[6].replace(/-/g,'%h');
      var hashapp = url_menu[4] + '-' + url_menu[5]+'-'+ url_menu[6];
    }else if(url_menu[5]!=null){
      var hashapp = url_menu[4] + '-' + url_menu[5];
    }else{
       var hashapp = url_menu[4];
    }
    window.location.hash = hashapp;
}

function loadJS(jsFiles, pageScript) {

  var body = document.getElementsByTagName('body')[0];

  for(var i = 0; i<jsFiles.length; i++){
    appendScript(body, jsFiles[i])
  } 

  if (pageScript) {
    appendScript(body, pageScript)
  }

  init();
}

function appendScript(element, src) {
  var async = (src.substring(0, 4) === 'http');
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.async = async;
  script.defer = async;
  script.src = src;
  async ? appendOnce(element, script) : element.appendChild(script);
}

function appendOnce(element, script) {
  var scripts = Array.from(document.querySelectorAll('script')).map(function(scr){return scr.src;});

  if (!scripts.includes(script.src)) {
    element.appendChild(script)
  }
}


function setFunction(){
  $(".Jselect2").select2();
  $('.date-picker').datepicker({
      format: "mm/dd/yyyy",
      disableTouchKeyboard : false,
      toggleActive: true,
      forceParse: false,
      autoclose: true
  });

  $(".date-picker").attr("autocomplete","off");
  $(".form-control").attr("autocomplete","off");

  $('.rupiah').priceFormat({
      prefix: 'Rp. ',
      centsSeparator: ',',
      thousandsSeparator: '.',
      centsLimit: 0
  });
  $('.fileinput').fileinput();

  $('table').on( 'draw.dt', function () {
      $('.rupiah').priceFormat({
                            prefix: '',
                            centsSeparator: ',',
                            thousandsSeparator: '.',
                            centsLimit: 0
                        });
  });

};


 // RELOAD WHEN PAGE BACK OR FORWARD
  window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                           ( typeof window.performance != "undefined" && 
                                window.performance.navigation.type === 2 );
    if ( historyTraversal ) {
      // Handle page restore.
      window.location.reload();
    }
  });


// TOOLTIP
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

