/*window.onbeforeunload = function() {
      return true;
      };*/

jQuery.validator.addMethod("checkPassword", function(value, element)
 {
     var response;
     var url      = base_url + "user/checkPassword";
     
         $.ajax({
                type: "POST",
                url: url,
                data: {value : value},
                dataType: "json",
                async: false
         }).done(function(result){
             console.log(result.status);
              if(result.status == true){
                  response = false;
              }else{
                  response = true;    
              }
         });
         return response;
 }, "Your Current Password not match");


jQuery.validator.addMethod("checkId", function(value, element)
{
     var response;
     var url      = base_url + "user/checkId";
     
         $.ajax({
                type: "POST",
                url: url,
                data: {value : value},
                dataType: "json",
                async: false
         }).done(function(result){
             console.log(result.status);
              if(result.status == true){
                  response = false;
              }else{
                  response = true;    
              }
         });
         return response;
 }, "This ID has been used");


jQuery.extend(jQuery.validator.messages, {
                equalTo: jQuery.validator.format("Make Sure Have same Value")
            });  

$('form').validate({
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function(element) {
                $(element).closest('.form-group').addClass('errors');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('error');
            },
            success: function(element){
                $(element).closest('.form-group').removeClass('error');
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter(element.next('span')); 
                } else {
                    error.insertAfter(element);            
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        }); 


/*$(document).on("click","a",function() {
     window.onbeforeunload = null;
});*/

