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
              <el-form ref="form" v-model="values">
                <el-form-item
                  v-for="question in poll.questions"
                  :class="$style.question"
                  :key="question.id"
                >
                  <h2 :class="$style.title">{{ question.label }}</h2>

                  <el-radio-group
                    v-if="question.type == 'radio'"
                    v-model="values[question.id]"
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
                    v-model="values[question.id]"
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

    <el-dialog title="Ваш вариант ответа" :visible="isUserVariantChanged">
      <el-input type="textarea" :rows="2" v-model="userVariant"></el-input>
      <el-button type="danger" @click="isUserVariantChanged = false"
        >Отмена</el-button
      >
      <el-button type="primary" @click="saveUserVariant">Отправить</el-button>
    </el-dialog>
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
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import PollSketelon from "../skeletons/PollSkeleton.vue";

export default {
  components: {
    MainLayout,
    PollSketelon,
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
      values: [],
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
        (question) => (this.values[question.id] = [])
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
          values: this.collectValues(),
        });

        // this.isVotted = true;
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

    collectValues() {
      const values = [];
      let index = 0;

      this.values.forEach((variant, id) => {
        if (
          variant == "undefined" ||
          variant == null ||
          (_.isArray(variant) && !variant.length)
        )
          return;

        values.push({ id, answer: [] });

        if (_.isNumber(variant))
          values[index].answer.push({ variantId: variant });

        if (_.isArray(variant)) {
          variant.forEach((id) => values[index].answer.push({ variantId: id }));
        }

        index++;
      });

      return values;
    },

    onUserVariantChange(questionId, variant) {
      if (!variant.hasUserVariant) return;

      this.questionId = questionId;
      this.variantId = variant.id;
      this.isUserVariantChanged = true;
    },

    saveUserVariant() {
      this.values[this.questionId] = this.values[this.questionId].filter(
        (variantId) => variantId != this.variantId
      );
      this.values[this.questionId].push({
        id: this.variantId,
        input: this.userVariant,
      });

      this.isUserVariantChanged = false;
    },

    validate() {
      let isValid = true;
      this.poll.questions.forEach((item) => {
        if (!this.variants[item.id]) isValid = false;
      });

      return isValid
        ? Promise.resolve()
        : Promise.reject(
            "Async validate failed",
            this.$onWarning("Ответьте на все вопросы")
          );
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
