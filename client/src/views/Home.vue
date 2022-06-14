<template>
  <el-container>
    <el-header style="height: auto; z-index: 999">
      <HeaderLayout />
    </el-header>

    <el-container>
      <el-main>
        <PollsForm />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import PollsForm from "@/components/PollsForm";
import HeaderLayout from "@/components/HeaderLayout";

export default {
  components: {
    HeaderLayout,
    PollsForm
  }
};
</script>
