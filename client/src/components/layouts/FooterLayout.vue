<template>
  <div :class="$style.footerContent">
    <div>
      Мы используем файлы cookie для улучшения работы сайта. Продолжая
      просматривать этот сайт, вы соглашаетесь с условиями использования
      cookie–файлов.Вы можете запретить сохранение cookie в настройках своего
      браузера. Дополнительно, сайт использует средство аналитики посещаемости
      пользователей "Яндекс.Метрика". С условиями использования сервиса
      Яндекс.Метрика и AppMetrica можно ознакомиться
      <a href="https://yandex.ru/legal/metrica_termsofuse/" target="_blank"
        >здесь</a
      >
    </div>

    <div
      :class="[$style.btnAccept, 'btn_primary']"
      @click="$emit('onCookieAccept')"
    >
      Понятно
    </div>
    <svg
      viewBox="0 0 1024 1024"
      xmlns="http://www.w3.org/2000/svg"
      data-v-78e17ca8=""
      :class="$style.btnClose"
      @click="$emit('onCookieDecline')"
    >
      <path
        fill="currentColor"
        d="M764.288 214.592 512 466.88 259.712 214.592a31.936 31.936 0 0 0-45.12 45.12L466.752 512 214.528 764.224a31.936 31.936 0 1 0 45.12 45.184L512 557.184l252.288 252.288a31.936 31.936 0 0 0 45.12-45.12L557.12 512.064l252.288-252.352a31.936 31.936 0 1 0-45.12-45.184z"
      ></path>
    </svg>
  </div>
</template>

<style module>
.footerContent {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}
.btnAccept {
  font-size: 15px;
  margin: 0 0.5rem;
}
.btnClose {
  color: #000000;
  height: 50px;
  width: 50px;
  cursor: pointer;
  position: relative;
  bottom: 30px;
}
</style>
