
const BASE_URL = "<?php echo BASE_URL; ?>";
const url_controller = "<?php echo BASE_URL.'public/assets/jquery/ajax_controller.php'; ?>";
const url_view = "<?php echo BASE_URL.'public/assets/jquery/ajax_view.php'; ?>";


//______________________________________________SUBMIT DEFAULT MODAL__________________________________________________________________________
function btn_submit1(id,reload) {//default submit button
  text = $('#'+id).html();//get button text
  $('#'+id).blur();
  $('#'+id).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
  $('#'+id).prop('disabled', true);
  $('#modal1').modal('hide');
  
  $.ajax({
  type: "POST",
  url: url_controller,
  dataType: "html",
  data: {_file:file,_filter:filter,_param:param,_data_array:data_array},  
      success : function(data){
          if ($.trim(data) == 'success') {
              //$('#'+id+'_alert').html('<div class="text-success text-left"><strong>Success! </strong> operation performed successfully.</div>');                
              if (reload == true){                      
                  //window.location.replace(BASE_URL+'settings/logoff');                
                  window.location.reload(); 
              }else{
                  //$('#'+id+'_alert').html('<div class="text-success text-left"><strong>Success! </strong> operation performed successfully.</div>');
              }
          }else{
              if ($.trim(data) == 'error') {//default msg              
                  $('#'+id+'_alert').html('<div class="text-danger text-left"><strong>Sorry! </strong> we are unable to fulfill your request at this time.</div>');         
              }else{//custom msg
                  $('#'+id+'_alert').html('<div class="text-danger text-left"><strong></strong>'+data+'</div>');
              }
          }
      },
      error: function(data){
          $('#'+id+'_alert').html('<div class="text-danger text-left"><strong>Sorry! </strong> we are unable to fulfill your request at this time.</div>');         
      },
      complete: function(data){
          //complete    
          $('#'+id).html(text);
          setTimeout(function() {//clear msg
            $('#'+id+'_alert').html('');
            $('#'+id).prop('disabled', false);
          }, 7000);    
      }
  });  

} 




//______________________________________________SUBMIT DEFAULT__________________________________________________________________________
function btn_submit_default(id,text,reload,file,param) {//default submit button
    text = $('#'+id).html();//get button text
    $('#'+id).blur();
    $('#'+id).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
    $('#'+id).prop('disabled', true);
    //$('#modal1').modal('hide');
    
    $.ajax({
    type: "POST",
    url: url_controller,
    dataType: "html",
    data: {_file:file,_filter:filter,_param:param,_data_array:data_array},  
        success : function(data){
            if ($.trim(data) == 'success') {
                //$('#'+id+'_alert').html('<div class="text-success text-left"><strong>Success! </strong> operation performed successfully.</div>');                
                if (reload == true){                      
                    //window.location.replace(BASE_URL+'settings/logoff');                
                    window.location.reload(); 
                }else{
                    //$('#'+id+'_alert').html('<div class="text-success text-left"><strong>Success! </strong> operation performed successfully.</div>');
                }
            }else{
                if ($.trim(data) == 'error') {//default msg              
                    $('#'+id+'_alert').html('<div class="text-danger text-left"><strong>Sorry! </strong> we are unable to fulfill your request at this time.</div>');         
                }else{//custom msg
                    $('#'+id+'_alert').html('<div class="text-danger text-left"><strong></strong>'+data+'</div>');
                }
            }
        },
        error: function(data){
            $('#'+id+'_alert').html('<div class="text-danger text-left"><strong>Sorry! </strong> we are unable to fulfill your request at this time.</div>');         
        },
        complete: function(data){
            //complete    
            $('#'+id).html(text);
            $('#'+id).prop('disabled', false);
            setTimeout(function() {//clear msg
                $('#'+id+'_alert').html('');
            }, 7000);    
        }
    });  

} 



