<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <nav class="bg-white border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <NuxtLink to="/" class="text-2xl font-bold text-indigo-600">Vendora</NuxtLink>
            </div>
            <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
              <NuxtLink to="/" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Home
              </NuxtLink>
              <NuxtLink v-if="auth.isVendor" to="/vendor" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Vendor Panel
              </NuxtLink>
            </div>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
            <template v-if="auth.isAuthenticated">
              <span class="text-sm text-gray-700">Hello, {{ auth.user?.name }}</span>
              <button @click="auth.logout" class="bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                Logout
              </button>
            </template>
            <template v-else>
              <NuxtLink to="/login" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Login</NuxtLink>
              <NuxtLink to="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                Register
              </NuxtLink>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <main class="flex-grow">
      <slot />
    </main>

    <footer class="bg-white border-t border-gray-200 py-8">
      <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
        &copy; {{ new Date().getFullYear() }} Vendora. All rights reserved.
      </div>
    </footer>
  </div>
</template>

<script setup>
const auth = useAuthStore()
</script>
