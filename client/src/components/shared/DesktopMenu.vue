<template>
  <div class="header">
    <div class="container-sm">
      <div class="header_wrapper shadowed">
        <router-link to="/">
          <div class="logo_wrapper">
            <img src="@/assets/logo_primary.svg" />
          </div>
        </router-link>

        <ul class="menu_wrapper d-flex">
          <li v-for="(item, i) in menu" :key="i" class="nav_item">
            <a
              v-if="$route.path == '/home' && 'scroll' in item"
              v-scroll-to="item.scroll"
              >{{ item.label }}</a
            >
            <router-link v-else :to="item.link"> {{ item.label }}</router-link>
          </li>
        </ul>

        <div class="auth_wrapper">
          <template v-if="isAuthorized">
            <a href="#" @click="$logout()" class="item" style="padding: 0"
              ><svg
                version="1.1"
                id="Layer_1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                viewBox="0 0 320.002 320.002"
                style="enable-background: new 0 0 320.002 320.002"
                xml:space="preserve"
              >
                <path
                  d="M51.213,175.001h173.785c8.284,0,15-6.716,15-15c0-8.284-6.716-15-15-15H51.213l19.394-19.394
		c5.858-5.858,5.858-15.355,0-21.213c-5.857-5.858-15.355-5.858-21.213,0L4.396,149.393c-0.351,0.351-0.683,0.719-0.997,1.103
		c-0.137,0.167-0.256,0.344-0.385,0.515c-0.165,0.22-0.335,0.435-0.488,0.664c-0.14,0.209-0.261,0.426-0.389,0.64
		c-0.123,0.206-0.252,0.407-0.365,0.619c-0.118,0.22-0.217,0.446-0.323,0.67c-0.104,0.219-0.213,0.435-0.306,0.659
		c-0.09,0.219-0.164,0.442-0.243,0.664c-0.087,0.24-0.179,0.477-0.253,0.722c-0.067,0.222-0.116,0.447-0.172,0.672
		c-0.063,0.249-0.133,0.497-0.183,0.751c-0.051,0.259-0.082,0.521-0.119,0.782c-0.032,0.223-0.075,0.443-0.097,0.669
		c-0.048,0.484-0.073,0.971-0.074,1.457c0,0.007-0.001,0.015-0.001,0.022c0,0.007,0.001,0.015,0.001,0.022
		c0.001,0.487,0.026,0.973,0.074,1.458c0.022,0.223,0.064,0.44,0.095,0.661c0.038,0.264,0.069,0.528,0.121,0.79
		c0.05,0.252,0.119,0.496,0.182,0.743c0.057,0.227,0.107,0.456,0.175,0.681c0.073,0.241,0.164,0.474,0.248,0.71
		c0.081,0.226,0.155,0.453,0.247,0.675c0.091,0.22,0.198,0.431,0.3,0.646c0.108,0.229,0.21,0.46,0.33,0.685
		c0.11,0.205,0.235,0.4,0.354,0.599c0.131,0.221,0.256,0.444,0.4,0.659c0.146,0.219,0.309,0.424,0.466,0.635
		c0.136,0.181,0.262,0.368,0.407,0.544c0.299,0.364,0.616,0.713,0.947,1.048c0.016,0.016,0.029,0.034,0.045,0.05l45,45.001
		c2.93,2.929,6.768,4.394,10.607,4.394c3.838-0.001,7.678-1.465,10.606-4.393c5.858-5.858,5.858-15.355,0.001-21.213L51.213,175.001
		z"
                />
                <path
                  d="M305.002,25h-190c-8.284,0-15,6.716-15,15v60c0,8.284,6.716,15,15,15s15-6.716,15-15V55h160v210.001h-160
		v-45.001c0-8.284-6.716-15-15-15s-15,6.716-15,15v60.001c0,8.284,6.716,15,15,15h190c8.284,0,15-6.716,15-15V40
		C320.002,31.716,313.286,25,305.002,25z"
                />
              </svg>
              <span>Выход</span></a
            >
          </template>

          <template v-else>
            <router-link to="/login" class="item">
              <svg
                version="1.1"
                id="Capa_1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                viewBox="0 0 490.1 490.1"
                style="enable-background: new 0 0 490.1 490.1"
                xml:space="preserve"
              >
                <path
                  d="M245,261.75c71.9,0,131.4-57.3,131.4-130.3S316.9,0.05,245,0.05s-131.4,57.3-131.4,130.3S173.1,261.75,245,261.75z
			 M245,40.75c50,0,90.7,40.7,90.7,89.7s-40.7,89.6-90.7,89.6s-90.7-40.7-90.7-89.7S195,40.75,245,40.75z"
                />
                <path
                  d="M333.6,274.25c-8.3-2.1-16.7,0-21.9,6.3l-66.7,76.1l-66.7-76.1c-5.2-6.3-14.6-8.3-21.9-6.3C61.5,305.55,0,382.65,0,469.15
			c0,11.5,9.4,20.9,20.9,20.9h448.3c11.5,0,20.9-9.4,20.9-20.9C490,382.65,428.5,305.55,333.6,274.25z M42.7,449.35
			c8.4-57.3,50.1-106.3,114.7-131.3l73,83.4c7.3,9.4,22.9,9.4,30.2,0l73-83.4c63.6,25,106.4,75,114.7,131.3H42.7z"
                />
              </svg>

              <span>Вход</span></router-link
            >

            <router-link to="/registration" class="item">
              <svg
                version="1.1"
                id="Layer_1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                viewBox="0 0 485.017 485.017"
                style="enable-background: new 0 0 485.017 485.017"
                xml:space="preserve"
              >
                <path
                  d="M361.205,68.899c-14.663,0-28.447,5.71-38.816,16.078c-21.402,21.403-21.402,56.228,0,77.631
		c10.368,10.368,24.153,16.078,38.815,16.078s28.447-5.71,38.816-16.078c21.402-21.403,21.402-56.228,0-77.631
		C389.652,74.609,375.867,68.899,361.205,68.899z M378.807,141.394c-4.702,4.702-10.953,7.292-17.603,7.292
		s-12.901-2.59-17.603-7.291c-9.706-9.706-9.706-25.499,0-35.205c4.702-4.702,10.953-7.291,17.603-7.291s12.9,2.589,17.603,7.291
		C388.513,115.896,388.513,131.688,378.807,141.394z"
                />
                <path
                  d="M441.961,43.036C414.21,15.284,377.311,0,338.064,0c-39.248,0-76.146,15.284-103.897,43.036
		c-42.226,42.226-54.491,105.179-32.065,159.698L0.254,404.584l-0.165,80.268l144.562,0.165v-55.722h55.705l0-55.705h55.705v-64.492
		l26.212-26.212c17.615,7.203,36.698,10.976,55.799,10.976c39.244,0,76.14-15.282,103.889-43.032
		C499.25,193.541,499.25,100.325,441.961,43.036z M420.748,229.617c-22.083,22.083-51.445,34.245-82.676,34.245
		c-18.133,0-36.237-4.265-52.353-12.333l-9.672-4.842l-49.986,49.985v46.918h-55.705l0,55.705h-55.705v55.688l-84.5-0.096
		l0.078-37.85L238.311,208.95l-4.842-9.672c-22.572-45.087-13.767-99.351,21.911-135.029C277.466,42.163,306.83,30,338.064,30
		c31.234,0,60.598,12.163,82.684,34.249C466.34,109.841,466.34,184.025,420.748,229.617z"
                />
              </svg>

              <span>Регистрация</span></router-link
            >
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { DESKTOP_MENU } from "../../values";

