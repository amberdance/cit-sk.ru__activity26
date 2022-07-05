<template>
  <el-container>
    <el-main :class="$style.contentWrapper">
      <el-header :class="[$style.headerWrapper, 'container']">
        <HeaderLayout />
      </el-header>

      <slot></slot>
    </el-main>

    <transition name="el-fade-in">
      <footer :class="$style.footerWrapper" v-if="!isSlidebarHidden">
        <FooterLayout
          @onCookieAccept="acceptCookie"
          @onCookieDecline="isSlidebarHidden = true"
        />
      </footer>
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
  z-index: 10;
  position: fixed;
  bottom: 0;
  background-color: #ffffff;
  border-radius: 20px;
  max-width: 1200px;
  margin: 5% auto 1rem auto;
  left: 0;
  right: 0;
  box-shadow: 3px 3px 10px #89898985;
}
</style>
