<template>
  <component
    :is="navigationMenuComponent"
    :menu="menu"
    :isAuthorized="isAuthorized"
  />
</template>

<script>
import { navigationMenu } from "@/values";

export default {
  computed: {
    isAuthorized() {
      return this.$store.getters.isUserAuthorized;
    },
  },

  data() {
    return {
      navigationMenuComponent: null,
      menu: navigationMenu,
    };
  },

  created() {
    this.navigationMenuComponent = this.$isMobile()
      ? () => import("@/components/shared/DesktopMenu.vue")
      : () => import("@/components/shared/DesktopMenu.vue");
  },
};
</script>
