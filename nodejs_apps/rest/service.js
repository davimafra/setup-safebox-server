// _________________________ SERVICES FOR LITECOIN USING LITECORE LIB _____________________________

const express = require('express');
const app = express();

var mylib = require ("./mylib.js");

var server = app.listen(3005, function(){
    var host = server.address().address    
    var port = server.address().port
    console.log("Example app listing at http://localhost:", port)
})

app.get('/', (req, res) => {
    console.log(req.url);
    return res.send('Received a POST HTTP method');
      
    
});

//______________________________________________________________
app.get('/create_wallet', (req, res) => {
console.log(req.url);
var awallet = mylib.create_wallet();
res.end(JSON.stringify(awallet));
      

});
//______________________________________________________________


//______________________________________________________________
app.get('/create_address', (req, res)=> {
    console.log(req.url);
    var privkey = req.query.privkey;
    var naddress = mylib.create_address(privkey);
    console.log(naddress);
    res.send(naddress);      
    
    });
//______________________________________________________________
//______________________________________________________________
app.get('/send_many', (req, res)=> {
  console.log(req.url);
  var privkey = req.query.privkey;
  var result = mylib.send_many(privkey);
  console.log(result);
  res.send(result);      
  
  });
//______________________________________________________________

//______________________________________________________________
    app.get('/send', async(req, res, next) => { //devolve txid
        var listarray
      
        for (const key in req.query) {   
          //nome do param
          if (key.toString() == 'address'){//param
            
            var address = (key, req.query[key]);
            console.log(address); 
            
          }
          if (key.toString() == 'privkey'){//param
            var priv_key = (key, req.query[key]);
            console.log(priv_key);
          }
          if (key.toString() == 'amount'){//param
            var str_amount = (key, req.query[key]);
            var amount = parseInt(str_amount, 10);
            console.log(amount);
          }
          if (key.toString() == 'fee'){//param
            var fee = (key, req.query[key]);
            console.log(fee);
          }

        };
//execucao da funcao
        try {
            var result = await mylib.send(priv_key,fee,address,amount);
            console.log(result);
            return res.send(result); 
        } catch(err) {
            console.log(err);
            return res.send(err);
        }
            
      })

      //______________________________________________________________
    app.get('/sendall', async(req, res, next) => { //devolve txid
      var listarray
    
      for (const key in req.query) {   
        //nome do param
        if (key.toString() == 'address'){//param
          
          var address = (key, req.query[key]);
          console.log(address); 
          
        }
        if (key.toString() == 'privkey'){//param
          var priv_key = (key, req.query[key]);
          console.log(priv_key);
        }                
        if (key.toString() == 'fee'){//param
          var fee = (key, req.query[key]);
          console.log(fee);
        }

      };
//execucao da funcao
      try {
          var amount = 0;
          var result = await mylib.send(priv_key,fee,address,amount,true);//send all

          console.log(result);
          return res.send(result); 
      } catch(err) {
          console.log(err);
          return res.send(err);
      }
          
    })

