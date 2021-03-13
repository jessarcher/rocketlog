<template>
  <component
    :is="iconComponent"
    class="inline-block"
    role="img"
  />
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    }
  },
  computed: {
    iconComponent () {
      this.name // Trigger the name as a dependency for change detection
      return () => import(
        /* webpackChunkName: "icons" */
        '!vue-svg-loader!@/../../public/icons/' + this.name + '.svg'
      )
    }
  }
}
</script>
