<template>
  <div>
    <div class="entry-card">
      <div class="entry-card-header d-flex">
        <div v-if="!childhash" class="child-img flex-1">
          <a :href="`/children/${entry.child.hash}`">
            <img class="rounded-circle object-fit-cover mr-1" :src="$avatarOrDefault(entry.child.image_path)" :alt="'Avatar: ' + entry.child.first_name" width="30px" height="30px"> 
            {{entry.child.first_name}}
          </a>
        </div>
        <div class="datetime white-space-nw text-right mr-1 text-gray d-flex" :class="{'flex-1': allowEditing}">
          <i>{{entry.entry_datetime | dateFormatMDY}} {{entry.entry_datetime | dateFormatTime}}</i>
          <div v-if="allowEditing" class="dropdown">
            <button class="ml-2 btn btn-tiny btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#" @click="isEditing = true;editEntry()">Edit</a>
              <a class="dropdown-item" href="#" @click="deleteTrackerEntry(entry.id)">Delete</a>
            </div>
          </div>
        </div>
      </div>
      <div class="entry-card-body">
        <span class="badge badge-primary">{{entry.category.group}}</span> 
        <span class="badge badge-secondary">{{entry.category.name}}</span>
        <br>
        <b>
          <template v-if="entry.category.prefix">{{entry.category.prefix}}</template>
          {{entry.value}}
          <template v-if="entry.category.suffix">{{entry.category.suffix}}</template>
        </b>
        <div v-html="entry.notes"></div>
      </div>
    </div>

    <tracker-add-data-form-component 
    v-if="isEditing"
    :existingEntry="entry"
    v-on:eventSaveTrackerEntry="isEditing = false;$emit('eventSaveTrackerEntry')"
    v-on:cancelTrackerEntry="isEditing = false"/>
  </div>
  
</template>

<script>
import trackerMixin from '../../mixins/tracker';

export default {
  data() {
    return {
      isEditing: false
    }
  },

  props: {
    allowEditing: {
      type: Boolean,
      required: false,
      default: true
    },
    childhash: {
      type: String,
      required: false,
      default: null
    },
    entry: {
      type: Object,
      required: true
    }
  },

  mixins: [trackerMixin],

  methods: {
    editEntry() {
      this.isEditing = true;
      this.$nextTick(() => {
        var scroll = new SmoothScroll();
        var anchor = document.querySelector('#tracker-entry-form-' + this.entry.id);
        console.log(anchor);
          scroll.animateScroll(anchor);
      })
    }
  }
}
</script>

<style lang="scss" scoped>
  .entry-card {
    background-color: white;
    border: 1px solid #dadada;
    margin-bottom: 24px;
    padding: 8px;
  }
</style>