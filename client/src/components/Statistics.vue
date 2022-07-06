<template>
  <div :class="$style.statistic_wrapper">
    <div :class="$style.statistic_content">
      <div v-for="(item, i) in stats" :key="i">
        <div :class="$style.value">{{ getRandom() }}</div>
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

  methods: {
    getRandom() {
      return _.random(999999);
    },
  },
};
</script>

<style module>
.statistic_wrapper {
  padding: 1.5rem 0;
  background-color: var(--color-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 4px 7px 6px #6d8491;
}
.statistic_content {
  min-width: 700px;
  display: flex;
  justify-content: space-between;
  line-height: 30px;
  align-items: center;
  color: var(--color-font--secondary);
  text-align: center;
  text-transform: lowercase;
  padding-top: 14px;
}

.statistic_content .value {
  font-size: 44px;
}
</style>
