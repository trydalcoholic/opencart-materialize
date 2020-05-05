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
    this.colorElements = [];

    this.colorPickers.forEach(element => {
      this.colorElements.push(element);

      this.colorElements[element] = new Pickr({
        el: element,
        useAsButton: true,
        default: element.value,
        theme: 'nano',

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
        this.initColor = element.value;
      }).on('change', color => {
        let value = color.toRGBA().toString(0);

        element.value = value;
        element.style.setProperty('--color-picker', value);

        let target = document.getElementById(element.dataset.target),
            dataSet = element.dataset.property;

        target.style.setProperty(dataSet, value);
      }).on('cancel', () => {
        let value = this.initColor;

        element.value = value;
        element.style.setProperty('--color-picker', value);

        let target = document.getElementById(element.dataset.target),
            dataSet = element.dataset.property;

        target.style.setProperty(dataSet, value);
      }).on('save', color => {
        let value = color.toRGBA().toString(0);

        this.initColor = value;

        element.value = value;
        element.style.setProperty('--color-picker', value);

        let target = document.getElementById(element.dataset.target),
            dataSet = element.dataset.property;

        target.style.setProperty(dataSet, value);

        this.colorElements[element].hide();
      }).on('hide', () => {
        let value = this.initColor;

        element.value = value;
        element.style.setProperty('--color-picker', value);

        let target = document.getElementById(element.dataset.target),
          dataSet = element.dataset.property;

        target.style.setProperty(dataSet, value);

        this.initColor = undefined;
      });
    });
  }
}

export default new UFramework();
