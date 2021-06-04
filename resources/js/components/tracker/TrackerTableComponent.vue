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
          <th @click="_trackerSortColumn('first_name')" class="clickable">Child</th>
          <th @click="_trackerSortColumn('category_name')" class="clickable">Category</th>
          <th @click="_trackerSortColumn('value')" class="clickable">Value</th>
          <th @click="_trackerSortColumn('notes')" class="clickable">Notes</th>
          <th @click="_trackerSortColumn('entry_datetime')" class="clickable">Date</th>
          <th style="width: 20px">Actions</th>
        </tr>
      </thead>
      <tbody>
        <template v-if="trackerEntries.length > 0">
          <tr v-for="entry in trackerEntries" :key="'entry' + entry.id">
            <td>{{entry.child.first_name}} {{entry.child.last_name}}</td>
            <td>{{entry.category.name}}</td>
            <td>
              <template v-if="entry.category.prefix">{{entry.category.prefix}}</template>{{entry.value}}
              <template v-if="entry.category.suffix">{{entry.category.suffix}}</template>
            </td>
            <td>{{entry.notes}}</td>
            <td>{{entry.entry_datetime}}</td>
            <td style="width: 20px" class="text-center">
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" 
                type="button" id="dropdownMenuButton" data-toggle="dropdown" 
                aria-haspopup="true" aria-expanded="false"
                style="padding: 0px 15px;">
                  
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">View</a>
                  <a class="dropdown-item" href="#">Edit</a>
                  <a @click="deleteTrackerEntry(entry.id)" class="dropdown-item" href="#">Delete</a>
                </div>
              </div>
            </td>
          </tr>
        </template>
        <template v-else>
          <tr>
            <td class="text-center" colspan="99">There are currently no entries. Click the New Entry button above to begin.</td>
          </tr>
        </template>
      </tbody>
    </table>
    <button @click="getTrackerEntries()">Refresh Entries</button>
  </div>
</template>

<script>
import trackerMixin from '../../mixins/tracker';

export default {
  data() {
    return {
      trackerEntriesPaginationDetails: null,
      trackerEntries: [],
      trackerFilters: {
        sort: 'entry_datetime',
        dir: 'asc'
      }
    }
  },

  mixins: [
    trackerMixin
  ],

  methods: {

  },

  mounted() {
    console.log('TrackerTableComponent mounted.');
    this.getTrackerEntries();
  }
}
</script>

<style>

</style>