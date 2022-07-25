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
    this.homeComponent =
      document.documentElement.clientWidth <= 960
        ? () => import("./Device.vue")
        : () => import("./Desktop.vue");
  },
};
</script>
