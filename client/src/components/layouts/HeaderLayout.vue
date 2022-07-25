<template>
  <div :class="$style.header_content">
    <div :class="[$style.header_wrapper, 'shadowed']">
      <div :class="$style.logo">
        <router-link to="/">
          <div :class="[$style.logo_wrapper, 'd-flex align-center']">
            <div :class="$style.primary_logo">
              <img src="@/assets/logo_primary.svg" />
            </div>
          </div>
        </router-link>
      </div>

      <div :class="$style.nav">
        <ul :class="$style.nav_ul">
          <li :class="$style.nav_item">Новости</li>
          <li v-scroll-to="'#polls'" :class="$style.nav_item">Опросы</li>
          <li :class="$style.nav_item">Контакты</li>
          <li :class="$style.nav_item">О проекте</li>
        </ul>
      </div>

      <div :class="$style.auth">
        <div :class="[$style.auth_wrapper, 'd-flex align-center']">
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
export default {
  computed: {
    isAuthorized() {
      return this.$store.getters.isUserAuthorized;
    },
  },
};
</script>
<style module>
.header_content {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  align-items: center;
  color: var(--color-font--secondary);
  margin: 40px 0px;
}

.header_wrapper {
  background-color: #ffffff;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  align-items: center;
  color: var(--color-font--secondary);
  border-radius: 40px;
}

.auth_wrapper {
  font-weight: bold;
  font-size: 16px;
  border-radius: 50px;
  padding: 20px;
}

.auth_wrapper a {
  color: var(--color-font--primary);
}

.auth_wrapper .item {
  display: flex;
  align-items: center;
}

.auth_wrapper span:hover {
  color: var(--color-link);
  transition: 0.3s;
}

.auth_wrapper .item img {
  margin-right: 0.3rem;
}

.auth_wrapper .item:first-child {
  padding-right: 1rem;
}

.logo_wrapper {
  border-radius: 50px;
  padding: 5px 10px;
}
.logo_wrapper img {
  height: 50px;
  padding: 0px 10px;
}
.flag img {
  height: 50px;
  border-radius: 100px;
}

.nav {
  display: flex !important;
}

.nav_ul {
  display: flex;
  padding: 0;
  color: #000000;
}

.nav_item {
  padding: 0rem 1rem;
  font-weight: bold;
}

.nav_item:hover {
  cursor: pointer;
  color: var(--color-link);
  transition: 0.3s;
}
</style>
