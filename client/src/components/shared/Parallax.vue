<template>
  <kinesis-container class="parallax">
    <kinesis-element
      class="img clouds"
      tag="img"
      :src="require('@/assets/parallax-bg/clouds.webp')"
      :strength="2"
    />
    <kinesis-element
      class="img mountain left_mountain"
      tag="img"
      :src="require('@/assets/parallax-bg/left_mountains.webp')"
      :strength="0.5"
      type="rotate"
    />
    <kinesis-element
      class="img mountain right_mountain"
      tag="img"
      :src="require('@/assets/parallax-bg/right_mountains.webp')"
      :strength="0.5"
      type="rotate"
    />
    <kinesis-element
      class="img field"
      tag="img"
      type="scaleY"
      :src="require('@/assets/parallax-bg/field.webp')"
      :strength="0.2"
    />
  </kinesis-container>
</template>
<script>
import { KinesisContainer, KinesisElement } from "vue-kinesis";

export default {
  components: {
    KinesisContainer,
    KinesisElement,
  },
};
</script>

<style scoped>
.parallax {
  position: absolute;
  overflow: hidden;
  top: -255px;
  right: 0;
}
.parallax .img {
  left: 0;
  right: 0;
  width: 100%;
  height: 100%;
}
.parallax .mountain {
  position: absolute;
  height: 250px;
  width: 50%;
  top: 660px;
}
.parallax .right_mountain {
  left: 50%;
}
.parallax .field {
  position: absolute;
  top: 800px;
  height: 350px;
}
</style>
