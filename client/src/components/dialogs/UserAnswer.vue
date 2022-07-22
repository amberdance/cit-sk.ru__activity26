<template>
  <el-dialog
    title="Ваш вариант ответа"
    width="25%"
    :visible="isVisible"
    :show-close="false"
  >
    <el-input
      :maxlength="maxlength"
      type="textarea"
      :rows="5"
      v-model="userAnswer"
    ></el-input>
    <div class="p-1 a-right">Осталось {{ charsLength }} символов</div>
    <template #footer>
      <el-button-group class="a-right">
        <el-button type="danger" @click="destroy">Отмена</el-button>
        <el-button type="primary" @click="$emit('onUserAnswerChanged')"
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
      userAnswer: null,
    };
  },

  computed: {
    charsLength() {
      const length = this.maxlength - String(this.userAnswer).length;

      return length > 0 ? length : 0;
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
      this.userAnswer = null;
    },

    destroy() {
      this.isVisible = false;

      this.$emit("onDialogClosed", {
        index: this.index,
        questionId: this.questionId,
        variantId: this.variantId,
      });

      this.index = null;
      this.userAnswer = null;
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
