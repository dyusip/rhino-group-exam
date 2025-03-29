<template>
  <div class="min-h-screen bg-gray-100 flex justify-center p-4">
    <div class="w-full max-w-8xl bg-white shadow-lg rounded-lg p-6">
      
      <!-- Search & Add Button -->
      <div class="flex flex-col md:flex-row justify-between items-center gap-3 mb-4">
        <input 
          type="text" 
          v-model="searchQuery"
          placeholder="Search..." 
          class="lg:w-1/4 md:w-3/4 w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <button 
          @click="showModal = true"
          class="px-4 py-2 w-full md:max-w-fit bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition cursor-pointer">
          Add Favorite
        </button>
      </div>
        <!-- Responsive Table -->
        <div class="overflow-x-auto">
        <!-- Table -->
            <TableContent 
                :favorites="favorites" 
                :tags="tags" 
                :errors="errors.createFavorite"
            />
        </div>
        <!-- Modal -->
        <Modal 
            :showModal="showModal" 
            @close="showModal = false" 
            :tags="tags" 
            :errors="errors.createFavorite" 
            :isCreate="true"
        />
        <!-- Pagination -->
      <div class="flex justify-center mt-4 space-x-2">
        <Pagination class="mt-6" :links="favorites.links" />
      </div>
    </div>
  </div>
</template>

<script setup>
    import Layout from '../Layouts/Layout.vue'
    import Pagination from '@/Components/Pagination.vue'
    import TableContent from '@/Components/TableContent.vue'
    import Modal from '@/Components/Modal.vue'
    import { watch, ref } from 'vue'
    import { router, Link } from '@inertiajs/vue3'

    let delayTimeout;
    const searchQuery = ref('');
    const showModal = ref(false);

    watch(searchQuery, value => {
        clearTimeout(delayTimeout);

        delayTimeout = setTimeout(() => {
            router.get('/', {
            filter: value,
        }, {
            preserveState: true,
            replace: true,
        });
        }, 500); // Adjust the debounce delay (in milliseconds) as needed
    })

    defineOptions({ layout: Layout})

    defineProps({
        favorites: Object,
        tags: Object,
        errors: Object
    })


</script>