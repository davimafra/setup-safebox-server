<?php


/** 
______________________________  GET_PARAM  _____________________________
*/
function _ex_get_param($label,$nvar = NULL) {
   

    if(!isset($conn)){
        require (DB_CONNECTION);
    }
    $sql = "SELECT * FROM exchange_parameter WHERE v_label = '$label' LIMIT 1";
    $result = mysqli_query($conn,$sql);   

    if (!$result or mysqli_num_rows($result) == 0){        
        return false;// erro 
    }else{
        $row = mysqli_fetch_assoc($result) ;
        $v_var1 = $row['v_var1']; 
        $i_var2 = $row['i_var2']; 
        $db_var3 = $row['db_var3']; 
        $dt_var4 = $row['dt_var4']; 
        if ($nvar == NULL){
            $resp[] = [$v_var1,$i_var2, $db_var3, $dt_var4];
        }else{
            switch ($nvar) {
                case 1:
                $resp = $v_var1;
                    break;
                case 2:
                $resp = $i_var2;                
                    break;
                case 3:
                $resp = $db_var3;
                    break;
                case 4:
                $resp = $dt_var4;
                    break;                
                default:
                return false;// erro                    
                    
            }
        }
        return $resp;  
    }
    
}
/** 
______________________________  SET_PARAM  _____________________________
*/
function _ex_set_param($label,$nvar,$new_value) { 
    if(!isset($conn)){
        require (DB_CONNECTION);
    } 
    $setpar = '';
    switch ($nvar) {
        case 1:
        $setpar = 'v_var1'; //string VARCHAR 200
            break;
        case 2:
        $setpar = 'i_var2';   // inteiro 2147483647 -1147483647           
            break;
        case 3:
        $setpar = 'db_var3'; //double 20,8
            break;
        case 4:
        $setpar = 'dt_var4'; //date time
            break;                
        default:
        return false;// erro                    
            
    }

    $sql = "UPDATE exchange_parameter SET $setpar = '$new_value' WHERE v_label = '$label'";

    if (mysqli_query($conn, $sql)) {
        return true;// ok
       
    }else{
        return false;// erro
    }   

    
}

/** 
______________________________  GET_PRICES  _____________________________
*/


//_______________________________________
function ex_get_price($pair_id) {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }

    $sql = "SELECT * FROM currency_pair WHERE pair_id = '$pair_id'";
    $result = mysqli_query($conn,$sql);   

    if (!$result or mysqli_num_rows($result) == 0){        
        return false;// erro 
    }else{
        $row = mysqli_fetch_assoc($result) ;
        $price = $row['db_price'];         
        return $price;  
    }
    
}


//_______________________________________
function ex_get_allpair() {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }
    $sql  = "SELECT * FROM currency_pair";	
	$result = mysqli_query($conn,$sql);
	if (!$result or mysqli_num_rows($result) == 0){	
		return false;	
	}else{
		$arr_result = array();
		while ($row = mysqli_fetch_assoc($result)){
			$arr_result [$row['pair_id']] = $row;		
		}
		return $arr_result;
	}
}
//_______________________________________
function ex_get_allcurrency() {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }
    $sql  = "SELECT * FROM currency";	
	$result = mysqli_query($conn,$sql);
	if (!$result or mysqli_num_rows($result) == 0){	
		return false;	
	}else{
		$arr_result = array();
		while ($row = mysqli_fetch_assoc($result)){
			$arr_result [$row['currency_id']] = $row;		
		}
		return $arr_result;
	}

}


//_______________________________________
function ex_get_price_market($pair_id) {
    if(!isset($conn)){
        require (DB_CONNECTION);
    }

    $sql = "SELECT * FROM currency_pair WHERE pair_id = '$pair_id'";
    $result = mysqli_query($conn,$sql);   

    if (!$result or mysqli_num_rows($result) == 0){        
        return false;// erro 
    }else{
        $row = mysqli_fetch_assoc($result) ;
        $market = $row['db_price_abroad'];         
        return $market;  
    }
    
}



/** 
______________________________  EXEC ORDER  _____________________________
*/


