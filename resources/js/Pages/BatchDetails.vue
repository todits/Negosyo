<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue';

const props = defineProps({
    batch: {
        type: Object,
        required: true
    }
})

const currentBatch = ref({})

const getCurrentBatch = () => {
    axios.get(`/api/batches/${props.batch.id}`)
        .then(response => {
            currentBatch.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}
onMounted(() => {
    getCurrentBatch()
})



// const batchId = parseInt(route.params.id)
// console.log(batchId)
console.log(currentBatch)


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Batch Details</h2>
            <div class="label">
                <div class="border">
                    <p style="padding-right: 10px; font-weight: 600;">Current Batch: </p>
                    <p>{{ props.batch.batchNo }}</p>
                </div>
                <div class="border">
                    <p style="padding-right: 10px; font-weight: 600;">Current Cycle: </p>
                    <p>{{ props.batch.cycle }}</p>
                </div>
                <div class="border">
                    <p style="padding-right: 10px; font-weight: 600;">Date Started: </p>
                    <p>{{ props.batch.dateStarted }}</p>
                </div>
                <div class="border">
                    <p style="padding-right: 10px; font-weight: 600;">End Date: </p>
                    <p>{{ props.batch.endDate }}</p>
                </div>
            </div>
        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="table-auto border-2 p-0 text-black text-center border-spacing-y-px" style="width:1000px">
                        <thead>
                            <tr>
                                <th class="w-96">Item</th>
                                <th class="w-40">Quantity</th>
                                <th class="w-40">Price</th>
                                <th class="w-40">Total</th>
                                <th class="w-40">Date Purchase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-2" v-for="expense in currentBatch.expenses">
                                <td>{{ expense.item }}</td>
                                <td>{{ expense.quantity }}</td>
                                <td>{{ expense.price }}</td>
                                <td>{{ expense.total }}</td>
                                <td>{{ expense.datepurchase }}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.label {
    display: flex;
    gap: 50px;

    padding: 10px;

}

.border {
    background: #d9d9f5;
    padding-left: 20px;
    border-radius: 6px;
    display: flex;
    width: 400px;
    font-size: 18px;
    height: 51px;
    place-items: center;
}

.table {
    display: flex;
    gap: 10px;
}
</style>