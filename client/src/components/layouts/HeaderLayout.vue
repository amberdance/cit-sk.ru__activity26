<template>
  <div :class="$style.header_content">
    <div :class="[$style.logo_wrapper, 'd-flex align-center']">
      <router-link to="/">
        <img src="@/assets/logo_primary.webp" alt="logo_primary" />
      </router-link>
    </div>

    <div :class="[$style.auth_wrapper, 'd-flex align-center']">
      <template v-if="isAuthorized">
        <a href="#" @click="$logout()" :class="$style.item"
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
  justify-content: space-between;
  flex-wrap: wrap;
  align-items: center;
  color: var(--color-font--secondary);
  padding: 1rem 0;
}

.auth_wrapper {
  font-weight: bold;
  font-size: 18px;
}

.auth_wrapper a {
  color: var(--color-font--primary);
}

.auth_wrapper .item {
  display: flex;
  align-items: center;
}
.auth_wrapper .item img {
  margin-right: 0.3rem;
}

.auth_wrapper .item:first-child {
  padding-right: 1rem;
}
.logo_wrapper img {
  max-width: 70px;
}
</style>
