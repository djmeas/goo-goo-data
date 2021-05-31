<template>
  <div id="child-cards" class="row">
    <template v-if="children">
      <div v-for="child in children" :key="child.first_name + '-' + child.id" class="col-lg-3 col-md-6">
        <div class="child-card">
          <div class="photo text-center">
            <img :src="`${$baseAvatarPath}/${child.image_path}`" alt="" />
          </div>
          <div class="name text-center pt-4">
            {{child.first_name}} {{child.last_name}}
            <br>
            <button @click="deleteChild(child.hash)">Delete</button>
          </div>
        </div>
      </div>
    </template>

    <div class="col-lg-3 col-md-6">
      <div class="child-card">
        <div class="photo text-center">
          [Add CIRCLE]
        </div>
        <div class="name text-center pt-4">
          <button @click="eventAddChild" class="btn btn-primary">Add Child</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      children: []
    }
  },

  methods: {
    /**
     * Fetches the children data from the API.
     */
    getChildren() {
      console.log('getChildren() called');
      axios.get(`${Vue.prototype.$baseAPI}/child`)
        .then(res => {
            console.log(res.data);
            this.children = res.data;
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

    eventAddChild() {
      this.$emit('eventAddChild');
    }
  },

  mounted() {
    console.log('ChildCardsComponent mounted.');
    this.getChildren();
  }
  
}
</script>

<style>

</style>