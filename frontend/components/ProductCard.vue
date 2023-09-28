<script setup lang="ts">
import { Product } from "~/global";

const props = defineProps({
  data: {
    type: Object as PropType<Product>,
    required: true,
  },
  active: {
    type: Boolean,
    default: false,
  },
  type: {
    type: String as PropType<"normal" | "small">,
    default: "normal",
  },
  removable: {
    type: Boolean,
    default: false,
  },
  groupId: {
    type: Number,
    required: false,
  },
});

const styles = computed(() => {
  return {
    container: props.type === "normal" ? "p-3 w-auto" : "p-2 w-fit",
    image: props.type === "normal" ? "h-14 w-14 md:w-20 md:h-20" : "w-10 h-10",
    data: props.type === "normal" ? "p-3 space-y-1" : "pl-1.5",
    title: props.type === "normal" ? "text-xl" : "text-base",
    price: props.type === "normal" ? "text-base" : "text-sm",
  };
});
</script>

<template>
  <div
    class="border flex transition relative group"
    :class="[
      styles.container,
      active ? 'ring ring-green-300' : 'border-gray-300',
    ]"
  >
    <div class="my-auto">
      <img :src="data.image" class="rounded" :class="styles.image" />
    </div>
    <div :class="styles.data" class="flex flex-col justify-center">
      <h3 class="font-medium leading-none" :class="styles.title">
        {{ data.name }}
      </h3>
      <p class="text-[#71717A]" :class="styles.price">
        Precio: ${{ data.price }}
      </p>
    </div>
    <div
      v-if="removable"
      class="absolute -top-2.5 -right-2 transition cursor-pointer"
      @click="$emit('remove-product', { groupId: groupId, data: data })"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="20"
        height="20"
        viewBox="0 0 24 24"
      >
        <path
          fill="red"
          d="m12 13.4l2.9 2.9q.275.275.7.275t.7-.275q.275-.275.275-.7t-.275-.7L13.4 12l2.9-2.9q.275-.275.275-.7t-.275-.7q-.275-.275-.7-.275t-.7.275L12 10.6L9.1 7.7q-.275-.275-.7-.275t-.7.275q-.275.275-.275.7t.275.7l2.9 2.9l-2.9 2.9q-.275.275-.275.7t.275.7q.275.275.7.275t.7-.275l2.9-2.9Zm0 8.6q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Z"
        />
      </svg>
    </div>
  </div>
</template>
