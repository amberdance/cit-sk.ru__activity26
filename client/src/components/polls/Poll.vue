<template>
  <MainLayout>
    <div class="poll container" v-loading="isVoting">
      <div class="poll_wrapper rounded shadowed">
        <PollSketelon v-if="isLoading" />

        <template v-else>
          <div class="heading">
            <span class="poll_label">{{ poll.label }}</span>
            <span class="poll_id"
              ><span style="margin-right: 0.3rem">ID</span>{{ poll.id }}</span
            >
          </div>

          <div v-if="!isAuthorized" class="auth_notice">
            <h2>Внимание!</h2>
            <span>Для участия в опросе необходимо авторизоваться</span>
            <div>
              <el-button type="primary" @click="showAuthDialog"
                >Войти</el-button
              >
            </div>
          </div>

          <div class="meta_wrapper">
            <div v-if="poll.description" class="description">
              <span>{{ poll.description }}</span>
            </div>

            <div v-if="poll.image" class="image_wrapper">
              <img :src="poll.image" />
            </div>

            <div class="questions_wrapper">
              <el-form ref="form" v-model="formData[0][14]">
                <el-form-item
                  v-for="(question, i) in poll.questions"
                  class="question"
                  :key="question.id"
                >
                  <h2 class="title">{{ question.label }}</h2>

                  <el-radio-group
                    v-if="question.type == 'radio'"
                    v-model="formData[i][question.id]"
                    :disabled="isVoted"
                  >
                    <el-radio
                      v-for="variant in question.variants"
                      :key="variant.id"
                      :label="variant.id"
                      class="title"
                      >{{ variant.label }}</el-radio
                    >
                  </el-radio-group>

                  <el-checkbox-group
                    v-else
                    v-model="formData[i][question.id]"
                    :max="question.maxAllowed"
                    :disabled="isVoted"
                  >
                    <el-checkbox
                      v-for="variant in question.variants"
                      :key="variant.id"
                      :label="variant.id"
                      @change="
                        onUserVariantChange($event, {
                          index: i,
                          questionId: question.id,
                          variant,
                        })
                      "
                      >{{ variant.label }}
                    </el-checkbox>
                  </el-checkbox-group>
                </el-form-item>
              </el-form>
            </div>
          </div>
          <div class="btn_group" v-if="isAuthorized">
            <el-button
              v-if="isVoted"
              type="primary"
              @click="$router.push('/home')"
              >На главную страницу</el-button
            >
            <el-button v-else type="primary" @click="submit"
              >Ответить</el-button
            >
          </div>
        </template>
      </div>
    </div>

    <el-dialog
      v-if="!isAuthorized"
      width="20%"
      custom-class="rounded"
      :close-on-click-modal="false"
      :visible="Boolean(authComponent)"
      :lock-scroll="false"
      @close="authComponent = null"
    >
      <component :is="authComponent" />
    </el-dialog>

    <UserAnswer
      ref="userAnswerDialog"
      @onUserAnswerChanged="saveUserAnswer"
      @onDialogClosed="uncheckUserAnswerCheckbox"
    />
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import PollSketelon from "../skeletons/PollSkeleton.vue";
import UserAnswer from "../dialogs/UserAnswer.vue";

