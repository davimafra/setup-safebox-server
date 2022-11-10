<!DOCTYPE html>
<html lang="en">

<?php 
$raiz = $_SERVER['DOCUMENT_ROOT'];
//include $raiz . '/app/model/database_connection_local.php';
//echo __DIR__; //template header
//echo "</br>";
//echo $raiz;
?>


<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Excenbit Services</title>

  
  
</head>

<body id="page-top">

  
 <!-- Navigation -->
 
 
 <section class="page-section" >
  <div class="container">
          
    <div class="row">
    <!DOCTYPE html>
    <p><a href="../">Home</a></p>
    </br>
      <h2> BTC Wallet Services </h2>
      

    </div>
    <h4> Create New BTC wallet </h4>
    <form action="/app/controller/btc_create_wallet.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                  <label for="uname">Password:</label>
                  <input type="text" class="form-control" id="pwd" placeholder="password" name="pwd" required  maxlength="100" value = "">
                  <label for="uname">Label:</label>
                  <input type="text" class="form-control" id="label" placeholder="name" name="label" required  maxlength="100" value = "">
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>
<h4> Generate New Address </h4>
    <form action="/app/controller/btc_create_address.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                  <label for="uname">wallet_id:</label>
                  <input type="text" class="form-control" id="wallet_id" placeholder="label" name="wallet_id" required  maxlength="100" value = "">                 
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>
<h4> list addresses from a wallet </h4>
    <form action="/app/controller/btc_list_address.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                  <label for="uname">Wallet id:</label>
                  <input type="text" class="form-control" id="wallet_id" placeholder="label" name="wallet_id" required  maxlength="100" value = "">                 
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>
<h4> get balance from a address </h4>
    <form action="/app/controller/btc_get_balance_address.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group"> 
                  <label for="uname">Wallet id:</label>
                  <input type="text" class="form-control" id="wallet_id" placeholder="label" name="wallet_id" required  maxlength="100" value = "">                  
                  <label for="uname">address:</label>
                  <input type="text" class="form-control" id="address" placeholder="address" name="address" required  maxlength="100" value = "">                 
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>
<h4> estimative balance from a wallet </h4>
    <form action="/app/controller/btc_get_balance_wallet.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group"> 
                  <label for="uname">Wallet id:</label>
                  <input type="text" class="form-control" id="wallet_id" placeholder="label" name="wallet_id" required  maxlength="100" value = "">                  
                                 
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>
<h4> Send Payment </h4>
    <form action="/app/controller/btc_send_payment.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group"> 
                  <label for="uname">from wallet id:</label>
                  <input type="text" class="form-control" id="wallet_id" placeholder="label" name="wallet_id" required  maxlength="100" value = "">                  
                  <label for="uname">to address:</label>
                  <input type="text" class="form-control" id="address" placeholder="address" name="address" required  maxlength="100" value = "">  
                  <label for="uname">amount(BTC):</label>
                  <input type="text" class="form-control" id="amount" placeholder="0.000" name="amount" required  maxlength="100" value = "">                  
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>

<h4> Generate hash encrypt </h4>
    <form action="/app/controller/encrypt.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                  <label for="uname">Secret key:</label>
                  <input type="text" class="form-control" id="key" placeholder="key" name="key" required  maxlength="100" value = "">
                  <label for="uname">text(password) to encrypt:</label>
                  <input type="text" class="form-control" id="text" placeholder="text" name="text" required  maxlength="100" value = "">
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>

<h4> Get full address information (rawaddr)</h4>
    <form action="/app/controller/btc_get_rawaddr.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                <label for="uname">skip the first n transactions(optional):</label>
                  <input type="text" class="form-control" id="skip" placeholder="0" name="skip" maxlength="100" value = "">                  
                  <label for="uname">address:</label>
                  <input type="text" class="form-control" id="address" placeholder="address" name="address" required  maxlength="100" value = "">       
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>

<h4> Get full info address information (btc.com)</h4>
    <form action="/app/controller/btc_address_info.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                                
                  <label for="uname">address:</label>
                  <input type="text" class="form-control" id="address" placeholder="address" name="address" required  maxlength="100" value = "">       
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>

<h4> TESTE FUNCTION PHP</h4>
    <form action="/app/controller/teste.php" method="post" >
            
            <br>
            <br>
            <div class="row">
              <div class="col-lg-6 text-left">          
                <div class="form-group">
                                
                  <label for="uname">address:</label>
                  <input type="text" class="form-control" id="address" placeholder="address" name="address" required  maxlength="100" value = "">       
                </div>
              </div>  
            
            </div>
            <br>
            <button type="submit1" class="btn btn-primary">Submit</button>
          </form> 
</br>



  <div>


   </div>

    
  </section>



<!-- Footer -->



</body>

</html>