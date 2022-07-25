<template>
  <MainLayout>
    <div :class="[$style.main_wrapper, 'container']">
      <div :class="$style.main_title">
        Уважаемые жители Ставропольского края!
      </div>

      <div :class="$style.main_subtitle">
        {{ description }}
      </div>

      <el-button
        style="font-size: 18px"
        class="m-1"
        type="primary"
        v-scroll-to="'#polls'"
        >Перейти к опросам
      </el-button>
    </div>

    <Statistics />
    <News id="news" />
    <PollsList id="polls" />
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";
import Statistics from "@/components/Statistics.vue";
import News from "@/components/News";
import PollsList from "@/components/polls/PollsList";
import { APP_DESCRIPTION } from "@/values";

export default {
  components: {
    MainLayout,
    Statistics,
    PollsList,
    News,
  },

  data() {
    return {
      description: APP_DESCRIPTION(),
    };
  },
};
</script>

<style module>
.main_wrapper {
  display: flex;
  align-items: center;
  flex-direction: column;
  min-height: 800px;
}
.main_title {
  width: 100%;
  font-size: 70px;
  line-height: 70px;
  font-weight: bold;
  margin-bottom: 2rem;
}

.main_title,
.main_subtitle {
  max-width: 1024px;
  text-align: center;
}
.main_subtitle {
  font-size: 25px;
  font-weight: bold;
}

@media (min-height: 900px) {
  .main_wrapper {
    margin-top: 5rem;
  }
}

@media (min-height: 1100px) {
  .main_wrapper {
    margin-top: 15rem;
  }
}

@media (max-width: 670px) {
  .main_title {
    font-size: 30px;
  }
  .quotation_wrapper {
    display: none;
  }
}
</style>
