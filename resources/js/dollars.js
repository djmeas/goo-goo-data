import EntryAmount from './entryAmount';

export default class Dollars extends EntryAmount {
  constructor(value) {
    super();
    this.value = value;
    this.prefix = '$';
    this.alternate = 'diapers';
  }

  getFormattedText() {
    return `${this.prefix}${this.value}`;
  }

  getAlternateText() {
    return `${this.valueInDiapers()} ${this.alternate}`;
  }

  valueInDiapers() {
    return (this.value / .20).toFixed(0);
  }
}