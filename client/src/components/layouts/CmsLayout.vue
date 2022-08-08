<template>
  <div>
    <div id="top" class="header">
      <div class="container">
        <div class="header_wrapper">
          <div class="menu">
            <router-link
              class="menu-item"
              :to="item.link"
              v-for="(item, i) in menu"
              :key="i"
              >{{ item.label }}</router-link
            >
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <slot></slot>
    </div>

    <ScrollTop />
  </div>
</template>

<script>
import ScrollTop from "../shared/ScrollTop.vue";
import { ADMIN_MENU } from "../../values";

export default {
  components: {
    ScrollTop,
  },

  data() {
    return {
      menu: ADMIN_MENU,
    };
  },
};
</script>
