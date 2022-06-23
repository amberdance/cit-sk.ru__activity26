<template>
  <MainLayout>
    <template #body>
      <div>VOTE WILL BE HERE</div>
    </template>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/MainLayout";

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
