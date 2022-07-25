<template>
  <div :class="$style.counters">
    <div class="container-sm">
      <div :class="$style.counters_wrapper">
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
.counters {
  background-color: var(--color-primary);
}
.counters_wrapper {
  min-height: 110px;
  margin: auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  text-align: center;
  text-transform: lowercase;
  flex-wrap: wrap;
  color: var(--color-font--secondary);
}

.counters_wrapper .count {
  font-size: 44px;
}

.counters_wrapper .label {
  font-size: 18px;
}
</style>
