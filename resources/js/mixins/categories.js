export default {
  data () {
     return {
      categories: [],
      selectedCategory: null
     }
  },

  methods: {
    /**
     * Gets all the categories and subcategories.
     */
    getCategories() {
      axios.get(`${Vue.prototype.$baseAPI}/category`)
        .then(res => {
          this.categories = res.data;
        })
        .catch(err => {
          this.$toaster.error('Whoops! Could not fetch the categories.');
        })
    }
  },

  computed: {
    /**
     * Computes the categories array to find a particular category.
     * 
     * @returns {Object} The selected category.
     */
    selectedCategoryOptions() {
      return this.selectedCategory ? this.categories[this.selectedCategory] : [];
    },
  },
}