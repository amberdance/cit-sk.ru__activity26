<template>
  <div>
    <MainLayout style="min-height: calc(100vh - 110px)">
      <div :class="[$style.main_wrapper, 'container']">
        <div :class="$style.main_title">
          <h1>Уважаемые жители Ставропольского края!</h1>
        </div>

        <div :class="$style.divider"></div>
        <div :class="$style.main_subtitle">
          <h2>
            Aute pariatur eu laborum aliqua labore reprehenderit dolor et minim
            qui ea. Nulla incididunt incididunt velit amet aliquip sunt ullamco
            exercitation minim. Qui ea adipisicing culpa nostrud id enim mollit
          </h2>
        </div>

        <el-button
          :class="$style.button"
          type="primary"
          size="default"
          :disabled="isFormSubmitted"
          @click="$router.push('/vote')"
          >Пройти опрос
        </el-button>

        <div :class="[$style.quotation_wrapper, 'container']">
          <div :class="$style.quotation__title">
            <q>{{ quote.title }}</q>
          </div>

          <div :class="$style.quotation__subtitle">{{ quote.author }}</div>
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

  async mounted() {
    this.quote = await getRandomQuote();
  },
};
</script>

<style module>
.main_wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  flex-direction: column;
}

.main_wrapper h1 {
  margin: 0;
}

.main_wrapper h2 {
  margin: 0 0 2rem 0;
}

.main_title,
.main_subtitle {
  max-width: 830px;
  line-height: 30px;
}

.main_subtitle {
  margin: 0 auto;
}
.divider {
  width: 60%;
  margin: 1.5rem 0;
  border-bottom: 1px solid var(--color-divider);
}

.button {
  font-size: 22px;
}
.quotation_wrapper {
  position: absolute;
  top: calc(100vh - 230px);
  font-weight: bold;
}

.quotation__title {
  font-size: 20px;
  font-style: italic;
  quotes: "«" "»";
}
.quotation__subtitle {
  font-size: 18px;
  margin-top: 0.5rem;
}
.quotation__subtitle::before {
  content: "\00a9";
  margin-right: 5px;
}
</style>
