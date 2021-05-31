<template>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Child</th>
          <th>Category</th>
          <th>Value</th>
          <th>Notes</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="x of 10" :key="x">
          <td>Row {{x}}</td>
          <td>Row {{x}}</td>
          <td>Row {{x}}</td>
          <td>Row {{x}}</td>
          <td>Row {{x}}</td>
          <td>[Actions]</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {

    }
  },

  methods: {

  },

  mounted() {

  }
}
</script>

<style>

</style>