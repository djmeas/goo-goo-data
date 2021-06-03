export default {
  data() {
    return {
      trackerEntriesPaginationDetails: null,
      trackerEntries: []
    }
  },

  methods: {
    getTrackerEntries(paginationUrl) {
      const targetUrl = paginationUrl ? paginationUrl : `${Vue.prototype.$baseAPI}/tracker?`;
      axios.get(targetUrl)
        .then(res => {
          this.trackerEntriesPaginationDetails = res.data;
          this.trackerEntries = res.data.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Saves a traccker entry.
     */
    saveTrackerEntry() {
      this.$v.formTracker.$touch();

      if (!this.$v.formTracker.$invalid) {
        this.formTracker.category_id = this.formTracker.category.id;

        axios.post(`${Vue.prototype.$baseAPI}/tracker`, this.formTracker)
          .then(res => {
            this.$emit('eventSaveTrackerEntry', res.data);

            this.$toasted.success('Entry successfully saved.');

            this._resetFormTracker();
          })
          .catch(err => {
            this.$toasted.error(err.response.data);
          });
      } else {
        this.$toasted.error('Please enter all required fields.');
      }
    }
  }
}