import EntryAmount from './entryAmount';

export default class OunceEntry extends EntryAmount {
  constructor(value) {
    super();
    this.value = value;
    this.suffix = 'oz';
    this.alternate = 'gallons';
  }

  getFormattedText() {
    let valueFormatted = this.value;
    if (valueFormatted % 1 === 0) {
      valueFormatted = Math.floor(valueFormatted);
    }
    return `${valueFormatted} ${this.suffix}`;
  }

  getAlternateText() {
    return `${this.getAlternateValue()} ${this.alternate}`;
  }

  getAlternateValue() {
    return (this.value * 0.0078125).toFixed(3);
  }
}