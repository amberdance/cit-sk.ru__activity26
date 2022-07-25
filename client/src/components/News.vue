<template>
  <div :class="$style.news_wrapper">
    <div class="container">
      <!-- <div :class="$style.overlay"></div> -->
      <div :class="$style.heading">Новости</div>

      <RowSkeleton v-if="isLoading" />

      <template v-else>
        <el-row
          type="flex"
          :gutter="20"
          :class="$style.news_list"
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
              :class="[$style.post_card, 'shadowed', 'rounded']"
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
</template>

<script>
import RowSkeleton from "./skeletons/RowSkeleton.vue";

export default {
  components: {
    RowSkeleton,
  },

  data() {
    return {
      isLoading: false,
    };
  },

  computed: {
    news() {
      return this.$store.getters.list("news");
    },
  },

  async created() {
    if (this.news.length) return;

    try {
      this.isLoading = true;
      await this.$store.dispatch("loadNews", { limit: 4 });
    } catch {
      this.$onError("Не удалось загрузить список новостей");
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
<style module>
.overlay {
  position: absolute;
  background: #0469ff54;
  height: 650px;
  left: 0;
  right: 0;
}

.image_wrapper {
  border-radius: 10px 10px 0px 0px;
}

.news_wrapper .heading {
  font-size: 40px;
  padding: 3rem 0 1rem 0;
  font-weight: bold;
  position: relative;
  border-bottom: 3px solid var(--color-font--primary);
  margin-bottom: 3rem;
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
  min-height: 100px;
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
  font-weight: bold;
  margin-bottom: 1rem;
  text-transform: uppercase;
  border-bottom: 1px solid #76767626;
}
</style>