export default {
  components: {
    MainLayout,
    PollSketelon,
    UserAnswer,
  },

  data() {
    return {
      isLoading: false,
      isVoting: false,
      isVoted: false,
      isUserVariantChanged: false,
      questionId: null,
      variantId: null,
      authComponent: null,
      formData: [],
      poll: {},
      userAnswer: {},
    };
  },

  computed: {
    isAuthorized() {
      return this.$store.getters.isUserAuthorized;
    },
  },

  async created() {
    try {
      this.isLoading = true;
      const data = await this.$http.get(`/polls/${this.$route.params.id}`);

      this.poll = data.poll;
      this.poll.questions = data.questions;
      this.poll.questions.forEach((question) =>
        this.formData.push({ [question.id]: [] })
      );
    } catch (e) {
      if (e.code == 404) return this.$onError("Опрос не найден");
      this.$onError();
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },

  methods: {
    async submit() {
      if (!this.isAuthorized) this.showAuthDialog();
      else await this.vote();
    },

    async vote() {
      try {
        await this.$refs.form.validate();

        this.isVoting = true;

        await this.$http.post("/polls/vote", {
          pollId: this.poll.id,
          userId: this.$store.getters.get("user")["id"],
          values: this.getValues(),
        });

        this.isVoted = true;
        this.$onSuccess(
          "Благодарим Вас за участие в исследовании общественного мнения!"
        );
      } catch (e) {
        if (e.code == 401) {
          this.$store.commit("setUser", {});
          this.authComponent = () => import("@/components/AuthForm.vue");
        } else if (e.code == 12) {
          this.isVoted = true;
          return this.$onWarning("В данном опросе Вы уже принимали участие");
        } else console.error(e);
      } finally {
        this.isVoting = false;
      }
    },

    showAuthDialog() {
      this.authComponent = () => import("@/components/AuthForm.vue");
    },

    getValues() {
      const values = [];
      let index = 0;

      this.formData.forEach((item) => {
        const questionId = Number(Object.keys(item)[0]);
        const variant = item[questionId];

        // Setting initial structure
        values.push({ id: questionId, answer: [] });

        // Radio type handle
        if (_.isNumber(variant)) values[index].answer.push({ id: variant });

        // Checkbox type handle
        if (_.isArray(variant)) {
          variant.forEach((id, i) => {
            let params = { id };

            values[index].answer.push(params);

            // Replacing element of formdata with user answer by index
            if (
              _.isObject(this.userAnswer[questionId]) &&
              this.userAnswer[questionId].id == id
            )
              values[index].answer[i].input = this.userAnswer[questionId].input;
          });
        }

        index++;
      });

      return values;
    },

    onUserVariantChange(checked, { index, questionId, variant }) {
      if (!variant.hasUserAnswer) return;

      if (checked)
        this.uncheckUserAnswerCheckbox({
          index,
          questionId,
          variantId: variant.id,
        });

      this.$refs.userAnswerDialog.show({
        index,
        questionId,
        variantId: variant.id,
      });
    },

    saveUserAnswer() {
      const { index, questionId, variantId, input } =
        this.$refs.userAnswerDialog.getData();

      this.formData[index][questionId].push(variantId);
      this.userAnswer[questionId] = { id: variantId, input };
      this.$refs.userAnswerDialog.close();
    },

    uncheckUserAnswerCheckbox({ index, questionId, variantId }) {
      if (index === null) return;

      this.formData[index][questionId] = this.formData[index][
        questionId
      ].filter((id) => id !== variantId);
    },
  },
};
</script>

<style scoped>
.poll_wrapper {
  background-color: #ffffff;
  min-height: 700px;
  margin: 1rem 0;
  padding-bottom: 2rem;
}
.poll_wrapper .auth_notice {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex-wrap: wrap;
  font-size: 18px;
  margin: 1.5rem 0;
  background-color: #f0b56052;
}
.poll_wrapper .auth_notice button {
  margin: 1rem 0;
}
.poll_wrapper .heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem;
  font-weight: bold;
  color: var(--color-font--secondary);
  background-color: var(--color-primary);
}
.poll_wrapper .image_wrapper {
  margin: 1rem 0;
}
.poll_wrapper img {
  width: 100%;
  height: auto;
  max-height: 450px;
  object-fit: cover;
}
.poll_wrapper .meta_wrapper {
  font-size: 18px;
  font-weight: bold;
  color: #606266;
  padding: 1rem 1.5rem;
  margin: 1rem 0;
}
.poll_wrapper .poll_label {
  font-size: 30px;
}
.poll_wrapper .poll_id {
  padding: 0.5rem;
  border-radius: 5px;
  border: 2px solid var(--color-font--secondary);
}
.poll_wrapper .btn_group {
  text-align: center;
}

.questions_wrapper .question {
  border: 1px dashed #ebebeb;
  margin: 1rem 0;
  padding: 0 1rem 1rem 1rem;
}
</style>
