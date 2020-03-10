var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.sockets.on('connection', function (socket) {





  socket.on( 'new_message', function( data ) {  


    io.sockets.emit( 'new_message', {
    	count: data.count,
      id:data.id,
      questionid:data.questionid,
       wc:data.wc,
      opt:data.opt
      
    });



  });







  qwe = 'new_count_message';
  socket.on(qwe, function( data ) {
    io.sockets.emit( 'new_count_message', { 
    	emp_id:data.emp_id,
    	new_count_message: data.new_count_message,
      notification:data.notification,
      notification_type:data.notification_type

    });
  });



    socket.on( 'poll', function( data ) {  


    io.sockets.emit( 'poll', {
              qwe:data.qwe,
              emp:data.emp,
              up:data.up,
              down:data.down,
              id:data.id,
              destination:data.destination
    });



  });
});
