<template>
<div>
  <MainLayout>
    <div class="main">
      <div class="main__title">
        <h1>Уважаемые жители Ставропольского края!</h1>
      </div>

      <div class="main__subtitle">
        <h2>
          Предлагаем вам принять участие в беспрецендентном опросе. Опрос прошел
          - душевное счастье нашел!
        </h2>
      </div>
      <button type="primary" @click="$router.push('/register')"
        >Пройти опрос</button>

      <div class="quotation">
        <div class="quotation__title">
          <p>“Владеть инициативой — значит иметь определённое преимущество”</p>
        </div>
        <div class="quotation__subtitle">
          <p>© Хосе Рауль Капабланка</p>
        </div>
      </div>
    </div>

    
  </MainLayout>
  <Statistics />
  <PollsList />
  </div>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";
import Statistics from "@/components/Statistics.vue";
import PollsList from "@/components/polls/PollsList.vue";

export default {
  components: {
    MainLayout,
    Statistics,
    PollsList,
  },
};
</script>

<style>
.el-container {
  flex-direction: column !important;
}

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
  margin-top: 200px;
}

.quotation__title {
  font-size: 24px;
  line-height: 30px;
}
.stats {
  display: block;
}
</style>
