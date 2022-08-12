<template>
  <div class="chart_wrapper shadowed">
    <div class="chart_heading shadowed">
      <div class="title">Принято мнений</div>
      <div class="chart_result">{{ polls.passedCount }}</div>
    </div>
    <Doughnut
      class="canvas_wrapper"
      :chart-options="chartOptions"
      :chart-data="chartData"
    />
  </div>
</template>

<script>
import { Doughnut } from "vue-chartjs/legacy";

export default {
  name: "DoughnutChart",
  components: {
    Doughnut,
  },

  data() {
    return {
      chartData: {
        labels: [],
        datasets: [
          {
            backgroundColor: ["#3186ff", "#035ad6", "#2d68bc", "#5c81b6"],
            data: [],
          },
        ],
      },

      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },
    };
  },

  computed: {
    polls() {
      return this.$store.getters.get("dashboard").polls;
    },
  },

  created() {
    this.polls.categories.forEach(({ label, count }) => {
      this.chartData.labels.push(label);
      this.chartData.datasets[0].data.push(count);
    });
  },
};
</script>
