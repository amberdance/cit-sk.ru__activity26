<template>
  <MainLayout>
    <div class="container">
      <div class="polls results">
        <PostsListBase
          heading="Результаты опросов"
          :visible="isLoading"
          :posts="polls"
          :has-results="true"
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
  </MainLayout>
</template>
<script>
import pagination from "@/mixins/pollsPagination.js";

export default {
  mixins: [pagination],
};
</script>
