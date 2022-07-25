<template>
  <div :class="$style.root">
    <HeaderLayout id="top" />

    <el-main :class="$style.content">
      <slot></slot>
    </el-main>

    <transition name="el-fade-in">
      <CookiePolicy
        v-if="!isCookieBannerHidden"
        @onCookieAccept="acceptCookie"
        @onCookieDecline="isCookieBannerHidden = true"
      >
      </CookiePolicy>
    </transition>

    <transition name="el-fade-in-linear">
      <div
        v-show="windowTop >= 500"
        class="up_btn shadowed"
        v-scroll-to="'#top'"
      >
        <i class="el-icon-top"></i>
      </div>
    </transition>
  </div>
</template>

<script>
import HeaderLayout from "./HeaderLayout.vue";
import CookiePolicy from "../CookiePolicy";

export default {
  components: {
    HeaderLayout,
    CookiePolicy,
  },

  data() {
    return {
      isCookieBannerHidden: false,
      windowTop: null,
    };
  },

  created() {
    window.addEventListener("scroll", this.onScroll);

    if ($cookies.get("cookie_policy_slidebar"))
      this.isCookieBannerHidden = true;
  },

  beforeDestroy() {
    window.removeEventListener("scroll", this.onScroll);
  },

  methods: {
    onScroll() {
      this.windowTop = window.top.scrollY;
    },

    acceptCookie() {
      $cookies.set("cookie_policy_slidebar", +new Date() + "Y", "1d");
      this.isCookieBannerHidden = true;
    },
  },
};
</script>

<style module>
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
}
</style>
