<template>
  <component :is="homeComponent" />
</template>
<script>
export default {
  data() {
    return {
      homeComponent: null,
    };
  },

  created() {
    this.homeComponent = this.$isMobile()
      ? () => import("./Mobile.vue")
      : () => import("./Desktop.vue");
  },
};
</script>
