export default {
  data () {
     return {
      myInvites: [],
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

    getMyInvites() {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/my-invites`)
        .then(res => {
          this.myInvites = res.data;
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
            this.$emit('emitSaveInvite');
            this.$toasted.success('The caretaker has been invited.');
          })
          .catch(err => {
            this.$toasted.error(err.response.data);
          });
      } else {
        this.$toasted.error('Please fill out all required fields.');
      }
    },

    deleteInvite(invite) {
      this.$confirm(
        {
          message: `
              Are you sure you want to delete the caretaker invitation to
              ${invite.email} (${invite.role})?
            `,
          button: {
            no: 'Cancel',
            yes: 'Yes'
          },
          callback: confirm => {
            if (confirm) {
              axios.delete(`${Vue.prototype.$baseAPI}/caretaker/invite/${invite.id}`)
                .then(res => {
                  this.$emit('emitDeleteInvite');
                  this.$toasted.success('The invitation has been deleted.');
                  // this.getPendingInvites(this.childhash);
                  this.pendingInvites = this.pendingInvites.filter(pendingInvite => {
                    return pendingInvite.id !== invite.id;
                  });
                })
                .catch(err => {
                  this.$toasted.error(err.response.data);
                });
            }
          }
        }
      );
    },

    acceptInvite(inviteId, option) {
      let postData = {
        id: inviteId,
        option: option
      };

      axios.post(`${Vue.prototype.$baseAPI}/caretaker/my-invites/${inviteId}`, postData)
        .then(res => {
          this.$emit('emitAcceptInvite');
          this.$toasted.success('The invitation has been accepted.');
          this.myInvites = this.myInvites.filter(myInvite => {
            return myInvite.id !== inviteId;
          });
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    }
  },

}