<template>
  <div id="children-page-container">
    <div class="row">
      <div class="col-lg-12 mb-2">
        <page-header-text text="Children"/>
      </div>
      <div class="col-lg-8 offset-lg-2">
        <child-add-form-component 
          class="mb-4"
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
    <!-- <button @click="refreshChildren">Refresh Test</button> -->
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

    /**
     * Listens for cancelings the add child form.
     */
    eventCancelAddChild() {
      console.log('eventCancelAddChild');
      this.$refs.childAddFormComponent.isAdding = false;
    },

    /**
     * Listens for the save child event.
     */
    eventSaveChild() {
      this.refreshChildren();
    },

    /**
     * Fetches the children data again from the API.
     */
    refreshChildren() {
      this.$refs.childCardsComponent.getChildren();
    }
  },
}
</script>

<style>

</style>