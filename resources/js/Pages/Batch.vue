<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import BatchCreate from '@/Components/BatchCreate.vue';
import BatchInfo from '@/Components/BatchInfo.vue';
import { onMounted, ref, computed } from 'vue'
import { reactive } from 'vue';
import axios from 'axios';
import BatchTable from '@/Components/BatchTable.vue';
import moment from 'moment'


const batches = ref([])
const endDate = ref('')
const batch = ref({
    cycle: '',
    dateStarted: '',

})
const selectedBatch = ref({})
const hideStartCycle = ref(true)

// console.log(lastItem.expenses)


onMounted(() => {
    batchList()

})

const batchList = () => {
    axios.get('/api/batches')
        .then(response => {
            console.log(response.data)
            batches.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}


const startBatch = () => {
    axios.post(`/api/batches`, {
        cycle: batch.value.cycle,
        dateStarted: batch.value.dateStarted,
        endDate: batch.value.endDate,
        batchNo: batchNo.value
    })
        .then(response => {
            batch.value.batchNo = '',
                batch.value.cycle = '',
                batch.value.dateStarted = '',
                console.log(response.data)
            hideStartCycle.value = false
            batchList()
        })
        .catch(error => {
            console.log(error)
        })
}
const lastItem = computed(() => {
    if (batches.value.length === 0) {
        return {}
    }
    return batches.value[batches.value.length - 1]

})





const total = computed(() => {
    return lastItem.value.expenses.total
})

const endCycle = (update) => {
    axios.put(`/api/batches/${update}`, {
        endDate: endDate.value,
        totalDays: diffInDays.value
    })
        .then(response => {
            console.log(response.data)
            endDate.value = response.data
            endDate.value = ''
            batchList()

        })
        .catch(error => {
            console.log(error)
        })
}




// const startDate = lastItem.value.dateStarted.getTime()
// const dateEnd = lastItem.value.endDate.getTime()

const diffInMs = computed(() => {
    if (endDate.value === '') {
        return ''
    }
    return new Date(endDate.value) - new Date(lastItem.value.dateStarted)
})

const diffInDays = computed(() => {
    return diffInMs.value / (1000 * 60 * 60 * 24)
})

const batchNo = computed(() => {
    return batches.value.length + 1
})


const daysAgo = (7)

// const dateDaysAgo = computed(() => {
//     return moment().subtract(daysAgo.value, 'days').format('MMMM Do YYYY')
// })
const dateDaysAgo = computed(() => {
    return time.format(-20, 'days')
})

const currentDate = new Date()
const createdDate = lastItem.value


// const subtract = computed(() => {
//     console.log(lastItem.value.updated_at)
//     return currentDate.getDate() - createdDate.getDate()
// })

</script>

<template>
    <Head title="Batch/Cycle" />

    {{ moment(lastItem.created_at).startOf().fromNow() }}
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Batch Info</h2>
            <h3>
                <BatchInfo :lastItem="lastItem" :days="diffInDays"></BatchInfo>
                <div v-if="!lastItem.endDate">
                    <form @submit.prevent="endCycle(lastItem.id)">
                        <div style="display: flex;">
                            <p>Input end cycle date: <input type="date" v-model="endDate"></p>
                            <button type="submit">End Cycle</button>
                        </div>
                        <div>
                            <label>Days</label>
                            <input type="text" v-model="diffInDays">
                        </div>

                    </form>
                </div>

            </h3>
        </template>


        <div class="py-12 flex content-center">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-if="lastItem.endDate || !lastItem.cycle">
                            <form @submit.prevent="startBatch()">
                                <table class="table-auto border-2 p-0 text-black text-center border-spacing-y-px"
                                    style="width:1000px">
                                    <thead>
                                        <tr>
                                            <th class="w-96">Batch No.</th>
                                            <th class="w-40">Cycle</th>
                                            <th class="w-40">Date Started</th>
                                            <th class="w-40">End Cycle</th>
                                            <th class="w-40">Info.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-2">
                                            <td><input type="number" disabled v-model="batchNo"></td>
                                            <td><input type="number" v-model="batch.cycle"></td>
                                            <td><input type="date" v-model="batch.dateStarted"></td>
                                            <td><input type="text" v-model="batch.info"></td>
                                            <td><button type="submit">Start Cycle</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        <BatchTable :batches="batches" @getbatch="batchList()"></BatchTable>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
