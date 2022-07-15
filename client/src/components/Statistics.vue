<template>
  <div :class="$style.statistic_wrapper">
    <div class="container" style="width: 100%">
      <div :class="$style.statistic_content">
        <div v-for="(item, i) in stats" :key="i">
          <AnimatedNumber
            :class="$style.count"
            :value="item.count"
            :round="1"
            :duration="200"
          ></AnimatedNumber>
          <div :class="$style.label">{{ item.label }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AnimatedNumber from "animated-number-vue";

export default {
  components: {
    AnimatedNumber,
  },

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

  async created() {
    try {
      const counters = await this.$http.get("/pages/main/counters");

      this.stats[0].count = counters.usersCount;
      this.stats[1].count = counters.passedPollsCount;
      this.stats[2].count = counters.pollsCount;
    } catch (e) {
      console.error(e);
    }
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
