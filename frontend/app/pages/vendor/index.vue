<template>
  <NuxtLayout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Vendor Dashboard</h1>
        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Stats Card -->
          <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
              <dt class="text-sm font-medium text-gray-500 truncate">Total Products</dt>
              <dd class="mt-1 text-3xl font-semibold text-gray-900">0</dd>
            </div>
          </div>
          <!-- Stats Card -->
          <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
              <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
              <dd class="mt-1 text-3xl font-semibold text-gray-900">0</dd>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>

<script setup>
definePageMeta({
  middleware: ['auth', 'vendor']
})
</script>
