<script setup>
import { onMounted, ref, computed } from 'vue'
import { reactive } from 'vue';
import axios from 'axios';
import BatchInfo from './BatchInfo.vue'
import BatchTable from './BatchTable.vue';


const batches = ref([])
const endDate = ref('')
const batch = ref({
    cycle: '',
    dateStarted: '',
    endDate: ''

})
const selectedBatch = ref({})



// console.log(lastItem)


onMounted(() => {
    batchList()


})

// const total = computed(() => {

//     return batch.value.batchNo + batch.value.cycle
// })



// const lastItem = computed(() => {
//     return batches.value[batches.value.length - 1]
// })



// const lastItem = batches.id.value[batches.id.value - 1]



// console.log(lastItem)

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
                batch.value.endDate = '',
                console.log(response.data)
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

const batchNo = computed(() => {
    return batches.value.length + 1
})


const total = computed(() => {
    return batch.value.batchNo + batch.value.cycle
})

const endCycle = (update) => {
    axios.put(`/api/batches/${update}`, { endDate: endDate.value })
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
</script>



<template>
    <div>
        <p>Current Batch: {{ lastItem.id }} </p>
        <p>Current Cycle: {{ lastItem.cycle }} </p>
        <p>Date Started: {{ lastItem.dateStarted }}</p>
    </div>
    <form @submit.prevent="endCycle(lastItem.id)">
        <div>

            <p>End Cycle: <input type="date" v-model="endDate"></p>
            <button type="submit">end</button>
        </div>
    </form>


    <form @submit.prevent="startBatch">
        <table class="table-auto border-2 p-0 text-black text-center border-spacing-y-px" style="width:1000px">
            <thead>
                <tr>
                    <th class="w-96">Batch No.</th>
                    <th class="w-40">Cycle</th>
                    <th class="w-40">Date Started</th>
                    <th class="w-40">End Date</th>
                    <th class="w-40">Info.</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-2">
                    <td><input type="number" disabled v-model="batchNo"></td>
                    <td><input type="number" v-model="batch.cycle"></td>
                    <td><input type="date" v-model="batch.dateStarted"></td>
                    <td><input type="date" v-model="batch.endDate"></td>
                    <td><button type="submit">Start Sycle</button></td>
                </tr>
            </tbody>
        </table>
    </form>
    <BatchTable :batches="batches" @getbatch="batchList()"></BatchTable>

    {{ lastItem }}
</template>