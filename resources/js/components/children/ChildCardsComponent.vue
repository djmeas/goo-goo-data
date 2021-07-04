<template>
  <div v-if="childrenInitLoad" id="child-cards" class="row">
    <template v-if="children">
      <div v-for="child in children" :key="child.first_name + '-' + child.id" class="col-lg-3 col-md-4 mb-5">
        <a :href="`/children/${child.hash}`">
          <div class="child-img position-relative">
            <img :id="'child-img-' + child.hash" class="child-hero-img object-fit-cover rounded-circle mb-4 animate__bounceIn" :src="$avatarOrDefault(child.image_path)" alt="" width="100%">
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

    <div class="col-lg-3 col-md-4 mb-5">
        <div class="child-img position-relative text-center clickable" @click="eventAddChild">
          <img class="child-hero-img rounded-circle mb-4 animate__bounceIn" src="/img/base_add.png" alt="" width="100%">
          <button @click="eventAddChild" class="btn btn-primary">Add Child</button>
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
      var scroll = new SmoothScroll();
      var anchor = document.querySelector('#form-add-child');
      scroll.animateScroll(anchor, {
        speed: 500,
	      speedAsDuration: true
      });
    }
  },

  watch: {
      /**
       * Watches for when the children data initially loads and attempts to keep their images square.
       */
      childrenInitLoad: function() {
        this.$nextTick(() => {
          if (this.children.length > 0) {
            this.children.forEach(child => {
              Vue.prototype.$keepElSquare('child-img-' + child.hash);
            })
          }
        })
      }
  },

  /**
   * On component mount.
   */
  mounted() {
    this.getChildren();
  }
  
}
</script>

<style>

</style>