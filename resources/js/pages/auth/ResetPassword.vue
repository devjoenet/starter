<script setup lang="ts">
  import InputError from "@/components/InputError.vue";
  import { Button } from "@/components/ui/button";
  import { Input } from "@/components/ui/input";
  import { Spinner } from "@/components/ui/spinner";
  import AuthLayout from "@/layouts/AuthLayout.vue";
  import { update } from "@/routes/password";
  import { Form, Head } from "@inertiajs/vue3";
  import { ref } from "vue";

  const props = defineProps<{
    token: string;
    email: string;
  }>();

  const inputEmail = ref(props.email);
</script>

<template>
  <AuthLayout title="Reset password" description="Please enter your new password below">
    <Head title="Reset password" />

    <Form v-bind="update.form()" :transform="(data) => ({ ...data, token, email })" :reset-on-success="['password', 'password_confirmation']" v-slot="{ errors, processing }">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Input id="email" type="email" name="email" autocomplete="email" v-model="inputEmail" label="Email" variant="filled" readonly />
          <InputError :message="errors.email" class="mt-2" />
        </div>

        <div class="grid gap-2">
          <Input id="password" type="password" name="password" autocomplete="new-password" autofocus label="Password" variant="filled" />
          <InputError :message="errors.password" />
        </div>

        <div class="grid gap-2">
          <Input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" label="Confirm password" variant="filled" />
          <InputError :message="errors.password_confirmation" />
        </div>

        <Button type="submit" class="mt-4 w-full" :disabled="processing" data-test="reset-password-button">
          <Spinner v-if="processing" />
          Reset password
        </Button>
      </div>
    </Form>
  </AuthLayout>
</template>
