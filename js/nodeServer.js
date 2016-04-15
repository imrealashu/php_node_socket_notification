var socket = require( 'socket.io' );
var express = require( 'express' );
var http = require( 'http' );

var app = express();
var server = http.createServer( app );

var io = socket.listen( server );

io.sockets.on( 'connection', function( client ) {
	console.log( "New client" );
	client.on( 'notification', function( data ) {
		console.log( 'Notification received ' + data.notification);
		//client.broadcast.emit( 'message', { name: data.name, message: data.message } );
		io.sockets.emit( 'notification', { notification: data.notification, serverData: data.serverData } );
	});
});

server.listen( 8080 );