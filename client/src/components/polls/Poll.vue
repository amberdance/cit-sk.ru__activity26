<template>
  <MainLayout>
    <div class="poll container" v-loading="isVoting">
      <div :class="[$style.poll_wrapper, 'rounded', 'shadowed']">
        <PollSketelon v-if="isLoading" />

        <template v-else>
          <div :class="$style.heading">
            <span :class="$style.poll_label">{{ poll.label }}</span>
            <span :class="$style.poll_id"
              ><span style="margin-right: 0.3rem">ID</span>{{ poll.id }}</span
            >
          </div>

          <div :class="$style.meta_wrapper">
            <div v-if="poll.description" :class="$style.description">
              <span>{{ poll.description }}</span>
            </div>

            <div v-if="poll.image" :class="$style.image_wrapper">
              <img :src="poll.image" />
            </div>

            <div :class="$style.questions_wrapper">
              <el-form ref="form" v-model="formData">
                <el-form-item
                  v-for="question in poll.questions"
                  :class="$style.question"
                  :key="question.id"
                >
                  <h2 :class="$style.title">{{ question.label }}</h2>

                  <el-radio-group
                    v-if="question.type == 'radio'"
                    v-model="formData[question.id]"
                    :disabled="isVotted"
                  >
                    <el-radio
                      v-for="variant in question.variants"
                      :key="variant.id"
                      :label="variant.id"
                      :class="$style.title"
                      >{{ variant.label }}</el-radio
                    >
                  </el-radio-group>

                  <el-checkbox-group
                    v-else
                    v-model="formData[question.id]"
                    :max="question.maxAllowed"
                    :disabled="isVotted"
                  >
                    <el-checkbox
                      v-for="variant in question.variants"
                      :key="variant.id"
                      :label="variant.id"
                      @change="onUserVariantChange(question.id, variant)"
                      >{{ variant.label }}
                    </el-checkbox>
                  </el-checkbox-group>
                </el-form-item>
              </el-form>
            </div>
          </div>
          <div :class="$style.btn_group">
            <el-button
              v-if="isVotted"
              type="primary"
              @click="$router.push('/home')"
              >На главную страницу</el-button
            >
            <el-button v-else type="primary" @click="submit"
              >Отправить</el-button
            >
          </div>
        </template>
      </div>
    </div>

    <el-dialog
      v-if="!isAuthorized"
      width="25%"
      custom-class="rounded"
      :visible="Boolean(authComponent)"
      :lock-scroll="false"
      @close="authComponent = null"
    >
      <component :is="authComponent" @onSuccessfullAuth="vote" />
    </el-dialog>
    <UserAnswer ref="userAnswerDialog" @onUserAnswerChanged="saveUserAnswer" />
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
      isVotted: false,
      isUserVariantChanged: false,
      questionId: null,
      variantId: null,
      authComponent: null,
      poll: {},
      variants: {},
      userVariant: null,
      formData: [],
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
      this.poll.questions.forEach(
        (question) => (this.formData[question.id] = [])
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
      if (!this.isAuthorized)
        this.authComponent = () => import("@/components/AuthForm.vue");
      else await this.vote();
    },

    async vote() {
      try {
        this.isVoting = true;

        await this.$http.post("/polls/vote", {
          pollId: this.poll.id,
          userId: this.$store.getters.get("user")["id"],
          values: this.getValues(),
        });

        this.isVotted = true;
        this.$onSuccess(
          "Благодарим Вас за участие в исследовании общественного мнения!"
        );
      } catch (e) {
        if (e.code == 401) {
          this.$store.commit("setUser", {});
          this.authComponent = () => import("@/components/AuthForm.vue");
        } else if (e.code == 12) {
          this.isVotted = true;
          return this.$onWarning("В данном опросе Вы уже принимали участие");
        } else console.error(e);
      } finally {
        this.isVoting = false;
      }
    },

    getValues() {
      const values = [];
      let index = 0;

      this.formData.forEach((variant, id) => {
        if (
          variant == "undefined" ||
          variant == null ||
          (_.isArray(variant) && !variant.length)
        )
          return;

        values.push({ id, answer: [] });

        if (_.isNumber(variant)) values[index].answer.push({ id: variant });

        if (_.isArray(variant)) {
          variant.forEach((item) => {
            const isObject = _.isObject(item);
            const params = {
              id: isObject ? item.id : item,
            };

            if (isObject) params.input = item.input;

            values[index].answer.push(params);
          });
        }

        index++;
      });

      return values;
    },

    onUserVariantChange(questionId, variant) {
      console.log(variant);
      if (!variant.hasUserAnswer) return;

      this.$refs.userAnswerDialog.show({
        questionId,
        variantId: variant.id,
      });
    },

    saveUserAnswer() {
      const { questionId, variantId, input } =
        this.$refs.userAnswerDialog.getData();

      this.formData[questionId].forEach((item, i) => {
        if (item == variantId)
          this.formData[questionId][i] = { id: variantId, input };
      });

      this.$refs.userAnswerDialog.hide();
    },
  },
};
</script>

<style module>
.poll_wrapper {
  background-color: #ffffff;
  min-height: 700px;
  margin: 1rem 0;
  padding-bottom: 2rem;
}
.poll_wrapper .heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 1rem 0;
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
  max-height: 650px;
  object-fit: cover;
}
.poll_wrapper .meta_wrapper {
  font-size: 18px;
  font-weight: bold;
  color: #606266;
  padding: 1rem 1.5rem;
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
.poll_wrapper .btn_group button {
  font-size: 18px;
}
.questions_wrapper .question {
  border: 1px dashed #ebebeb;
  margin: 1rem 0;
  padding: 0 1rem 1rem 1rem;
}
</style>
