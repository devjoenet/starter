<script setup lang="ts">
  import InputError from "@/components/InputError.vue";
  import TextLink from "@/components/TextLink.vue";
  import { Button } from "@/components/ui/button";
  import { Checkbox } from "@/components/ui/checkbox";
  import { Input } from "@/components/ui/input";
  import { Spinner } from "@/components/ui/spinner";
  import AuthBase from "@/layouts/AuthLayout.vue";
  import { register } from "@/routes";
  import { store } from "@/routes/login";
  import { request } from "@/routes/password";
  import { Form, Head } from "@inertiajs/vue3";

  defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
  }>();
</script>

<template>
  <AuthBase title="Log in to your account" description="Enter your email and password below to log in">
    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <Form v-bind="store.form()" :reset-on-success="['password']" v-slot="{ errors, processing }" class="flex flex-col gap-6">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Input id="email" type="email" name="email" required autofocus :tabindex="1" autocomplete="email" label="Email address" variant="filled" />
          <InputError :message="errors.email" />
        </div>

        <div class="grid gap-2">
          <Input id="password" type="password" name="password" required :tabindex="2" autocomplete="current-password" label="Password" variant="filled" />
          <InputError :message="errors.password" />
          <div class="flex justify-end">
            <TextLink v-if="canResetPassword" :href="request()" class="text-sm" :tabindex="5">Forgot password?</TextLink>
          </div>
        </div>

        <div class="flex items-center justify-between">
          <label for="remember" class="flex items-center gap-3 text-sm font-medium text-foreground">
            <Checkbox id="remember" name="remember" :tabindex="3" />
            <span>Remember me</span>
          </label>
        </div>

        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="processing" data-test="login-button">
          <Spinner v-if="processing" />
          Log in
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground" v-if="canRegister">
        Don't have an account?
        <TextLink :href="register()" :tabindex="5">Sign up</TextLink>
      </div>
    </Form>
  </AuthBase>
</template>
