<template>
  <div style="background-color: rgb(211 211 211)" v-if="hasPosts">
    <div class="container">
      <div :class="$style.news_wrapper">
        <div :class="$style.heading">Новости</div>

        <RowSkeleton v-if="isLoading" />

        <template v-else>
          <el-row
            type="flex"
            :class="$style.news_list"
            :gutter="20"
            v-show="!isLoading"
          >
            <el-col
              v-for="post in news"
              :key="post.id"
              :xs="12"
              :sm="12"
              :lg="8"
              :xl="24"
            >
              <a
                :href="post.link"
                target="_blank"
                :class="[$style.post_card, 'rounded']"
                @click="$openNewWindow(`${post.link}`)"
              >
                <div :class="[$style.image_wrapper]">
                  <div
                    :class="$style.image"
                    :style="`background-image:url(${post.image})`"
                  ></div>
                </div>
                <div :class="$style.meta">
                  <div :class="$style.category">{{ post.category }}</div>
                  <div :class="$style.title">
                    {{ post.title }}
                  </div>
                </div>
              </a>
            </el-col>
          </el-row>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import RowSkeleton from "./skeletons/RowSkeleton.vue";

export default {
  components: {
    RowSkeleton,
  },

  data() {
    return {
      hasPosts: false,
    };
  },

  computed: {
    news() {
      return this.$store.getters.get("news");
    },
  },

  async created() {
    if (!_.isEmpty(this.news)) return;

    try {
      this.isLoading = true;
      await this.$store.dispatch("loadNews", { limit: 4 });

      if (!this.news.lenght) this.hasPosts = false;
    } catch {
      this.hasPosts = false;
      this.$onError("Не удалось загрузить список новостей");
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
<style module>
.image_wrapper {
  border-radius: 10px 10px 0px 0px;
}
.news_wrapper {
  padding: 1rem 0;
}
.news_wrapper .heading {
  font-size: 40px;
  width: 100%;
  margin: 1rem 0;
  text-align: center;
  font-weight: bold;
}
.news_list {
  color: var(--color-font--primary);
  justify-content: center;
  width: 100%;
  margin: 0 !important;
  padding: 20px;
  border-radius: 15px;
  background-color: #f3f3f3;
}
.post_card {
  display: block;
  color: var(--color-font--primary);
  background-color: #ffffff;
  cursor: pointer;
  transition: box-shadow 0.2s linear;
  margin-bottom: 0.5rem;
}
.post_card .meta {
  padding: 1rem;
  min-height: 120px;
}
.post_card .image_wrapper {
  position: relative;
  width: 100%;
  overflow: hidden;
  padding-top: 66.6666%;
  margin-top: auto;
}
.post_card .image {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-repeat: no-repeat;
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
.post_card .image:hover {
  transform: scale3d(1.1, 1.1, 1.1);
  -webkit-transform: scale3d(1.1, 1.1, 1.1);
  -moz-transform: scale3d(1.1, 1.1, 1.1);
}
.post_card:hover button {
  color: #000;
  background-color: #f6cd03 !important;
}
.post_card .category {
  padding-bottom: 0.5rem;
  color: #767676;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 1px solid #76767626;
}
.post_card .title {
  font-size: 18px;
}
.post_card:hover {
  box-shadow: 4px 3px 7px 0px #80808045;
}

@media (min-width: 1500px) {
  .post_card {
    max-width: 320px;
  }
}

@media (max-width: 992px) {
  .news_list {
    flex-wrap: wrap;
  }

  .news_list .post_card {
    border-radius: 0;
  }
}
</style>
