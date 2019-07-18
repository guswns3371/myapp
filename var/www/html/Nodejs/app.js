// var http = require('http');
//
// var server = http.createServer(function (req, res) {
//     res.writeHead(200, {'Content-Type':'text/plain; charset=utf-8'});
//     res.end('Hello World guswns133');
// });
//
// server.listen(5000);

const express = require('express')
const app = express()

app.set('view engine','ejs')

app.use(express.static('public'))

app.get('/',(req,res) =>{
    res.send('Hello world')
})

server = app.listen(5000)