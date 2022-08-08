<template>
  <div :class="isInnerPage ? 'root' : null">
    <HeaderLayout id="top" />

    <el-main :class="isInnerPage ? 'content' : null">
      <slot></slot>
    </el-main>

    <FooterLayout id="footer" />

    <transition name="el-fade-in">
      <CookiePolicy
        v-if="!isCookieBannerHidden"
        @onCookieAccept="acceptCookie"
        @onCookieDecline="isCookieBannerHidden = true"
      >
      </CookiePolicy>
    </transition>

    <ScrollTo />
  </div>
</template>

<script>
import HeaderLayout from "./HeaderLayout";
import FooterLayout from "./FooterLayout";
import CookiePolicy from "../shared/CookiePolicy";
import ScrollTo from "../shared/ScrollTop";

export default {
  components: {
    HeaderLayout,
    FooterLayout,
    CookiePolicy,
    ScrollTo,
  },

  data() {
    return {
      isCookieBannerHidden: false,
      windowTop: null,
      isInnerPage: false,
    };
  },

  created() {
    this.isInnerPage = this.$route.path !== "/home";

    window.addEventListener("scroll", this.onScroll);

    if ($cookies.get("cookie_policy_slidebar"))
      this.isCookieBannerHidden = true;
  },

  methods: {
    acceptCookie() {
      $cookies.set("cookie_policy_slidebar", +new Date() + "Y", "1d");
      this.isCookieBannerHidden = true;
    },
  },
};
</script>

<style scoped>
.root {
  background: url(../../assets/bg_primary.webp);
  background-attachment: fixed;
  background-position: 50% 100%;
  background-repeat: no-repeat;
  background-size: cover;
  color: var(--color-font--primary);
}

.content {
  padding-top: 100px !important;
  min-height: 100vh;
  position: relative;
}
</style>
