<template>
  <div class="dashboard">
    <div class="visitors">
      <BarChart />
      <HoriszntalBarChart />
    </div>
  </div>
</template>

<script>
import BarChart from "./BarChart.vue";
import HoriszntalBarChart from "./HoriszntalBarChart.vue";

export default {
  components: {
    BarChart,
    HoriszntalBarChart,
  },

  async created() {
    const response = await this.$http.get("/admin/dashboard");

    console.log(response);
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
