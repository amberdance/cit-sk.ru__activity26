<template>
  <div :class="$style.statistic_wrapper">
    <div class="container" style="width: 100%">
      <div :class="$style.statistic_content">
        <div v-for="(item, i) in stats" :key="i">
          <div :class="$style.count">{{ getRandom() }}</div>
          <div :class="$style.label">{{ item.label }}</div>
        </div>
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
          count: 0,
        },
        {
          label: "Принято мнений",
          count: 0,
        },
        {
          label: "Пройдено опросов",
          count: 0,
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
  background-color: var(--color-primary);
}
.statistic_content {
  min-height: 110px;
  max-width: 700px;
  margin: auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  text-align: center;
  text-transform: lowercase;
  flex-wrap: wrap;
  color: var(--color-font--secondary);
}

.statistic_content .count {
  font-size: 44px;
}

.statistic_content .label {
  font-size: 18px;
}

@media (max-width: 590px) {
  .statistic_content {
    display: none;
  }
}
</style>
