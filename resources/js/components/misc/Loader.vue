<template>
  <div class="loader-container text-center animate__pulse animate__infinite">
    <span style="font-size: 100px" class="loader material-icons animate__animated animate__heartBeat animate__infinite animate__bounceIn">
      child_friendly
    </span>
  </div>
</template>

<script>
export default {

}
</script>

<style>
  .loader-container {
    border: 1px solid;
    border-radius: 100px;
    width: 110px;
    margin: auto;
    background: linear-gradient( 
    90deg
    , #bd55ff 0%, #8245ea 51%, #8245ea 100%);
      color: white;
  }
</style>