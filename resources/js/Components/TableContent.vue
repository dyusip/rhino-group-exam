<template>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-gray-600 cursor-pointer">
                    ID 
                </th>
                <th class="px-4 py-2 text-left text-gray-600 cursor-pointer">
                    Title 
                </th>
                <th class="px-4 py-2 text-left text-gray-600 cursor-pointer">
                    Author 
                </th>
                <th class="px-4 py-2 text-left text-gray-600 cursor-pointer">
                    Type
                </th>
                <th class="px-4 py-2 text-left text-gray-600">Tags</th>
                <th class="px-4 py-2 text-left text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="favorite in favorites.data" :key="favorite.id" class="border-b hover:bg-gray-50 transition">
                <td class="px-4 py-2">{{ favorite.id }}</td>
                <td class="px-4 py-2">{{ favorite.title }}</td>
                <td class="px-4 py-2">{{ favorite.author }}</td>
                <td class="px-4 py-2">{{ favorite.type }}</td>
                <td class="px-4 py-2">
                    <span v-for="(tag, index) in favorite.tags" 
                    :key="index"
                    class="inline-block bg-blue-100 text-blue-600 text-xs font-semibold px-2 py-1 rounded-lg mr-1">
                    {{ tag.name }}
                    </span>
                </td>
                <td class="px-4 py-2 flex space-x-2">
                    <button 
                        @click="editItem(favorite)" 
                        class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition cursor-pointer">
                        Edit
                    </button>
                    <button 
                        @click="deleteItem(favorite.id)" 
                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition cursor-pointer">
                        Delete
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <Modal 
        :showModal="showModal" 
        @close="showModal = false" 
        :tags="tags" 
        :errors="errors?.createFavorite" 
        :favorite="favoriteVariable" 
        :isCreate="false"
    />
</template>

<script setup>
    import { defineComponent, ref } from "vue";
    import { router } from '@inertiajs/vue3'
    import Modal from '@/Components/Modal.vue'
    defineProps({
        favorites: Object,
        tags: Array,
        errors: Array
    })

    const showModal = ref(false);
    const favoriteVariable = ref({})

    const deleteItem = (id) => {
        router.delete( `/${id}`, {
            onBefore: () => confirm('Are you sure you want to delete this record?'),
        });
    }

    const editItem = (favorite) => {
        favoriteVariable.value = favorite
        showModal.value = true; 
    }
</script>