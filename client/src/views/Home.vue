<template>
  <div :class="$style.pageWrapper">
    <MainLayout>
      <template #leftColumn>
        <h1>Уважаемые жители Ставропольского края!</h1>
        <p>Предлагаем вам принять участие в беспрецендентном опросе</p>

        <div :class="$style.menuWrapper">
          <!-- <el-button type="primary" @click="$router.push('/polls')"
            >Голосования</el-button
          >
          <el-button type="primary" @click="$router.push('/results')"
            >Результаты</el-button
          > -->
          <el-button type="primary" @click="$router.push('/register')"
            >Пройти опрос</el-button
          >
        </div>
      </template>
    </MainLayout>
  </div>
</template>

<script>
import MainLayout from "@/components/MainLayout.vue";

export default {
  components: {
    MainLayout,
  },
};
</script>

<style module>
.pageWrapper {
  width: 100%;
}

.menuWrapper button{
  margin: 0.2rem 0;
  margin-left: 0 !important;
}
</style>
