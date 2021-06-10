export default {
  data () {
     return {
      pendingInvites: [],
      caretakers: [],
     }
  },

  methods: {
    getCaretakers(childHash) {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/${childHash}`)
        .then(res => {
          this.caretakers = res.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    getPendingInvites(childHash) {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/pending-invites/${childHash}`)
        .then(res => {
          this.pendingInvites = res.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    saveInvite() {
      this.$v.formCaretaker.$touch();

      if (!this.$v.formCaretaker.$invalid) {
        axios.post(`${Vue.prototype.$baseAPI}/caretaker/invite`, this.formCaretaker)
          .then(res => {
            this.$emit('emitSaveCaretaker');
            this.$toasted.success('The caretaker has been saved.');
          })
          .catch(err => {
            this.$toasted.error(err.response.data);
          });
      } else {
        this.$toasted.error('Please fill out all required fields.');
      }
    }
  },

}