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
            <div class="col-lg-3">
              <div class="form-group mb-3">
                <label for="child" class="form-label">Caretaker's Email</label>
                <input v-model="formCaretaker.email" class="form-control" type="email">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3">
                <label for="child" class="form-label">Role</label>
                <input v-model="formCaretaker.role" class="form-control" type="text">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3">
                <label for="child" class="form-label">Child Admin</label>
                <input v-model="formCaretaker.is_admin" class="" type="checkbox">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mb-3">
                <label for="child" class="form-label">Read Only Access</label>
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

<style>

</style>