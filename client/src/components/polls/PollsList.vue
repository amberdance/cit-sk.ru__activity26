<template>
  <div :class="$style.root">
    <div class="container">
      <div v-loading="isLoading">
        <div :class="$style.heading">Опросы</div>

        <el-row :class="$style.polls_list" type="flex" :gutter="20">
          <el-col
            v-for="poll in polls"
            :key="poll.id"
            :xs="24"
            :sm="12"
            :span="24"
          >
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
                <div :class="$style.category">
                  <span>{{ poll.category }}</span>
                  <svg
                    v-if="poll.isPopular"
                    width="24px"
                    height="24px"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                  >
                    <defs><path id="a" d="M-22 2.24h42V22h-42z" /></defs>
                    <clipPath id="b">
                      <use xlink:href="#a" overflow="visible" />
                    </clipPath>
                    <path
                      clip-path="url(#b)"
                      d="M16.543 8.028c-.023 1.503-.523 3.538-2.867 4.327.734-1.746.846-3.417.326-4.979-.695-2.097-3.014-3.735-4.557-4.627-.527-.306-1.203.074-1.193.683.02 1.112-.318 2.737-1.959 4.378C4.107 9.994 3 12.251 3 14.517 3 17.362 5 21 9 21c-4.041-4.041-1-7.483-1-7.483C8.846 19.431 12.988 21 15 21c1.711 0 5-1.25 5-6.448 0-3.133-1.332-5.511-2.385-6.899-.347-.458-1.064-.198-1.072.375"
                    />
                  </svg>
                </div>
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
.root {
  background-color: #f5d299;
}
.root .heading {
  font-size: 40px;
  width: 100%;
  padding: 1rem 0;
  text-align: center;
  font-weight: bold;
}
.polls_list {
  color: var(--color-font--primary);
  padding: 1rem 0;
}

.polls_card {
  background-color: #ffffff;
  cursor: pointer;
  transition: box-shadow 0.2s linear;
  margin-bottom: 1rem;
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
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
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
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 0.5rem;
  color: #767676;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 1px solid #76767626;
}
.polls_card svg {
  fill: #cd6044;
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

@media (max-width: 990px) {
  .polls_list {
    flex-wrap: wrap;
  }
}
</style>
