<template>
  <div class="dashboard">
    <div class="visitors">
      <ChartVisitors />
    </div>
  </div>
</template>

<script>
import ChartVisitors from "./ChartVisitors.vue";

export default {
  components: {
    ChartVisitors,
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
  /* display: flex;
  justify-content: center; */
  padding: 1rem;
}
.visitors {
  background-color: #ffffff;
}
</style>
