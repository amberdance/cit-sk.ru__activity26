<template>
  <MainLayout>
    <template #body>
      <div>PollSingle</div>
    </template>
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
    };
  },

  methods: {},
};
</script>
