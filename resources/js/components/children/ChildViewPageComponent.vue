<template>
  <div id="child-view-page-container">
    <div v-if="child" class="row">
      <div class="col-lg-4 offset-lg-4 mb-5">
        <div class="text-center">
          <img class="rounded-circle mb-4 animate__bounceIn" :src="`${$baseAvatarPath}/${child.image_path}`" alt="" width="100%">
          <h1>{{child.first_name}} {{child.last_name}}</h1>
          <h3><span class="material-icons">cake</span> {{child.birthday | dateFormatBirthday}}</h3>
          <h3>{{$childBirthdayInMonths(child.birthday)}}</h3>
          
        </div>
      </div>

      <!-- Caretakers -->
      <div class="col-lg-12">
        <page-header-text text="Caretakers"/>
      </div>

      <div v-for="caretaker in child.caretaker_users" class="col-lg-4 mb-5">
        <div class="card-horizontal">
          <div class="left-box">
            <span class="material-icons">
              account_circle
            </span>
          </div>
          <div class="right-box">
            <h1>{{caretaker.first_name}} {{caretaker.last_name}}</h1>
            <h2>{{caretaker.role}}</h2>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card-horizontal">
          <div class="left-box">
            <span class="material-icons">
              person_add
            </span>
          </div>
          <div class="right-box">
            <h1>Add New Caretaker</h1>
          </div>
        </div>
      </div>
      
      <div class="col-lg-12">
      <tracker-table-component :childhash="childhash"/>
      </div>

    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children';

export default {
  props: {
    childhash: {
      type: String,
      required: false,
      default: null
    }
  },

  mixins: [
    childrenMixin,
  ],

  methods: {

  },

  mounted() {
    this.getChildren(this.childhash);
  }
}
</script>

<style>

</style>