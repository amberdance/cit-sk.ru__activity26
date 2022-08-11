<template>
  <div class="dashboard">
    <BarChart v-if="isLoaded" />
  </div>
</template>

<script>
import BarChart from "./charts/BarChart.vue";

export default {
  components: {
    BarChart,
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
</style>
