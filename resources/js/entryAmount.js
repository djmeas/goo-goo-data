export default class EntryAmount {
  constructor(value) {
    this.value = value;
  }

  getValueIntRoundedDown() {
    return Math.floor(this.value);
  }

  getValueIntRoundedUp() {
    return Math.ceil(this.value);
  }

  getValueDecimal() {
    return this.value.toFixed(2);
  }

  getAlternateText() {
    return this.value;
  }

  getAlternateValue() {
    return this.value;
  }

  getValue() {
    return this.value;
  }

  setValue(value) {
    this.value = value;
  }
}