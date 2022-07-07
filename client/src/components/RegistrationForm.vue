<template>
  <MainLayout>
    <div class="container">
      <el-form
        v-loading="isLoading"
        :class="$style.registration_wrapper"
        :rules="rules"
        :model="formData"
        ref="form"
        size="large"
      >
        <div :class="$style.policy_text">
          <p>
            Информация, направленная в электронном виде, хранится и
            обрабатывается с соблюдением требований российского законодательства
            о персональных данных.
          </p>
          <p>
            Поля, отмеченные
            <span style="color: var(--el-color-danger)">*</span>, обязательны
            для заполнения.
          </p>
        </div>

        <div :class="$style.heading">Личные данные</div>

        <div :class="$style.form_item">
          <el-form-item required label="Фамилия" prop="surname">
            <el-input
              v-model="formData.surname"
              clearable
              :disabled="isFormSubmitted"
            />
          </el-form-item>
          <div :class="$style.hint">
            Поле обязательно для заполнения. Используйте буквы русского
            алфавита.
          </div>
        </div>

        <el-form-item
          :class="$style.form_item"
          required
          label="Имя"
          prop="name"
        >
          <el-input
            v-model="formData.name"
            clearable
            :disabled="isFormSubmitted"
          />
        </el-form-item>

        <el-form-item
          :class="$style.form_item"
          label="Отчество"
          prop="patronymic"
        >
          <el-input
            v-model="formData.patronymic"
            clearable
            :disabled="isFormSubmitted"
          />
        </el-form-item>

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
          <div :class="$style.hint">
            Поле обязательно для заполнения. Используйте буквы русского
            алфавита.
          </div>
        </div>

        <el-form-item
          :class="$style.form_item"
          label="Электронная почта"
          prop="email"
        >
          <el-input
            v-model="formData.email"
            clearable
            :disabled="isFormSubmitted"
          />
        </el-form-item>

        <div :class="$style.heading">Пароль</div>

        <el-form-item :class="$style.form_item" label="Пароль" prop="password">
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

        <el-form-item
          :class="$style.form_item"
          label="Повторите пароль"
          prop="checkPassword"
        >
          <el-input
            v-model="formData.checkPassword"
            clearable
            :disabled="isFormSubmitted"
            show-password
            prefix-icon="el-icon-lock"
            type="password"
            autocomplete="off"
          />
        </el-form-item>

        <el-form-item size="large" prop="policyAgree" required>
          <p>
            <el-checkbox
              v-model="formData.policyAgree"
              :disabled="isFormSubmitted"
              label="Я соглашаюсь на обработку моих персональных
                данных, в соответствии с требованиями федерального закона от
                27.07.2006 № 152-ФЗ 'О персональных данных'"
            >
            </el-checkbox>
          </p>
        </el-form-item>

        <div class="a-right">
          <el-button
            type="primary"
            size="default"
            :disabled="isFormSubmitted"
            @click="submit"
            >Подтвердить</el-button
          >
        </div>
      </el-form>
      <PhoneValidateDialog ref="dialog" />
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import PhoneValidateDialog from "./dialogs/PhoneValidateDialog";
import { mask } from "vue-the-mask";
import {
  passwordStrengthValidator,
  matchPasswordsValidator,
  phoneNumberValidator,
  emailValidator,
} from "@/utils/validator";

export default {
  components: {
    MainLayout,
    PhoneValidateDialog,
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
        checkPassword: null,
        policyAgree: [],
      },

      rules: {
        name: [
          {
            required: true,
            message: "Обязательное поле",
          },
        ],

        surname: [
          {
            required: true,
            message: "Обязательное поле",
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

        checkPassword: [
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
        });

        this.isFormSubmitted = true;
        this.$refs.dialog.show({
          uuid,
          phone: this.formData.phone,
        });
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
.registration_wrapper {
  max-width: 750px;
  margin: auto;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 1rem 3rem;
  box-shadow: 4px 3px 7px 0px #80808045;
}

.registration_wrapper label,
.policy_text {
  font-size: 20px;
  color: var(--color-font--primary);
}

.form_item {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
.form_item input {
  width: 50%;
  margin-bottom: 1rem;
}
</style>
