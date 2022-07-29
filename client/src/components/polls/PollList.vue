<template>
  <MainLayout>
    <div class="container">
      <div class="polls">
        <div class="filter_wrapper">
          <el-radio-group v-model="filter" @change="getPolls">
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
            :skeleton-count="countPerPage"
            :visible="isLoading"
          />
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
      pageNumber: 1,
      countPerPage: 10,
    };
  },

  async created() {
    await this.getPolls();
  },

  methods: {
    async getPolls() {
      try {
        this.isLoading = true;

        this.polls = await this.$http.get("/polls", {
          limit: this.countPerPage,
          pageNumber: this.pageNumber,
          filter: this.filter,
        });
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
</style>
