export default {
  data() {
    return {
      // trackerEntriesPaginationDetails: null,
      // trackerEntries: [],
      // trackerFilters: {
      //   sort: 'entry_datetime',
      //   dir: 'asc'
      // }
    }
  },

  methods: {
    /**
     * Fetches the tracker entries to be dispalyed in the table.
     * 
     * @param {string} paginationUrl The API url for paginated data.
     */
    getTrackerEntries(paginationUrl, setCurrentPage) {
      let currentPage = this.trackerEntriesPaginationDetails 
        ? this.trackerEntriesPaginationDetails.current_page 
        : 1;

      if (setCurrentPage) {
        currentPage = setCurrentPage;
      }

      let targetUrl = paginationUrl 
        ? paginationUrl 
        : `${Vue.prototype.$baseAPI}/tracker?page=${currentPage}`;
      
      targetUrl += `&sort=${this.trackerFilters.sort}&dir=${this.trackerFilters.dir}`;

      axios.get(targetUrl)
        .then(res => {
          // There can be times where the user will delete the last
          // entry of a particular page (e.g. page 3 has one entry).
          // If that is the case, we need to re-fetch the tracker 
          // entries by going back to the previous page.
          if (res.data.data.length === 0 && currentPage !== 1) {
            this.getTrackerEntries(null, currentPage - 1);
          } else {
            this.trackerEntriesPaginationDetails = res.data;
            this.trackerEntries = res.data.data;
          }
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Saves a tracker entry.
     */
    saveTrackerEntry() {
      this.$v.formTracker.$touch();

      if (!this.$v.formTracker.$invalid) {
        this.formTracker.category_id = this.formTracker.category.id;

        axios.post(`${Vue.prototype.$baseAPI}/tracker`, this.formTracker)
          .then(res => {
            this.$toasted.success('Entry successfully saved.');
            this.$emit('eventSaveTrackerEntry');
          })
          .catch(err => {
            console.log('saveTrackerEntry catch: ', err);
            this.$toasted.error(err.response.data);
          });
      } else {
        this.$toasted.error('Please enter all required fields.');
      }
    },

    deleteTrackerEntry(entryId) {
      axios.delete(`${Vue.prototype.$baseAPI}/tracker/${entryId}`)
        .then(res => {
          this.$toasted.success('Entry successfully deleted.');
          this.$emit('eventDeleteTrackerEntry');
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Sets the sort and direction before fetching the tracker entries.
     * 
     * @param {string} column 
     */
    _trackerSortColumn(column) {
      this.trackerFilters.sort = column;
      this.trackerFilters.dir = this.trackerFilters.dir === 'asc' ? 'desc' : 'asc';
      this.getTrackerEntries();
    }
  }
}