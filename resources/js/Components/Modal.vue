<template>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg lg:w-1/2 md:w-3/4 w-11/12">
            <h2 class="text-xl font-semibold mb-4">{{ isCreate ? 'Add' : 'Update' }} Favorite</h2>
            
            <label class="block mb-2">Title</label>
            <input v-model="newFavorite.title" type="text" class="w-full p-2 border rounded">
            <div v-if="errors?.title" class="text-xs text-red-500">{{ errors.title }}</div>
            
            <label class="block mb-2 mt-3">Author</label>
            <input v-model="newFavorite.author" type="text" class="w-full p-2 border rounded">
            <div v-if="errors?.author" class="text-xs text-red-500">{{ errors.author }}</div>
            
            <label class="block mb-2 mt-3">Type</label>
            <multiselect class="border rounded" v-model="newFavorite.type" :options="types" :preserve-search="true">
            </multiselect>
            <div v-if="errors?.type" class="text-xs text-red-500">{{ errors.type }}</div>

            <label class="block mb-2 mt-3">Release Date</label>
            <input v-model="newFavorite.release_year" type="text" class="w-full p-2 border rounded">
            <div v-if="errors?.release_year" class="text-xs text-red-500">{{ errors.release_year }}</div>

            
            <label class="block mb-2 mt-3">Tags</label>
            <multiselect 
                class="border rounded" 
                v-model="newFavorite.tags" 
                :options="tagNames" 
                :preserve-search="true" 
                :multiple="true" 
                :close-on-select="false" 
                :clear-on-select="false"
            >
                <template #selection="{ values, search, isOpen }">
                    <span class="multiselect__single"
                        v-if="values.length"
                        v-show="!isOpen">{{ values.length }} options selected</span>
                </template>
            </multiselect>
            <div v-if="errors?.release_date" class="text-xs text-red-500">{{ errors.release_date }}</div>
            
            <div class="flex justify-end space-x-2 mt-4">
            <button 
                @click="emit('close')" 
                class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-pointer"
            >
                Cancel
            </button>
            <button 
                @click="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer"
             >
                {{ isCreate ? 'Save' : 'Update' }}
            </button>
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script setup>
    import { ref, reactive , watch} from 'vue'
    import Multiselect from 'vue-multiselect'
    import { usePrefetch, router } from '@inertiajs/vue3'
    
    const props = defineProps({
        showModal: Boolean,
        tags: Array,
        errors: Object,
        favorite: Object,
        isCreate: Boolean
    })

    const emit = defineEmits(["close"]);
    const tagNames = ref([])
    const types = [
        'movie', 'book'
    ]
    
    const newFavorite = reactive ({
        title: '',
        author: '',
        type: '',
        release_year: '',
        tags: []
    });

    tagNames.value = props.tags.map(item => item.name)

    const submit = () => {
        if(props.isCreate)
        {
            router.post('/', newFavorite, {
                errorBag: 'createFavorite',
                onSuccess: emit('close')
            })
        } else {
            router.put(`/${newFavorite.id}`, newFavorite, {
                errorBag: 'createFavorite',
                onSuccess: emit('close')
            })
        }
       
        
    }

    watch(() => props.favorite, (value, _)=> {
        const tags = value.tags.map(item => item?.name)
        Object.assign(newFavorite, {...value, tags})
    }, {deep:true});
</script>