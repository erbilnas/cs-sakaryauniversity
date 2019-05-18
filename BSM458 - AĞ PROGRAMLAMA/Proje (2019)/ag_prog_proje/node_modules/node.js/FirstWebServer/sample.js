var fs=require("fs");
console.log("Starting...");
fs.readFile("Sample.txt",function(error,data){
	console.log(error);
	console.log("Contents of file: "+data);
});
console.log("Carray on executing");