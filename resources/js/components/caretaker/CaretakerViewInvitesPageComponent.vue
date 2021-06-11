<template>
  <div id="caretaker-invites-page">
    <page-header-text text="Caretaker Invitations"/>
    
    <div v-for="invite in myInvites" class="col-lg-4 mb-5">
      <div class="card-horizontal" style="height: 80px">
        <div class="left-box">
          <img :src="`${$baseAvatarPath}/${invite.child.image_path}`" 
          class="rounded-circle p-1"
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

  mounted() {
    this.getMyInvites();
  }
}
</script>

<style>

</style>