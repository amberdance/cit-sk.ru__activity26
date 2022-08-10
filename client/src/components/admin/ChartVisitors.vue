<template>
  <Bar 
  :chart-data="chartData"/>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      chartData: {
        labels: [ '1 января', '2 января', '3 января', '4 января', '5 января', '6 января', '7 января',],
        datasets: [
          {
            label: 'Посетители сайта',
            backgroundColor: '#25b38b',
            aspectRatio: '4',
            data: [10000, 9400, 12000, 10000, 13000, 8000, 15000],
          }
        ]
      },
      chartOptions: {
        aspectRatio: 5,
      }
    }
  }
}
</script>