<template>
  <div style="z-index: 100">
    <div :class="[$style.auth_wrapper, isShadowed, 'container', 'rounded']">
      <div :class="$style.title">
        <svg
          :class="$style.logo"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 941 930"
          style="enable-background: new 0 0 941 930"
          xml:space="preserve"
        >
          <path
            d="M914.5,428.6l-65.1-65.1c-11.2-11.2-29.2-11.3-40.5-0.3L701.8,467.2c-17.8,17.3-46.3,16.9-63.6-1l-18.8-19.4
	c-17.3-17.8-16.9-46.3,0.9-63.6l99.9-97c14.5-14,14.6-37.2,0.4-51.5L518.3,32.4C494.8,9,456.8,9,433.4,32.4L234.2,231.7
	c-14.4,14.4-14.2,37.8,0.4,52l102.6,99.5c17.8,17.3,18.3,45.8,1,63.6l-18.8,19.4c-17.3,17.8-45.8,18.3-63.6,1L146.6,361.3
	c-11.8-11.5-30.7-11.4-42.4,0.3l-67,67c-23.4,23.4-23.4,61.4,0,84.8l258.6,258.6c7,7,18.9,2,18.9-7.8V591.1
	c0-71.7,33.7-107.6,101.1-107.6h108.4c67.4,0,101.1,35.9,101.1,107.6v181c0,11.3,13.6,16.9,21.6,8.9l267.6-267.6
	C937.9,490,937.9,452.1,914.5,428.6z M471.9,399.1c-57.1,0.5-103.4-45.9-102.9-102.9c0.5-55.4,45.7-100.7,101.2-101.2
	c57.1-0.5,103.4,45.9,102.9,102.9C572.6,353.3,527.3,398.6,471.9,399.1z"
          />
          <path
            d="M509.9,571c0.9,1.9,1.3,4,1.3,6.3v176.8h-82.3V609c-0.6,2.9-0.8,5.9-0.8,9v145h84V571H509.9z"
          />
          <g id="Слой_2"></g>
          <path
            d="M477.5,757h-23c-16.8,0-30.5-13.7-30.5-30.5v-129c0-16.8,13.7-30.5,30.5-30.5h23c16.8,0,30.5,13.7,30.5,30.5
	v129C508,743.3,494.3,757,477.5,757z"
          />
          <path
            d="M467.3,923L467.3,923c-22.9,0-41.5-18.6-41.5-41.5v-39c0-11.3,9.2-20.5,20.5-20.5H487
	c11.3,0,20.5,9.2,20.5,20.5v40.3C507.5,905,489.5,923,467.3,923z"
          />
        </svg>

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
        <router-link to="/registration">Зарегистрироваться</router-link>
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
.auth_wrapper .logo {
  height: 110px;
  width: 110px;
  margin-bottom: 40px;
  margin-top: -50px;
}
</style>
