<template>
  <div class="dashboard">
    <div class="visitors">
      <BarChart v-if="isLoaded" />
      <HorizontalBarChart v-if="isLoaded" />
    </div>
  </div>
</template>

<script>
import BarChart from "./BarChart.vue";
import HorizontalBarChart from "./HorizontalBarChart.vue";

export default {
  components: {
    BarChart,
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
  width: 100%;
  height: 100%;
  padding: 2rem;
}
.visitors {
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: space-between;
}
</style>
