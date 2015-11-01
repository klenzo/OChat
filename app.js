$(function(){
	$('.btn_smileys').click(function(){
		$('.smileys').slideToggle();
	});

	$('.icon_smileys').click(function(){
		var name = $(this).attr('rel-name'), message = $('#message').val();
		$('#message').val(message + ' -' + name + '- ');
	});


	afficheConversation();
	$('.load').hide();
	$(".form").submit(function(e){
		e.preventDefault();
        var pseudo		= $('#pseudo').val();
        var message 	= $('#message').val();
        var submit 		= $('#submit').val();
        var pattern     = /^[a-z0-9]{3,25}$/i;
		if(pseudo.length >= 3 && pattern.test(pseudo) && message.length >= 2)	{
			$('#message').val('');
			$('.load').show();
			$.post('mcs.php', {'pseudo':pseudo, 'message':message, 'submit':submit}, function() {
				$('#pseudo').attr('type', 'hidden');
				$('.load').hide();
				$('.smileys').slideUp();
				$('.notif').fadeOut();
				$('#success').css('background-color', '#0F5').fadeIn();
				afficheConversation();
			});
		}else if(pseudo.length < 3 || !pattern.test(pseudo)){
			$('.notif').fadeOut();
			$('#errorp').css('background-color', '#F50').fadeIn();
		}else if(message.length < 2){
			$('.notif').fadeOut();
			$('#errorm').css('background-color', '#F50').fadeIn();
		}
    });

	$('.notif').click(function(){
		$(this).fadeOut();
	});

    function afficheConversation() {
		$('.chat').load('rochat.php');
    }
    setInterval(afficheConversation, 2000);

    function afficheOnline() {
		$('#online_list').load('online.php');
    }
    setInterval(afficheOnline, 10000);

    $('.name').click(function(){
    	console.log('Hello');
		var name = $(this).text(), message = $('#message').val();
		$('#message').val(message + ' @' + name + ' ');
    });
});
