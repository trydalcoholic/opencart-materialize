export default class URange {
  static _default = {
    onChange: null
  };

  constructor(option) {
    this.option = Object.assign(URange._default, option);

    this._setEventHandlers();
  }

  _setEventHandlers() {
    this._handleRangeBound = this._handleRange.bind(this);
    document.querySelectorAll('.slider__input').forEach(element => element.addEventListener('input', this._handleRangeBound));
  }

  _handleRange(event) {
    let target = event.target,
        output = target.nextElementSibling;

    target.style.setProperty('--slider-percent', 'calc(100% * ' + target.value + ' / 4)');
    output.innerText = target.value + 'rem';

    if (typeof this.option.onChange === 'function') {
      this.option.onChange.call(this, target);
    }
  }
}
