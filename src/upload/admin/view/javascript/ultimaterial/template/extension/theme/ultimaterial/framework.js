import Pickr from '@simonwep/pickr';
import URange from '../../../../config/input/range';

import UDialog from "../../../../../../../../catalog/view/theme/ultimaterial/src/javascript/config/dialog";

class UFramework {
  constructor() {
    this._range();
    this._dialog();
    this._colorPicker();
  }

  _range() {
    this.range = new URange({
      onChange: (element) => {
        let target = document.getElementById(element.dataset.target),
            dataProperty = element.dataset.property;

        target.style.setProperty(dataProperty, element.nextElementSibling.innerText);
      }
    });
  }

  _dialog() {
    this.dialog = new UDialog(document.getElementById('framework-dialog'), {
      dismissBackdrop: false,
      dismissClose: false,
      dismissEscape: false,
      moveToBody: false
    });
  }

  _colorPicker() {
    this.colorPickers = document.querySelectorAll('.color-picker__input');

    this.colorPickers.forEach(element => {
      var trigger = element;

      element = new Pickr({
        el: element,
        useAsButton: true,
        default: trigger.value,
        theme: 'nano',
        lockOpacity: 'lockOpacity' in trigger.dataset ? (trigger.dataset.lockOpacity === 'true') : false,
        swatches: [
          'rgba(0, 0, 0, 0.4)',
          'rgba(244, 67, 54, 0.4)',
          'rgba(233, 30, 99, 0.4)',
          'rgba(156, 39, 176, 0.4)',
          'rgba(103, 58, 183, 0.4)',
          'rgba(63, 81, 181, 0.4)',
          'rgba(33, 150, 243, 0.4)',
          'rgba(3, 169, 244, 0.4)',
          'rgba(0, 188, 212, 0.4)',
          'rgba(0, 150, 136, 0.4)',
          'rgba(76, 175, 80, 0.4)',
          'rgba(139, 195, 74, 0.4)',
          'rgba(205, 220, 57, 0.4)',
          'rgba(255, 235, 59, 0.4)'
        ],
        components: {
          preview: true,
          opacity: true,
          hue: true,
          interaction: {
            input: true,
            cancel: true,
            save: true
          }
        }
      }).on('show', () => {
        this.initColor = trigger.value;
      }).on('change', color => {
        let value = color.toRGBA().toString(0);

        trigger.value = value;
        trigger.style.setProperty('--color-picker', value);

        let target = document.getElementById(trigger.dataset.target),
            dataSet = trigger.dataset.property;

        target.style.setProperty(dataSet, value);
      }).on('cancel', () => {
        trigger.value = this.initColor;
        trigger.style.setProperty('--color-picker', this.initColor);

        let target = document.getElementById(trigger.dataset.target),
            dataSet = trigger.dataset.property;

        target.style.setProperty(dataSet, this.initColor);
      }).on('save', color => {
        this.initColor = color.toRGBA().toString(0);

        trigger.value = this.initColor;
        trigger.style.setProperty('--color-picker', this.initColor);

        let target = document.getElementById(trigger.dataset.target),
            dataSet = trigger.dataset.property;

        target.style.setProperty(dataSet, this.initColor);
        element.hide();
      }).on('hide', () => {
        trigger.value = this.initColor;
        trigger.style.setProperty('--color-picker', this.initColor);

        let target = document.getElementById(trigger.dataset.target),
            dataSet = trigger.dataset.property;

        target.style.setProperty(dataSet, this.initColor);

        this.initColor = undefined;
      });
    });
  }
}

export default new UFramework();
