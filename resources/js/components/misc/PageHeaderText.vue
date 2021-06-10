<template>
  <div class="page-header animate__pulse">
    <h1 class="mb-5 ">
      {{text}}
    </h1>
    <!-- <svg class="header-circle-a" height="100" width="100">
      <circle cx="50" cy="50" r="40" stroke="white" stroke-width="3" fill="aquamarine" />
      Sorry, your browser does not support inline SVG.  
    </svg> 
    <svg class="header-circle-b" height="100" width="100">
      <circle cx="50" cy="50" r="40" stroke="white" stroke-width="3" fill="blueviolet" />
      Sorry, your browser does not support inline SVG.  
    </svg>  -->
  </div>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      required: true
    }
  }
}
</script>

<style>

</style>