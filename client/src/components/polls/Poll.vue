<template>
  <MainLayout>
    <div class="container" v-loading="isVoting">
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

            <div
              v-if="poll.image"
              :class="$style.image"
              :style="`background-image:url(${poll.image});`"
            ></div>

            <div :class="$style.questions_wrapper">
              <div
                v-for="question in poll.questions"
                :class="$style.question"
                :key="question.id"
              >
                <h2 :class="$style.title">{{ question.label }}</h2>

                <div :class="$style.variants_wrapper">
                  <div v-for="variant in question.variants" :key="variant.id">
                    <el-radio-group v-model="variants[question.id]">
                      <el-radio :label="variant.id" :class="$style.title">{{
                        variant.label
                      }}</el-radio>
                    </el-radio-group>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="a-center">
            <el-button type="primary" @click="submit">Отправить</el-button>
          </div>
        </template>
      </div>
    </div>
    <el-dialog
      v-if="!isAuthorized"
      :visible="Boolean(authComponent)"
      custom-class="rounded"
      @close="authComponent = null"
      width="25%"
    >
      <component :is="authComponent" @onSuccessfullAuth="vote" />
    </el-dialog>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import PollSketelon from "./PollSketelon.vue";

export default {
  components: {
    MainLayout,
    PollSketelon,
  },

  data() {
    return {
      isLoading: false,
      isVoting: false,
      authComponent: null,
      poll: {},
      variants: {},
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
        await this.validate();

        this.isVoting = true;
        await this.$http.post("/polls/vote", {
          pollId: this.poll.id,
          userId: this.$store.getters.get("user")["id"],
          variants: this.variants,
        });

        this.variants = {};
        this.$onSuccess("Ваш голос принят! Спасибо за участие в опросе");
      } catch (e) {
        if (e.code == 401) {
          this.$store.commit("setUser", {});
          this.authComponent = () => import("@/components/AuthForm.vue");
        } else if (e.code == 12)
          return this.$onWarning("В данном опросе Вы уже принимали участие");
        else console.error(e);
      } finally {
        this.isVoting = false;
      }
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

.poll_wrapper .image {
  padding-bottom: 30%;
  background-repeat: no-repeat;
  background-size: contain;
  margin-top: 1rem;
}

.questions_wrapper .question {
  border: 1px dashed #ebebeb;
  margin: 1rem 0;
  padding: 0 1rem 1rem 1rem;
}
</style>
