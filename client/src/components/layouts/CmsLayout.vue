<template>
  <div>
    <div id="top" class="header">
      <div class="container">
        <div class="header_wrapper">
          <div class="menu">
            <router-link
              class="menu-item"
              v-for="(item, i) in menu"
              :key="i"
              :to="item.link"
              >{{ item.label }}</router-link
            >
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <router-view></router-view>
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

<style scoped>
.header {
  font-size: 20px;
  background-color: var(--color-secondary);
  padding: 20px 0;
}
.header a {
  color: var(--color-font--secondary);
  margin: 0 20px;
  position: relative;
  line-height: 1;
}
.header a:after {
  display: block;
  position: absolute;
  left: 0;
  width: 0;
  height: 3px;
  background-color: var(--color-link);
  content: "";
  transition: width 0.3s ease-out;
}

.header a:hover:after,
.header a:focus:after {
  width: 85%;
}

.header_wrapper {
  display: flex;
  justify-content: center;
}
</style>
