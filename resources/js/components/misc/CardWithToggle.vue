<template>
  <div class="card">
    <div class="card-header">
      {{cardHeader}} 
      <button class="btn btn-tiny btn-default float-right" @click="isExpanded = !isExpanded">
        <span v-if="isExpanded" class="material-icons">
        expand_less
        </span>
        <span v-else class="material-icons">
        expand_more
        </span>
      </button>
    </div>
    <div  v-if="isExpanded" class="card-body">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isExpanded: false,
    }
  },

  props: {
    expanded: {
      type: Boolean,
      required: false,
      default: false
    },
    cardHeader: {
      type: String,
      required: true
    }
  },

  mounted() {
    this.isExpanded = this.expanded;
  }
}
</script>

<style lang="scss" scoped>
  .card-header {
    padding: 8px 16px;
  }
</style>