<template>
  <el-dialog
    :visible="isVisible"
    :modal="false"
    :append-to-body="true"
    :close-on-click-modal="false"
    :lock-scroll="true"
    :show-close="false"
    :width="dialogWidth"
    top="5%"
  >
    <el-form
      v-loading="isLoading"
      :class="$style.form_wrapper"
      :rules="rules"
      :model="formData"
      ref="form"
      label-position="top"
      size="large"
    >
      <el-row
        type="flex"
        :gutter="20"
        class="align-center"
        style="flex-wrap: wrap"
      >
        <el-col :lg="12" :sm="22" :xs="22">
          <el-form-item
            :class="$style.formItem"
            label="Последние 4 цифры номера телефона"
            prop="code"
          >
            <el-input
              v-model="formData.code"
              v-mask="'####'"
              clearable
              :disabled="attempsCount >= 5 || isSmsExpired"
            />
          </el-form-item>

          <countdown
            v-if="!isSmsExpired"
            v-slot="{ minutes, seconds }"
            ref="countdown"
            tag="div"
            :class="$style.timer"
            :time="time"
            @end="onCountdownEnd"
          >
            Через 0{{ minutes }}:{{ formatTime(seconds) }} код можно запросить
            повторно
          </countdown>

          <el-button
            type="primary"
            size="default"
            style="width: 100%"
            :loading="isLoading"
            @click="submit"
            >{{ buttonLabel }}</el-button
          ></el-col
        >

        <el-col :lg="12" :sm="22" :xs="22" style="margin-top: 1rem">
          В течение нескольких секунд на Ваш телефон поступит звонок-сброс с
          уникального номера. Вам нужно ввести последние 4 цифры этого номера.

          <p>
            <span style="font-weight: bold; margin-right: 0.3rem">Пример:</span
            ><span>8951</span>
          </p></el-col
        >
      </el-row>
    </el-form>
  </el-dialog>
</template>

<script>
import { incomeCallCodeValidator } from "@/utils/validator";
import { mask } from "vue-the-mask";
import { VALIDATE_DEFAULT_ERROR } from "@/values";

export default {
  directives: { mask },

  data() {
    return {
      isVisible: true,
      isLoading: false,
      isSmsExpired: false,
      attempsCount: 1,
      time: 299999,

      formData: {
        code: "",
        uuid: null,
      },

      rules: {
        code: [
          {
            validator: (rule, code, callback) =>
              incomeCallCodeValidator(code)
                ? callback()
                : callback(new Error(VALIDATE_DEFAULT_ERROR)),
          },
        ],
      },
    };
  },

  computed: {
    buttonLabel() {
      return this.isSmsExpired || this.attempsCount >= 5
        ? "Запросить код повторно"
        : "Продолжить";
    },

    dialogWidth() {
      return document.body.offsetWidth <= 950 ? "80%" : "30%";
    },
  },

  methods: {
    async submit() {
      if (this.isSmsExpired || this.attempsCount >= 5) await this.resetCode();
      else {
        await this.$refs.form.validate();
        await this.verifyCode();
      }
    },

    async verifyCode() {
      try {
        this.isLoading = true;

        await this.$http.get("/registration/verify-code", {
          uuid: this.formData.uuid,
          code: this.formData.code,
        });

        this.$router.push("/login");
        this.$onSuccess(
          "Ваш профиль подтвержден, теперь вы можете авторизоваться для прохождения опросов"
        );
      } catch (e) {
        if (e.code == 10) {
          this.isSmsExpired = true;
          this.$onWarning("Код просрочен");
        }

        if (e.code == 11) {
          this.attempsCount = this.attempsCount + 1;
          this.$onWarning("Неверно указан код");
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

        await this.$http.get("/registration/reset-code", {
          uuid: this.formData.uuid,
        });

        this.resetCountdown();
      } catch (e) {
        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },

    show(uuid) {
      this.formData.uuid = uuid;
      this.isVisible = true;
    },

    onCountdownEnd() {
      this.formData.code = "";
      this.isSmsExpired = true;
    },

    resetCountdown() {
      this.time = 0;
      this.attempsCount = 1;

      setTimeout(() => {
        this.time = 299999;
        this.isSmsExpired = false;

        setTimeout(() => {
          this.$refs.countdown.start();
        }, 0);
      }, 0);
    },

    formatTime(value) {
      return value < 10 ? "0" + value : value;
    },
  },
};
</script>

<style module>
.form_wrapper {
  padding: 2rem;
}

.form_wrapper label {
  font-size: 22px;
  line-height: 30px;
  color: #4c4c4c;
}

.form_wrapper .timer {
  width: 100%;
  margin: 1rem 0;
}
</style>
