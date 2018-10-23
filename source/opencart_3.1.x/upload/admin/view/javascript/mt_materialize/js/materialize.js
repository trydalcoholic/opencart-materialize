/*!
  * DashboardCode BsMultiSelect v0.2.17 (https://dashboardcode.github.io/BsMultiSelect/)
  * Copyright 2017-2018 Roman Pokrovskij (github user rpokrovskij)
  * Licensed under APACHE 2 (https://github.com/DashboardCode/BsMultiSelect/blob/master/LICENSE)
  */
(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('popper.js'), require('jquery')) :
		typeof define === 'function' && define.amd ? define(['popper.js', 'jquery'], factory) :
			(factory(global.Popper,global.jQuery));
}(this, (function (Popper,$) { 'use strict';

	Popper = Popper && Popper.hasOwnProperty('default') ? Popper['default'] : Popper;
	$ = $ && $.hasOwnProperty('default') ? $['default'] : $;

	var Bs4AdapterCss =
		/*#__PURE__*/
		function () {
			function Bs4AdapterCss(options, $$$1) {
				var defaults = {
					selectedPanelFocusClass: 'focus',
					selectedPanelDisabledClass: 'disabled',
					selectedItemContentDisabledClass: 'disabled',
					dropDownItemDisabledClass: 'disabled'
				};
				this.options = $$$1.extend({}, defaults, options);
			}

			var _proto = Bs4AdapterCss.prototype;

			_proto.DisableSelectedItemContent = function DisableSelectedItemContent($content) {
				$content.addClass(this.options.selectedItemContentDisabledClass);
			};

			_proto.DisabledStyle = function DisabledStyle($checkBox, isDisbaled) {
				if (isDisbaled) //? $checkBox.addClass : $checkBox.removeClass
					$checkBox.addClass(this.options.dropDownItemDisabledClass);else $checkBox.removeClass(this.options.dropDownItemDisabledClass);
			};

			_proto.Enable = function Enable($selectedPanel) {
				$selectedPanel.removeClass(this.options.selectedPanelDisabledClass);
			};

			_proto.Disable = function Disable($selectedPanel) {
				$selectedPanel.addClass(this.options.selectedPanelDisabledClass);
			};

			_proto.FocusIn = function FocusIn($selectedPanel) {
				$selectedPanel.addClass(this.options.selectedPanelFocusClass);
			};

			_proto.FocusOut = function FocusOut($selectedPanel) {
				$selectedPanel.removeClass(this.options.selectedPanelFocusClass);
			};

			return Bs4AdapterCss;
		}();

	var defSelectedPanelStyle = {
		'margin-bottom': '0',
		'height': 'initial'
	};
	var defSelectedItemStyle = {
		'padding-left': '0px',
		'line-height': '1.5em'
	};
	var defRemoveSelectedItemButtonStyle = {
		'font-size': '1.5em',
		'line-height': '.9em'
	};

	var Bs4AdapterJs =
		/*#__PURE__*/
		function () {
			function Bs4AdapterJs(options, $$$1) {
				var defaults = {
					selectedPanelDefMinHeight: 'calc(2.25rem + 2px)',
					selectedPanelLgMinHeight: 'calc(2.875rem + 2px)',
					selectedPanelSmMinHeight: 'calc(1.8125rem + 2px)',
					selectedPanelDisabledBackgroundColor: '#e9ecef',
					selectedPanelFocusBorderColor: '#80bdff',
					selectedPanelFocusBoxShadow: '0 0 0 0.2rem rgba(0, 123, 255, 0.25)',
					selectedPanelFocusValidBoxShadow: '0 0 0 0.2rem rgba(40, 167, 69, 0.25)',
					selectedPanelFocusInvalidBoxShadow: '0 0 0 0.2rem rgba(220, 53, 69, 0.25)',
					filterInputColor: '#495057',
					selectedItemContentDisabledOpacity: '.65',
					dropdDownLabelDisabledColor: '#6c757d'
				};
				this.options = $$$1.extend({}, defaults, options);
			}

			var _proto = Bs4AdapterJs.prototype;

			_proto.OnInit = function OnInit(dom) {
				dom.selectedPanel.css(defSelectedPanelStyle);
				dom.filterInput.css("color", this.options.filterInputColor);
			};

			_proto.CreateSelectedItemContent = function CreateSelectedItemContent($selectedItem, $button) {
				$selectedItem.css(defSelectedItemStyle);
				$button.css(defRemoveSelectedItemButtonStyle);
			};

			_proto.DisableSelectedItemContent = function DisableSelectedItemContent($content) {
				$content.css("opacity", this.options.selectedItemContentDisabledOpacity);
			};

			_proto.DisabledStyle = function DisabledStyle($checkBox, isDisbaled) {
				$checkBox.siblings('label').css('color', isDisbaled ? this.options.dropdDownLabelDisabledColor : '');
			};

			_proto.UpdateSize = function UpdateSize($selectedPanel) {
				if ($selectedPanel.hasClass("form-control-lg")) {
					$selectedPanel.css("min-height", this.options.selectedPanelLgMinHeight);
				} else if ($selectedPanel.hasClass("form-control-sm")) {
					$selectedPanel.css("min-height", this.options.selectedPanelSmMinHeight);
				} else {
					$selectedPanel.css("min-height", this.options.selectedPanelDefMinHeight);
				}
			};

			_proto.Enable = function Enable($selectedPanel) {
				$selectedPanel.css({
					"background-color": ""
				});
			};

			_proto.Disable = function Disable($selectedPanel) {
				$selectedPanel.css({
					"background-color": this.options.selectedPanelDisabledBackgroundColor
				});
			};

			_proto.FocusIn = function FocusIn($selectedPanel) {
				if ($selectedPanel.hasClass("is-valid")) {
					$selectedPanel.css("box-shadow", this.options.selectedPanelFocusValidBoxShadow);
				} else if ($selectedPanel.hasClass("is-invalid")) {
					$selectedPanel.css("box-shadow", this.options.selectedPanelFocusInvalidBoxShadow);
				} else {
					$selectedPanel.css("box-shadow", this.options.selectedPanelFocusBoxShadow).css("border-color", this.options.selectedPanelFocusBorderColor);
				}
			};

			_proto.FocusOut = function FocusOut($selectedPanel) {
				$selectedPanel.css("box-shadow", "").css("border-color", "");
			};

			return Bs4AdapterJs;
		}();

	var defSelectedPanelStyleSys = {
		'display': 'flex',
		'flex-wrap': 'wrap',
		'list-style-type': 'none'
	}; // remove bullets since this is ul

	var defFilterInputStyleSys = {
		'width': '2ch',
		'border': '0',
		'padding': '0',
		'outline': 'none',
		'background-color': 'transparent'
	};
	var defDropDownMenuStyleSys = {
		'list-style-type': 'none'
	}; // remove bullets since this is ul
	// jQuery used for:
	// $.extend, $.contains, $("<div>"), $(function(){}) aka ready
	// $e.trigger, $e.unbind, $e.on; but namespaces are not used;
	// events: "focusin", "focusout", "mouseover", "mouseout", "keydown", "keyup", "click"
	// $e.show, $e.hide, $e.focus, $e.css
	// $e.appendTo, $e.remove, $e.find, $e.closest, $e.prev, $e.data, $e.val

	var MultiSelect =
		/*#__PURE__*/
		function () {
			function MultiSelect(selectElement, options, onDispose, adapter, window, $$$1) {
				if (typeof Popper === 'undefined') {
					throw new TypeError('DashboardCode BsMultiSelect require Popper.js (https://popper.js.org)');
				} // readonly


				this.selectElement = selectElement;
				this.adapter = adapter;
				this.window = window;
				this.onDispose = onDispose;
				this.$ = $$$1;
				this.options = $$$1.extend({}, options);
				this.container = null;
				this.selectedPanel = null;
				this.filterInputItem = null;
				this.filterInput = null;
				this.dropDownMenu = null;
				this.popper = null; // removable handlers

				this.selectedPanelClick = null;
				this.documentMouseup = null;
				this.containerMousedown = null;
				this.documentMouseup2 = null; // state

				this.disabled = null;
				this.filterInputItemOffsetLeft = null; // used to detect changes in input field position (by comparision with current value)

				this.skipFocusout = false;
				this.hoveredDropDownItem = null;
				this.hoveredDropDownIndex = null;
				this.hasDropDownVisible = false; // jquery adapters

				this.$document = $$$1(window.document);
				this.$selectElement = $$$1(selectElement);
				this.init();
			}

			var _proto = MultiSelect.prototype;

			_proto.updateDropDownPosition = function updateDropDownPosition(force) {
				var offsetLeft = this.filterInputItem.offsetLeft;

				if (force || this.filterInputItemOffsetLeft != offsetLeft) {
					this.popper.update();
					this.filterInputItemOffsetLeft = offsetLeft;
				}
			};

			_proto.hideDropDown = function hideDropDown() {
				this.dropDownMenu.style.display = 'none';
			};

			_proto.showDropDown = function showDropDown() {
				this.dropDownMenu.style.display = 'block';
			}; // Public methods


			_proto.resetDropDownMenuHover = function resetDropDownMenuHover() {
				if (this.hoveredDropDownItem !== null) {
					this.adapter.HoverOut(this.$(this.hoveredDropDownItem));
					this.hoveredDropDownItem = null;
				}

				this.hoveredDropDownIndex = null;
			};

			_proto.filterDropDownMenu = function filterDropDownMenu() {
				var _this = this;

				var text = this.filterInput.value.trim().toLowerCase();
				var visible = 0;
				this.$(this.dropDownMenu).find('LI').each(function (i, dropDownMenuItem) {
					var $dropDownMenuItem = _this.$(dropDownMenuItem);

					if (text == '') {
						$dropDownMenuItem.show();
						visible++;
					} else {
						var itemText = $dropDownMenuItem.data("option-text");
						var option = $dropDownMenuItem.data("option");

						if (!option.selected && !option.hidden && !option.disabled && itemText.indexOf(text) >= 0) {
							$dropDownMenuItem.show();
							visible++;
						} else {
							$dropDownMenuItem.hide();
						}
					}
				});
				this.hasDropDownVisible = visible > 0;
				this.resetDropDownMenuHover();
			};

			_proto.clearFilterInput = function clearFilterInput(updatePosition) {
				if (this.filterInput.value) {
					this.filterInput.value = '';
					this.input(updatePosition);
				}
			};

			_proto.closeDropDown = function closeDropDown() {
				this.resetDropDownMenuHover();
				this.clearFilterInput(true);
				this.hideDropDown();
			};

			_proto.appendDropDownItem = function appendDropDownItem(optionElement) {
				var _this2 = this;

				var isHidden = optionElement.hidden;
				var itemText = optionElement.text;
				var $dropDownItem = this.$("<LI/>").prop("hidden", isHidden);
				$dropDownItem.data("option-text", itemText.toLowerCase()).appendTo(this.dropDownMenu);
				$dropDownItem.data("option", optionElement);
				var adjustDropDownItem = this.adapter.CreateDropDownItemContent($dropDownItem, optionElement.value, itemText);
				var isDisabled = optionElement.disabled;
				var isSelected = optionElement.selected;
				if (isSelected && isDisabled) adjustDropDownItem.disabledStyle(true);else if (isDisabled) adjustDropDownItem.disable(isDisabled);
				adjustDropDownItem.onSelected(function () {
					var toggleItem = $dropDownItem.data("option-toggle");
					toggleItem();

					_this2.filterInput.focus();
				});

				var selectItem = function selectItem() {
					if (optionElement.hidden) return;

					var $selectedItem = _this2.$("<LI/>");

					var adjustPair = function adjustPair(isSelected, toggle, remove) {
						optionElement.selected = isSelected;
						adjustDropDownItem.select(isSelected);
						$dropDownItem.data("option-toggle", toggle);
						$selectedItem.data("option-remove", remove);
					};

					var removeItem = function removeItem() {
						adjustDropDownItem.disabledStyle(false);
						adjustDropDownItem.disable(optionElement.disabled);
						adjustPair(false, function () {
							if (optionElement.disabled) return;
							selectItem();

							_this2.$selectElement.trigger('change');
						}, null, true);
						$selectedItem.remove();

						_this2.$selectElement.trigger('change');
					};

					var removeItemAndCloseDropDown = function removeItemAndCloseDropDown() {
						removeItem();

						_this2.closeDropDown();
					};

					_this2.adapter.CreateSelectedItemContent($selectedItem, itemText, removeItemAndCloseDropDown, _this2.disabled, optionElement.disabled);

					adjustPair(true, removeItem, removeItemAndCloseDropDown);
					$selectedItem.insertBefore(_this2.filterInputItem);
				};

				$dropDownItem.mouseover(function () {
					return _this2.adapter.HoverIn($dropDownItem);
				}).mouseout(function () {
					return _this2.adapter.HoverOut($dropDownItem);
				});
				if (optionElement.selected) selectItem();else $dropDownItem.data("option-toggle", function () {
					if (optionElement.disabled) return;
					selectItem();
				});
			};

			_proto.keydownArrow = function keydownArrow(down) {
				var visibleNodeListArray = this.$(this.dropDownMenu).find('LI:not([style*="display: none"]):not(:hidden)').toArray();

				if (visibleNodeListArray.length > 0) {
					if (this.hasDropDownVisible) {
						this.updateDropDownPosition(true);
						this.showDropDown();
					}

					if (this.hoveredDropDownItem === null) {
						this.hoveredDropDownIndex = down ? 0 : visibleNodeListArray.length - 1;
					} else {
						this.adapter.HoverOut(this.$(this.hoveredDropDownItem));

						if (down) {
							var newIndex = this.hoveredDropDownIndex + 1;
							this.hoveredDropDownIndex = newIndex < visibleNodeListArray.length ? newIndex : 0;
						} else {
							var _newIndex = this.hoveredDropDownIndex - 1;

							this.hoveredDropDownIndex = _newIndex >= 0 ? _newIndex : visibleNodeListArray.length - 1;
						}
					}

					this.hoveredDropDownItem = visibleNodeListArray[this.hoveredDropDownIndex];
					this.adapter.HoverIn(this.$(this.hoveredDropDownItem));
				}
			};

			_proto.input = function input(forceUpdatePosition) {
				this.filterInput.style.width = this.filterInput.value.length * 1.3 + 2 + "ch";
				this.filterDropDownMenu();

				if (this.hasDropDownVisible) {
					if (forceUpdatePosition) // ignore it if it is called from
						this.updateDropDownPosition(forceUpdatePosition); // we need it to support case when textbox changes its place because of line break (texbox grow with each key press)

					this.showDropDown();
				} else {
					this.hideDropDown();
				}
			};

			_proto.Update = function Update() {
				var $selectedPanel = this.$(this.selectedPanel);
				this.adapter.UpdateIsValid($selectedPanel);
				this.UpdateSizeImpl($selectedPanel);
				this.UpdateDisabledImpl(this.$(this.container), $selectedPanel);
			};

			_proto.Dispose = function Dispose() {
				if (this.onDispose) this.onDispose(); // removable handlers

				this.$document.unbind("mouseup", this.documentMouseup).unbind("mouseup", this.documentMouseup2);

				if (this.adapter !== null) {
					this.adapter.Dispose();
				}

				if (this.popper !== null) {
					this.popper.destroy();
				}

				if (this.container !== null) {
					this.$(this.container).remove();
				} // this.selectedPanel = null;
				// this.filterInputItem = null;
				// this.filterInput = null;
				// this.dropDownMenu = null;
				// this.selectElement = null;
				// this.options = null;

			};

			_proto.UpdateSize = function UpdateSize() {
				this.UpdateSizeImpl(this.$(this.selectedPanel));
			};

			_proto.UpdateDisabled = function UpdateDisabled() {
				this.UpdateDisabledImpl(this.$(this.container), this.$(this.selectedPanel));
			};

			_proto.UpdateSizeImpl = function UpdateSizeImpl($selectedPanel) {
				if (this.adapter.UpdateSize) this.adapter.UpdateSize($selectedPanel);
			};

			_proto.UpdateDisabledImpl = function UpdateDisabledImpl($container, $selectedPanel) {
				var disabled = this.selectElement.disabled;

				if (this.disabled !== disabled) {
					if (disabled) {
						this.filterInput.style.display = "none";
						this.adapter.Disable($selectedPanel);
						$container.unbind("mousedown", this.containerMousedown);
						this.$document.unbind("mouseup", this.documentMouseup);
						$selectedPanel.unbind("click", this.selectedPanelClick);
						this.$document.unbind("mouseup", this.documentMouseup2);
					} else {
						this.filterInput.style.display = "inline-block";
						this.adapter.Enable($selectedPanel);
						$container.mousedown(this.containerMousedown); // removable

						this.$document.mouseup(this.documentMouseup); // removable

						$selectedPanel.click(this.selectedPanelClick); // removable

						this.$document.mouseup(this.documentMouseup2); // removable
					}

					this.disabled = disabled;
				}
			};

			_proto.init = function init() {
				var _this3 = this;

				var $selectElement = this.$(this.selectElement);
				$selectElement.hide();
				var $container = this.$("<DIV/>");
				this.container = $container.get(0);
				var $selectedPanel = this.$("<UL/>");
				$selectedPanel.css(defSelectedPanelStyleSys);
				this.selectedPanel = $selectedPanel.get(0);
				$selectedPanel.appendTo(this.container);
				var $filterInputItem = this.$('<LI/>');
				this.filterInputItem = $filterInputItem.get(0);
				$filterInputItem.appendTo(this.selectedPanel);
				var $filterInput = this.$('<INPUT type="search" autocomplete="off">');
				$filterInput.css(defFilterInputStyleSys);
				$filterInput.appendTo(this.filterInputItem);
				this.filterInput = $filterInput.get(0);
				var $dropDownMenu = this.$("<UL/>").css({
					"display": "none"
				}).appendTo($container);
				this.dropDownMenu = $dropDownMenu.get(0); // prevent heavy understandable styling error

				$dropDownMenu.css(defDropDownMenuStyleSys); // create handlers

				this.documentMouseup = function () {
					_this3.skipFocusout = false;
				};

				this.containerMousedown = function () {
					_this3.skipFocusout = true;
				};

				this.documentMouseup2 = function (event) {
					if (!(_this3.container === event.target || _this3.$.contains(_this3.container, event.target))) {
						_this3.closeDropDown();
					}
				};

				this.selectedPanelClick = function (event) {
					if (event.target.nodeName != "INPUT") _this3.$(_this3.filterInput).val('').focus();

					if (_this3.hasDropDownVisible && _this3.adapter.IsClickToOpenDropdown(event)) {
						_this3.updateDropDownPosition(true);

						_this3.showDropDown();
					}
				};

				this.adapter.Init({
					container: $container,
					selectedPanel: $selectedPanel,
					filterInputItem: $filterInputItem,
					filterInput: $filterInput,
					dropDownMenu: $dropDownMenu
				});
				$container.insertAfter($selectElement);
				this.popper = new Popper(this.filterInput, this.dropDownMenu, {
					placement: 'bottom-start',
					modifiers: {
						preventOverflow: {
							enabled: false
						},
						hide: {
							enabled: false
						},
						flip: {
							enabled: false
						}
					}
				});
				this.adapter.UpdateIsValid($selectedPanel);
				this.UpdateSizeImpl($selectedPanel);
				this.UpdateDisabledImpl($container, $selectedPanel); // some browsers (IE11) can change select value (as part of "autocomplete") after page is loaded but before "ready" event
				// bellow: ready shortcut

				this.$(function () {
					var selectOptions = $selectElement.find('OPTION');
					selectOptions.each(function (index, el) {
						_this3.appendDropDownItem(el);
					});
					_this3.hasDropDownVisible = selectOptions.length > 0;

					_this3.updateDropDownPosition(false);
				});
				$dropDownMenu.click(function (event) {
					return event.stopPropagation();
				});
				$dropDownMenu.mouseover(function () {
					return _this3.resetDropDownMenuHover();
				});
				$filterInput.focusin(function () {
					return _this3.adapter.FocusIn($selectedPanel);
				}).focusout(function () {
					if (!_this3.skipFocusout) _this3.adapter.FocusOut($selectedPanel);
				});
				$filterInput.on("keydown", function (event) {
					if ([38, 40, 13].indexOf(event.which) >= 0 || event.which == 9 && _this3.filterInput.value) {
						event.preventDefault();
					}

					if (event.which == 38) {
						_this3.keydownArrow(false);
					} else if (event.which == 40) {
						if (_this3.hoveredDropDownItem === null && _this3.hasDropDownVisible) {
							_this3.showDropDown();
						}

						_this3.keydownArrow(true);
					} else if (event.which == 9) {
						if (!_this3.filterInput.value) {
							_this3.closeDropDown();
						}
					} else if (event.which == 8) {
						// NOTE: this will process backspace only if there are no text in the input field
						// If user will find this inconvinient, we will need to calculate something like this
						// this.isBackspaceAtStartPoint = (this.filterInput.selectionStart == 0 && this.filterInput.selectionEnd == 0);
						if (!_this3.filterInput.value) {
							var $penult = _this3.$(_this3.selectedPanel).find("LI:last").prev();

							if ($penult.length) {
								var removeItem = $penult.data("option-remove");
								removeItem();
							}

							_this3.updateDropDownPosition(false);
						}
					}

					if ([38, 40, 13, 9].indexOf(event.which) == -1) _this3.resetDropDownMenuHover();
				});
				$filterInput.on("keyup", function (event) {
					if (event.which == 13 || event.which == 9) {
						if (_this3.hoveredDropDownItem) {
							var $hoveredDropDownItem = _this3.$(_this3.hoveredDropDownItem);

							var toggleItem = $hoveredDropDownItem.data("option-toggle");
							toggleItem();

							_this3.closeDropDown();
						} else {
							var text = _this3.filterInput.value.trim().toLowerCase();

							var dropDownItems = _this3.dropDownMenu.querySelectorAll("LI");

							var dropDownItem = null;

							for (var i = 0; i < dropDownItems.length; ++i) {
								var it = dropDownItems[i];

								if (it.textContent.trim().toLowerCase() == text) {
									dropDownItem = it;
									break;
								}
							}

							if (dropDownItem) {
								var $dropDownItem = _this3.$(dropDownItem);

								var option = $dropDownItem.data("option");

								if (!option.selected) {
									var toggle = $dropDownItem.data("option-toggle");
									toggle();
								}

								_this3.clearFilterInput(true);
							}
						}
					} else if (event.which == 27) {
						// escape
						_this3.closeDropDown();
					}
				});
				$filterInput.on('input', function () {
					_this3.input(true);
				});
			};

			return MultiSelect;
		}();

	function AddToJQueryPrototype(pluginName, createPlugin, $$$1) {
		var firstChar = pluginName.charAt(0);
		var firstCharLower = firstChar.toLowerCase();

		if (firstCharLower == firstChar) {
			throw new TypeError("Plugin name '" + pluginName + "' should be started from upper case char");
		}

		var prototypableName = firstCharLower + pluginName.slice(1);
		var noConflictPrototypable = $$$1.fn[prototypableName];
		var dataKey = "DashboardCode." + pluginName;

		function prototypable(options) {
			return this.each(function () {
				var $e = $$$1(this);
				var instance = $e.data(dataKey);
				var isMethodName = typeof options === 'string';

				if (!instance) {
					if (isMethodName && /Dispose/.test(options)) {
						return;
					}

					var optionsObject = typeof options === 'object' ? options : null;
					instance = createPlugin(this, optionsObject, function () {
						$e.removeData(dataKey);
					});
					$e.data(dataKey, instance);
				}

				if (isMethodName) {
					var methodName = options;

					if (typeof instance[methodName] === 'undefined') {
						throw new TypeError("No method named '" + methodName + "'");
					}

					instance[methodName]();
				}
			});
		}

		$$$1.fn[prototypableName] = prototypable; // pluginName with first capitalized letter - return plugin instance for 1st $selected item

		$$$1.fn[pluginName] = function () {
			return $$$1(this).data(dataKey);
		};

		$$$1.fn[prototypableName].noConflict = function () {
			$$$1.fn[prototypableName] = noConflictPrototypable;
			return prototypable;
		};
	}

	function disableButton($selectedPanel, isDisabled) {
		$selectedPanel.find('BUTTON').prop("disabled", isDisabled);
	}

	var Bs4Adapter =
		/*#__PURE__*/
		function () {
			function Bs4Adapter(hiddenSelect, adapter, classes, $$$1) {
				var defaults = {
					containerClass: 'dashboardcode-bsmultiselect',
					dropDownMenuClass: 'dropdown-menu pb-0',
					dropDownItemClass: 'pl-2',
					dropDownItemHoverClass: 'text-primary bg-light',
					selectedPanelClass: 'form-control',
					selectedItemClass: 'badge',
					removeSelectedItemButtonClass: 'close',
					filterInputItemClass: '',
					filterInputClass: ''
				};
				this.classes = $$$1.extend({}, defaults, classes);
				this.$ = $$$1;
				this.hiddenSelect = hiddenSelect;
				this.adapter = adapter;
				this.bs4LabelDispose = null;
			}

			var _proto = Bs4Adapter.prototype;

			_proto.HandleLabel = function HandleLabel($selectedPanel) {
				var inputId = this.hiddenSelect.id;
				var $formGroup = this.$(this.hiddenSelect).closest('.form-group');

				if ($formGroup.length == 1) {
					var $label = $formGroup.find("label[for=\"" + inputId + "\"]");
					var forId = $label.attr('for');

					if (forId == this.hiddenSelect.id) {
						var id = this.classes.containerClass + "-generated-filter-id-" + this.hiddenSelect.id;
						$selectedPanel.find('input').attr('id', id);
						$label.attr('for', id);
						return function () {
							$label.attr('for', forId);
						};
					}
				}

				return null;
			}; // ------------------------------------------


			_proto.Init = function Init(dom) {
				dom.container.addClass(this.classes.containerClass);
				dom.selectedPanel.addClass(this.classes.selectedPanelClass);
				dom.dropDownMenu.addClass(this.classes.dropDownMenuClass);
				dom.filterInputItem.addClass(this.classes.filterInputItemClass);
				dom.filterInput.addClass(this.classes.filterInputClass);
				if (this.adapter.OnInit) this.adapter.OnInit(dom);
				this.bs4LabelDispose = this.HandleLabel(dom.selectedPanel);
			};

			_proto.Dispose = function Dispose() {
				if (this.bs4LabelDispose) this.bs4LabelDispose();
			}; // ------------------------


			_proto.CreateDropDownItemContent = function CreateDropDownItemContent($dropDownItem, optionId, itemText) {
				var checkBoxId = this.classes.containerClass + "-" + this.hiddenSelect.name.toLowerCase() + "-generated-id-" + optionId.toLowerCase();
				var $dropDownItemContent = this.$(
					"<div class=\"pure-css-switch\">\n" +
					"<label for=\"" + checkBoxId + "\" class=\"d-flex\">\n" +
					"<span class=\"flex-grow-1\">" + itemText + "</span>\n" +
					"<input class=\"simple-switch-input\" id=\"" + checkBoxId + "\" type=\"checkbox\"><span class=\"simple-switch dark mr-2\"></span>\n" +
					"</label>\n" +
					"</div>"
				);
				$dropDownItemContent.appendTo($dropDownItem);
				var $checkBox = $dropDownItemContent.find("INPUT[type=\"checkbox\"]");
				$dropDownItem.addClass(this.classes.dropDownItemClass);
				var dropDownItem = $dropDownItem.get(0);
				var dropDownItemContent = $dropDownItemContent.get(0);
				var adapter = this.adapter;
				return {
					select: function select(isSelected) {
						$checkBox.prop('checked', isSelected);
					},
					disable: function disable(isDisabled) {
						$checkBox.prop('disabled', isDisabled);
					},
					disabledStyle: function disabledStyle(_disabledStyle) {
						adapter.DisabledStyle($checkBox, _disabledStyle);
					},
					onSelected: function onSelected(toggle) {
						$checkBox.on("change", toggle);
						$dropDownItem.on("click", function (e) {
							if (e.target == dropDownItem || e.target == dropDownItemContent) toggle();
						});
					}
				};
			};

			_proto.CreateSelectedItemContent = function CreateSelectedItemContent($selectedItem, itemText, removeSelectedItem, controlDisabled, optionDisabled) {
				var $content = this.$("<span>" + itemText + "</span>").appendTo($selectedItem);
				if (optionDisabled) this.adapter.DisableSelectedItemContent($content);
				var $button = this.$('<button aria-label="Close" tabIndex="-1" type="button"><span aria-hidden="true">&times;</span></button>').css("white-space", "nowrap").on("click", removeSelectedItem).appendTo($selectedItem).prop("disabled", controlDisabled);
				$selectedItem.addClass(this.classes.selectedItemClass);
				$button.addClass(this.classes.removeSelectedItemButtonClass);
				if (this.adapter.CreateSelectedItemContent) this.adapter.CreateSelectedItemContent($selectedItem, $button);
			}; // -----------------------


			_proto.IsClickToOpenDropdown = function IsClickToOpenDropdown(event) {
				var target = event.target;
				var nodeName = target.nodeName;
				return !(nodeName == "BUTTON" || nodeName == "SPAN" && target.parentElement.nodeName == "BUTTON");
			};

			_proto.UpdateIsValid = function UpdateIsValid($selectedPanel) {
				var $hiddenSelect = this.$(this.hiddenSelect);

				if ($hiddenSelect.hasClass("is-valid")) {
					$selectedPanel.addClass("is-valid");
				}

				if ($hiddenSelect.hasClass("is-invalid")) {
					$selectedPanel.addClass("is-invalid");
				}
			};

			_proto.UpdateSize = function UpdateSize($selectedPanel) {
				if (this.adapter.UpdateSize) this.adapter.UpdateSize($selectedPanel);
			};

			_proto.HoverIn = function HoverIn($dropDownItem) {
				$dropDownItem.addClass(this.classes.dropDownItemHoverClass);
			};

			_proto.HoverOut = function HoverOut($dropDownItem) {
				$dropDownItem.removeClass(this.classes.dropDownItemHoverClass);
			};

			_proto.Enable = function Enable($selectedPanel) {
				this.adapter.Enable($selectedPanel);
				disableButton($selectedPanel, false);
			};

			_proto.Disable = function Disable($selectedPanel) {
				this.adapter.Disable($selectedPanel);
				disableButton($selectedPanel, true);
			};

			_proto.FocusIn = function FocusIn($selectedPanel) {
				this.adapter.FocusIn($selectedPanel);
			};

			_proto.FocusOut = function FocusOut($selectedPanel) {
				this.adapter.FocusOut($selectedPanel);
			};

			return Bs4Adapter;
		}();

	(function (window, $$$1) {
		AddToJQueryPrototype('BsMultiSelect', function (element, optionsObject, onDispose) {
			var adapter = optionsObject && optionsObject.useCss ? new Bs4AdapterCss(optionsObject, $$$1) : new Bs4AdapterJs(optionsObject, $$$1);
			var facade = new Bs4Adapter(element, adapter, optionsObject, $$$1);
			return new MultiSelect(element, optionsObject, onDispose, facade, window, $$$1);
		}, $$$1);
	})(window, $);

})));