//______________________________________________VALIDATE PRICE__________________________________________________________________________
function validate_price(id,label,decimals) {

    price = $('#'+id).val().replace(/,/g, "");
    if(isNaN(price) || price < 0){//not number           
    $('#'+id).val("");
    $('#'+id).addClass("is-invalid"); 
    $('#'+id+'_invalid').html("Invalid price");
    return false;
    } 
    price = Number(price);      
  
    if (price == 0){                  
    $('#'+id).addClass("is-invalid"); 
    $('#'+id+'_invalid').html("Invalid price");
    return false;              
    }
    $('#'+id).val(price.toFixed(decimals)); 
    $('#'+id).removeClass("is-invalid");           
    $('#'+id+'_invalid').html("");           
    return true;  
  
    }

    //_______________________________________________VALIDATE AMOUNT_________________________________________________________________________
 function validate_amount(id,label,decimals,available,min,max) {
  
    amount = $('#'+id).val().replace(/,/g, "");      
    if(isNaN(amount) || amount < 0){//not number           
    $('#'+id).val("");
    $('#'+id).addClass("is-invalid"); 
    $('#'+id+'_invalid').html("Invalid amount");
    return false;
    }        
    amount = Number(amount);//type string
    $('#'+id).val(amount.toFixed(decimals));
    available = Number(available);//type string
    if (amount > available){       
      $('#'+id).addClass("is-invalid"); 
      $('#'+id+'_invalid').html("Insufficient funds");      
      return false;       
    }               
    if (amount < min){              
      $('#'+id).addClass("is-invalid"); 
      $('#'+id+'_invalid').html("minimal amount: "+Number(min).toFixed(decimals)+' '+label);      
      return false;              
    }
    if (amount > max){                   
      $('#'+id).addClass("is-invalid"); 
      $('#'+id+'_invalid').html("maximum amount: "+Number(max).toFixed(decimals)+' '+label);      
      return false; 
    }
    $('#'+id).removeClass("is-invalid");           
    $('#'+id+'_invalid').html("");           
    return true;  
  
  } 

//______________________________________________INPUT CLICK____________________________________
function inputclick(id) {
  //onclick="inputclick(this.id);"
  $('#input1').prop('readonly', false);
  $('#btn_rename').prop('disabled', false);
}

  //_________________________________________________INPUT CHANGE _________________________________
function inputchange(id,label) {
  
    //onchange="inputchange(this.id,'null','sample','user_id >0\',this.value);"
    switch(id) {
    
    case 'input1':
      result = validate_amount(id,label,8,1000.01,0.001,999999);
      if (result){      
        amount_valid = true;
        if (price_valid){              
          $("#btn_submit1").prop('disabled', false);       
        } 
      }else{
        amount_valid = false;
        $("#btn_submit1").prop('disabled', true);      
      }                 
  
      // code block
      break;
  
      case 'input2':
        result = validate_price(id,label,2);
        if (result){      
          price_valid = true;
          if (amount_valid){              
            $("#btn_submit1").prop('disabled', false);          
          } 
        }else{
          price_valid = false;
          $("#btn_submit1").prop('disabled', true);
        }
      // code block
      break;

      case 'input3'://text
        inputtxt = $('#'+id).val();
        if (validate_text(inputtxt)){
          $('#btn_rename').prop('disabled', false);
          $('#'+id).removeClass("is-invalid");           
          $('#'+id+'_invalid').html("");
        }else{
          $('#btn_rename').prop('disabled', true);
          $('#'+id).addClass("is-invalid"); 
          $('#'+id+'_invalid').html('invalid characters')      
        }
  
    default:
      // code block
    }   
      
   } 

//_____________________________________________LIST CHANGE_____________________________________
function listchange(id,file) { 
  
  switch(id) {
  case 'list_pairs':
    listval = $('#'+id).val(); 
    text = $('#'+id+' option:selected').text(); 
    if (listval == ''){
      $('#btn_submit1').prop('disabled', true);
    }else{
      $('#btn_submit1').prop('disabled', false);
      alert('listval:'+listval+' text:' + text);
    }
  break;
  case 'list1':
    file = 'account/getborrow/list2'
    param = $('#'+id).val(); 
    
    $('#resume').hide();   
    $('#list2').load(url_view, {_file:file,_param:param});
    setTimeout(function() {
        calctotal();
    }, 500);
  break;
  case 'list2':     
    

  break;

  default:
    // code block
  }   
    
} 

 //_____________________________________________BUTTON CLICK_____________________________________
 function buttonclick(id,file,param,filter) { 
  //onclick="buttonclick(this.id,'componentes/list1','sample','user_id = 1','null');"
  alert(id);
  $('#'+id).blur();
  switch(id) {
  case 'btn_1':
    
  break;
   

  default:
    // code block
  }   
    
} 

//________________________________________________CHECK CLICK__________________________________
function checkclick(id) {
  
  if ($('#check1').is(":checked")){    
      if ($('#check2').is(":checked")){
          $("#btn_submit2").prop('disabled', false);
      }else{
          $("#btn_submit2").prop('disabled', true);
      }   
  }else{
      $("#btn_submit2").prop('disabled', true);
  }
}


