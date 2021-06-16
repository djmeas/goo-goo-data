import EntryAmount from './entryAmount';

export default class Ounces extends EntryAmount {
  constructor(value) {
    super();
    this.value = value;
    this.suffix = 'oz';
    this.alternate = 'gallons';
  }

  getFormattedText() {
    return `${this.value} ${this.suffix}`;
  }

  getAlternateText() {
    return `${this.valueInGallons()} ${this.alternate}`;
  }

  valueInGallons() {
    return (this.value * 0.0078125).toFixed(3);
  }

  valueInBabyBottles() {
    return (this.value / 8).toFixed(2);
  }
}