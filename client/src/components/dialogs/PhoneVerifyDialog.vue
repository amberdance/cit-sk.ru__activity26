<template>
  <el-dialog
    title="Последние 4 цифры номера телефона"
    :visible="isVisible"
    :append-to-body="true"
    :close-on-click-modal="false"
    :lock-scroll="true"
    :show-close="false"
    :width="dialogWidth"
    custom-class="rounded"
    top="5%"
  >
    <el-form
      v-loading="isLoading"
      class="form_wrapper"
      :rules="rules"
      :model="formData"
      ref="form"
      label-position="top"
      size="large"
    >
      <div class="row">
        <div class="column col-xl-6 col-md-12 col-sm-12">
          <el-form-item prop="code">
            <el-input
              v-model="formData.code"
              v-mask="'####'"
              clearable
              :disabled="attempsCount >= allowedAttemptsCount || isSmsExpired"
            />
          </el-form-item>

          <countdown
            v-if="!isSmsExpired"
            v-slot="{ minutes, seconds }"
            ref="countdown"
            tag="div"
            class="timer"
            :time="time"
            @end="onCountdownEnd"
          >
            Через 0{{ minutes }}:{{ formatTime(seconds) }} код можно запросить
            повторно
          </countdown>

          <div>
            <el-button
              style="white-space: break-spaces; width: 100%"
              type="primary"
              :loading="isLoading"
              @click="submit"
              >{{ buttonLabel }}</el-button
            >
          </div>
        </div>

        <div class="column col">
          В течение нескольких секунд на Ваш телефон поступит звонок-сброс с
          уникального номера. Вам нужно ввести последние 4 цифры этого номера.

          <p>
            <span style="font-weight: bold; margin-right: 0.3rem">Пример:</span
            ><span>8951</span>
          </p>
        </div>
      </div>
    </el-form>
  </el-dialog>
</template>

<script>
import { mask } from "vue-the-mask";
import { incomeCallCodeValidator } from "@/utils/validator";
import { VALIDATE_DEFAULT_ERROR } from "@/values";

export default {
  directives: { mask },

  data() {
    return {
      isVisible: false,
      isLoading: false,
      isSmsExpired: false,
      attempsCount: 1,
      allowedAttemptsCount: 4,
      time: 60000,

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
      return this.isSmsExpired || this.attempsCount >= this.allowedAttemptsCount
        ? "Запросить код повторно"
        : "Продолжить";
    },

    dialogWidth() {
      return document.body.offsetWidth <= 950 ? "80%" : "30%";
    },
  },

  methods: {
    async submit() {
      if (this.isSmsExpired || this.attempsCount >= this.allowedAttemptsCount)
        await this.resetCode();
      else {
        await this.$refs.form.validate();
        await this.verifyCode();
      }
    },

    async verifyCode() {
      try {
        this.isLoading = true;

        await this.$http.get("/sms/verify-code", {
          uuid: this.formData.uuid,
          code: this.formData.code,
        });

        this.$emit("onPhoneVerified");
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
        await this.$http.get("/sms/reset-code", { uuid: this.formData.uuid });

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
        this.time = 60000;
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

<style scoped>
.form_wrapper label {
  font-size: 22px;
  line-height: 30px;
  color: #4c4c4c;
}

.form_wrapper .timer {
  width: 100%;
  margin: 1rem 0;
}
.form_wrapper .column {
  min-height: 160px;
}
</style>
