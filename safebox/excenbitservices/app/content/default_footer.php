<!-- ___________________________<?php echo basename(__FILE__); ?>__________________ -->

<footer class="footer text-muted">
    <div class="container">
      <div class="row align-items-center"> 
        <div class="col-md-4">
          <span class="copyright">Copyright &copy; Excenbit 2020</span>
        </div>
        <div class="col-md-4">
          <ul class="list-inline quicklinks">
            <li class="list-inline-item">
              <a href="support">Support</a>
            </li>
            <li class="list-inline-item quicklinks">
           <a >
           
          </a>
            </li>
          </ul>
          
          </div>
         
        <div class="col-md-4">
        <ul class="list-inline quicklinks">
        
            <li class="list-inline-item">            
             <div class="google_translate_element" id="google_translate_element">
           </div>
           <div 
               id="goog-gt-tt" 
               class="goog-tooltip skiptranslate"  >
           </div>   
           </li>
          </ul>
        </div>
        </div>
      </div>
    </div>
</footer>

<!-- Custom Scripts for this Template -->
<script src="public/assets/js/agency.js"></script>

<!-- ASYNCHRONOUS Google Translate -->
<script type="text/javascript">
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'id', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false},'google_translate_element');
      }

      (function() {
        var googleTranslateScript = document.createElement('script');
        googleTranslateScript.type = 'text/javascript';
        googleTranslateScript.async = true;
        googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( googleTranslateScript );
      })();
      function changeGoogleStyles() {
        if(($goog = $('.goog-te-menu-frame').contents().find('body')).length) {
        var stylesHtml = '<style>'+
            '.goog-te-menu2 {'+
                'width:100% !important;'+
                'overflow-x:scroll !important;'+
                'box-sizing:border-box !important;'+
                'height:auto !important;'+
            '}'+
        '</style>';
        $goog.prepend(stylesHtml);
    } else {
        setTimeout(changeGoogleStyles, 50);
    }
        }
        changeGoogleStyles();
</script>   
