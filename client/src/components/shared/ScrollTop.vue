<template>
  <transition name="el-fade-in-linear">
    <div
      v-show="windowTop >= offset"
      class="up_btn shadowed"
      v-scroll-to="scrollTo"
    >
      <i class="el-icon-top"></i>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      windowTop: null,
    };
  },

  props: {
    scrollTo: {
      type: String,
      default: "#top",
    },

    offset: {
      type: Number,
      default: 500,
    },
  },

  created() {
    window.addEventListener("scroll", this.onScroll);
  },

  beforeDestroy() {
    window.removeEventListener("scroll", this.onScroll);
  },

  methods: {
    onScroll() {
      this.windowTop = window.top.scrollY;
    },
  },
};
</script>
