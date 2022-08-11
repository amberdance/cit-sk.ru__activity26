<template>
  <div class="chart_wrapper w-100">
    <div class="chart_data">
      <div class="title">Населенных пунктов</div>
      <div class="chart_result">{{ dashboard.population.length }}</div>
    </div>
    <Bar
      class="canvas_wrapper h-90"
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
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: "y",
        scales: {
          x: {
            ticks: {
              display: false,
            },

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
