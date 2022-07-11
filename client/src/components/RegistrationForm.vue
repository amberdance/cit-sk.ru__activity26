<template>
  <MainLayout>
    <div class="container">
      <el-form :class="$style.registration_wrapper" :rules="rules" :model="formData" ref="form" size="large"
        :hide-required-asterisk="true">
        <div :class="$style.formWrapper" v-loading="isLoading">
          <div :class="$style.heading">Личные данные</div>

          <div :class="$style.form_item">
            <el-form-item required label="Фамилия" prop="surname">
              <el-input v-model="formData.surname" clearable :disabled="isFormSubmitted" />
            </el-form-item>
            <div :class="$style.hint">
              Поле обязательно для заполнения. Используйте буквы русского
              алфавита.
            </div>
          </div>

          <div :class="$style.form_item">
            <el-form-item required label="Имя" prop="name">
              <el-input v-model="formData.name" clearable :disabled="isFormSubmitted" />
            </el-form-item>
            <div :class="$style.hint">
              Поле обязательно для заполнения. Используйте буквы русского
              алфавита.
            </div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Отчество" prop="patronymic">
              <el-input v-model="formData.patronymic" clearable :disabled="isFormSubmitted" />
            </el-form-item>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Телефон" prop="phone">
              <el-input v-model="formData.phone" v-mask="'+7(###)#######'" placeholder="+7(999)9999999" type="tel"
                clearable :disabled="isFormSubmitted" />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>
        </div>

        <div :class="$style.formWrapper" v-loading="isLoading">
          <div :class="$style.heading">Данные аккаунта</div>

          <div :class="$style.form_item">
            <el-form-item label="Электронная почта" prop="email">
              <el-input v-model="formData.email" clearable :disabled="isFormSubmitted" type="email"
                autocomplete="off" />
            </el-form-item>
            <div :class="$style.hint">
              Поле обязательно для заполнения. <br />
              Буквы только латинского алфавита.
            </div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Пароль" prop="password">
              <el-input v-model="formData.password" clearable :disabled="isFormSubmitted" show-password
                prefix-icon="el-icon-lock" type="password" autocomplete="off" />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Повторите пароль" prop="confirmPassword">
              <el-input v-model="formData.confirmPassword" clearable :disabled="isFormSubmitted" show-password
                prefix-icon="el-icon-lock" type="password" autocomplete="off" />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>
          <div :class="$style.policy_text">
            <p>
              Нажимая кнопку "Зарегистрироваться" вы соглашаетесь
              с <a href="#">условиями использования</a>
            </p>
          </div>


          <div class="a-right">
            <el-button type="primary" size="default" :disabled="isFormSubmitted" @click="submit">Зарегистрироваться
            </el-button>
          </div>
        </div>

      </el-form>
    </div>

    <PhoneVerifyDialog ref="dialog" />
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import PhoneVerifyDialog from "./dialogs/PhoneVerifyDialog";
import { mask } from "vue-the-mask";
import {
  passwordStrengthValidator,
  matchPasswordsValidator,
  phoneNumberValidator,
  emailValidator,
} from "@/utils/validator";
import { VALIDATE_DEFAULT_ERROR } from "@/values";

export default {
  components: {
    MainLayout,
    PhoneVerifyDialog,
  },

  directives: { mask },

  data() {
    return {
      isLoading: false,
      isFormSubmitted: false,

      formData: {
        name: null,
        surname: null,
        patronymic: null,
        phone: null,
        email: null,
        password: null,
        confirmPassword: null,
        policyAgree: [],
      },

      rules: {
        name: [
          {
            required: true,
            message: VALIDATE_DEFAULT_ERROR,
          },
        ],

        surname: [
          {
            required: true,
            message: VALIDATE_DEFAULT_ERROR,
          },
        ],

        email: [
          {
            required: true,
            validator: (rule, email, callback) =>
              emailValidator(email)
                ? callback()
                : callback(new Error("Укажите адрес электронной почты")),
          },
        ],

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

        phone: [
          {
            required: true,
            validator: (rule, phone, callback) =>
              phoneNumberValidator(phone)
                ? callback()
                : callback(new Error("Укажите номер телефона")),
          },
        ],

        policyAgree: [
          {
            type: "array",
            required: true,
            message: "Подтвердите ознакомление",
            trigger: "change",
          },
        ],
      },
    };
  },

  methods: {
    async submit() {
      await this.$refs.form.validate();
      await this.registration();
    },

    async registration() {
      try {
        this.isLoading = true;

        const { uuid } = await this.$http.post("/users", {
          name: this.formData.name,
          surname: this.formData.surname,
          patronymic: this.formData.patronymic,
          phone: this.formData.phone,
          email: this.formData.email,
          password: this.formData.password,
          confirmPassword: this.formData.confirmPassword,
        });

        this.isFormSubmitted = true;
        this.$refs.dialog.show(uuid);
      } catch (e) {
        if (e.code == 422)
          return this.$onWarning("Заполните все обязательные поля");

        if (e.error == "The phone format is invalid.")
          return this.$onWarning("Некорректый номер телефона");

        if (e.code == 1062)
          return this.$onWarning(
            `Номер телефона ${this.formData.phone} был ранее зарегистрирован`
          );

        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style module>
.el-form {
  font-size: 10px;
}

.formWrapper {
  background-color: #ffffff;
  padding: 2rem 2rem;
  box-shadow: 4px 3px 7px 0px #80808045;
  border-radius: 15px;
  margin-bottom: 25px;
}

.heading {
  font-size: 26px;
  margin-bottom: 10px;
}

.registration_wrapper {
  max-width: 750px;
  margin: auto;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.registration_wrapper label {
  font-size: 18px;
  color: #333;
}

.policy_text {
  font-size: 16px;
  color: var(--color-font--primary);
}

.form_item {
  display: flex;
  flex-direction: row;
  align-items: center;
  color: #9ea4ac;
}

.hint {
  display: flex;
  max-width: 300px;
  margin-left: 20px;
  font-size: 14px;
}

.form_item input {
  width: 100%;
  margin-bottom: 1rem;
}
</style>
