<template>
  <div :class="$style.pageWrapper">
    <MainLayout>
      <template #leftColumn>
        <p>Предлагаем вам принять участие в беспрецендентном опросе</p>

        <div class="a-center">
          <el-button type="primary" @click="$router.push('/validation')"
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
</style>
