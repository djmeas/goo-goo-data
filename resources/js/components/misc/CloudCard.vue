<template>
  <div class="cloud-card position-relative">
    <div class="content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
  .cloud-card {
    /* background-color: #e0d3ec; */
  }

  .cloud-card .content {
    z-index: 1;
  }

  .splat {
    position: absolute;
    top: -318px;
    z-index: -1;
    left: 52px;
    opacity: 0;
  }

  .splat svg {
    /* width: 250px; */
  }

  .splat-svg {
    fill: #e0d3ec;
}
</style>