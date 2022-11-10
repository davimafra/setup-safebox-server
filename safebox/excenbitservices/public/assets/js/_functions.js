







function btn_submit_default(id,text,reload,file,table,param,filter,data_array) {//default submit button
    $('#'+id).blur();
    $('#'+id).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
    $('#'+id).prop('disabled', true);

    $.ajax({
    type: "POST",
    url: url_controller,
    dataType: "html",
    data: {_file:file,_table:table,_filter:filter,_param:param,_data_array:data_array},  
        success : function(data){
            if ($.trim(data) == 'success') {            
            if (reload == true){  
                //window.location.replace("http://www.w3schools.com");                
                window.location.reload(); 
            }else{
                //$('#'+id+'_alert').html('<div class="text-success text-left"><strong>Success! </strong> operation performed successfully.</div>');
            }
            }else{
                if ($.trim(data) == 'error') {//default msg              
                    $('#'+id+'_alert').html('<div class="text-danger text-left"><strong>Sorry! </strong> we are unable to fulfill your request at this time.</div>');         
                }else{//custom msg
                    $('#'+id+'_alert').html('<div class="text-danger text-left"><strong>Sorry! </strong>custom msg.</div>');
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