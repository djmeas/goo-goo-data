<template>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr class="pagination-row">
          <td colspan="99">
            <template v-if="trackerEntriesPaginationDetails">
              <button class="btn btn-default btn-tiny" 
              :disabled="trackerEntriesPaginationDetails.current_page === 1"
              @click="getTrackerEntries(trackerEntriesPaginationDetails.prev_page_url)">
                <span class="material-icons">
                  arrow_back
                </span>
              </button>
              <button class="btn btn-default btn-tiny mr-3"
              :disabled="trackerEntriesPaginationDetails.current_page === trackerEntriesPaginationDetails.last_page"
              @click="getTrackerEntries(trackerEntriesPaginationDetails.next_page_url)">
                <span class="material-icons">
                  arrow_forward
                </span>
              </button>
              {{trackerEntriesPaginationDetails.from}} - 
              {{trackerEntriesPaginationDetails.to}} of 
              {{trackerEntriesPaginationDetails.total}} entries
            </template>
            <template v-if="children && categories">
              <div class="card mt-3">
                <div class="card-header">Filters</div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-lg-8">
                      <div class="row">
                        <div class="col-lg-4">
                        <div class="form-group mb-3">
                          <label for="child" class="form-label">Child</label>
                          <select v-model="trackerFilters.child_id" class="form-control" name="child" id="child">
                            <option :value="null">Select...</option>
                            <option v-for="child in children" :value="child.id" :key="`${child.id}-${child.first_name}`">
                              {{child.first_name}} {{child.last_name}}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group mb-3">
                          <label for="category" class="form-label">Category</label>
                          <select v-model="selectedCategory" @change="trackerFilters.category = null" class="form-control" name="child" id="child">
                            <option :value="null">Select...</option>
                            <option v-for="(category, index) in categories" :key="index" :value="index">
                              {{index}}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group mb-3">
                          <label for="category" class="form-label">Option</label>
                          <select v-model="trackerFilters.category" class="form-control" name="child" id="child">
                            <option :value="null">Select...</option>
                            <option v-for="option in selectedCategoryOptions" :key="option.id + option.name" :value="option">
                              {{option.name}}
                            </option>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <label for="inlineFormInputGroup">Amount Min</label>
                        <div class="input-group mb-2">
                          <div v-if="trackerFilters.category && trackerFilters.category.prefix" class="input-group-prepend">
                            <div class="input-group-text">{{trackerFilters.category.prefix}}</div>
                          </div>
                          
                          <input v-model="trackerFilters.value_min" type="number" class="form-control" id="inlineFormInputGroup">

                          <div v-if="trackerFilters.category && trackerFilters.category.suffix" class="input-group-append">
                            <div class="input-group-text">{{trackerFilters.category.suffix}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <label for="inlineFormInputGroup">Amount Max</label>
                        <div class="input-group mb-2">
                          <div v-if="trackerFilters.category && trackerFilters.category.prefix" class="input-group-prepend">
                            <div class="input-group-text">{{trackerFilters.category.prefix}}</div>
                          </div>
                          
                          <input v-model="trackerFilters.value_max" type="number" class="form-control" id="inlineFormInputGroup">

                          <div v-if="trackerFilters.category && trackerFilters.category.suffix" class="input-group-append">
                            <div class="input-group-text">{{trackerFilters.category.suffix}}</div>
                          </div>
                        </div>
                      </div>

                      

                      <div class="col-lg-4">
                        <div class="form-group mb-3"> 
                          <label for="birthday" class="form-label">Notes</label>
                          <input v-model="trackerFilters.notes" type="text" class="form-control">
                        </div>
                      </div>
                      </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3"> 
                          <label for="birthday" class="form-label">Date Range</label>
                          <br>
                          <!-- <input v-model="formChild.birthday" type="text" class="form-control" id="birthday"> -->
                          <v-date-picker :timezone="$browserTimezone" is-range v-model="trackerFilters.entry_datetime_range" />
                        </div>
                      </div>
                  </div>
                </div>
              </div>
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
            <template v-if="editEntryId !== entry.id">
              <td>{{entry.child.first_name}} {{entry.child.last_name}}</td>
              <td>{{entry.category.name}}</td>
              <td>
                <template v-if="entry.category.prefix">{{entry.category.prefix}}</template>{{entry.value}}
                <template v-if="entry.category.suffix">{{entry.category.suffix}}</template>
              </td>
              <td v-html="entry.notes"></td>
              <td>{{entry.entry_datetime | dateFormat}}</td>
              <td style="width: 20px" class="text-center">
                <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" 
                  type="button" id="dropdownMenuButton" data-toggle="dropdown" 
                  aria-haspopup="true" aria-expanded="false"
                  style="padding: 0px 15px;">
                    
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">View</a>
                    <a @click="isEditing = true; editEntryId = entry.id" class="dropdown-item" href="#">Edit</a>
                    <a @click="deleteTrackerEntry(entry.id)" class="dropdown-item" href="#">Delete</a>
                  </div>
                </div>
              </td>
            </template>
            <template v-if="editEntryId === entry.id">
              <td colspan="99">
                <tracker-add-data-form-component 
                :existingEntry="entry"
                v-on:eventSaveTrackerEntry="getTrackerEntries();editEntryId = null"
                v-on:cancelTrackerEntry="editEntryId = null"/>
              </td>
            </template>
          </tr>
          <tr class="pagination-row">
            <td colspan="99">
              <template v-if="trackerEntriesPaginationDetails">
                <button class="btn btn-default btn-tiny" 
                :disabled="trackerEntriesPaginationDetails.current_page === 1"
                @click="getTrackerEntries(trackerEntriesPaginationDetails.prev_page_url)">
                  <span class="material-icons">
                    arrow_back
                  </span>
                </button>
                <button class="btn btn-default btn-tiny mr-3"
                :disabled="trackerEntriesPaginationDetails.current_page === trackerEntriesPaginationDetails.last_page"
                @click="getTrackerEntries(trackerEntriesPaginationDetails.next_page_url)">
                  <span class="material-icons">
                    arrow_forward
                  </span>
                </button>
                {{trackerEntriesPaginationDetails.from}} - 
                {{trackerEntriesPaginationDetails.to}} of 
                {{trackerEntriesPaginationDetails.total}} entries
              </template>
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
    <!-- <button @click="getTrackerEntries()">Refresh Entries</button> -->
    <button @click="_debugSaveEntry()">Force Entry</button>
  </div>
</template>

<script>
import categoriesMixin from '../../mixins/categories';
import childrenMixin from '../../mixins/children';
import trackerMixin from '../../mixins/tracker';

export default {
  data() {
    return {
      isEditing: false,
      editEntryId: null,

      trackerEntriesPaginationDetails: null,
      trackerEntries: [],
      trackerFilters: {
        sort: 'entry_datetime',
        dir: 'asc',
        child_id: null,
        category: null,
        category_id: null,
        value_min: null,
        value_max: null,
        entry_datetime_range: {
          start: null,
          end: null
        },
        notes: null
      },
    }
  },

  mixins: [
    trackerMixin,
    childrenMixin,
    categoriesMixin
  ],

  methods: {

  },

  mounted() {
    console.log('TrackerTableComponent mounted.');
    this.getTrackerEntries();
    this.getChildren();
    this.getCategories();
  }
}
</script>

<style>

</style>