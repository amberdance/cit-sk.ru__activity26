<template>
  <div :class="$style.root">
    <el-header id="top" :class="[$style.header, 'container']">
      <HeaderLayout />
    </el-header>

    <el-main :class="$style.content">
      <slot></slot>
    </el-main>

    <transition name="el-fade-in">
      <footer
        v-if="!isSlidebarHidden"
        :class="[$style.footer, 'rounded', 'shadowed']"
      >
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
  </div>
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
.root {
  background: url(../../assets/bg_primary.webp);
  background-attachment: fixed;
  background-position: 50% 100%;
  background-repeat: no-repeat;
  background-size: cover;
  color: var(--color-font--primary);
}

.header {
  padding: 1rem 0 !important;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  width: 100%;
  z-index: 20;
}

.content {
  padding-top: 100px !important;
}
.footer {
  z-index: 10000;
  position: fixed;
  bottom: 0;
  background-color: #ffffff;
  max-width: 1024px;
  margin: 5% auto 1rem auto;
  left: 0;
  right: 0;
}
</style>
