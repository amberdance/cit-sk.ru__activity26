<template>
  <div class="bar_wrapper">
    <div class="bar_data">
      <div class="title">Населенные пункты</div>
      <div class="result">33</div>
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
  async created() {
    const response = await this.$http.get("/admin/dashboard");
    response.population.forEach(item => {
      console.log(item.label)
    });
  },

  name: "BarChart",
  components: { Bar },
  data() {
    return {
      chartData: {
        labels: [
          "Ставрополь",
          "Туруновский",
          "Районовский",
          "Тестовый",
          "Программистский",
          "Неважны",
          "Важный",
        ],
        datasets: [
          {
            label: "Количество голосов",
            backgroundColor: "#2488d4",
            data: [200, 32, 12, 100, 130, 800, 1500],
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
