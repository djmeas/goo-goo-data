<template>
  <div>
    <div v-show="!isAdding">
      <button class="btn btn-primary mb-3" @click="isAdding = true">
        <i class="material-icons">add_circle</i> Add New Data
      </button>
    </div>

    <div v-show="isAdding" id="form-add-child" class="card mb-4">
      <div class="card-header">Add New Data</div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group mb-3">
                <label for="child" class="form-label">Child</label>
                <select v-model="formTracker.child_id" class="form-control" name="child" id="child">
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
                <select v-model="formTracker.category_id" class="form-control" name="child" id="child">
                  <option :value="null">Select...</option>
                </select>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group mb-3">
                <label for="category" class="form-label">Value</label>
                <input type="text" class="form-control" v-model="formTracker.value" />
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3"> 
                <label for="birthday" class="form-label">Date & Time</label>
                <br>
                <!-- <input v-model="formChild.birthday" type="text" class="form-control" id="birthday"> -->
                <v-date-picker mode="dateTime" v-model="formTracker.datetime" />
              </div>
            </div>
            <div class="col-lg-9">
              <div class="form-group mb-3"> 
                <label for="Notes">Notes</label>
                <textarea v-model="formTracker.notes" class="form-control" style="height: 335px" />
              </div>
            </div>
          </div>
          
          <div class="float-right">
            <input type="button" onsubmit="event.preventDefault()" @click="isAdding = false" class="btn btn-danger" value="Cancel">
            <input type="button" onsubmit="event.preventDefault()" class="btn btn-success" value="Save" />
          </div>
          
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children';

export default {
  data() {
    return {
      isAdding: false,

      formTracker: {
        child_id: null,
        category_id: null,
        value: null,
        notes: null,
        datetime: null
      }
    }
  },

  mixins: [childrenMixin],

  methods: {

  },

  mounted() {
    this.getChildren();
  }
}
</script>

<style>

</style>