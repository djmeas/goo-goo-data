<template>
  <div id="caretaker-invites-page">
    <page-header-text text="Invitations"/>
    
    <template v-if="myInvites.length > 0">
      <div class="row">
        <div v-for="invite in myInvites" class="col-lg-4 col-md-6 mb-5">
          <div class="card-horizontal" style="height: 80px">
            <div class="left-box">
              <img :src="$avatarOrDefault(invite.child.image_path)" 
              :id="'child-img-' + invite.id"
              class="child-img rounded-circle p-1"
              width="64px"
              alt="child's image" >
            </div>
            <div class="right-box">
              <h1 class="mb-2">{{invite.child.first_name}} {{invite.child.last_name}}</h1>
              <div class="d-flex">
                <button class="btn btn-tiny btn-default mr-1">Dismiss</button>
                <button class="btn btn-tiny btn-primary" @click="acceptInvite(invite.id, 'accept')">Accept</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>

    <div v-else>
      <div class="alert alert-warning">You do not have any caretaker invitations at this time.</div>
    </div>
  </div>
</template>

<script>
import caretakersMixin from '../../mixins/caretakers';

export default {
  data() {
    return {

    }
  },

  mixins: [
    caretakersMixin
  ],

  watch: {
    myInvites: function() {
      if (this.myInvites.length > 0) {
        this.$nextTick(() => {
          this.myInvites.forEach(invite => {
            Vue.prototype.$keepElSquare('child-img-' + invite.id);
          });
        });
      }
    }
  },

  mounted() {
    this.getMyInvites();
  }
}
</script>

<style lang="scss" scoped>
  .child-img {
    object-fit: cover;
    // width: 68%;
    // height: 88%;
  }
</style>