<script setup lang="ts">
import { Group, Product } from "~/global";

const BACK_URL = useRuntimeConfig().public.BACKEND_URL;
const editingMode = ref(false);
const selectedProducts = ref<Product[]>([]);

const { data: groups, refresh: refreshGroups } = await useAsyncData<Group[]>(
  "index-groups",
  () => $fetch(`${BACK_URL}/groups`)
);

const products = [
  {
    name: "Airpods",
    image: "https://i.imgur.com/IF8MJq8.png",
    price: 500,
  },
  {
    name: "Vaso acero inoxidable",
    image: "https://i.imgur.com/ZjgS6zs.png",
    price: 500,
  },
  {
    name: "Apple Ipad",
    image: "https://i.imgur.com/2GEwIIB.png",
    price: 1000,
  },
  {
    name: "Cargador portable",
    image: "https://i.imgur.com/U3qrZDn.png",
    price: 1500,
  },
  {
    name: "Apple Watch",
    image: "https://i.imgur.com/7LUPUJz.png",
    price: 2000,
  },
];

const handleUpdateProductGroup = async (e: {
  groupId: number;
  data: Product;
}) => {
  const { groupId, data } = e;

  const newProducts =
    groups.value &&
    groups.value
      .find((group: Group) => group.id === groupId)
      ?.products.filter((product: Product) => product.name !== data.name);

  if (newProducts) {
    const res = await updateProductGroup(groupId, newProducts);
    if (res) refreshGroups();
  }
};

const handleRemoveGroup = async (id: number) => {
  const res = await removeGroup(id);
  if (res) refreshGroups();
};

const handleEditNameGroup = async (id: number, name: string) => {
  const res = await editNameGroup(id, name);

  if (res) {
    editingMode.value = false;
    refreshGroups();
  }
};

const updateGroups = () => {
  refreshGroups();
  selectedProducts.value = [];
};

const handleSelectedProduct = (key: number) => {
  const product = products[key];
  const index = selectedProducts.value.findIndex(
    (item) => item.name === product.name
  );

  if (index === -1) {
    selectedProducts.value.push(product);
  } else {
    selectedProducts.value.splice(index, 1);
  }
};
</script>

<template>
  <div class="bg-gray-50 min-h-screen font-Poppins">
    <main class="container">
      <h1 class="text-center py-5 text-4xl font-bold">Bienvenido</h1>
      <div class="grid grid-cols-12 gap-5 mb-10">
        <section
          class="col-span-12 md:col-span-6 border border-gray-300 rounded"
        >
          <h2 class="text-2xl border-b border-gray-300 p-3 font-semibold">
            Productos
          </h2>
          <ul class="space-y-4 my-2 p-3">
            <li
              v-for="(product, key) in products"
              :key="key"
              @click="handleSelectedProduct(key)"
              class="cursor-pointer"
            >
              <div>
                <ProductCard
                  :data="product"
                  :active="selectedProducts.includes(product)"
                />
              </div>
            </li>
          </ul>
        </section>
        <section
          class="col-span-12 md:col-span-6 border border-gray-300 rounded"
        >
          <h2 class="text-2xl border-b border-gray-300 p-3 font-semibold">
            Grupos
          </h2>
          <ul v-if="groups && groups.length">
            <li
              v-for="(group, key) in groups"
              :key="key"
              class="border-gray-300 border-b"
            >
              <div class="p-3 flex space-y-1 justify-between items-center">
                <div class="group relative">
                  <input
                    type="text"
                    class="h-8 md:h-10 bg-transparent text-lg md:text-xl font-semibold w-[90%]"
                    v-model="group.name"
                    @click="editingMode = true"
                    @blur="handleEditNameGroup(group.id, group.name)"
                  />
                  <span
                    class="pointer-events-none absolute -top-5 -left-4 w-max opacity-0 text-white rounded p-1 text-sm transition-opacity group-hover:opacity-100 bg-[#121624]"
                    v-if="!editingMode"
                  >
                    Presiona para editar
                  </span>
                </div>

                <button
                  class="bg-red-500 text-white rounded px-2 shadow py-1 text-sm md:text-base transition hover:bg-red-600"
                  @click="handleRemoveGroup(group.id)"
                >
                  Eliminar
                </button>
              </div>
              <div class="flex flex-wrap gap-3 px-2 pb-3 pt-1">
                <ProductCard
                  v-for="(product, key) in group.products"
                  :key="key"
                  :data="product"
                  :removable="true"
                  :groupId="group.id"
                  type="small"
                  :canRemove="group.products.length > 1"
                  @remove-product="(e) => handleUpdateProductGroup(e)"
                />
              </div>
            </li>
          </ul>
          <div
            class="p-6 flex items-center justify-center w-full text-gray-500"
            v-else
          >
            <p>
              Aún no tienes ningún grupo. Para crear uno, selecciona algún
              producto de la lista.
            </p>
          </div>
        </section>
      </div>
      <ConfirmModal
        v-if="selectedProducts.length"
        :data="selectedProducts"
        @updateGroups="updateGroups"
      />
    </main>
  </div>
</template>
