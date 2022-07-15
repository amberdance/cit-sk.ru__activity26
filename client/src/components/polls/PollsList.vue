<template>
  <div :class="$style.polls_list" v-loading="isLoading">
    <h2 style="font-size: 40px">Опросы</h2>

    <div :class="$style.polls_wrapper">
      <div v-for="poll in polls" :key="poll.id" :class="$style.polls_wrapper">
        <div :class="$style.polls_card">
          <div
            :class="$style.image"
            :style="`background-image:url(${poll.thumbnail})`"
          ></div>

          <div :class="$style.meta">
            <div :class="$style.title">
              {{ poll.label }}
            </div>

            <div :class="$style.subtitle">{{ poll.category }}</div>
            <div :class="$style">
              <el-button
                type="primary"
                @click="$router.push(`/polls/${poll.id}`)"
                >Перейти</el-button
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="m-1">
      <a href="#">Показать еще</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      polls: [],
      isLoading: false,
    };
  },

  async created() {
    try {
      this.isLoading = true;
      this.polls = await this.$http.get("/polls");
    } catch (e) {
      console.error(E);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
<style module>
.polls_list {
  background-color: #9cacb5;
  color: var(--color-font--secondary);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.polls_wrapper {
  display: flex;
  justify-content: space-between;
}
.polls_card {
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  color: var(--color-font--primary);
  max-width: 250px;
  min-height: 430px;
  margin-right: 20px;
}
.polls_card,
.image {
  border-radius: 15px;
}
.meta {
  padding: 0 15px 15px 15px;
}
.image {
  height: 220px;
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-size: cover;
  background-color: #ffffff;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.subtitle {
  color: #444444;
  margin: 1rem 0;
  font-weight: bold;
  font-size: 17px;
}
.title {
  font-size: 20px;
  margin-top: 5px;
}
</style>
