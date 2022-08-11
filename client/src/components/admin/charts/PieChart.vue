<template>
  <div class="chart_wrapper">
    <div class="chart_data">
      <div class="title">Всего пользователей</div>
      <div class="chart_result">{{ dashboard.users.totalCount }}</div>
    </div>
    <Pie
      class="canvas_wrapper"
      :chart-options="chartOptions"
      :chart-data="chartData"
    />
  </div>
</template>

<script>
import { Pie } from "vue-chartjs";

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
  name: "PieChart",
  components: {
    Pie,
  },
  data() {
    return {
      chartData: {
        labels: ["Не подтвержденные", "Подтвержденные"],
        datasets: [
          {
            backgroundColor: ["#01409a", "#2488d4"],
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
    this.chartData.datasets[0].data.push(this.dashboard.users.unverifiedCount);
    this.chartData.datasets[0].data.push(this.dashboard.users.verifiedCount);
  },
};
</script>
