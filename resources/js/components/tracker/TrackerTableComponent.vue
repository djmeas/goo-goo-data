<template>
  <div>
    <page-header-text v-if="childhash" text="Tracker Entries"/>

    <template v-if="trackerInitLoad && children.length > 0">
    <!-- Desktop -->
    <div class="table-responsive d-none d-sm-block">
      <transition name="fade">
        <template v-if="trackerInitLoad">
          <table id="tracker-table" class="table table-bordered">
          <thead>
            <!-- Filters -->
            <template v-if="children && categories">
              <tr v-if="showFilter">
                <td  colspan="99">
                  <div  class="card mt-3">
                    <div class="card-header">Filters</div>
                    <div class="card-body">
                      <div class="row">

      
                            <div class="col-lg-3">
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
                          <div class="col-lg-2">
                            <div class="form-group mb-3">
                              <label for="category" class="form-label">Category</label>
                              <select v-model="selectedCategory" @change="trackerFilters.category = null" class="form-control" name="child" id="child">
                                <option :value="null">All</option>
                                <option v-for="(category, index) in categories" :key="index" :value="index">
                                  {{index}}
                                </option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group mb-3">
                              <label for="category" class="form-label">Subcategory</label>
                              <select v-model="trackerFilters.category" class="form-control" name="child" id="child">
                                <option :value="null">All</option>
                                <option v-for="option in selectedCategoryOptions" :key="option.id + option.name" :value="option">
                                  {{option.name}}
                                </option>
                              </select>
                            </div>
                          </div>

                          <div class="col-lg-2">
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
                          <div class="col-lg-2">
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
                          
                        <!-- <div class="col-lg-3">
                          <div class="form-group mb-3"> 
                            <label for="birthday" class="form-label">Date Range</label>
                            <br>
                            <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="trackerFilters.entry_datetime_range" />
                          </div>
                        </div> -->
                        <div class="col-lg-2">
                          <div class="form-group mb-3"> 
                            <label for="birthday" class="form-label">Date Start</label>
                            <br>
                            <!-- <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" /> -->
                            <v-date-picker v-model="trackerFilters.entry_datetime_range.start" ref="datePickerRange" :timezone="$browserTimezone">
                              <template v-slot="{ inputValue, inputEvents }">
                                <input
                                  class="form-control"
                                  :value="inputValue"
                                  v-on="inputEvents"
                                />
                              </template>
                            </v-date-picker>
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div class="form-group mb-3"> 
                            <label for="birthday" class="form-label">Date End</label>
                            <br>
                            <!-- <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" /> -->
                            <v-date-picker v-model="trackerFilters.entry_datetime_range.end" ref="datePickerRange" :timezone="$browserTimezone">
                              <template v-slot="{ inputValue, inputEvents }">
                                <input
                                  class="form-control"
                                  :value="inputValue"
                                  v-on="inputEvents"
                                />
                              </template>
                            </v-date-picker>
                          </div>
                        </div>

                        <div class="col-lg-4">
                          <div class="text-right d-flex" style="margin-top: 31px;">
                            <button class="btn btn-default flex-1" @click="showFilter = false">
                              <span class="material-icons">visibility_off</span> Hide
                            </button>
                            <button class="btn btn-default flex-1 ml-2 mr-2" @click="_resetFormFilters(); hasFilters = false;">
                              <span class="material-icons">restart_alt</span> Reset
                            </button>
                            <button class="btn btn-primary flex-1" @click="getTrackerEntries(); hasFilters = true;">
                              <span class="material-icons">search</span> Search
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
            </template>

            <tr v-if="trackerEntries.length > 0" class="pagination-row">
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
                <button v-if="!childhash" class="btn btn-primary btn-tiny float-right" @click="showFilter = true">
                  <span class="material-icons">visibility</span> Show Filters
                </button>
              </td>
            </tr>
            <tr v-if="trackerEntries.length > 0">
              <th v-if="!childhash" @click="_trackerSortColumn('first_name')" class="clickable">Child</th>
              <th @click="_trackerSortColumn('category_group')" class="clickable">Category</th>
              <th @click="_trackerSortColumn('category_name')" class="clickable">Subcategory</th>
              <th @click="_trackerSortColumn('value')" class="clickable">Amount</th>
              <th @click="_trackerSortColumn('notes')" class="clickable">Notes</th>
              <th @click="_trackerSortColumn('entry_datetime')" class="clickable">Date</th>
              <th v-if="!childhash" style="width: 20px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="trackerEntries.length > 0">
              <tr :id="'entry-tr-' + entry.id" v-for="entry in trackerEntries" :key="'entry' + entry.id">
                <template v-if="editEntryId !== entry.id">
                  <td v-if="!childhash" class="white-space-nw">
                    <a :href="`/children/${entry.child.hash}`">
                      <img class="rounded-circle object-fit-cover mr-2" 
                      :src="$avatarOrDefault(entry.child.image_path)" 
                      :alt="'Avatar: ' + entry.child.first_name" 
                      width="30px" height="30px">{{entry.child.first_name}}
                    </a>
                  </td>
                  <td>{{entry.category.group}}</td>
                  <td>{{entry.category.name}}</td>
                  <td>
                    <!-- <template v-if="entry.category.prefix">{{entry.category.prefix}}</template>{{entry.value}}
                    <template v-if="entry.category.suffix">{{entry.category.suffix}}</template> -->
                    <span v-if="entry.entry_amount" v-tooltip="entry.entry_amount.alternate">{{entry.entry_amount.value_formatted}}</span>
                  </td>
                  <td v-html="entry.notes"></td>
                  <td class="white-space-nw">
                    {{entry.entry_datetime | dateFormatMDY}} {{entry.entry_datetime | dateFormatTime}}
                  </td>
                  <td v-if="!childhash" style="width: 20px" class="text-center">
                    <div v-if="childEntryAccess.includes(entry.child.hash)" class="dropdown">
                      <button class="btn btn-default dropdown-toggle" 
                      type="button" id="dropdownMenuButton" data-toggle="dropdown" 
                      aria-haspopup="true" aria-expanded="false"
                      style="padding: 0px 15px;">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a @click="editEntryId = entry.id;editEntry();" class="dropdown-item" href="#">Edit</a>
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
              <!-- <tr class="pagination-row">
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
              </tr> -->
            </template>
            <template v-else>
              <tr>
                <td class="text-center" colspan="99">
                  <template v-if="hasFilters">
                    There are no entries based on your filters.
                  </template>
                  <template v-else>
                    There are currently no entries. 
                    <template v-if="!childhash">
                    Click the New Entry button above to begin.
                    </template>
                  </template>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
        </template>
      </transition>
      <template v-if="!trackerInitLoad && trackerEntries.length === 0">
        <loader/>
      </template>

      <!-- <button @click="getTrackerEntries()">Refresh Entries</button> -->
      <!-- <button @click="_debugSaveEntry()">Force Entry</button> -->
      </div>

      <!-- Mobile -->
      <div class="d-block d-sm-none">
        <!-- Filters -->
        <card-with-toggle v-if="!childhash" cardHeader="Filters" class="mt-3">
          <div class="row">
                  <div class="col-lg-3">
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
                <div class="col-lg-2">
                  <div class="form-group mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select v-model="selectedCategory" @change="trackerFilters.category = null" class="form-control" name="child" id="child">
                      <option :value="null">All</option>
                      <option v-for="(category, index) in categories" :key="index" :value="index">
                        {{index}}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group mb-3">
                    <label for="category" class="form-label">Subcategory</label>
                    <select v-model="trackerFilters.category" class="form-control" name="child" id="child">
                      <option :value="null">All</option>
                      <option v-for="option in selectedCategoryOptions" :key="option.id + option.name" :value="option">
                        {{option.name}}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-2">
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
                <div class="col-lg-2">
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
                
              <!-- <div class="col-lg-3">
                <div class="form-group mb-3"> 
                  <label for="birthday" class="form-label">Date Range</label>
                  <br>
                  <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="trackerFilters.entry_datetime_range" />
                </div>
              </div> -->
              <div class="col-lg-2">
                <div class="form-group mb-3"> 
                  <label for="birthday" class="form-label">Date Start</label>
                  <br>
                  <!-- <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" /> -->
                  <v-date-picker v-model="trackerFilters.entry_datetime_range.start" ref="datePickerRange" :timezone="$browserTimezone">
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="form-control"
                        :value="inputValue"
                        v-on="inputEvents"
                      />
                    </template>
                  </v-date-picker>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group mb-3"> 
                  <label for="birthday" class="form-label">Date End</label>
                  <br>
                  <!-- <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" /> -->
                  <v-date-picker v-model="trackerFilters.entry_datetime_range.end" ref="datePickerRange" :timezone="$browserTimezone">
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="form-control"
                        :value="inputValue"
                        v-on="inputEvents"
                      />
                    </template>
                  </v-date-picker>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="text-right d-flex" style="margin-top: 31px;">

                  <button class="btn btn-default flex-1 mr-1" @click="_resetFormFilters(); hasFilters = false;">
                    <span class="material-icons">restart_alt</span> Reset
                  </button>
                  <button class="btn btn-primary flex-1 ml-1" @click="getTrackerEntries(); hasFilters = true;">
                    <span class="material-icons">search</span> Search
                  </button>
                </div>
              </div>
            </div>
        </card-with-toggle>
            

        <div v-if="trackerEntriesPaginationDetails" class="d-flex mt-4 mb-3">
          <button class="btn btn-default btn-tiny flex-1" 
          :disabled="trackerEntriesPaginationDetails.current_page === 1"
          @click="getTrackerEntries(trackerEntriesPaginationDetails.prev_page_url)">
            <span class="material-icons">
              arrow_back
            </span>
          </button>
          
          <div class="flex-3 text-center">
          {{trackerEntriesPaginationDetails.from}} - 
          {{trackerEntriesPaginationDetails.to}} of 
          {{trackerEntriesPaginationDetails.total}} entries
          </div>

          <button class="btn btn-default btn-tiny flex-1"
          :disabled="trackerEntriesPaginationDetails.current_page === trackerEntriesPaginationDetails.last_page"
          @click="getTrackerEntries(trackerEntriesPaginationDetails.next_page_url)">
            <span class="material-icons">
              arrow_forward
            </span>
          </button>
        </div>

        <div v-for="entry in trackerEntries">
          <tracker-mobile-entry-card :entry="entry"
          :allowEditing="!childhash"
          v-on:eventSaveTrackerEntry="getTrackerEntries()"
          v-on:eventDeleteTrackerEntry="getTrackerEntries()"/>
        </div>

        <div v-if="trackerEntriesPaginationDetails" class="d-flex mt-4 mb-3">
          <button class="btn btn-default btn-tiny flex-1" 
          :disabled="trackerEntriesPaginationDetails.current_page === 1"
          @click="getTrackerEntries(trackerEntriesPaginationDetails.prev_page_url)">
            <span class="material-icons">
              arrow_back
            </span>
          </button>
          
          <div class="flex-3 text-center">
          {{trackerEntriesPaginationDetails.from}} - 
          {{trackerEntriesPaginationDetails.to}} of 
          {{trackerEntriesPaginationDetails.total}} entries
          </div>

          <button class="btn btn-default btn-tiny flex-1"
          :disabled="trackerEntriesPaginationDetails.current_page === trackerEntriesPaginationDetails.last_page"
          @click="getTrackerEntries(trackerEntriesPaginationDetails.next_page_url)">
            <span class="material-icons">
              arrow_forward
            </span>
          </button>
        </div>

        <div v-if="hasFilters && trackerEntries.length === 0">
          <tr>
            <td class="text-center" colspan="99">
              <template v-if="hasFilters">
                There are no entries based on your filters.
              </template>
              <template v-else>
                There are currently no entries. 
                <template v-if="!childhash">
                  Click the New Entry button above to begin.
                </template>
              </template>
            </td>
          </tr>
        </div>
      </div>
    </template>

    <!-- No Children -->
    <template v-else>
      <div v-if="trackerInitLoad && !childhash" class="alert alert-warning">
        Before adding Tracker Entries, please visit the <a href="/children">Children</a> page and add a child.
      </div>
    </template>
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

      showFilter: false,
      hasFilters: false,
      trackerFilters: {
        sort: 'entry_datetime',
        dir: 'desc',
        child_id: null,
        hash: null,
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

  props: {
    childhash: {
      type: String,
      required: false,
      default: null
    }
  },

  mixins: [
    trackerMixin,
    childrenMixin,
    categoriesMixin
  ],

  methods: {
    /**
     * Resets the trackerFilters data.
     * Note that we do not reset the hash when a 
     * user is viewing a particular child's profile page.
     */
    _resetFormFilters() {
      this.trackerFilters.sort = 'entry_datetime';
      this.trackerFilters.dir = 'desc';
      this.trackerFilters.child_id = null;
      this.selectedCategory = null;
      this.trackerFilters.category = null;
      this.trackerFilters.category_id = null;
      this.trackerFilters.value_min = null;
      this.trackerFilters.value_max = null;
      this.trackerFilters.entry_datetime_range.start = null;
      this.trackerFilters.entry_datetime_range.end = null;
      this.trackerFilters.notes = null;

      this.getTrackerEntries();
    },

    editEntry() {
      this.isEditing = true;
      this.$nextTick(() => {
        var scroll = new SmoothScroll();
        var anchor = document.querySelector('#tracker-entry-form-' + this.editEntryId);
        console.log(anchor);
          scroll.animateScroll(anchor);
      })
      
    }
  },

  mounted() {
    console.log('TrackerTableComponent mounted.');

    if (this.childhash) {
      this.trackerFilters.hash = this.childhash;
    }

    this.getTrackerEntries();
    this.getChildren();
    this.getCategories();
  }
}
</script>

