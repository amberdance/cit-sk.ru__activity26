<template>
  <MainLayout>
    <div class="container"></div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
export default {
  components: {
    MainLayout,
  },
  data() {
    return {
      isLoading: false,
      poll: {},
    };
  },
  async created() {
    try {
      this.isLoading = true;
      this.poll = await this.$http.get(`/polls/${this.$route.params.id}`);
    } catch (e) {
      if (e.code == 404) return this.$onError("Опрос не найден");
      this.$onError();
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },
  methods: {},
};
</script>
