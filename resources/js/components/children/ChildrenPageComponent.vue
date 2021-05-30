<template>
  <div id="children-page-container">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <h1>Children</h1>
      </div>
      <div class="col-lg-8 offset-lg-2">
        <child-add-form-component 
          ref="childAddFormComponent"
          v-on:eventSaveChild="eventSaveChild()"
          v-on:eventCancelAddChild="eventCancelAddChild()">
        </child-add-form-component>
      </div>
    </div>
    <child-cards-component 
      ref="childCardsComponent"
      v-on:eventAddChild="eventAddChild()"
      v-on:eventDeleteChild="eventDeleteChild()">
    </child-cards-component>
    <button @click="refreshChildren">Refresh Test</button>
  </div>
</template>

<script>
export default {
  methods: {
    /**
     * Listens for eventAddChild to display the add child form.
     */
    eventAddChild() {
      this.$refs.childAddFormComponent.isAdding = true;
    },

    eventCancelAddChild() {
      console.log('eventCancelAddChild');
      this.$refs.childAddFormComponent.isAdding = false;
    },

    eventSaveChild() {
      this.refreshChildren();
    },

    eventDeleteChild() {

    },

    refreshChildren() {
      console.log('refreshChildren');
      this.$refs.childCardsComponent.getChildren();
    }
  },
}
</script>

<style>

</style>