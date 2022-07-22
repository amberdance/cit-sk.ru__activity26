<template>
  <div>
    <MainLayout :class="$style.root">
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

        <div :class="[$style.quotation_wrapper]">
          <div class="container">
            <div :class="$style.quotation__title">
              <q>{{ quote.title }}</q>
            </div>

            <div :class="$style.quotation__subtitle">{{ quote.author }}</div>
          </div>
        </div>
      </div>
    </MainLayout>
    <Statistics />
    <News />
    <PollsList id="polls" />
  </div>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";
import Statistics from "@/components/Statistics.vue";
import News from "@/components/News";
import PollsList from "@/components/polls/PollsList";
import { getRandomQuote } from "@/utils/common.js";
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

      quote: {
        title: "",
        author: "",
      },
    };
  },

  async mounted() {
    this.quote = await getRandomQuote();
  },
};
</script>

<style module>
.root {
  min-height: calc(100vh - 110px);
}
.main_wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-top: 10rem;
}
.main_title {
  width: 100%;
  font-size: 50px;
  font-weight: bold;
  margin-bottom: 1rem;
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

.quotation_wrapper {
  position: absolute;
  top: calc(100vh - 230px);
  font-weight: bold;
  width: 100%;
}
.quotation__title {
  font-size: 20px;
  font-style: italic;
  quotes: "«" "»";
  text-align: center;
}
.quotation__title,
.quotation__subtitle {
  color: #7c4b02;
  text-align: center;
}
.quotation__subtitle {
  font-size: 18px;
  margin-top: 0.5rem;
}
.quotation__subtitle::before {
  content: "\00a9";
  margin-right: 5px;
}

@media (max-height: 790px) {
  .main_wrapper {
    margin-top: 0;
  }
  .root {
    min-height: 100vh;
  }
  .quotation_wrapper {
    top: calc(100vh - 110px);
  }
}

@media (min-height: 900px) {
  .main_wrapper {
    margin-top: 10rem;
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
