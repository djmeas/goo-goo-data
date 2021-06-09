<template>
  <div id="child-view-page-container">
    <div v-if="child" class="row">
      <div class="col-lg-3 offset-lg-4 mb-4">
        <div class="text-center">
          <img class="rounded-circle mb-4 animate__bounceIn" :src="`${$baseAvatarPath}/${child.image_path}`" alt="" width="100%">
          <h1>{{child.first_name}} {{child.last_name}}</h1>
          <h2><span class="material-icons">cake</span> {{child.birthday | dateFormatBirthday}}</h2>
          <h2>{{$childBirthdayInMonths(child.birthday)}}</h2>
          
        </div>
      </div>
      
      <!-- <div class="col-lg-9">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Age</td>
              <td>{{$childBirthdayInMonths(child.birthday)}}</td>
            </tr>
            <tr>
              <td>Birthday</td>
              <td>{{child.birthday}}</td>
            </tr>
            <tr>
              <td>Caretakers</td>
              <td>
                <span v-for="caretaker in child.caretaker_users">
                  {{caretaker.first_name}} {{caretaker.last_name}}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div> -->
      <tracker-table-component :childhash="childhash"/>

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