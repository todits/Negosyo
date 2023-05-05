<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InventoryCreate from '@/Components/InventoryCreate.vue';
import moment from 'moment';
import { computed, ref } from 'vue'


export default {
    components: { InventoryCreate, AuthenticatedLayout, Head },
    data: function () {
        return {
            name: '',
            quantity: '',
            price: '',
            total: '',
            condition: '',
            inventories: [],
            inventory: {}
        };
    },
    created() {
        this.getInventories();
        console.log("RELOAD");

        axios.get(`/api/inventories`)
            .then(response => {
                console.log(response);
                this.inventories = response.data;
                this.name = '',
                    this.quantity = '',
                    this.price = '',
                    this.total = '',
                    this.condition = ''

            });
    },
    methods: {
        getInventories() {
            console.log("RELOAD")
            axios.get(`/api/inventories`)

                .then(response => {
                    this.name = '',
                        this.quantity = '',
                        this.price = '',
                        this.total = '',
                        this.condition = '',
                        this.inventories = response.data;
                })
                .catch(error => {
                })
                .finally(() => {
                });
        },
        editInventory() {

        }
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Inventory</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto ">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <InventoryCreate @success="getInventories()" :inventory="inventory" :inventories="inventories">
                        </InventoryCreate>

                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>