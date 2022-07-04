<template>
  <el-container>
    <el-main :class="$style.contentWrapper">
      <el-header :class="[$style.headerWrapper, 'container']">
        <HeaderLayout />
      </el-header>

      <slot></slot>
    </el-main>

    <transition name="el-fade-in">
      <el-footer :class="$style.footerWrapper" v-if="!isSlidebarHidden">
        <FooterLayout @onCookieAccept="acceptCookie" />
      </el-footer>
    </transition>
  </el-container>
</template>

<script>
import HeaderLayout from "./HeaderLayout.vue";
import FooterLayout from "./FooterLayout.vue";

export default {
  components: {
    HeaderLayout,
    FooterLayout,
  },

  data() {
    return {
      isSlidebarHidden: false,
    };
  },

  created() {
    if ($cookies.get("cookie_policy_slidebar")) this.isSlidebarHidden = true;
  },

  methods: {
    acceptCookie() {
      $cookies.set("cookie_policy_slidebar", +new Date() + "Y", "1d");
      this.isSlidebarHidden = true;
    },
  },
};
</script>

<style module>
.headerWrapper {
  height: inherit !important;
}

.contentWrapper {
  min-height: 1024px;
  background: url(../../assets/bg_primary.webp);
  background-position: 50% 80%;
  background-repeat: no-repeat;
  background-size: cover;
}

.footerWrapper {
  position: fixed;
  display: flex;
  justify-content: center;
  min-height: 100px;
  width: 100%;
  bottom: 0;
  background-color: #ffffff;
  box-shadow: -1px -6px 10px #89898985;
}
</style>
