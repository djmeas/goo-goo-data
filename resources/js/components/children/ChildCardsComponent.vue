<template>
  <div v-if="childrenInitLoad" id="child-cards" class="row">
    <template v-if="children">
      <div v-for="child in children" :key="child.first_name + '-' + child.id" class="col-lg-3 col-md-4 mb-5">
        <a :href="`/children/${child.hash}`">
          <div class="child-img position-relative">
            <img class="child-hero-img rounded-circle mb-4 animate__bounceIn" :src="`${$baseAvatarPath}/${child.image_path}`" alt="" width="100%">
            <transition name="fade">
              <div v-if="child.caretaker.length > 0 && child.caretaker[0].is_parent" class="parent-icon">
                <span class="material-icons" style="font-size:32px">
                  escalator_warning
                </span>
              </div>
            </transition>
          </div>
        </a>
        <h3 class="text-center">{{child.first_name}} {{child.last_name}}</h3>
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