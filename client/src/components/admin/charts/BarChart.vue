<template>
  <div class="chart_wrapper shadowed">
    <div class="chart_heading shadowed">
      <div class="title">Населенных пунктов</div>
      <div class="chart_result">33</div>
    </div>
    <Bar
      class="canvas_wrapper"
      :styles="{ minHeight: '600px' }"
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
    population() {
      return this.$store.getters
        .get("dashboard")
        .population.filter(({ count }) => count > 20);
    },
  },

  created() {
    this.population.forEach(({ label, count }) => {
      this.chartData.labels.push(label);
      this.chartData.datasets[0].data.push(count);
    });
  },
};
</script>
