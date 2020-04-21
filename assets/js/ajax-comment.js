jQuery(document).ready(function(jQuery) {

	var $commentform = jQuery('#commentform'),
	$comments = jQuery('#comments-title'),
	$cancel = jQuery('#cancel-comment-reply-link'),
	cancel_text = $cancel.text();
	jQuery(document).on("submit", "#commentform",
	function() {
		jQuery.ajax({
			url: ajaxcomment.ajax_url,
			data: jQuery(this).serialize() + "&action=ajax_comment"+"&nonce="+jQuery('#reload').attr('wpnonce'),
			type: jQuery(this).attr('method'),
			beforeSend:addComment.createButterbar("提交中...."),
			error: function(request) {
				var t = addComment;
				t.createButterbar(request.responseText);
			},
			success: function(data) {
				jQuery('textarea').each(function() {
					this.value = ''
				});
				var t = addComment,
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId),
				post = t.I('comment_post_ID').value,
				parent = t.I('comment_parent').value;
				if (parent != '0') {
					jQuery('#respond').before('<ol class="children">' + data + '</ol>');
				} else {
					if (jQuery('.comment-list').length == 0)
						jQuery('#respond').before('<ol>' + data + '</ol>');
					else
						jQuery('.comment-list').append(data);// your comments wrapper

				}
				t.createButterbar("提交成功!");
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});

	addComment = {
		moveForm: function(commId, parentId, respondId) {
			var t = this,
			div,
			comm = t.I(commId),
			respond = t.I(respondId),
			parent = t.I('comment_parent'),
			post = t.I('comment_post_ID');
			t.respondId = respondId;
			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			} ! comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
			jQuery("body").animate({
				scrollTop: jQuery('#respond').offset().top - 180
			},
			400);
			parent.value = parentId;
			try {
				t.I('comment').focus();
			}
			 catch(e) {}
			return false;
		},
		I: function(e) {
			return document.getElementById(e);
		},
		clearButterbar: function(e) {
			if (jQuery(".butterBar").length > 0) {
				jQuery(".butterBar").remove();
			}
		},
		createButterbar: function(message) {
			var t = this;
			t.clearButterbar();	
			if ("提交中...." != message)
			{
				jQuery("body").append('<div class="butterBar butterBar--center"><p class="butterBar-message">' + message + '</p></div>');
				setTimeout("jQuery('.butterBar').remove()", 2000);
			}
			else {
				jQuery("body").append('<div class="butterBar butterBar--center"><p class="butterBar-message">' + message + '</p><div class="lds-facebook"><div></div><div></div><div></div></div></div>');
			}
		}
	};
});

//Ctrl + Enter 提交。20200418从apip中移植
document.getElementById("comment").onkeydown = function (moz_ev){
	//var key_id = "submit";
	var ev = null;
	if (window.event){
		ev = window.event;
			}else{
			ev = moz_ev;
		}
		if (ev != null && ev.ctrlKey && ev.keyCode == 13)
		{
		document.getElementById("reload").click();
		}
	}