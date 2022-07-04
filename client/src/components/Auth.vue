<template>
  <div :class="$style.root">
    <div :class="[$style.auth_wrapper, 'container']">
      <div :class="$style.title">
        Вход в информационную систему "{{ title }}"
      </div>

      <el-form ref="form" :model="formData" :show-message="false">
        <el-form-item prop="login" :rules="{ required: true, trigger: 'blur' }">
          <el-input
            v-model="formData.login"
            placeholder="логин"
            autofocus
            prefix-icon="el-icon-user"
          />
        </el-form-item>

        <el-form-item
          prop="password"
          :rules="{ required: true, trigger: 'blur' }"
        >
          <el-input
            type="password"
            v-model="formData.password"
            placeholder="пароль"
            prefix-icon="el-icon-lock"
            show-password
          />
        </el-form-item>

        <el-button
          type="primary"
          style="width: 100%"
          :loading="isLoading"
          @click="authorize"
          >Войти</el-button
        >
      </el-form>

      <div class="a-center m-1">
        Нет аккаунта?
        <router-link to="registration">Зарегистрироваться</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { APP_TITLE } from "@/values.js";

export default {
  data() {
    return {
      title: APP_TITLE,
      isLoading: false,

      formData: {
        login: null,
        password: null,
      },
    };
  },

  created() {
    if (this.$isAuthorized()) this.$router.push("/home");
  },

  methods: {
    async authorize() {
      await this.$refs.form.validate();

      this.isLoading = true;

      try {
        await this.$login(this.formData);

        this.$router.push("/home");
      } catch (e) {
        this.$cookies.remove("access_token");
        this.$cookies.remove("user");

        if ("config" in e && e.config.response.status == 401) {
          return this.$onError(
            "Не удалось войти с предоставленными учетными данными"
          );
        }

        this.$onError();
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style module>
.root {
  background-color: #dfe5e7;
  height: 100vh;
  display: flex;
  align-items: center;
}
.auth_wrapper {
  max-width: 450px;
  background-color: #efefef;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 0 3rem;
}

.title {
  font-size: 25px;
  font-weight: bold;
  text-align: center;
  margin: 1rem 0;
}
</style>
