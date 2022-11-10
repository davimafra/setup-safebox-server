var http = require('http')
var url = require('url');

//var dt = require('./myfirstmodule');

http.createServer(function(req,res) {
     res.writeHead(200, { 'Content-Type' : 'text/html' });
     res.write("The date and time are currently: " + dt.myDateTime());
     res.write(req.url);
     //res.end('fim');
     res.end();
}).listen(3001);

console.log('Servidor iniciando em localhost:3000; pressione Ctrl-C para encerrar')