<template>
  <div :class="['btn_mobile', state ? 'open' : null]">
    <span></span>
  </div>
</template>
<script>
export default {
  props: {
    state: {
      type: Boolean,
      required: true,
    },
  },
};
</script>

<style scoped>
.btn_mobile {
  position: relative;
  z-index: 10;
  transform: translateZ(10);
  -webkit-transform: translateZ(10);
  width: 24px;
  height: 20px;
  cursor: pointer;
}

.btn_mobile span {
  position: absolute;
  height: 2px;
  width: 24px;
  top: 50%;
  left: 0;
  margin-top: -1px;
  transition-duration: 0.5s;
  background-color: var(--color-primary);
}
.btn_mobile::after {
  bottom: 0;
}
.btn_mobile::before {
  top: 0;
  left: 0;
}
.btn_mobile::before,
.btn_mobile::after {
  content: "";
  position: absolute;
  width: 24px;
  height: 2px;
  transition-duration: 0.5s;
  background-color: var(--color-primary);
}
.btn_mobile.open::after {
  top: 15px;
}
.btn_mobile.open::before {
  top: -5px;
}
.btn_mobile.open span {
  opacity: 0;
  background: transparent;
}
.btn_mobile.open::before {
  transform: rotateZ(45deg) scaleX(1.25) translate(6.5px, 6.5px);
}
.btn_mobile.open::after {
  transform: rotateZ(-45deg) scaleX(1.25) translate(6px, -6px);
}
</style>
