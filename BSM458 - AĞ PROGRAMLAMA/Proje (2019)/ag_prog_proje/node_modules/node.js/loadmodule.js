//loadmodule.js
var hello1 = require('./module');
hello1.setName('BYVoid');
var hello2 = require('./module');
hello2.setName('BYVoid 2');
hello1.sayHello();