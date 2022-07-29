<template>
  <div class="posts">
    <div class="container">
      <div class="heading">{{ heading }}</div>

      <PostsListSkeletonBase v-if="visible" :skeleton-count="skeletonCount" />

      <template v-else>
        <div class="empty-text" v-if="!posts.length">{{ emptyText }}</div>

        <div v-else class="row posts_wrapper">
          <div
            v-for="post in posts"
            class="col-lg-3 col-md-6 col-sm-6 col-xs-12"
            :key="post.id"
          >
            <a
              v-if="'link' in post"
              :href="post.link"
              target="_blank"
              class="post_card shadowed rounded"
            >
              <div class="image_wrapper">
                <div
                  class="image"
                  :style="`background-image:url(${post.image})`"
                ></div>
              </div>

              <div class="meta">
                <div class="category">{{ post.category }}</div>
                <div class="title">
                  {{ post.title }}
                </div>
              </div>
            </a>

            <router-link
              v-else
              :to="
                post.isCompleted
                  ? `/poll/${post.id}/result`
                  : `/poll/${post.id}`
              "
              class="post_card shadowed rounded"
            >
              <div class="image_wrapper">
                <div
                  class="image"
                  :style="`background-image:url(${post.thumbnail})`"
                ></div>
              </div>

              <div class="meta">
                <div class="category">{{ post.category }}</div>
                <div class="title">
                  {{ post.label }}
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import PostsListSkeletonBase from "../skeletons/PostsListSkeletonBase";

export default {
  components: {
    PostsListSkeletonBase,
  },

  props: {
    visible: {
      type: Boolean,
      required: false,
      default: false,
    },

    heading: {
      type: String,
      required: true,
    },

    posts: {
      type: Array,
      required: true,
    },

    skeletonCount: {
      type: Number,
      default: 4,
    },

    emptyText: {
      type: String,
      default: "Ничего не найдено",
    },
  },
};
</script>
<style scoped>
.posts {
  padding: 2rem 0;
}
.posts .heading {
  text-align: center;
  font-size: 40px;
  padding: 1rem;
  font-weight: bold;
  position: relative;
  color: var(--color-font--primary);
  border-bottom: 3px solid var(--color-font--primary);
  margin-bottom: 2rem;
}

.posts .empty-text {
  font-size: 20px;
  text-align: center;
  font-weight: bold;
  padding: 2rem 0;
  color: var(--color-danger);
}
.post_card {
  display: block;
  color: var(--color-font--primary);
  background-color: #ffffff;
  cursor: pointer;
  transition: box-shadow 0.2s linear;
  margin-bottom: 1rem;
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
  border-radius: 10px 10px 0px 0px;
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

.post_card .category {
  padding-bottom: 0.5rem;
  color: #767676;
  font-weight: bold;
  margin-bottom: 1rem;
  text-transform: uppercase;
  border-bottom: 1px solid var(--color-divider);
}

@media (max-width: 992px) {
  .post_card,
  .image_wrapper {
    border-radius: 0 !important;
  }
}
</style>
