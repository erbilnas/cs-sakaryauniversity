var http = require('http');  
var server = http.createServer();  
var fs = require('fs');

var getData = function(res){  
    res.writeHead(200, {'Content-Type': 'text/html'});  
    var obj = {"name":"lili","age":"22" , "sex":"F"};
    //res.end(JSON.stringify(obj));
    res.end('<input/><p>asdfas<p>');
}  

var postData = function(req, res) {  
    var info ='';  
    req.addListener('data', function(chunk){  
        info += chunk;  
     })  
    .addListener('end', function(){  
	//var a;
        //a= JSON.parse(info);  
        //if(a.username == 'root'){  
	//	 res.end('login success!'); 
        //}else{  
        //    res.end('login failed!');  
        //}  
	//var substr = info.split("&");
	//var namestr = substr[0].split("=");
	//var agestr = substr[1].split("=");
	//var name = namestr[1];
	//var age = agestr[1];
	//console.log(name);
	//console.log(age);
	//if(name == "niujingqian")
	//{
	//	console.log("successful");	
	//}
	
	console.log(info+"\n");
	res.end('login successful');
     })  
}  
  
var requestFunction = function (req, res)
{  
    if(req.url == '/')
    {  
        return getData(res);  
    }  
    if(req.url == '/login')
    {  
      //  if (req.method != 'POST')
       // {  
      //      return;  
      //  }  
        return postData(req, res)  
    }  
}  
  
server.on('request',requestFunction);  
server.listen(1337, "127.0.0.1");  
  
console.log('Server running at http://127.0.0.1:1337/');  