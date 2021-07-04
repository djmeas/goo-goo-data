/**
 * This class convenient formats tracker entry values to be displayed for the user.
 */
export default class EntryAmount {
  constructor(value) {
    this.value = value;
  }

  /**
   * Returns the value rounded down.
   * 
   * @returns {Integer} The entry value.
   */
  getValueIntRoundedDown() {
    return Math.floor(this.value);
  }

  /**
   * Returns the value rounded up.
   * 
   * @returns {Integer} The entry value.
   */
  getValueIntRoundedUp() {
    return Math.ceil(this.value);
  }

  /**
   * Returns the value with two decimal places.
   * 
   * @returns {Float} The entry value.
   */
  getValueDecimal() {
    return this.value.toFixed(2);
  }

  /**
   * Returns the alternaive text (if set).
   * 
   * @returns {Mixed}
   */
  getAlternateText() {
    return this.value;
  }

  /**
   * Returns the alternaive value (if set).
   * 
   * @returns {Mixed}
   */
  getAlternateValue() {
    return this.value;
  }

  /**
   * Returns the entry value.
   * 
   * @returns {Mixed}
   */
  getValue() {
    return this.value;
  }

  /**
   * Sets the entry value.
   */
  setValue(value) {
    this.value = value;
  }
}