<template>
  <div :class="$style.stats">
    <div v-for="(item, i) in stats" :key="i" :class="$style.stats__item">
      <div class="value">{{ item.count }}</div>
      <div class="title">{{ item.label }}</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stats: [
        {
          label: "Активных граждан",
          count: 23000,
        },
        {
          label: "Прошло голосований",
          count: 1350,
        },
        {
          label: "Принято мнений",
          count: 100000,
        },
      ],
    };
  },
};
</script>

<style module>
.stats {
  background-color: rgb(82, 82, 82);
  display: flex;
  justify-content: center;
  align-items: center;
  color: #ffffff;
  text-align: center;
  min-height: 100px;
}

.stats__item {
}
</style>
