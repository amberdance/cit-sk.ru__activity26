<template>
  <MainLayout>
    <div class="container-sm">
      <div class="recovery-form rounded shadowed">
        <div class="heading">Восстановление доступа</div>
        <el-divider />

        <div class="sub-heading">
          Допускаются буквы латинского алфавита, состоящие из 1 цифры, 3 букв в
          нижнем регистре, 2 букв в верхнем регистре.
        </div>

        <el-form
          :model="formData"
          :rules="rules"
          :hide-required-asterisk="true"
          ref="form"
          size="large"
          label-position="left"
        >
          <div class="form-content">
            <el-form-item prop="password">
              <div class="hint">Придумайте пароль для вашей учетной записи</div>
              <el-input
                v-model="formData.password"
                clearable
                show-password
                prefix-icon="el-icon-lock"
                type="password"
                autocomplete="off"
                placeholder="Пароль"
              ></el-input>
            </el-form-item>

            <el-form-item prop="confirmPassword">
              <div class="hint">Повторите пароль, чтобы не ошибиться</div>
              <el-input
                v-model="formData.confirmPassword"
                clearable
                show-password
                prefix-icon="el-icon-lock"
                type="password"
                autocomplete="off"
                placeholder="Повторите пароль"
              ></el-input>
            </el-form-item>

            <div class="w-100 mt-3 a-center">
              <el-button type="primary" v-loading="isLoading" @click="recover"
                >Восстановить доступ</el-button
              >
            </div>
          </div>
        </el-form>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import {
  passwordStrengthValidator,
  matchPasswordsValidator,
} from "@/utils/validator";

export default {
  components: { MainLayout },

  data() {
    return {
      isLoading: false,

      formData: {
        password: null,
        confirmPassword: null,
        uuid: null,
      },

      rules: {
        password: [
          {
            required: true,
            validator: (rule, password, callback) =>
              passwordStrengthValidator(password)
                ? callback()
                : callback(new Error("Слабый пароль")),
          },
        ],

        confirmPassword: [
          {
            required: true,
            validator: (rule, password, callback) =>
              matchPasswordsValidator(
                password,
                this.formData.password,
                callback
              ),
          },
        ],
      },
    };
  },

  methods: {
    async recover() {
      await this.$refs.form.validate();
      try {
        this.isLoading = true;
        await this.$http.post("/users/password-reset", {
          ...this.formData,
          uuid: this.$route.params.uuid,
        });

        this.$router.push("/login");
        this.$onSuccess(
          "Пароль успешно изменен. Теперь вы можете авторизоваться"
        );
      } catch (e) {
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.recovery-form {
  min-height: 500px;
  max-width: 460px;
  padding: 2rem;
  margin: auto;
  background-color: #ffffff;
}

.recovery-form .sub-heading {
  margin: 1rem 0;
  font-weight: bold;
  padding: 1rem 0 1rem 1rem;
  border-left: 3px solid var(--color-primary);
}
.recovery-form .hint {
  font-weight: bold;
  color: #9ea4ac;
}
</style>