//________________________________________________RADIO CLICK__________________________________
function radioclick(id) {
  
  if ($('#radio2').is(":checked")){    
      paymin = 1; 
  }else{
      paymin = 0; 
  }
  alert(paymin);
}

//_________________________________________________SLIDER CHANGE _________________________________
function sliderchange(id) {
  //onchange="sliderchange(this.id);"
    result = $('#'+id).val(); 
    $('#result').html(result+'%');         
} 


//______________________________________________SUBMIT FEEDBACK__________________________________________________________________________
function btn_submit_3(id,reload,file,param,filter,data_array) {//default submit button
    
  $('#main_body').hide();
  $('#spinner_center').show();
  $('#modalx').modal('hide');

  param = $('#total').html();
  data_array = null;
  var file = "_ajax_controller"; 
  $.ajax({
  type: "POST",
  url: url_controller,
  dataType: "html",
  data: {_file:file,_filter:filter,_param:param,_data_array:data_array},  
      success : function(data){
          if ($.trim(data) == 'success') {
              $('#spinner_center').hide();
              $('#req_result').show();
              $('#result_success').html('Operation successfully performed!');                
              $('#result_info').html('thanks for your purchase. your product is now available for use.');
              setTimeout(function() {//clear msg
                  window.location.replace(BASE_URL);
              }, 3000); 
              if (reload == true){  
                                 
                  window.location.reload(); 
              }else{
                  //$('#'+id+'_alert').html('<div class="text-success text-left"><strong>Success! </strong> operation performed successfully.</div>');
              }
          }else{
              if ($.trim(data) == 'error') {//default msg              
                  $('#spinner_center').hide();
                  $('#req_result').show();
                  $('#result_error').html('Sorry, but we were unable to fulfill your request at this time.');                
                  $('#result_info').html('an error occurred while processing your request');
                  $('#goback').html('Go Back');         
              }else{//custom msg
                  $('#spinner_center').hide();
                  $('#req_result').show();
                  $('#result_error').html(data);                
                  $('#result_info').html($.trim(data));
                  $('#goback').html('Go Back'); 
              }
          }
      },
      error: function(data){
        $('#spinner_center').hide();
        $('#req_result').show();
        $('#result_error').html('Sorry, but we were unable to fulfill your request at this time.');                
        $('#result_info').html('an error occurred while processing your request');
        $('#goback').html('Go Back');
      },
      complete: function(data){
          //complete    
          $('#spinner_center').hide();
          $('#req_result').show();
             
      }
  });  

} 

//_________________________________________________INPUT BLUR _________________________________
function inputblur(id){
  
  var file = "check_nickname";
  param = $('#'+id).val();    
  if (param.length < 10){                    
    $("#btn_submit").prop('disabled', false);       
    $("#btn_submit").prop('disabled', true);    
      $('#'+id).addClass("is-invalid"); 
      $('#'+id+'_invalid').html('minimum 10 characters');
      teste = $('#input4_invalid').html();
      
      alert(teste);
    return false;      
  }
  
  $.ajax({
    type: "POST",
    url: url_controller,
    dataType: "html",
    data: {_file:file,_param:param},
    success : function(data){
    if ($.trim(data) == 'success') {
      $("#btn_submit").prop('disabled', false);
      $('#'+id).addClass("is-valid");
      $('#'+id).removeClass("is-invalid"); 
      $('#'+id+'_invalid').html("valid nickname");   
    } else {
      
      $("#btn_submit").prop('disabled', true);    
      $('#'+id).addClass("is-invalid"); 
      $('#'+id+'_invalid').html(data);
     
    }
    },
    error: function(data){
      $("#btn_submit").prop('disabled', true);    
      $('#'+id).addClass("is-invalid"); 
      $('#'+id+'_invalid').html('invalid field')
    },
    complete: function(data){
      
    }
  });
  
  }
//________________________________________________TEXT INPUT VALIDATION________________________________________
  function validate_text(text) {
    var regexp1=new RegExp("^[0-9A-Za-z_ .-]+$");

    if (!regexp1.test(text)) {
       return false;
    } else {
        return true;
    }
}




  $(document).ready(function() {
    //______________________________________________________________SLIDER_______________________________________________________
    $("#customRange2").on("input change", function(e) {
      result2 = $(this).val();
        $('#result2').html(result2+'%'); 
    });
  
  });