<template>
  <MainLayout>
    <div class="container">
      <div class="results">
        <PostsListBase
          heading="Результаты опросов"
          :visible="isLoading"
          :posts="polls"
          :has-results="true"
        />
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import PostsListBase from "../shared/PostsListBase.vue";

export default {
  components: { PostsListBase, MainLayout },

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
.results {
  padding-bottom: 2rem;
  background-color: #ffffff;
}
</style>
