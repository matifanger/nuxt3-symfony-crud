import { Group, Product } from "~/global";

export const removeGroup = async (id: number) => {
  const BACK_URL = useRuntimeConfig().public.BACKEND_URL;

  return await $fetch(`${BACK_URL}/groups/${id}`, {
    method: "DELETE",
  });
};

export const editNameGroup = async (id: number, name: string) => {
  const BACK_URL = useRuntimeConfig().public.BACKEND_URL;

  return await $fetch(`${BACK_URL}/groups/${id}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      name,
    }),
  });
};

export const updateProductGroup = async (id: number, products: Product[]) => {
  const BACK_URL = useRuntimeConfig().public.BACKEND_URL;

  return await $fetch(`${BACK_URL}/groups/${id}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      products,
    }),
  });
};
