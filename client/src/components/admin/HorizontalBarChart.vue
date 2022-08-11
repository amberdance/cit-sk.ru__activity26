<template>
  <div class="bar_wrapper" v-if="population">
    <div class="bar_data">
      <div class="title">Пользователи по регионам</div>
      <div class="result">{{ population.length }}</div>
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
          },
        ],
      },

      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: "y",
      },
    };
  },

  computed: {
    population() {
      return this.$store.getters.get("dashboard").population;
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

<style scoped>
.bar_wrapper {
  width: 49%;
  font-size: 16px;
  font-weight: 500;
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
  position: relative;
  background-color: #ffffff;
  padding: 1rem;
  min-height: 300px;
}
</style>
