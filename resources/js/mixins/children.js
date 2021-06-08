export default {
  data () {
     return {
      child: null,
      children: []
     }
  },
  methods: {
     /**
      * Get the list of children for this user.
      * 
      */
     getChildren(hash) {
      let targetUrl = `${Vue.prototype.$baseAPI}/child`;
      
      if (hash) {
        targetUrl += `/${hash}`;
      }

      axios.get(targetUrl)
      .then(res => {
        if (hash) {
          this.child = res.data;
        } else {
          this.children = res.data;
        }
      })
      .catch(err => {

      })
     },

     /**
     * Deletes a child by its hash then filters it out of the UI.
     * @param {string} hash  The child's hash.
     */
    deleteChild(hash) {
      axios.delete(`${Vue.prototype.$baseAPI}/child/${hash}`)
        .then(res => {
          this.$toasted.success('Child successfully deleted.');

          this.children = this.children.filter(child => {
            return child.hash != hash;
          });
        })
        .catch(err => {
          this.$toasted.error('Whoops! The child could not be deleted.');
        })
    },

    /**
     * Makes a POST request to save a new child.
     * 
     * Requires component to: 
     * - Include a formChild object definition with vuelidate.
     */
     saveChild() {
      this.$v.formChild.$touch();

      if (!this.$v.formChild.$invalid) {
        var formPostData = new FormData();
        formPostData.append('form_data', JSON.stringify(this.formChild));
        formPostData.append('uploaded_file', this.$refs.uploaded_file.files[0]);

        axios.post(`${Vue.prototype.$baseAPI}/child`, formPostData)
          .then(res => {
            this.$emit('eventSaveChild', res.data);

            this.$toasted.success('Child successfully created.');

            this._resetFormChild();
          })
          .catch(err => {
            this.$toasted.error(err.response.data);
          });

      } else {
        this.$toasted.error('Please fill out all required fields.');
      }

    },
  }
}