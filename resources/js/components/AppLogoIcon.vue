<script setup lang="ts">
  import type { SVGAttributes } from "vue";

  interface Props {
    fillColor?: SVGAttributes["fill"];
    strokeColor?: SVGAttributes["stroke"];
    strokeWidth?: SVGAttributes["stroke-width"];
  }

  const props = withDefaults(defineProps<Props>(), {
    fillColor: "currentColor",
    strokeColor: "none",
    strokeWidth: "0",
  });
</script>

<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
    <path
      :fill="props.fillColor"
      :stroke="props.strokeColor"
      :stroke-width="props.strokeWidth"
      d="M3414.6 764v472h196zm271.1 472V764h-196zm64.2 0V764h196zm-430-472v472H544.6v195.1l-245.3-215.5L54.1 1000l245.2-215.6L544.5 569v195H3320"
    />
  </svg>
</template>
