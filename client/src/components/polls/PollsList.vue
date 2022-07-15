<template>
  <div style="background-color: #f5d299">
    <div class="container">
      <div :class="$style.polls_list" v-loading="isLoading">
        <div :class="$style.heading">Опросы</div>

        <el-row type="flex" :gutter="20" style="width: 100%">
          <el-col v-for="poll in polls" :key="poll.id" :lg="24">
            <div
              :class="[$style.polls_card, 'rounded']"
              @click="$router.push(`/polls/${poll.id}`)"
            >
              <div :class="$style.image_wrapper">
                <div
                  :class="$style.image"
                  :style="`background-image:url(${poll.thumbnail})`"
                ></div>
              </div>

              <div :class="$style.meta">
                <div :class="$style.category">{{ poll.category }}</div>
                <div :class="$style.title">
                  {{ poll.label }}
                </div>
              </div>

              <div :class="$style.footer">
                <el-button
                  type="primary"
                  @click="$router.push(`/polls/${poll.id}`)"
                  >Перейти</el-button
                >
              </div>
            </div>
          </el-col>
        </el-row>
      </div>
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
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
<style module>
.polls_list {
  color: var(--color-font--primary);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 1rem 0;
}
.polls_list .polls_wrapper {
  display: flex;
  justify-content: space-between;
}
.polls_list .heading {
  font-size: 40px;
  width: 100%;
  margin: 1rem 0;
  text-align: center;
  font-weight: bold;
}
.polls_card {
  background-color: #ffffff;
  cursor: pointer;
  transition: box-shadow 0.2s linear;
}

.polls_card .meta {
  padding: 1rem;
  min-height: 90px;
}
.polls_card .image_wrapper {
  position: relative;
  width: 100%;
  overflow: hidden;
  padding-top: 66.6666%;
  margin-top: auto;
}
.polls_card .image {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-size: cover;
  background-position: center center;
  transform: scale3d(1, 1, 1);
  -webkit-transform: scale3d(1, 1, 1);
  -moz-transform: scale3d(1, 1, 1);
  transition: all 0.3s ease-out;
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
}

.polls_card .image:hover {
  transform: scale3d(1.1, 1.1, 1.1);
  -webkit-transform: scale3d(1.1, 1.1, 1.1);
  -moz-transform: scale3d(1.1, 1.1, 1.1);
}
.polls_card:hover button {
  color: #000;
  background-color: #f6cd03 !important;
}
.polls_card .category {
  padding-bottom: 0.5rem;
  color: #767676;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 1px solid #76767626;
}
.polls_card .title {
  font-size: 18px;
}
.polls_card .footer {
  padding: 1rem;
  text-align: center;
}
.polls_card .footer button {
  width: 100%;
  transition: all 0.2s linear;
}

.polls_card:hover {
  box-shadow: 4px 3px 7px 0px #80808045;
}
</style>
