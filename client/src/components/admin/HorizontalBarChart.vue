<template>
  <div class="bar_wrapper">
    <div class="bar_data">
      <div class="title">Всего пользователей</div>
      <div class="result">{{ dashboard.users.totalCount }}</div>
    </div>
    <Bar
      class="canvas_wrapper"
      :chart-options="chartOptions"
      :chart-data="chartData"
    />
  </div>
</template>

<script>
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  components: { Bar },

  data() {
    return {
      chartData: {
        labels: [],

        datasets: [
          {
            label: "Пользователи по регионам",
            backgroundColor: "#2488d4",
            data: [],
            minBarLength: 2,
          },
        ],
      },

      chartOptions: {
        scales: {
          x: {
            grid: {
              display: false,
            },
          },
        },
      },
    };
  },

  computed: {
    dashboard() {
      return this.$store.getters.get("dashboard");
    },
  },

  created() {
    this.dashboard.population.forEach(({ label, count }) => {
      this.chartData.labels.push(label);
      this.chartData.datasets[0].data.push(count);
    });
  },
};
</script>

<style scoped>
.bar_wrapper {
  font-size: 16px;
  font-weight: 500;
  max-width: 950px;
}
.bar_data {
  background-color: #ffffff;
  padding: 1rem;
  margin-bottom: 0.5rem;
}

.result {
  font-size: 40px;
}
.canvas_wrapper {
  background-color: #ffffff;
  padding: 1rem;
}
</style>
