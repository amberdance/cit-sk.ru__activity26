<template>
  <PostsListBase heading="Опросы" :posts="polls" :loading="isLoading" />
</template>

<script>
import PostsListBase from "../shared/PostsListBase";

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
    polls() {
      return this.$store.getters.list("polls");
    },
  },

  async created() {
    if (!_.isEmpty(this.polls)) return;

    try {
      this.isLoading = true;
      await this.$store.dispatch("loadPolls", { limit: 4 });
    } catch (e) {
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
