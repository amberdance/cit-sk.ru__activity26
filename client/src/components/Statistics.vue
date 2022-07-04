<template>
  <div :class="$style.stats__wrapper">
    <div :class="$style.stats">
      <div v-for="(item, i) in stats" :key="i" :class="$style.stats__item">
        <div :class="$style.value">{{ item.count }}</div>
        <div :class="$style.title">{{ item.label }}</div>
      </div>
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
.stats__wrapper {
  min-height: 100px;
  background-color: #2c2c2c;
  display: flex;
  align-items: center;
  justify-content: center;
}
.stats {
  min-width: 700px;
  display: flex;
  justify-content: space-between;
  line-height: 30px;
  align-items: center;
  color: #ffffff;
  text-align: center;
  text-transform: lowercase;
  padding-top: 14px;
}

.stats__item {
}

.value {
  font-size: 44px;
}
</style>
