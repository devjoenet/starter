<script setup lang="ts">
  import AppLogoIcon from "@/components/AppLogoIcon.vue";
</script>

<template>
  <div class="flex aspect-square size-9 items-center justify-center rounded-xl bg-sidebar-primary text-sidebar-primary-foreground">
    <AppLogoIcon class="size-6 text-white dark:text-black" />
  </div>
  <div class="ml-2 grid flex-1 text-left text-sm">
    <span class="truncate leading-tight font-semibold">Southeast Code</span>
    <span class="text-xs text-sidebar-foreground/70">SoutheastCode.com</span>
  </div>
</template>
