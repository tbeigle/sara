(function($) {
  $.fn.hasVal = function() {
		if (typeof this.val() != 'string') return false;
		if (this.val().length == 0) return false;
		
		return true;
  };
})(jQuery);

(function($) {
  $.fn.fieldLabel = function() {
		return $('label[for="'+this.attr('id')+'"]');
  };
})(jQuery);

(function($) {
  $.fn.noString = function() {
		if (typeof this != 'string') return true;
		if (this.length == 0) return true;
		
		return false;
  };
})(jQuery);

$(document).ready(function() {
	$('#submit-wrapper').html('<a class="form-submit">SEND</a>');
	
	$('.has-overlay').each(function() {
		var $f = $(this);
		var $l = $f.fieldLabel();
		
		if ($f.hasVal() && $f.hasClass('error')) {
			$f.removeClass('error');
			$l.removeClass('error');
		}
		
		$f
			.on('focus', function() {
				if ($f.hasClass('show-overlay')) {
					$f.removeClass('show-overlay').addClass('fade-overlay');
				}
				
				if ($f.hasClass('error')) {
					$f.attr('data-had-error', 1);
					$f.removeClass('error');
				} else {
					$f.attr('data-had-error', 0);
				}
			})
			.on('keydown', function() {
				if ($f.hasClass('fade-overlay')) {
					$f.removeClass('fade-overlay').addClass('hide-overlay');
				}
			})
			.on('keyup', function() {
				if ($f.hasClass('hide-overlay') && !$f.hasVal()) {
					$f.removeClass('hide-overlay').addClass('fade-overlay');
				}
			})
			.on('blur', function() {
				if (!$f.hasVal()) {
					if (($f.hasClass('hide-overlay') || $f.hasClass('fade-overlay'))) {
						$f.removeClass('hide-overlay').removeClass('fade-overlay').addClass('show-overlay');
						
						if ($f.attr('data-had-error') == 1 && !$f.hasClass('error')) {
							$f.addClass('error');
						}
					}
				}
			});
	});
	
	$('.form-submit').on('click', function() {
		var fdata = {
			name: $('#field-name').val(),
			email: $('#field-email').val(),
			phone: $('#field-phone').val(),
			method: $('#field-method').val(),
			message: $('#field-message').val(),
			js: 1
		}
		
		$.post('includes/form-handler.php', fdata, function(data) {
			var parsed = jQuery.parseJSON(data);
			if (typeof parsed.thanks == 'string') {
				$('#contact').fadeOut('fast', function() {
					var $c = $(this);
					
					$c.html('<p class="thank-you-copy">'+parsed.thanks+'</p>').fadeIn('fast');
				});
			} else {
				$('label, .field').removeClass('error');
				
				for (x in parsed) {
					var empty_str = (typeof parsed[x] != 'string');
					
					if (!empty_str) {
						empty_str = (parsed[x].length == 0);
					}
					
					if (!empty_str) {
						var fid = 'field-'+x;
						$('label[for="'+fid+'"],#'+fid).addClass('error');
					}
				}
			}
		});
		
		return false;
	});
});