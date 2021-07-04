import EntryAmount from './entryAmount';

/**
 * This class formats entries into ounces.
 * 
 * @extends EntryAmount
 */
export default class OunceEntry extends EntryAmount {
  constructor(value) {
    super();
    this.value = value;
    this.suffix = 'oz';
    this.alternate = 'gallons';
  }

  /**
   * Returns the value formatted with the appropriate suffix/prefix.
   * 
   * @returns {String} formatted value text.
   */
  getFormattedText() {
    let valueFormatted = this.value;
    if (valueFormatted % 1 === 0) {
      valueFormatted = Math.floor(valueFormatted);
    }
    return `${valueFormatted} ${this.suffix}`;
  }

  /**
   * Returns the alternative value formatted with the appropriate suffix/prefix.
   * 
   * @returns {String} formatted value text.
   */
  getAlternateText() {
    return `${this.getAlternateValue()} ${this.alternate}`;
  }

  /**
   * Returns a the alternative value.
   * 
   * @returns {Float} formatted value text.
   */
  getAlternateValue() {
    return (this.value * 0.0078125).toFixed(3);
  }
}