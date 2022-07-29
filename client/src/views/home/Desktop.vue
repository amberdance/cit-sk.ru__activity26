<template>
  <MainLayout>
    <div class="main_banner">
      <Parallax />

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
    <FooterLayout id="footer" />
  </MainLayout>
</template>

<script>
import MainLayout from "@/components/layouts/MainLayout.vue";
import FooterLayout from "@/components/layouts/FooterLayout.vue";
import Parallax from "@/components/shared/Parallax.vue";
import Counters from "@/components/shared/Counters.vue";
import News from "@/components/shared/News.vue";
import PollsList from "@/components/polls/PollsList.vue";
import { APP_DESCRIPTION } from "@/values.js";

export default {
  components: {
    MainLayout,
    Parallax,
    Counters,
    PollsList,
    News,
    FooterLayout,
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
  position: relative;
  min-height: 830px;
}

.main_wrapper {
  display: flex;
  align-items: center;
  flex-direction: column;
  text-align: center;
  position: relative;
  top: 10rem;
}
.main_title {
  width: 100%;
  font-size: 70px;
  line-height: 70px;
  font-weight: bold;
  margin-bottom: 2rem;
}

.main_subtitle {
  font-size: 25px;
  font-weight: bold;
}
</style>
