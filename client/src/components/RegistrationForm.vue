<template>
  <MainLayout>
    <el-form
      v-loading="isLoading"
      :class="$style.formWrapper"
      :rules="rules"
      :model="formData"
      ref="form"
      label-position="top"
      size="large"
    >
      <div :class="$style.policyText">
        <p>
          Информация, направленная в электронном виде, хранится и обрабатывается
          с соблюдением требований российского законодательства о персональных
          данных.
        </p>
        <p>
          Поля, отмеченные
          <span style="color: var(--el-color-danger)">*</span>, обязательны для
          заполнения.
        </p>
      </div>

      <el-form-item
        :class="$style.formItem"
        required
        label="Фамилия"
        prop="surname"
      >
        <el-input
          v-model="formData.surname"
          clearable
          :disabled="isFormSubmitted"
        />
      </el-form-item>

      <el-form-item :class="$style.formItem" required label="Имя" prop="name">
        <el-input
          v-model="formData.name"
          clearable
          :disabled="isFormSubmitted"
        />
      </el-form-item>

      <el-form-item :class="$style.formItem" label="Отчество" prop="patronymic">
        <el-input
          v-model="formData.patronymic"
          clearable
          :disabled="isFormSubmitted"
        />
      </el-form-item>

      <el-form-item :class="$style.formItem" label="Телефон" prop="phone">
        <el-input
          v-model="formData.phone"
          v-mask="'+7(###)#######'"
          placeholder="+7(999)9999999"
          type="tel"
          clearable
          :disabled="isFormSubmitted"
        />
      </el-form-item>

      <el-form-item :class="$style.formItem" label="Логин" prop="login">
        <el-input
          v-model="formData.login"
          clearable
          :disabled="isFormSubmitted"
        />
      </el-form-item>

      <el-form-item :class="$style.formItem" label="Пароль" prop="password">
        <el-input
          v-model="formData.password"
          clearable
          :disabled="isFormSubmitted"
          type="password"
        />
      </el-form-item>

      <el-form-item size="large" prop="policyAgree" required>
        <p>
          <el-checkbox
            v-model="formData.policyAgree"
            label="Я соглашаюсь на обработку моих персональных
                данных, в соответствии с требованиями федерального закона от
                27.07.2006 № 152-ФЗ 'О персональных данных'"
          >
          </el-checkbox>
        </p>
      </el-form-item>

      <div class="a-right">
        <el-button type="primary" size="default" @click="submit"
          >Подтвердить</el-button
        >
      </div>
    </el-form>
    <PhoneValidateDialog ref="dialog" />
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import PhoneValidateDialog from "./dialogs/PhoneValidateDialog";
import { mask } from "vue-the-mask";

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
        surname: null,
        name: null,
        patronymic: null,
        phone: null,
        policyAgree: [], // с boolean работает неккоректно
      },

      rules: {
        surname: [
          {
            required: true,
            message: "Обязательное поле",
          },
        ],

        name: [
          {
            required: true,
            message: "Обязательное поле",
          },
        ],

        login: [
          {
            required: true,
            message: "Обязательное поле",
          },
        ],

        password: [
          {
            required: true,
            message: "Обязательное поле",
          },
        ],

        phone: [
          {
            required: true,
            validator: (rule, val, callback) =>
              /(\+7)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})/g.test(
                val
              )
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

        const { token } = await this.$post("/users", {
          name: this.formData.name,
          surname: this.formData.surname,
          patronymic: this.formData.patronymic,
          phone: this.formData.phone,
          login: this.formData.login,
          password: this.formData.password,
        });

        $cookies.set("access_token", token);

        this.isFormSubmitted = true;
        this.$refs.dialog.show();
      } catch (e) {
        if (e.code == 30)
          return this.$onWarning(
            `Номер телефона ${this.formData.phone} был ранее зарегистрирован`,
            5500
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
.formWrapper {
  width: 1250px;
  margin: 20px auto;
  border: 1px solid #cfcfcf73;
  padding: 2rem;
  border-radius: 3px;
  background-color: #ffffff;
  box-shadow: 4px 4px 14px 1px lightgrey;
}

.formWrapper label,
.policyText {
  font-size: 22px;
  color: #4c4c4c;
}

.formItem {
  margin-top: 1rem;
  min-width: 50%;
}
</style>
