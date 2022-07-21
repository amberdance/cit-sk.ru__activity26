<template>
  <el-dialog
    title="Ваш вариант ответа"
    width="25%"
    :visible="isVisible"
    @close="hide"
  >
    <el-input type="textarea" :rows="5" v-model="userAnswer"></el-input>

    <template #footer>
      <div class="a-right">
        <el-button type="danger" @click="hide">Отмена</el-button>
        <el-button type="primary" @click="$emit('onUserAnswerChanged')"
          >Отправить</el-button
        >
      </div>
    </template>
  </el-dialog>
</template>

<script>
export default {
  data() {
    return {
      isVisible: false,
      questionId: null,
      variantId: null,
      userAnswer: null,
    };
  },

  methods: {
    show(params) {
      this.questionId = params.questionId;
      this.variantId = params.variantId;
      this.isVisible = true;
    },

    hide() {
      this.isVisible = false;
      this.userAnswer = null;
      this.questionId = null;
      this.variantId = null;
    },

    getData() {
      return {
        questionId: this.questionId,
        variantId: this.variantId,
        input: this.userAnswer,
      };
    },
  },
};
</script>
