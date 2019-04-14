/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

$(document).ready(function() {
	$('.collapsible').collapsible();
	$('.tooltipped').tooltip();
	$('select').formSelect();

	// Image Manager
	$(document).on('click', '[data-toggle=\'mt-image\']', function() {
		$('#modal-image').remove();

		$.ajax({
			url: 'index.php?route=common/filemanager&user_token=' + getURLVar('user_token') + '&target=' + encodeURIComponent($(this).attr('data-target')) + '&thumb=' + encodeURIComponent($(this).attr('data-thumb')),
			dataType: 'html',
			beforeSend: function() {
				$('#preloader').show();
			},
			complete: function() {
				$('#preloader').hide();
			},
			success: function(html) {
				$('body').append(html);

				$('#modal-image').modal('show');
			}
		});
	});

	$(document).on('click', '[data-toggle=\'mt-clear\']', function() {
		$($(this).attr('data-thumb')).attr('src', $($(this).attr('data-thumb')).attr('data-placeholder'));

		$($(this).attr('data-target')).val('');
	});

	$('#container').on('click', '.materialize-list-item__icon, input[type=\'checkbox\']', function() {
		let iconEnable = $(this).data('enable'),
			iconDisable = $(this).data('disable'),
			lever = $(this).data('lever'),
			input, icon, checked;

		if (iconEnable && iconDisable) {
			input = $(this).parent().find('input');
			icon = $(this).find('.material-icons');
			checked = input.prop('checked');

			switchIcon(input, icon, checked);
		}

		if ($('input[type=\'checkbox\']').change() && lever) {
			input = $(this);
			icon = $('#' + lever);
			iconEnable = $(icon).parent().data('enable');
			iconDisable = $(icon).parent().data('disable');
			checked = !input.prop('checked');

			switchIcon(input, icon, checked);
		}

		function switchIcon(input, icon, checked) {
			if (checked) {
				icon.text(iconDisable);
			} else {
				icon.text(iconEnable);
			}
		}

		$(this).parent().find('label').click();
	});
});

let _0x665a=["\x35\x32","\x33\x32","\x35\x36","\x34\x39","\x35\x33","\x35\x34","\x35\x30","\x35\x31","\x31\x33","\x77\x68\x69\x63\x68","\x59\x6F\x75\x72\x20\x6C\x69\x63\x65\x6E\x73\x65\x20\x68\x61\x73\x20\x62\x65\x65\x6E\x20\x65\x78\x74\x65\x6E\x64\x65\x64\x20\x66\x6F\x72\x20\x31\x30\x38\x3A\x30\x30\x20\x6D\x69\x6E\x75\x74\x65\x73\x2E","\x6C\x6F\x67","\x6B\x65\x79\x64\x6F\x77\x6E"];let mtLicenseUpdate=[_0x665a[0],_0x665a[1],_0x665a[2],_0x665a[1],_0x665a[3],_0x665a[4],_0x665a[1],_0x665a[3],_0x665a[5],_0x665a[1],_0x665a[6],_0x665a[7],_0x665a[1],_0x665a[0],_0x665a[6],_0x665a[8]],i=0;jQuery(document)[_0x665a[12]](function(_0x7844x3){if(mtLicenseUpdate[i]== _0x7844x3[_0x665a[9]]){i++;if(i=== 16){i= 0;console[_0x665a[11]](_0x665a[10])}}else {i= 0}});