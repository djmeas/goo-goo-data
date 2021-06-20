import EntryAmount from './entryAmount';

export default class DollarEntry extends EntryAmount {
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
    return `${this.getAlternateValue()} ${this.alternate}`;
  }

  getAlternateValue() {
    return (this.value / .20).toFixed(0);
  }
}