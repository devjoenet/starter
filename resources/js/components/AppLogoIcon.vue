<script setup lang="ts">
  import type { HTMLAttributes } from "vue";

  defineOptions({
    inheritAttrs: false,
  });

  interface Props {
    className?: HTMLAttributes["class"];
  }

  defineProps<Props>();
</script>

<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" :class="className" v-bind="$attrs">
    <circle cx="16" cy="16" r="13" fill="none" stroke="currentColor" stroke-width="2" />
    <path d="M9 12.5c1.6-2.2 4.6-3.5 7.5-2.7 2 .5 3.6 2 3.2 3.9-.4 1.9-2.3 2.6-4.3 3.1-2.8.7-4.8 1.6-5.8 3.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" />
    <path d="M22.8 20.3c-1.2 1.8-3.4 2.9-6.1 2.9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" />
  </svg>
</template>
