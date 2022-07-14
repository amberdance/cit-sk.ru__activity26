<template>
  <MainLayout>
    <AuthForm :title="title" @onSuccessfullAuth="$router.push('/home')" />
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
};
</script>
