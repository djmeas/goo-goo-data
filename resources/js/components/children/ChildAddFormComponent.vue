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
              <label for="birthday" class="form-label">Birthday</label>
              <br>
              <!-- <input v-model="formChild.birthday" type="text" class="form-control" id="birthday"> -->
              <v-date-picker v-model="formChild.birthday" />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group mb-3" :class="{'form-group--error': $v.formChild.birthday.$error}"> 
              <label for="" class="form-label">Image</label>
              <input id="uploaded_file" type="file" ref="uploaded_file" name="uploaded_file">
            </div>
          </div>
        </div>
        
        <div class="float-right">
          <button @click="isAdding = false; cancelAddChild();" class="btn btn-danger">Cancel</button>
          <input type="button" onsubmit="event.preventDefault()" @click="saveChild" class="btn btn-success" value="Save" />
        </div>
        
      </form>
    </div>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';

export default {
  data() {
    return {
      isAdding: false,

      formChild: {
        first_name: null,
        last_name: null,
        birthday: null
      }
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
     * Makes a POST request to save a new child.
     */
    saveChild() {
      this.$v.formChild.$touch();

      if (!this.$v.formChild.$invalid) {
        // MUST USE FormData() if you want to uploaded a FILE to Laravel's REQUEST $request class
        var formPostData = new FormData();
        formPostData.append('form_data', JSON.stringify(this.formChild));

        // if () {
            formPostData.append('uploaded_file', this.$refs.uploaded_file.files[0]);
        // } else {
        //     if(document.getElementById("edit_uploaded_file").files.length > 0) {
        //         formPostData.append('uploaded_file', this.$refs.edit_uploaded_file.files[0]);
        //     }
        // }

        console.log(formPostData);

        axios.post('/api/child', formPostData)
          .then(res => {
            this.$emit('eventSaveChild', res.data);

            this.$toasted.success('Child successfully created.');

            this._resetFormChild();
          })
          .catch(err => {
            this.$toasted.error('Whoops! Something went wrong.');
          });

      } else {
        this.$toasted.error('Please fill out all required fields.');
      }

    },

    cancelAddChild() {
      this._resetFormChild();
      this.$emit('eventCancelAddChild');
    },

    _resetFormChild() {
      this.isAdding = false;
      this.formChild.first_name = null;
      this.formChild.last_name = null;
      this.formChild.birthday = null;

      this.$v.formChild.$reset();
    }
  }
}
</script>

<style>

</style>