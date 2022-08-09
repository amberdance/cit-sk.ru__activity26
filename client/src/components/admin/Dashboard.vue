<template>
  <div class="dashboard">Nothing yet</div>
</template>

<script>
export default {
  async created() {
    const response = await this.$http.get("/admin/dashboard");

    console.log(response);
  },
};
</script>
