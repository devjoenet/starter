<script setup lang="ts">
  import type { Component, HTMLAttributes } from "vue";
  import { computed, useAttrs, useId } from "vue";
  import { useVModel } from "@vueuse/core";
  import { cn } from "@/lib/utils";

  defineOptions({
    inheritAttrs: false,
  });

  type InputVariant = "filled" | "outline";
  type InputDensity = "default" | "compact";

  const props = withDefaults(
    defineProps<{
      defaultValue?: string | number;
      modelValue?: string | number;
      label?: string;
      supportingText?: string;
      variant?: InputVariant;
      density?: InputDensity;
      leadingIcon?: Component;
      trailingIcon?: Component;
      inputClass?: HTMLAttributes["class"];
      class?: HTMLAttributes["class"];
    }>(),
    {
      variant: "outline",
      density: "default",
    },
  );

  const attrs = useAttrs();
  const generatedId = useId();

  const emits = defineEmits<{
    (e: "update:modelValue", payload: string | number): void;
  }>();

  const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
    defaultValue: props.defaultValue,
  });

  const inputId = computed(() => (attrs.id as string | undefined) ?? `input-${generatedId}`);
  const hasLabel = computed(() => Boolean(props.label));
  const inputAttrs = computed(() => ({
    ...attrs,
    id: inputId.value,
    placeholder: hasLabel.value ? " " : (attrs.placeholder as string | undefined),
  }));

  const wrapperClasses = computed(() =>
    cn(
      "group relative flex w-full items-center gap-2 rounded-xl transition",
      "focus-within:ring-ring/40 focus-within:ring-2",
      props.variant === "filled"
        ? "border border-transparent bg-[color:var(--surface-variant)] shadow-xs"
        : "border border-input bg-transparent shadow-xs",
      props.density === "compact" ? "px-3 pt-3 pb-1.5" : "px-3 pt-4 pb-2",
      "aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive",
      props.class,
    ),
  );

  const inputClasses = computed(() =>
    cn(
      "peer w-full bg-transparent text-base text-foreground outline-none",
      "placeholder:text-muted-foreground/0 selection:bg-primary selection:text-primary-foreground",
      "disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm",
      props.inputClass,
    ),
  );

  const labelClasses = computed(() =>
    cn(
      "pointer-events-none absolute left-3 text-sm text-muted-foreground transition-all",
      props.density === "compact" ? "top-3" : "top-4",
      props.density === "compact"
        ? "peer-placeholder-shown:top-3 peer-focus:top-1.5 peer-[&:not(:placeholder-shown)]:top-1.5"
        : "peer-placeholder-shown:top-4 peer-focus:top-2 peer-[&:not(:placeholder-shown)]:top-2",
      "peer-placeholder-shown:text-sm peer-focus:text-xs peer-[&:not(:placeholder-shown)]:text-xs",
      props.variant === "filled" ? "text-muted-foreground/80" : "bg-background px-1",
      "peer-focus:text-primary",
    ),
  );
</script>

<template>
  <div class="grid w-full gap-1.5">
    <div :class="wrapperClasses" data-slot="input">
      <component :is="leadingIcon" v-if="leadingIcon" class="size-4 text-muted-foreground" aria-hidden="true" />
      <input v-model="modelValue" v-bind="inputAttrs" :class="inputClasses" />
      <label v-if="label" :for="inputId" :class="labelClasses">
        {{ label }}
      </label>
      <component :is="trailingIcon" v-if="trailingIcon" class="size-4 text-muted-foreground" aria-hidden="true" />
    </div>
    <p v-if="supportingText" class="text-xs text-muted-foreground">{{ supportingText }}</p>
  </div>
</template>
