<template>
  <div id="tracker-page-container" class="container">
    <h1 class="mb-5">Tracker Entries</h1>
    <div class="row">
      <div class="col-lg-12">
        <tracker-add-data-form-component
        ref="trackerAddDataFormComponent"
        v-on:eventSaveTrackerEntry="eventSaveTrackerEntry" />
        <tracker-table-component
        ref="trackerTableComponent"
        v-on:eventDeleteTrackerEntry="eventDeleteTrackerEntry" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {

    }
  },

  methods: {
    eventSaveTrackerEntry() {
      this.$refs.trackerAddDataFormComponent._resetFormTracker();
      this.$refs.trackerTableComponent.getTrackerEntries();
    },

    eventDeleteTrackerEntry() {
      this.$refs.trackerTableComponent.getTrackerEntries();
    }
  },

  mounted() {

  }
}
</script>

<style>

</style>