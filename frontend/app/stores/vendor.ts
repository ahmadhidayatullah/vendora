import { defineStore } from 'pinia'

export const useVendorStore = defineStore('vendor', () => {
  const vendor = ref(null)
  const products = ref([])
  const { $api } = useApi()

  async function fetchVendor() {
    // In a real app, this might fetch the current user's vendor details
    // For now, it's a placeholder for vendor-specific state
  }

  return {
    vendor,
    products,
    fetchVendor,
  }
})
