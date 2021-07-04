import EntryAmount from './entryAmount';

/**
 * This class formats entries into dollar currency.
 * 
 * @extends EntryAmount
 */
export default class DollarEntry extends EntryAmount {
  constructor(value) {
    super();
    this.value = value;
    this.prefix = '$';
    this.alternate = 'diapers';
  }

  /**
   * Returns the value formatted with the appropriate suffix/prefix.
   * 
   * @returns {String} formatted value text.
   */
  getFormattedText() {
    return `${this.prefix}${this.value}`;
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
    return (this.value / .20).toFixed(0);
  }
}