<template>
  <div class="bar_wrapper">
    <div class="bar_data">
      <div class="title">Посетители сайта</div>
      <div class="result">125 000</div>
    </div>
    <Bar
      :chart-options="chartOptions"
      :chart-data="chartData"
      class="canvas_wrapper"
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
  name: "BarChart",
  components: { Bar },
  data() {
    return {
      chartData: {
        labels: ["пн", "вт", "ср", "чт", "пт", "сб", "вс"],
        datasets: [
          {
            label: "Посетители сайта",
            backgroundColor: "#2488d4",
            data: [10000, 9400, 12000, 10000, 13000, 8000, 15000],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },
    };
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
