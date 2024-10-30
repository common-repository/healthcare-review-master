jQuery(document).ready(function($) {
	var hrm_num_show_zocdoc_review = parseInt( hrm_loc.hrm_num_show_zocdoc_review );
	var hrm_zocdoc_review_interval = parseInt( hrm_loc.hrm_zocdoc_review_interval );
	var hrm_zocdoc_review_speed = hrm_loc.hrm_zocdoc_review_speed;
	var hrm_zocdoc_review_pause_on_hover = parseInt( hrm_loc.hrm_zocdoc_review_pause_on_hover );
	
	
	
	var dd = $('.hrm_review_display').easyTicker({
		direction: 'up',
		easing: 'easeInOutBack',
		speed: hrm_zocdoc_review_speed,
		interval: hrm_zocdoc_review_interval,
		height: 'auto',
		visible: hrm_num_show_zocdoc_review,
		mousePause: hrm_zocdoc_review_pause_on_hover,
		controls: {
			up: '.hrm_zocdoc_up',
			down: '.hrm_zocdoc_down',
			toggle: '.hrm_zocdoc_toggle',
			playText: 'Play',
			stopText: 'Stop'
		}
	}).data('easyTicker');
});