<template>
  <div class="dashboard">
    <DoughnutChart v-if="isLoaded" />
    <PieChart v-if="isLoaded" />
    <BarChart v-if="isLoaded" />
  </div>
</template>

<script>
import BarChart from "./charts/BarChart.vue";
import PieChart from "./charts/PieChart.vue";
import DoughnutChart from "./charts/DoughnutChart.vue";

export default {
  components: {
    BarChart,
    PieChart,
    DoughnutChart,
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
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  background-color: #ebebeb;
  min-height: 100vh;
  padding: 2rem;
}
</style>
