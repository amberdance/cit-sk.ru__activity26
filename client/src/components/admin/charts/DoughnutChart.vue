<template>
  <div class="chart_wrapper">
    <div class="chart_data">
      <div class="title">Принято мнений</div>
      <div class="chart_result">{{ dashboard.polls.passedCount }}</div>
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

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

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
    dashboard() {
      return this.$store.getters.get("dashboard");
    },
  },

  created() {
    this.dashboard.polls.categories.forEach(({ label, count }) => {
      this.chartData.labels.push(label);
      this.chartData.datasets[0].data.push(count);
    });
  },
};
</script>
