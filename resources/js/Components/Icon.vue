<template>
  <component
    :is="iconComponent"
    class="inline-block"
    :style="styleObject"
    role="img"
  />
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },

    autoSize: {
      type: Boolean,
      default: false,
    }
  },
  computed: {
    iconComponent () {
      this.name // Trigger the name as a dependency for change detection
      return () => import(
        /* webpackChunkName: "icons" */
        '!vue-svg-loader!@/../../public/icons/' + this.name + '.svg'
      )
    },

    styleObject() {
      return this.autoSize ? {
        height: '1em',
        width: '1em',
        verticalAlign: '-0.125em',
      } : {}
    },
  }
}
</script>
