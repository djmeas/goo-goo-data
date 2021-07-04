<template>
  <div v-show="isAdding" id="form-add-child" class="card mb-4">
    <div class="card-header">Add Child</div>
    <div class="card-body">
      <form>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group mb-3" :class="{'form-group--error': $v.formChild.first_name.$error}">
              <label for="first_name" class="form-label">First Name</label>
              <input v-model="formChild.first_name" type="text" class="form-control" id="first_name">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group mb-3" :class="{'form-group--error': $v.formChild.last_name.$error}">
              <label for="last_name" class="form-label">Last Name</label>
              <input v-model="formChild.last_name" type="text" class="form-control" id="last_name">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group mb-3" :class="{'form-group--error': $v.formChild.birthday.$error}"> 
              <label for="birthday" class="form-label">
                Birthday 
                <span v-if="existingChild">({{existingChild.birthday | dateFormatBirthday}})</span>
              </label>
              <br>
              <v-date-picker v-model="formChild.birthday" />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group mb-3"> 
              <label for="" class="form-label">Image</label>
              <input id="uploaded_file" type="file" ref="uploaded_file" name="uploaded_file">
            </div>
            <div v-if="existingChild && existingChild.image_path" class="current-image">
              <div>Current Image</div>
              <img :src="`${$baseAvatarPath}/${existingChild.image_path}`" alt="" width="45%">
              <div class="mt-2">
                <input type="checkbox" v-model="formChild.remove_image"> Remove current image
              </div>
            </div>
          </div>
        </div>
        
        <div class="float-right">
          <input type="button" onsubmit="event.preventDefault()" @click="isAdding = false; cancelAddChild();" class="btn btn-danger" value="Cancel">
          <input type="button" onsubmit="event.preventDefault()" @click="saveChild" class="btn btn-success" value="Save" />
        </div>
        
      </form>
    </div>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
import childrenMixin from '../../mixins/children.js';

export default {
  data() {
    return {
      isAdding: false,

      formChild: {
        id: null,
        first_name: null,
        last_name: null,
        birthday: null,
        remove_image: false
      }
    }
  },

  mixins: [childrenMixin],

  props: {
    existingChild: {
      type: Object,
      required: false,
      default: null
    }
  },

  validations: {
      formChild: {
          first_name: {
              required
          },
          last_name: {
              required
          },
          birthday: {
              required
          }
      }
  },

  methods: {
    /**
     * Handles the cancel child button.
     */
    cancelAddChild() {
      this._resetFormChild();
      this.$emit('eventCancelAddChild');
    },

    /**
     * Resets the add/edit child form.
     */
    _resetFormChild() {
      if (!this.existingChild) {
        this.formChild.first_name = null;
        this.formChild.last_name = null;
        this.formChild.birthday = null;
        this.$v.formChild.$reset();
      } else {
        this.formChild.first_name = this.existingChild.first_name;
        this.formChild.last_name = this.existingChild.last_name;
        this.formChild.birthday = this.existingChild.birthday + ' 12:00:00';
      }

      this.isAdding = false;
      this.formChild.remove_image = false;
      document.getElementById('uploaded_file').value = null;
    }
  },

  /**
   * On component mount.
   */
  mounted() {
    if (this.existingChild) {
      this.formChild.id = this.existingChild.id;
      this.formChild.first_name = this.existingChild.first_name;
      this.formChild.last_name = this.existingChild.last_name;
      this.formChild.birthday = this.existingChild.birthday + ' 12:00:00';
    }
  }
}
</script>

<style>

</style>