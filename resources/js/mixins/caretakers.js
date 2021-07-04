import Vue from "vue";

export default {
  data () {
     return {
      myInvites: [],
      pendingInvites: [],
      caretakers: [],
     }
  },

  methods: {
    /**
     * Gets all the caretakers for a particular child.
     * 
     * @param {String} childHash 
     */
    getCaretakers(childHash) {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/${childHash}`)
        .then(res => {
          this.caretakers = res.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Deletes a caretaker from a particular child.
     * 
     * @param {String} childHash 
     * @param {Object} user 
     */
    removeCaretaker(childHash, user) {

      this.$confirm(
        {
          message: `
              Are you sure you want to remove the caretaker 
              ${user.first_name} ${user.last_name} (${user.email})?
            `,
          button: {
            no: 'Cancel',
            yes: 'Yes'
          },
          callback: confirm => {
            if (confirm) {
              axios.delete(`${Vue.prototype.$baseAPI}/caretaker/${childHash}/${user.id}`)
                .then(res => {
                  this.caretakers = this.caretakers.filter(caretaker => {
                    return user.id !== caretaker.id;
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

    /**
     * Gets the current user's invitations.
     */
    getMyInvites() {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/my-invites`)
        .then(res => {
          this.myInvites = res.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Gets the current user's pending invitations based on a particular child.
     * 
     * @param {String} childHash 
     */
    getPendingInvites(childHash) {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/pending-invites/${childHash}`)
        .then(res => {
          this.pendingInvites = res.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Saves a caretaker invitation.
     */
    saveInvite() {
      this.$v.formCaretaker.$touch();

      if (!this.$v.formCaretaker.$invalid) {
        if (this.formCaretaker.id) {
          axios.post(`${Vue.prototype.$baseAPI}/caretaker`, this.formCaretaker)
          .then(res => {
            this.$emit('emitUpdateCaretaker');
            this.$toasted.success('The caretaker has been updated.');
          })
          .catch(err => {
            this.$toasted.error(err.response.data);
          });
        } else {
          axios.post(`${Vue.prototype.$baseAPI}/caretaker/invite`, this.formCaretaker)
          .then(res => {
            this.$emit('emitSaveInvite');
            this.$toasted.success('The caretaker has been invited.');
          })
          .catch(err => {
            this.$toasted.error(err.response.data);
          });
        }
        
      } else {
        this.$toasted.error('Please fill out all required fields.');
      }
    },

    /**
     * Deletes a particular invitation.
     * 
     * @param {Object} invite 
     */
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

    /**
     * Responds to a particular invite.
     * 
     * @param {Integer} inviteId 
     * @param {String} option 
     */
    respondToInvite(inviteId, option) {
      let postData = {
        id: inviteId,
        option: option
      };

      axios.post(`${Vue.prototype.$baseAPI}/caretaker/my-invites`, postData)
        .then(res => {
          this.$emit('emitRespondToInvite');
          this.$toasted.success(`The invitation has been ${option}.`);
          this.getMyInvites();
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Unfollow a particular child.
     * 
     * @param {Object} invite 
     */
    unfollowChild(invite) {
      this.$confirm(
        {
          message: `
              Are you sure you want to unfollow 
              ${invite.child.first_name} ${invite.child.last_name}?
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
                  this.$toasted.success(`You are no longer following ${invite.child.first_name}.`);
                  this.myInvites = this.myInvites.filter(myInvite => {
                    return myInvite.id !== invite.id;
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

    /**
     * Checks if a caretaker is marked as a parent for a particular child.
     * 
     * @param {String} childHash 
     * @param {Integer} userId 
     */
    getIsParentOfChild(childHash, userId) {
      axios.get(`${Vue.prototype.$baseAPI}/caretaker/is-parent/${childHash}/${userId}`)
        .then(res => {
          this.isParentOfChild = res.data;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    },

    /**
     * Marks a caretaker as a parent of a particular child.
     * 
     * @param {Integer} childId 
     */
    markChildParent(childId) {
      let postData = {
        child_id: childId,
        user_id: Vue.prototype.$currentUser.id,
        is_parent: this.isParentOfChild === 1 ? 0 : 1
      };

      axios.post(`${Vue.prototype.$baseAPI}/caretaker/mark-parent-child`, postData)
        .then(res => {
          this.$emit('emitMarkParentChild');
          this.$toasted.success(
            postData.is_parent 
              ? 'You have been updated as a parent' 
              : 'You have been unmarked as a parent'
          );
          this.isParentOfChild = postData.is_parent;
        })
        .catch(err => {
          this.$toasted.error(err.response.data);
        });
    }
  },

}