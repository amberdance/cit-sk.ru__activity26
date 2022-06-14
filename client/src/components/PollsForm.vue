<template>
  <el-form :model="formData">
    <el-input v-model="formData.fullName" placeholder="ФИО"></el-input>
  </el-form>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        fullName: null
      }
    };
  }
};
</script>
