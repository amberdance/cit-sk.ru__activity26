<template>
  <header class="header">
    <div class="header_wrapper shadowed">
      <router-link to="/">
        <div class="logo_wrapper">
          <img src="@/assets/logo_primary.svg" />
        </div>
      </router-link>

      <div @click="opendrawer">
        <Hamburger :state="isDrawerOpened" />
      </div>

      <el-drawer
        class="drawer"
        size="100%"
        direction="ltr"
        :visible="isDrawerOpened"
        :with-header="false"
        :wrapper-closable="false"
        :append-to-body="false"
        :modal-append-to-body="false"
      >
        <div class="menu_wrapper">
          <div class="auth_wrapper d-flex flex-column">
            <template v-if="isAuthorized">
              <a href="#" @click="$logout()">
                <span>Выход</span> <i class="el-icon-arrow-right"></i
              ></a>
            </template>

            <template v-else>
              <router-link to="/login">
                <span>Вход</span> <i class="el-icon-arrow-right"></i
              ></router-link>
              <router-link to="/registration"
                ><span>Регистрация</span> <i class="el-icon-arrow-right"></i
              ></router-link>
            </template>
          </div>

          <div class="navigation_menu d-flex flex-column">
            <router-link
              v-for="(item, i) in menu"
              :key="i"
              :to="item.link"
              class="nav_item"
            >
              <span> {{ item.label }}</span>
              <i class="el-icon-arrow-right"></i>
            </router-link>
          </div>
        </div>
      </el-drawer>
    </div>
  </header>
</template>

<script>
import { MOBILE_MENU } from "../../values";
import Hamburger from "./Hamburger.vue";

export default {
  components: { Hamburger },

  props: {
    isAuthorized: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      menu: MOBILE_MENU,
      isDrawerOpened: false,
    };
  },

  methods: {
    opendrawer() {
      this.isDrawerOpened = !this.isDrawerOpened;
    },
  },
};
</script>

<style scoped>
.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 20;
  transform: translateZ(20);
  -webkit-transform: translateZ(20);
  height: var(--header-height);
}

.header_wrapper {
  background-color: #ffffff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.3rem 1rem;
}
.drawer {
  top: calc(var(--header-height) - 2px);
}

.header_wrapper img {
  width: 50px;
}
.menu_wrapper {
  padding: 1rem;
}
.menu_wrapper a,
.menu_wrapper i {
  font-weight: bold;
  font-size: 18px;
  color: var(--color-font--primary);
}
.menu_wrapper a {
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  padding: 1rem 0;
  border-bottom: 1px solid var(--color-divider);
}
</style>
