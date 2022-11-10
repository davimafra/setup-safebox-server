<?php
//________________________________API EXECUTION_____________________________________
$doc_root = $_SERVER['DOCUMENT_ROOT'].'/excenbitservices';
require_once ($doc_root.('/app/config.php'));
//________________________________VIEW_____________________________________
//debug info
if (DEBUG_MODE){
    echo '<br>';
    $current_php = __FILE__;
    echo 'INIT VIEW FILE: '.$current_php;
    echo '<br>';    
}

include (BASE_LOCAL."/app/content/default_header.php");
?>

<!-- Custom javascript for this View  -->
<script></script>

<!-- Custom Style for this View -->
<style></style>

<?php include (BASE_LOCAL."/app/content/default_navbar.php"); ?>

<!-- Custom View Content  -->
<!-------------------------------- spinner center------------------------------>
<div id ="spinner_center" class="container-fluid" style="display: none;">
    <div class="text-center" style="position:fixed;top:50%;left:50%">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Running...</span>
        </div>
    </div>    
</div>
<!--------------------------------------------------------------------->
<!-------------------------------- result feedback------------------------------>
<section id="req_result" style="display: none;">
    <div class="row">    
    <div class="col-lg-12 text-left">
        <div class="container">        
            <h4 id="result_error" class="text-danger"></h4>
            <h4 id="result_success" class="text-success"></h4>            
            <h6 id="result_info" class="text-muted"></h6>
            <h6 id="result_info2" class="text-muted"></h6>
            <br>
            <br>  
            <h6 ><a class="text-info" id="goback" href="excenbitservices"></a>Sair</h6>          
            <br><br><br><br><br><br><br>
            <br>
            <br>       
        </div>  
    </div>
    </div>
</section>
<!--------------------------------------------------------------------->


<?php include (BASE_LOCAL."/app/content/footer_tools.php"); ?>
<!-- Custom Scripts for this View -->
<script>
const BASE_URL = "<?php echo BASE_URL; ?>";
const url_controller = "<?php echo BASE_URL.'public/assets/jquery/ajax_controller.php'; ?>";
const url_view = "<?php echo BASE_URL.'public/assets/jquery/ajax_view.php'; ?>";



var intTime1 = setInterval(update_interval1, 10000); 
    function update_interval1() {
    
    loadprocess();
    }



//_____________________________________________LOAD PROCESS_____________________________________
function loadprocess(file){
    
    $('#spinner_center').show();
    $('#req_result').hide();
    
    
    var file = "run_services";
      

    $.ajax({
        type: "POST",
        url: url_controller,
        dataType: "html",
        data: {_file:file},
        success : function(data){
        if ($.trim(data) == 'error') {
            $('#result_success').html('');
            $('#result_error').html('error');
            
        } else {
            $('#result_success').html(data);
            $('#result_error').html('');
           
    		
        }
       $('#result_info').html('servico executado');
        },
        error: function(data){
            $('#result_success').html('');
            $('#result_error').html('error');
            $('#result_info').html('erro no teste');
        },
        complete: function(data){
            $('#spinner_center').hide();
            $('#req_result').show();        
            
            
        }
    });

}


$(document).ready(function() {
    
    

  
  });



</script>

    

</body>
</html>