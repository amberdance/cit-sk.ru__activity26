<template>
  <PostsListBase
    v-if="news.length"
    heading="Новости"
    :posts="news"
    :loading="isLoading"
  />
</template>

<script>
import PostsListBase from "./PostsListBase";

export default {
  components: {
    PostsListBase,
  },

  data() {
    return {
      isLoading: false,
    };
  },

  computed: {
    news() {
      return this.$store.getters.list("news");
    },
  },

  async created() {
    if (this.news.length) return;

    try {
      this.isLoading = true;
      await this.$store.dispatch("loadNews", { limit: 4 });
    } catch {
      this.$onError("Не удалось загрузить список новостей");
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