//_______________________________________
function ex_exec_order($pair_id) {
    try {
    require (DB_CONNECTION);
    
    mysqli_autocommit($conn, FALSE);
    // AAA/BBB
    //get the lowest a side SELLERS

    $sql = "SELECT * FROM order_book WHERE fk_pair_id = '$pair_id' AND v_side = 'a' AND v_order_type = 'limit' AND ti_active = '1' ORDER BY db_price_a_limit ASC LIMIT 1";
    $result = mysqli_query($conn,$sql);   

    if (!$result or mysqli_num_rows($result) == 0){        
        return true;// anything
    }else{
        $row = mysqli_fetch_assoc($result) ;
        $order1_amount_a = $row['db_amount_a'];
        $order1_side = $row['v_side'];
        $order1_executed = $row['db_amount_a_exec'];
        $order1_amount = $order1_amount_a - $order1_executed;        
        $price_a = $row['db_price_a_limit'];
        $orderid1 = $row['order_id'];
        $order1_account_tocredit = $row['fk_account_to_credit'];
          
    }

    //get the highest b side BUYERS

    $sql = "SELECT * FROM order_book WHERE fk_pair_id = '$pair_id' AND v_side = 'b' AND v_order_type = 'limit' AND ti_active = '1' ORDER BY db_price_a_limit DESC LIMIT 1";
    $result = mysqli_query($conn,$sql);   

    if (!$result or mysqli_num_rows($result) == 0){        
        return true;// anything
    }else{
        $row = mysqli_fetch_assoc($result) ;
        $order2_amount_a = $row['db_amount_a'];
        $order2_side = $row['v_side'];
        $order2_executed = $row['db_amount_a_exec'];
        $order2_amount = $order2_amount_a - $order2_executed;
        $price_b = $row['db_price_a_limit'];
        $orderid2 = $row['order_id'];
        $order2_account_tocredit = $row['fk_account_to_credit'];
    }

    //compare prices
    if ($price_b >= $price_a){

        if($order1_amount <= $order2_amount){ //o1 < o2

            //o2r = o2-o1
            $o2r = number_format($order2_amount - $order1_amount,8,'.','');
            //o1r = o2r+o2-o1
            $o1r = number_format($o2r + $order1_amount - $order2_amount,8,'.','');
            //o2e =o2-o2r
            $o2e = number_format($order2_amount - $o2r,8,'.','');
            //o1e = o1-o1r
            $o1e = number_format($order1_amount - $o1r,8,'.','');
            
        }else{//o1 > o2

            //o2r = o2-o1
            $o1r = $order1_amount - $order2_amount;
            //o1r = o2r+o2-o1
            $o2r = $o1r + $order2_amount - $order1_amount;
            //o2e =o2-o2r
            $o2e = number_format($order2_amount - $o2r,8,'.','');
            //o1e = o1-o1r
            $o1e = number_format($order1_amount - $o1r,8,'.','');

        }
//update orders
        $dt = gmdate('Y-m-d H:i:s');
        $order1_executed = $order1_executed + $o1e;
        $order1_fill = $order1_executed / $order1_amount_a;
        //order 1 = a side
        $amount_tocredit1 = $order1_executed * $price_a; //currency b     

        if($order1_executed >= $order1_amount_a){
            $sql = "SELECT db_amount FROM user_account WHERE id_account = '$order1_account_tocredit'";
            $result = mysqli_query($conn, $sql);
            if (!$result or mysqli_num_rows($result) == 0){        
                mysqli_rollback($conn);	   
                return false;
                }else{
                    $row = mysqli_fetch_assoc($result) ;
                    $balance_tocredit = $row['db_amount'];
                    $balance_tocredit = $balance_tocredit + $amount_tocredit1;
                    $sql = "UPDATE user_account SET db_amount = '$balance_tocredit' WHERE id_account = '$order1_account_tocredit'";
                    $result = mysqli_query($conn, $sql);
                    if (!$result){
                    mysqli_rollback($conn);	   
                    return false;	
                    } 
            }     
            $executed = '1';
            $active = '0';
            $status = '3';
            $credited = '1';
        }else{
            $executed = '0';
            $status = '2';
            $active = '1';
            $credited = '0';
        }
        
        $data_array = array(
        'si_status' => $status,
        'ti_executed' => $executed,
        'ti_active' => $active,
        'ti_credited' => $credited,
        'db_amount_a_exec' => $order1_executed,
        'dt_executed_date' => $dt,
        'db_amount_to_credit' => $amount_tocredit1,
        'db_fill_percent' => $order1_fill);
        
        //____________________________________________________
        $table = 'order_book';
        $where = "order_id = '$orderid1' AND ti_active = '1'";
        $cols = array(); 
        foreach($data_array as $key=>$val) {
            $cols[] = "$key = '$val'";
        }
        $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $order2_executed = $order2_executed + $o2e;
            $order2_fill = $order2_executed / $order2_amount_a;
            //order 2 = b side
            $amount_tocredit2 = $order2_executed; //currency a
            if($order2_executed >= $order2_amount_a){
                
            $sql = "SELECT db_amount FROM user_account WHERE id_account = '$order2_account_tocredit'";
            $result = mysqli_query($conn, $sql);
            if (!$result or mysqli_num_rows($result) == 0){        
                mysqli_rollback($conn);	   
                return false;
                }else{
                    $row = mysqli_fetch_assoc($result) ;
                    $balance_tocredit = $row['db_amount'];
                    $balance_tocredit = $balance_tocredit + $amount_tocredit2;
                    $sql = "UPDATE user_account SET db_amount = '$balance_tocredit' WHERE id_account = '$order2_account_tocredit'";
                    $result = mysqli_query($conn, $sql);
                    if (!$result){
                    mysqli_rollback($conn);	   
                    return false;	
                    } 
                }     
                $executed = '1';
                $active = '0';
                $status = '3';
                $credited = '1';
            }else{
                $executed = '0';
                $status = '2';
                $active = '1';
                $credited = '0';
            }            
            $data_array = array(
            'si_status' => $status,
            'ti_executed' => $executed,
            'ti_active' => $active,
            'ti_credited' => $credited,
            'db_amount_a_exec' => $order2_executed,
            'dt_executed_date' => $dt,
            'db_amount_to_credit' => $amount_tocredit2,
            'db_fill_percent' => $order2_fill);
            //____________________________________________________
            $table = 'order_book';
            $where = "order_id = '$orderid2' AND ti_active = '1'";
            $cols = array(); 
            foreach($data_array as $key=>$val) {
                $cols[] = "$key = '$val'";
            }
            $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
            $result = mysqli_query($conn, $sql);
            //____________________________________________________   
            if ($result){


                // Commit transaction
                if (!mysqli_commit($conn)) {
                    mysqli_rollback($conn); 
                    return false;
                }
                //calc exchange profit
                //update last price
                ex_update_price($pair_id,$price_a);
                return true;		
            }else{		
                mysqli_rollback($conn);                    
               
                return false;	
            } 
            		
        }else{		
            mysqli_rollback($conn);                    
            
            return false;	
        }      

    }else{//not executed
        return true;

    }
    } catch (Exception $e) {
        // An exception has been thrown
        // We must rollback the transaction
        mysqli_rollback($conn);
        return false;
    }
}


