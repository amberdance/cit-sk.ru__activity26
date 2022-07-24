<template>
  <div :class="$style.statistic_wrapper">
    <div class="container">
      <div :class="$style.statistic_content">
        <div v-for="(count, key) in counters" :key="key">
          <AnimatedNumber
            :class="$style.count"
            :value="count"
            :round="1"
            :duration="200"
          ></AnimatedNumber>
          <div :class="$style.label">{{ labels[key] }}</div>
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
      labels: {
        usersCount: "Активных граждан",
        passedPollsCount: "Принято мнений",
        pollsCount: "Всего опросов",
      },
    };
  },

  computed: {
    counters() {
      return this.$store.getters.list("counters");
    },
  },

  async created() {
    if (!_.isEmpty(this.counters)) return;

    try {
      await this.$store.dispatch("loadCounters");
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
