<script setup lang="ts"></script>

<template>
  <UApp>
    <UHeader :title="$page.props.name">
      <template #right>
        <UColorModeButton as="button" :disabled="false" color="neutral" variant="ghost" />
        <UButton to="https://github.com/nuxt-ui-templates/starter-laravel" target="_blank" icon="simple-icons:github" aria-label="GitHub" color="neutral" variant="ghost" />
      </template>
    </UHeader>

    <UMain>
      <slot />
    </UMain>

    <USeparator icon="simple-icons:laravel" />

    <UFooter>
      <template #left>
        <p class="text-muted text-sm">Built with Nuxt UI • © {{ new Date().getFullYear() }}</p>
      </template>

      <template #right>
        <UButton to="https://github.com/nuxt-ui-templates/starter-laravel" target="_blank" icon="simple-icons:github" aria-label="GitHub" color="neutral" variant="ghost" />
      </template>
    </UFooter>
  </UApp>
</template>
