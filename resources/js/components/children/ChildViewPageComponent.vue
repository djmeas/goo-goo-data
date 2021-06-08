<template>
  <div id="child-view-page-container">
    <div v-if="child" class="row">
      <div class="col-lg-3 mb-4">
        <div class="text-center">
          <img class="rounded-circle mb-4" :src="`${$baseAvatarPath}/${child.image_path}`" alt="" width="100%">
          <h1>{{child.first_name}} {{child.last_name}}</h1>
        </div>
      </div>
      <div class="col-lg-9">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>Birthday</td>
              <td>{{child.birthday}}</td>
            </tr>
          </thead>
        </table>
      </div>
      <tracker-table-component :childhash="childhash"/>
    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children';

export default {
  props: {
    childhash: {
      type: String,
      required: false,
      default: null
    }
  },

  mixins: [
    childrenMixin,
  ],

  methods: {

  },

  mounted() {
    this.getChildren(this.childhash);
  }
}
</script>

<style>

</style>