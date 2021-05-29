<template>
  <div id="child-cards" class="row">
    <div v-for="index in 3" :key="index" class="col-lg-3 col-md-6">
      <div class="child-card">
        <div class="photo text-center">
          [Child Photo]
        </div>
        <div class="name text-center pt-4">
          First Last
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="child-card">
        <div class="photo text-center">
          [Add CIRCLE]
        </div>
        <div class="name text-center pt-4">
          <button @click="emitAddChild()" class="btn btn-primary">Add Child</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    emitAddChild() {
      console.log('caught');
      this.$emit('eventAddChild');
    }
  }
  
}
</script>

<style>

</style>