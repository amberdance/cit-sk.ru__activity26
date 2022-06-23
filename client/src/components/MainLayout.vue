<template>
  <el-container>
    <el-main :class="$style.contentWrapper">
      <div :class="$style.background">
        <div :class="$style.overlay"></div>
        <div :class="$style.content">
          <el-row>
            <el-col :xs="10" :md="12" :sm="10" :lg="4">
              <div :class="$style.heading">
                <div :class="[$style.headingContent, 'heading']">
                  <slot name="leftColumn"></slot>
                </div>
              </div>
            </el-col>

            <el-col
              :span="20"
              :class="$style.formWrapper"
              :style="{
                backgroundColor: $slots.body ? '#ffffffcc' : 'none',
              }"
            >
              <slot name="body"></slot>
            </el-col>
          </el-row>
        </div>
      </div>
    </el-main>

    <transition name="el-fade-in">
      <el-footer :class="$style.footerWrapper" v-if="!isSlidebarHidden">
        <FooterLayout @onCookieAccept="acceptCookie" />
      </el-footer>
    </transition>
  </el-container>
</template>

<script>
import FooterLayout from "@/components/FooterLayout.vue";

export default {
  components: {
    FooterLayout,
  },

  data() {
    return {
      isSlidebarHidden: false,
    };
  },

  created() {
    if (localStorage.getItem("cookie_policy_slidebar"))
      this.isSlidebarHidden = true;
  },

  methods: {
    acceptCookie() {
      localStorage.setItem("cookie_policy_slidebar", +new Date() + ":Y");
      this.isSlidebarHidden = true;
    },
  },
};
</script>

<style module>
.headerWrapper {
  background-color: var(--color-secondary);
  padding: 1rem;
}

.contentWrapper {
  overflow: hidden;
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

.background {
  background-image: url("../assets/bg_animated.gif");
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
}
.overlay {
  background-color: #ffffff;
  height: 100%;
  opacity: 0.5;
  position: fixed;
  width: 100%;
}
.content {
  position: relative;
}

.heading {
  background-color: #259942cc;
  display: flex;
  flex-direction: column;
  height: 100vh;
  padding: 1rem;
  border-right: 4px #ffffff solid;
  color: #ffffff;
  box-shadow: 4px -1px 13px #2e2e2e47;
}

.heading h1 {
  text-align: center;
}

.headingContent {
  font-size: 18px;
}

.headingContent button {
  border: none;
  color: #ffffff;
  padding: 1.5rem;
  width: 100%;
  font-weight: bold;
}
</style>
