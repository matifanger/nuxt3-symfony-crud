<script setup lang="ts">
import { ref } from "vue";
import { Product } from "~/global";

import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";

const props = defineProps({
  data: {
    type: Array as PropType<Product[]>,
  },
  editing: {
    type: Boolean,
    default: false,
  },
});

const isOpen = ref(false);
const newGroupName = ref("");

const emit = defineEmits(["updateGroups"]);

const handleCreateNewGroup = async () => {
  const res = await createNewGroup(newGroupName.value, props.data as Product[]);
  if (res) emit("updateGroups");
};

const acceptModal = () => {
  handleCreateNewGroup();
  closeModal();
};

const closeModal = () => {
  isOpen.value = false;
};

const openModal = () => {
  isOpen.value = true;
};
</script>

<template>
  <div
    class="fixed left-1/2 -translate-x-1/2 bottom-14 md:bottom-16 font-Poppins"
  >
    <button
      class="bg-green-600 text-white p-3 md:text-lg font-semibold rounded hover:bg-green-500 transition"
      @click="openModal"
    >
      Crear nuevo grupo
    </button>
  </div>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10 font-Poppins">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                {{
                  editing
                    ? "Cambiar nombre del grupo"
                    : "Nombre del nuevo grupo"
                }}
              </DialogTitle>
              <div class="mt-2">
                <input
                  type="text"
                  class="border border-gray-200 p-2 w-full"
                  v-model="newGroupName"
                  @keyup.enter="acceptModal"
                />
              </div>

              <div class="mt-4">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-green-100 px-4 py-2 text-sm font-medium text-green-900 hover:bg-green-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-2"
                  @click="acceptModal"
                >
                  Aceptar
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
