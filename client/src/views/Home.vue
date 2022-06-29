<template>
  <MainLayout>
    <template #leftColumn>
      <h1>Уважаемые жители Ставропольского края !</h1>
      <p>Предлагаем вам принять участие в беспрецендентном опросе</p>

      <el-button type="primary" @click="$router.push('/register')"
        >Пройти опрос</el-button
      >
    </template>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";

export default {
  components: {
    MainLayout,
  },
};
</script>
