<template>
  <div>
    <div v-show="!isAdding">
      <button class="btn btn-primary mb-3" @click="isAdding = true">
        <i class="material-icons">add_circle</i> New Entry
      </button>
    </div>

    <div v-show="isAdding" id="form-add-child" class="card mb-4">
      <div class="card-header">{{existingEntry ? 'Edit' : 'New'}} Entry</div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-lg-3">
              <div class="form-group mb-3" :class="{'form-group--error': $v.formTracker.child_id.$error}">
                <label for="child" class="form-label">Child</label>
                <select v-model="formTracker.child_id" class="form-control" name="child" id="child">
                  <option :value="null">Select...</option>
                  <option v-for="child in children" :value="child.id" :key="`${child.id}-${child.first_name}`">
                    {{child.first_name}} {{child.last_name}}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3" :class="{'form-group--error': $v.formTracker.$dirty && !selectedCategory}">
                <label for="category" class="form-label">Category</label>
                <select v-model="selectedCategory" @change="formTracker.category = null" class="form-control" name="child" id="child">
                  <option :value="null">Select...</option>
                  <option v-for="(category, index) in categories" :key="index" :value="index">
                    {{index}}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3" :class="{'form-group--error': $v.formTracker.category.$error}">
                <label for="category" class="form-label">Option</label>
                <select v-model="formTracker.category" class="form-control" name="child" id="child">
                  <option :value="null">Select...</option>
                  <option v-for="option in selectedCategoryOptions" :key="option.id + option.name" :value="option">
                    {{option.name}}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-lg-3">
              <label for="inlineFormInputGroup" :class="{'form-group--error': $v.formTracker.value.$error}">Amount</label>
              <div class="input-group mb-2" :class="{'form-group--error': $v.formTracker.value.$error}">
                <div v-if="this.formTracker.category && this.formTracker.category.prefix" class="input-group-prepend">
                  <div class="input-group-text">{{this.formTracker.category.prefix}}</div>
                </div>
                
                <input v-model="formTracker.value" type="number" class="form-control" id="inlineFormInputGroup">

                <div v-if="this.formTracker.category && this.formTracker.category.suffix" class="input-group-append">
                  <div class="input-group-text">{{this.formTracker.category.suffix}}</div>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3" :class="{'form-group--error': $v.formTracker.entry_datetime.$error}"> 
                <label for="birthday" class="form-label">Date & Time</label>
                <br>
                <!-- <input v-model="formChild.birthday" type="text" class="form-control" id="birthday"> -->
                <v-date-picker mode="dateTime" v-model="formTracker.entry_datetime" />
              </div>
            </div>
            <div class="col-lg-9">
              <div class="form-group mb-3"> 
                <label for="Notes">Notes</label>
                <wysiwyg v-model="formTracker.notes" style="height: 335px" />
                <!-- <textarea v-model="formTracker.notes" class="form-control" style="height: 335px" /> -->
              </div>
            </div>
          </div>
          
          <div class="float-right">
            <input type="button" onsubmit="event.preventDefault()" @click="_resetFormTracker();$emit('cancelTrackerEntry');" class="btn btn-danger" value="Cancel">
            <input type="button" onsubmit="event.preventDefault()" @click="saveTrackerEntry()" class="btn btn-success" value="Save" />
          </div>
          
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children';
import categoriesMixin from '../../mixins/categories';
import trackerMixin from '../../mixins/tracker';

import { required, decimal, maxLength } from 'vuelidate/lib/validators';

export default {
  data() {
    return {
      isAdding: false,

      formTracker: {
        id: null,
        child_id: null,
        category: null,
        category_id: null,
        value: null,
        notes: null,
        entry_datetime: null
      }
    }
  },

  mixins: [
    childrenMixin,
    categoriesMixin,
    trackerMixin
  ],

  props: {
    existingEntry: {
      type: Object,
      required: false,
      default: null
    }
  },

  validations: {
    formTracker: {
      child_id: {
        required
      },
      category: {
        required
      },
      value: {
        required,
        decimal,
        maxLength: maxLength(8)
      },
      entry_datetime: {
        required
      }
    }
  },

  methods: {
    _resetFormTracker() {
      this.isAdding = false;
      this.formTracker.child_id = null;
      this.formTracker.category = null;
      this.formTracker.category_id = null;
      this.formTracker.value = null;
      this.formTracker.notes = null;
      this.formTracker.entry_datetime = null;

      this.selectedCategory = null;

      this.$v.formTracker.$reset();
    }
  },

  mounted() {
    this.getChildren();
    this.getCategories();

    if (this.existingEntry) {
      this.isAdding = true;
      this.formTracker.id = this.existingEntry.id;
      this.formTracker.child_id = this.existingEntry.child_id;
      this.formTracker.category = this.existingEntry.category;
      this.selectedCategory = this.existingEntry.category.group;
      this.formTracker.category_id = this.existingEntry.category_id;
      this.formTracker.value = this.existingEntry.value;
      this.formTracker.notes = this.existingEntry.notes;
      this.formTracker.entry_datetime = this.existingEntry.entry_datetime;
    }
  }
}
</script>

<style>

</style>