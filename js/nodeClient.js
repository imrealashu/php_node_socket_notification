var client = (function(){
	var socket = io.connect( 'http://localhost:8080' );
	var interval; //for random notification generation
	function init(){
		buttonClicked();
		socketNotificationUpdate();
	}

	function buttonClicked(){
		$( "#notification" ).on('submit', function(e) {
			e.preventDefault(); //Preventing default submit action

			var $cacheDom = $(this); //Caching the dom so that jQuery doesn't always need to search in the page
			var url = $cacheDom.attr('action'); //Grabbing url of the form
			var notification = $cacheDom.find('div:nth-child(2) input').val();

			$cacheDom.find('div').removeClass('has-error').addClass('has-success').val('');

			if(notification.length == 0){
				$cacheDom.find('div').removeClass('has-success').addClass('has-error');
				return false;
			}

			//Ajax call to save data
			saveAjaxNotification(notification, url);

		});
	}

	function socketNotificationUpdate(){
		socket.on( 'notification', function( data ) {
			var $cacheDom = $('#notifications-container');
			var actualContent = $cacheDom.html(); //All notification
			var $notificationCount = $cacheDom.parent().prev().find('span'); //Header notification count selector
			var notificationCount = $notificationCount.text(); //Header Notification count

			$notificationCount.text(Number(notificationCount) + 1); //Incrementing after one notification

			var newMsgContent = '<li data-id="'+data.serverData.lastInsertId+'" onclick="client.openNotification(this)"><a><span class="image"><img src="images/img.jpg" alt="Profile Image" /></span><span><span>Ashish Singh</span><span class="time">0 seconds ago</span></span><span class="message">'+data.notification+'</span></a></li>';

			$cacheDom.html( newMsgContent + actualContent );
			PNotify.desktop.permission();
				(new PNotify({
					title:  'Ashish Singh',
					text:  data.notification,
					desktop: {
						desktop: true,
						icon: 'images/img.jpg'
					}
				})).get().click(function(e) {
					if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
					alert('http://vegfru.com/imrealashu/notification/'+serverData.link);
				});

		});
	}
	function openNotification(that){
		var notificationId = $(that).attr('data-id');

		$.post('./ajax/readNotification.php',{notification_id:notificationId},function(){
			$(that).remove(); //removing the clicked notification (optional as it should take the user to new page)
			var $notificationCount = $('#notifications-container').parent().prev().find('span');
			var notificationCount = $notificationCount.text();

			$notificationCount.text(Number(notificationCount) -1);

			alert('Notification Link will be opened'); //Just for message
			location.href=""; //Reloading the page as on clicking the notification will take the user to notifications page where all the notification will be shown (read or unread)
		});
	}
	function saveAjaxNotification(notification, url){
		$.ajax({
			url: url,
			type: "POST",
			data: { notification: notification},
			success: function(data) {
				var serverData = JSON.parse(data);
				socket.emit( 'notification', { notification: notification, serverData:serverData } );
				// PNotify.desktop.permission();
				// (new PNotify({
				// 	title:  'Ashish Singh',
				// 	text:  notification,
				// 	desktop: {
				// 		desktop: true,
				// 		icon: 'images/img.jpg'
				// 	}
				// })).get().click(function(e) {
				// 	if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
				// 	alert('http://vegfru.com/imrealashu/notification/'+serverData.link);
				// });
			}
		});
	}
	function gerateRandomNotification(that){
		var url = $(that).parent().parent().attr('action');
		var count = 1;
		if($(that).is(':checked')){
			interval = setInterval(function(){ saveAjaxNotification('notification'+count,url); count++},3000);

		}else{
			clearInterval(interval);

		}
	}

	init();

	return {
		openNotification: openNotification, //Revealing the openNotification function as it will be used in DOM
		gerateRandomNotification: gerateRandomNotification
	}
})();