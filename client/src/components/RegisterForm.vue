<template>
  <MainLayout>
    <template #leftColumn>
      <div class="description active">
        <span class="text"
          >Внимание! Для участия в голосовании необходимо
          зарегистрироваться.</span
        >
      </div>
    </template>

    <template #body>
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

        <el-form-item
          :class="$style.formItem"
          required
          label="Фамилия"
          prop="surname"
        >
          <el-input
            v-model="formData.surname"
            clearable
            :disabled="isFormSubmit"
          />
        </el-form-item>

        <el-form-item :class="$style.formItem" required label="Имя" prop="name">
          <el-input
            v-model="formData.name"
            clearable
            :disabled="isFormSubmit"
          />
        </el-form-item>

        <el-form-item
          :class="$style.formItem"
          label="Отчество"
          prop="patronymic"
        >
          <el-input
            v-model="formData.patronymic"
            clearable
            :disabled="isFormSubmit"
          />
        </el-form-item>

        <el-form-item
          :class="$style.formItem"
          required
          label="Телефон"
          prop="phone"
        >
          <el-input
            placeholder="+7(999)9999999"
            v-maska="'+7(###)#######'"
            v-model="formData.phone"
            clearable
            :disabled="isFormSubmit"
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
    </template>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/MainLayout";
import PhoneValidateDialog from "./dialogs/PhoneValidateDialog";

export default {
  components: {
    MainLayout,
    PhoneValidateDialog,
  },

  data() {
    return {
      isLoading: false,
      isFormSubmit: false,

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

        const { data } = await this.$axios.post("/registration", {
          fullName: this.formData.fullName,
          name: this.formData.name,
          surname: this.formData.surname,
          patronymic: this.formData.patronymic,
          phone: this.formData.phone,
        });

        localStorage.setItem("token", data.token);

        this.isFormSubmit = true;
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
