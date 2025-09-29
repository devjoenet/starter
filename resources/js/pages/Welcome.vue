<script lang="ts" setup>
  //
</script>
<template>
  <UApp>
    <UPage>
      <UPageHeader>
        <UHeader :title="$page.props.name">
          <template #right>
            <UColorModeButton as="button" :disabled="false" color="neutral" variant="ghost" />
            <UButton to="https://github.com/nuxt-ui-templates/starter-laravel" target="_blank" icon="simple-icons:github" aria-label="GitHub" color="neutral" variant="ghost" />
          </template>
        </UHeader>
      </UPageHeader>
      <UPageBody>
        <UPageColumns>
          <UButton raw> Button raw </UButton>
          <UButton active> Button active </UButton>
          <UButton active class="font-medium" active-class="text-(--ui-text-highlighted)"> Button active with class </UButton>
          <UButton active disabled> Button active disabled </UButton>
          <UButton> Button inactive </UButton>
          <UButton class="font-medium" inactive-class="hover:text-(--ui-primary)"> Button inactive with class </UButton>
          <UButton disabled> Button inactive disabled </UButton>
          <ULink to="/components/link" raw> Link raw </ULink>
          <ULink to="/"> Link active </ULink>
          <ULink to="/" class="font-medium" active-class="text-(--ui-text-highlighted)"> Link active with class </ULink>
          <ULink to="/" disabled> Link active disabled </ULink>
          <ULink to="/components/button"> Link inactive </ULink>
          <ULink to="/components/button" class="font-medium" inactive-class="hover:text-(--ui-primary)"> Link inactive with class </ULink>
          <ULink to="/components/button" disabled> Link inactive disabled </ULink>
        </UPageColumns>
      </UPageBody>
    </UPage>
  </UApp>
</template>
