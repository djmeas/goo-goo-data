export default {
  data() {
    return {
      trackerEntriesPaginationDetails: null,
      trackerEntries: [],
      trackerFilters: {
        sort: 'entry_datetime',
        dir: 'asc'
      }
    }
  },

  methods: {
    getTrackerEntries(paginationUrl) {
      let currentPage = this.trackerEntriesPaginationDetails 
        ? this.trackerEntriesPaginationDetails.current_page 
        : 1;

      let targetUrl = paginationUrl 
        ? paginationUrl 
        : `${Vue.prototype.$baseAPI}/tracker?page=${currentPage}`;
      
      targetUrl += `&sort=${this.trackerFilters.sort}&dir=${this.trackerFilters.dir}`;

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
    },

    _trackerSortColumn(column) {
      this.trackerFilters.sort = column;
      this.trackerFilters.dir = this.trackerFilters.dir === 'asc' ? 'desc' : 'asc';
      this.getTrackerEntries();
    }
  }
}