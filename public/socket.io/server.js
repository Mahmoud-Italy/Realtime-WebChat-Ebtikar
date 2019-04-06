var express = require("express");
var app = express();
var server = require("http").createServer(app);
var io = require("socket.io")(server);
var users = {};

//MySQL npm install socket.io mysql
var mysql = require('mysql');
var db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'ebtikar_realtimeDB',
    debug:   false,
    socketPath: '/Applications/MAMP/tmp/mysql/mysql.sock'
});

//Log any errors connected to the db
db.connect(function(err){
   if (err) console.log("db err :"+err);
   else console.log('db connected');
});


// Create Route
app.get("/", function(req, res, next) {
  res.sendFile(__dirname + "/public/index.html");
});
app.use(express.static("public"));


// On Connection
io.on("connection", function(client) {
    console.log("new user connected...");

   // get Online
    client.on("online",function(data) {
      users[client.id] = data;         
      console.log('user ' + data + ': connected');
      db.query("UPDATE `users` SET `online` = 1 , `socket_token` = '"+client.id+"' WHERE `id` = "+data+" ");
    });

    // get Offline
    client.on('disconnect', function() {
        db.query("SELECT * FROM `users` WHERE `id` = "+users[client.id]+" AND `online` = 1 ", (err, rows) => { 
        if(err || !rows || rows.length < 1) { status = false; exp = err; } 
        else { db.query("UPDATE `users` SET `online` = 0, `socket_token` = 0  WHERE `id` = "+users[client.id]+" "); }
        });
    });


    // emit Message
    client.on("chat_emit", function(data) {
      var response = data; 
      var status = true;
      if(IsJsonString(data) === true) {
        var parse = JSON.parse(data);
        var stringify = JSON.stringify(parse);
        var response = JSON.parse(stringify); } 

        if(response.message) text = JSON.stringify(response.message);
        
        // get date & time according Cairo
        var timestamp = new Date().toISOString('en-US', { timeZone: 'Africa/Cairo' }).split('T')[0]+new Date().toLocaleString('en-US', { timeZone: 'Africa/Cairo' , hour12: false }).replace(/[ :]/g,'-').split(',')[1];
        var created_at = new Date().toISOString('en-US', { timeZone: 'Africa/Cairo' }).split('T')[0]+new Date().toLocaleString('en-US', { timeZone: 'Africa/Cairo' , hour12: false }).split(',')[1];
        var time = new Date().toLocaleString('en-US', { timeZone: 'Africa/Cairo' }).replace(/:\d{2}\s/,' ').split(',')[1]; 
        var date = new Date().toISOString('en-US', { timeZone: 'Africa/Cairo' }).split('T')[0]; 
        
        // Store Chat into DB
        db.query("INSERT INTO  `chats` (`user_from`,`user_to`,`message`) VALUES ("+response.user_from+","+response.user_to+",'"+response.message+"') ");
        
        var serverResponse = {
          user_from : response.user_from, 
          user_to : response.user_to,
          message : response.message,
          date: date, 
          time: time,
          deviceType : 'server'
        };
        client.emit("chat_listen", serverResponse);
        
        // fetch socket_token & send only to user_to
        db.query("SELECT * FROM `users` WHERE `id` = "+response.user_to+" AND `online` = 1", (errT, rowsT) => { 
        if(errT || !rowsT || rowsT.length < 1) {  status = false; exp = errT; } 
        else {
            // send NotificationMsg
            var notifyResponse = {
                user_id : response.user_to,
                status : status,
                exception : exp,
                deviceType : 'server'
            };
            client.broadcast.to(rowsT[0].socket_token).emit("chat_listen", serverResponse);
            client.broadcast.to(rowsT[0].socket_token).emit('notificationsMsg_listen', notifyResponse);
            // end Send NotificationMsg
                
            // start typing..
            var typingData = {
                user_from : response.user_from,
                user_to : response.user_to,
                status: 'false',
                deviceType: 'server'
            };
            client.broadcast.to(rowsT[0].socket_token).emit('typing',typingData);
            // end typing..
           } 
        }); // end fetching socket
    });




    // emit Typing... 
    client.on('typing', function(user_id,user_to,status) {
      var response = data;
       
       if(IsJsonString(data) === true) {
        var parse = JSON.parse(data);
        var stringify = JSON.stringify(parse);
        var response = JSON.parse(stringify); }
        
        var typingData = {
            user_from : response.user_from,
            user_to : response.user_to,
            status: response.status,
            deviceType: 'server'
        };
        
       db.query("SELECT * FROM `users` WHERE `id` = "+data.user_to+" AND `online` = 1 ", (errT, rowsT) => { 
         if(errT || !rowsT || rowsT.length < 1) {  } 
         else { client.broadcast.to(rowsT[0].socket_token).emit('typing', typingData); }
       });
    });

    // Convert JsonParse
    function IsJsonString(str) {
      try { JSON.parse(str);
      } catch (e) { return false; }
      return true;
    };
    
});
server.listen(8002);
