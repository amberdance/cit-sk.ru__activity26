<template>
  <el-container class="fill-height">
    <el-main :class="$style.content_wrapper">
      <el-header id="top" :class="[$style.header_wrapper, 'container']">
        <HeaderLayout />
      </el-header>

      <slot></slot>
    </el-main>

    <transition name="el-fade-in">
      <footer :class="$style.footer_wrapper" v-if="!isSlidebarHidden">
        <FooterLayout
          @onCookieAccept="acceptCookie"
          @onCookieDecline="isSlidebarHidden = true"
        />
      </footer>
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
      windowTop: null,
    };
  },

  created() {
    window.addEventListener("scroll", this.onScroll);
    if ($cookies.get("cookie_policy_slidebar")) this.isSlidebarHidden = true;
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
      this.isSlidebarHidden = true;
    },
  },
};
</script>

<style module>
.header_wrapper {
  height: inherit !important;
}

.content_wrapper {
  background: url(../../assets/bg_primary.webp);
  background-attachment: fixed;
  background-position: 50% 100%;
  background-repeat: no-repeat;
  background-size: cover;
  color: var(--color-font--primary);
}

.footer_wrapper {
  z-index: 10000;
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
