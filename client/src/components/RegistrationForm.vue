<template>
  <MainLayout>
    <div class="container">
      <div class="container-sm">
        <el-form
          :class="$style.registrate_wrapper"
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
                <span>Поле обязательно для заполнения.</span> <br />
                <span>Используйте буквы русского алфавита.</span>
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
                <span>Поле обязательно для заполнения.</span> <br />
                <span>Используйте буквы русского алфавита.</span>
              </div>
            </div>

            <div :class="$style.form_item">
              <el-form-item label="Отчество" prop="patronymic">
                <el-input
                  v-model="formData.patronymic"
                  clearable
                  :disabled="isFormSubmitted"
                />
                <div :class="$style.hint"></div>
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
              <div :class="$style.hint">Поле обязательно для заполнения.</div>
            </div>

            <div :class="$style.form_item">
              <el-form-item
                label="Город/район/муниципальный округ"
                prop="districtId"
                style="max-width: 370px"
              >
                <el-select v-model="formData.districtId" clearable filterable>
                  <el-option
                    v-for="item in districts"
                    :key="item.id"
                    :value="item.id"
                    :label="item.name"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
              <div :class="$style.hint">Поле обязательно для заполнения.</div>
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
                <span>Поле обязательно для заполнения.</span> <br />
                <span>Буквы только латинского алфавита.</span>
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
              Нажимая кнопку "Зарегистрироваться" вы соглашаетесь с
              <a href="#">условиями использования</a>
            </div>

            <div class="a-center">
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
    </div>
    <PhoneVerifyDialog ref="dialog" @onPhoneVerified="onRegistrateSuccess" />
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
      districts: [],

      formData: {
        firstName: null,
        lastName: null,
        districtId: null,
        address: null,
        birthday: null,
        patronymic: null,
        phone: null,
        email: null,
        password: null,
        confirmPassword: null,
        previousPageUrl: null,
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

        districtId: [
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

  beforeRouteEnter(to, from, next) {
    next((vm) => (vm.previousPageUrl = from.path || "/home"));
  },

  async created() {
    try {
      this.isLoading = true;
      const { districts } = await this.$http.get("/registration/districts");
      this.districts = districts;
    } catch (e) {
      this.$onError("Не удалось загрузить список регионов");
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },

  methods: {
    async submit() {
      await this.$refs.form.validate();
      await this.registrate();
    },

    async registrate() {
      try {
        this.isLoading = true;

        const { uuid } = await this.$http.post("/users", {
          firstName: this.formData.firstName,
          lastName: this.formData.lastName,
          patronymic: this.formData.patronymic,
          districtId: this.formData.districtId,
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

        if (e.code == 1062) {
          if (e.message.includes("mail"))
            return this.$onWarning(
              "Такой адрес электронной почты уже зарегистрирован"
            );

          if (e.message.includes("phone"))
            return this.$onWarning("Такой номер телефона уже зарегистрирован");
        }

        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },

    onRegistrateSuccess() {
      this.$router.push(this.previousPageUrl);
      this.$onSuccess(
        "Ваш профиль зарегистрирован, теперь вы можете аутентифицироваться для участия в опросах"
      );
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

.registrate_wrapper .heading {
  font-size: 26px;
  margin-bottom: 10px;
  font-weight: bold;
}

.registrate_wrapper label {
  font-size: 18px;
  color: #333;
}

.form_item .hint,
.registrate_wrapper .policy_text {
  color: #9ea4ac;
}
.registrate_wrapper .policy_text {
  margin: 1rem 0;
}

.form_item {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}
.form_item div:first-child {
  min-width: 350px;
  margin-right: 20px;
}
.form_item .hint {
  font-weight: bold;
  font-size: 14px;
}

@media (max-width: 790px) {
  .form_item {
    flex-wrap: wrap;
  }

  .form_item .hint {
    max-width: unset;
  }
  .form_item .hint,
  .form_item input {
    margin: 0;
  }
}
@media (max-width: 430px) {
  .form_item div:first-child {
    min-width: unset;
    width: 100%;
    margin-right: 0;
  }
  .form_wrapper button {
    width: 100%;
  }
}
</style>
