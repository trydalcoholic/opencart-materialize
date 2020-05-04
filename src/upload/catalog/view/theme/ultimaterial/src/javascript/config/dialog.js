import dialogPolyfill from 'dialog-polyfill';

export default class UDialog {
  static _default = {
    dismissBackdrop: true,
    dismissClose: true,
    dismissEscape: true,
    moveToBody: true,
    onOpenStart: null,
    onOpenEnd: null,
    onCloseStart: null,
    onCloseEnd: null
  };

  constructor(element, option) {
    this.element = element;
    this.option = Object.assign(UDialog._default, option);

    this.dialogClose = this.element.querySelectorAll('.dialog__close');

    if (this.option.moveToBody) {
      document.body.append(this.element);
    }

    dialogPolyfill.registerDialog(this.element);

    this._setEventHandlers();
  }

  open() {
    if (typeof this.option.onOpenStart === 'function') {
      this.option.onOpenStart.call(this, this.element);
    }

    const rect = document.body.getBoundingClientRect();
    this._isBodyOverflowing = rect.left + rect.right < window.innerWidth;
    this._scrollbarWidth = this._getScrollbarWidth();
    this._setScrollbar();

    this.element.showModal();

    if (typeof this.option.onOpenEnd === 'function') {
      this.option.onOpenEnd.call(this, this.element);
    }
  }

  close() {
    if (typeof this.option.onCloseStart === 'function') {
      this.option.onCloseStart.call(this, this.element);
    }

    if (this._isBodyOverflowing) {
      document.body.style.overflow = 'auto';
    }

    this.element.close();
    this._removeEventHandlers();

    if (typeof this.option.onCloseEnd === 'function') {
      this.option.onCloseEnd.call(this, this.element);
    }
  }

  _setScrollbar() {
    /*if (this._isBodyOverflowing) {
      makeArray(SelectorEngine.find(Selector.FIXED_CONTENT))
      .forEach(element => {
        const actualPadding = element.style.paddingRight
        const calculatedPadding = window.getComputedStyle(element)['padding-right']
        Manipulator.setDataAttribute(element, 'padding-right', actualPadding)
        element.style.paddingRight = `${parseFloat(calculatedPadding) + this._scrollbarWidth}px`
      })

      makeArray(SelectorEngine.find(Selector.STICKY_CONTENT))
      .forEach(element => {
        const actualMargin = element.style.marginRight
        const calculatedMargin = window.getComputedStyle(element)['margin-right']
        Manipulator.setDataAttribute(element, 'margin-right', actualMargin)
        element.style.marginRight = `${parseFloat(calculatedMargin) - this._scrollbarWidth}px`
      })

      const actualPadding = document.body.style.paddingRight;
      const calculatedPadding = window.getComputedStyle(document.body)['padding-right'];

      Manipulator.setDataAttribute(document.body, 'padding-right', actualPadding)
      document.body.style.paddingRight = `${parseFloat(calculatedPadding) + this._scrollbarWidth}px`
    }*/

    document.body.style.overflow = 'hidden';
  }

  _setEventHandlers() {
    if (this.option.dismissBackdrop) {
      this._handleBackdropClickBound = this._handleBackdropClick.bind(this);
      this.element.addEventListener('click', this._handleBackdropClickBound, this._supportsPassive ? {passive: true} : false);
    }

    if (this.option.dismissClose) {
      this._handleDialogCloseBound = this._handleDialogClose.bind(this);
      this.dialogClose.forEach(element => element.addEventListener('click', this._handleDialogCloseBound, this._supportsPassive ? {passive: true} : false));
    }

    this._handleDialogKeyupBound = this._handleDialogKeyup.bind(this);
    document.addEventListener('keydown', this._handleDialogKeyupBound);

    /*this._handleWindowResizeBound = this._handleWindowResize.bind(this);
    window.addEventListener('resize', this._handleWindowResizeBound, this._supportsPassive ? {passive: true} : false);*/
  }

  _handleDialogClose() {
    if (this.element.open) {
      this.close();
    }
  }

  _handleBackdropClick(event) {
    if (this.element.open && (event.target.closest('.dialog__close') || event.target === this.element)) {
      this.close();
    }
  }

  _handleDialogKeyup(event) {
    if (event.code === 'Escape' && this.option.dismissEscape) {
      this.close();
    }

    if (event.code === 'Escape' && !this.option.dismissEscape) {
      event.preventDefault();

      return false;
    }
  }

  _removeEventHandlers() {
    if (this.option.dismissBackdrop) {
      this.element.removeEventListener('click', this._handleBackdropClickBound);
    }

    if (this.option.dismissClose) {
      this.dialogClose.forEach(element => element.removeEventListener('click', this._handleDialogCloseBound));
    }

    document.removeEventListener('keydown', this._handleDialogKeyupBound);

    // window.removeEventListener('resize', this._handleDialogKeyup);
  }

  /*_handleWindowResize() {
    clearTimeout(this.timerResize);

    this.timerResize = setTimeout(() => {
      this._getScrollbarWidth();
    }, 50);
  }*/

  _getScrollbarWidth() {
    const scrollDiv = document.createElement('div');

    scrollDiv.style.position = 'absolute';
    scrollDiv.style.width = '50px';
    scrollDiv.style.height = '50px';
    scrollDiv.style.overflow = 'scroll';
    scrollDiv.style.top = '-9999px';

    document.body.append(scrollDiv);

    this._scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth;

    scrollDiv.remove();
  }

  _supportsPassive() {
    let supportsPassive = false;

    try {
      let opts = Object.defineProperty({}, 'passive', {
        get: function() {
          supportsPassive = true;
        }
      });

      window.addEventListener('testPassive', null, opts);
      window.removeEventListener('testPassive', null, opts);
    } catch (e) {}

    return supportsPassive;
  }
}