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
import MainLayout from "./layouts/MainLayout.vue";
import { APP_TITLE } from "@/values.js";
import { emailValidator } from "@/utils/validator";

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
              emailValidator(email)
                ? callback()
                : callback(new Error("Укажите адрес электронной почты")),
          },
        ],

        password: [{ required: "true", trigger: "blur" }],
      },
    };
  },

  methods: {
    async authorize() {
      await this.$refs.form.validate();

      this.isLoading = true;

      try {
        const data = await this.$http.post("/auth/login", this.formData);

        $cookies.set("access_token", data.accessToken);

        this.$onSuccess("Спасибо, что Вы с нами", 3000);
        this.$store.commit("setUser", data.user);
        this.$router.push("/home");
      } catch (e) {
        if (e.response.status == 401)
          return this.$onError("Введен некорректный логин или пароль");

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
  text-align: center;
  margin: 1rem 0;
  color: var(--color-font--primary);
}
</style>
