<template>
  <el-dialog title=""> </el-dialog>
</template>

<script>
export default {
  data() {
    return {
      visible: false,
      user: [],
    };
  },

  methods: {
    show(user) {
      this.user = user;
      this.visible = true;
    },
  },
};
</script>
