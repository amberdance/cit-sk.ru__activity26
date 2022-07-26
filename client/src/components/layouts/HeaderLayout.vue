<template>
  <div :class="$style.header">
    <div class="container-sm">
      <div :class="[$style.header_wrapper, 'shadowed']">
        <router-link to="/">
          <div :class="$style.logo_wrapper">
            <img src="@/assets/logo_primary.svg" />
          </div>
        </router-link>

        <ul :class="$style.menu_wrapper">
          <li v-for="(item, i) in menu" :key="i" :class="$style.nav_item">
            <a
              v-if="$route.path == '/home' && 'isHomePageOnly' in item"
              v-scroll-to="item.scroll"
              >{{ item.label }}</a
            >

            <a
              v-else-if="$route.path == '/home' && 'scroll' in item"
              v-scroll-to="item.scroll"
              >{{ item.label }}</a
            >
            <router-link v-else-if="'link' in item" :to="item.link">
              {{ item.label }}</router-link
            >
          </li>
        </ul>

        <div :class="$style.auth_wrapper">
          <template v-if="isAuthorized">
            <a
              href="#"
              @click="$logout()"
              :class="$style.item"
              style="padding: 0"
              ><img src="@/assets/icon_logout.png" class="icon-mini" /><span
                >Выход</span
              ></a
            >
          </template>
          <template v-else>
            <router-link to="/login" :class="$style.item"
              ><img src="@/assets/icon_user.png" class="icon-mini" /><span
                >Вход</span
              ></router-link
            >

            <router-link to="/registration" :class="$style.item">
              <img src="@/assets/icon_key.png" class="icon-mini" />
              <span>Регистрация</span></router-link
            >
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { navigationMenu } from "@/values";

export default {
  computed: {
    isAuthorized() {
      return this.$store.getters.isUserAuthorized;
    },
  },

  data() {
    return {
      menu: navigationMenu,
    };
  },
};
</script>

<style module>
.header {
  padding: 1rem 0 !important;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 20;
}

.header_wrapper {
  background-color: #ffffff;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  align-items: center;
  color: var(--color-font--secondary);
  border-radius: 40px;
  max-width: 800px;
  margin: auto;
}

.auth_wrapper {
  display: flex;
  align-items: center;
  font-weight: bold;
  font-size: 16px;
  border-radius: 50px;
  padding: 20px;
}
.auth_wrapper a,
.menu_wrapper li a {
  color: var(--color-font--primary);
}

.auth_wrapper .item {
  display: flex;
  align-items: center;
}

.auth_wrapper span:hover,
.menu_wrapper li:hover a {
  cursor: pointer;
  color: var(--color-link);
  transition: 0.3s;
}

.auth_wrapper .item img {
  margin-right: 0.3rem;
}

.auth_wrapper .item:first-child {
  padding-right: 1rem;
}

.logo_wrapper img {
  width: 60px;
  padding: 0px 10px;
}

.menu_wrapper {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  padding: 0;
}

.menu_wrapper .nav_item {
  padding: 0rem 1.2rem;
  font-weight: bold;
}
</style>
