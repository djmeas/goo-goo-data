<template>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <td colspan="99">
            <template v-if="trackerEntriesPaginationDetails">
              <button class="btn btn-secondary" 
              :disabled="trackerEntriesPaginationDetails.current_page === 1"
              @click="getTrackerEntries(trackerEntriesPaginationDetails.prev_page_url)">
                Prev
              </button>
              <button class="btn btn-secondary"
              :disabled="trackerEntriesPaginationDetails.current_page === trackerEntriesPaginationDetails.last_page"
              @click="getTrackerEntries(trackerEntriesPaginationDetails.next_page_url)">
                Next
              </button>
            </template>
          </td>
        </tr>
        <tr>
          <th @click="_trackerSortColumn('first_name')">Child</th>
          <th @click="_trackerSortColumn('category_name')">Category</th>
          <th @click="_trackerSortColumn('value')">Value</th>
          <th @click="_trackerSortColumn('notes')">Notes</th>
          <th @click="_trackerSortColumn('entry_datetime')">Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="entry in trackerEntries" :key="'entry' + entry.id">
          <td>{{entry.child.first_name}} {{entry.child.last_name}}</td>
          <td>{{entry.category.name}}</td>
          <td>
            <template v-if="entry.category.prefix">{{entry.category.prefix}}</template>{{entry.value}}
            <template v-if="entry.category.suffix">{{entry.category.suffix}}</template>
          </td>
          <td>{{entry.notes}}</td>
          <td>{{entry.entry_datetime}}</td>
          <td>[Actions]</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import trackerMixin from '../../mixins/tracker';

export default {
  data() {
    return {

    }
  },

  mixins: [
    trackerMixin
  ],

  methods: {

  },

  mounted() {
    this.getTrackerEntries();
  }
}
</script>

<style>

</style>