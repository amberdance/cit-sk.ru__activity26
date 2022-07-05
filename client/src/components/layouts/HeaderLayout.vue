<template>
  <div :class="$style.header_content">
    <div :class="[$style.logo_wrapper, 'd-flex align-center']">
      <router-link to="/">
        <img src="@/assets/logo_primary.webp" alt="logo_primary" />
      </router-link>
    </div>

    <div :class="[$style.auth_wrapper, 'd-flex align-center']">
      <router-link to="/auth" :class="$style.item"
        ><img src="@/assets/icon_user.png" class="icon-mini" /><span
          >Вход</span
        ></router-link
      >

      <router-link to="/registration" :class="$style.item">
        <img src="@/assets/icon_key.png" class="icon-mini" />
        <span>Регистрация</span></router-link
      >
    </div>
  </div>
</template>

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
  max-width: 55px;
}
</style>
