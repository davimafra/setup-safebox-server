<?php
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



<section class="page-section">
    <div class="container"> 
        <div class="row">
            <div class="col-lg-12 text-left">      
                                  
                <h4>NEW PAGE</h4>
                <h3 class="section-subheading text-muted">Get discount if you have an Excencode promo code.</h3> 
                    
            </div>
        </div>
    </div>
</section>




<?php include (BASE_LOCAL."/app/content/default_footer.php"); ?>
<!-- Custom Scripts for this View -->
<script></script>

    

</body>
</html>