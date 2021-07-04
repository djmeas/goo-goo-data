<template>
  <div id="tracker-page-container" class="container">
    <page-header-text text="Tracker Entries"/>
    <div class="row">
      <div class="col-lg-12">
        <transition name="fade">
          <tracker-add-data-form-component
          ref="trackerAddDataFormComponent"
          v-if="trackerInitLoadComplete && children.length > 0"
          v-on:eventSaveTrackerEntry="eventSaveTrackerEntry" />
        </transition>
        <tracker-table-component
        ref="trackerTableComponent"
        v-on:eventDeleteTrackerEntry="eventDeleteTrackerEntry"
        v-on:trackerInitLoadComplete="trackerInitLoadComplete = true;" />
      </div>
    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children';

export default {
  data() {
    return {
      trackerInitLoadComplete: false,
    }
  },

  mixins: [childrenMixin],

  methods: {
    /**
     * Listens for the save tracker entry event and reloads the entries.
     */
    eventSaveTrackerEntry() {
      this.$refs.trackerAddDataFormComponent._resetFormTracker();
      this.$refs.trackerTableComponent.getTrackerEntries();
    },

    /**
     * Listens for the delete tracker entry event and reloads the remaining entries.
     */
    eventDeleteTrackerEntry() {
      this.$refs.trackerTableComponent.getTrackerEntries();
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