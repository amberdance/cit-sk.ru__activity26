<template>
  <div>
    <MainLayout>
      <div :class="[$style.main, 'container']">
        <div :class="$style.main__title">
          <h1>Уважаемые жители Ставропольского края!</h1>
        </div>

        <div :class="$style.main__subtitle">
          <h2>
            Предлагаем вам принять участие в беспрецендентном опросе. Опрос
            прошел - душевное счастье обрел!
          </h2>
        </div>
        <div class="btn_primary" @click="$router.push('/vote')">
          Пройти опрос
        </div>

        <div :class="$style.quotation">
          <div :class="$style.quotation__title">
            <p>“{{ quote.title }}”</p>
          </div>
          <div :class="$style.quotation__subtitle">
            <p>© {{ quote.author }}</p>
          </div>
        </div>
      </div>
    </MainLayout>
    <Statistics />
  </div>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";
import Statistics from "@/components/Statistics.vue";
import { getRandomQuote } from "@/utils/common.js";
export default {
  components: {
    MainLayout,
    Statistics,
  },

  data() {
    return {
      quote: {
        title: "",
        author: "",
      },
    };
  },

  async created() {
    this.quote = await getRandomQuote();
  },
};
</script>

<style module>
.main {
  margin-top: 130px;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  flex-direction: column;
}

.main h1 {
  margin: 0px;
}

.main__title {
  max-width: 830px;
  margin-bottom: 40px;
}

.main__subtitle {
  max-width: 700px;
  line-height: 30px;
  margin: 0 auto;
}

.quotation {
  font-weight: 500;
  line-height: 1px;
  margin-top: 300px;
}

.quotation__title {
  font-size: 24px;
  line-height: 30px;
  font-style: italic;
}
.quotation__subtitle {
  font-size: 18px;
}
</style>
