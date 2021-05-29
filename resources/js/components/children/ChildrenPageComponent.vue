<template>
  <div id="children-page-container">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <h1>Children</h1>
      </div>
      <div class="col-lg-6 offset-lg-3">
        <child-add-form-component ref="childAddFormComponent"></child-add-form-component>
      </div>
    </div>
    <child-cards-component v-on:eventAddChild="eventAddChild"></child-cards-component>
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
    }
  }
}
</script>

<style>

</style>