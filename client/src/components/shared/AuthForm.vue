<template>
  <div :class="['auth_wrapper', 'rounded', isShadowed]">
    <div class="auth_content">
      <div class="title">
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
            v-if="isLoginEmail"
            v-model="formData.login"
            placeholder="email"
            autofocus
            prefix-icon="el-icon-user"
            clearable
          />
          <el-input
            v-else
            v-model="formData.login"
            prefix-icon="el-icon-phone"
            type="tel"
            clearable
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

        <el-switch
          v-model="isLoginEmail"
          @change="changeLoginType"
          class="mt-3 mb-3 w-100"
          active-text="Вход по email"
          inactive-text="Вход по номеру телефона"
        ></el-switch>
        <el-button
          type="primary"
          style="width: 100%"
          :loading="isLoading"
          @click="authorize"
          >Войти</el-button
        >
      </el-form>

      <div class="footer rounded">
        <div class="d-flex flex-column align-center">
          <span style="font-weight: bold"> Забыли пароль? </span>
          <router-link to="/recovery">Восстановить доступ</router-link>
        </div>

        <div class="d-flex flex-column align-center mt-3">
          <span style="font-weight: bold"> Нет аккаунта? </span>
          <router-link to="/registration">Зарегистрироваться</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { emailValidator, phoneNumberValidator } from "@/utils/validator";
import { mask } from "vue-the-mask";

export default {
  props: {
    title: {
      type: String,
      default: "Для участия в опросе вам необходимо авторизоваться",
    },
  },

  directives: { mask },

  data() {
    return {
      isLoading: false,
      isLoginEmail: true,

      formData: {
        login: null,
        password: null,
      },

      formRules: {
        login: [
          {
            trigger: "blur",
            validator: (rule, value, callback) => {
              if (this.isLoginEmail)
                emailValidator(value)
                  ? callback()
                  : callback(new Error("Укажите адрес электронной почты"));
              else
                phoneNumberValidator(value)
                  ? callback()
                  : callback(
                      new Error("Укажите номер телефона в формате +79999999999")
                    );
            },
          },
        ],

        password: [
          {
            required: "true",
            trigger: "blur",
            message: "Укажите пароль",
          },
        ],
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
        this.$store.commit("setState", { key: "user", value: data.user });
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

    changeLoginType() {
      this.$refs.form.resetFields();
      this.$refs.form.clearValidate();
      this.formData.login = null;
    },
  },
};
</script>

<style scoped>
.auth_wrapper {
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 0 3rem;
}
.auth_wrapper .title {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.auth_wrapper .title {
  display: flex;
  align-items: center;
  margin: 1rem 0;
}
.auth_wrapper .title span {
  font-size: 18px;
  font-weight: bold;
  color: var(--color-font--primary);
}
.auth_wrapper .footer {
  margin: 1.5rem 0;
  padding: 1rem;
}
</style>
