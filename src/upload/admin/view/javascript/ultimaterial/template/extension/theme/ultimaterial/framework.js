import URange from '../../../../config/input/range';

class UFramework {
  constructor() {
    this.range = new URange({
      onChange: (element) => {
        let target = document.getElementById(element.dataset.target),
            dataSet = element.dataset.set;

        target.style.setProperty(dataSet, element.nextElementSibling.innerText);
      }
    });
  }
}

export default new UFramework();
