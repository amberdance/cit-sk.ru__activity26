<template>
  <div :class="$style.pageWrapper">
    <el-container>
      <el-header :class="$style.headerWrapper">
        <HeaderLayout />
      </el-header>

      <el-main :class="$style.contentWrapper">
        <MainLayout />
      </el-main>
      <transition name="el-fade-in">
        <el-footer :class="$style.footerWrapper" v-if="!isSidebarHidden">
          <FooterLayout @onCookieAccept="cookieAccept" />
        </el-footer>
      </transition>
    </el-container>
  </div>
</template>

<script>
import HeaderLayout from "@/components/HeaderLayout.vue";
import MainLayout from "@/components/MainLayout.vue";
import FooterLayout from "@/components/FooterLayout.vue";

export default {
  components: {
    HeaderLayout,
    MainLayout,
    FooterLayout,
  },

  data() {
    return {
      isSidebarHidden: false,
    };
  },

  created() {
    if (localStorage.getItem("cookie_policy_slidebar"))
      this.isSidebarHidden = true;
  },

  methods: {
    cookieAccept() {
      localStorage.setItem("cookie_policy_slidebar", +new Date() + ":Y");
      this.isSidebarHidden = true;
    },
  },
};
</script>

<style module>
.pageWrapper {
  width: 100%;
}

.headerWrapper {
  background-color: var(--color-secondary);
  padding: 1rem;
}

.contentWrapper {
  height: 100vh;
}
.footerWrapper {
  position: absolute;
  display: flex;
  justify-content: center;
  min-height: 100px;
  width: 100%;
  bottom: 0;
  background-color: #ffffff;
  box-shadow: -1px -6px 10px #89898985;
}
</style>
