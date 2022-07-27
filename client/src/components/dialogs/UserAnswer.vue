<template>
  <el-dialog
    title="Ваш вариант ответа"
    width="500px"
    :visible="isVisible"
    :show-close="false"
  >
    <el-input
      v-model="userAnswer"
      :maxlength="maxlength"
      :rows="5"
      type="textarea"
    ></el-input>

    <div class="pt-3 a-right">Осталось {{ charsLength }} символов</div>
    <template #footer>
      <el-button-group class="a-right">
        <el-button type="danger" size="medium" @click="destroy"
          >Отмена</el-button
        >
        <el-button
          v-if="charsLength !== maxlength"
          type="primary"
          size="medium"
          @click="$emit('onUserAnswerChanged')"
          >Отправить</el-button
        >
      </el-button-group>
    </template>
  </el-dialog>
</template>

<script>
export default {
  data() {
    return {
      isVisible: false,
      maxlength: 500,
      index: null,
      questionId: null,
      variantId: null,
      userAnswer: "",
    };
  },

  computed: {
    charsLength() {
      return this.maxlength - this.userAnswer.length;
    },
  },

  methods: {
    show(params) {
      this.index = params.index;
      this.questionId = params.questionId;
      this.variantId = params.variantId;
      this.isVisible = true;
    },

    close() {
      this.isVisible = false;
      this.userAnswer = "";
    },

    destroy() {
      this.isVisible = false;

      this.$emit("onDialogClosed", {
        index: this.index,
        questionId: this.questionId,
        variantId: this.variantId,
      });

      this.index = null;
      this.userAnswer = "";
      this.questionId = null;
      this.variantId = null;
    },

    getData() {
      return {
        index: this.index,
        questionId: this.questionId,
        variantId: this.variantId,
        input: this.userAnswer,
      };
    },
  },
};
</script>
