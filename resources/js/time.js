import EntryAmount from './entryAmount';

export default class TimeEntry extends EntryAmount {
  constructor(value) {
    super();
    this.value = value;
    this.suffix = 'minutes';
    this.alternate = 'hour(s)';
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
    return (this.value / 60).toFixed(2);
  }
}