<template>
  <div :class="$style.background">
    <div :class="$style.overlay"></div>
    <div :class="$style.content">
      <el-row>
        <el-col :xs="10" :md="12" :sm="10" :lg="5">
          <div :class="$style.heading">
            <div :class="$style.headingContent">
              <h1>Уважаемые жители Ставропольского края!</h1>
              <p>Предлагаем вам принять участие в беспрецендентном опросе</p>
              <div class="a-center">
                <el-button type="primary" @click="changeFormVisible"
                  >Пройти опрос</el-button
                >
              </div>
            </div>
          </div>
        </el-col>

        <el-col :span="19" :class="$style.formWrapper">
          <el-form
            v-if="isFormHidden"
            :class="$style.formInner"
            :rules="rules"
            :model="formData"
            ref="form"
            label-position="top"
            size="large"
          >
            <div :class="$style.inputWrapper">
              <div :class="$style.policyText">
                <p>
                  Информация о персональных данных авторов обращений,
                  направленных в электронном виде, хранится и обрабатывается с
                  соблюдением требований российского законодательства о
                  персональных данных. Поля, отмеченные *, обязательны для
                  заполнения.
                </p>
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
                    placeholder="+7 (999) ___-__-__"
                    v-maska="'+7 (###) ###-##-##'"
                    v-model="formData.phone"
                    clearable
                  />
                </el-form-item>
              </div>

              <p style="font-size: 30px">
                <el-form-item prop="policyAgree">
                  <el-checkbox
                    v-model="formData.policyAgree"
                    label="Сообщаю, что даю своё согласие на обработку моих персональных
                данных, в соответствии с требованиями федерального закона от
                27.07.2006 № 152-ФЗ 'О персональных данных'"
                  >
                  </el-checkbox>
                </el-form-item>
              </p>
            </div>

            <div class="a-right">
              <el-button type="primary" size="default" @click="formInitialize"
                >Подтвердить</el-button
              >
            </div>
          </el-form>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isFormHidden: true,

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
            message: "Укажите Телефон",
          },
        ],

        policyAgree: [
          {
            required: true,
            message: "Подтвердите ознакомление",
            trigger: "change",
          },
        ],
      },
    };
  },

  methods: {
    changeFormVisible() {
      this.isFormHidden = !this.isFormHidden;
    },

    async formInitialize() {
      console.log(this.formData);
      await this.$refs.form.validate();
    },
  },
};
</script>

<style module>
.background {
  background-image: url("../assets/bg.webp");
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-size: cover;
}
.overlay {
  background-color: #ffffff;
  height: 100%;
  opacity: 0.5;
  position: fixed;
  width: 100%;
}
.content {
  position: relative;
}

.heading {
  background-color: #259942cc;
  display: flex;
  flex-direction: column;
  height: 100vh;
  padding: 1rem;
  border-right: 4px #ffffff solid;
  color: #ffffff;
}

.heading h1 {
  font-size: 30px;
}

.headingContent {
  font-size: 18px;
  padding: 1rem;
  margin-top: 20vh;
}

.headingContent button {
  border: none;
  color: #ffffff;
  padding: 1.5rem;
  width: 100%;
  font-weight: bold;
}

.formWrapper {
  display: flex;
  background-color: #ffffffcf;
}

.formInner {
  width: 1250px;
  margin: 5% auto;
}

.formInner label,
.policyText {
  font-size: 30px;
  font-size: 22px;
  color: #4c4c4c;
}

.formItem {
  margin-top: 1rem;
  min-width: 50%;
}
</style>
