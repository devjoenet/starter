<script setup lang="ts">
  import type { PrimitiveProps } from "reka-ui";
  import type { HTMLAttributes } from "vue";
  import type { ButtonVariants } from ".";
  import { Primitive } from "reka-ui";
  import { cn } from "@/lib/utils";
  import { buttonVariants } from ".";
  import { ref } from "vue";

  interface Props extends PrimitiveProps {
    variant?: ButtonVariants["variant"];
    size?: ButtonVariants["size"];
    class?: HTMLAttributes["class"];
  }

  const props = withDefaults(defineProps<Props>(), {
    as: "button",
  });

  const buttonRef = ref<HTMLElement | null>(null);

  const createRipple = (event: PointerEvent) => {
    if (!buttonRef.value) {
      return;
    }

    if (buttonRef.value.hasAttribute("disabled") || buttonRef.value.getAttribute("aria-disabled") === "true") {
      return;
    }

    const rect = buttonRef.value.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const ripple = document.createElement("span");

    ripple.className = "ripple";
    ripple.style.width = `${size}px`;
    ripple.style.height = `${size}px`;
    ripple.style.left = `${event.clientX - rect.left - size / 2}px`;
    ripple.style.top = `${event.clientY - rect.top - size / 2}px`;

    buttonRef.value.appendChild(ripple);

    ripple.addEventListener("animationend", () => {
      ripple.remove();
    });
  };
</script>

<template>
  <Primitive ref="buttonRef" data-slot="button" :as="as" :as-child="asChild" :class="cn(buttonVariants({ variant, size }), props.class)" @pointerdown="createRipple">
    <slot />
  </Primitive>
</template>
