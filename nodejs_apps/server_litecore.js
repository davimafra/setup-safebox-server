
var http = require('http');
http.createServer(function(req,res) {
  res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' }); 
  res.write('Olá mundo!');
  res.end();
  console.log
}).listen(3001);
console.log('Litecore_running at port 3001...');
var litecore = require('./node_modules/litecore-lib');
var privateKey = new litecore.PrivateKey("1c7c3673e8ba3c5da61707da64839f9c73dddf961717f8050c581b1cab5f7672");
//var privateKey = new dashcore.PrivateKey();
//console.log(privateKey.toString());

//var privateKey = new dashcore.PrivateKey(privateKey);
//var publicKey = new dashcore.PublicKey(privateKey);
//console.log(publicKey.toString());

//var address = publicKey.toAddress();
//console.log(address.toString());
//var transaction = new Transaction()
    //.from(utxos)          // Feed information about what unspent outputs one can use
    //.to(address, amount)  // Add an output with the given amount of satoshis
    //.change(address)      // Sets up a change address where the rest of the funds will go
    //.sign(privateKey)     // Signs all the inputs it can
    //;
const address = privateKey.toAddress();
console.log(address.toString());
const adressTo = 'LKy3WpU5576eFcxHSzQRF4MxnRXxXj7yPr';


var request = require("request");

//manually hit an insight api to retrieve utxos of address
function getUTXOs(address) {
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
  return new Promise((resolve, reject) => {
    request({
      uri: 'https://insight.litecore.io/api/tx/send',
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
  })
}

//your private key and address here
//var privateKey = PrivateKey.fromWIF('YOUR_PRIVATE_KEY_HERE');
//var address = privateKey.toPublicKey().toAddress();

ress = getUTXOs(address)
  .then((utxos) => {

    let balance = 0;
    for (var i = 0; i < utxos.length; i++) {
      balance +=utxos[i]['satoshis'];
    } //add up the balance in satoshi format from all utxos
    var fee = 100000; //fee for the tx
    //var amount = balance - fee;
    var amount = 200000;
    console.log('amount: ' + amount);
    console.log('fee: ' + fee);
    
    var tx = litecore.Transaction() //use litecore-lib to create a transaction
      .from(utxos)
      .to(adressTo, amount) //note: you are sending all your balance AKA sweeping
      .fee(fee)
      .sign(privateKey)
      .serialize();
      console.log('to...' + adressTo);
    return broadcastTX(tx) //broadcast the serialized tx
  })
  .then((result) => {
    console.log(result) // txid
    
  })
  .catch((error) => {
    console.log(error);
    
  })
    
    