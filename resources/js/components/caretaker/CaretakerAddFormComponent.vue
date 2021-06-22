<template>
  <div class="caretaker-add-container mb-4">
    <div class="card">
      <div class="card-header">Add Caretaker</div>
      <div class="card-body">
        <form>
          <div class="row">
            <!-- <div class="col-lg-12">
              <div class="alert alert-primary" role="alert">
              <span class="text-danger">Important Note</span>: 
              Caretakers can only be added to this child if 
              the user in question has registered for Goo Goo Data. If they
              have not yet registered for Goo Goo Data, please have them registered
              first before requesting to add them as a caretaker for this child.
              </div>
            </div> -->
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="form-group mb-3">
                <label for="child" class="form-label">
                  Caretaker's Email <required/>
                  <span class="material-icons" 
                  v-tooltip="'Please use the caretaker\'s Goo Goo Data email they have registered (or plan to register) with.'" 
                  style="font-size: 16px">
                    info
                  </span>
                </label>
                <input v-model="formCaretaker.email" class="form-control" type="email">
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="form-group mb-3">
                <label for="child" class="form-label">
                  Role <required/>
                  <span class="material-icons" 
                  v-tooltip="'This description will appear below the caretaker in various pages.'" 
                  style="font-size: 16px">
                    info
                  </span>
                </label>
                <input v-model="formCaretaker.role" class="form-control" type="text">
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="form-group mb-3 checkbox-group">
                <label for="child" class="form-label">Caretaker Management 
                  <span class="material-icons" 
                  v-tooltip="'If checkmarked, this user will be able to manage this child\'s caretakers.'" 
                  style="font-size: 16px">
                    info
                  </span>
                </label>
                <input v-model="formCaretaker.is_admin" class="" type="checkbox">
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="form-group mb-3 checkbox-group">
                <label for="child" class="form-label">Tracker Management
                  <span class="material-icons" 
                  v-tooltip="'If checkmarked, this user will be able to manage this child\'s tracker entries.'" 
                  style="font-size: 16px">
                    info
                  </span>
                </label>
                <input v-model="formCaretaker.read_only" class="" type="checkbox">
              </div>
            </div>
          </div>
        </form>
        <div class="text-right">
          <slot></slot>
          <button class="btn btn-primary" @click="saveInvite()">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import caretakersMixin from '../../mixins/caretakers';

import { required, email } from 'vuelidate/lib/validators';

export default {
  data() {
    return {
      formCaretaker: {
        child_hash: null,
        email: null,
        role: null,
        is_admin: false,
        read_only: false
      }
    }
  },

  props: {
    childHash: {
      type: String,
      required: true
    }
  },

  mixins: [
    caretakersMixin
  ],

  validations: {
    formCaretaker: {
      email: {
        required,
        email
      },
      role: {
        required
      }
    }
  },

  created() {
    this.formCaretaker.child_hash = this.childHash;
  }
}
</script>

<style lang="scss" scoped>
  .checkbox-group {
    margin-top: 34px;
    border: 1px solid #cbcbcc;
    background-color: white;
    padding: 4px 8px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;

    label {
      margin: 0;
      flex: 1;
    }

    input {
      flex: 1;
      max-width: 24px;
    }
  }
</style>
