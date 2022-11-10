
exports.create_address = function  (privkey){
  var litecore = require('../node_modules/litecore-lib');
  var privateKey = litecore.PrivateKey.fromWIF(privkey);
  var publicKey = new litecore.PublicKey(privateKey);
  var nnaddress = publicKey.toAddress();  
   
      return nnaddress.toString();

};


exports.create_wallet = function(){//litecore permite 1 endereço por wallet
  var litecore = require('../node_modules/litecore-lib');
  var privateKey = new litecore.PrivateKey();
  //var privateKey = litecore.PrivateKey.fromWIF('T41MBC2kdhprMwrCiuC58Z8SNiStJJcAYhfkDHe8kyXRwoHBU2Yt');
  //var privateKey = new litecore.PrivateKey("1c7c3673e8ba3c5da61707da64839f9c73dddf961717f8050c581b1cab5f7672");//from hexa code
  var exported = privateKey.toWIF();
  console.log(exported);
  var publicKey = new litecore.PublicKey(privateKey);
  var exported = publicKey.toAddress().toString();
  
  console.log(exported);


 var nwallet =
   {
        "status" : "success",
        "data" :
         
	    { 'Privkey' : privateKey.toWIF(),
		'Pubkey' : publicKey.toAddress().toString()       
	    }
	};


      return nwallet;
};

exports.send = async function  (privkey,strfee, address_to, stramount,sendall = false){
  var litecore = require('../node_modules/litecore-lib');
  
  if (privkey == null) {
    return 'private key undefinied';
  }
  if (stramount == null) {
    return 'invalid amount';
  }else{
    amount = parseInt(stramount);
  }
  if (strfee == null) {
    return 'invalid amount';
  }else{
    fee = parseInt(strfee);
  }
  
  if (address_to == null) {
    return 'invalid address';
  }



//execucao da funcao

var privateKey = litecore.PrivateKey.fromWIF(privkey);
const address = privateKey.toAddress();
console.log(address_to.toString());
adressTo = address_to;

var resposta = await getUTXOs(address)
  .then((utxos) => {

    let balance = 0;
    for (var i = 0; i < utxos.length; i++) {
      balance +=utxos[i]['satoshis'];
    } //add up the balance in satoshi format from all utxos
    //var fee = 100000; //fee for the tx

    if (sendall){
      var tot_send = balance - fee;
      var tx = litecore.Transaction() //use litecore-lib to create a transaction
      .from(utxos)
      .to(adressTo, tot_send) //note: you are sending all your balance AKA sweeping
      //.change(address.toString())//Sets up a change address where the rest of the funds will go
      .fee(fee)      
      .sign(privateKey)      
      .serialize();
    }else{
      var tot_send = amount;
      var tx = litecore.Transaction() //use litecore-lib to create a transaction
      .from(utxos)
      .to(adressTo, tot_send) //note: you are sending all your balance AKA sweeping
      .change(address.toString())//Sets up a change address where the rest of the funds will go
      .fee(fee)      
      .sign(privateKey)      
      .serialize();
    }
    
    
    //var amount = 200000;
    console.log('amount: ' + tot_send);
    console.log('fee: ' + fee);
    console.log('to...' + adressTo);
    return broadcastTX(tx) //broadcast the serialized tx
  })
  .then((result) => {
    console.log(result) // txid
    if(result == undefined){
      result = "error";
    }
    return result; 
  })
  .catch((error) => {
    console.log(error);
   
    return "error"; 
  })
  
  if (resposta == 'error'){
    return 'error';
  }else{
    var jresult =
   {
        "status" : "success",
        "data" :
         
	    { 'txid' : resposta.toString()
		     
	    }
	};
    return jresult;
  }

  
};


//manually hit an insight api to retrieve utxos of address
function getUTXOs(address) {
  var request = require("../node_modules/request-promise");


  return new Promise((resolve, reject) => {
    request({
      uri: 'https://insight.litecore.io/api/addr/' + address + '/utxo',
      json: true
    },
      (error, response, body) => {
        if(error) reject(error);
        resolve(body)
        
      }
    )
  })

 


}

//manually hit an insight api to broadcast your tx
function broadcastTX(rawtx) {
  var request = require("../node_modules/request");
  return new Promise((resolve, reject) => {    
    request({
      uri: 'https://insight.litecore.io/api/tx/send',//https://testnet.litecore.io/tx/send
      method: 'POST',
      json: {
        rawtx
      }
    },
      (error, response, body) => {
        if(error) reject(error);
        resolve(body.txid)
      }
    )
    //setTimeout(() => resolve(response), 2000)
  })
}

//your private key and address here
//var privateKey = PrivateKey.fromWIF('YOUR_PRIVATE_KEY_HERE');
//var address = privateKey.toPublicKey().toAddress();





exports.send_many = function  (privkey){
  
  var jresult =
  {
       "status" : "success",
       "data" :
        
     { 'txid' : privkey.toString()
        
     }
 
    }

    return jresult;
};


