<template>
  <MainLayout>
    <div :class="[$style.auth_wrapper, 'container']">
      <div :class="$style.title">
        Вход в информационную систему "{{ title }}"
      </div>

      <el-form
        ref="form"
        :model="formData"
        :rules="formRules"
        :show-message="false"
      >
        <el-form-item prop="login">
          <el-input
            v-model="formData.login"
            placeholder="логин"
            autofocus
            prefix-icon="el-icon-user"
          />
        </el-form-item>

        <el-form-item prop="password">
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
        <span> Нет аккаунта? </span>
        <router-link to="registration">Зарегистрироваться</router-link>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { APP_TITLE } from "@/values.js";
import MainLayout from "./layouts/MainLayout.vue";
import { emailValidate } from "@/utils/common";

export default {
  components: {
    MainLayout,
  },

  data() {
    return {
      title: APP_TITLE,
      isLoading: false,

      formData: {
        login: null,
        password: null,
      },

      formRules: {
        login: [
          {
            trigger: "blur",
            validator: (rule, email, callback) =>
              emailValidate(email)
                ? callback()
                : callback(new Error("Укажите адрес электронной почты")),
          },
        ],
        password: [{ required: "true", trigger: "blur" }],
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
        if ("config" in e && e.config.response.status == 401) {
          return this.$onError(
            "Не удалось войти с предоставленными учетными данными"
          );
        }

        console.error(e);
        this.$onError();
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style module>
.auth_wrapper {
  max-width: 350px;
  min-height: 550px;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 0 3rem;
  box-shadow: 4px 3px 7px 0px #80808045;
}

.title {
  font-size: 25px;
  font-weight: bold;
  text-align: start;
  margin: 1rem 0;
  color: var(--color-font--primary);
}
</style>
