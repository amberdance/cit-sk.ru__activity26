<template>
  <MainLayout>
    <div class="main_banner">
      <div class="container-sm">
        <div class="main_wrapper">
          <div class="main_title">Уважаемые жители Ставропольского края!</div>

          <div class="main_subtitle">
            {{ description }}
          </div>
          <el-button
            style="font-size: 18px"
            class="mt-3"
            type="primary"
            v-scroll-to="'#polls'"
            >Перейти к опросам
          </el-button>
        </div>
      </div>
    </div>

    <section id="counters"><Counters /></section>
    <section id="news"><News /></section>
    <section id="polls"><PollsList /></section>
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout";
import Counters from "@/components/shared/Counters";
import News from "@/components/shared/News";
import PollsList from "@/components/polls/PollListHome";
import { APP_DESCRIPTION } from "@/values";

export default {
  components: {
    MainLayout,
    Counters,
    PollsList,
    News,
  },

  data() {
    return {
      description: APP_DESCRIPTION(),
    };
  },
};
</script>

<style scoped>
.main_banner {
  min-height: 110vh;
  background: url(../../assets/bg_primary.webp);
  background-position: 50% 100%;
  background-repeat: no-repeat;
  background-size: cover;
  color: var(--color-font--primary);
}

.main_wrapper {
  display: flex;
  align-items: center;
  flex-direction: column;
  text-align: center;
  word-break: break-word;
  z-index: 10;
  transform: translateZ(10);
  -webkit-transform: translateZ(10);
  padding-top: calc(var(--header-height) + 100px);
  padding-bottom: 2rem;
}
.main_title {
  width: 100%;
  font-size: 50px;
  line-height: 50px;
  font-weight: bold;
  margin-bottom: 2rem;
}

.main_subtitle {
  font-size: 25px;
  font-weight: bold;
}

@media (max-width: 550px) {
  .main_title {
    font-size: 40px;
  }
}
</style>
