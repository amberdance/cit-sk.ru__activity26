<template>
  <MainLayout>
    <AuthForm class="auth" :title="title" @onSuccessfullAuth="onAuthSuccess" />
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";
import AuthForm from "../components/AuthForm";
import { APP_TITLE } from "@/values.js";

export default {
  components: {
    MainLayout,
    AuthForm,
  },

  data() {
    return {
      title: "Вход в информационный ресурс " + APP_TITLE,
    };
  },

  methods: {
    onAuthSuccess() {
      this.$router.push("/home");
      this.$onSuccess("Теперь вы можете проходить опросы");
    },
  },
};
</script>
<style scoped>
.auth {
  max-width: 450px;
  min-height: 550px;
  margin: 5rem auto;
}
</style>
