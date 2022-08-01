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
import MainLayout from "../layouts/MainLayout.vue";
import PostsListBase from "../shared/PostsListBase";

export default {
  components: {
    MainLayout,
    PostsListBase,
  },

  data() {
    return {
      isLoading: false,
      polls: [],
      filter: "all",
      skeletonCount: 4,

      pagination: {
        currentPage: 1,
        perPage: 4,
        total: 0,
      },
    };
  },

  async created() {
    await this.paginate();
  },

  methods: {
    async paginate(showMore = false) {
      try {
        this.isLoading = true;

        const params = {
          perPage: this.pagination.perPage,
          filter: this.filter,
        };

        if (showMore) params.page = this.pagination.currentPage;

        const response = await this.$http.get("/polls", params);

        this.pagination.total = response.total;
        this.skeletonCount += response.data.length;
        this.pagination.currentPage = response.nextPageUrl
          ? response.nextPageUrl.match(/page=(.*\d)/)[1]
          : null;

        showMore
          ? response.data.forEach((poll) => this.polls.push(poll))
          : (this.polls = response.data);
      } catch (e) {
        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.polls {
  background-color: #ffffff;
}
.polls_wrapper {
  padding-bottom: 2rem;
}
.filter_wrapper {
  padding: 1rem;
  text-align: right;
}

@media (max-width: 390px) {
  .footer button {
    width: 100%;
  }
}
</style>
