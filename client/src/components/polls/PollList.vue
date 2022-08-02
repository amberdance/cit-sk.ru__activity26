<template>
  <MainLayout>
    <div class="container">
      <div class="polls">
        <div class="filter_wrapper">
          <el-radio-group v-model="filter" @change="paginate">
            <el-radio-button class="shadowed" label="all"
              >Все опросы</el-radio-button
            >
            <el-radio-button class="shadowed" label="available"
              >Активные</el-radio-button
            >
            <el-radio-button class="shadowed" label="completed"
              >Завершенные</el-radio-button
            >
          </el-radio-group>
        </div>

        <div class="polls_wrapper">
          <PostsListBase
            heading="Опросы"
            :posts="polls"
            :skeleton-count="skeletonCount"
            :visible="isLoading"
          >
            <template #footer v-if="pagination.total !== polls.length">
              <div class="w-100 a-center mt-3">
                <el-button type="primary" @click="paginate(true)"
                  >Показать еще</el-button
                >
              </div></template
            >
          </PostsListBase>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import pagination from "@/mixins/pollsPagination.js";

export default {
  mixins: [pagination],
};
</script>
