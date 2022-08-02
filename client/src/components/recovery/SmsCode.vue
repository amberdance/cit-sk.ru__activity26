<template>
  <MainLayout>
    <div class="container-sm">
      <div class="recovery-form rounded shadowed">
        <div class="heading">Восстановление доступа</div>
        <el-divider />

        <div class="sub-heading">
          Введите Ваш номер мобильного телефона или адрес электронной почты.
        </div>

        <el-form
          :model="formData"
          ref="form"
          size="large"
          label-position="left"
        >
          <div class="form-content">
            <el-form-item
              prop="login"
              :rules="{
                required: true,
                message: 'Введите номер телефона или email',
              }"
            >
              <div class="hint">Телефон или email</div>
              <el-input
                v-model="formData.login"
                clearable
                autocomplete="off"
              ></el-input>
            </el-form-item>

            <div class="w-100 mt-3 a-center">
              <el-button type="primary" v-loading="isLoading" @click="recover"
                >Восстановить доступ</el-button
              >
            </div>
          </div>
        </el-form>
      </div>
    </div>

    <PhoneVerifyDialog ref="smsDialog" @onPhoneVerified="passwordReset" />
  </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import PhoneVerifyDialog from "../dialogs/PhoneVerifyDialog.vue";

export default {
  components: { MainLayout, PhoneVerifyDialog },

  data() {
    return {
      isLoading: false,
      uuid: null,

      formData: {
        login: null,
      },
    };
  },

  methods: {
    async recover() {
      await this.$refs.form.validate();

      try {
        this.isLoading = true;
        const { uuid } = await this.$http.get("/users/recovery", {
          login: this.formData.login,
        });

        this.uuid = uuid;
        this.$refs.smsDialog.show(uuid);
      } catch (e) {
        if (e.code == 404) return this.$onWarning("Пользователь не найден");
        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },

    passwordReset() {
      this.$router.push({
        name: "PasswordReset",
        params: { uuid: this.uuid },
      });
    },
  },
};
</script>

<style scoped>
.recovery-form {
  max-width: 460px;
  padding: 2rem;
  margin: auto;
  background-color: #ffffff;
}

.recovery-form .sub-heading {
  margin: 1rem 0;
  font-weight: bold;
  padding: 1rem 0 1rem 1rem;
  border-left: 3px solid var(--color-primary);
}
.recovery-form .hint {
  font-weight: bold;
  color: #9ea4ac;
}
</style>
