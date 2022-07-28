<template>
  <div class="counters">
    <div class="container-sm">
      <div class="counters_wrapper">
        <div v-for="(count, key) in counters" :key="key" class="counter">
          <div class="meta">
            <AnimatedNumber
              class="count"
              :value="count"
              :round="1"
              :duration="200"
            ></AnimatedNumber>
            <span class="label">{{ labels[key] }}</span>
          </div>
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
      counters: {},
      labels: {
        usersCount: "Активных граждан",
        passedPollsCount: "Принято мнений",
        pollsCount: "Всего опросов",
      },
    };
  },

  async created() {
    try {
      this.counters = await this.$http.get("/pages/main/counters");
    } catch (e) {
      console.error(e);
    }
  },
};
</script>

<style scoped>
.counters {
  background-color: var(--color-primary);
}
.counters_wrapper {
  min-height: 110px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  text-align: center;
  text-transform: lowercase;
  flex-wrap: wrap;
  color: var(--color-font--secondary);
}
.counter {
  flex-grow: 1;
  display: flex;
  transform: skewX(-10deg);
  align-items: center;
  justify-content: center;
}
.counter:not(:last-child) {
  border-right: 3px solid #00000015;
  border-radius: 15px;
}
.counter .meta {
  transform: skewX(10deg);
  display: flex;
  flex-direction: column;
  line-height: 1;
}
.counters_wrapper .count {
  font-size: 44px;
}
.counters_wrapper .label {
  font-size: 18px;
}
</style>
