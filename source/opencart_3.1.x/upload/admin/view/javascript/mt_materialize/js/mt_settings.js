/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

$(document).ready(function() {
	function changeSettings() {
		let content = $('#content'),
			mtSettings = $('[data-mt-settings]');

		content.on('keyup keypress blur change', $(mtSettings), function(event) {
			let input = $(event.target),
				target = $('#' + input.data('target')),
				css = input.data('css'),
				value = input.val();

			$(target).css(css, value);
		});
	}

	changeSettings();
});