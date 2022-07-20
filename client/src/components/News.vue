<template>
    <div style="background-color: rgb(211 211 211)">
        <div class="container">
            <div :class="$style.news_wrapper">
                <div :class="$style.heading">Новости</div>

                <el-row type="flex" :class="$style.news_list" :gutter="20">
                    <el-col v-for="news in news" :key="news.link" :xs="12" :sm="12" :lg="8" :xl="24">
                        <div :class="[$style.news_card, 'rounded']" @click="$router.push(`${news.link}`)">
                            <div :class="[$style.image_wrapper]">
                                <div :class="$style.image"
                                    :style="`background-image:url(${news.enclosure.attributes.url})`">
                                </div>
                            </div>
                            <div :class="$style.meta">
                                        <div :class="$style.category">{{ news.category }}</div>
                                        <div :class="$style.title">
                                            {{ news.title }}
                                        </div>
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
    components: {},
    data() {
        return {
            news: [],
        };
    },

    created() {
        this.link = this.$openNewWindow;
    },

    async created() {
        try {
            this.news = await this.$http.get("/pages/main/news");
            console.log(this.news)
        } catch (e) {
            console.error(e);
        } finally {
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
.news_card {
  background-color: #ffffff;
  cursor: pointer;
  transition: box-shadow 0.2s linear;
  margin-bottom: 0.5rem;
}
.news_card .meta {
  padding: 1rem;
  min-height: 120px;
}
.news_card .image_wrapper {
  position: relative;
  width: 100%;
  overflow: hidden;
  padding-top: 66.6666%;
  margin-top: auto;
}
.news_card .image {
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
.news_card .image:hover {
  transform: scale3d(1.1, 1.1, 1.1);
  -webkit-transform: scale3d(1.1, 1.1, 1.1);
  -moz-transform: scale3d(1.1, 1.1, 1.1);
}
.news_card:hover button {
  color: #000;
  background-color: #f6cd03 !important;
}
.news_card .category {
  padding-bottom: 0.5rem;
  color: #767676;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 1px solid #76767626;
}
.news_card .title {
  font-size: 18px;
}
.news_card .footer {
  padding: 1rem;
  text-align: center;
}
.news_card .footer button {
  width: 100%;
  transition: all 0.2s linear;
}
.news_card:hover {
  box-shadow: 4px 3px 7px 0px #80808045;
}

@media (min-width: 1500px) {
    .news_card {
        max-width: 320px;
    }
}

@media (max-width: 992px) {
    .news_list {
        flex-wrap: wrap;
    }

    .news_list .news_card {
        border-radius: 0;
    }
}
</style>