export default {
  props: {
    isAuthorized: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      menu: DESKTOP_MENU,
    };
  },
};
</script>

<style scoped>
.header {
  padding: 1rem 0 !important;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 20;
  transform: translateZ(20);
  -webkit-transform: translateZ(20);
}
.header_wrapper {
  background-color: #ffffff;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  align-items: center;
  color: var(--color-font--secondary);
  border-radius: 40px;
  margin: auto;
}
.header_wrapper a {
  font-weight: bold;
}
.auth_wrapper {
  display: flex;
  align-items: center;
}
.auth_wrapper a,
.menu_wrapper li a {
  cursor: pointer;
  color: var(--color-font--primary);
  transition: 0.3s;
}
.auth_wrapper svg {
  fill: var(--color-font--primary);
  transition: 0.3s;
}
.auth_wrapper .item {
  display: flex;
  align-items: center;
}
.auth_wrapper a:hover,
.menu_wrapper li:hover a {
  color: var(--color-link);
}
.auth_wrapper a:hover svg {
  fill: var(--color-link);
}

.auth_wrapper .item svg {
  width: 24px;
  margin-right: 0.3rem;
}
.auth_wrapper .item:nth-child(1) {
  padding-right: 1rem;
}
.logo_wrapper img {
  width: 65px;
  padding: 0px 10px;
}

.menu_wrapper .nav_item {
  padding: 1.2rem;
}
</style>