/** 
______________________________  CANCEL ORDER  _____________________________
*/


//_______________________________________
function ex_cancel_order($order_id) {
    try {
        require (DB_CONNECTION);
        mysqli_autocommit($conn, FALSE);
    
        $sql = "SELECT * FROM order_book WHERE order_id = '$order_id' AND ti_active = '1' AND ti_canceled='0'";
        $result = mysqli_query($conn, $sql);
        if (!$result or mysqli_num_rows($result) == 0){        
            mysqli_rollback($conn);	   
            return true;
        }else{

        
          $row = mysqli_fetch_assoc($result) ;
          $order_executed = $row['db_amount_a_exec'];
          $fill_percent = $row['db_fill_percent'];
          $fee = $row['db_fee'];
          $side = $row['v_side'];
          $account_tocredit = $row['fk_account_to_credit'];
          $amount_tocredit = $row['db_amount_to_credit'];
          $debited_account = $row['fk_debited_account'];
          $debited_amount = $row['db_debited_amount'];
            
            
            if($side == 'a'){
                $currency_id = $row['fk_currency_a'];
            }else{//b
                $currency_id = $row['fk_currency_b'];
            }
          //se ja estiver sido preenchida...
          if ($amount_tocredit > 0){
            $sql2 = "SELECT db_amount FROM user_account WHERE id_account = '$account_tocredit'";
            $result2 = mysqli_query($conn, $sql2);
            if (!$result2 or mysqli_num_rows($result2) == 0){        
                mysqli_rollback($conn);	   
                return false;
              }else{
                  $row = mysqli_fetch_assoc($result2) ;
                  $balance_tocredit = $row['db_amount'];
                  $balance_tocredit = $balance_tocredit + $amount_tocredit;
                  $sql5 = "UPDATE user_account SET db_amount = '$balance_tocredit' WHERE id_account = '$account_tocredit'";
                  $result5 = mysqli_query($conn, $sql5);
                  if (!$result5){
                    mysqli_rollback($conn);	   
                    return false;	
                  }
              }
          }
          //giveback debited amount
            $sql3 = "SELECT db_amount FROM user_account WHERE id_account = '$debited_account'";
            $result3 = mysqli_query($conn, $sql3);
            if (!$result3 or mysqli_num_rows($result3) == 0){        
                mysqli_rollback($conn);	   
                return false;
            }else{
                $row = mysqli_fetch_assoc($result3) ;
                $balance_deb_amount = $row['db_amount'];
                $balance_deb_amount = $balance_deb_amount + ($debited_amount * (1-$fill_percent));
                $sql6 = "UPDATE user_account SET db_amount = '$balance_deb_amount' WHERE id_account = '$debited_account'";
                $result6 = mysqli_query($conn, $sql6);
                if (!$result6){
                    mysqli_rollback($conn);	   
                    return false;	
                }
                //debit fee proporcional from exchange
                $fee_total = $fee * (1-$fill_percent);  
                $sql = "UPDATE exchange_account SET db_amount = db_amount - '$fee_total'" . " WHERE fk_currency_id = '$currency_id' AND ti_exchange_account = '1'";
                $result = mysqli_query($conn, $sql);
                if ($result){ 

                }
                $sql4 = "UPDATE order_book SET ti_active='0', ti_canceled = '1', ti_credited = '1' WHERE order_id = '$order_id' AND ti_active = '1' AND ti_canceled='0'";
                $result4 = mysqli_query($conn, $sql4);
                if (!$result4){
                    mysqli_rollback($conn);	   
                    return false;	
                }else{
                    //DELETE from mirror table        
                    $sql5  = "DELETE FROM mirror WHERE fk_order_id = '$order_id'";
                    $result5 = mysqli_query($conn, $sql5);	
                    

                    // Commit transaction
                    if (!mysqli_commit($conn)) {
                    mysqli_rollback($conn); 
                    return false;
                    }
                    return true;//ok
                }  
            }
        
        }
    } catch (Exception $e) {
        // An exception has been thrown
        // We must rollback the transaction
        mysqli_rollback($conn);
        return false;
    }
}


//_______________________________________
function ex_update_price($pair_id,$new_price) {

    if(!isset($conn)){
        require (DB_CONNECTION);
    }
   
    $price_last = _sqlgetval('currency_pair','db_price',"pair_id = '$pair_id'");
    $result = _sqlsetval('currency_pair','db_price_before',$price_last,"pair_id = '$pair_id'");
    $result = _sqlsetval('currency_pair','db_price',$new_price,"pair_id = '$pair_id'");
    

    $where =  "ti_active = '1' AND v_order_type = 'stop' AND v_side = 'a' AND db_price_a_stop > '$new_price'";
    $result = _sqlsetval('order_book','v_order_type','limit',$where);

    $where =  "ti_active = '1' AND v_order_type = 'stop' AND v_side = 'b' AND db_price_a_stop < '$new_price'";
    $result = _sqlsetval('order_book','v_order_type','limit',$where);
    return true;//ok

}


?>