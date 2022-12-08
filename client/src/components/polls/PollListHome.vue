<template>
  <PostsListBase heading="Опросы" :posts="polls" :visible="isLoading">
    <template #footer>
      <div class="d-flex justify-center mt-3">
        <el-button
          type="primary"
          style="font-size: 16px"
          @click="$router.push('/polls')"
          >Все опросы
        </el-button>
      </div>
    </template>
  </PostsListBase>
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
      return this.$store.getters.list("polls").sort((a, b) => a.sort - b.sort);
    },
  },

  async created() {
    if (!_.isEmpty(this.polls)) return;

    try {
      this.isLoading = true;
      await this.$store.dispatch("loadPolls", {
        filter: "available",
        limit: 4,
      });
    } catch (e) {
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
