<template>
  <MainLayout>
    <div class="container">
      <div class="results_wrapper">
        <PollSkeleton v-if="isLoading" />

        <div v-else class="results">
          <div class="heading">
            <span class="poll_label">{{ poll.label }}</span>
            <span class="poll_id"
              ><span style="margin-right: 0.3rem">ID</span>{{ poll.id }}</span
            >
          </div>

          <div class="notification">
            <h2 v-if="poll.isCompleted">Опрос завершен</h2>
            <div>Принято голосов: {{ poll.totalAnswersCount }}</div>
            <br />
            <div>Результаты голосований распределились следующим образом:</div>
          </div>

          <div class="meta_wrapper">
            <div class="questions_wrapper">
              <div
                v-for="question in questions"
                :key="question.id"
                class="question"
              >
                <h2 class="title">{{ question.label }}</h2>

                <div class="variants_wrapper d-flex flex-column">
                  <div
                    class="variant d-flex flex-column"
                    v-for="variant in question.variants"
                    :key="variant.id"
                  >
                    <template v-if="question.type !== 'input'">
                      <span class="label">{{ variant.label }}</span>

                      <el-progress
                        :percentage="variant.percent"
                        :color="customColors"
                      ></el-progress>
                    </template>

                    <template v-if="question.type == 'input'">
                      <ul class="input_wrapper">
                        <li
                          v-for="answer in variant.answers.slice(
                            0,
                            allowedInputVariantsPerRow
                          )"
                          :key="answer.id"
                        >
                          {{ answer.userAnswer }}
                        </li>
                      </ul>

                      <el-collapse
                        :v-model="['collapse']"
                        v-if="
                          variant.answers.length >= allowedInputVariantsPerRow
                        "
                      >
                        <el-collapse-item title="Все ответы" name="collapse">
                          <ul class="input_wrapper">
                            <li
                              v-for="answer in variant.answers.slice(
                                allowedInputVariantsPerRow
                              )"
                              :key="answer.id"
                            >
                              {{ answer.userAnswer }}
                            </li>
                          </ul>
                        </el-collapse-item>
                      </el-collapse>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import PollSkeleton from "../skeletons/PollSkeleton.vue";

export default {
  components: {
    MainLayout,

    PollSkeleton,
  },

  data() {
    return {
      isLoading: false,
      allowedInputVariantsPerRow: 10,
      poll: [],
      questions: [],
      customColors: [
        { color: "#f56c6c", percentage: 20 },
        { color: "#e6a23c", percentage: 40 },
        { color: "#5cb87a", percentage: 60 },
        { color: "#1989fa", percentage: 80 },
        { color: "#6f7ad3", percentage: 100 },
      ],
    };
  },

  async created() {
    try {
      this.isLoading = true;
      const response = await this.$http.get(
        `/polls/${this.$route.params.id}/result`
      );

      this.poll = response.poll;
      this.questions = response.questions;
    } catch (e) {
      if (e.code == 401)
        return this.$router.push(`/polls/${this.$route.params.id}`);
      this.$onError();
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>

<style scoped>
.results_wrapper {
  background-color: #ffffff;
  min-height: 700px;
  margin: 1rem 0;
  padding-bottom: 2rem;
}

.results_wrapper .notification {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex-wrap: wrap;
  font-size: 20px;
  margin: 1.5rem 0;
  padding: 1rem;
  color: var(--color-font--secondary);
  background-color: var(--color-success);
}

.results_wrapper .heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem;
  font-weight: bold;
  color: var(--color-font--secondary);
  background-color: var(--color-primary);
}

.results_wrapper .image_wrapper {
  margin: 1rem 0;
}

.results_wrapper img {
  width: 100%;
  height: auto;
  max-height: 450px;
  object-fit: cover;
}

.results_wrapper .meta_wrapper {
  color: #606266;
  padding: 1rem 1.5rem;
  margin: 1rem 0;
}

.results_wrapper .poll_label {
  font-size: 30px;
}

.results_wrapper .poll_id {
  padding: 0.5rem;
  border-radius: 5px;
  border: 2px solid var(--color-font--secondary);
}

.questions_wrapper .question {
  border: 1px dashed #ebebeb;
  margin: 1rem 0;
  padding: 0 1rem 1rem 1rem;
}

.variant {
  padding: 1rem 0;
}

.variant .label {
  margin-bottom: 0.5rem;
}

.input_wrapper {
  padding-left: 1.5rem;
}

.input_wrapper li {
  list-style-type: disc;
}

.el-collapse {
  margin-top: 1.5rem;
}

::v-deep .el-collapse-item__header {
  font-size: 16px !important;
  color: var(--color-link);
  font-weight: bold;
}
</style>
