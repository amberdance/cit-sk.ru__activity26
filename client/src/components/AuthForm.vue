<template>
  <div style="z-index: 100">
    <div :class="[$style.auth_wrapper, isShadowed, 'container', 'bordered']">
      <div :class="$style.title">
        <img
          src="@/assets/logo_secondary.png"
          alt="logo_primary"
          :class="$style.logo"
        />
        <span>{{ title }}</span>
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
        <span style="font-weight: bold"> Нет аккаунта? </span>
        <router-link to="registration">Зарегистрироваться</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { emailValidator } from "@/utils/validator";

export default {
  props: {
    title: {
      type: String,
      default: "Для участия в опросе вам необходимо авторизоваться",
    },
  },

  data() {
    return {
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

  computed: {
    isShadowed() {
      return _.isEmpty(this.$parent.$refs) ? "shadowed" : "";
    },
  },

  methods: {
    async authorize() {
      await this.$refs.form.validate();

      this.isLoading = true;

      try {
        const data = await this.$http.post("/auth/login", this.formData);
        $cookies.set("access_token", data.accessToken);
        this.$store.commit("setUser", data.user);
        this.$emit("onSuccessfullAuth");
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
.title {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.title img {
  margin-top: -50px;
}

.auth_wrapper {
  max-width: 350px;
  min-height: 440px;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 0 3rem;
  margin-top: 50px;
}

.auth_wrapper .title {
  display: flex;
  align-items: center;
  margin: 1rem 0;
}
.auth_wrapper .title span {
  font-size: 18px;
  margin-left: 0.5rem;
  font-weight: bold;
  color: var(--color-font--primary);
}
.logo {
  max-height: 110px;
  width: auto;
  margin-bottom: 40px;
}
</style>
