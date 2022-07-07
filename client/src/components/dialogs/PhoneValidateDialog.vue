<template>
  <el-dialog
    v-model="isVisible"
    :modal="false"
    :append-to-body="true"
    :close-on-click-modal="false"
    :lock-scroll="false"
    :show-close="false"
    width="30%"
    top="5%"
  >
    <el-form
      v-loading="isLoading"
      :class="$style.formWrapper"
      :rules="rules"
      :model="formData"
      ref="form"
      label-position="top"
      size="large"
    >
      <el-row type="flex" :gutter="20" class="align-center">
        <el-col :span="12">
          <el-form-item
            :class="$style.formItem"
            label="Последние 4 цифры номера телефона"
            prop="code"
          >
            <el-input
              v-model="formData.code"
              v-maska="'####'"
              clearable
              :disabled="attempsCount >= 5 || isVerifyCodeExhausted"
            />
          </el-form-item>

          <vue-countdown
            v-if="!isVerifyCodeExhausted"
            v-slot="{ minutes, seconds }"
            ref="countdown"
            tag="div"
            :class="$style.timer"
            :time="time"
            @end="onCountdownEnd"
          >
            Через 0{{ minutes }}:{{ formatTime(seconds) }} код можно запросить
            повторно
          </vue-countdown>

          <el-button
            type="primary"
            size="default"
            style="width: 100%"
            :loading="isLoading"
            @click="submit"
            >{{ buttonLabel }}</el-button
          ></el-col
        >

        <el-col :span="12">
          В течение нескольких секунд на Ваш телефон поступит звонок-сброс с
          уникального номера. Вам нужно ввести последние 4 цифры этого номера.

          <p>
            <span style="font-weight: bold; margin-right: 0.3rem">Пример:</span
            ><span>{{ getRandomInt() }}</span>
          </p></el-col
        >
      </el-row>
    </el-form>
  </el-dialog>
</template>

<script>
import { random } from "lodash";
import { incomeCallCodeValidator } from "@/utils/validator";

export default {
  data() {
    return {
      isVisible: false,
      isLoading: false,
      isVerifyCodeExhausted: false,
      attempsCount: 1,
      time: 299999,
      errorMessage: "Неверный код",

      formData: {
        code: "",
      },

      rules: {
        code: [
          {
            validator: (rule, code, callback) =>
              incomeCallCodeValidator(code)
                ? callback()
                : callback(new Error("Поле обязательно для заполнения")),
          },
        ],
      },
    };
  },

  computed: {
    buttonLabel() {
      return this.isVerifyCodeExhausted || this.attempsCount >= 5
        ? "Запросить код заново"
        : "Продолжить";
    },
  },

  methods: {
    async submit() {
      if (this.isVerifyCodeExhausted || this.attempsCount >= 5)
        await this.resetCode();
      else {
        await this.$refs.form.validate();
        await this.verifyCode();
      }
    },

    async verifyCode() {
      try {
        this.isLoading = true;

        await this.$http.get("/verify-code", {
          params: {
            token: localStorage.getItem("token"),
            code: this.formData.code,
          },
        });

        this.$router.push("/login");
      } catch (e) {
        if (e.code == 40) {
          this.isVerifyCodeExhausted = true;

          this.$onWarning("Код просрочен", 6000);
        }

        if (e.code == 50) {
          this.attempsCount = this.attempsCount + 1;

          this.$onWarning("Неверный код");
        }

        this.formData.code = "";
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },

    async resetCode() {
      try {
        this.isLoading = true;

        await this.$http.get("/reset-code", {
          params: { token: localStorage.getItem("token") },
        });

        this.resetCountdown();
      } catch (e) {
        if (e.code == 50) this.$onWarning("Неверный код", 6000);

        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },

    show() {
      this.isVisible = true;
    },

    onCountdownEnd() {
      this.isVerifyCodeExhausted = true;
    },

    resetCountdown() {
      this.time = 0;
      this.attempsCount = 1;

      setTimeout(() => {
        this.time = 299999;
        this.isVerifyCodeExhausted = false;

        setTimeout(() => {
          this.$refs.countdown.start();
        }, 0);
      }, 0);
    },

    formatTime(value) {
      return value < 10 ? "0" + value : value;
    },

    getRandomInt() {
      return random(1000, 9999);
    },
  },
};
</script>

<style module>
.formWrapper {
  border: 1px solid #cfcfcf73;
  padding: 2rem;
  border-radius: 3px;
  background-color: #ffffff;
}
.formContent {
  display: flex;
}
.formWrapper label {
  font-size: 22px;
  color: #4c4c4c;
}

.timer {
  width: 100%;
  margin: 1rem 0;
}
</style>
