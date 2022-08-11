<template>
  <div class="dashboard">
    <HorizontalBarChart v-if="isLoaded" />
  </div>
</template>

<script>
import HorizontalBarChart from "./HorizontalBarChart.vue";

export default {
  components: {
    HorizontalBarChart,
  },

  data() {
    return {
      isLoaded: false,
    };
  },

  async created() {
    try {
      await this.$store.dispatch("loadDashboard");
      this.isLoaded = true;
    } catch (e) {
      this.$onError();
      console.error(e);
    }
  },
};
</script>

<style scoped>
.dashboard {
  background-color: #ebebeb;
  min-height: 100vh;
  padding: 2rem;
}

.visitors {
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: space-between;
}
</style>
