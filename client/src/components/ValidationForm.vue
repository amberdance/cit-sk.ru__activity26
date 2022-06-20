<template>
  <MainLayout>
    <template #leftColumn>
      Для участия в опросе сперва необходимо пройти процедуру смс-валидации
    </template>

    <template #rightColumn>
      <el-form
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
          <p>Поля, отмеченные *, обязательны для заполнения.</p>
        </div>

        <div class="d-flex">
          <el-form-item
            :class="$style.formItem"
            required
            label="ФИО"
            prop="fullName"
          >
            <el-input v-model="formData.fullName" clearable />
          </el-form-item>

          <el-form-item
            :class="$style.formItem"
            required
            label="Телефон"
            prop="phone"
          >
            <el-input
              placeholder="+7 (999) 999-99-99"
              v-maska="'+7 (###) ###-##-##'"
              v-model="formData.phone"
              clearable
            />
          </el-form-item>
        </div>

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
          <el-button type="primary" size="default" @click="formInitialize"
            >Получить смс</el-button
          >
        </div>
      </el-form>
    </template>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/MainLayout";

export default {
  components: {
    MainLayout,
  },

  data() {
    return {
      formData: {
        fullName: null,
        phone: null,
        policyAgree: [],
      },

      rules: {
        fullName: [
          {
            required: true,
            message: "Укажите ФИО",
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
    async formInitialize() {
      await this.$refs.form.validate();
      await this.getSmsCode();
    },

    async getSmsCode() {
      try {
        const data = await this.$axios.get("/validate", {
          params: {
            fullName: this.formData.fullName,
            phone: this.formData.phone,
          },
        });

        console.log(data);
      } catch (e) {
        console.error(e);
      }
    },
  },
};
</script>

<style module>
.formWrapper {
  width: 1250px;
  margin: 15% auto;
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
