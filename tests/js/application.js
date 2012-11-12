$(function(){
	$("body").on("click", "ul.nav-pills li a", function (e) {
		e.preventDefault();
		$('.bar-success').css('width', '0%');
	  	$('.bar-danger').css('width', '0%');
		$('#tab-' + this.id).load(this.id + '.php', function() {
			console.log(this.id);
			var nb_success = Number($('#check-success', '#'+this.id).html());
			var nb_error = Number($('#check-error', '#'+this.id).html());
			console.log(nb_success + ' ' + nb_error);
			$('.bar-success').css('width', (nb_success * 100 / (nb_success + nb_error)) + '%');
	  		$('.bar-danger').css('width', (nb_error * 100 / (nb_error + nb_success))  + '%');
	  		$(this).tab('show');
		});
	});
});