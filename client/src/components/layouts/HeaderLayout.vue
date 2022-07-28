<template>
  <component :is="navigationMenuComponent" :isAuthorized="isAuthorized" />
</template>

<script>
export default {
  computed: {
    isAuthorized() {
      return this.$store.getters.isUserAuthorized;
    },
  },

  data() {
    return {
      navigationMenuComponent: null,
    };
  },

  created() {
    this.navigationMenuComponent = this.$isMobile()
      ? () => import("@/components/shared/MobileMenu.vue")
      : () => import("@/components/shared/DesktopMenu.vue");
  },
};
</script>
