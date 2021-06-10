<template>
  <div v-if="childrenInitLoad" id="child-cards" class="row">
    <template v-if="children">
      <div v-for="child in children" :key="child.first_name + '-' + child.id" class="col-lg-3 col-md-6">
        <div :id="`child-card-${child.id}`" class="child-card">
          <div class="photo text-center">
            <img v-if="child.image_path" :src="`${$baseAvatarPath}/${child.image_path}`" alt="Child's avatar" />
            <span v-else class="material-icons" style="font-size: 200px;">child_care</span>
          </div>
          <div class="name text-center pt-4">
            <a :href="`/children/${child.hash}`">
              {{child.first_name}} {{child.last_name}}
            </a>
            <!-- <br>
            <span @click="deleteChild(child.hash)">Delete</span> -->
          </div>
        </div>
      </div>
    </template>

    <div class="col-lg-3 col-md-6">
      <div class="child-card">
        <div class="photo text-center">
          <span class="material-icons" style="font-size: 200px;">
            person_add_alt_1
          </span>
        </div>
        <div class="name text-center pt-4">
          <button @click="eventAddChild" class="btn btn-primary">Add Child</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children.js';

export default {
  data() {
    return {

    }
  },

  mixins: [childrenMixin],

  methods: {
    /**
     * Emits the add child event to the parent component.
     */
    eventAddChild() {
      this.$emit('eventAddChild');
      window.scrollTo(0, 0);
    }
  },

  /**
   * Runs when mounted.
   */
  mounted() {
    console.log('ChildCardsComponent mounted.');
    this.getChildren();
  }
  
}
</script>

<style>

</style>