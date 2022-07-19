<template>
  <MainLayout>
    <div class="container">
      <el-form
        :class="$style.registration_wrapper"
        :rules="rules"
        :model="formData"
        :hide-required-asterisk="true"
        ref="form"
        size="large"
        label-position="left"
      >
        <div
          :class="[$style.form_wrapper, 'rounded', 'shadowed']"
          v-loading="isLoading"
        >
          <div :class="$style.heading">Личные данные</div>
          <el-divider></el-divider>

          <div :class="$style.form_item">
            <el-form-item required label="Фамилия" prop="lastName">
              <el-input
                v-model="formData.lastName"
                clearable
                :disabled="isFormSubmitted"
              />
            </el-form-item>
            <div :class="$style.hint">
              Поле обязательно для заполнения. Используйте буквы русского
              алфавита.
            </div>
          </div>

          <div :class="$style.form_item">
            <el-form-item required label="Имя" prop="firstName">
              <el-input
                v-model="formData.firstName"
                clearable
                :disabled="isFormSubmitted"
              />
            </el-form-item>
            <div :class="$style.hint">
              Поле обязательно для заполнения. Используйте буквы русского
              алфавита.
            </div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Отчество" prop="patronymic">
              <el-input
                v-model="formData.patronymic"
                clearable
                :disabled="isFormSubmitted"
              />
            </el-form-item>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Дата рождения" prop="birthday">
              <el-input
                v-model="formData.birthday"
                clearable
                v-mask="'##.##.####'"
                placeholder="12.12.1993"
                :disabled="isFormSubmitted"
              />
            </el-form-item>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Адрес проживания" prop="address">
              <el-input
                v-model="formData.address"
                clearable
                :disabled="isFormSubmitted"
              />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Телефон" prop="phone">
              <el-input
                v-model="formData.phone"
                v-mask="'+7(###)#######'"
                placeholder="+7(999)9999999"
                type="tel"
                clearable
                :disabled="isFormSubmitted"
              />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>
        </div>

        <div
          :class="[$style.form_wrapper, 'rounded', 'shadowed']"
          v-loading="isLoading"
        >
          <div :class="$style.heading">Данные аккаунта</div>
          <el-divider></el-divider>

          <div :class="$style.form_item">
            <el-form-item label="Электронная почта" prop="email">
              <el-input
                v-model="formData.email"
                clearable
                :disabled="isFormSubmitted"
                type="email"
                autocomplete="off"
              />
            </el-form-item>
            <div :class="$style.hint">
              Поле обязательно для заполнения. <br />
              Буквы только латинского алфавита.
            </div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Пароль" prop="password">
              <el-input
                v-model="formData.password"
                clearable
                :disabled="isFormSubmitted"
                show-password
                prefix-icon="el-icon-lock"
                type="password"
                autocomplete="off"
              />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>

          <div :class="$style.form_item">
            <el-form-item label="Повторите пароль" prop="confirmPassword">
              <el-input
                v-model="formData.confirmPassword"
                clearable
                :disabled="isFormSubmitted"
                show-password
                prefix-icon="el-icon-lock"
                type="password"
                autocomplete="off"
              />
            </el-form-item>
            <div :class="$style.hint">Поле обязательно для заполнения.</div>
          </div>

          <el-divider></el-divider>
          <div :class="$style.policy_text">
            <p>
              Нажимая кнопку "Зарегистрироваться" вы соглашаетесь с
              <a href="#">условиями использования</a>
            </p>
          </div>

          <div class="a-right">
            <el-button
              type="primary"
              :disabled="isFormSubmitted"
              @click="submit"
              >Зарегистрироваться
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
import PhoneVerifyDialog from "@/components/dialogs/PhoneVerifyDialog";
import { mask } from "vue-the-mask";
import {
  passwordStrengthValidator,
  matchPasswordsValidator,
  phoneNumberValidator,
  emailValidator,
  birthdatValidator,
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
        firstName: null,
        lastName: null,
        districtId: 0,
        address: null,
        birthday: null,
        patronymic: null,
        phone: null,
        email: null,
        password: null,
        confirmPassword: null,
      },

      rules: {
        firstName: [
          {
            required: true,
            message: VALIDATE_DEFAULT_ERROR,
          },
        ],

        lastName: [
          {
            required: true,
            message: VALIDATE_DEFAULT_ERROR,
          },
        ],

        address: [
          {
            required: true,
            message: VALIDATE_DEFAULT_ERROR,
          },
        ],

        birthday: [
          {
            required: true,
            validator: (rule, birthday, callback) =>
              birthdatValidator(birthday)
                ? callback()
                : callback(new Error("Укажите дату рождения")),
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
          firstName: this.formData.firstName,
          lastName: this.formData.lastName,
          patronymic: this.formData.patronymic,
          districtId: this.formData.districtId || 66,
          birthday: this.formData.birthday,
          address: this.formData.address,
          phone: this.formData.phone,
          email: this.formData.email,
          password: this.formData.password,
          confirmPassword: this.formData.confirmPassword,
        });

        this.isFormSubmitted = true;
        this.$refs.dialog.show(uuid);
      } catch (e) {
        if (e.code == 422)
          return this.$onWarning("Не все поля заполнены корректно");

        if (e.code == 1062)
          if (e.message.includes("mail"))
            return this.$onWarning(
              "Такой адрес электронной почты уже зарегистрирован"
            );
        if (e.message.includes("phone"))
          return this.$onWarning("Такой номер телефона уже зарегистрирован");

        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style module>
.form_wrapper {
  background-color: #ffffff;
  padding: 2rem 2rem;
  margin-bottom: 25px;
}

.heading {
  font-size: 26px;
  margin-bottom: 10px;
  font-weight: bold;
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
  font-weight: bold;
  max-width: 300px;
  margin-left: 20px;
  font-size: 14px;
}

.form_item input {
  width: 100%;
  margin-bottom: 1rem;
}

@media (max-width: 590px) {
  .form_item {
    display: block;
  }

  .form_item {
    margin-bottom: 1rem;
  }
  .hint {
    max-width: unset;
  }
  .hint,
  .form_item input {
    margin: 0;
  }
}
</style>
