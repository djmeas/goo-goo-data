export default {
  data () {
     return {
      categories: [],
      selectedCategory: null
     }
  },

  methods: {
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
    selectedCategoryOptions() {
      return this.selectedCategory ? this.categories[this.selectedCategory] : [];
    }
  },
}